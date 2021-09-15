
@extends('layouts.main', ['activePage' => 'docente', 'titlePage' => __('')])
  
@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('docentes.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card">
          <div class= "card-header card-header-primary">
          <h4 class="card-tittle">Agregar nuevo docente</h4>
          </div>
        <div class="card-body">
          <div class="row">
            <label class="col-sm-2 col-form-label">DNI</label>
            <div class="col-sm-7">
            <input type="text" name="dni" class="form-control">

            @if ($errors->has('dni'))
                <div id="dni-error" class="error text-danger pl-3" for="dni" style="display: block;">
                  <strong>{{ $errors->first('dni') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-7">
            <input type="text" name="nombre" class="form-control">
            @if ($errors->has('nombre'))
                <div id="nombre-error" class="error text-danger pl-3" for="nombre" style="display: block;">
                  <strong>{{ $errors->first('nombre') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Apellido</label>
            <div class="col-sm-7">
            <input class="form-control" name="apellido"></input>
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
            <input type="date" name="fechanacimiento" class="form-control" min="1951-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 18 years"));?>">
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
            <select name="genero" class="form-control">
                    <option></option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                </select>
            @if ($errors->has('genero'))
                <div id="genero-error" class="error text-danger pl-3" for="genero" style="display: block;">
                  <strong>{{ $errors->first('genero') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Domicilio</label>
            <div class="col-sm-7">
            <input type="text" name="domicilio" class="form-control">
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
            <input type="text" name="localidad" class="form-control">
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
            <input type="text" name="provincia" class="form-control">
            @if ($errors->has('provincia'))
                <div id="provincia-error" class="error text-danger pl-3" for="provincia" style="display: block;">
                  <strong>{{ $errors->first('provincia') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Estado civil</label>
            <div class="col-sm-7">
            <select name="estadocivil" class="form-control">
                    <option></option>
                    <option value="Soltera/o">Soltera/o</option>
                    <option value="Casada/o">Casada/o</option>
                    <option value="Divorciada/o">Divorciada/o</option>
                    <option value="Viuda/o">Viuda/o</option>
                    <option value="En concubitato">En concubitato</option>
                </select>
            @if ($errors->has('estadocivil'))
                <div id="estadocivil-error" class="error text-danger pl-3" for="estadocivil" style="display: block;">
                  <strong>{{ $errors->first('estadocivil') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Teléfono</label>
            <div class="col-sm-7">
            <input type="text" name="telefono" class="form-control">
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
            <input type="text" name="email" class="form-control">
            @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Legajo</label>
            <div class="col-sm-7">
            <input type="text" name="legajo" class="form-control">
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
            <input type="text" name="especialidad" class="form-control">
            @if ($errors->has('especialidad'))
                <div id="especialidad-error" class="error text-danger pl-3" for="especialidad" style="display: block;">
                  <strong>{{ $errors->first('especialidad') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="reset" class="btn btn-primary">Limpiar</button>
          </div>
        </div>
      </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection