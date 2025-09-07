{{-- resources/views/stops/create.blade.php --}}
@extends('layouts.app') {{-- ajusta al layout que uses, por ejemplo el del login --}}
@section('breadcrumb')
    {{ Breadcrumbs::render('stops.create') }}
@endsection

@section('content')
<form method="POST" action="{{ route('stops.store') }}" class="form_global">
    @csrf
    @include('stops._form')
</form>  
@endsection
