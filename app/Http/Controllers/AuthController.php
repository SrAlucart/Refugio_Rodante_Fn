<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\Parqueadero;
use App\Models\EspacioParqueadero;


class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'Email' => 'required|email',
        'Contrasena' => 'required'
    ]);

    // Cambiar nombres a los del formulario
    if (Auth::attempt([
        'email' => $credentials['Email'],
        'password' => $credentials['Contrasena']
    ])) {
        $request->session()->regenerate();

        $usuario = Auth::user();
        return $usuario->rol === 'admin'
            ? redirect('/dashboard-admin')->with('success', '¡Bienvenido Administrador!')
            : redirect('/dashboard')->with('success', '¡Bienvenido ' . $usuario->username . '!');
    }

    return back()->with('error', 'Credenciales incorrectas.');
}
    /**
     * Registro de nuevos usuarios
     */
    public function registro(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:50',
            'Apellido' => 'required|string|max:50',
            'Email' => 'required|email|unique:usuarios,email',
            'Contrasena' => 'required|min:1',
            'tipoUsuario' => 'required|in:usuario,admin'
        ]);

        $username = $request->Nombre . ' ' . $request->Apellido;

        // Asegurar nombre de usuario único
        $original = $username;
        $i = 1;
        while (DB::table('usuarios')->where('username', $username)->exists()) {
            $username = $original . $i++;
        }

        $insertado = DB::table('usuarios')->insert([
            'username' => $username,
            'email' => $request->Email,
            'password' => Hash::make($request->Contrasena),
            'rol' => $request->tipoUsuario,
            'fecha_registro' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $insertado
            ? back()->with('success', '¡Registro exitoso!')
            : back()->with('error', 'Error al registrar.');
    }

    /**
     * Cerrar sesión
     */
    public function logout()
{
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login')->with('success', 'Sesión cerrada correctamente.');
}


    /**
     * Dashboard usuario
     */
    public function dashboard()
{
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Debes iniciar sesión para acceder.');
    }

    $usuario = Auth::user();

    $reservas = DB::table('reservas')
        ->where('usuario_id', $usuario->id)
        ->join('espacios_parqueadero', 'reservas.espacio_id', '=', 'espacios_parqueadero.id')
        ->join('parqueaderos', 'espacios_parqueadero.parqueadero_id', '=', 'parqueaderos.id')
        ->select(
            'reservas.*',
            'espacios_parqueadero.numero as numero_espacio',
            'parqueaderos.nombre as nombre_parqueadero'
        )
        ->get();

    return view('usuario', compact('usuario', 'reservas'));
}

    /**
     * Dashboard administrador
     */
public function dashboardAdmin()
{
    if (!Auth::check() || Auth::user()->rol !== 'admin') {
        return redirect('/login')->with('error', 'Acceso no autorizado.');
    }

    $usuario = Auth::user();

    // ESTADÍSTICAS
    $estadisticas = [
        'total_usuarios' => DB::table('usuarios')->count(),
        'total_parqueaderos' => DB::table('parqueaderos')->count(),
        'total_espacios' => DB::table('espacios_parqueadero')->count(),
        'total_reservas' => DB::table('reservas')->count(),
        'reservas_pendientes' => DB::table('reservas')->where('estado', 'pendiente')->count()
    ];

    // RESERVAS PENDIENTES REALES
    $reservasPendientes = Reserva::with(['usuario', 'parqueadero', 'espacio'])
        ->where('estado', 'pendiente')
        ->get();

    return view('admin', compact(
        'usuario',
        'estadisticas',
        'reservasPendientes'
    ));
}

    /**
     * Obtener usuario desde la sesión
     */
    private function getUsuarioDesdeSession()
    {
        return [
            'id' => Session::get('usuario_id'),
            'username' => Session::get('usuario_username'),
            'email' => Session::get('usuario_email'),
            'rol' => Session::get('usuario_rol')
        ];
    }
}
