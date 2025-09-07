
@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('stops.show',$stop) }}
@endsection


@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0">
      

        <div class="dropdown ms-lg-3">
            <a href="#" class="d-flex align-items-center text-body dropdown-toggle py-2" data-bs-toggle="dropdown">
                <i class="ph-gear me-1"></i>
                <span class="flex-1">
                  Opciones
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end w-100 w-lg-auto">
              
              <a href="{{ route('stops.edit',$stop) }}" class="dropdown-item">
                  <i class="ph-pencil me-2"></i>
                  Editar
              </a>
              
              <a href="#" class="dropdown-item" onclick="event.preventDefault(); deleteGlobal(this);" data-url="{{ route('stops.destroy',$stop) }}" data-info="{{ $stop->code }}">
                  <i class="ph-trash me-2"></i>
                  Eliminar
              </a>
            </div>
        </div>
    </div>
@endsection


@section('content')
<div class="container py-4" style="max-width: 1080px;">
  <div class="row g-4">
    {{-- CARD DATOS PRINCIPALES --}}
    <div class="col-lg-6">
      <div class="card shadow-sm h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-start justify-content-between">
            <div>
              <div class="text-muted small">Código</div>
              <div class="fs-5 fw-semibold">{{ $stop->code }}</div>
            </div>
            @php
              $status = $stop->status ?: '--';
              $badgeClass = match($status) {
                'ACTIVE'   => 'bg-success',
                'ANACTIVE' => 'bg-danger',
                default    => 'bg-light text-dark'
              };
            @endphp
            <span class="badge {{ $badgeClass }} align-self-start px-3 py-2">
              <i class="fa-solid fa-toggle-on me-1"></i>{{ $status }}
            </span>
          </div>

          <hr class="my-3">

          <dl class="row mb-0">
            <dt class="col-sm-4"><i class="fa-solid fa-tag me-1"></i> Nombre</dt>
            <dd class="col-sm-8">{{ $stop->name }}</dd>

            <dt class="col-sm-4"><i class="fa-solid fa-location-dot me-1"></i> Dirección</dt>
            <dd class="col-sm-8">{{ $stop->address ?: '—' }}</dd>

            <dt class="col-sm-4"><i class="fa-solid fa-align-left me-1"></i> Descripción</dt>
            <dd class="col-sm-8">
              @if(trim((string)$stop->description) !== '')
                <p class="mb-0">{{ $stop->description }}</p>
              @else
                <span class="text-muted">Sin descripción</span>
              @endif
            </dd>
          </dl>
        </div>
      </div>
    </div>

    {{-- CARD COORDENADAS + ACCIONES --}}
    <div class="col-lg-6">
      <div class="card shadow-sm h-100">
        <div class="card-body p-4">
          @php
            $lat = is_numeric($stop->latitude) ? number_format($stop->latitude, 6) : null;
            $lng = is_numeric($stop->longitude) ? number_format($stop->longitude, 6) : null;
            $hasCoords = $lat !== null && $lng !== null;
          @endphp

          <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted small">Coordenadas:</span>
              <span id="coords-text" class="fw-semibold">
                {{ $hasCoords ? "$lat, $lng" : '--' }}
              </span>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-secondary btn-sm" id="btn-copy-coords" type="button" {{ $hasCoords ? '' : 'disabled' }}>
                <i class="fa-regular fa-copy me-1"></i> Copiar
              </button>
              @if($hasCoords)
                <a
                  class="btn btn-outline-primary btn-sm"
                  target="_blank"
                  rel="noopener"
                  href="https://www.google.com/maps?q={{ $stop->latitude }},{{ $stop->longitude }}">
                  <i class="fa-solid fa-map-location-dot me-1"></i> Abrir en Maps
                </a>
              @endif
            </div>
          </div>

          <div id="map-show" style="height: 360px; border-radius: .5rem; overflow: hidden;"></div>
        </div>
      </div>
    </div>

    {{-- CARD NOTAS --}}
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-header bg-white">
          <i class="fa-solid fa-note-sticky me-1"></i> Notas
        </div>
        <div class="card-body">
          @if(trim((string)$stop->notes) !== '')
            <p class="mb-0">{{ $stop->notes }}</p>
          @else
            <span class="text-muted">Sin notas</span>
          @endif
        </div>
      </div>
    </div>

    {{-- CARD INFORMACION ADICIONAL, CREATED AND UPDATE INFO --}}
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-header bg-white">
          <i class="fa-solid fa-circle-info me-1"></i> Información adicional
        </div>
        <div class="card-body">
          <dl class="row mb-0">
            <dt class="col-sm-3"><i class="fa-solid fa-calendar-plus me-1"></i> Creado</dt>
            <dd class="col-sm-9">
              @if($stop->created_at)
                {{ $stop->created_at->format('d/m/Y H:i') }}
                <span class="text-muted small">({{ $stop->created_at->diffForHumans() }})</span>
              @else
                —
              @endif
            </dd>
            <dt class="col-sm-3"><i class="fa-solid fa-clock me-1"></i> Actualizado</dt>
            <dd class="col-sm-9">
              @if($stop->updated_at)
                {{ $stop->updated_at->format('d/m/Y H:i') }}
                <span class="text-muted small">({{ $stop->updated_at->diffForHumans() }})</span>
              @else
                —
              @endif
            </dd>
          </dl> 
        </div>
      </div>
  </div>
  
</div>
@endsection


@prepend('scripts')
  <script src="{{ asset('assets/js/vendor/maps/leaflet/leaflet.min.js') }}"></script>
@endprepend

@push('scripts')
  {{-- Leaflet JS --}}
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
          integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    (function () {
      const lat = parseFloat(@json($stop->latitude));
      const lng = parseFloat(@json($stop->longitude));
      const hasCoords = !isNaN(lat) && !isNaN(lng);

      const map = L.map('map-show', { zoomControl: true, dragging: true, scrollWheelZoom: true });
      map.setView(hasCoords ? [lat, lng] : [0, 0], hasCoords ? 15 : 2);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
      }).addTo(map);

      if (hasCoords) {
        L.marker([lat, lng]).addTo(map);
      }

      // Copiar coordenadas
      const copyBtn = document.getElementById('btn-copy-coords');
      const coordsText = document.getElementById('coords-text');
      copyBtn?.addEventListener('click', async () => {
        const text = coordsText?.textContent?.trim();
        if (!text || text === '--') return;
        try {
          await navigator.clipboard.writeText(text);
          copyBtn.classList.remove('btn-outline-secondary');
          copyBtn.classList.add('btn-success');
          copyBtn.innerHTML = '<i class="fa-solid fa-check me-1"></i> Copiado';
          setTimeout(() => {
            copyBtn.classList.add('btn-outline-secondary');
            copyBtn.classList.remove('btn-success');
            copyBtn.innerHTML = '<i class="fa-regular fa-copy me-1"></i> Copiar';
          }, 1500);
        } catch {
          alert('No se pudo copiar al portapapeles.');
        }
      });
    })();
  </script>
@endpush
