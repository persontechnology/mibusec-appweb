@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('vehicles.index') }}
@endsection

@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0 flex-wrap gap-2">
        <a href="{{ route('vehicles.create') }}" class="d-flex align-items-center text-body py-2">
            <i class="fa-solid fa-plus me-1"></i>
            Nuevo
        </a>
        <div class="dropdown ms-lg-3">
            <a href="#" class="d-flex align-items-center text-body dropdown-toggle py-2" data-bs-toggle="dropdown">
                <i class="ph-gear me-2"></i>
                <span class="flex-1">Configuración</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end w-100 w-lg-auto">
                <a href="{{ route('api.getdevices') }}" class="dropdown-item">
                    <i class="fa-solid fa-car me-2"></i>
                    Obtener vehículos de API externa
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container py-3">


  <div class="row mb-4">
  <div class="col-12">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <form method="GET" class="row gx-3 gy-2 align-items-end" role="search" aria-label="Buscar vehículos">
          <!-- Buscar -->
          <div class="col-12 col-md-6 col-xl-4">
            <label for="q" class="form-label mb-1">Buscar</label>
            <div class="input-group">
              <span class="input-group-text" id="q-addon">
                <i class="fa-solid fa-magnifying-glass"></i>
              </span>
              <input
                type="text"
                class="form-control"
                name="q"
                id="q"
                aria-describedby="q-addon"
                value="{{ request('q') }}"
                placeholder="Placa, Código, Nombre, Marca o Modelo">
            </div>
          </div>

          <!-- Agencia -->
          <div class="col-12 col-sm-6 col-md-3 col-xl-3">
            <label for="agency" class="form-label mb-1">Agencia</label>
            <select name="agency" id="agency" class="form-select">
              <option value="">Todas</option>
              @foreach($agencies as $agency)
                <option value="{{ $agency->id }}" {{ request('agency') == $agency->id ? 'selected' : '' }}>
                  {{ $agency->name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Estado -->
          <div class="col-12 col-sm-6 col-md-3 col-xl-3">
            <label for="estado" class="form-label mb-1">Estado</label>
            <select name="estado" id="estado" class="form-select">
              <option value="activo" {{ $estado === 'activo' ? 'selected' : '' }}>Activo</option>
              <option value="eliminado" {{ $estado === 'eliminado' ? 'selected' : '' }}>Eliminado</option>
              <option value="" {{ $estado === '' ? 'selected' : '' }}>Todos</option>
            </select>
          </div>

          <!-- Acciones -->
          <div class="col-12 col-xl-2">
            <div class="d-grid gap-2 d-xl-flex flex-xl-wrap justify-content-xl-end align-items-xl-center">
              <!-- Mismo estilo de botón -->
              <button class="btn btn-primary w-100 w-xl-auto flex-shrink-0" type="submit">
                <i class="fa-solid fa-search me-1"></i>
                <span class="d-none d-sm-inline">Buscar.</span>
              </button>

              @if(request()->has('q') || request()->has('agency') || request()->has('estado'))
                <!-- MISMA CLASE: btn btn-primary -->
                <a href="{{ route('vehicles.index') }}"
                   class="btn btn-outline-primary w-100 w-xl-auto flex-shrink-0"
                   title="Limpiar filtros" aria-label="Limpiar filtros">
                  <i class="fa-solid fa-rotate-left me-1"></i>
                  <!-- En XL se oculta el texto para no ensanchar -->
                  <span class="d-none d-xl-inline">Limpiar</span>
                </a>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  {{-- Cards de vehículos --}}
  @if(isset($vehicles) && $vehicles->count())

  


    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
      @foreach($vehicles as $v)
      <div class="col d-flex">
        <div class="card shadow-sm h-100 w-100 {{ $v->deleted_at ? 'border-danger' : 'border-success' }}">
          <div class="card-header bg-transparent border-0 pb-0 position-relative">
            <div class="d-flex align-items-center flex-wrap gap-2">
              <span class="badge bg-info text-dark">Vehículo</span>
              @if($v->deleted_at)
                <span class="badge bg-danger">Eliminado</span>
              @else
                <span class="badge bg-success">Activo</span>
              @endif
            </div>
            <small class="text-muted d-block mt-1">
              @if(!$v->deleted_at)
                <i class="fa-solid fa-circle-check text-success"></i> Vehículo activo
              @else
                <i class="fa-solid fa-circle-xmark text-danger"></i> Vehículo eliminado
              @endif
            </small>
            <div class="dropdown position-absolute end-0 top-0 mt-2 me-2">
              <a href="#" class="text-body" data-bs-toggle="dropdown" aria-label="Acciones">
                <i class="ph-gear"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a href="{{ route('vehicles.show', $v) }}" class="dropdown-item">
                  <i class="fa-solid fa-eye me-2"></i> Ver detalles
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('vehicles.edit', $v) }}" class="dropdown-item">
                  <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                </a>
                @if(empty($v->deleted_at))
                  <button type="button" class="dropdown-item"
                          onclick="deleteGlobal(this)"
                          data-url="{{ route('vehicles.destroy', $v) }}"
                          data-info="El vehículo {{ $v->placa ?? $v->codigo }} se enviará a la papelera.">
                    <i class="fa-solid fa-trash me-2"></i> Eliminar
                  </button>
                @else
                  <button type="button" class="dropdown-item"
                          onclick="restoreGlobal(this)"
                          data-url="{{ route('vehicles.restore', $v->id) }}"
                          data-info="{{ $v->placa ? 'El vehículo '.$v->placa : 'Este vehículo' }} se restaurará y volverá a estar activo.">
                    <i class="ph-arrow-u-up-left me-2"></i> Restaurar
                  </button>
                  <button type="button" class="dropdown-item text-danger"
                          onclick="deleteGlobal(this)"
                          data-url="{{ route('vehicles.forceDelete', $v->id) }}"
                          data-info="{{ $v->placa ? 'El vehículo '.$v->placa : 'Este vehículo' }} se eliminará permanentemente y no podrá ser restaurado.">
                    <i class="fa-solid fa-trash-can me-2"></i> Eliminar permanentemente
                  </button>
                @endif
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              @php
                $src = null;
                if (!empty($v->foto)) {
                    if (\Illuminate\Support\Str::startsWith($v->foto, ['http://','https://'])) {
                        $src = $v->foto;
                    } else {
                        $src = \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($v->foto);
                    }
                }
              @endphp
              @if($src)
                <img src="{{ $src }}" class="rounded-circle object-fit-cover me-3 border" width="48" height="48" alt="Foto del vehículo {{ $v->placa }}" loading="lazy">
              @else
                <div class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center me-3"
                     style="width:48px;height:48px;" title="Código: {{ $v->codigo }}">
                  <span class="text-muted fw-bold" style="font-size: 1.25rem;">
                    {{ strtoupper(\Illuminate\Support\Str::substr($v->codigo,0,1)) }}
                  </span>
                </div>
              @endif
              <div>
                <h5 class="mb-0 d-flex align-items-center gap-2">
                  <a href="{{ route('vehicles.show', $v) }}" class="text-decoration-none text-dark">
                    {{ $v->placa ?? $v->codigo ?? 'Sin identificar' }}
                  </a>
                  <button type="button"
                    class="btn btn-sm btn-outline-secondary py-0 px-2 ms-1 btn-copy"
                    title="Copiar {{ $v->placa ?? $v->codigo }} al portapapeles"
                    data-copy="{{ $v->placa ?? $v->codigo }}">
                    <i class="fa-regular fa-copy"></i>
                  </button>
                </h5>
                @if($v->name)
                  <div class="text-truncate" style="max-width: 200px;">
                    <i class="fa-solid fa-car me-1"></i>
                    {{ $v->name }}
                  </div>
                @endif
                <small class="text-muted d-block">
                  <i class="ph-hash me-1"></i>
                  {{ $v->codigo }}
                </small>
              </div>
            </div>
            <div class="mb-2">
              @if($v->anio)
                <span class="me-3"><i class="fa-solid fa-calendar me-1"></i>{{ $v->anio }}</span>
              @endif
              @if($v->color)
                <span class="me-3"><i class="fa-solid fa-palette me-1"></i>{{ $v->color }}</span>
              @endif
              @unless($v->anio || $v->color)
                <span class="text-muted">Sin datos principales</span>
              @endunless
            </div>
            <div class="mb-2">
              <span class="me-3">
                <i class="fa-solid fa-gauge-high me-1"></i>
                Velocidad: {{ number_format((float)($v->velocidad ?? 0), 1) }} km/h
              </span>
            </div>
            <div class="mb-0">
              <span class="text-muted">
                <i class="ph-clock me-1"></i>
                Actualizado: {{ optional($v->updated_at)->diffForHumans() }}
              </span>
            </div>
            @if($v->deleted_at)
              <div class="alert alert-danger py-1 px-2 mt-2 small">
                Este vehículo está eliminado. Puedes restaurarlo desde el menú.
              </div>
            @endif
          </div>
          <div class="card-footer bg-transparent small">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 w-100">
              @php
                $agency = $v->agencies->first();
              @endphp
              <div class="text-truncate">
                @if($agency)
                  <p class="text-dark fw-bold mb-0" title="Agencia: {{ $agency->name }}">
                    <i class="fa-solid fa-building me-1"></i>
                    {{ $agency->name }}
                  </p>
                @else
                  <p class="text-muted mb-0">Sin agencia asignada</p>
                @endif
              
                @if($v->latitud && $v->longitud)
                  <a class="link-primary text-nowrap text-muted text-truncate" target="_blank" rel="noopener"
                     href="https://www.google.com/maps?q={{ $v->latitud }},{{ $v->longitud }}"
                     aria-label="Ver ubicación de {{ $v->placa ?? $v->codigo }} en el mapa">
                    <i class="fa-solid fa-map-location-dot me-1"></i>
                    Ver en mapa
                  </a>
                  <p class="text-muted ms-2 text-nowrap d-none d-md-inline mb-0">
                    <i class="fa-solid fa-location-crosshairs me-1"></i>
                    {{ number_format($v->latitud, 6) }}, {{ number_format($v->longitud, 6) }}
                  </p>
                @else
                  <p class="text-muted mb-0">Sin ubicación</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-3">
      {{ $vehicles->links('pagination::bootstrap-5') }}
    </div>
  @else
    <div class="alert alert-info">No hay vehículos para mostrar.</div>
  @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-copy').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const text = btn.getAttribute('data-copy');
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
