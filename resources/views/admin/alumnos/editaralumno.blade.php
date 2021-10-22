@extends('layouts.main', ['activePage' => 'alumno', 'titlePage' => __('')])
  
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{route('alumnos.update',$alu->id) }}" method="POST" class="form-horizontal">
        @csrf
        @METHOD('PUT')
        <div class="card" >
          <div class= "card-header card-header-info">
          <h4 class="card-title">Editar alumno</h4>
          </div>
        <div class="card-body" >
          <div class="card" style="border: 3px solid grey">
         <h4 class="card-tittle text-center"><strong>Datos del Alumno</strong></h4>
          <div class="row">
            <label class="col-sm-2 col-form-label">DNI</label>
            <div class="col-sm-7">
            <input type="text" name="dnialumno" class="form-control" value="{{$alu->dnialumno}}">
            @if ($errors->has('dnialumno'))
                <div id="dnialumno-error" class="error text-danger pl-3" for="dnialumno" style="display: block;">
                  <strong>{{ $errors->first('dnialumno') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-7">
            <input type="text" name="nombrealumno" class="form-control" value="{{$alu->nombrealumno}}">
            @if ($errors->has('nombrealumno'))
                <div id="nombrealumno-error" class="error text-danger pl-3" for="nombrealumno" style="display: block;">
                  <strong>{{ $errors->first('nombrealumno') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Apellido</label>
            <div class="col-sm-7">
            <input class="form-control" name="apellidoalumno" value="{{$alu->apellidoalumno}}">
            @if ($errors->has('apellidoalumno'))
                <div id="apellidoalumno-error" class="error text-danger pl-3" for="apellidoalumno" style="display: block;">
                  <strong>{{ $errors->first('apellidoalumno') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 col-form-label">Fecha de nacimiento</label>
            <div class="col-sm-7">
            <input type="date" name="fechanacimiento" class="form-control" min="2006-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 5 years"));?>" value="{{$alu->fechanacimiento}}">
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
            <select name="generoalumno" id="opciongenero" class="form-control" value="{{$alu->generoalumno}}" >
                    <option></option>
                    <option value="Femenino" <?php if($alu->generoalumno=='Femenino') echo 'selected="selected" ';?>>Femenino
                    <option value="Masculino" <?php if($alu->generoalumno=='Masculino') echo 'selected="selected" ';?>>Masculino
                </select>
            @if ($errors->has('generoalumno'))
                <div id="generoalumno-error" class="error text-danger pl-3" for="generoalumno" style="display: block;">
                  <strong>{{ $errors->first('generoalumno') }}</strong>
                </div>
              @endif
            </div>
          </div>
        
          <div class="row">
            <label class="col-sm-2 col-form-label">Domicilio</label>
            <div class="col-sm-7">
            <input type="text" name="domicilio" class="form-control" value="{{$alu->domicilio}}">
            @if ($errors->has('domicilio'))
                <div id="grado-error" class="error text-danger pl-3" for="domicilio" style="display: block;">
                  <strong>{{ $errors->first('domicilio') }}</strong>
                </div>
              @endif
            </div>
          </div>

           <div class="row">
            <label class="col-sm-2 col-form-label">Localidad</label>
            <div class="col-sm-7">
            <input type="text" name="localidad" class="form-control" value="{{$alu->localidad}}">
            @if ($errors->has('localidad'))
                <div id="grado-error" class="error text-danger pl-3" for="localidad" style="display: block;">
                  <strong>{{ $errors->first('localidad') }}</strong>
                </div>
              @endif
            </div>
          </div>

           <div class="row">
            <label class="col-sm-2 col-form-label">Provincia</label>
            <div class="col-sm-7">
            <input type="text" name="provincia" class="form-control" value="{{$alu->provincia}}" >
            @if ($errors->has('provincia'))
                <div id="grado-error" class="error text-danger pl-3" for="provincia" style="display: block;">
                  <strong>{{ $errors->first('provincia') }}</strong>
                </div>
              @endif
            </div>
          </div>
          </div>
          <div class="card" style="border: 3px solid grey">
          <h4 class="card-tittle text-center"><strong>Datos de la Familia</strong></h4>
          <div id="familiar">
          <div class="row">
            <label class="col-sm-2 col-form-label">DNI</label>
            <div class="col-sm-7">
            <input type="text" name="dnifamilia" class="form-control" value="{{$fam->dnifamilia}}">
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
            <input type="text" name="nombrefamilia" class="form-control" value="{{$fam->nombrefamilia}}" >
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
            <input class="form-control" name="apellidofamilia" value="{{$fam->apellidofamilia}}" >
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
            <select name="generofamilia" id="opciongenerofamilia" class="form-control" value="{{$fam->generofamilia}}">
                    <option></option>
                    <option value="Femenino" <?php if($fam->generofamilia=='Femenino') echo 'selected="selected" ';?>>Femenino
                    <option value="Masculino" <?php if($fam->generofamilia=='Masculino') echo 'selected="selected" ';?>>Masculino
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
            <input type="text" name="telefono" class="form-control" value="{{$fam->telefono}}" >
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
            <input type="text" name="email" class="form-control" value="{{$fam->email}}" >
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
              <select name="vinculofamiliar" id="opcionvinculo" class="form-control" value="{{$fam->vinculofamiliar}}">
                    <option></option>
                    <option value="Madre" <?php if($fam->vinculofamiliar=='Madre') echo 'selected="selected" ';?>>Madre
                    <option value="Padre" <?php if($fam->vinculofamiliar=='Padre') echo 'selected="selected" ';?>>Padre
                    <option value="Tutor" <?php if($fam->vinculofamiliar=='Tutor') echo 'selected="selected" ';?>>Tutor   
                </select>

            @if ($errors->has('vinculofamiliar'))
                <div id="vinculofamiliar-error" class="error text-danger pl-3" for="vinculofamiliar" style="display: block;">
                  <strong>{{ $errors->first('vinculofamiliar') }}</strong>
                </div>
              @endif
            </div>
          </div>
            
            <i><div class="text-danger">*Recuerde que todos los campos son obligatorios.</div></i>
            </div>
          </div>
  
  </div>
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