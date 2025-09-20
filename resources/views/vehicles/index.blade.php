@extends('layouts.app')

@push('styles')
<style>
  .status-dot{display:inline-block;width:.75rem;height:.75rem;border-radius:50%}
  .object-fit-cover{object-fit:cover}
</style>
@endpush

@section('content')
<div class="container py-3">
  <div class="d-flex align-items-center justify-content-between mb-3">
    {{-- enlace api getdevices --}}
    <a href="{{ route('api.getdevices') }}" class="btn btn-outline-primary">Actualizar lista</a>
    
    <h1 class="h4 mb-0">Vehículos</h1>
    <form method="GET" class="d-flex gap-2" role="search" aria-label="Buscar vehículos">
      <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Buscar por placa, nombre, marca o modelo">
      <button class="btn btn-primary">Buscar</button>
      @if(request('q'))
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">Limpiar</a>
      @endif
    </form>
  </div>

  @if(isset($vehicles) && $vehicles->count())
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">
      @foreach($vehicles as $v)
      <div class="col">
        <div class="card shadow-sm h-100 {{ $v->deleted_at ? 'border-danger' : 'border-success' }}">
          <div class="card-header bg-transparent border-0 pb-0 d-flex align-items-center">
            <span class="badge bg-info text-dark me-2">Vehículo</span>
            @if($v->deleted_at)
              <span class="badge bg-danger">Eliminado</span>
            @else
              <span class="badge bg-success">Activo</span>
            @endif
            <div class="dropdown ms-auto">
              <a href="#" class="text-body" data-bs-toggle="dropdown">
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
                          data-info="{{ $v->placa ? 'El vehículo '.$v->placa : 'Este vehículo' }} se enviará a la papelera.">
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
                     style="width:48px;height:48px;">
                  <span class="text-muted" style="font-size: 1.25rem;">
                    {{ strtoupper(\Illuminate\Support\Str::substr($v->marca,0,1)) }}{{ strtoupper(\Illuminate\Support\Str::substr($v->modelo,0,1)) }}
                  </span>
                </div>
              @endif
              <div>
                <h5 class="mb-0">
                  <a href="{{ route('vehicles.show', $v) }}" class="text-decoration-none text-dark">
                    {{ $v->name ?? trim(($v->marca.' '.$v->modelo)) ?: 'Vehículo' }}
                  </a>
                </h5>
                <small class="text-muted">
                  <i class="ph-calendar me-1"></i>
                  {{ optional($v->created_at)->format('d.m.Y') }}
                </small>
              </div>
            </div>
            <div class="mb-2">
              @if($v->placa)
                <span class="me-3"><i class="fa-solid fa-car-side me-1"></i>{{ $v->placa }}</span>
              @endif
              @if($v->anio)
                <span class="me-3"><i class="fa-solid fa-calendar me-1"></i>{{ $v->anio }}</span>
              @endif
              @if($v->color)
                <span class="me-3"><i class="fa-solid fa-palette me-1"></i>{{ $v->color }}</span>
              @endif
              @unless($v->placa || $v->anio || $v->color)
                <span class="text-muted">Sin datos principales</span>
              @endunless
            </div>
            <div class="mb-2">
              <span class="me-3">
                <i class="fa-solid fa-gauge-high me-1"></i>
                Velocidad: {{ number_format((float)($v->velocidad ?? 0), 1) }} km/h
              </span>
              @if($v->latitud && $v->longitud)
                <a class="link-primary" target="_blank" rel="noopener" href="https://www.google.com/maps?q={{ $v->latitud }},{{ $v->longitud }}">
                  <i class="fa-solid fa-map-location-dot me-1"></i>Mapa
                </a>
              @endif
            </div>
            <div class="mb-2">
              <span class="text-muted">
                <i class="ph-clock me-1"></i>
                Actualizado: {{ optional($v->updated_at)->diffForHumans() }}
              </span>
            </div>
            @if($v->deleted_at)
              <div class="alert alert-danger py-1 px-2 mb-0 small">
                Este vehículo está eliminado. Puedes restaurarlo desde el menú.
              </div>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-3">
      {{ $vehicles->links() }}
    </div>
  @else
    <div class="alert alert-info">No hay vehículos para mostrar.</div>
  @endif
</div>
@endsection
