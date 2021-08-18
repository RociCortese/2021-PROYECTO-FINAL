@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Usted se ha registado correctamente. Para comenzar a utilizar la plataforma verifique su dirección de correo electrónico.') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                        </div>
                    @endif
                        <a class="btn btn-default"  href="{{ asset('/') }}">Volver a login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
