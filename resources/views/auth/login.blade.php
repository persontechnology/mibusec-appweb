@extends('layouts.guest')
@section('content')
    <!-- Login form -->
    <form class="login-form form_global" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ asset('assets/images/logo_icon.svg') }}" class="h-48px" alt="">
                    </div>
                    <h5 class="mb-0">Inicia sesión en tu cuenta</h5>
                    <span class="d-block text-muted">Ingrese sus credenciales a continuación</span>
                  

                    @include('section.alert')

                </div>

                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-envelope"></i>
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
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input 
                            type="password" 
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password"
                            minlength="6"
                            required
                            >
                        <label>Password</label>
                        @error('password')
                            <div class="invalid-feedback fw-bold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> 
                
                <div class="d-flex align-items-center mb-3">
                    <label class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                        <span class="form-check-label">Recordar</span>
                    </label>

                    <a href="{{ route('password.request') }}" class="ms-auto">¿Has olvidado tu contraseña?</a>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-dark btn-lg w-100 fw-bold"> <i class="fas fa-sign-in-alt me-2"></i> Ingresar</button>
                </div>

            </div>
        </div>
    </form>
    <!-- /login form -->
@endsection