@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('agencies.show', $agency) }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0 d-flex align-items-center">
                    <span class="badge bg-warning text-dark me-2">Agencia</span>
                    @if($agency->trashed())
                        <span class="badge bg-danger">Eliminada</span>
                    @else
                        <span class="badge bg-success">Activa</span>
                    @endif
                    <div class="ms-auto">
                       
                        <a href="{{ route('agencies.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        @if($agency->image)
                            <img src="{{ asset('storage/'.$agency->image) }}" class="rounded-circle me-3 border" width="64" height="64" alt="{{ $agency->name }}">
                        @else
                            <div class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center me-3"
                                 style="width:64px;height:64px;">
                                <span class="text-muted" style="font-size: 2rem;">
                                    {{ strtoupper(Str::substr($agency->name,0,1)) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <h3 class="mb-0">{{ $agency->name }}</h3>
                            <small class="text-muted">
                                <i class="ph-calendar me-1"></i>
                                {{ optional($agency->created_at)->format('d.m.Y') }}
                            </small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Correo electrónico:</strong>
                        @if($agency->email)
                            <span class="ms-2"><i class="fa-solid fa-envelope me-1"></i>{{ $agency->email }}</span>
                        @else
                            <span class="text-muted ms-2">No registrado</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Teléfono:</strong>
                        @if($agency->phone)
                            <span class="ms-2"><i class="fa-solid fa-phone me-1"></i>{{ $agency->phone }}</span>
                        @else
                            <span class="text-muted ms-2">No registrado</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Estado:</strong>
                        @if($agency->trashed())
                            <span class="badge bg-danger ms-2">Eliminada</span>
                        @else
                            <span class="badge bg-success ms-2">Activa</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Creada:</strong>
                        <span class="ms-2">
                            <i class="ph-calendar me-1"></i>
                            {{ optional($agency->created_at)->format('d.m.Y H:i') }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Última actualización:</strong>
                        <span class="ms-2">
                            <i class="ph-clock me-1"></i>
                            {{ optional($agency->updated_at)->diffForHumans() }}
                        </span>
                    </div>
                    @if($agency->trashed())
                        <div class="alert alert-danger py-2 px-3 mt-3">
                            Esta agencia está eliminada. Puedes restaurarla desde el listado.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection