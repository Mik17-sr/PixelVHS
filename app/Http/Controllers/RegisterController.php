<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function mostrarRegistro()
    {
        return view('registro');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email'    => 'required|email:rfc,filter|unique:usuario,email',
            'username' => 'required|unique:usuario,usuario',
            'password' => 'required|min:6|confirmed',
        ],
        [
            'name.required' => 'Debes ingresar tu nombre.',
            'email.required' => 'Debes ingresar un correo.',
            'email.email' => 'El correo no es válido.',
            'email.unique' => 'Ese correo ya está registrado.',
            'username.required' => 'Debes ingresar un usuario.',
            'username.unique' => 'Ese usuario ya existe.',
            'password.required' => 'Debes ingresar una contraseña.',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = Usuario::create([
            'nombre'     => $request->input('name'),
            'email'    => $request->input('email'),
            'usuario' => $request->input('username'),
            'password' => Hash::make($request->password),
            'fecha_registro' => now(),
            'estado' => 'activo',
            'rol' => 'socio',
        ]);

        Socio::create([
            'id_socio' => $usuario->id_usuario,
            'max_peliculas_simultaneas' => 3,
        ]);

        Mail::send(
            'emails.bienvenida',
            ['usuario' => $usuario],
            function ($message) use ($usuario) {

                $message->to($usuario->email)
                        ->subject('Bienvenido a PIXELVHS');
            }
        );

        return redirect('/login')->with('success', 'Cuenta creada. Ya puedes iniciar sesión.');
    }
}
