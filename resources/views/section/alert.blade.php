{{-- section/notifications.blade.php --}}

{{-- Errores de validación --}}
@if ($errors->any())
    <div class="alert bg-danger text-white alert-dismissible fade show">
        @foreach ($errors->all() as $index => $error)
            <div class="fw-bold d-flex align-items-start p-0 m-0">
                {{-- Mostrar icono solo si hay más de un error --}}
                @if ($errors->count() > 1)
                    <i class="fas fa-long-arrow-alt-right me-1"></i>
                @endif
                <span class="text-start">{{ $error }}</span>
            </div>
        @endforeach
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
@endif


{{-- Mensajes flash --}}
@foreach (['success', 'info', 'primary', 'warning', 'danger','status'] as $type)
    @if (session($type))
        <div class="alert {{ $type === 'status' ? 'alert-dark text-dark' : 'bg-'.$type.' text-white' }} alert-dismissible fade show">
            <div class="fw-bold d-flex align-items-start p-0 m-0">
                <span class="text-start">{{ session($type) }}</span>
            </div>
            <button type="button" class="btn-close {{ $type === 'status' ? '' : 'btn-close-white' }}" data-bs-dismiss="alert"></button>
        </div>
    @endif
@endforeach


