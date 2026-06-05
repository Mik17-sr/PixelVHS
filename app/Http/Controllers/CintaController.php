<?php

namespace App\Http\Controllers;

use App\Models\Cinta;
use Illuminate\Http\Request;

class CintaController
{
    public function storeLote(Request $request) {
        $request->validate([
            'id_pelicula' => 'required|exists:pelicula,id_pelicula',
            'lotes'       => 'required|array|min:1',
            'lotes.*.id_formato' => 'required|integer|in:1,2,3,4',
            'lotes.*.cantidad'   => 'required|integer|min:1|max:50',
        ]);

        $cintas = [];
        foreach ($request->lotes as $lote) {
            for ($i = 0; $i < $lote['cantidad']; $i++) {
                $cintas[] = Cinta::create([
                    'id_pelicula' =>  $request->id_pelicula,
                    'id_formato'  => $lote['id_formato'],
                    'estado'      => 'disponible',
                ]);
            }
        }
        return response()->json(['cintas' => $cintas], 201);
    }

    public function index() {
        $cintas = Cinta::join('pelicula', 'cinta.id_pelicula', '=', 'pelicula.id_pelicula')
            ->select('cinta.*', 'pelicula.titulo as pelicula')
            ->orderBy('cinta.id_cinta', 'desc')
            ->get();
        return response()->json(['cintas' => $cintas]);
    }

    public function cambiarEstado(Request $request, $id) {
        $request->validate([
            'estado' => 'required|in:disponible,dañada,en mantenimiento,perdida',
        ]);
        $cinta = Cinta::findOrFail($id);
        $cinta->estado = $request->estado;
        $cinta->save();
        return response()->json(['cinta' => $cinta]);
    }
}
