<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
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
                <h1>REFUGIO RODANTE - ADMIN</h1>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>
        <nav id="nav-menu" class="nav-links">
            <div class="nav-link-wrapper"><a href="/inde">Inicio</a></div>
            <div class="nav-link-wrapper"><a href="/configuracion" class="text-warning">Panel Admin</a></div>
            <div class="nav-link-wrapper"><a href="/logout">Cerrar Sesión</a></div>
        </nav>
    </header>

    <div class="container mt-5">
        <!-- Mensajes de éxito -->
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Bienvenido Administrador',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Dashboard de Administrador</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Información Personal</h5>
                                <p><strong>Nombre:</strong> {{ $usuario['username'] }}</p>
                                <p><strong>Email:</strong> {{ $usuario['email'] }}</p>
                                <p><strong>Rol:</strong> <span class="badge bg-danger">{{ ucfirst($usuario['rol']) }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <h5>Acciones de Administrador</h5>
<a href="{{ route('parqueaderos.index') }}" class="btn btn-primary mb-2">Gestionar Parqueaderos</a><br>

                                <a href="{{ route('usuarios.index') }}" class="btn btn-success mb-2">
    Gestionar Usuarios
</a>
                                <a href="#" class="btn btn-info mb-2">Ver Todas las Reservas</a><br>
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Estadísticas del Sistema</h5>
                            </div>
                            <div class="col-md-2">
                                <div class="card text-center bg-info text-white">
                                    <div class="card-body">
                                        <h3>{{ $estadisticas['total_usuarios'] }}</h3>
                                        <p>Usuarios</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card text-center bg-success text-white">
                                    <div class="card-body">
                                        <h3>{{ $estadisticas['total_parqueaderos'] }}</h3>
                                        <p>Parqueaderos</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card text-center bg-primary text-white">
                                    <div class="card-body">
                                        <h3>{{ $estadisticas['total_espacios'] }}</h3>
                                        <p>Espacios</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center bg-warning text-white">
                                    <div class="card-body">
                                        <h3>{{ $estadisticas['total_reservas'] }}</h3>
                                        <p>Total Reservas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center bg-danger text-white">
                                    <div class="card-body">
                                        <h3>{{ $estadisticas['reservas_pendientes'] }}</h3>
                                        <p>Reservas Pendientes</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>Reservas Pendientes de Aprobación</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Parqueadero</th>
                                                <th>Espacio</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin</th>
                                                <th>Placa</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
    @forelse ($reservasPendientes as $reserva)
        <tr>
            <td>{{ $reserva->usuario->username }}</td>
            <td>{{ $reserva->espacio->parqueadero->nombre }}</td>
            <td>{{ $reserva->espacio->numero }}</td>
            <td>{{ $reserva->fecha_inicio }}</td>
            <td>{{ $reserva->fecha_fin }}</td>
            <td>{{ $reserva->placa_vehiculo }}</td>
            <td>
                <a href="{{ route('reservas.aprobar', $reserva->id) }}"
                   class="btn btn-success btn-sm">Aprobar</a>

                <a href="{{ route('reservas.cancelar', $reserva->id) }}"
                   class="btn btn-danger btn-sm">Cancelar</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">No hay reservas pendientes</td>
        </tr>
    @endforelse
</tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>