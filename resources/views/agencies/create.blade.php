@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('agencies.create') }}
@endsection

@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0">
        <a href="{{ route('agencies.index') }}" class="d-flex align-items-center text-body py-2">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Volver a agencias
        </a>
    </div>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            {{-- Formulario de creación de agencia --}}
            <form class="form_global" action="{{ route('agencies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-0 shadow-sm">
                    <div class="card-body">
                      

                        <div class="mb-3">
                            <div class="form-floating form-control-feedback form-control-feedback-start">
                                <div class="form-control-feedback-icon">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required autofocus placeholder="Nombre">
                                <label for="name">Nombre <span class="text-danger">*</span></label>
                                @error('name')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating form-control-feedback form-control-feedback-start">
                                <div class="form-control-feedback-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="Correo electrónico">
                                <label for="email">Correo electrónico</label>
                                @error('email')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-group phone-floating">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-phone"></i>
                                </span>
                                <div class="form-floating flex-fill">
                                    <input
                                        type="tel"
                                        name="phone"
                                        id="phoneEc"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="0998808775"
                                        inputmode="tel"
                                        pattern="0\d{9}"
                                        maxlength="10"
                                        value="{{ old('phone') }}"
                                        aria-label="Número telefónico Ecuador"
                                        aria-describedby="{{ $errors->has('phone') ? 'phoneEc-error' : 'phoneEc-help' }}"
                                        aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                    />
                                    <label for="phoneEc">Número telefónico</label>
                                </div>
                            </div>
                            @error('phone')
                                <div id="phoneEc-error" class="invalid-feedback d-block fw-bold mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div id="phoneEc-help" class="form-text">Ingresa 10 dígitos, empezando por 0 (ej: 0998808775).</div>
                        </div>


                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen (opcional)</label>
                            <input 
                                type="file" 
                                name="image" 
                                id="image"
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/*"
                                
                            >
                            @error('image')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Tamaño máximo: 2MB. Tipos permitidos: jpg, jpeg, png, gif.</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('agencies.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-check me-1"></i> Guardar
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
    
@endprepend
@push('scripts')
    <script>
        $(document).ready(function () {
            // Inicializar el plugin fileinput para el campo de imagen
            $("#image").fileinput({
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
                maxFileSize: 2048, // Tamaño máximo en KB
                maxFilesNum: 1,
                initialPreviewAsData: true, // Mostrar la imagen como vista previa
                overwriteInitial: true, // Sobrescribir la vista previa inicial si se selecciona una nueva imagen
                language: "es",
            });
        });     
    </script>


    
@endpush