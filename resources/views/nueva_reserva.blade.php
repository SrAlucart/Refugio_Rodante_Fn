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
                    <option value="{{ $parqueadero->id }}">{{ $parqueadero->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="espacios_disponibles" class="form-label">Espacio</label>
            <select id="espacios_disponibles" name="espacios_disponibles" class="form-control" required>
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
        document.getElementById('parqueadero_id').addEventListener('change', function() {
            const parqueaderoId = this.value;
            const espacioSelect = document.getElementById('espacios_disponibles');
            
            espacioSelect.innerHTML = '<option value="">Cargando espacios...</option>';

            if (!parqueaderoId) {
                espacioSelect.innerHTML = '<option value="">Seleccione un parqueadero primero</option>';
                return;
            }

            // Petición fetch para obtener los espacios del parqueadero seleccionado
            fetch(/parqueaderos/${parqueaderoId}/espacios)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    espacioSelect.innerHTML = '<option value="">Seleccione un espacio</option>';
                    if (data.length > 0) {
                        data.forEach(espacio => {
                            const option = document.createElement('option');
                            option.value = espacio.id;
                            option.textContent = Espacio ${espacio.numero} (${espacio.tipo || 'Estándar'});
                            espacioSelect.appendChild(option);
                        });
                    } else {
                        espacioSelect.innerHTML = '<option value="">No hay espacios disponibles</option>';
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los espacios:', error);
                    espacioSelect.innerHTML = '<option value="">Error al cargar los espacios</option>';
                });
        });
    });
</script>
@endsection