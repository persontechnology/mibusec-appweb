@extends('layouts.app')
 
@section('breadcrumb')
    {{ Breadcrumbs::render('route.stops.index',$route) }}
@endsection

@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0">
        <a href="{{ route('route.stops.create',$route) }}" class="d-flex align-items-center text-body py-2">
            <i class="fa-solid fa-plus me-1"></i>
            Crear o Actualizar
        </a>

    </div>
@endsection


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    {{-- tabla para route_distances --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Desde Parada</th>
                                <th>Hasta Parada</th>
                                <th>Distancia (km)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($route_distances as $distance)
                                <tr>
                                    <td>{{ $distance->fromStop->name }} ({{ $distance->fromStop->code }})</td>
                                    <td>{{ $distance->toStop->name }} ({{ $distance->toStop->code }})</td>
                                    <td>{{ number_format($distance->distance_km, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
 
@push('scripts')
    {{ $dataTable->scripts() }}
@endpush