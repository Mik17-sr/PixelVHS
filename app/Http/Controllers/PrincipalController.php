<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\Genero;
use Illuminate\Routing\Controller;

class PrincipalController extends Controller
{
    public function mostrarPrincipal()
    {
        $generos = Genero::all();
        $peliculasDestacadas = Pelicula::with(['genero', 'director', 'actores', 'cintas'])
            ->limit(8)
            ->get();
        $peliculasPorGenero = [];
        foreach ($generos as $genero) {
            $peliculasPorGenero[$genero->nombre] = Pelicula::where('id_genero', $genero->id_genero)
                ->with(['genero', 'director', 'actores', 'cintas'])
                ->get();
        }
        
        return view('principal', [
            'peliculasDestacadas' => $peliculasDestacadas,
            'generos' => $generos,
            'peliculasPorGenero' => $peliculasPorGenero,
        ]);
    }
    
    public function buscar(Request $request)
    {
        $query = $request->input('q', '');
        
        $resultados = Pelicula::where('titulo', 'LIKE', "%{$query}%")
            ->orWhere('resumen', 'LIKE', "%{$query}%")
            ->with(['genero', 'director', 'actores', 'cintas'])
            ->get();
        
        return response()->json($resultados);
    }
    
    public function obtenerPorGenero($idGenero)
    {
        $peliculas = Pelicula::where('id_genero', $idGenero)
            ->with(['genero', 'director', 'actores', 'cintas'])
            ->get();
        
        return response()->json($peliculas);
    }
}
