<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <header>
        <div class="logo-container">
            <div class="left-side">
                <a href="/"><img src="{{ asset('img/refugiorodante2.png') }}" alt="Logo"></a>
            </div>
            <div class="right-side">
                <h1>REFUGIO RODANTE</h1>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>
        <nav id="nav-menu" class="nav-links">
            <div class="nav-link-wrapper"><a href="/logout">Cerrar Sesión</a></div>
        </nav>
    </header>

    <div class="container mt-5">
        <!-- Mensajes de éxito -->
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Dashboard de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Información Personal</h5>
                                    <p><strong>Nombre:</strong> {{ $usuario['username'] }}</p>
                                    <p><strong>Email:</strong> {{ $usuario['email'] }}</p>
                                    <p><strong>Rol:</strong> {{ ucfirst($usuario['rol']) }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Acciones Rápidas</h5>

<a href="/mapa-parqueaderos" class="btn btn-warning mb-2">Hacer Nueva Reserva</a>



                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>Mis Reservas Recientes</h5>
                                <div class="table-responsive">
                                   <table class="table table-striped">
    <thead>
        <tr>
            <th>Parqueadero</th>
            <th>Espacio</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
            <th>Placa</th>
            <th>Acciones</th> <!-- 🔥 NUEVA COLUMNA -->
        </tr>
    </thead>
    <tbody>
        @forelse($reservas as $reserva)
        <tr>
            <td>{{ $reserva->nombre_parqueadero ?? 'N/A' }}</td>
            <td>{{ $reserva->numero_espacio ?? 'N/A' }}</td>
            <td>{{ $reserva->fecha_inicio }}</td>
            <td>{{ $reserva->fecha_fin }}</td>
            <td>{{ ucfirst($reserva->estado) }}</td>
            <td>{{ $reserva->placa_vehiculo }}</td>

            <!-- 🔥 BOTONES NUEVOS -->
            <td>
                @if($reserva->estado == 'confirmada' || $reserva->estado == 'pendiente')
                    <a href="{{ route('usuario.reserva.cancelar', $reserva->id) }}"
                       class="btn btn-danger btn-sm">
                        Cancelar
                    </a>
                @endif

                @if($reserva->estado == 'confirmada')
                    <a href="{{ route('usuario.reserva.finalizar', $reserva->id) }}"
                       class="btn btn-secondary btn-sm mt-1">
                        Finalizar
                    </a>
                @endif
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No tienes reservas actualmente</td>
        </tr>
        @endforelse
    </tbody>
</table>
                                </div>
                            </div>
                        </div>

                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
