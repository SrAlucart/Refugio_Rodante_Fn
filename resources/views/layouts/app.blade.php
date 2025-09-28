<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refugio Rodante</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .hero { background-image: url(" {{ asset ('img/principal.png') }}"); }
    .nav-link-wrapper a { text-decoration: none; color: white; padding: 10px; transition: color 0.3s ease; }
</style>
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
                <div class="bar"></div><div class="bar"></div><div class="bar"></div>
            </div>
        </div>
        <nav id="nav-menu" class="nav-links">
        <div class="nav-link-wrapper"><a href="{{ route('dashboard') }}">Mi Dashboard</a></div>
        <div class="nav-link-wrapper"><a href="/logout">Cerrar Sesión</a></div>

        </nav>
    </header>

    <main>
        {{-- AQUI VA EL CONTENIDO DE CADA PÁGINA --}}
        @yield('content')
    </main>

    <footer class="footer">
        </footer>

    {{-- SCRIPTS GLOBALES --}}
    <script src="{{ asset('js/bilboard.js') }}"></script>
    
    {{-- LUGAR PARA SCRIPTS ESPECÍFICOS DE CADA PÁGINA --}}
    @yield('scripts')
</body>
</html>