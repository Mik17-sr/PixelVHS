<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ListaEspera;
use App\Models\Cinta;
use App\Events\CintaDisponible;

class LimpiarEsperasExpiradas extends Command
{
    protected $signature   = 'espera:limpiar';
    protected $description = 'Expira notificaciones de lista de espera sin reclamar después de 24h';

    public function handle(): void
    {
        ListaEspera::where('notificado', true)
            ->where('updated_at', '<', now()->subHours(24))
            ->each(function ($entrada) {
                $this->info("Expirando espera ID {$entrada->id_lista_espera}");
                $entrada->delete();

                $cinta = Cinta::where('id_pelicula', $entrada->id_pelicula)
                    ->where('id_formato', $entrada->id_formato)
                    ->where('estado', 'disponible')
                    ->first();

                if ($cinta) event(new CintaDisponible($cinta));
            });

        $this->info('Limpieza completada.');
    }
}