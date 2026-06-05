<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Cinta;
use App\Models\Socio;
use App\Models\Pelicula;
use App\Models\Multa;
use App\Models\Pago;
use App\Models\TipoMulta;
use App\Models\ListaEspera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

class PrestamoController extends Controller
{
    public function datosSocio()
    {
        $socio = Socio::where('id_socio', auth()->id())->firstOrFail();
        
        $rentasActivas = Prestamo::where('id_socio', $socio->id_socio)
            ->where('estado', 'Activo')
            ->withCount('cintas')
            ->get()
            ->sum('cintas_count');
        
        return response()->json([
            'id_socio' => $socio->id_socio,
            'nombre' => $socio->usuario->nombre ?? 'Usuario',
            'max_peliculas_simultaneas' => $socio->max_peliculas_simultaneas,
            'rentas_activas' => $rentasActivas,
            'disponibles' => $socio->max_peliculas_simultaneas - $rentasActivas,
        ]);
    }

    public function crear(Request $request)
    {
        $request->validate([
            'cintas'        => 'required|array|min:1',
            'cintas.*'      => 'integer|exists:cinta,id_cinta',
            'dias'          => 'required|integer|min:1|max:14',
            'metodo_pago'   => 'nullable|in:Efectivo,PSE,Tarjeta',
        ]);

        $socio = Socio::where('id_socio', auth()->id())->firstOrFail();

        $metodoPago = $request->metodo_pago ?? 'Efectivo';
        $estado = ($metodoPago === 'PSE') ? 'Pendiente' : 'Activo';

        $rentasActivas = Prestamo::where('id_socio', $socio->id_socio)
            ->whereIn('estado', ['Activo', 'Pendiente'])
            ->withCount('cintas')
            ->get()
            ->sum('cintas_count');

        $solicitadas = count($request->cintas);

        if (($rentasActivas + $solicitadas) > $socio->max_peliculas_simultaneas) {
            return response()->json([
                'message' => "Límite de préstamos simultáneos alcanzado. Tienes {$rentasActivas} activas y tu máximo es {$socio->max_peliculas_simultaneas}."
            ], 422);
        }

        $cintas = Cinta::whereIn('id_cinta', $request->cintas)
            ->where('estado', 'Disponible')
            ->with(['pelicula', 'formato'])
            ->get();

        if ($cintas->count() !== $solicitadas) {
            return response()->json([
                'message' => 'Una o más cintas seleccionadas ya no están disponibles.'
            ], 422);
        }

        $prestamoId = null;

        DB::transaction(function () use (
            $socio,
            $cintas,
            $request,
            $metodoPago,
            $estado,
            &$prestamoId
        ) {

            $cargoDiario = $cintas->sum(function ($cinta) {
                $precio = (float) ($cinta->pelicula?->precio_alquiler ?? 0);
                $multiplicador = (float) ($cinta->formato?->multiplicador ?? 1);
                return $precio * $multiplicador;
            });
            $diasExtra = max(0, $request->dias - 1);
            $cargoTotal = $cargoDiario + ($diasExtra * 5000 * count($cintas));

            $prestamo = Prestamo::create([
                'id_socio'      => $socio->id_socio,
                'fecha_inicio'  => now(),
                'fecha_limite'  => now()->addDays($request->dias),
                'cargo_diario'  => round($cargoTotal, 2),
                'estado'        => $estado,
                'observaciones' => $metodoPago === 'PSE'
                    ? 'Pago pendiente PSE'
                    : null,
            ]);

            $prestamoId = $prestamo->id_prestamo;

            $estadoCinta = ($metodoPago === 'PSE') ? 'Prestada' : 'Prestada';
            foreach ($cintas as $cinta) {
                $cinta->update(['estado' => $estadoCinta]);
            }

            $prestamo->cintas()->attach(
                $cintas->pluck('id_cinta')
            );

            $peliculaIds = $cintas->pluck('id_pelicula')->unique();

            ListaEspera::where('id_socio', $socio->id_socio)
                ->whereIn('id_pelicula', $peliculaIds)
                ->delete();
        });

        $mensaje = $metodoPago === 'PSE'
            ? 'Préstamo creado. Por favor completa el pago PSE para confirmar.'
            : 'Préstamo registrado correctamente.';

        $prestamo = Prestamo::find($prestamoId);

        return response()->json([
            'message'      => $mensaje,
            'id_prestamo'  => $prestamoId,
            'metodo_pago'  => $metodoPago,
            'estado'       => $estado,
            'cargo_diario' => (float) $prestamo->cargo_diario,
            'dias'         => $request->dias,
            'cargo_diario'  => round((float) $prestamo->cargo_diario, 2), 
        ]);
    }

    public function misRentas()
    {
        $socio = Socio::where('id_socio', auth()->id())->firstOrFail();

        $prestamos = Prestamo::where('id_socio', $socio->id_socio)
            ->with(['cintas.pelicula', 'cintas.formato', 'multas.tipoMulta', 'multas.pagos'])
            ->orderByDesc('fecha_inicio')
            ->get()
            ->map(fn($p) => $this->formatPrestamo($p));
        $listaEspera = ListaEspera::where('id_socio', $socio->id_socio)
            ->with(['pelicula', 'formato'])
            ->orderBy('fecha_solicitud')
            ->get()
            ->map(fn($e) => [
                'id_lista_espera' => $e->id_lista_espera,
                'pelicula'        => $e->pelicula->titulo ?? '—',
                'formato'         => $e->formato->nombre ?? 'Cualquier formato',
                'fecha_solicitud' => $e->fecha_solicitud,
                'notificado'      => $e->notificado,
                'posicion'        => ListaEspera::where('id_pelicula', $e->id_pelicula)
                    ->where(fn($q) => $e->id_formato
                        ? $q->where('id_formato', $e->id_formato)
                        : $q->whereNull('id_formato'))
                    ->where('fecha_solicitud', '<=', $e->fecha_solicitud)
                    ->count(),
            ]);

        return response()->json([
            'prestamos'   => $prestamos,
            'lista_espera' => $listaEspera,
        ]);
    }

    public function index(Request $request)
    {
        $query = Prestamo::with([
            'socio.usuario',
            'cintas.pelicula',
            'cintas.formato',
            'multas.tipoMulta',
            'multas.pagos', 
        ])->orderByDesc('fecha_inicio');

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->search) {
            $query->whereHas('socio.usuario', function ($q) use ($request) {
                $q->where('nombre', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $prestamos = $query->paginate(20);

        return response()->json([
            'prestamos' => $prestamos->map(fn($p) => $this->formatPrestamo($p)),
            'total'     => $prestamos->total(),
            'pagina'    => $prestamos->currentPage(),
            'paginas'   => $prestamos->lastPage(),
        ]);
    }

    public function devolver(Request $request, $id)
    {
        $prestamo = Prestamo::with('cintas.pelicula', 'cintas.formato')->findOrFail($id);

        if (strtolower($prestamo->estado) !== 'activo') {
            return response()->json(['message' => 'Este préstamo no está activo.'], 422);
        }

        $hoy         = Carbon::now();
        $diasRetraso = (int) max(0, $hoy->diffInDays(Carbon::parse($prestamo->fecha_limite), false) * -1);
        $totalPrestamo = (float) $prestamo->cargo_diario;

        $multaRetrasoData      = null;
        $multasAdicionalesData = [];

        DB::transaction(function () use (
            $prestamo, $diasRetraso, $totalPrestamo, $hoy, $request,
            &$multaRetrasoData, &$multasAdicionalesData
        ) {
            foreach ($prestamo->cintas as $cinta) {
                $cinta->update(['estado' => 'Disponible']);
                event(new \App\Events\CintaDisponible($cinta));
            }
            $prestamo->update([
                'estado'           => 'Terminado',
                'fecha_devolucion' => $hoy,
            ]);

            if ($diasRetraso > 0) {
                $tipoRetraso  = TipoMulta::find(1);
                $multiplicador = $tipoRetraso ? (float) $tipoRetraso->multiplicador : 1.0;
                $valorRetraso  = round($totalPrestamo * $multiplicador * $diasRetraso, 2);

                Multa::create([
                    'id_prestamo'      => $prestamo->id_prestamo,
                    'id_tipo_multa'    => 1,
                    'valor'            => $valorRetraso,
                    'fecha_generacion' => now(),
                ]);

                $multaRetrasoData = [
                    'dias_retraso'  => $diasRetraso,
                    'multiplicador' => $multiplicador,
                    'valor'         => $valorRetraso,
                ];
            }
            foreach ($request->input('multas_adicionales', []) as $m) {
                $tipo          = TipoMulta::find($m['id_tipo_multa']);
                $multiplicador = $tipo ? (float) $tipo->multiplicador : 1.0;
                $valor = (float) $m['valor'] > 0
                    ? round((float) $m['valor'], 2)
                    : round($totalPrestamo * $multiplicador, 2);

                Multa::create([
                    'id_prestamo'      => $prestamo->id_prestamo,
                    'id_tipo_multa'    => $m['id_tipo_multa'],
                    'valor'            => $valor,
                    'fecha_generacion' => now(),
                ]);

                $multasAdicionalesData[] = [
                    'id_tipo_multa' => $m['id_tipo_multa'],
                    'multiplicador' => $multiplicador,
                    'valor'         => $valor,
                ];
            }
            if ($diasRetraso === 0) {
                $socio = $prestamo->socio;
                $totalCompletados = Prestamo::where('id_socio', $socio->id_socio)
                    ->where('estado', 'Devuelto')
                    ->count();
                if ($totalCompletados % 3 === 0 && $socio->max_peliculas_simultaneas < 10) {
                    $socio->increment('max_peliculas_simultaneas');
                }
            }
        });

        $totalMultas = ($multaRetrasoData['valor'] ?? 0)
        + collect($multasAdicionalesData)->sum('valor');
        if ($totalMultas > 0 && $request->metodo_pago) {
            DB::transaction(function () use ($prestamo, $totalMultas, $request) {
                $pago = Pago::create([
                    'tipo'        => 'multa',
                    'monto'       => round($totalMultas, 2),
                    'fecha_pago'  => now(),
                    'metodo_pago' => $request->metodo_pago,
                ]);

                $multaIds = $prestamo->multas()
                    ->whereDoesntHave('pagos')
                    ->pluck('id_multa');

                $pago->multas()->attach($multaIds);
            });
        }
        $prestamo->load('multas.tipoMulta');
        return response()->json([
            'message'            => 'Préstamo devuelto correctamente.',
            'dias_retraso'       => $diasRetraso,
            'total_prestamo'     => $totalPrestamo,
            'multa_retraso'      => $multaRetrasoData,
            'multas_adicionales' => $multasAdicionalesData,
            'total_multas'       => round($totalMultas, 2),
        ]);
    }

    public function cancelarAdmin($id)
    {
        $prestamo = Prestamo::with('cintas')->findOrFail($id);

        if (!in_array(strtolower($prestamo->estado), ['activo', 'pendiente'])) {
            return response()->json([
                'message' => 'Este préstamo no puede cancelarse.'
            ], 422);
        }

        DB::transaction(function () use ($prestamo) {
            foreach ($prestamo->cintas as $cinta) {
                $cinta->update(['estado' => 'Disponible']);
            }
            $prestamo->update([
                'estado'        => 'Cancelado',
                'observaciones' => trim(
                    ($prestamo->observaciones ?? '') .
                    ' | Cancelado por empleado el ' . now()->format('Y-m-d H:i')
                )
            ]);
        });

        return response()->json(['message' => 'Préstamo cancelado correctamente.']);
    }

    public function cancelar($id)
    {
        $prestamo = Prestamo::with('cintas')->findOrFail($id);
        if (!in_array($prestamo->estado, ['Activo', 'Pendiente'])) {
            return response()->json([
                'message' => 'Este préstamo no puede cancelarse.'
            ], 422);
        }
        DB::transaction(function () use ($prestamo) {
            foreach ($prestamo->cintas as $cinta) {
                $cinta->update([
                    'estado' => 'Disponible'
                ]);
            }
            $prestamo->update([
                'estado' => 'Cancelado',
                'observaciones' => trim(
                    ($prestamo->observaciones ?? '') .
                    ' | Cancelado por el usuario el ' . now()->format('Y-m-d H:i')
                )
            ]);
        });

        return response()->json([
            'message' => 'Préstamo cancelado correctamente.'
        ]);
    }

    public function registrarPago(Request $request, $id)
    {
        $request->validate([
            'monto'        => 'required|numeric|min:0.01',
            'metodo_pago'  => 'required|string',
            'tipo'         => 'required|in:prestamo,multa',
            'id_multa'     => 'nullable|integer|exists:multa,id_multa',
        ]);

        $prestamo = Prestamo::findOrFail($id);

        $pago = Pago::create([
            'tipo'        => $request->tipo,
            'monto'       => $request->monto,
            'fecha_pago'  => now(),
            'metodo_pago' => $request->metodo_pago,
        ]);

        if ($request->tipo === 'multa' && $request->id_multa) {
            $pago->multas()->attach($request->id_multa);
        } else {
            $pago->prestamos()->attach($prestamo->id_prestamo);
        }

        return response()->json(['message' => 'Pago registrado.', 'pago' => $pago]);
    }

    private function formatPrestamo(Prestamo $p): array
{
    $hoy         = Carbon::now();
    $fechaLimite = Carbon::parse($p->fecha_limite);
    $fechaInicio = Carbon::parse($p->fecha_inicio); 
    $diasRestantes = strtolower($p->estado) === 'activo'
        ? (int) $hoy->diffInDays($fechaLimite, false)
        : null;
    $diasTotales = (int) $fechaInicio->diffInDays($fechaLimite);
        return [
            'id_prestamo'      => $p->id_prestamo,
            'estado'           => $p->estado,
            'fecha_inicio'     => $p->fecha_inicio,
            'fecha_limite'     => $p->fecha_limite,
            'fecha_devolucion' => $p->fecha_devolucion,
            'dias_restantes'   => $diasRestantes,
            'dias_totales'     => $diasTotales,
            'cargo_diario'     => (float) $p->cargo_diario,  
            'monto_total'      => (float) $p->cargo_diario,   
            'vencido'          => $diasRestantes !== null && $diasRestantes < 0,
            'socio'            => $p->socio ? [
                'id'     => $p->socio->id_socio,
                'nombre' => $p->socio->usuario->nombre ?? '—',
                'email'  => $p->socio->usuario->email  ?? '—',
            ] : null,
            'cintas' => $p->cintas->map(fn($c) => [
                'id_cinta'  => $c->id_cinta,
                'pelicula'  => $c->pelicula->titulo ?? '—',
                'formato'   => $c->formato->nombre  ?? '—',
                'precio'    => $c->pelicula->precio_alquiler ?? 0,
            ])->toArray(),
            'multas' => $p->multas->map(fn($m) => [
                'id_multa'  => $m->id_multa,
                'concepto'  => $m->tipoMulta->concepto ?? '—',
                'valor'     => $m->valor,
                'pagada'    => $m->pagos->isNotEmpty(),
            ])->toArray(),
            'observaciones' => $p->observaciones,
        ];
    }
}