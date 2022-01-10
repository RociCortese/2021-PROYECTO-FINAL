@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row align-items-center">
    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{ __('REGISTRARME') }}</strong></h4>
          </div>
          <div class="card-body ">
            <div class="bmd-form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">person</i>
                  </span>
                </div>

           <input type="text" name="nombre" class="form-control" placeholder="{{ __('Nombre (*)') }}" value="{{ old('nombre') }}" autocomplete="off">

              </div>
              @if ($errors->has('nombre'))
                <div id="nombre-error" class="error text-danger pl-3" for="nombre" style="display: block;">
                  <strong>{{ $errors->first('nombre') }}</strong>
                </div>
              @endif
              


            </div>
            <div class="bmd-form-group{{ $errors->has('apellido') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">person</i>
                  </span>
                </div>

            <input type="text" name="apellido" class="form-control" placeholder="{{ __('Apellido (*)') }}" value="{{ old('apellido') }}"autocomplete="off">
              </div>
              @if ($errors->has('apellido'))
                <div id="apellido-error" class="error text-danger pl-3" for="apellido" style="display: block;">
                  <strong>{{ $errors->first('apellido') }}</strong>
                </div>
              @endif
            
            

            </div>
            <div class="bmd-form-group{{ $errors->has('dni') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">badge</i>
                  </span>
                </div>

            <input type="text" name="dni" class="form-control" placeholder="{{ __('DNI (*)') }}" value="{{ old('dni') }}" autocomplete="off">
  

              </div>
              @if ($errors->has('dni'))
                <div id="apellido-error" class="error text-danger pl-3" for="dni" style="display: block;">
                  <strong>{{ $errors->first('dni') }}</strong>
                </div>
              @endif

            </div>
            <div class="bmd-form-group{{ $errors->has('telefono') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">phone</i>
                  </span>
                </div>



            <input type="text" name="telefono" class="form-control" placeholder="{{ __('Teléfono celular (*)') }}" value="{{ old('telefono') }}" autocomplete="off">
            

              </div>
              @if ($errors->has('telefono'))
                <div id="apellido-error" class="error text-danger pl-3" for="telefono" style="display: block;">
                  <strong>{{ $errors->first('telefono') }}</strong>
                </div>
              @endif
             

            </div>
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="{{ __('Correo electrónico (*)') }}" value="{{ old('email') }}" autocomplete="off">
              </div>
              @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif


            </div>
            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>

                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Contraseña (*)') }}"autocomplete="off" >

              </div>

              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif


            </div>
            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirmar contraseña *') }}" autocomplete="off">
              </div>
              @if ($errors->has('password_confirmation'))
                <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
              @endif

            </div>
  
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Registrarme') }}</button>
          </div>
          <div align="center">
           <i></label> <small>Los campos con (*) son obligatorios.</small></i>
      
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
