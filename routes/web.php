<?php

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardEmpleadoController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\EditUsuarioController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\CintaController;
use App\Http\Controllers\ListaEsperaController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ValoracionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Vistas
Route::middleware(['auth', 'role:socio'])->group(function () {
    Route::get('/principal', [PrincipalController::class, 'mostrarPrincipal'])->name('principal');
    Route::get('/socio/datos', [PrestamoController::class, 'datosSocio'])->name('socio.datos');
    Route::post('/rentas', [PrestamoController::class, 'crear'])->name('rentas.crear');
    Route::get('/mis-rentas', [PrestamoController::class, 'misRentas'])->name('rentas.mis');
    Route::post('/lista-espera', [ListaEsperaController::class, 'unirse'])->name('lista-espera.unirse');
    Route::delete('/lista-espera/{id}', [ListaEsperaController::class, 'salir'])->name('lista-espera.salir');
    Route::post('/pago/pse/abrir', [PagoController::class, 'abrirPSE'])->name('pago.pse.abrir');
    Route::post('/pago/pse/confirmar', [PagoController::class, 'confirmarPSE'])->name('pago.pse.confirmar');
    Route::post('/notificaciones/leer-todas', function () {
    auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['ok' => true]);
    })->name('notificaciones.leer');
    Route::post('/prestamos/{id}/cancelar', [PrestamoController::class, 'cancelar'])->name('prestamos.cancelar');
    Route::post('/valoraciones', [ValoracionController::class, 'guardar'])->name('valoraciones.guardar');
    Route::get('/valoraciones/{id}/mia', [ValoracionController::class, 'miValoracion'])->name('valoraciones.mia');
    Route::get('/valoraciones/{id}', [ValoracionController::class, 'porPelicula'])->name('valoraciones.pelicula');
    Route::get('/recomendaciones', [ValoracionController::class, 'recomendaciones'])->name('recomendaciones');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard_admin',
        [DashboardAdminController::class, 'mostrarPrincipal']
    )->name('dashboard.admin');
});

Route::post('empleado/prestamos/{id}/cancelar-admin', 
    [PrestamoController::class, 'cancelarAdmin']);

Route::middleware(['auth', 'role:empleado'])->group(function () {
    Route::get('/dashboard_empleado',
        [DashboardEmpleadoController::class, 'mostrarPrincipal']
    )->name('dashboard.empleado'); 
});

Route::get('/registro', [RegisterController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [RegisterController::class, 'registrar']);

Route::get('/forgot-password', [PasswordResetController::class, 'mostrarFormulario'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'enviarEnlace'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'mostrarReset'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetear'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::post('/perfil/foto', [PerfilController::class, 'actualizarFoto'])->name('perfil.foto');
    Route::put('/perfil/datos', [PerfilController::class, 'actualizarDatos'])->name('perfil.datos');
});


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    Route::post('/registrar',
        [RegisterController::class, 'registrarAdmin']
    )->name('registrar');

    Route::put('/usuarios/{id}/toggle',
        [EditUsuarioController::class, 'toggleUser']
    )->name('usuarios.toggle');

    Route::delete('/usuarios/{id}',
        [EditUsuarioController::class, 'eliminarUsuario']
    )->name('usuarios.eliminar');

    Route::get('/usuarios/{id}',
        [EditUsuarioController::class, 'obtenerUsuario']
    )->name('usuarios.obtener');

    Route::put('/usuarios/{id}',
        [EditUsuarioController::class, 'actualizarUsuario']
    )->name('usuarios.actualizar');
});

Route::middleware(['auth', 'role:empleado'])
    ->prefix('empleado')
    ->name('empleado.')
    ->group(function () {

    Route::post('/directores/registrar',
        [DirectorController::class, 'registrarDirector']
    )->name('directores.registrar');

    Route::post('/directores/{id}', 
        [DirectorController::class, 'update'])
     ->name('directores.actualizar');

    Route::delete('/directores/{id}', 
        [DirectorController::class, 'destroy'])
     ->name('directores.destroy');

     Route::post('/actores/registrar', 
        [ActorController::class, 'registrar'])
     ->name('actores.registrar');

     Route::post('/actores/{id}', 
        [ActorController::class, 'update'])
    ->name('actores.actualizar');

     Route::delete('/actores/{id}', 
        [ActorController::class, 'destroy'])
     ->name('actores.destroy');

    Route::post('/peliculas/registrar', 
        [PeliculaController::class, 'registrarPelicula'])
    ->name('peliculas.registrar');

    Route::post('/cintas/lote', 
        [CintaController::class, 'storeLote'])
    ->name('cintas.lote');

    Route::get('/cintas', [CintaController::class, 'index'])->name('cintas.index');
    Route::post('/cintas/{id}/estado', [CintaController::class, 'cambiarEstado'])->name('cintas.estado');

    Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
    Route::post('/prestamos/{id}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
    Route::post('/prestamos/{id}/cancelar', [PrestamoController::class, 'cancelar'])->name('prestamos.cancelar');
    Route::post('/prestamos/{id}/pago', [PrestamoController::class, 'registrarPago'])->name('prestamos.pago');
    Route::post('/prestamos/{id}/cancelar-admin', 
    [PrestamoController::class, 'cancelarAdmin']);
});

