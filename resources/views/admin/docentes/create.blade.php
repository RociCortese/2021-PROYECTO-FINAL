@extends('layouts.main', ['activePage' => 'creardocente', 'titlePage' => __('Nuevo Docente')])
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Agregar nuevo docente</h2>
        </div>
    </div>
</div>
   
<form action="{{ route('docentes.store') }}" method="POST">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <input type="text" name="dni" class="one-half" placeholder="DNI">
            </div>
            @if ($errors->has('dni'))
                <div id="dni-error" class="error text-danger pl-3" for="dni" style="display: block;">
                  <strong>{{ $errors->first('dni') }}</strong>
                </div>
              @endif
        </div>
        

<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                
                <input type="text" name="nombre" class="one-half last" placeholder="Nombre">
            </div>
            @if ($errors->has('nombre'))
                <div id="nombre-error" class="error text-danger pl-3" for="nombre" style="display: block;">
                  <strong>{{ $errors->first('nombre') }}</strong>
                </div>
              @endif
        </div>
<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Apellido</label>
                <input class="form-control" name="apellido">
            </div>
            @if ($errors->has('apellido'))
                <div id="apellido-error" class="error text-danger pl-3" for="apellido" style="display: block;">
                  <strong>{{ $errors->first('apellido') }}</strong>
                </div>
              @endif
        </div>
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fechanacimiento" class="form-control" >
            </div>
            @if ($errors->has('fechanacimiento'))
                <div id="fechanacimiento-error" class="error text-danger pl-3" for="fechanacimiento" style="display: block;">
                  <strong>{{ $errors->first('fechanacimiento') }}</strong>
                </div>
              @endif
        </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Género</label>
                <select name="genero">
                    <option></option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                </select>
            </div>
            @if ($errors->has('genero'))
                <div id="genero-error" class="error text-danger pl-3" for="genero" style="display: block;">
                  <strong>{{ $errors->first('genero') }}</strong>
                </div>
              @endif
        </div>
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Domicilio</label>
                <input type="text" name="domicilio" class="form-control" >
            </div>
            @if ($errors->has('domicilio'))
                <div id="domicilio-error" class="error text-danger pl-3" for="domicilio" style="display: block;">
                  <strong>{{ $errors->first('domicilio') }}</strong>
                </div>
              @endif
        </div>
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Localidad</label>
                <input type="text" name="localidad" class="form-control">
            </div>
            @if ($errors->has('localidad'))
                <div id="localidad-error" class="error text-danger pl-3" for="localidad" style="display: block;">
                  <strong>{{ $errors->first('localidad') }}</strong>
                </div>
              @endif
        </div>
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Provincia</label>
                <input type="text" name="provincia" class="form-control">
            </div>
            @if ($errors->has('provincia'))
                <div id="provincia-error" class="error text-danger pl-3" for="provincia" style="display: block;">
                  <strong>{{ $errors->first('provincia') }}</strong>
                </div>
              @endif
        </div>
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Estado civil</label>
                <select name="estadocivil">
                    <option></option>
                    <option value="Soltera/o">Soltera/o</option>
                    <option value="Casada/o">Casada/o</option>
                    <option value="Divorciada/o">Divorciada/o</option>
                    <option value="Viuda/o">Viuda/o</option>
                    <option value="En concubitato">En concubitato</option>
                </select>
            </div>
            @if ($errors->has('estadocivil'))
                <div id="estadocivil-error" class="error text-danger pl-3" for="estadocivil" style="display: block;">
                  <strong>{{ $errors->first('estadocivil') }}</strong>
                </div>
              @endif
        </div>
       <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>
            @if ($errors->has('telefono'))
                <div id="telefono-error" class="error text-danger pl-3" for="telefono" style="display: block;">
                  <strong>{{ $errors->first('telefono') }}</strong>
                </div>
              @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="text" name="email" class="form-control" >
            </div>
            @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
        </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Legajo</label>
                <input type="text" name="legajo" class="form-control">
            </div>
            @if ($errors->has('legajo'))
                <div id="legajo-error" class="error text-danger pl-3" for="legajo" style="display: block;">
                  <strong>{{ $errors->first('legajo') }}</strong>
                </div>
              @endif
        </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Especialidad</label>
                <input type="text" name="especialidad" class="form-control" >
            </div>
            @if ($errors->has('especialidad'))
                <div id="especialidad-error" class="error text-danger pl-3" for="especialidad" style="display: block;">
                  <strong>{{ $errors->first('especialidad') }}</strong>
                </div>
              @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="reset" class="btn btn-link">Limpiar</button>
        </div>
    </div>
   
</form>
@endsection