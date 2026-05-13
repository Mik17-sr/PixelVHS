<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeliculaController
{
    public function registrarPelicula(Request $request)
    {
        try {
            $validated = $request->validate([
                'titulo'           => 'required|string|max:255',
                'anio_lanzamiento' => 'required|integer|min:1888|max:' . date('Y'),
                'duracion'         => 'required|integer|min:1',
                'resumen'          => 'nullable|string',
                'estudio'          => 'nullable|string|max:255',
                'precio_alquiler'  => 'nullable|numeric|min:0',
                'clasificacion'    => 'nullable|string|max:10',
                'id_genero'        => 'required|exists:genero,id_genero',
                'id_director'      => 'required|exists:director,id_director',
                'reparto'          => 'nullable|array',
                'reparto.*.id'     => 'required|exists:actor,id_actor',
                'reparto.*.papel'  => 'nullable|string|max:100',
                'foto_portada'     => 'nullable|image|max:4096',
                'banner'           => 'nullable|image|max:8192',
                'portadas'         => 'nullable|array',
                'portadas.*'       => 'nullable|image|max:4096',
            ], [
                'titulo.required'           => 'El título es obligatorio.',
                'anio_lanzamiento.required' => 'El año de lanzamiento es obligatorio.',
                'anio_lanzamiento.integer'  => 'El año debe ser un número entero.',
                'anio_lanzamiento.min'      => 'El año no puede ser anterior a 1888.',
                'anio_lanzamiento.max'      => 'El año no puede ser posterior al año actual.',
                'duracion.required'         => 'La duración es obligatoria.',
                'duracion.integer'          => 'La duración debe ser un número entero.',
                'duracion.min'              => 'La duración debe ser al menos 1 minuto.',
                'id_genero.required'        => 'El género es obligatorio.',
                'id_genero.exists'          => 'El género seleccionado no es válido.',
                'id_director.required'      => 'El director es obligatorio.',
                'id_director.exists'        => 'El director seleccionado no es válido.',
                'reparto.*.id.required'     => 'Cada actor debe tener un ID válido.',
                'reparto.*.id.exists'       => 'Uno o más actores no son válidos.',
                'foto_portada.image'        => 'La foto de portada debe ser una imagen válida.',
                'foto_portada.max'          => 'La foto de portada no puede superar los 4MB.',
                'banner.image'              => 'El banner debe ser una imagen válida.',
                'banner.max'                => 'El banner no puede superar los 8MB.',
                'portadas.*.image'          => 'Cada portada de formato debe ser una imagen válida.',
                'portadas.*.max'            => 'Cada portada no puede superar los 4MB.',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'ok'     => false,
                'errors' => $e->errors(),
            ], 422);
        }

        $pelicula = Pelicula::create([
            'titulo'           => $validated['titulo'],
            'resumen'          => $validated['resumen']          ?? null,
            'anio_lanzamiento' => $validated['anio_lanzamiento'],
            'duracion_minutos'         => $validated['duracion'],
            'estudio'          => $validated['estudio']          ?? null,
            'precio_alquiler'  => $validated['precio_alquiler']  ?? 0,
            'clasificacion'    => $validated['clasificacion']    ?? null,
            'id_genero'        => $validated['id_genero'],
            'id_director'      => $validated['id_director'],
            'foto_portada'     => $request->hasFile('foto_portada')
                                    ? $request->file('foto_portada')->store('peliculas/portadas', 'public')
                                    : null,
            'banner'           => $request->hasFile('banner')
                                    ? $request->file('banner')->store('peliculas/banners', 'public')
                                    : null,
        ]);
        if (!empty($validated['reparto'])) {
            $repartoInsert = collect($validated['reparto'])->map(fn($item) => [
                'id_pelicula' => $pelicula->id_pelicula,
                'id_actor'    => $item['id'],
                'papel'       => $item['papel'] ?? null,
            ])->toArray();

            DB::table('reparto')->insert($repartoInsert);
        }

        if ($request->hasFile('portadas')) {
            $portadasInsert = [];

            foreach ($request->file('portadas') as $idFormato => $archivo) {
                if (!$archivo || !$archivo->isValid()) continue;

                $path = $archivo->store("peliculas/portadas/formato_{$idFormato}", 'public');
                $portadasInsert[] = [
                    'id_pelicula' => $pelicula->id_pelicula,
                    'id_formato'  => $idFormato,
                    'imagen'      => $path,
                ];
            }

            if (!empty($portadasInsert)) {
                DB::table('portada_pelicula')->insert($portadasInsert);
            }
        }

        return response()->json([
            'ok'       => true,
            'pelicula' => $pelicula,
        ], 201);
    }
}
