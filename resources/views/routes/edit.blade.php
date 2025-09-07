
@extends('layouts.app')

 
@section('breadcrumb')
    {{ Breadcrumbs::render('routes.edit',$route) }}
@endsection


@section('content')
<form method="POST" action="{{ route('routes.update', $route) }}" class="form_global">
    @csrf
    @method('PUT')
    @include('routes._form')
</form>
@endsection
