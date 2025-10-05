@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('home') }}
@endsection

@section('breadcrumb_elements')
    <div class="d-lg-flex mb-2 mb-lg-0">
        <a href="#" class="d-flex align-items-center text-body py-2">
            <i class="ph-lifebuoy me-2"></i>
            Support
        </a>

        <div class="dropdown ms-lg-3">
            <a href="#" class="d-flex align-items-center text-body dropdown-toggle py-2" data-bs-toggle="dropdown">
                <i class="ph-gear me-2"></i>
                <span class="flex-1">Settings</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end w-100 w-lg-auto">
                <a href="#" class="dropdown-item">
                    <i class="ph-shield-warning me-2"></i>
                    Account security
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ph-chart-bar me-2"></i>
                    Analytics
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ph-lock-key me-2"></i>
                    Privacy
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="ph-gear me-2"></i>
                    All settings
                </a>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="card">
        <div class="card-header">HOLAS</div>
        <div class="card-body">
            <h4 class="card-title">Title</h4>
            <p class="card-text">Text</p>
        </div>
        <div class="card-footer text-muted">Footer</div>
    </div>
    
@endsection