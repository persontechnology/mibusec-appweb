@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('agencies.index') }}
@endsection

@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0">
        <a href="{{ route('agencies.create') }}" class="d-flex align-items-center text-body py-2">
            <i class="fa-solid fa-plus me-1"></i>
            Nuevo
        </a>
    </div>
@endsection


@section('content')

<div class="container">
    {{-- Card de búsqueda y filtros --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('agencies.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <label for="q" class="form-label mb-0">Buscar</label>
                            <input type="text" name="q" id="q" value="{{ old('q', $q ?? '') }}" class="form-control" placeholder="Nombre, email o teléfono">
                        </div>
                        <div class="col-md-3">
                            <label for="trashed" class="form-label mb-0">Estado</label>
                            <select name="trashed" id="trashed" class="form-select mt-0">
                                <option value="" {{ !isset($showTrashed) ? 'selected' : '' }}>Solo activas</option>
                                <option value="1" {{ (isset($showTrashed) && $showTrashed == 1) ? 'selected' : '' }}>Solo eliminadas</option>
                                <option value="all" {{ (isset($showTrashed) && $showTrashed === 'all') ? 'selected' : '' }}>Todas</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100 mt-4">
                                <i class="ph-magnifying-glass"></i> Buscar
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('agencies.index') }}" class="btn btn-outline-secondary w-100 mt-4">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        {{-- foreach de agencies --}}
        @forelse ($agencies as $agency)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm h-100 {{ $agency->trashed() ? 'border-danger' : 'border-success' }}">
                    <div class="card-header bg-transparent border-0 pb-0 d-flex align-items-center">
                        <span class="badge bg-warning text-dark me-2">Agencia</span>
                        @if($agency->trashed())
                            <span class="badge bg-danger">Eliminada</span>
                        @else
                            <span class="badge bg-success">Activa</span>
                        @endif
                        <div class="dropdown ms-auto">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-gear"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                

                                
                                <a href="{{ route('agencies.show', $agency) }}" class="dropdown-item">
                                    <i class="fa-solid fa-eye me-2"></i> Ver detalles
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('agencies.edit', $agency) }}"
                                   class="dropdown-item">
                                    <i class="fa-solid fa-pen-to-square me-2"></i> Editar
                                </a>

                                @if(!$agency->trashed())
                                    
                                        <button type="button" class="dropdown-item" 
                                                onclick="deleteGlobal(this)"
                                                data-url="{{ route('agencies.destroy', $agency) }}"
                                                data-info="{{ $agency->name .' se enviará a la papelera.' }}"
                                            >
                                            <i class="fa-solid fa-trash me-2"></i> Eliminar
                                        </button>
                                @else
                                    
                                    <button type="button" class="dropdown-item"
                                            onclick="restoreGlobal(this)"
                                            data-url="{{ route('agencies.restore', $agency->id) }}"
                                            data-info="{{ $agency->name }} se restaurará y volverá a estar activa.">
                                        <i class="ph-arrow-u-up-left me-2"></i> Restaurar
                                    </button>

                                    <button type="button" class="dropdown-item text-danger"
                                            onclick="deleteGlobal(this)"
                                            data-url="{{ route('agencies.forceDelete', $agency->id) }}"
                                            data-info="{{ $agency->name .' se eliminará permanentemente y no podrá ser restaurada.' }}"
                                        >
                                        <i class="fa-solid fa-trash-can me-2"></i> Eliminar permanentemente
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($agency->image)
                                <img src="{{ asset('storage/'.$agency->image) }}" class="rounded-circle me-3 border" width="48" height="48" alt="{{ $agency->name }}">
                            @else
                                <div class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center me-3"
                                     style="width:48px;height:48px;">
                                    <span class="text-muted" style="font-size: 1.25rem;">
                                        {{ strtoupper(Str::substr($agency->name,0,1)) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">
                                    <a href="javascript:void(0)" class="text-decoration-none text-dark">{{ $agency->name }}</a>
                                </h5>
                                <small class="text-muted">
                                    <i class="ph-calendar me-1"></i>
                                    {{ optional($agency->created_at)->format('d.m.Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="mb-2">
                            @if($agency->email)
                                <span class="me-3"><i class="ph-at me-1"></i>{{ $agency->email }}</span>
                            @endif
                            @if($agency->phone)
                                <span class="me-3"><i class="ph-phone me-1"></i>{{ $agency->phone }}</span>
                            @endif
                            @unless($agency->email || $agency->phone)
                                <span class="text-muted">Sin datos de contacto</span>
                            @endunless
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">
                                <i class="ph-clock me-1"></i>
                                Actualizada: {{ optional($agency->updated_at)->diffForHumans() }}
                            </span>
                        </div>
                        @if($agency->trashed())
                            <div class="alert alert-danger py-1 px-2 mb-0 small">
                                Esta agencia está eliminada. Puedes restaurarla desde el menú.
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No hay agencias registradas.
                </div>
            </div>
        @endforelse
    </div>
    {{-- links de paginacion --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $agencies->links() }}
    </div>
</div>
@endsection