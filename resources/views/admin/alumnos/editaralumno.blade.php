@extends('layouts.main', ['activePage' => 'alumno', 'titlePage' => __('')])
 <?php
$detect = new Mobile_Detect;
?> 
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{route('alumnos.update',$alu->id) }}" method="POST" class="form-horizontal">
        @csrf
        @METHOD('PUT')
        <?php 
        if ($detect->isMobile() or $detect->isTablet()) {?>
      <div class="card" >
        <div class= "card-header card-header-info">
        <h4 class="card-title">Editar Alumno</h4>
        </div>
      <div class="card-body" >
        <div >
         <br>
         <h4 class="card-tittle text-center"><strong>DATOS DEL ALUMNO</strong></h4>

        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>DNI</label>
          <input type="text" name="dnialumno" class="form-control" value="{{$alu->dnialumno}}">
          @if ($errors->has('dnialumno'))
          <div id="dnialumno-error" class="error text-danger pl-3" for="dnialumno" style="display: block;">
          <strong>{{ $errors->first('dnialumno') }}</strong>
          </div>
          @endif
        </div>
         
        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Nombre</label>
          <input type="text" name="nombrealumno" class="form-control" value="{{$alu->nombrealumno}}">
          @if ($errors->has('nombrealumno'))
          <div id="nombrealumno-error" class="error text-danger pl-3" for="nombrealumno" style="display: block;">
          <strong>{{ $errors->first('nombrealumno') }}</strong>
          </div>
          @endif
        </div>
          
        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Apellido</label>
          <input class="form-control" name="apellidoalumno" value="{{$alu->apellidoalumno}}">
          @if ($errors->has('apellidoalumno'))
          <div id="apellidoalumno-error" class="error text-danger pl-3" for="apellidoalumno" style="display: block;">
          <strong>{{ $errors->first('apellidoalumno') }}</strong>
          </div>
          @endif
        </div>

       
        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Fecha de nacimiento</label>
          <input type="date" name="fechanacimiento" class="form-control" min="2006-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 5 years"));?>" value="{{$alu->fechanacimiento}}">
          @if ($errors->has('fechanacimiento'))
          <div id="fechanacimiento-error" class="error text-danger pl-3" for="fechanacimiento" style="display: block;">
          <strong>{{ $errors->first('fechanacimiento') }}</strong>
          </div>
          @endif
        </div>

        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Género</label>
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
        
        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Domicilio</label>
          <input type="text" name="domicilio" class="form-control" value="{{$alu->domicilio}}">
          @if ($errors->has('domicilio'))
          <div id="grado-error" class="error text-danger pl-3" for="domicilio" style="display: block;">
          <strong>{{ $errors->first('domicilio') }}</strong>
          </div>
          @endif
        </div>


        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Localidad</label>
          <input type="text" name="localidad" class="form-control" value="{{$alu->localidad}}">
          @if ($errors->has('localidad'))
          <div id="grado-error" class="error text-danger pl-3" for="localidad" style="display: block;">
          <strong>{{ $errors->first('localidad') }}</strong>
          </div>
          @endif
        </div>
          
        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Provincia</label>
          <input type="text" name="provincia" class="form-control" value="{{$alu->provincia}}" >
          @if ($errors->has('provincia'))
          <div id="grado-error" class="error text-danger pl-3" for="provincia" style="display: block;">
          <strong>{{ $errors->first('provincia') }}</strong>
          </div>
          @endif
        </div>
      
    </div> <!--cierra tarjeta de alumnos-->

           
      <div ><!--abre tarjeta de familia-->
       <br>
      <u><h4 class="card-tittle text-center"><strong>DATOS DE LA FAMILA</strong></h4></u>  
      <div id="familiar">

        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>DNI</label>
          <input type="text" name="dnifamilia" class="form-control" value="{{$fam->dnifamilia}}">
          @if ($errors->has('dnifamilia'))
          <div id="dnifamilia-error" class="error text-danger pl-3" for="dnifamilia" style="display: block;">
          <strong>{{ $errors->first('dnifamilia') }}</strong>
          </div>
          @endif
        </div>

        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Nombre</label>
          <input type="text" name="nombrefamilia" class="form-control" value="{{$fam->nombrefamilia}}" >
          @if ($errors->has('nombrefamilia'))
          <div id="nombrefamilia-error" class="error text-danger pl-3" for="nombrefamilia" style="display: block;">
          <strong>{{ $errors->first('nombrefamilia') }}</strong>
          </div>
          @endif
        </div>
          
        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Apellido</label>
          <input class="form-control" name="apellidofamilia" value="{{$fam->apellidofamilia}}" >
          @if ($errors->has('apellidofamilia'))
          <div id="apellidofamilia-error" class="error text-danger pl-3" for="apellidofamilia" style="display: block;">
          <strong>{{ $errors->first('apellidofamilia') }}</strong>
          </div>
          @endif
        </div>

        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Género</label>
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


        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Vínculo Familiar</label>
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

        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Teléfono celular</label>
          <input type="text" name="telefono" class="form-control" value="{{$fam->telefono}}" >
          @if ($errors->has('telefono'))
          <div id="telefono-error" class="error text-danger pl-3" for="telefono" style="display: block;">
          <strong>El campo debe ser del tipo numérico y contener 10 caracteres.</strong>
          </div>
          @endif
        </div>
         

        <div class="row" style="margin-right: 3px; margin-left: 3px;">
          <label>Correo electrónico</label>
          <input type="text" name="email" class="form-control" value="{{$fam->email}}" >
          @if ($errors->has('email'))
          <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
          <strong>{{ $errors->first('email') }}</strong>
          </div>
          @endif
        </div>

          
      </div>
      </div>  <!--cierra tarjeta de familia-->     
       <br> 
     <div class="text-right">
      <h4><span class="badge badge-danger">*Recuerde que todos los campos son obligatorios.</span></h4>
      </div>
     
      <div class="card-footer">
        <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
          <button type="submit" class="btn btn-sm btn-facebook">Guardar cambios</button>
        </div>
      </div>

    </div><!--cierra el card body-->
    </div> <!--cierra el card-->

    <!-- termina mobile--> 

    <?php 
    }
    else{?>
    <div class="card" >
      <div class= "card-header card-header-info">
      <h4 class="card-title">Editar Alumno</h4>
      </div>
    <div class="card-body" >
      <div class="card" style="border: thin solid lightgrey;">
      <br>
      <h4 class="card-tittle text-center"><strong>DATOS DEL ALUMNO</strong></h4>
      <br>

    <div class="row">
        <div class="col">
          <label>DNI</label>
          <input type="text" name="dnialumno" class="form-control" value="{{$alu->dnialumno}}">
          @if ($errors->has('dnialumno'))
          <div id="dnialumno-error" class="error text-danger pl-3" for="dnialumno" style="display: block;">
          <strong>{{ $errors->first('dnialumno') }}</strong>
          </div>
          @endif
        </div>
         
        <div class="col">
          <label>Nombre</label>
          <input type="text" name="nombrealumno" class="form-control" value="{{$alu->nombrealumno}}">
          @if ($errors->has('nombrealumno'))
          <div id="nombrealumno-error" class="error text-danger pl-3" for="nombrealumno" style="display: block;">
          <strong>{{ $errors->first('nombrealumno') }}</strong>
          </div>
          @endif
        </div>
          
        <div class="col">
          <label>Apellido</label>
          <input class="form-control" name="apellidoalumno" value="{{$alu->apellidoalumno}}">
          @if ($errors->has('apellidoalumno'))
          <div id="apellidoalumno-error" class="error text-danger pl-3" for="apellidoalumno" style="display: block;">
          <strong>{{ $errors->first('apellidoalumno') }}</strong>
          </div>
          @endif
        </div>
    </div>
    <br>   
    <div class="row">
        <div class="col">
          <label>Fecha de nacimiento</label>
          <input type="date" name="fechanacimiento" class="form-control" min="2006-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 5 years"));?>" value="{{$alu->fechanacimiento}}">
          @if ($errors->has('fechanacimiento'))
          <div id="fechanacimiento-error" class="error text-danger pl-3" for="fechanacimiento" style="display: block;">
          <strong>{{ $errors->first('fechanacimiento') }}</strong>
          </div>
          @endif
        </div>

        <div class="col">
          <label>Género</label>
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
    <br>
    <div class="row">
        <div class="col">
          <label>Domicilio</label>
          <input type="text" name="domicilio" class="form-control" value="{{$alu->domicilio}}">
          @if ($errors->has('domicilio'))
          <div id="grado-error" class="error text-danger pl-3" for="domicilio" style="display: block;">
          <strong>{{ $errors->first('domicilio') }}</strong>
          </div>
          @endif
        </div>

        <div class="col">
          <label>Localidad</label>
          <input type="text" name="localidad" class="form-control" value="{{$alu->localidad}}">
          @if ($errors->has('localidad'))
          <div id="grado-error" class="error text-danger pl-3" for="localidad" style="display: block;">
          <strong>{{ $errors->first('localidad') }}</strong>
          </div>
          @endif
        </div>
          
        <div class="col">
          <label>Provincia</label>
          <input type="text" name="provincia" class="form-control" value="{{$alu->provincia}}" >
          @if ($errors->has('provincia'))
          <div id="grado-error" class="error text-danger pl-3" for="provincia" style="display: block;">
          <strong>{{ $errors->first('provincia') }}</strong>
          </div>
          @endif
        </div>
    </div>
    <br>
  </div> <!--cierra tarjeta de alumnos-->

           
  <div class="card" style="border: thin solid lightgrey;"><!--abre tarjeta de familia-->
    <br>
  <h4 class="card-tittle text-center"><strong>DATOS DE LA FAMILIA</strong></h4>
    <div id="familiar">
    <div class="row">
        <div class="col">
          <label>DNI</label>
          <input type="text" name="dnifamilia" class="form-control" value="{{$fam->dnifamilia}}">
          @if ($errors->has('dnifamilia'))
          <div id="dnifamilia-error" class="error text-danger pl-3" for="dnifamilia" style="display: block;">
          <strong>{{ $errors->first('dnifamilia') }}</strong>
          </div>
          @endif
        </div>

        <div class="col">
          <label>Nombre</label>
          <input type="text" name="nombrefamilia" class="form-control" value="{{$fam->nombrefamilia}}" >
          @if ($errors->has('nombrefamilia'))
          <div id="nombrefamilia-error" class="error text-danger pl-3" for="nombrefamilia" style="display: block;">
          <strong>{{ $errors->first('nombrefamilia') }}</strong>
          </div>
          @endif
        </div>
          
        <div class="col">
          <label>Apellido</label>
          <input class="form-control" name="apellidofamilia" value="{{$fam->apellidofamilia}}" >
          @if ($errors->has('apellidofamilia'))
          <div id="apellidofamilia-error" class="error text-danger pl-3" for="apellidofamilia" style="display: block;">
          <strong>{{ $errors->first('apellidofamilia') }}</strong>
          </div>
          @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
          <label>Género</label>
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

        <div class="col">
          <label>Vínculo Familiar</label>
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
    <br>
    <div class="row">
        <div class="col">
          <label>Teléfono celular</label>
          <input type="text" name="telefono" class="form-control" value="{{$fam->telefono}}" >
          @if ($errors->has('telefono'))
          <div id="telefono-error" class="error text-danger pl-3" for="telefono" style="display: block;">
          <strong>El campo debe ser del tipo numérico y contener 10 caracteres.</strong>
          </div>
          @endif
        </div>
         
        <div class="col">
          <label>Correo electrónico</label>
          <input type="text" name="email" class="form-control" value="{{$fam->email}}" >
          @if ($errors->has('email'))
          <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
          <strong>{{ $errors->first('email') }}</strong>
          </div>
          @endif
        </div>

    </div>
    <br>
    </div>
  </div>  <!--cierra tarjeta de familia-->     
        
  <div class="text-right">
    <h4><span class="badge badge-danger">*Recuerde que todos los campos son obligatorios.</span></h4>
  </div>
     
  <div class="card-footer">
    <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
    <button type="submit" class="btn btn-sm btn-facebook">Guardar cambios</button>
    </div>
  </div>

  </div><!--cierra el card body-->
  </div> <!--cierra el card-->
  <?php 
  }
  ?>
        </form>
      </div>
    </div>
  </div>
</div>         
@endsection