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
                        <form id="routeForm" action="{{ route('routes.store') }}" method="POST">
                            @csrf
                            @include('routes._form')
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
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([-0.180653, -78.467838], 15);
            const routes = @json($routes);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Variables para controlar las rutas
            let routeLayers = [];
            let routesVisible = false;

            function showRoutes() {
                routes.forEach((route, index) => {
                    let coordinates = JSON.parse(route.coordinates);
                    if (coordinates.length > 0) {
                        const latlngs = coordinates.map(p => [p[1], p[0]]); // [lat, lng]
                        const polyline = L.polyline(latlngs, {
                            color: route?.color || 'blue',
                            weight: 4
                        }).addTo(map);
                        polyline.bindPopup(`<b>${route.name}</b>`).openPopup();

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

                        // Ajustar el mapa al bounds de la primera ruta
                        if (index === 0) {
                            map.fitBounds(polyline.getBounds());
                        }
                    }
                });
                routesVisible = true;
            }

            function hideRoutes() {
                routeLayers.forEach(layer => map.removeLayer(layer));
                routeLayers = [];
                routesVisible = false;
            }

            // Botón para mostrar/ocultar rutas
            const toggleBtn = document.getElementById('toggleRoutesBtn');
            toggleBtn.addEventListener('click', function() {
                if (routesVisible) {
                    hideRoutes();
                    toggleBtn.textContent = 'Mostrar otras rutas';
                } else {
                    showRoutes();
                    toggleBtn.textContent = 'Ocultar otras rutas';
                }
            });

            // Inicialmente ocultas
            hideRoutes();


            let points = [];
            let polyline = L.polyline(points, {
                color: 'orange',
                weight: 4
            }).addTo(map);
            let pointMarkers = [];

            map.on('click', function(e) {
                points.push({
                    lat: e.latlng.lat,
                    lng: e.latlng.lng
                });
                polyline.setLatLngs(points);
                const marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
                pointMarkers.push(marker);
            });

            // Botón para eliminar el último punto
            document.getElementById('removeLastPointBtn').addEventListener('click', function() {
                if (points.length > 0) {
                    points.pop();
                    polyline.setLatLngs(points);
                    // Eliminar el último marcador
                    const marker = pointMarkers.pop();
                    if (marker) map.removeLayer(marker);
                }
            });

            // Botón para borrar toda la ruta
            document.getElementById('clearPolylineBtn').addEventListener('click', function() {
                points = [];
                polyline.setLatLngs(points);
                // Eliminar todos los marcadores
                pointMarkers.forEach(marker => map.removeLayer(marker));
                pointMarkers = [];
            });

            // Enviar puntos al backend como JSON
            const form = document.getElementById('routeForm');
            form.addEventListener('submit', function(e) {
                if (points.length < 2) {
                    e.preventDefault();
                    alert('Debe agregar al menos 2 puntos para la ruta.');
                    return;
                }
                document.getElementById('pathInput').value = JSON.stringify(points);
            });
        });
    </script>
@endpush
