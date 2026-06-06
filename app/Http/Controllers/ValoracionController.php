<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use App\Models\Pelicula;
use App\Models\Socio;
use App\Models\GustaActor;
use App\Models\GustaDirector;
use App\Models\GustaGenero;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ValoracionController extends Controller
{
    const UMBRAL_POSITIVO = 3;
    const MIN_POSITIVAS = 2;

    public function guardar(Request $request)
    {
        $request->validate([
            'id_pelicula' => 'required|integer|exists:pelicula,id_pelicula',
            'puntuacion'  => 'required|integer|min:1|max:5',
            'comentario'  => 'nullable|string|max:500',
        ]);

        $socio = Socio::where('id_socio', auth()->id())->firstOrFail();
        $rentado = DB::table('prestamo')
            ->join('cinta_prestamo', 'prestamo.id_prestamo', '=', 'cinta_prestamo.id_prestamo')
            ->join('cinta', 'cinta.id_cinta', '=', 'cinta_prestamo.id_cinta')
            ->where('prestamo.id_socio', $socio->id_socio)
            ->where('cinta.id_pelicula', $request->id_pelicula)
            ->where('prestamo.estado', 'Terminado')
            ->exists();

        if (!$rentado) {
            return response()->json([
                'message' => 'Solo puedes valorar películas que hayas rentado y devuelto.'
            ], 403);
        }

        DB::transaction(function () use ($request, $socio) {
            $valoracion = Valoracion::updateOrCreate(
                ['id_socio' => $socio->id_socio, 'id_pelicula' => $request->id_pelicula],
                [
                    'puntuacion' => $request->puntuacion,
                    'comentario' => $request->comentario,
                    'fecha'      => now(),
                ]
            );

            $this->actualizarGustos($socio->id_socio, $request->id_pelicula, $request->puntuacion);
        });

        return response()->json(['message' => 'Valoración guardada.']);
    }

    public function miValoracion($idPelicula)
    {
        $socio = Socio::where('id_socio', auth()->id())->firstOrFail();

        $val = Valoracion::where('id_socio', $socio->id_socio)
            ->where('id_pelicula', $idPelicula)
            ->first();

        return response()->json([
            'valoracion' => $val ? [
                'puntuacion' => $val->puntuacion,
                'comentario' => $val->comentario,
                'fecha'      => $val->fecha,
            ] : null,
        ]);
    }

    public function porPelicula($idPelicula)
    {
        $valoraciones = Valoracion::where('id_pelicula', $idPelicula)
            ->with('socio.usuario')
            ->orderByDesc('fecha')
            ->get()
            ->map(fn($v) => [
                'nombre'     => $v->socio->usuario->nombre ?? '—',
                'puntuacion' => $v->puntuacion,
                'comentario' => $v->comentario,
                'fecha'      => $v->fecha,
            ]);

        $promedio = $valoraciones->avg('puntuacion');

        return response()->json([
            'valoraciones' => $valoraciones,
            'promedio'     => $promedio ? round($promedio, 1) : null,
            'total'        => $valoraciones->count(),
        ]);
    }

    private function actualizarGustos(int $idSocio, int $idPelicula, int $puntuacion): void
    {
        $pelicula = Pelicula::find($idPelicula);
        if (!$pelicula) return;

        $esPositiva = $puntuacion >= self::UMBRAL_POSITIVO;
        if ($pelicula->id_genero) {
            $this->evaluarGusto(
                tabla:     'gusta_genero',
                columna:   'id_genero',
                idSocio:   $idSocio,
                idEntidad: $pelicula->id_genero,
                esPositiva: $esPositiva,
                contarPositivasDe: fn() => Valoracion::where('id_socio', $idSocio)
                    ->join('pelicula', 'pelicula.id_pelicula', '=', 'valoracion.id_pelicula')
                    ->where('pelicula.id_genero', $pelicula->id_genero)
                    ->where('valoracion.puntuacion', '>=', self::UMBRAL_POSITIVO)
                    ->count(),
            );
        }

        if ($pelicula->id_director) {
            $this->evaluarGusto(
                tabla:     'gusta_director',
                columna:   'id_director',
                idSocio:   $idSocio,
                idEntidad: $pelicula->id_director,
                esPositiva: $esPositiva,
                contarPositivasDe: fn() => Valoracion::where('id_socio', $idSocio)
                    ->join('pelicula', 'pelicula.id_pelicula', '=', 'valoracion.id_pelicula')
                    ->where('pelicula.id_director', $pelicula->id_director)
                    ->where('valoracion.puntuacion', '>=', self::UMBRAL_POSITIVO)
                    ->count(),
            );
        }

        $actoresIds = DB::table('reparto')
            ->where('id_pelicula', $idPelicula)
            ->pluck('id_actor');

        foreach ($actoresIds as $idActor) {
            $this->evaluarGusto(
                tabla:     'gusta_actor',
                columna:   'id_actor',
                idSocio:   $idSocio,
                idEntidad: $idActor,
                esPositiva: $esPositiva,
                contarPositivasDe: fn() => Valoracion::where('id_socio', $idSocio)
                    ->join('reparto', 'reparto.id_pelicula', '=', 'valoracion.id_pelicula')
                    ->where('reparto.id_actor', $idActor)
                    ->where('valoracion.puntuacion', '>=', self::UMBRAL_POSITIVO)
                    ->count(),
            );
        }
    }

    private function evaluarGusto(
        string $tabla,
        string $columna,
        int $idSocio,
        int $idEntidad,
        bool $esPositiva,
        callable $contarPositivasDe
    ): void {
        $yaGusta = DB::table($tabla)
            ->where('id_socio', $idSocio)
            ->where($columna, $idEntidad)
            ->exists();

        if ($esPositiva && !$yaGusta) {
            $positivas = $contarPositivasDe();
            if ($positivas >= self::MIN_POSITIVAS) {
                DB::table($tabla)->insertOrIgnore([
                    'id_socio' => $idSocio,
                    $columna   => $idEntidad,
                ]);
            }
        }

        if (!$esPositiva && $yaGusta) {
            $positivas = $contarPositivasDe();
            if ($positivas < self::MIN_POSITIVAS) {
                DB::table($tabla)
                    ->where('id_socio', $idSocio)
                    ->where($columna, $idEntidad)
                    ->delete();
            }
        }
    }

    public function recomendaciones()
    {
        $socio = Socio::where('id_socio', auth()->id())->firstOrFail();

        $generosGustados  = DB::table('gusta_genero')->where('id_socio', $socio->id_socio)->pluck('id_genero');
        $directoresGustados = DB::table('gusta_director')->where('id_socio', $socio->id_socio)->pluck('id_director');
        $actoresGustados  = DB::table('gusta_actor')->where('id_socio', $socio->id_socio)->pluck('id_actor');
        $vistas = DB::table('valoracion')->where('id_socio', $socio->id_socio)->pluck('id_pelicula');

        $peliculas = Pelicula::with(['genero', 'director', 'cintas.formato'])
            ->where(function ($q) use ($generosGustados, $directoresGustados, $actoresGustados) {
                if ($generosGustados->isNotEmpty()) {
                    $q->orWhereIn('id_genero', $generosGustados);
                }
                if ($directoresGustados->isNotEmpty()) {
                    $q->orWhereIn('id_director', $directoresGustados);
                }
                if ($actoresGustados->isNotEmpty()) {
                    $q->orWhereHas('actores', fn($q2) => $q2->whereIn('actor.id_actor', $actoresGustados));
                }
            })
            ->whereNotIn('id_pelicula', $vistas)
            ->inRandomOrder()
            ->limit(12)
            ->get()
            ->map(fn($p) => [
                'id_pelicula'      => $p->id_pelicula,
                'titulo'           => $p->titulo,
                'anio_lanzamiento' => $p->anio_lanzamiento,
                'foto_portada'     => $p->foto_portada ? asset('storage/' . $p->foto_portada) : null,
                'genero'           => ['nombre' => $p->genero?->nombre],
                'director'         => ['nombre' => $p->director?->nombre],
            ]);

        return response()->json(['peliculas' => $peliculas]);
    }
}