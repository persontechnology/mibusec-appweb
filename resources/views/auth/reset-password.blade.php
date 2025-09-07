@extends('layouts.guest')
@section('content')
    <form class="login-form" action="{{ route('password.store') }}" method="POST" id="form_reset_pw">
        @csrf
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ asset('assets/images/logo_icon.svg') }}" class="h-48px" alt="">
                    </div>
                    <h5 class="mb-0">Recuperación de contraseña</h5>
                    <span class="d-block text-muted">Escribe y confirma tu nueva contraseña para acceder nuevamente a tu cuenta.</span>
                  

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
                            value="{{ old('email', $request->email) }}" 
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
                            <i class="fas fa-unlock"></i>
                        </div>
                        <input 
                            id="password"
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
                <div class="mb-3">
                    <div class="form-floating form-control-feedback form-control-feedback-start">
                        <div class="form-control-feedback-icon">
                            <i class="fas fa-unlock"></i>
                        </div>
                        <input 
                            type="password" 
                            name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="Password"
                            required
                            >
                        <label>Confirmar password</label>
                        @error('password_confirmation')
                            <div class="invalid-feedback fw-bold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> 
                
                

                <div class="mb-3">
                    <button type="submit" class="btn btn-dark btn-lg w-100 fw-bold"> 
                        <i class="fas fa-sign-in-alt me-2"></i> 
                        Restablecer contraseña
                    </button>
                </div>

            </div>
        </div>
    </form>
@endsection
@push('scriptFoot')
<script>
    
    $('#form_reset_pw').validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                equalTo: '#password'
            }
        }
    });

</script>
@endpush
