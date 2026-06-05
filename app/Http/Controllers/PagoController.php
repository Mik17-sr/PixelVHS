<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagoController extends Controller
{
    public function abrirPSE(Request $request)
    {
        $request->validate([
            'id_prestamo' => 'required|integer|exists:prestamo,id_prestamo',
            'monto'       => 'required|numeric|min:0.01',
            'referencia'  => 'nullable|string',
        ]);

        $prestamo = Prestamo::findOrFail($request->id_prestamo);

        // Verificar que el socio sea el dueño del préstamo
        if ($prestamo->id_socio !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        // Generar referencia PSE simulada
        $referencia = $request->referencia ?? 'PSE-' . strtoupper(Str::random(12));

        return response()->json([
            'referencia'   => $referencia,
            'monto'        => $monto = (float) $request->monto,
            'cuenta'       => 'CUENTA SIMULADA',
            'banco'        => 'BANCO VIRTUAL',
            'banco_logo'   => 'https://via.placeholder.com/60',
            'mensaje'      => 'Pago simulado. Haz clic en "Confirmar Pago" para completar.',
        ]);
    }

   public function confirmarPSE(Request $request)
    {
        $request->validate([
            'id_prestamo' => 'required|integer|exists:prestamo,id_prestamo',
            'referencia'  => 'required|string',
            'monto'       => 'required|numeric|min:0.01',
        ]);

        $prestamo = Prestamo::with('cintas')->findOrFail($request->id_prestamo);

        if ($prestamo->id_socio !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        if ($prestamo->estado !== 'Pendiente') {
            return response()->json(['error' => 'Este préstamo no está pendiente de pago.'], 422);
        }

        try {
            DB::transaction(function () use ($prestamo, $request) {
                $pago = Pago::create([
                    'tipo'        => 'Prestamo',
                    'monto'       => $request->monto,
                    'fecha_pago'  => now(),
                    'metodo_pago' => 'Transferencia',
                ]);

                $prestamo->pagos()->attach($pago->id_pago);

                $observaciones = ($prestamo->observaciones ? $prestamo->observaciones . ' | ' : '')
                    . "Pago PSE confirmado: {$request->referencia}";

                $prestamo->update([
                    'estado'        => 'Activo',
                    'observaciones' => $observaciones,
                ]);

                // ← Correcto: actualizar cada cinta individualmente
                foreach ($prestamo->cintas as $cinta) {
                    $cinta->update(['estado' => 'Prestada']);
                }
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar el pago: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'success'     => true,
            'mensaje'     => 'Pago confirmado exitosamente. Tu renta está activa.',
            'id_prestamo' => $prestamo->id_prestamo,
            'estado'      => 'Activo',
            'referencia'  => $request->referencia,
        ]);
    }
}
