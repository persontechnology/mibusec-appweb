@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('vehicles.edit', $vehicle) }}
@endsection

@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0">
        <a href="{{ route('vehicles.index') }}" class="d-flex align-items-center text-body py-2">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Volver a vehículos
        </a>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <form class="form_global" action="{{ route('vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-0 shadow-sm">
                    <div class="card-body">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                {{-- Selección de agencia --}}
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select name="agency_id" id="agency_id" class="form-select @error('agency_id') is-invalid @enderror" required>
                                            <option value="">-- Selecciona una agencia --</option>
                                            @foreach($agencies as $agency)
                                                <option value="{{ $agency->id }}"
                                                    {{ (old('agency_id') ?? optional($vehicle->agencies->first())->id) == $agency->id ? 'selected' : '' }}>
                                                    {{ $agency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="agency_id">Agencia</label>
                                        @error('agency_id')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating form-control-feedback form-control-feedback-start">
                                        <div class="form-control-feedback-icon">
                                            <i class="fa-solid fa-barcode"></i>
                                        </div>
                                        <input type="text" name="codigo" id="codigo"
                                            class="form-control @error('codigo') is-invalid @enderror"
                                            value="{{ old('codigo', $vehicle->codigo) }}" required placeholder="Código">
                                        <label for="codigo">Código <span class="text-danger">*</span></label>
                                        @error('codigo')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating form-control-feedback form-control-feedback-start">
                                        <div class="form-control-feedback-icon">
                                            <i class="fa-solid fa-car-side"></i>
                                        </div>
                                        <input type="text" name="placa" id="placa"
                                            class="form-control @error('placa') is-invalid @enderror"
                                            value="{{ old('placa', $vehicle->placa) }}" required placeholder="Placa">
                                        <label for="placa">Placa <span class="text-danger">*</span></label>
                                        @error('placa')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating form-control-feedback form-control-feedback-start">
                                        <div class="form-control-feedback-icon">
                                            <i class="fa-solid fa-signature"></i>
                                        </div>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $vehicle->name) }}" placeholder="Nombre">
                                        <label for="name">Nombre</label>
                                        @error('name')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" name="marca" id="marca"
                                                class="form-control @error('marca') is-invalid @enderror"
                                                value="{{ old('marca', $vehicle->marca) }}" placeholder="Marca">
                                            <label for="marca">Marca</label>
                                            @error('marca')
                                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" name="modelo" id="modelo"
                                                class="form-control @error('modelo') is-invalid @enderror"
                                                value="{{ old('modelo', $vehicle->modelo) }}" placeholder="Modelo">
                                            <label for="modelo">Modelo</label>
                                            @error('modelo')
                                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="number" name="anio" id="anio"
                                                class="form-control @error('anio') is-invalid @enderror"
                                                value="{{ old('anio', $vehicle->anio) }}" placeholder="Año" min="1900" max="{{ date('Y')+1 }}">
                                            <label for="anio">Año</label>
                                            @error('anio')
                                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" name="color" id="color"
                                                class="form-control @error('color') is-invalid @enderror"
                                                value="{{ old('color', $vehicle->color) }}" placeholder="Color">
                                            <label for="color">Color</label>
                                            @error('color')
                                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <textarea name="observaciones" id="observaciones"
                                            class="form-control @error('observaciones') is-invalid @enderror"
                                            placeholder="Observaciones" style="height: 80px">{{ old('observaciones', $vehicle->observaciones) }}</textarea>
                                        <label for="observaciones">Observaciones</label>
                                        @error('observaciones')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" name="velocidad" id="velocidad"
                                            class="form-control @error('velocidad') is-invalid @enderror"
                                            value="{{ old('velocidad', $vehicle->velocidad) }}" placeholder="Velocidad">
                                        <label for="velocidad">Velocidad (km/h)</label>
                                        @error('velocidad')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mb-1">Ubicación en el mapa <span class="text-danger">*</span></label>
                                <div id="map" style="height: 320px; border-radius: 0.5rem; border:1px solid #dee2e6;"></div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <input type="text" name="latitud" id="latitud"
                                                class="form-control @error('latitud') is-invalid @enderror"
                                                value="{{ old('latitud', $vehicle->latitud) }}" placeholder="Latitud" readonly required>
                                            <label for="latitud">Latitud</label>
                                            @error('latitud')
                                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <input type="text" name="longitud" id="longitud"
                                                class="form-control @error('longitud') is-invalid @enderror"
                                                value="{{ old('longitud', $vehicle->longitud) }}" placeholder="Longitud" readonly required>
                                            <label for="longitud">Longitud</label>
                                            @error('longitud')
                                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-text mt-1 mb-3">Haz clic en el mapa para seleccionar la ubicación del vehículo.</div>
                                {{-- Campo de imagen después del mapa --}}
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Imagen (opcional)</label>
                                    <input 
                                        type="file" 
                                        name="foto" 
                                        id="foto"
                                        class="form-control @error('foto') is-invalid @enderror"
                                        accept="image/*"
                                    >
                                    @error('foto')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Tamaño máximo: 2MB. Tipos permitidos: jpg, jpeg, png, gif.</div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-check me-1"></i> Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@prepend('scripts')
    <script src="{{ asset('assets/js/vendor/uploaders/fileinput/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/uploaders/fileinput/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/uploaders/fileinput/fileinput_theme_fa6.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/uploaders/fileinput/fileinput_es.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/maps/leaflet/leaflet.min.js') }}"></script>
@endprepend

@push('scripts')
    <script>
        $(document).ready(function () {
            $("#foto").fileinput({
                theme: "fa6",
                showUpload: false,
                showRemove: true,
                showCaption: true,
                dropZoneEnabled: false,
                browseClass: "btn btn-secondary",
                fileActionSettings: {
                    showZoom: true,
                    zoomClass: "btn btn-sm btn-outline-secondary",
                    zoomIcon: '<i class="fa-solid fa-search-plus"></i>',
                },
                allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
                maxFileSize: 2048,
                maxFilesNum: 1,
                initialPreviewAsData: true,
                overwriteInitial: true,
                language: "es",
                @if($vehicle->foto)
                initialPreview: [
                    "{{ asset('storage/' . $vehicle->foto) }}"
                ],
                initialPreviewConfig: [
                    {
                        caption: "{{ $vehicle->codigo }}", 
                        key: 1, 
                        downloadUrl: "{{ asset('storage/' . $vehicle->foto) }}",
                        // ocultar el ícono de eliminar
                        showRemove: false,
                        showDrag: false,
                        showZoom: true,
                    }
                ],
                @endif
            });

            // Leaflet map
            var defaultLat = {{ old('latitud', $vehicle->latitud ?? '-2.170998') }};
            var defaultLng = {{ old('longitud', $vehicle->longitud ?? '-79.922359') }};
            var map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var marker = null;
            function setMarker(lat, lng) {
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {draggable:true}).addTo(map);
                    marker.on('dragend', function(e) {
                        var pos = marker.getLatLng();
                        $('#latitud').val(pos.lat.toFixed(6));
                        $('#longitud').val(pos.lng.toFixed(6));
                    });
                }
                $('#latitud').val(lat.toFixed(6));
                $('#longitud').val(lng.toFixed(6));
            }

            // Si hay valores previos, poner el marker
            if ($('#latitud').val() && $('#longitud').val()) {
                setMarker(parseFloat($('#latitud').val()), parseFloat($('#longitud').val()));
            } else {
                setMarker(defaultLat, defaultLng);
            }

            map.on('click', function(e) {
                setMarker(e.latlng.lat, e.latlng.lng);
            });
        });
    </script>
@endpush