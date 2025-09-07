
<div class="d-inline-flex">
    <div class="dropdown">
        <a href="#" class="text-body" data-bs-toggle="dropdown">
            <i class="ph-list"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-start">
            <a href="{{ route('vehicles.show',$vehicle) }}" class="dropdown-item">
                <i class="ph-eye me-2"></i>
                Ver
            </a>
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