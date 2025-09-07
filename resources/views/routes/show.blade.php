
@extends('layouts.app')

 
@section('breadcrumb')
    {{ Breadcrumbs::render('routes.show',$route) }}
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
              
              <a href="{{ route('routes.edit',$route) }}" class="dropdown-item">
                  <i class="ph-pencil me-2"></i>
                  Editar
              </a>
              
              <a href="#" class="dropdown-item" onclick="event.preventDefault(); deleteGlobal(this);" data-url="{{ route('routes.destroy',$route) }}" data-info="{{ $route->code }}">
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
    <div class="col-lg-7">
      <div class="card shadow-sm h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-start justify-content-between">
            <div>
              <div class="text-muted small">Código</div>
              <div class="fs-5 fw-semibold d-flex align-items-center gap-2">
                <span id="code-text">{{ $route->code }}</span>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-copy-code" title="Copiar código">
                  <i class="fa-regular fa-copy"></i>
                </button>
              </div>
            </div>
          </div>

          <hr class="my-3">

          <dl class="row mb-0">
            <dt class="col-sm-4"><i class="fa-solid fa-tag me-1"></i> Nombre</dt>
            <dd class="col-sm-8">{{ $route->name ?: '—' }}</dd>

            <dt class="col-sm-4"><i class="fa-solid fa-align-left me-1"></i> Descripción</dt>
            <dd class="col-sm-8">
              @if(trim((string)$route->description) !== '')
                <p class="mb-0">{{ $route->description }}</p>
              @else
                <span class="text-muted">Sin descripción</span>
              @endif
            </dd>
          </dl>
        </div>
      </div>
    </div>

    {{-- CARD METADATOS / ACCIONES --}}
    <div class="col-lg-5">
      <div class="card shadow-sm h-100">
        <div class="card-body p-4">
          <h2 class="h6 text-uppercase text-muted mb-3">Información adicional</h2>
          <ul class="list-unstyled mb-4">
            <li class="mb-2">
              <i class="fa-regular fa-calendar-plus me-2"></i>
              <span class="text-muted">Creado:</span>
              <span class="fw-semibold">{{ optional($route->created_at)->format('Y-m-d H:i') }}</span>
            <span class="text-muted"> ({{ $route->created_at->diffForHumans() }})</span>    
            </li>
            <li>
              <i class="fa-regular fa-clock me-2"></i>
              <span class="text-muted">Actualizado:</span>
              <span class="fw-semibold">{{ optional($route->updated_at)->format('Y-m-d H:i') }}</span>
                <span class="text-muted"> ({{ $route->updated_at->diffForHumans() }})</span>
            </li>
          </ul>

         
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Copiar código al portapapeles (UX consistente)
  (function () {
    const btn = document.getElementById('btn-copy-code');
    const textEl = document.getElementById('code-text');
    btn?.addEventListener('click', async () => {
      const text = textEl?.textContent?.trim();
      if (!text) return;
      try {
        await navigator.clipboard.writeText(text);
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        btn.innerHTML = '<i class="fa-solid fa-check"></i>';
        setTimeout(() => {
          btn.classList.add('btn-outline-secondary');
          btn.classList.remove('btn-success');
          btn.innerHTML = '<i class="fa-regular fa-copy"></i>';
        }, 1500);
      } catch {
        alert('No se pudo copiar al portapapeles.');
      }
    });
  })();
</script>
@endpush
