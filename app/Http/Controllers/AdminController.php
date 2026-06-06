<?php

namespace App\Http\Controllers;

use App\Models\Multa;
use App\Models\Pago;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController
{
    public function prestamosIndex(Request $request)
    {
        $prestamos = Prestamo::with(['socio.usuario'])
            ->withCount('cintas')
            ->orderByDesc('fecha_inicio')
            ->get()
            ->map(fn($p) => [
                'id_prestamo'      => $p->id_prestamo,
                'socio_nombre'     => $p->socio?->usuario?->nombre ?? '—',
                'socio_email'      => $p->socio?->usuario?->email  ?? '—',
                'cintas_count'     => $p->cintas_count ?? 0,
                'fecha_inicio'     => $p->fecha_inicio,
                'fecha_limite'     => $p->fecha_limite,
                'fecha_devolucion' => $p->fecha_devolucion,
                'estado'           => $p->estado,
                'cargo_diario'     => $p->cargo_diario,
                'observaciones'    => $p->observaciones,
            ]);
    
        return response()->json(['prestamos' => $prestamos]);
    }

    public function prestamosShow(int $id)
    {
        $p = Prestamo::with([
            'socio.usuario',
            'cintas.pelicula',
            'cintas.formato',
            'multas.tipoMulta',
        ])->findOrFail($id);
    
        $data = [
            'id_prestamo'      => $p->id_prestamo,
            'socio_nombre'     => $p->socio?->usuario?->nombre ?? '—',
            'socio_email'      => $p->socio?->usuario?->email  ?? '—',
            'fecha_inicio'     => $p->fecha_inicio,
            'fecha_limite'     => $p->fecha_limite,
            'fecha_devolucion' => $p->fecha_devolucion,
            'estado'           => $p->estado,
            'cargo_diario'     => $p->cargo_diario,
            'observaciones'    => $p->observaciones,
            'cintas'           => $p->cintas->map(fn($c) => [
                'id_cinta' => $c->id_cinta,
                'pelicula' => $c->pelicula?->titulo ?? '—',
                'formato'  => $c->formato?->nombre  ?? '—',
            ]),
            'multas'           => $p->multas->map(fn($m) => [
                'id_multa' => $m->id_multa,
                'concepto' => $m->tipoMulta?->concepto ?? '—',
                'valor'    => $m->valor,
            ]),
        ];
    
        return response()->json(['prestamo' => $data]);
    }

    public function reportesIndex()
{
    $desde = request('desde');
    $hasta = request('hasta');

    $totalPrestamos   = Prestamo::count();
    $prestamosActivos = Prestamo::where('estado', 'Activo')->count();
    $totalIngresos    = (float) Pago::where('tipo', 'Prestamo')->sum('monto');
    $totalMultas      = (float) Multa::sum('valor');

    $estados = Prestamo::select('estado', DB::raw('count(*) as total'))
        ->groupBy('estado')
        ->pluck('total', 'estado');

    $topPeliculas = DB::table('cinta_prestamo as cp')
        ->join('prestamo as pr', 'pr.id_prestamo', '=', 'cp.id_prestamo')
        ->join('cinta as c',    'c.id_cinta',      '=', 'cp.id_cinta')
        ->join('pelicula as p', 'p.id_pelicula',   '=', 'c.id_pelicula')
        ->when($desde, fn($q) => $q->where('pr.fecha_inicio', '>=', $desde))
        ->when($hasta,  fn($q) => $q->where('pr.fecha_inicio', '<=', $hasta . ' 23:59:59'))
        ->select('p.titulo', DB::raw('count(*) as total'))
        ->groupBy('p.id_pelicula', 'p.titulo')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    $topGeneros = DB::table('cinta_prestamo as cp')
        ->join('prestamo as pr', 'pr.id_prestamo', '=', 'cp.id_prestamo')
        ->join('cinta as c',    'c.id_cinta',      '=', 'cp.id_cinta')
        ->join('pelicula as p', 'p.id_pelicula',   '=', 'c.id_pelicula')
        ->join('genero as g',   'g.id_genero',     '=', 'p.id_genero')
        ->when($desde, fn($q) => $q->where('pr.fecha_inicio', '>=', $desde))
        ->when($hasta,  fn($q) => $q->where('pr.fecha_inicio', '<=', $hasta . ' 23:59:59'))
        ->select('g.nombre', DB::raw('count(*) as total'))
        ->groupBy('g.id_genero', 'g.nombre')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    $topSocios = DB::table('prestamo as pr')
        ->join('socio as s',     's.id_socio',    '=', 'pr.id_socio')
        ->join('usuario as u',   'u.id_usuario',  '=', 's.id_socio')
        ->leftJoin('multa as m', 'm.id_prestamo', '=', 'pr.id_prestamo')
        ->when($desde, fn($q) => $q->where('pr.fecha_inicio', '>=', $desde))
        ->when($hasta,  fn($q) => $q->where('pr.fecha_inicio', '<=', $hasta . ' 23:59:59'))
        ->select(
            'u.nombre',
            DB::raw('count(distinct pr.id_prestamo) as total_prestamos'),
            DB::raw('count(m.id_multa) as total_multas')
        )
        ->groupBy('s.id_socio', 'u.nombre')
        ->orderByDesc('total_prestamos')
        ->limit(10)
        ->get();

    $multas = Multa::with('tipoMulta')
        ->when($desde, fn($q) => $q->where('fecha_generacion', '>=', $desde))
        ->when($hasta,  fn($q) => $q->where('fecha_generacion', '<=', $hasta . ' 23:59:59'))
        ->orderByDesc('fecha_generacion')
        ->limit(20)
        ->get()
        ->map(fn($m) => [
            'id_multa'         => $m->id_multa,
            'id_prestamo'      => $m->id_prestamo,
            'concepto'         => $m->tipoMulta?->concepto,
            'valor'            => $m->valor,
            'fecha_generacion' => $m->fecha_generacion,
        ]);

    $topActores = collect();
    try {
        $topActores = DB::table('gusta_actor as ga')
            ->join('actor as a', 'a.id_actor', '=', 'ga.id_actor')
            ->select('a.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('a.id_actor', 'a.nombre')
            ->orderByDesc('total')
            ->limit(8)
            ->get();
    } catch (\Exception $e) {
        \Log::warning('top_actores error: ' . $e->getMessage());
    }

    $topDirectores = collect();
    try {
        $topDirectores = DB::table('gusta_director as gd')
            ->join('director as d', 'd.id_director', '=', 'gd.id_director')
            ->select('d.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('d.id_director', 'd.nombre')
            ->orderByDesc('total')
            ->limit(8)
            ->get();
    } catch (\Exception $e) {
        \Log::warning('top_directores error: ' . $e->getMessage());
    }

    $pagosMulta = DB::table('pago_multa')->select('id_multa')->get();

    $pagos = Pago::when($desde, fn($q) => $q->where('fecha_pago', '>=', $desde))
                 ->when($hasta,  fn($q) => $q->where('fecha_pago', '<=', $hasta . ' 23:59:59'))
                 ->orderByDesc('fecha_pago')
                 ->limit(20)
                 ->get(['id_pago', 'tipo', 'monto', 'metodo_pago', 'fecha_pago']);

    return response()->json([
        'total_prestamos'   => $totalPrestamos,
        'prestamos_activos' => $prestamosActivos,
        'total_ingresos'    => $totalIngresos,
        'total_multas'      => $totalMultas,
        'estados'           => $estados,
        'top_peliculas'     => $topPeliculas,
        'top_generos'       => $topGeneros,
        'top_socios'        => $topSocios,
        'multas'            => $multas,
        'pagos_multa'       => $pagosMulta,
        'pagos'             => $pagos,
        'top_actores'       => $topActores,
        'top_directores'    => $topDirectores,
    ]);
}

    public function peliculasIndex()
    {
        $peliculas = DB::table('pelicula as p')
            ->leftJoin('genero as g',   'g.id_genero',   '=', 'p.id_genero')
            ->leftJoin('director as d', 'd.id_director', '=', 'p.id_director')
            ->select(
                'p.id_pelicula',
                'p.titulo',
                'p.anio_lanzamiento as anio',
                'p.resumen as sinopsis',
                'p.foto_portada',    
                'p.duracion_minutos as duracion',
                'g.nombre as genero',
                'd.nombre as director'
            )
            ->orderBy('p.titulo')
            ->get();

        return response()->json(['peliculas' => $peliculas]);
    }
}