<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<header class="bg-dark text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4">Refugio Rodante - Admin</h1>
        <nav>
            <a href="/dashboard-admin" class="text-warning me-3">Panel Admin</a>
            <a href="/logout" class="text-white">Cerrar Sesión</a>
        </nav>
    </div>
</header>

<div class="container mt-5">
    <h2 class="mb-4">Gestión de Usuarios</h2>

    <!-- Formulario -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Crear / Editar Usuario</div>
        <div class="card-body">

<form id="form-usuario" method="POST" action="{{ route('usuarios.store') }}">
    @csrf
    <input type="hidden" id="method-user" name="_method" value="POST">

    <div class="row g-3">

        <div class="col-md-4">
            <label class="form-label">Usuario</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Contraseña (solo crear o cambiar)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Rol</label>
            <select name="rol" class="form-control">
                <option value="usuario">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

    </div>

    <div class="text-end mt-4">
        <button type="submit" id="btn-user-submit" class="btn btn-success">
            Guardar Usuario
        </button>

        <button type="button" id="btn-cancel-user" class="btn btn-secondary d-none">
            Cancelar edición
        </button>
    </div>

</form>

        </div>
    </div>

    <!-- TABLA -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr id="fila-user-{{ $usuario->id }}">
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->username }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->rol }}</td>
                        <td>
                            <button onclick="editarUsuario({{ $usuario }})"
                                class="btn btn-warning btn-sm">Editar</button>

                            <button onclick="eliminarUsuario({{ $usuario->id }})"
                                class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>


<script>
// ========== Crear / Editar Usuario ==========
document.getElementById('form-usuario').addEventListener('submit', function(e) {
    e.preventDefault();

    let form = this;
    let data = new FormData(form);
    let action = form.action;
    let method = document.getElementById('method-user').value;

    fetch(action, {
        method: "POST",
        headers: {"X-Requested-With": "XMLHttpRequest"},
        body: data
    })
    .then(res => res.json())
    .then(response => {

        Swal.fire("Éxito", response.message, "success");

        actualizarFilaUsuario(response.usuario, method);

        form.reset();
        document.getElementById('method-user').value = "POST";
        document.getElementById('btn-user-submit').innerText = "Guardar Usuario";
        document.getElementById('btn-cancel-user').classList.add('d-none');
    });
});

// ========== Actualizar Fila ==========
function actualizarFilaUsuario(usuario, metodo) {

    if (metodo === "PUT") {
        let fila = document.getElementById("fila-user-" + usuario.id);
        fila.innerHTML = generarFila(usuario);
    } else {
        let tbody = document.querySelector("table tbody");
        let tr = document.createElement('tr');
        tr.id = "fila-user-" + usuario.id;
        tr.innerHTML = generarFila(usuario);
        tbody.prepend(tr);
    }
}

// ========== Fila HTML ==========
function generarFila(usuario) {
    return `
        <td>${usuario.id}</td>
        <td>${usuario.username}</td>
        <td>${usuario.email}</td>
        <td>${usuario.rol}</td>
        <td>
            <button onclick='editarUsuario(${JSON.stringify(usuario)})' class='btn btn-warning btn-sm'>Editar</button>
            <button onclick='eliminarUsuario(${usuario.id})' class='btn btn-danger btn-sm'>Eliminar</button>
        </td>`;
}

// ========== Editar ==========
function editarUsuario(usuario) {
    const form = document.getElementById('form-usuario');

    form.action = `/admin/usuarios/${usuario.id}`;
    document.getElementById('method-user').value = "PUT";

    document.querySelector('[name="username"]').value = usuario.username;
    document.querySelector('[name="email"]').value = usuario.email;
    document.querySelector('[name="rol"]').value = usuario.rol;

    document.getElementById('btn-user-submit').innerText = "Actualizar Usuario";
    document.getElementById('btn-cancel-user').classList.remove('d-none');
}

// ========== Cancelar Edición ==========
document.getElementById('btn-cancel-user').addEventListener('click', function() {
    const form = document.getElementById('form-usuario');
    form.action = "{{ route('usuarios.store') }}";
    form.reset();

    document.getElementById('method-user').value = "POST";
    document.getElementById('btn-user-submit').innerText = "Guardar Usuario";
    this.classList.add('d-none');
});

// ========== Eliminar ==========
function eliminarUsuario(id) {
    Swal.fire({
        title: "¿Eliminar usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar"
    }).then(result => {
        if (result.isConfirmed) {

            fetch(`/admin/usuarios/${id}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: new URLSearchParams({ _method: "DELETE" })
            })
            .then(res => res.json())
            .then(response => {

                Swal.fire("Eliminado", response.message, "success");
                document.getElementById("fila-user-" + id).remove();
            });
        }
    });
}
</script>

</body>
</html>
