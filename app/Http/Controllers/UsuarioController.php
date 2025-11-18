<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Reserva;
use App\Models\EspacioParqueadero;
use App\Models\Parqueadero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Dashboard principal del usuario
public function Usuario()
{
    $usuario = Auth::user();

    $reservas = Reserva::where('usuario_id', $usuario->id)
        ->with('espacio.parqueadero')
        ->orderBy('fecha_inicio', 'desc')
        ->limit(5)
        ->get();

    return view('usuario.dashboard', compact('usuario', 'reservas'));
}

    // Ver todos los parqueaderos disponibles
    public function verParqueaderos()
    {
        // Mostramos solo parqueaderos con al menos 1 espacio disponible
        $parqueaderos = Parqueadero::where('espacios_disponibles', '>', 0)->get();

        return view('usuario.parqueaderos', compact('parqueaderos'));
    }

    // Ver todas sus reservas
    public function misReservas()
    {
        $usuario = Auth::user();

        $reservas = Reserva::where('usuario_id', $usuario->id)
            ->with('espacio.parqueadero')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('usuario.mis_reservas', compact('reservas'));
    }

    // Mostrar formulario para hacer una nueva reserva
    public function nuevaReserva()
    {
        // Traemos espacios disponibles
        $espacios = EspacioParqueadero::whereDoesntHave('reservas', function ($query) {
            $query->where('estado', '!=', 'cancelada');
        })->with('parqueadero')->get();

        return view('usuario.nueva_reserva', compact('espacios'));
    }

    // Guardar la nueva reserva
    public function guardarReserva(Request $request)
    {
        $request->validate([
            'espacio_id' => 'required|exists:espacios_parqueadero,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'placa_vehiculo' => 'required|string|max:20',
            'modelo_vehiculo' => 'nullable|string|max:50'
        ]);

        $reserva = new Reserva();
        $reserva->usuario_id = Auth::id();
        $reserva->espacio_id = $request->espacio_id;
        $reserva->fecha_inicio = $request->fecha_inicio;
        $reserva->fecha_fin = $request->fecha_fin;
        $reserva->placa_vehiculo = $request->placa_vehiculo;
        $reserva->modelo_vehiculo = $request->modelo_vehiculo;
        $reserva->estado = 'pendiente';
        $reserva->save();

        // Actualizamos espacios disponibles del parqueadero
        $espacio = EspacioParqueadero::find($request->espacio_id);
        $espacio->parqueadero->decrement('espacios_disponibles');

        return redirect()->route('usuario.dashboard')->with('success', 'Reserva realizada con éxito');
    }

      public function index()
    {
        $usuarios = Usuario::all();

        return view('admin.gestion-usuarios', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:usuario,admin',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $usuario = Usuario::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'usuario' => $usuario
        ]);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|min:3|max:50',
            'email' => "required|email|unique:usuarios,email,$id",
            'rol' => 'required|in:usuario,admin',
        ]);

        // Cambiar contraseña si viene en el request
        if ($request->password) {
            $validated['password'] = Hash::make($request->password);
        }

        $usuario->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'usuario' => $usuario
        ]);
    }

    public function destroy($id)
    {
        Usuario::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ]);
    }
}
