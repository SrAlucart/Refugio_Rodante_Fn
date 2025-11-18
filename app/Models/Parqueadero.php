<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parqueadero extends Model
{
    protected $table = 'parqueaderos';

    protected $fillable = [
        'nombre',
        'direccion',
        'descripcion',
        'espacios_disponibles',
        'latitud',
        'longitud',
        // opcionales: si quieres almacenar metadatos sobre la generación automática
    ];

    private function generarEtiquetas(int $filas, int $puestosPorFila, string $letraInicio = 'A'): array
{
    $labels = [];
    $start = strtoupper($letraInicio)[0];
    for ($f = 0; $f < $filas; $f++) {
        $letter = chr(ord($start) + $f);
        for ($n = 1; $n <= $puestosPorFila; $n++) {
            $labels[] = $n . $letter; // e.g. "1A"
        }
    }
    return $labels;
}
    // Relación: un parqueadero tiene muchos espacios
    public function espacios()
    {
        return $this->hasMany(EspacioParqueadero::class, 'parqueadero_id');
    }
}
