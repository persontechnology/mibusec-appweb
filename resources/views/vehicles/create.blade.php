@extends('layouts.app')
 
@section('breadcrumb')
    {{ Breadcrumbs::render('vehicles.create') }}
@endsection


@section('content')
<form method="POST" action="{{ route('vehicles.store') }}" class="form_global">
    @csrf
    @include('vehicles._form')
</form>
@endsection
