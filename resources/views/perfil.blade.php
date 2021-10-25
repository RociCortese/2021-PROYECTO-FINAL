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
              



                @if ($user->role=='docente')
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" id="input-nombre" type="text" placeholder="{{ __('Nombre') }}" value="{{$docente->nombre}}"/>
                      @if ($errors->has('nombre'))
                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{ $errors->first('nombre') }}</span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="row">
            <label class="col-sm-2 col-form-label">Apellido</label>
            <div class="col-sm-7">
            <input class="form-control" name="apellido" value="{{$docente->apellido}}"></input>
            @if ($errors->has('apellido'))
                <div id="apellido-error" class="error text-danger pl-3" for="apellido" style="display: block;">
                  <strong>{{ $errors->first('apellido') }}</strong>
                </div>
              @endif
            </div>
          </div>

          <div class="row">
            <label class="col-sm-2 col-form-label">Fecha de nacimiento</label>
            <div class="col-sm-7">
            <input type="date" name="fechanacimiento" class="form-control" min="1951-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 18 years"));?>" value="{{$docente->fechanacimiento}}">
            @if ($errors->has('fechanacimiento'))
                <div id="fechanacimiento-error" class="error text-danger pl-3" for="fechanacimiento" style="display: block;">
                  <strong>{{ $errors->first('fechanacimiento') }}</strong>
                </div>
              @endif
            </div>
          </div>

          <div class="row">
            <label class="col-sm-2 col-form-label">Género</label>
            <div class="col-sm-7">
            <select name="genero" id="opciongenero" class="form-control" value="{{$docente->genero}}">
                    <option></option>
                    <option value="Femenino" <?php if($docente->genero=='Femenino') echo 'selected="selected" ';?>>Femenino
                    <option value="Masculino" <?php if($docente->genero=='Masculino') echo 'selected="selected" ';?>>Masculino
                </select>
                
            @if ($errors->has('genero'))
                <div id="genero-error" class="error text-danger pl-3" for="genero" style="display: block;">
                  <strong>{{ $errors->first('genero') }}</strong>
                </div>
              @endif
            </div>
          </div>

          <div class="row">
            <label class="col-sm-2 col-form-label">Estado civil</label>
            <div class="col-sm-7">
            <select name="estadocivil" id="opcionestadocivil" class="form-control" value="{{$docente->estadocivil}}">
                    <option></option>
                    <option value="Soltera/o" <?php if($docente->estadocivil=='Soltera/o') echo 'selected="selected" ';?>>Soltera/o
                    <option value="Casada/o" <?php if($docente->estadocivil=='Casada/o') echo 'selected="selected" ';?>>Casada/o
                    <option value="Divorciada/o" <?php if($docente->estadocivil=='Divorciada/o') echo 'selected="selected" ';?>>Divorciada/o
                    <option value="Viuda/o" <?php if($docente->estadocivil=='Viuda/o') echo 'selected="selected" ';?>>Viuda/o
                    <option value="En concubitato" <?php if($docente->estadocivil=='En concubitato') echo 'selected="selected" ';?>>En concubitato

                </select>
            @if ($errors->has('estadocivil'))
                <div id="estadocivil-error" class="error text-danger pl-3" for="estadocivil" style="display: block;">
                  <strong>{{ $errors->first('estadocivil') }}</strong>
                </div>
              @endif
            </div>
          </div>

          <div class="row">
            <label class="col-sm-2 col-form-label">Domicilio</label>
            <div class="col-sm-7">
            <input type="text" name="domicilio" class="form-control" value="{{$docente->domicilio}}">
            @if ($errors->has('domicilio'))
                <div id="domicilio-error" class="error text-danger pl-3" for="domicilio" style="display: block;">
                  <strong>{{ $errors->first('domicilio') }}</strong>
                </div>
              @endif
            </div>
          </div> 

           <div class="row">
            <label class="col-sm-2 col-form-label">Localidad</label>
            <div class="col-sm-7">
            <input type="text" name="localidad" class="form-control" value="{{$docente->localidad}}">
            @if ($errors->has('localidad'))
                <div id="localidad-error" class="error text-danger pl-3" for="localidad" style="display: block;">
                  <strong>{{ $errors->first('localidad') }}</strong>
                </div>
              @endif
            </div>
          </div>

           <div class="row">
            <label class="col-sm-2 col-form-label">Provincia</label>
            <div class="col-sm-7">
            <input type="text" name="provincia" class="form-control" value="{{$docente->provincia}}">
            @if ($errors->has('provincia'))
                <div id="provincia-error" class="error text-danger pl-3" for="provincia" style="display: block;">
                  <strong>{{ $errors->first('provincia') }}</strong>
                </div>
              @endif
            </div>
          </div>

          

          <div class="row">
            <label class="col-sm-2 col-form-label">Teléfono</label>
            <div class="col-sm-7">
            <input type="text" name="telefono" class="form-control" value="{{$docente->telefono}}">
            @if ($errors->has('telefono'))
                <div id="telefono-error" class="error text-danger pl-3" for="telefono" style="display: block;">
                  <strong>{{ $errors->first('telefono') }}</strong>
                </div>
              @endif
            </div>
          </div>
        
          <div class="row">
            <label class="col-sm-2 col-form-label">Legajo</label>
            <div class="col-sm-7">
            <input type="text" name="legajo" class="form-control" value="{{$docente->legajo}}">
            @if ($errors->has('legajo'))
                <div id="legajo-error" class="error text-danger pl-3" for="legajo" style="display: block;">
                  <strong>{{ $errors->first('legajo') }}</strong>
                </div>
              @endif
            </div>
          </div>

          <div class="row">
            <label class="col-sm-2 col-form-label">Especialidad</label>
            <div class="col-sm-7">
            <input type="text" name="especialidad" class="form-control" value="{{$docente->especialidad}}">
            @if ($errors->has('especialidad'))
                <div id="especialidad-error" class="error text-danger pl-3" for="especialidad" style="display: block;">
                  <strong>{{ $errors->first('especialidad') }}</strong>
                </div>
              @endif
            </div>
            </div>
                @endif

                @if ($user->role=='familia')
                  <div class="row">
            <label class="col-sm-2 col-form-label">DNI</label>
            <div class="col-sm-7">
            <input type="text" name="dnifamilia" class="form-control" value="{{$id->dnifamilia}}">
            @if ($errors->has('dnifamilia'))
                <div id="dnifamilia-error" class="error text-danger pl-3" for="dnifamilia" style="display: block;">
                  <strong>{{ $errors->first('dnifamilia') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-7">
            <input type="text" name="nombrefamilia" class="form-control" value="{{$id->nombrefamilia}}">
            @if ($errors->has('nombrefamilia'))
                <div id="nombrefamilia-error" class="error text-danger pl-3" for="nombrefamilia" style="display: block;">
                  <strong>{{ $errors->first('nombrefamilia') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Apellido</label>
            <div class="col-sm-7">
            <input class="form-control" name="apellidofamilia" value="{{$id->apellidofamilia}}">
            @if ($errors->has('apellidofamilia'))
                <div id="apellidofamilia-error" class="error text-danger pl-3" for="apellidofamilia" style="display: block;">
                  <strong>{{ $errors->first('apellidofamilia') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Género</label>
            <div class="col-sm-7">
            <select name="generofamilia" id="opciongenerofamilia" class="form-control" value="{{$id->generofamilia}}">
                    <option></option>
                    <option value="Femenino" <?php if($id->generofamilia=='Femenino') echo 'selected="selected" ';?>>Femenino
                    <option value="Masculino" <?php if($id->generofamilia=='Masculino') echo 'selected="selected" ';?>>Masculino
                </select>
  
            @if ($errors->has('generofamilia'))
                <div id="generofamilia-error" class="error text-danger pl-3" for="generofamilia" style="display: block;">
                  <strong>{{ $errors->first('generofamilia') }}</strong>
                </div>
              @endif
            </div>
          </div>
              <div class="row">
            <label class="col-sm-2 col-form-label">Teléfono</label>
            <div class="col-sm-7">
            <input type="text" name="telefono" class="form-control" value="{{$id->telefono}}">
            @if ($errors->has('telefono'))
                <div id="telefono-error" class="error text-danger pl-3" for="telefono" style="display: block;">
                  <strong>{{ $errors->first('telefono') }}</strong>
                </div>
              @endif
            </div>
          </div>

           <div class="row">
            <label class="col-sm-2 col-form-label">Correo electrónico</label>
            <div class="col-sm-7">
            <input type="text" name="email" class="form-control" value="{{$id->email}}">
            @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>
          </div>

          <div class="row">
            <label class="col-sm-2 col-form-label">Vínculo Familiar</label>
            <div class="col-sm-7">
              <select name="vinculofamiliar" id="opcionvinculo" class="form-control" value="{{$id->vinculofamiliar}}">
                    <option></option>
                    <option value="Madre" <?php if($id->vinculofamiliar=='Madre') echo 'selected="selected" ';?>>Madre
                    <option value="Padre" <?php if($id->vinculofamiliar=='Padre') echo 'selected="selected" ';?>>Padre
                    <option value="Tutor" <?php if($id->vinculofamiliar=='Tutor') echo 'selected="selected" ';?>>Tutor  
                </select>
            @if ($errors->has('vinculofamiliar'))
                <div id="vinculofamiliar-error" class="error text-danger pl-3" for="vinculofamiliar" style="display: block;">
                  <strong>{{ $errors->first('vinculofamiliar') }}</strong>
                </div>
              @endif
            </div>
            </div>
            @endif


               


        </div>

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