<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
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
            'usuario' => 'required',
            'password' => 'required',
        ], [
            'usuario.required' => 'Debes ingresar tu usuario.',
            'password.required' => 'Debes ingresar tu contraseña.',
        ]);

        $credenciales = [
            'usuario' => trim($request->usuario),
            'password' => $request->password,
            'estado' => 1,
        ];
        if (!Auth::attempt($credenciales)) {
            return back()
                ->withInput($request->only('usuario'))
                ->withErrors([
                    'usuario' => 'Usuario, contraseña o estado inválido.',
                ]);

        }

        $request->session()->regenerate();

        $user = Auth::user();

        return match ($user->rol) {
            'admin' => redirect()->route('dashboard.admin'),
            'empleado' => redirect()->route('dashboard.empleado'),
            default => redirect()->route('principal'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
