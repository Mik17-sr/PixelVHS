<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();
        return view('perfil', compact('usuario'));
    }

    public function actualizarFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $usuario = auth()->user();

        if ($usuario->foto_perfil && Storage::disk('public')->exists($usuario->foto_perfil)) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $path = $request->file('foto')->store('fotosPerfil', 'public');
        $usuario->foto_perfil = $path;
        $usuario->save();

        return response()->json(['url' => asset('storage/' . $path)]);
    }

    public function actualizarDatos(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'nombre'    => 'required|string|max:100',
            'email'     => 'required|email|unique:usuario,email,' . $usuario->id_usuario . ',id_usuario',
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:200',
        ]);

        $usuario->nombre    = $request->nombre;
        $usuario->email     = $request->email;
        $usuario->telefono  = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->save();

        return response()->json(['usuario' => $usuario]);
    }
}