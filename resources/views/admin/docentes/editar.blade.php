@extends('layouts.main', ['activePage' => 'docente', 'titlePage' => __('')])
  
@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('docentes.update',$id->id) }}" method="POST" class="form-horizontal">
        @csrf
        @METHOD('PUT')
        <div class="card">
          <div class= "card-header card-header-info">
          <h4 class="card-title">Editar Docente</h4>
          </div>
        <div class="card-body">
         
         <br>
          <div class="row">
            
            <div class="col">
            <label>DNI</label>
            <input type="text" name="dni" class="form-control" value="{{$id->dnidocente}}">
            @if ($errors->has('dni'))
                <div id="dni-error" class="error text-danger pl-3" for="dni" style="display: block;">
                  <strong>{{ $errors->first('dni') }}</strong>
                </div>
              @endif
            </div>
            
            
            <div class="col">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{$id->nombredocente}}">
            @if ($errors->has('nombre'))
                <div id="nombre-error" class="error text-danger pl-3" for="nombre" style="display: block;">
                  <strong>{{ $errors->first('nombre') }}</strong>
                </div>
              @endif
            </div>
         


            <div class="col">
            <label>Apellido</label>
            <input class="form-control" name="apellido" value="{{$id->apellidodocente}}"></input>
            @if ($errors->has('apellido'))
                <div id="apellido-error" class="error text-danger pl-3" for="apellido" style="display: block;">
                  <strong>{{ $errors->first('apellido') }}</strong>
                </div>
              @endif
            </div>
         


          </div>

          <br>
          
       


          <div class="row">
           

           <div class="col">
            <label>Fecha de nacimiento</label>
            <input type="date" name="fechanacimiento" class="form-control" min="1951-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 18 years"));?>" value="{{$id->fechanacimientodoc}}">
            @if ($errors->has('fechanacimiento'))
                <div id="fechanacimiento-error" class="error text-danger pl-3" for="fechanacimiento" style="display: block;">
                  <strong>{{ $errors->first('fechanacimiento') }}</strong>
                </div>
              @endif
          </div>


            <div class="col">
            <label>Género</label>
            <select name="generodocente" id="opciongenero" class="form-control" value="{{$id->generodocente}}">
                    <option></option>
                    <option value="Femenino" <?php if($id->generodocente=='Femenino') echo 'selected="selected" ';?>>Femenino
                    <option value="Masculino" <?php if($id->generodocente=='Masculino') echo 'selected="selected" ';?>>Masculino
                </select>
            @if ($errors->has('generodocente'))
                <div id="generodocente-error" class="error text-danger pl-3" for="generodocente" style="display: block;">
                  <strong>{{ $errors->first('generodocente') }}</strong>
                </div>
              @endif
            </div>
        

            <div class="col">
            <label>Estado civil</label>
            <select name="estadocivildoc" id="opcionestadocivil" class="form-control" value="{{$id->estadocivildoc}}">
                    <option></option>
                    <option value="Soltera/o" <?php if($id->estadocivildoc=='Soltera/o') echo 'selected="selected" ';?>>Soltera/o
                    <option value="Casada/o" <?php if($id->estadocivildoc=='Casada/o') echo 'selected="selected" ';?>>Casada/o
                    <option value="Divorciada/o" <?php if($id->estadocivildoc=='Divorciada/o') echo 'selected="selected" ';?>>Divorciada/o
                    <option value="Viuda/o" <?php if($id->estadocivildoc=='Viuda/o') echo 'selected="selected" ';?>>Viuda/o
                    <option value="En concubitato" <?php if($id->estadocivildoc=='En concubitato') echo 'selected="selected" ';?>>En concubitato
                </select>
            @if ($errors->has('estadocivildoc'))
                <div id="estadocivildoc-error" class="error text-danger pl-3" for="estadocivildoc" style="display: block;">
                  <strong>{{ $errors->first('estadocivildoc') }}</strong>
                </div>
              @endif
            </div>
    


          </div>

          <br>

          <div class="row">
            <div class="col">
            <label>Domicilio</label>
            <input type="text" name="domicilio" class="form-control" value="{{$id->domiciliodocente}}">
            @if ($errors->has('domicilio'))
                <div id="domicilio-error" class="error text-danger pl-3" for="domicilio" style="display: block;">
                  <strong>{{ $errors->first('domicilio') }}</strong>
                </div>
              @endif
            </div>

 
         <div class="col">
            <label >Localidad</label>
            <input type="text" name="localidad" class="form-control" value="{{$id->localidaddocente}}">
            @if ($errors->has('localidad'))
                <div id="localidad-error" class="error text-danger pl-3" for="localidad" style="display: block;">
                  <strong>{{ $errors->first('localidad') }}</strong>
                </div>
              @endif
            </div>
         

            <div class="col">
            <label>Provincia</label>
            <input type="text" name="provincia" class="form-control" value="{{$id->provinciadocente}}">
            @if ($errors->has('provincia'))
                <div id="provincia-error" class="error text-danger pl-3" for="provincia" style="display: block;">
                  <strong>{{ $errors->first('provincia') }}</strong>
                </div>
              @endif
            </div>
         


          </div> 
         

          <br>

          <div class="row">

            <div class="col"> 
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{$id->telefonodocente}}">
            @if ($errors->has('telefono'))
                <div id="telefono-error" class="error text-danger pl-3" for="telefono" style="display: block;">
                  <strong>{{ $errors->first('telefono') }}</strong>
                </div>
              @endif
            </div>


            <div class="col">
            <label>Correo electrónico</label>
            <input type="text" name="email" class="form-control" value="{{$id->emaildocente}}">
            @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>
          

          </div>
        
          <br>
        
          <div class="row">

            <div class="col">
            <label >Legajo</label>
            <input type="text" name="legajo" class="form-control" value="{{$id->legajo}}">
            @if ($errors->has('legajo'))
                <div id="legajo-error" class="error text-danger pl-3" for="legajo" style="display: block;">
                  <strong>{{ $errors->first('legajo') }}</strong>
                </div>
              @endif
            </div>
          
            <div class="col">
            <label>Especialidad</label>
            <input type="text" name="especialidad" class="form-control" value="{{$id->especialidad}}">
            @if ($errors->has('especialidad'))
                <div id="especialidad-error" class="error text-danger pl-3" for="especialidad" style="display: block;">
                  <strong>{{ $errors->first('especialidad') }}</strong>
                </div>
              @endif
            </div>
        



          </div>

           <br>

          <div class="text-right">
            <h4><span class="badge badge-danger">*Recuerde que todos los campos son obligatorios.</span></h4>
          </div>

          <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar cambios</button>
          </div>
        </div>
      
        </form>
      </div>
    </div>
  </div>
</div>
@endsection