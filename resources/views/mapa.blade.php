<!DOCTYPE html>
<html>
<head>
    <title>Mapa de Parqueaderos</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>#map { height: 600px; width: 100%; }</style>
</head>
<body>
    @extends('layouts.app')

    <h2 style="text-align: center;">Parqueaderos disponibles</h2>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([6.2442, -75.5812], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

 @foreach ($parkings as $p)
    @if($p->latitud && $p->longitud)
        L.marker([{{ $p->latitud }}, {{ $p->longitud }}])
            .addTo(map)
            .bindPopup(`
                <strong>{{ $p->nombre }}</strong><br>
                {{ $p->direccion }}<br>
                Espacios disponibles: {{ $p->espacios_disponibles }}<br><br>
                <button onclick="reservar({{ $p->id }})" 
                    style="background:#007bff;color:white;padding:6px 10px;border:none;border-radius:4px;cursor:pointer;">
                    Reservar aquí
                </button>
            `);
    @endif
@endforeach

        function reservar(id) {
            window.location.href = "/usuario/reserva/nueva?parqueadero_id=" + id;
        }
    </script>

</body>
</html>
