<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspacioParqueadero extends Model
{
    protected $table = 'espacios_parqueadero';

    protected $fillable = ['numero', 'tipo', 'parqueadero_id'];

    public function parqueadero()
    {
        return $this->belongsTo(Parqueadero::class, 'parqueadero_id');
    }

    public function reservas()
{
    return $this->hasMany(Reserva::class, 'espacio_id');
}
}
