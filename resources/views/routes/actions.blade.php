
<div class="d-inline-flex">
    <div class="dropdown">
        <a href="#" class="text-body" data-bs-toggle="dropdown">
            <i class="ph-list"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-start">

            
            <a href="{{ route('routes.show',$route) }}" class="dropdown-item">
                <i class="ph-eye me-2"></i>
                Ver
            </a>
            <a href="{{ route('route.stops.index',$route) }}" class="dropdown-item">
                <i class="ph ph-traffic-signal me-2"></i>
                Paradas
            </a>
            <div class="dropdown-divider"></div>

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