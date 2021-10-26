
@extends('layouts.main', ['activePage' => 'docente', 'titlePage' => __('')])
  
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('docentes.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card">
          <div class= "card-header card-header-info">
          <h4 class="card-title">Agregar nuevo docente</h4>
          </div>
        <div class="card-body">

           <br>

        <div class="row">
          <div class="col">
            <label>DNI</label>
              <input type="text" name="dnidocente" class="form-control" value="{{ old('dnidocente') }}">

            @if ($errors->has('dnidocente'))
                <div id="dnidocente-error" class="error text-danger pl-3" for="dnidocente" style="display: block;">
                  <strong>{{ $errors->first('dnidocente') }}</strong>
                </div>
              @endif
          
          </div>

        <div class="col">
            <label>Nombre</label>
            <input type="text" name="nombredocente" class="form-control" value="{{ old('nombredocente') }}">
            @if ($errors->has('nombredocente'))
                <div id="nombredocente-error" class="error text-danger pl-3" for="nombredocente" style="display: block;">
                  <strong>{{ $errors->first('nombredocente') }}</strong>
                </div>
              @endif
        </div>


        <div class="col">
          <label>Apellido</label>
            <input class="form-control" name="apellidodocente" value="{{ old('apellidodocente') }}"></input>
            @if ($errors->has('apellidodocente'))
                <div id="apellidodocente-error" class="error text-danger pl-3" for="apellidodocente" style="display: block;">
                  <strong>{{ $errors->first('apellidodocente') }}</strong>
                </div>
              @endif
            </div>
        </div>

        <br>

        <div class="row">
          <div class="col form-group">
          <label>Fecha de nacimiento</label>
            <input type="date" name="fechanacimientodoc" class="form-control" min="1951-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 18 years"));?>" value="{{ old('fechanacimientodoc') }}">
            @if ($errors->has('fechanacimientodoc'))
                <div id="fechanacimientodoc-error" class="error text-danger pl-3" for="fechanacimientodoc" style="display: block;">
                  <strong>{{ $errors->first('fechanacimientodoc') }}</strong>
                </div>
              @endif
          </div>

            <div class="col">
                <label>Género</label>
                <select name="generodocente" id="opciongenero" class="form-control" value="{{ old('generodocente') }}">
                    <option value="">Seleccione una opción</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                </select>
                <script
                  src="https://code.jquery.com/jquery-3.2.0.min.js"
                  integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I="
                  crossorigin="anonymous">
               </script>
                <script>
                $(function(){
                $("#opciongenero").val(value="{{ old('generodocente') }}")
                });
               </script>
            @if ($errors->has('generodocente'))
                <div id="generodocente-error" class="error text-danger pl-3" for="generodocente" style="display: block;">
                  <strong>{{ $errors->first('generodocente') }}</strong>
                </div>
              @endif
              
            </div>


            <div class="col">
              <label>Estado civil</label>
            <select name="estadocivildoc" id="opcionestadocivil" class="form-control" value="{{ old('estadocivildoc') }}" >
                    <option value="">Seleccione una opción</option>
                    <option value="Soltera/o">Soltera/o</option>
                    <option value="Casada/o">Casada/o</option>
                    <option value="Divorciada/o">Divorciada/o</option>
                    <option value="Viuda/o">Viuda/o</option>
                    <option value="En concubitato">En concubitato</option>
                </select>
                <script
                  src="https://code.jquery.com/jquery-3.2.0.min.js"
                  integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I="
                  crossorigin="anonymous">
               </script>
                <script>
                $(function(){
                $("#opcionestadocivil").val(value="{{ old('estadocivildoc') }}")
                });
               </script>
            @if ($errors->has('estadocivildoc'))
                <div id="estadocivil-error" class="error text-danger pl-3" for="estadocivildoc" style="display: block;">
                  <strong>{{ $errors->first('estadocivildoc') }}</strong>
                </div>
              @endif
            </div>
          
        </div>

        <br>
        <br>

        
        <div class="row">
          <div class="col">
            <label>Domicilio</label>
            <input type="text" name="domiciliodocente" class="form-control" value="{{ old('domiciliodocente') }}">
            @if ($errors->has('domiciliodocente'))
                <div id="domiciliodocente-error" class="error text-danger pl-3" for="domiciliodocente" style="display: block;">
                  <strong>{{ $errors->first('domiciliodocente') }}</strong>
                </div>
              @endif
          </div>

            <div class="col">
              <label>Localidad</label>
            <input type="text" name="localidaddocente" class="form-control" value="{{ old('localidaddocente') }}">
            @if ($errors->has('localidaddocente'))
                <div id="localidaddocente-error" class="error text-danger pl-3" for="localidaddocente" style="display: block;">
                  <strong>{{ $errors->first('localidaddocente') }}</strong>
                </div>
              @endif
            </div>


            <div class="col">
                 <label>Provincia</label>
            <input type="text" name="provinciadocente" class="form-control" value="{{ old('provinciadocente') }}">
            @if ($errors->has('provinciadocente'))
                <div id="provinciadocente-error" class="error text-danger pl-3" for="provinciadocente" style="display: block;">
                  <strong>{{ $errors->first('provinciadocente') }}</strong>
                </div>
              @endif
            </div>

          
        </div>
        <br>

        <div class="row">

          <div class="col">
              <label>Teléfono</label>
            <input type="text" name="telefonodocente" class="form-control" value="{{ old('telefonodocente') }}">
            @if ($errors->has('telefonodocente'))
                <div id="telefonodocente-error" class="error text-danger pl-3" for="telefonodocente" style="display: block;">
                  <strong>{{ $errors->first('telefonodocente') }}</strong>
                </div>
              @endif
          </div>

          <div class="col">
            <label>Correo electrónico</label>
            <input type="text" name="emaildocente" class="form-control" value="{{ old('emaildocente') }}" placeholder="Ingese su correo electrónico">
            @if ($errors->has('emaildocente'))
                <div id="emaildocente-error" class="error text-danger pl-3" for="emaildocente" style="display: block;">
                  <strong>{{ $errors->first('emaildocente') }}</strong>
                </div>
              @endif
            
          </div>
          
        </div>
    

    <br>
    <br>

           
          <div class="row">
              <div class="col">
            <label class="text-light">Legajo</label>
            <input type="text" name="legajo" class="form-control" value="{{ old('legajo') }}">
            @if ($errors->has('legajo'))
                <div id="legajo-error" class="error text-danger pl-3" for="legajo" style="display: block;">
                  <strong>{{ $errors->first('legajo') }}</strong>
                </div>
              @endif
              </div>

          <div class="col">
            <label class="text-light">Especialidad</label>
            <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad') }}">
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
                <button type="submit" class="btn btn-sm btn-facebook">Guardar</button>
                <button type="reset" class="btn btn-sm btn-facebook">Limpiar</button>
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