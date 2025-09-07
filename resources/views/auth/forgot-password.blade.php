@extends('layouts.guest')
@section('content')
    <form class="login-form form_global" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ asset('assets/images/logo_icon.svg') }}" class="h-48px" alt="">
                    </div>
                    <h5 class="mb-0">¿Olvidaste tu contraseña?</h5>
                    <span class="d-block text-muted">
                        No te preocupes. Solo dinos tu correo electrónico y te enviaremos un enlace para restablecerla y elegir una nueva.
                    </span>
                  
                    @include('section.alert')

                </div>

                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" 
                            required
                            placeholder="Email"
                            autofocus
                        >
                        <label>Email</label>
                        @error('email')
                            <div class="invalid-feedback fw-bold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="mb-3">
                    <button type="submit" class="btn btn-dark btn-lg w-100 fw-bold"> 
                        <i class="fas fa-sign-in-alt me-2"></i> Enviar enlace
                    </button>
                </div>

            </div>
        </div>
    </form>
@endsection