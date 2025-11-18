<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Parqueaderos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="text-white text-decoration-none">
                <h1 class="h4">Refugio Rodante - Admin</h1>
            </a>
            <nav>
                <a href="/inde" class="text-white me-3">Inicio</a>
                <a href="/dashboard-admin" class="text-warning me-3">Panel Admin</a>
                <a href="/logout" class="text-white">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <h2 class="mb-4">Gestión de Parqueaderos</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

<!-- Formulario para agregar parqueadero -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">Agregar Nuevo Parqueadero</div>
    <div class="card-body">
        <form method="POST" action="{{ route('parqueaderos.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="espacios_disponibles" class="form-label">Espacios disponibles</label>
                    <input type="number" name="espacios_disponibles" class="form-control" min="0" required>
                </div>
                <div class="col-md-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="1"></textarea>
                </div>
                <div class="col-md-3">
                    <label for="latitud" class="form-label">Latitud</label>
                    <input type="text" name="latitud" class="form-control" placeholder="Ej: 6.2442" required>
                </div>

                <div class="col-md-3">
                    <label for="longitud" class="form-label">Longitud</label>
                    <input type="text" name="longitud" class="form-control" placeholder="Ej: -75.5812" required>
                </div>

                <div class="col-md-3">
    <label for="filas" class="form-label">Filas (letras)</label>
    <input type="number" name="filas" class="form-control" min="1" value="1" required>
</div>

<div class="col-md-3">
    <label for="puestos_por_fila" class="form-label">Puestos por fila (números)</label>
    <input type="number" name="puestos_por_fila" class="form-control" min="1" value="1" required>
</div>

<div class="col-md-3">
    <label for="letra_inicio" class="form-label">Letra inicio</label>
    <input type="text" name="letra_inicio" class="form-control" maxlength="1" value="A" required>
</div>
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success">Guardar Parqueadero</button>
            </div>
        </form>
    </div>
</div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Descripción</th>
                        <th>Espacios Disponibles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parqueaderos as $parqueadero)
                        <tr>
                            <td>{{ $parqueadero->nombre }}</td>
                            <td>{{ $parqueadero->direccion }}</td>
                            <td>{{ $parqueadero->descripcion }}</td>
                            <td>{{ $parqueadero->espacios_disponibles }}</td>
                            <td>
                                <a href="{{ route('parqueaderos.show', $parqueadero->id) }}" class="btn btn-sm btn-info">
                                    Ver Espacios
                                </a>
                                <a href="{{ route('parqueaderos.edit', $parqueadero->id) }}" class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                                <form action="{{ route('parqueaderos.destroy', $parqueadero->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este parqueadero?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay parqueaderos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
