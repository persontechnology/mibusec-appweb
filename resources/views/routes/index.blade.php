@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('routes.index') }}
@endsection

@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0">
        <a href="{{ route('routes.create') }}" class="d-flex align-items-center text-body py-2">
            <i class="fa-solid fa-plus me-1"></i>
            Nuevo
        </a>

    </div>
@endsection


@section('content')

    <div class="row">
        <!-- Sidebar personalizado -->
        <div class="col-md-4 col-sm-12 col-lg-3 card p-3" id="custom-sidebar" style="transition: all 0.3s ease;">
            <!-- Header del sidebar -->
            <div class="sidebar-section sidebar-section-body d-flex align-items-center pb-2">
                <h5 class="mb-0">Navigation</h5>

            </div>

            @if (isset($routes) && $routes->count() > 0)
                <!-- Búsqueda -->
                <div class="sidebar-section">

                    <div class="sidebar-section-body" action="#">
                        <div class="form-control-feedback form-control-feedback-end">
                            <input type="search" class="form-control" id="search-routes" placeholder="Buscar ruta...">
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de rutas -->
                <div class="sidebar-section">
                    <div class="table-responsive" style="{{ $routes->count() < 5 ? 'height: 400px;' : '' }}">
                        <table class="table text-nowrap">
                            @foreach ($routes as $route)
                                <tr>

                                    <td class="text-center">
                                        <h6 class="mb-0">{{ $route->stops_count }}</h6>
                                        <div class="fs-sm text-muted lh-1">paradas</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#"
                                                class="d-inline-flex align-items-center justify-content-center {{ $route->color ? '' : 'bg-teal' }} text-white lh-1 rounded-pill w-40px h-40px me-3"
                                                style="background-color: {{ $route->color }};">
                                                <span class="letter-icon">
                                                    {{ strtoupper(substr($route->name, 0, 2)) }}
                                                </span>
                                            </a>
                                            <div>
                                                <a href="#" class="te text-info fw-semibold letter-icon-title">
                                                    {{ $route->name }}
                                                </a>
                                                <div class="d-flex align-items-center text-muted fs-sm">
                                                    <span class="bg-danger rounded-pill p-1 me-2"></span>
                                                    {{ $route->code }}
                                                    <span class="ms-3 view-route" data-id="{{ $route->id }}"
                                                        style="cursor: pointer;" title="Ver en el mapa">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a href="#" class="text-body" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ph-list"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('routes.stops.index', $route->id) }}"
                                                    class="dropdown-item">
                                                    <i class="ph-arrow-bend-up-left me-2"></i>Paradas
                                                </a>
                                                <a href="#" class="dropdown-item">
                                                    <i class="ph-clock-counter-clockwise me-2"></i> Full history
                                                </a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @else
                <x-notData />
            @endif
        </div>

        <!-- Contenido principal -->
        <div class="col-md-8 col-sm-12 col-lg-9">
            <div class="card p-4">
                <div id="map" style="width:100%; height:80vh; min-height:400px;"></div>
            </div>
        </div>
    </div>

    <!-- Script para togglear el sidebar personalizado -->



@endsection
@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-routes');
            const tableRows = document.querySelectorAll('table tr');

            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script>
        let routeLayers2 = {};
        let map;
        document.addEventListener('DOMContentLoaded', function() {
            map = L.map('map').setView([-0.180653, -78.467838], 15);
            const routes = @json($routes);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            let routeLayers = [];
            routes.forEach((route, index) => {
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
                    if (index === 0) {
                        map.fitBounds(polyline.getBounds());
                    }
                }
            });
        });
        // Clic en "ver más" para centrar la ruta
        document.querySelectorAll('.view-route').forEach(el => {
            el.addEventListener('click', function() {
                const routeId = this.dataset.id;
                const route = routeLayers2[routeId];

                if (route) {
                    map.fitBounds(route.bounds);
                    debugger
                    L.popup()
                        .setLatLng(route.center)
                        .setContent(`
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 20px; height: 4px; background-color: ${route.polyline.options.color}; border-radius: 2px;"></div>
                        <b>Ruta:</b> ${route.name}
                    </div>
                `)
                        .openOn(map);
                }
            });
        });
    </script>
@endpush
@section('styles')
    <style>
        #map {
            width: 100%;
            height: 80vh;
            min-height: 400px;
        }
    </style>
