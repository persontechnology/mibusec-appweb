{{-- resources/views/stops/create.blade.php --}}
@extends('layouts.app') {{-- ajusta al layout que uses, por ejemplo el del login --}}
@section('breadcrumb')
    {{ Breadcrumbs::render('stops.edit',$stop) }}
@endsection

@section('content')
<form method="POST" action="{{ route('stops.update',$stop) }}" class="form_global">
    @csrf
    @method('PUT')
    @include('stops._form')
</form>  
@endsection
