<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Director;
use App\Models\Formato;
use App\Models\Genero;
use App\Models\Pelicula;
use Illuminate\Http\Request;

class DashboardEmpleadoController
{
    public function mostrarPrincipal()
    {
        $peliculas = Pelicula::all();
        $directores = Director::all();
        $actores = Actor::all();
        $generos = Genero::all();
        $formatos = Formato::all();
        return view('dashboard_empleado', compact('peliculas', 'directores', 'actores', 'generos', 'formatos'));
    }
}
