<?php

namespace App\Http\Controllers;

use App\Models\ListaEspera;
use App\Models\Pelicula;
use App\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ListaEsperaController extends Controller
{
    public function unirse(Request $request)
    {
        $request->validate([
            'id_pelicula' => 'required|integer|exists:pelicula,id_pelicula',
            'id_formato'  => 'nullable|integer|exists:formato,id_formato',
        ]);

        $socio = Socio::where('id_socio', auth()->id())->firstOrFail();

        $yaEnEspera = ListaEspera::where('id_socio', $socio->id_socio)
            ->where('id_pelicula', $request->id_pelicula)
            ->where(function ($q) use ($request) {
                $request->id_formato
                    ? $q->where('id_formato', $request->id_formato)
                    : $q->whereNull('id_formato');
            })
            ->exists();

        if ($yaEnEspera) {
            return response()->json([
                'message' => 'Ya estás en la lista de espera para esta película.'
            ], 422);
        }

        $entrada = ListaEspera::create([
            'id_socio'        => $socio->id_socio,
            'id_pelicula'     => $request->id_pelicula,
            'id_formato'      => $request->id_formato,
            'fecha_solicitud' => now(),
            'notificado'      => false,
        ]);

        $posicion = ListaEspera::where('id_pelicula', $request->id_pelicula)
            ->where(function ($q) use ($request) {
                $request->id_formato
                    ? $q->where('id_formato', $request->id_formato)
                    : $q->whereNull('id_formato');
            })
            ->where('fecha_solicitud', '<=', $entrada->fecha_solicitud)
            ->count();

        return response()->json([
            'message'  => 'Te has unido a la lista de espera.',
            'posicion' => $posicion,
        ]);
    }

    public function salir($id)
    {
        $socio = Socio::where('id_socio', auth()->id())->firstOrFail();

        $entrada = ListaEspera::where('id_lista_espera', $id)
            ->where('id_socio', $socio->id_socio)
            ->firstOrFail();

        $entrada->delete();

        return response()->json(['message' => 'Has salido de la lista de espera.']);
    }
}