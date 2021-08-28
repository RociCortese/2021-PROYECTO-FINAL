@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'verify', 'title' => __('')])


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('El usuario ha sido registrado con éxito. Se le ha enviado el enlace para confirmar la cuenta al correo electrónico con el que se hizo el registro.') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                        </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
