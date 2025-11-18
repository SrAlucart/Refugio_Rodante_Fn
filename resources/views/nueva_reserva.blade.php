@extends('layouts.app')

{{-- Esta es la sección para el contenido principal de la página --}}
@section('content')
<div class="container mt-5">
    <h3>Nueva Reserva</h3>
    <form action="{{ route('guardar_reserva') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="parqueadero_id" class="form-label">Parqueadero</label>
            <select id="parqueadero_id" name="parqueadero_id" class="form-control" required>
                <option value="">Seleccione un parqueadero</option>
                @foreach($parqueaderos as $parqueadero)
                    <option value="{{ $parqueadero->id }}"
    {{ isset($parqueaderoSeleccionado) && $parqueaderoSeleccionado == $parqueadero->id ? 'selected' : '' }}>
    {{ $parqueadero->nombre }}
</option>

                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="espacio_id" class="form-label">Espacio</label>
            <select id="espacio_id" name="espacio_id" class="form-control" required>
                <option value="">Seleccione un parqueadero primero</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha Fin</label>
            <input type="datetime-local" id="fecha_fin" name="fecha_fin" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="placa_vehiculo" class="form-label">Placa Vehículo</label>
            <input type="text" id="placa_vehiculo" name="placa_vehiculo" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Reserva</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

{{-- Esta es la sección para los scripts de JavaScript --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const parqueaderoSelect = document.getElementById('parqueadero_id');
    const espacioSelect = document.getElementById('espacio_id');
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');

    function cargarEspacios() {
        const parqueaderoId = parqueaderoSelect.value;
        if (!parqueaderoId) {
            espacioSelect.innerHTML = '<option value="">Seleccione un parqueadero primero</option>';
            return;
        }

        espacioSelect.innerHTML = '<option value="">Cargando espacios...</option>';

        // Construir query params si hay fechas
        const params = new URLSearchParams();
        if (fechaInicio.value) params.append('fecha_inicio', fechaInicio.value);
        if (fechaFin.value) params.append('fecha_fin', fechaFin.value);

        fetch(`/parqueaderos/${parqueaderoId}/espacios?${params.toString()}`)
            .then(resp => resp.json())
            .then(data => {
                espacioSelect.innerHTML = '<option value="">Seleccione un espacio</option>';
                if (data.length > 0) {
                    data.forEach(e => {
                        const opt = document.createElement('option');
                        opt.value = e.id;
                        opt.textContent = `Espacio ${e.numero} (${e.tipo || 'Estándar'})`;
                        espacioSelect.appendChild(opt);
                    });
                } else {
                    espacioSelect.innerHTML = '<option value="">No hay espacios disponibles</option>';
                }
            })
            .catch(err => {
                console.error(err);
                espacioSelect.innerHTML = '<option value="">Error al cargar los espacios</option>';
            });
    }

    parqueaderoSelect.addEventListener('change', cargarEspacios);
    fechaInicio.addEventListener('change', cargarEspacios);
    fechaFin.addEventListener('change', cargarEspacios);

    // Si viene preseleccionado (desde mapa)
    if (parqueaderoSelect.value) {
        cargarEspacios();
    }
});
</script>
@endsection