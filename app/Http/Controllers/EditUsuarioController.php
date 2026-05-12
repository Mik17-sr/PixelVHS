<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class EditUsuarioController
{
    public function toggleUser($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        $usuario->estado = ($usuario->estado === 'Activo') ? 'Inactivo' : 'Activo';
        $usuario->save();
        return response()->json(['estado' => $usuario->estado]);
    }

    public function eliminarUsuario($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        $usuario->delete();
        return response()->json(['success' => true]);
    }

    public function obtenerUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json(['usuario' => $usuario]);
    }

    public function actualizarUsuario(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'email'     => 'required|email|unique:usuario,email,' . $id . ',id_usuario',
            'usuario'   => 'required|string|unique:usuario,usuario,' . $id . ',id_usuario',
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:200',
            'rol'       => 'required|in:admin,empleado',
        ]);

        $usuario->nombre    = $request->nombre;
        $usuario->email     = $request->email;
        $usuario->usuario   = $request->usuario;
        $usuario->telefono  = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->rol       = $request->rol;

        $usuario->save();

        return response()->json(['usuario' => $usuario]);
    }
}
