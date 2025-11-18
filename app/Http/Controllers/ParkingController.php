<?php

namespace App\Http\Controllers;

use App\Models\Parqueadero;

class ParkingController extends Controller
{
    public function showMap()
    {
        $parkings = Parqueadero::select(
            'id',
            'nombre',
            'latitud',
            'longitud',
            'espacios_disponibles'
        )->get();

        return view('mapa', compact('parkings'));
    }
}

