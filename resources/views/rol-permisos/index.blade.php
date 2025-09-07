@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('rol-permisos.index') }}
@endsection
@section('content')
    

    <div class="row">
        <div class="col-sm-12 col-md-4">

                <form action="{{ route('rol-permisos.store') }}" method="post" id="form_global">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h6 class="hstack gap-2 mb-0">
                                <i class="fa-solid fa-plus"></i>
                                Crear nuevo rol
                            </h6>
                        </div>

                        <div class="card-body">
                            <div class="mb-0">
                                <div class="form-floating form-control-feedback form-control-feedback-start">
                                    <div class="form-control-feedback-icon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" 
                                        required
                                        placeholder="Nombre"
                                        autofocus
                                    >
                                    <label>Nombre</label>
                                    @error('name')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        
                        <div class="card-footer d-sm-flex align-items-sm-center py-1">
                            <button type="submit" class="btn btn-dark w-100 w-sm-auto ms-sm-auto">
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            
        @foreach ($roles as $rol)
            <div class="col-sm-12 col-md-4">
                <form 
                        id="form-permisos-{{ $rol->id }}" 
                        action="{{ route('rol-permisos.update',$rol->id) }}"
                        method="POST" class="form-permisos">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-body d-sm-flex align-items-sm-center">
                            <h6 class="mb-sm-0">{{ $rol->name }}</h6>
                        </div>

                        <ul class="list-group list-group-flush border-top">
                            @foreach ($permisos as $permiso)
                                <li class="list-group-item d-flex">
                                    {{ $permiso->name }}
                                    <input type="checkbox" name="permissions[]" value="{{ $permiso->name }}"
                                        class="form-check-input ms-auto"
                                        {{ $rol->hasPermissionTo($permiso->name) ? 'checked' : '' }}>
                                </li>
                            @endforeach
                        </ul>

                        <div class="card-footer d-sm-flex align-items-sm-center py-1 border-top">
                            <button type="button" class="btn btn-danger w-100 w-sm-auto ms-sm-auto" onclick="deleteGlobal(this);" data-url="{{ route('rol-permisos.destroy',$rol->id) }}" data-info="{{ $rol->name }}">
                                Eliminar
                            </button>
                            <button type="submit" class="btn btn-dark w-100 w-sm-auto ms-sm-auto">
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endforeach



    </div>
    
@endsection