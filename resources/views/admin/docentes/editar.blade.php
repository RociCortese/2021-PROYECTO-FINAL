@extends('layouts.main', ['activePage' => 'docente', 'titlePage' => __('')])
  
@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('update',$id->id) }}" method="POST" class="form-horizontal">
        @csrf
        @METHOD('PUT')
        <div class="card">
          <div class= "card-header card-header-primary" style="background-color: grey;">
          <h4 class="card-title">Modificar docente</h4>
          </div>
        <div class="card-body">
          <div class="row">
            <label class="col-sm-2 col-form-label">DNI</label>
            <div class="col-sm-7">
            <input type="text" name="dni" class="form-control" value="{{$id->dni}}">

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
            <input type="text" name="nombre" class="form-control" value="{{$id->nombre}}">
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
            <input class="form-control" name="apellido" value="{{$id->apellido}}"></input>
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
            <input type="date" name="fechanacimiento" class="form-control" min="1951-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 18 years"));?>" value="{{$id->fechanacimiento}}">
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
            <select name="genero" id="opciongenero" class="form-control" value="{{$id->genero}}">
                    <option></option>
                    <option value="Femenino" <?php if($id->genero=='Femenino') echo 'selected="selected" ';?>>Femenino
                    <option value="Masculino" <?php if($id->genero=='Masculino') echo 'selected="selected" ';?>>Masculino
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
            <input type="text" name="domicilio" class="form-control" value="{{$id->domicilio}}">
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
            <input type="text" name="localidad" class="form-control" value="{{$id->localidad}}">
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
            <input type="text" name="provincia" class="form-control" value="{{$id->provincia}}">
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
            <select name="estadocivil" id="opcionestadocivil" class="form-control" value="{{$id->estadocivil}}">
                    <option></option>
                    <option value="Soltera/o" <?php if($id->estadocivil=='Soltera/o') echo 'selected="selected" ';?>>Soltera/o
                    <option value="Casada/o" <?php if($id->estadocivil=='Casada/o') echo 'selected="selected" ';?>>Casada/o
                    <option value="Divorciada/o" <?php if($id->estadocivil=='Divorciada/o') echo 'selected="selected" ';?>>Divorciada/o
                    <option value="Viuda/o" <?php if($id->estadocivil=='Viuda/o') echo 'selected="selected" ';?>>Viuda/o
                    <option value="En concubitato" <?php if($id->estadocivil=='En concubitato') echo 'selected="selected" ';?>>En concubitato

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
            <label class="col-sm-2 col-form-label">Legajo</label>
            <div class="col-sm-7">
            <input type="text" name="legajo" class="form-control" value="{{$id->legajo}}">
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
            <input type="text" name="especialidad" class="form-control" value="{{$id->especialidad}}">
            @if ($errors->has('especialidad'))
                <div id="especialidad-error" class="error text-danger pl-3" for="especialidad" style="display: block;">
                  <strong>{{ $errors->first('especialidad') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <i><div class="text-danger">*Recuerde que todos los campos son obligatorios.</div></i>
          <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar cambios</button>
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