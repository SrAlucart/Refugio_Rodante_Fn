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
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif

        <!-- FORMULARIO -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Agregar / Editar Parqueadero</div>
            <div class="card-body">

<form method="POST" id="form-parqueadero" action="{{ route('parqueaderos.store') }}">
    @csrf
    <input type="hidden" id="method-field" name="_method" value="POST">

    <div class="row g-3">

        <div class="col-md-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Espacios disponibles</label>
            <input type="number" name="espacios_disponibles" class="form-control" min="0" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="1"></textarea>
        </div>

        <div class="col-md-3">
            <label class="form-label">Latitud</label>
            <input type="text" name="latitud" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Longitud</label>
            <input type="text" name="longitud" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Filas</label>
            <input type="number" name="filas" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Puestos por fila</label>
            <input type="number" name="puestos_por_fila" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Letra inicio</label>
            <input type="text" name="letra_inicio" maxlength="1" class="form-control" required>
        </div>

    </div>

    <div class="text-end mt-4">
        <button type="submit" id="btn-submit" class="btn btn-success">Guardar Parqueadero</button>
        <button type="button" id="btn-cancel-edit" class="btn btn-secondary d-none">Cancelar edición</button>
    </div>
</form>

            </div>
        </div>

        <!-- TABLA -->
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
                    @foreach($parqueaderos as $p)
                    <tr>
                        <td>{{ $p->nombre }}</td>
                        <td>{{ $p->direccion }}</td>
                        <td>{{ $p->descripcion }}</td>
                        <td>{{ $p->espacios_disponibles }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick='editarParqueadero(@json($p))'>
                                Editar
                            </button>

                            <form action="{{ route('parqueaderos.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este parqueadero?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

<script>
function editarParqueadero(p) {
    const form = document.getElementById('form-parqueadero');

    form.action = `/parqueaderos/${p.id}`;
    document.getElementById('method-field').value = 'PUT';

    document.querySelector('[name="nombre"]').value = p.nombre;
    document.querySelector('[name="direccion"]').value = p.direccion ?? '';
    document.querySelector('[name="descripcion"]').value = p.descripcion ?? '';
    document.querySelector('[name="espacios_disponibles"]').value = p.espacios_disponibles;
    document.querySelector('[name="latitud"]').value = p.latitud;
    document.querySelector('[name="longitud"]').value = p.longitud;

    if (p.filas) document.querySelector('[name="filas"]').value = p.filas;
    if (p.puestos_por_fila) document.querySelector('[name="puestos_por_fila"]').value = p.puestos_por_fila;
    if (p.letra_inicio) document.querySelector('[name="letra_inicio"]').value = p.letra_inicio;

    document.getElementById('btn-submit').innerText = "Actualizar Parqueadero";
    document.getElementById('btn-cancel-edit').classList.remove('d-none');

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.getElementById('btn-cancel-edit').addEventListener('click', () => {
    const form = document.getElementById('form-parqueadero');
    form.action = "{{ route('parqueaderos.store') }}";
    document.getElementById('method-field').value = 'POST';
    form.reset();
    document.getElementById('btn-cancel-edit').classList.add('d-none');
    document.getElementById('btn-submit').innerText = "Guardar Parqueadero";
});
</script>

</body>
</html>
