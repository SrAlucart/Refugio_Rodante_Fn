<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ParqueaderoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/inde');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/registro', [AuthController::class, 'registro']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD (Admin y Usuario)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard-admin', [AuthController::class, 'dashboardAdmin'])->name('dashboard.admin');
});
/*
|--------------------------------------------------------------------------
| RUTAS ADMIN - RECURSOS (Admin)
|--------------------------------------------------------------------------
*/
Route::resource('parqueaderos', ParqueaderoController::class);

/*
|--------------------------------------------------------------------------
| RUTAS USUARIO AUTENTICADO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/usuario/dashboard', [UsuarioController::class, 'Usuario'])->name('usuario.dashboard');
    Route::get('/usuario/reservas', [UsuarioController::class, 'misReservas'])->name('usuario.reservas');
});

/*
|--------------------------------------------------------------------------
| RUTAS DE RESERVA (Usuario con rol usuario)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'rol:usuario'])->group(function () {
    Route::get('/usuario/reserva/nueva', [ReservaController::class, 'create'])->name('nueva_reserva');
    Route::post('/usuario/reserva', [ReservaController::class, 'guardar'])->name('guardar_reserva');
    Route::get('/parqueaderos/{id}/espacios', [ReservaController::class, 'getEspacios'])->name('parqueaderos.espacios');
});

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Frontend general)
|--------------------------------------------------------------------------
*/
Route::view('/inde', 'inde');
Route::view('/informacion', 'informacion');
Route::view('/quienessomos', 'quienessomos');
Route::view('/termino-y-condiciones', 'termino-y-condiciones');

/*
|--------------------------------------------------------------------------
| RUTAS DE INTERFAZ
|--------------------------------------------------------------------------
*/
Route::view('/admin', 'admin'); // Vista admin.blade.php
Route::view('/cerrarsesion', 'cerrarsesion');
Route::view('/espacioamerica', 'espacioamerica');
Route::view('/mapa', 'mapa');
Route::get('/mapa-parqueaderos', [ParkingController::class, 'showMap']);
Route::view('/reservaamerica', 'reservaamerica');
