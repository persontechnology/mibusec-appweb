@php
    $isEdit = $stop && $stop->exists;
    $lat = old('latitude', $stop->latitude ?? null);
    $lng = old('longitude', $stop->longitude ?? null);
@endphp

<div class="card shadow-sm">
    <div class="card-body p-4">
        <div class="row">

            {{-- CODE --}}
            <div class="col-md-4">
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-hashtag"></i>
                        </div>
                        <input type="text" id="code" name="code" placeholder="Code"
                            value="{{ old('code', $stop->code) }}"
                            class="form-control @error('code') is-invalid @enderror" required autofocus>
                        <label for="code">Code</label>
                        @error('code')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- NAME --}}
            <div class="col-md-8">
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <input type="text" id="name" name="name" placeholder="Name"
                            value="{{ old('name', $stop->name) }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        <label for="name">Name</label>
                        @error('name')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="col-12">
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-align-left"></i>
                        </div>
                        <textarea id="description" name="description" placeholder="Description" style="height: 120px"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $stop->description) }}</textarea>
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- LOCATION SEARCH --}}
            <div class="col-md-8">
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-search"></i>
                        </div>
                        <input type="text" id="location-search" name="location-search" placeholder="Search location"
                            value="{{ old('location-search', '') }}"
                            class="form-control @error('location-search') is-invalid @enderror">
                        <label for="location-search">Search Location</label>
                        @error('location-search')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ADDRESS --}}
            <div class="col-md-8">
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <input type="text" id="address" name="address" placeholder="Address"
                            value="{{ old('address', $stop->address) }}"
                            class="form-control @error('address') is-invalid @enderror">
                        <label for="address">Address</label>
                        @error('address')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- STATUS --}}
            <div class="col-md-4">
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-toggle-on"></i>
                        </div>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="" {{ old('status', $stop->status) === null ? 'selected' : '' }}>--
                            </option>
                            <option value="ACTIVE" {{ old('status', $stop->status) === 'ACTIVE' ? 'selected' : '' }}>
                                ACTIVE</option>
                            <option value="ANACTIVE"
                                {{ old('status', $stop->status) === 'ANACTIVE' ? 'selected' : '' }}>ANACTIVE</option>
                        </select>
                        <label for="status">Status</label>
                        @error('status')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- LATITUDE --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-compass"></i>
                        </div>
                        <input type="text" id="latitude" name="latitude" placeholder="Latitude"
                            value="{{ $lat }}" class="form-control @error('latitude') is-invalid @enderror"
                            readonly required>
                        <label for="latitude">Latitude</label>
                        @error('latitude')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- LONGITUDE --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-location-crosshairs"></i>
                        </div>
                        <input type="text" id="longitude" name="longitude" placeholder="Longitude"
                            value="{{ $lng }}" class="form-control @error('longitude') is-invalid @enderror"
                            readonly required>
                        <label for="longitude">Longitude</label>
                        @error('longitude')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- MAPA + GEOLOCATE --}}
            <div class="col-12">
                <div class="mb-2 d-flex gap-2 align-items-center alert alert-info">
                    <button class="btn btn-info btn-sm" type="button" id="btn-geolocate">Usar mi ubicación</button>
                    <small class="text-muted">O haz clic en el mapa para colocar el marcador.</small>
                </div>
                <div id="map" style="height: 360px; border-radius: .5rem; overflow: hidden;"></div>
            </div>

            {{-- NOTES --}}
            <div class="col-12">
                <div class="my-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-note-sticky"></i>
                        </div>
                        <textarea id="notes" name="notes" placeholder="Notes" style="height: 120px"
                            class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $stop->notes) }}</textarea>
                        <label for="notes">Notes</label>
                        @error('notes')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ACCIONES --}}
            <div class="col-12 d-flex justify-content-start gap-2">
                <a href="{{ route('stops.index') }}" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-dark">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
            </div>
        </div>
    </div>
</div>
@push('styles')
    <style>
        /* Estilos para el buscador dentro del mapa */
        .leaflet-control-geocoder {
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 0.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .leaflet-bar {
            margin-top: 10px;
        }

        /* Estilos para el marcador */
        .leaflet-marker-icon {
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            border: 2px solid #007bff;
        }

        /* Estilo para el botón de geolocalización */
        #btn-geolocate {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #btn-geolocate:hover {
            background-color: #0056b3;
        }
    </style>
@endpush

@prepend('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endprepend

@push('scripts')
    <script>
        (function() {
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const locationSearchInput = document.getElementById('location-search');

            // Mapa de Leaflet
            const map = L.map('map').setView([0, 0], 2); // Vista inicial

            // Cargar los tiles de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Crear el marcador
            let marker = L.marker([0, 0], {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function(e) {
                const latLng = e.target.getLatLng();
                latInput.value = latLng.lat.toFixed(6);
                lngInput.value = latLng.lng.toFixed(6);
            });

            // Geocodificador de Nominatim para buscar direcciones
            const geocoder = L.Control.Geocoder.nominatim();

            // Función de búsqueda de ubicación
            const searchControl = L.Control.geocoder({
                    geocoder: geocoder,
                    placeholder: 'Search location...',
                    errorMessage: 'Location not found',
                    collapse: true
                })
                .on('markgeocode', function(e) {
                    const lat = e.geocode.center.lat;
                    const lng = e.geocode.center.lng;

                    // Establecer la nueva latitud y longitud en los inputs
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);

                    // Mover el mapa y el marcador a la nueva ubicación
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                })
                .addTo(map);

            // Búsqueda de ubicación cuando se escribe en el input
            locationSearchInput.addEventListener('input', function() {
                const query = locationSearchInput.value;

                if (query.length >= 3) {
                    geocoder.geocode(query, function(results) {
                        if (results.length > 0) {
                            const firstResult = results[0];
                            locationSearchInput.value = firstResult.name;
                            const lat = firstResult.center.lat;
                            const lng = firstResult.center.lng;
                            latInput.value = lat.toFixed(6);
                            lngInput.value = lng.toFixed(6);
                            map.setView([lat, lng], 16);
                            marker.setLatLng([lat, lng]);
                        }
                    });
                }
            });

            // Geolocalización actual
            document.getElementById('btn-geolocate').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        latInput.value = lat.toFixed(6);
                        lngInput.value = lng.toFixed(6);
                        map.setView([lat, lng], 16);
                        marker.setLatLng([lat, lng]);
                    });
                } else {
                    alert('Geolocalización no soportada por tu navegador.');
                }
            });
        })();
    </script>
@endpush
