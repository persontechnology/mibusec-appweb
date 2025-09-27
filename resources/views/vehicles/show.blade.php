@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('vehicles.show', $vehicle) }}
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
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0 position-relative">
                   
                    <small class="text-muted d-block mt-1">
                        @if(!$vehicle->deleted_at)
                            <i class="fa-solid fa-circle-check text-success"></i> Vehículo activo
                        @else
                            <i class="fa-solid fa-circle-xmark text-danger"></i> Vehículo eliminado
                        @endif
                    </small>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @php
                            $src = null;
                            if (!empty($vehicle->foto)) {
                                if (\Illuminate\Support\Str::startsWith($vehicle->foto, ['http://','https://'])) {
                                    $src = $vehicle->foto;
                                } else {
                                    $src = \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($vehicle->foto);
                                }
                            }
                        @endphp
                        @if($src)
                            <img src="{{ $src }}" class="rounded-circle object-fit-cover me-3 border" width="64" height="64" alt="Foto del vehículo {{ $vehicle->placa }}" loading="lazy">
                        @else
                            <div class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center me-3"
                                 style="width:64px;height:64px;" title="Código: {{ $vehicle->codigo }}">
                                <span class="text-muted fw-bold" style="font-size: 1.5rem;">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($vehicle->codigo,0,1)) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <h4 class="mb-0 d-flex align-items-center gap-2">
                                {{ $vehicle->placa ?? $vehicle->codigo ?? 'Sin identificar' }}
                                <button type="button"
                                    class="btn btn-sm btn-outline-secondary py-0 px-2 ms-1 btn-copy"
                                    title="Copiar {{ $vehicle->placa ?? $vehicle->codigo }} al portapapeles"
                                    data-copy="{{ $vehicle->placa ?? $vehicle->codigo }}">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </h4>
                            @if($vehicle->name)
                                <div class="text-truncate" style="max-width: 250px;">
                                    <i class="fa-solid fa-car me-1"></i>
                                    {{ $vehicle->name }}
                                </div>
                            @endif
                            <small class="text-muted d-block">
                                <i class="ph-hash me-1"></i>
                                {{ $vehicle->codigo }}
                            </small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <strong>Marca:</strong> {{ $vehicle->marca ?? '—' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Modelo:</strong> {{ $vehicle->modelo ?? '—' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Año:</strong> {{ $vehicle->anio ?? '—' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Color:</strong> {{ $vehicle->color ?? '—' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Velocidad:</strong> {{ number_format((float)($vehicle->velocidad ?? 0), 1) }} km/h
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Actualizado:</strong> {{ optional($vehicle->updated_at)->diffForHumans() }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <strong>Observaciones:</strong>
                        <div class="text-muted">{{ $vehicle->observaciones ?? '—' }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Agencia:</strong>
                            @php
                                $agency = $vehicle->agencies->first();
                            @endphp
                            @if($agency)
                                <span class="badge bg-secondary" title="Agencia: {{ $agency->name }}">
                                    <i class="fa-solid fa-building me-1"></i>
                                    {{ $agency->name }}
                                </span>
                            @else
                                <span class="text-muted">Sin agencia asignada</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Ubicación:</strong>
                            @if($vehicle->latitud && $vehicle->longitud)
                                <a class="link-primary text-nowrap" target="_blank" rel="noopener"
                                   href="https://www.google.com/maps?q={{ $vehicle->latitud }},{{ $vehicle->longitud }}"
                                   aria-label="Ver ubicación en el mapa">
                                    <i class="fa-solid fa-map-location-dot me-1"></i>
                                    Ver en mapa
                                </a>
                                <span class="text-muted ms-2 text-nowrap">
                                    <i class="fa-solid fa-location-crosshairs me-1"></i>
                                    {{ number_format($vehicle->latitud, 6) }}, {{ number_format($vehicle->longitud, 6) }}
                                </span>
                            @else
                                <span class="text-muted">Sin ubicación</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if($vehicle->deleted_at)
                    <div class="card-footer bg-danger text-white">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i>
                        Este vehículo está eliminado. Puedes restaurarlo desde el menú de acciones.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-copy').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const text = btn.getAttribute('data-copy');
            // Modern API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function() {
                    feedback(btn);
                }, function() {
                    fallbackCopy(text, btn);
                });
            } else {
                fallbackCopy(text, btn);
            }
        });
    });

    function fallbackCopy(text, btn) {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.setAttribute('readonly', '');
        textarea.style.position = 'absolute';
        textarea.style.left = '-9999px';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            feedback(btn);
        } catch (err) {
            alert('No se pudo copiar al portapapeles');
        }
        document.body.removeChild(textarea);
    }

    function feedback(btn) {
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        btn.innerHTML = '<i class="fa-solid fa-check"></i>';
        setTimeout(function() {
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
            btn.innerHTML = '<i class="fa-regular fa-copy"></i>';
        }, 1200);
    }
});
</script>
@endpush