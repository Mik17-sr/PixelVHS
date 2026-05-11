<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Models\Pelicula;
use App\Models\Usuario;
use Illuminate\Http\Request;

class DashboardAdminController
{
    public function mostrarPrincipal()
    {
        $generos = Genero::all();
        $usuarios = Usuario::all();
        $peliculasDestacadas = Pelicula::with(['genero', 'director', 'actores', 'cintas'])
            ->limit(8)
            ->get();
        $peliculasPorGenero = [];
        foreach ($generos as $genero) {
            $peliculasPorGenero[$genero->nombre] = Pelicula::where('id_genero', $genero->id_genero)
                ->with(['genero', 'director', 'actores', 'cintas'])
                ->get();
        }
        
        return view('dashboard_admin', [
            'peliculasDestacadas' => $peliculasDestacadas,
            'generos' => $generos,
            'peliculasPorGenero' => $peliculasPorGenero,
            'usuarios' => $usuarios
        ]);
    }
}

