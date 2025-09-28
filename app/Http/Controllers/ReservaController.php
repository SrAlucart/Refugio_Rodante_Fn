<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;
use App\Models\Parqueadero;
use App\Models\EspacioParqueadero;

class ReservaController extends Controller
{
    // Mostrar formulario
    public function create()
    {
        $parqueaderos = Parqueadero::with('espacios')->get();
        return view('nueva_reserva', compact('parqueaderos'));
    }

    // Guardar reserva
    public function store(Request $request)
    {
        $request->validate([
            'parqueadero_id' => 'required|exists:parqueaderos,id',
            'espacio_id'     => 'required|exists:espacios_parqueadero,id',
            'fecha_inicio'   => 'required|date',
            'fecha_fin'      => 'required|date|after:fecha_inicio',
            'placa_vehiculo' => 'required|string|max:10'
        ]);

        Reserva::create([
            'usuario_id'     => Auth::id(),
            'espacio_id'     => $request->espacio_id,
            'fecha_inicio'   => $request->fecha_inicio,
            'fecha_fin'      => $request->fecha_fin,
            'estado'         => 'pendiente',
            'placa_vehiculo' => $request->placa_vehiculo,
        ]);

        return redirect()->route('dashboard')
            ->with('success', '¡Reserva creada exitosamente!');
    }
    /**
 * Obtener espacios de un parqueadero específico para AJAX.
 */
    public function getEspacios($parqueadero_id)
        {
    // Busca solo los espacios que no estén en una reserva activa o pendiente
    $espacios = EspacioParqueadero::where('parqueadero_id', $parqueadero_id)
        ->whereDoesntHave('reservas', function ($query) {
            $query->whereIn('estado', ['confirmada', 'pendiente']);
        })
        ->get();

    return response()->json($espacios);
    }
}
