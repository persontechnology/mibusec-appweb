@extends('layouts.app')
 
@section('breadcrumb')
    {{ Breadcrumbs::render('routes.index') }}
@endsection

@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0">
        <a href="{{ route('routes.create') }}" class="d-flex align-items-center text-body py-2">
            <i class="fa-solid fa-plus me-1"></i>
            Nuevo
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
    </div>
@endsection
 
@push('scripts')
    {{ $dataTable->scripts() }}
@endpush