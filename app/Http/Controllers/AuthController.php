<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario'    => 'required',
            'password' => 'required',
        ],[
            'usuario.required' => 'Debes ingresar tu usuario.',
            'password.required' => 'Debes ingresar tu contraseña.',
        ]);

        $credenciales = $request->only('usuario', 'password');

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            return redirect('/principal');
        }

        return back()->withErrors([
            'usuario' => 'Las credenciales no son correctas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
