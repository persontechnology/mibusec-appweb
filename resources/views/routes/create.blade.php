
@extends('layouts.app')


 
@section('breadcrumb')
    {{ Breadcrumbs::render('routes.create') }}
@endsection

@section('content')
<form method="POST" action="{{ route('routes.store') }}" class="form_global">
    @csrf
    @include('routes._form')
</form>
@endsection
