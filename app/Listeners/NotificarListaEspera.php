<?php

namespace App\Listeners;

use App\Events\CintaDisponible;
use App\Models\ListaEspera;
use App\Models\Prestamo;
use App\Notifications\CintaDisponibleNotification;
use Illuminate\Support\Facades\DB;

class NotificarListaEspera
{
    public function handle(CintaDisponible $event): void
    {
        $cinta = $event->cinta->load(['pelicula', 'formato']);

        $espera = ListaEspera::where('id_pelicula', $cinta->id_pelicula)
            ->where(function ($q) use ($cinta) {
                $q->whereNull('id_formato')
                  ->orWhere('id_formato', $cinta->id_formato);
            })
            ->where('notificado', false)
            ->orderBy('fecha_solicitud')
            ->with('socio.usuario')
            ->first();

        if (!$espera) {
            return;
        }

        DB::transaction(function () use ($espera, $cinta) {
            $espera->update(['notificado' => true]);

            $prestamo = Prestamo::create([
                'id_socio'      => $espera->id_socio,
                'fecha_inicio'  => now(),
                'fecha_limite'  => now()->addDays(3),
                'cargo_diario'  => (float) ($cinta->pelicula?->precio_alquiler ?? 0)
                                 * (float) ($cinta->formato?->multiplicador ?? 1),
                'estado'        => 'Pendiente',
                'observaciones' => 'Reserva automática desde lista de espera. Confirmar antes de '
                                 . now()->addDays(3)->format('d/m/Y H:i'),
            ]);

            $cinta->update(['estado' => 'Prestada']);
            $prestamo->cintas()->attach($cinta->id_cinta);

            $espera->delete();
        });
        $usuario = $espera->socio?->usuario;
        if ($usuario) {
            $usuario->notify(
                new CintaDisponibleNotification($cinta->pelicula, $cinta->formato)
            );
        }
    }
}