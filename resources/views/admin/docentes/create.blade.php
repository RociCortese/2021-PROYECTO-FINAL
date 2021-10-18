
@extends('layouts.main', ['activePage' => 'docente', 'titlePage' => __('')])
  
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('docentes.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card">
          <div class= "card-header card-header-primary" style="background-color: grey;">
          <h4 class="card-title">Agregar nuevo docente</h4>
          </div>
        <div class="card-body">

           <br>

        <div class="row">
          <div class="col">
            <label><strong>DNI</strong></label>
              <input type="text" name="dni" class="form-control" value="{{ old('dni') }}">

            @if ($errors->has('dni'))
                <div id="dni-error" class="error text-danger pl-3" for="dni" style="display: block;">
                  <strong>{{ $errors->first('dni') }}</strong>
                </div>
              @endif
          
          </div>

        <div class="col">
            <label><strong>Nombre</strong></label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
            @if ($errors->has('nombre'))
                <div id="nombre-error" class="error text-danger pl-3" for="nombre" style="display: block;">
                  <strong>{{ $errors->first('nombre') }}</strong>
                </div>
              @endif
        </div>


        <div class="col">
          <label><strong>Apellido</strong></label>
            <input class="form-control" name="apellido" value="{{ old('apellido') }}"></input>
            @if ($errors->has('apellido'))
                <div id="apellido-error" class="error text-danger pl-3" for="apellido" style="display: block;">
                  <strong>{{ $errors->first('apellido') }}</strong>
                </div>
              @endif
            </div>
        </div>

        <br>

        <div class="row">
          <div class="col form-group">
          <label><strong>Fecha de nacimiento</strong></label>
            <input type="date" name="fechanacimiento" class="form-control  datetimepicker" min="1951-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 18 years"));?>" value="{{ old('fechanacimiento') }}">
            @if ($errors->has('fechanacimiento'))
                <div id="fechanacimiento-error" class="error text-danger pl-3" for="fechanacimiento" style="display: block;">
                  <strong>{{ $errors->first('fechanacimiento') }}</strong>
                </div>
              @endif
<script>
              $('.datetimepicker').datetimepicker({
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
    }
});
</script>
          </div>

            <div class="col">
                <label><strong>Género</strong></label>
                <select name="genero" id="opciongenero" class="form-control" value="{{ old('genero') }}">
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
                $("#opciongenero").val(value="{{ old('genero') }}")
                });
               </script>
            @if ($errors->has('genero'))
                <div id="genero-error" class="error text-danger pl-3" for="genero" style="display: block;">
                  <strong>{{ $errors->first('genero') }}</strong>
                </div>
              @endif
              
            </div>


            <div class="col">
              <label><strong>Estado civil</strong></label>
            <select name="estadocivil" id="opcionestadocivil" class="form-control" value="{{ old('estadocivil') }}" >
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
                $("#opcionestadocivil").val(value="{{ old('estadocivil') }}")
                });
               </script>
            @if ($errors->has('estadocivil'))
                <div id="estadocivil-error" class="error text-danger pl-3" for="estadocivil" style="display: block;">
                  <strong>{{ $errors->first('estadocivil') }}</strong>
                </div>
              @endif
            </div>
          
        </div>

        <br>
        <br>

        
        <div class="row">
          <div class="col">
            <label ><strong>Domicilio</strong></label>
            <input type="text" name="domicilio" class="form-control" value="{{ old('domicilio') }}">
            @if ($errors->has('domicilio'))
                <div id="domicilio-error" class="error text-danger pl-3" for="domicilio" style="display: block;">
                  <strong>{{ $errors->first('domicilio') }}</strong>
                </div>
              @endif
          </div>

            <div class="col">
              <label><strong>Localidad</strong></label>
            <input type="text" name="localidad" class="form-control" value="{{ old('localidad') }}">
            @if ($errors->has('localidad'))
                <div id="localidad-error" class="error text-danger pl-3" for="localidad" style="display: block;">
                  <strong>{{ $errors->first('localidad') }}</strong>
                </div>
              @endif
            </div>


            <div class="col">
                 <label><strong>Provincia</strong></label>
            <input type="text" name="provincia" class="form-control" value="{{ old('provincia') }}">
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
              <label><strong>Teléfono</strong></label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
            @if ($errors->has('telefono'))
                <div id="telefono-error" class="error text-danger pl-3" for="telefono" style="display: block;">
                  <strong>{{ $errors->first('telefono') }}</strong>
                </div>
              @endif
          </div>

          <div class="col">
            <label><strong>Correo electrónico</strong></label>
            <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Ingese su correo electrónico">
            @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            
          </div>
          
        </div>
    

    <br>
    <br>

           
          <div class="row">
              <div class="col">
            <label><strong>Legajo</strong></label>
            <input type="text" name="legajo" class="form-control" value="{{ old('legajo') }}">
            @if ($errors->has('legajo'))
                <div id="legajo-error" class="error text-danger pl-3" for="legajo" style="display: block;">
                  <strong>{{ $errors->first('legajo') }}</strong>
                </div>
              @endif
              </div>

          <div class="col">
            <label><strong>Especialidad</strong></label>
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