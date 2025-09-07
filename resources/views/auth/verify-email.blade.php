@extends('layouts.guest')
@section('content')
    <!-- Login form -->
    
        <div class=" login-form card mb-0">

            <div class="card-body">

                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ asset('assets/images/logo_icon.svg') }}" class="h-48px" alt="">
                    </div>
                    <h5 class="mb-0">Verificar correo electrónico</h5>
                    <span class="d-block text-muted">
                        ¡Gracias por registrarte! Revisa tu correo y haz clic en el enlace de verificación. Si no lo recibiste, podemos enviarte otro.
                    </span>
                    
                                        
                    @include('section.alert')
                 

                </div>

                

                    <div class="mb-2">
                        <form action="{{ route('verification.send') }}" method="POST" id="form_login">
                            @csrf   
                            <button type="submit" class="btn btn-flat-primary btn-lg w-100 fw-bold"> 
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Reenviar verificación
                            </button>
                        </form>
                    </div>

                
                    <div class="mb-0">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-flat-danger btn-lg w-100 fw-bold">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Finalizar la sesión
                            </button>
                        </form>
                    </div>
                
            </div>
        </div>
    
    <!-- /login form -->

    
@endsection