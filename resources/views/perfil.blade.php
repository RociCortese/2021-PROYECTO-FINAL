@extends('layouts.main', ['activePage' => 'profile', 'titlePage' => __('User Profile')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{route('profile.updatepersonal')}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-info">
                <h4 class="card-title">{{ __('Información personal') }}</h4>
              </div>
              <div class="card-body ">
                @if(session('success'))
                    <div class="alert alert-success" role="success">
                    {{session('success')}}
                    </div>
                    <script type="text/javascript">
                    window.setTimeout(function() {
                    $(".alert-success").fadeTo(400, 0).slideUp(400, function(){
                    $(this).remove(); 
                    });
                    }, 1000);
                    </script>
                    @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}"/>
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @if ($user->role=='directivo')
              <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                      <input class="form-control" name="nombre" id="input-nombre" type="text" placeholder="{{ __('Nombre') }}" value="{{$directivo->nombre}}"/>
                      @if ($errors->has('nombre'))
                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{ $errors->first('nombre') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Apellido') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('apellido') ? ' has-danger' : '' }}">
                      <input class="form-control" name="apellido" id="input-apellido" type="text" placeholder="{{ __('Apellido') }}" value="{{$directivo->apellido}}"/>
                      @if ($errors->has('apellido'))
                        <span id="apellido-error" class="error text-danger" for="input-apellido">{{ $errors->first('apellido') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('DNI') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('dni') ? ' has-danger' : '' }}">
                      <input class="form-control" name="dni" id="input-dni" type="text" placeholder="{{ __('DNI') }}" value="{{$directivo->dni}}"/>
                      @if ($errors->has('dni'))
                        <span id="dni-error" class="error text-danger" for="input-dni">{{ $errors->first('dni') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Teléfono') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }}">
                      <input class="form-control" name="telefono" id="input-telefono" type="text" placeholder="{{ __('telefono') }}" value="{{$directivo->telefono}}"/>
                      @if ($errors->has('telefono'))
                        <span id="telefono-error" class="error text-danger" for="input-telefono">{{ $errors->first('telefono') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @endif
              </div>
                @if ($user->role=='docente')
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" id="input-nombre" type="text" placeholder="{{ __('Nombre') }}" value="{{$directivo->apellido}}"/>
                      @if ($errors->has('nombre'))
                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{ $errors->first('nombre') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @endif
                <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-sm btn-facebook">{{ __('Actualizar cambios') }}</button>
              </div>
              </div>
            </form>
            <form method="post" action="{{route('profile.updatecontra')}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
                <div class="card ">
              <div class="card-header card-header-info">
                <h4 class="card-title">{{ __('Contraseña') }}</h4>
              </div>
              <div class="card-body ">
                @if (session('status_password'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status_password') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-current-password">{{ __('Contraseña actual') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                      <input class="form-control" input type="password" name="old_password" id="input-current-password" placeholder="{{ __('Current Password') }}" value="{{$contra}}"/>
                      @if ($errors->has('old_password'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('old_password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
            
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __('Nueva contraseña') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control" name="password" id="input-password" type="password" />
                      @if ($errors->has('password'))
                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirmar nueva contraseña') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password"/>
                    </div>
                  </div>
                </div>
              </div>
                <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-sm btn-facebook">{{ __('Modificar contraseña') }}</button>
              </div>
              </div>
              </div>
            </form>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection