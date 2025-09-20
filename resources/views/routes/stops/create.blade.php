@extends('layouts.app')



@section('breadcrumb')
    {{ Breadcrumbs::render('routes.create') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Crear Ruta</h5>
                    <div class="header-elements">

                        <form id="stopForm" action="{{ route('routes.stops.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre de la parada</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <input type="hidden" name="location" id="locationInput">
                            <input type="hidden" name="route_id" value="{{ $route->id }}">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">


            <div class="mb-2 d-flex justify-content-between">
                <div>
                    <span>Nuevos puntos: </span>
                    <button id="removeLastPointBtn" class="btn btn-warning" type="button">Eliminar último punto</button>
                    <button id="clearPolylineBtn" class="btn btn-danger" type="button">Borrar toda la ruta</button>
                </div>
                <div>
                    <span>Rutas existentes: </span>
                    <button id="toggleRoutesBtn" class="btn btn-primary" type="button">Mostrar otras rutas</button>

                </div>

            </div>
            <div id="map" style="width:100%; height:80vh; min-height:400px;"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let routeLayers2 = {};
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializamos el mapa centrado en la primera coordenada de la ruta

            const route = @json($route ?? null);
            const map = L.map('map').setView([-0.180653, -78.467838], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);


            let routeLayers = [];
            if (route) {
                let coordinates = JSON.parse(route.coordinates);
                if (coordinates.length > 0) {
                    const latlngs = coordinates.map(p => [p[1], p[0]]); // [lat, lng]
                    const polyline = L.polyline(latlngs, {
                        color: route?.color || 'blue',
                        weight: 4
                    }).addTo(map);
                    polyline
                        .bindPopup(`<b>${route.name}</b>`)
                        .openPopup();

                    // Marker de inicio (menos opaco)
                    const start = latlngs[0];
                    const startIcon = L.circleMarker(start, {
                        radius: 10,
                        color: route?.color || 'blue',
                        fillColor: route?.color || 'blue',
                        fillOpacity: 0.4,
                        opacity: 0.4
                    }).addTo(map).bindPopup(`<b>Inicio</b><br>${route.name}`).openPopup();

                    // Marker de fin (más opaco)
                    const end = latlngs[latlngs.length - 1];
                    const endIcon = L.circleMarker(end, {
                        radius: 10,
                        color: route?.color || 'blue',
                        fillColor: route?.color || 'blue',
                        fillOpacity: 1,
                        opacity: 1
                    }).addTo(map).bindPopup(`<b>Fin</b><br>${route.name}`).openPopup();

                    routeLayers.push(polyline, startIcon, endIcon);

                    // Guardar referencia para centrar el mapa después
                    routeLayers2[route.id] = {
                        polyline: polyline,
                        bounds: polyline.getBounds(),
                        center: polyline.getCenter(),
                        name: route.name
                    };

                    // Centrar el mapa en la primera ruta al cargar

                    map.fitBounds(polyline.getBounds());

                }
            }

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
            // Marcador de parada
            let marker = null;
            map.on('click', function(e) {
                if (marker) map.removeLayer(marker);
                console.log(e.latlng, 'latlng', e.latlng.lat, e.latlng.lng);

                marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
                document.getElementById('locationInput').value = JSON.stringify({
                    lat: e.latlng.lat,
                    lng: e.latlng.lng
                });
            });

            // Validación al enviar
            const form = document.getElementById('stopForm');
            form.addEventListener('submit', function(e) {
                if (!document.getElementById('locationInput').value) {
                    e.preventDefault();
                    alert('Please place the stop on the map.');
                }
            });

            stops = @json($stops ?? []);
            stops.forEach(stop => {
                L.marker([stop.lat, stop.lng])
                    .addTo(map)
                    .bindPopup(`Parada ${stop.ord}: ${stop.name}`);

                L.circleMarker([stop.lat, stop.lng], {
                    radius: 10,
                    color: "black",
                    fillColor: "yellow",
                    fillOpacity: 0.9
                }).addTo(map).bindTooltip(`
                <div style="min-width:180px">
                            <div style="font-weight:bold; color:${route?.color || '#007bff'}">
                                Parada ${stop.ord}: ${stop.name}
                            </div>
                            <div style="font-size:0.95em; color:#555;">
                                <i class="fa-solid fa-location-dot"></i> ${stop.lat}, ${stop.lng}
                            </div>
                            <div style="font-size:0.95em; color:#888;">
                                Distancia anterior: ${stop.distance_from_prev ?? 0}
                            </div>
                        </div>
                `, {
                    permanent: true,
                    direction: "center"
                });
            });
        });
    </script>
@endpush
