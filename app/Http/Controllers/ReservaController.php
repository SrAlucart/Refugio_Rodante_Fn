<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\EspacioParqueadero;
use App\Models\Parqueadero;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ReservaController extends Controller
{

public function create(Request $request)
{
    $parqueaderos = Parqueadero::all();

    $parqueaderoSeleccionado = $request->input('parqueadero_id'); // <-- ESTE USA input()

    return view('nueva_reserva', compact('parqueaderos', 'parqueaderoSeleccionado'));
}

    // 👉 Cargar espacios disponibles para el SELECT
public function espaciosPorParqueadero($id)
{
    // Obtener todos los espacios del parqueadero
    $espacios = EspacioParqueadero::where('parqueadero_id', $id)->get();

    // Filtrar solo los disponibles
    $espaciosDisponibles = $espacios->filter(function ($espacio) {
        $reservaActiva = Reserva::where('espacio_id', $espacio->id)
            ->where('estado', 'confirmada')
            ->where('fecha_inicio', '<=', now())
            ->where('fecha_fin', '>=', now())
            ->exists();

        return !$reservaActiva; // si NO tiene reserva activa → disponible
    })->values();

    return response()->json($espaciosDisponibles);
}


public function guardar(Request $request)
{
    $request->validate([
        'parqueadero_id' => 'required',
        'espacio_id' => 'required',
        'fecha_inicio' => 'required',
        'fecha_fin' => 'required',
        'placa_vehiculo' => 'required',
    ]);

    DB::transaction(function () use ($request) {

        // Crear la reserva
        $reserva = Reserva::create([
            'usuario_id' => auth()->user()->id,
            'parqueadero_id' => $request->parqueadero_id,
            'espacio_id' => $request->espacio_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'placa_vehiculo' => $request->placa_vehiculo,
            'estado' => 'pendiente'
        ]);

        // 🔥 RESTAR UN ESPACIO DISPONIBLE
        Parqueadero::where('id', $request->parqueadero_id)
            ->decrement('espacios_disponibles', 1);
    });

    return redirect()->route('usuario.reservas')
                     ->with('success','Reserva creada con éxito.');
}



public function aprobar($id)
{
    $reserva = Reserva::findOrFail($id);
    
    // Cambiar estado
    $reserva->estado = 'confirmada';
    $reserva->save();

    // Reducir espacios del parqueadero
    $parqueadero = $reserva->espacio->parqueadero;
    $parqueadero->espacios_disponibles -= 1;
    $parqueadero->save();

    return back()->with('success', 'Reserva confirmada.');
}


public function cancelar($id)
{
    $reserva = Reserva::findOrFail($id);

    // Volver espacio disponible
    $parqueadero = $reserva->espacio->parqueadero;
    $parqueadero->espacios_disponibles += 1;
    $parqueadero->save();

    $reserva->estado = 'cancelada';
    $reserva->save();

    return back()->with('success', 'Reserva cancelada.');
}



public function finalizar($id)
{
    $reserva = Reserva::findOrFail($id);

    // Liberar espacio del parqueadero
    $parqueadero = $reserva->espacio->parqueadero;
    $parqueadero->espacios_disponibles += 1;
    $parqueadero->save();

    // Cambiar estado
    $reserva->estado = 'finalizada';
    $reserva->save();

    return back()->with('success', 'La reserva ha sido finalizada y el espacio está disponible.');
}


//cancelar reserva usuario
public function cancelarUsuario($id)
{
    $reserva = Reserva::findOrFail($id);

    // Verificar propietario
    if ($reserva->usuario_id != Auth::id()) {
        return back()->with('error', 'No tienes permiso para cancelar esta reserva.');
    }

    // Liberar espacio
    $parqueadero = $reserva->espacio->parqueadero;
    $parqueadero->espacios_disponibles += 1;
    $parqueadero->save();

    // Cambiar estado
    $reserva->estado = 'cancelada';
    $reserva->save();

    return back()->with('success', 'Reserva cancelada correctamente.');
}
public function finalizarUsuario($id)
{
    $reserva = Reserva::findOrFail($id);

    // Verificar propietario
    if ($reserva->usuario_id != Auth::id()) {
        return back()->with('error', 'No tienes permiso para finalizar esta reserva.');
    }

    // Liberar espacio
    $parqueadero = $reserva->espacio->parqueadero;
    $parqueadero->espacios_disponibles += 1;
    $parqueadero->save();

    // Cambiar estado
    $reserva->estado = 'finalizada';
    $reserva->save();

    return back()->with('success', 'Reserva finalizada y espacio liberado.');
}



    
    // 👉 Guardar nueva reserva
    public function store(Request $request)
    {
        $request->validate([
            'parqueadero_id' => 'required|exists:parqueaderos,id',
            'espacio_id'     => 'required|exists:espacios_parqueadero,id',
            'fecha_inicio'   => 'required|date',
            'fecha_fin'      => 'required|date|after:fecha_inicio',
            'placa_vehiculo' => 'required|string|max:20',
        ]);

        $usuarioId = auth()->id();

        // Validación de disponibilidad REAL del espacio
        $conflicto = DB::table('reservas')
            ->where('espacio_id', $request->espacio_id)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->where(function ($q) use ($request) {
                $q->where('fecha_inicio', '<', $request->fecha_fin)
                  ->where('fecha_fin', '>', $request->fecha_inicio);
            })
            ->exists();

        if ($conflicto) {
            return back()->withErrors(['espacio_id' => 'El espacio seleccionado NO está disponible en las fechas elegidas.']);
        }

        // Crear reserva
        Reserva::create([
            'usuario_id'     => $usuarioId,
            'espacio_id'     => $request->espacio_id,
            'fecha_inicio'   => $request->fecha_inicio,
            'fecha_fin'      => $request->fecha_fin,
            'placa_vehiculo' => $request->placa_vehiculo,
            'modelo_vehiculo'=> $request->modelo_vehiculo,
            'estado'         => 'pendiente',
        ]);

        return redirect()->route('dashboard')->with('success', 'Reserva creada correctamente.');
    }
}
