<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'usuario_id',
        'parqueadero_id',
        'espacio_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'placa_vehiculo',
    ];

    // 🔥 RELACIÓN CON USUARIO
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // 🔥 RELACIÓN CON PARQUEADERO
    public function parqueadero()
    {
        return $this->belongsTo(Parqueadero::class, 'parqueadero_id');
    }

    // 🔥 RELACIÓN CON ESPACIO
    public function espacio()
    {
        return $this->belongsTo(EspacioParqueadero::class, 'espacio_id');
    }
}
