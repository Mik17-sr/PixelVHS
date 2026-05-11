<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    public function mostrarFormulario()
    {
        return view('forgot-password');
    }

    public function enviarEnlace(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Te enviamos el enlace a tu correo.')
            : back()->withErrors(['email' => 'No encontramos ese correo.']);
    }

    public function mostrarReset(string $token)
    {
        return view('reset-password', ['token' => $token]);
    }

    public function resetear(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email:rfc,filter',
            'password' => 'required|min:6|confirmed',
        ],[
            'token.required' => 'El token es obligatorio.',
            'email.required' => 'Debes ingresar tu correo electrónico.',
            'email.email' => 'El correo electrónico no es válido.',
            'password.required' => 'Debes ingresar una contraseña.',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => bcrypt($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('success', '¡Contraseña actualizada!')
            : back()->withErrors(['email' => 'El enlace no es válido o expiró.']);
    }
}