
@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('vehicles.show',$vehicle) }}
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
              
              <a href="{{ route('vehicles.edit',$vehicle) }}" class="dropdown-item">
                  <i class="ph-pencil me-2"></i>
                  Editar
              </a>
              
              <a href="#" class="dropdown-item" onclick="event.preventDefault(); deleteGlobal(this);" data-url="{{ route('vehicles.destroy',$vehicle) }}" data-info="{{ $vehicle->license_plate }}">
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
          @php
            $status  = $vehicle->status ?: '--';
            $badge   = match($status) {
              'ACTIVE' => 'bg-success',
              'ANACTIVE' => 'bg-danger',
              default => 'bg-light text-dark'
            };
          @endphp

          <div class="d-flex align-items-start justify-content-between mb-2">
            <div>
              <div class="text-muted small">Placa</div>
              <div class="fs-5 fw-semibold d-flex align-items-center gap-2">
                <span id="plate-text">{{ $vehicle->license_plate }}</span>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-copy-plate" title="Copiar placa">
                  <i class="fa-regular fa-copy"></i>
                </button>
              </div>
            </div>
            <span class="badge {{ $badge }} align-self-start px-3 py-2">
              <i class="fa-solid fa-toggle-on me-1"></i>{{ $status }}
            </span>
          </div>

          <hr class="my-3">

          <dl class="row mb-0">
            <dt class="col-sm-4"><i class="fa-solid fa-tag me-1"></i> Nombre</dt>
            <dd class="col-sm-8">{{ $vehicle->name }}</dd>

            <dt class="col-sm-4"><i class="fa-solid fa-align-left me-1"></i> Descripción</dt>
            <dd class="col-sm-8">
              @if(trim((string)$vehicle->description) !== '')
                <p class="mb-0">{{ $vehicle->description }}</p>
              @else
                <span class="text-muted">Sin descripción</span>
              @endif
            </dd>

            <dt class="col-sm-4"><i class="fa-solid fa-people-group me-1"></i> Capacidad</dt>
            <dd class="col-sm-8">{{ $vehicle->capacity ?: '—' }}</dd>
          </dl>
        </div>
      </div>
    </div>

    {{-- CARD METADATOS / ACCIONES --}}
    <div class="col-lg-6">
      <div class="card shadow-sm h-100">
        <div class="card-body p-4">
          <h2 class="h6 text-uppercase text-muted mb-3">Información adicional</h2>
          <ul class="list-unstyled mb-4">
            <li class="mb-2">
              <i class="fa-regular fa-calendar-plus me-2"></i>
              <span class="text-muted">Creado:</span>
              <span class="fw-semibold">{{ optional($vehicle->created_at)->format('Y-m-d H:i') }} </span>
              {{-- direncia humans --}}
                <span class="text-muted">({{ optional($vehicle->created_at)->diffForHumans() }})</span>
            </li>
            <li>
              <i class="fa-regular fa-clock me-2"></i>
              <span class="text-muted">Actualizado:</span>
              <span class="fw-semibold">{{ optional($vehicle->updated_at)->format('Y-m-d H:i') }}</span>
                {{-- direncia humans --}}
                <span class="text-muted">({{ optional($vehicle->updated_at)->diffForHumans() }})</span> 
            </li>
          </ul>

      
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
          @if(trim((string)$vehicle->notes) !== '')
            <p class="mb-0">{{ $vehicle->notes }}</p>
          @else
            <span class="text-muted">Sin notas</span>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Copiar placa al portapapeles (UX similar a la que usamos antes)
  (function () {
    const plateBtn = document.getElementById('btn-copy-plate');
    const plateText = document.getElementById('plate-text');
    plateBtn?.addEventListener('click', async () => {
      const text = plateText?.textContent?.trim();
      if (!text) return;
      try {
        await navigator.clipboard.writeText(text);
        plateBtn.classList.remove('btn-outline-secondary');
        plateBtn.classList.add('btn-success');
        plateBtn.innerHTML = '<i class="fa-solid fa-check"></i>';
        setTimeout(() => {
          plateBtn.classList.add('btn-outline-secondary');
          plateBtn.classList.remove('btn-success');
          plateBtn.innerHTML = '<i class="fa-regular fa-copy"></i>';
        }, 1500);
      } catch {
        alert('No se pudo copiar al portapapeles.');
      }
    });
  })();
</script>
@endpush
