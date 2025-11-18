<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parqueadero;
use App\Models\EspacioParqueadero;
use Illuminate\Support\Facades\DB;


class ParqueaderoController extends Controller
{
    private function generarEtiquetas(int $filas, int $puestosPorFila, string $letraInicio = 'A'): array
{
    $labels = [];
    $start = strtoupper($letraInicio)[0];

    for ($f = 0; $f < $filas; $f++) {
        $letter = chr(ord($start) + $f);

        for ($n = 1; $n <= $puestosPorFila; $n++) {
            $labels[] = $n . $letter;  // Ejemplo: 1A, 2A, 3A, luego 1B, 2B...
        }
    }

    return $labels;
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $parqueaderos = Parqueadero::all();
    return view('parqueaderos', compact('parqueaderos'));
    }




public function store(Request $request)
{
    $data = $request->validate([
        'nombre' => 'required|string|max:100',
        'direccion' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',
        'espacios_disponibles' => 'required|integer|min:0',
        'latitud' => 'nullable|numeric',
        'longitud' => 'nullable|numeric',
        'filas' => 'required|integer|min:1',
        'puestos_por_fila' => 'required|integer|min:1',
        'letra_inicio' => 'nullable|string|size:1'
    ]);

    $filas = (int) $data['filas'];
    $puestosPorFila = (int) $data['puestos_por_fila'];
    $letraInicio = $data['letra_inicio'] ?? 'A';

    DB::transaction(function() use ($data, $filas, $puestosPorFila, $letraInicio) {

        // Crear parqueadero
        $parqueadero = Parqueadero::create([
            'nombre' => $data['nombre'],
            'direccion' => $data['direccion'] ?? null,
            'descripcion' => $data['descripcion'] ?? null,
            'espacios_disponibles' => $data['espacios_disponibles'],
            'latitud' => $data['latitud'] ?? null,
            'longitud' => $data['longitud'] ?? null,
        ]);

        // Generar etiquetas
        $labels = $this->generarEtiquetas($filas, $puestosPorFila, $letraInicio);

        // Crear espacios_parqueadero
        foreach ($labels as $label) {
            EspacioParqueadero::create([
                'numero' => $label,
                'tipo' => 'Estándar', // o puedes tomar desde el form
                'parqueadero_id' => $parqueadero->id,
            ]);
        }

        // Ajustar el contador espacios_disponibles para ser el conteo real
        $parqueadero->espacios_disponibles = count($labels);
        $parqueadero->save();
    });

    return redirect()->route('parqueaderos.index')->with('success', 'Parqueadero y espacios creados correctamente.');
}

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

