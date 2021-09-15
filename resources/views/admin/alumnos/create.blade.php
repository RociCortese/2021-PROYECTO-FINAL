@extends('layouts.main', ['activePage' => 'alumno', 'titlePage' => __('')])
  
@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('alumnos.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card">
          <div class= "card-header card-header-primary">
          <h4 class="card-tittle">AGREGAR NUEVO ALUMNO</h4>
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
            <label class="col-sm-2 col-form-label">Grado</label>
            <div class="col-sm-7">
            <input type="text" name="grado" class="form-control">
            @if ($errors->has('domicilio'))
                <div id="grado-error" class="error text-danger pl-3" for="grado" style="display: block;">
                  <strong>{{ $errors->first('grado') }}</strong>
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