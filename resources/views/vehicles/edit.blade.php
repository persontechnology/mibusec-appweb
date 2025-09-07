
@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('vehicles.edit',$vehicle) }}
@endsection

@section('content')
<form method="POST" action="{{ route('vehicles.update', $vehicle) }}" class="form_global">
    @csrf
    @method('PUT')
    @include('vehicles._form')
  </form>
@endsection
