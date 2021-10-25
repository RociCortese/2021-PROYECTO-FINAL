@extends('layouts.main', ['activePage' => 'alumno', 'titlePage' => __('')])
  
@section('content')

<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript">
function mostrar() {
    var x = document.getElementById('familiar');
    if (x.style.display =='none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
$('#check').on('change', function() {
        $( ".check" ).prop( "disabled", $(this).is(':checked'))
});
</script>
<script>
function deshabilitar(valor){
var elemento = document.getElementById('check');
var hipervinculo = document.getElementById('link');
if(elemento.checked){
hipervinculo.href = valor;
}else{
hipervinculo.href = '';
}
}
</script>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form class="form-horizontal" name="formalumnos">
        @csrf
        <div class="card" >
          <div class= "card-header card-header-info">
          <h4 class="card-title">Agregar nuevo Alumno</h4>
          </div>
        <div class="card-body" >


    <div class="card" style="border: thin solid lightgrey;">
            <br>
         <h4 class="card-tittle text-center"><strong>DATOS DEL ALUMNO</strong></h4>

          <br>

          <div class="row">
            <div class="col">
              <label>DNI</label>
            <input type="text" name="dnialumno" class="form-control" value="{{ old('dnialumno') }}">
            @if ($errors->has('dnialumno'))
                <div id="dnialumno-error" class="error text-danger pl-3" for="dnialumno" style="display: block;">
                  <strong>{{ $errors->first('dnialumno') }}</strong>
                </div>
              @endif
            </div>
          
            
          <div class="col">
              <label>Nombre</label>
            <input type="text" name="nombrealumno" class="form-control" value="{{ old('nombrealumno') }}">
            @if ($errors->has('nombrealumno'))
              <div id="nombrealumno-error" class="error text-danger pl-3" for="nombrealumno" style="display: block;">
                  <strong>{{ $errors->first('nombrealumno') }}</strong>
              </div>
              @endif
            </div>


          <div class="col">       
              <label>Apellido</label>
            <input class="form-control" name="apellidoalumno" value="{{ old('apellidoalumno') }}"></input>
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
            <input type="date"  id="datepicker" name="fechanacimiento" class="form-control" min="2006-01-01" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 5 years"));?>" value="{{ old('fechanacimiento') }}">
            @if ($errors->has('fechanacimiento'))
                <div id="fechanacimiento-error" class="error text-danger pl-3" for="fechanacimiento" style="display: block;">
                  <strong>{{ $errors->first('fechanacimiento') }}</strong>
                </div>
              @endif
            </div>
           
          <div class="col">
            <label>Género</label>
            <select name="generoalumno" id="opciongenero" class="form-control" value="{{ old('generoalumno') }}">
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
                $("#opciongenero").val(value="{{ old('generoalumno') }}")
                });
               </script>
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
            <input type="text" name="domicilio" class="form-control" value="{{ old('domicilio') }}">
            @if ($errors->has('domicilio'))
                <div id="grado-error" class="error text-danger pl-3" for="domicilio" style="display: block;">
                  <strong>{{ $errors->first('domicilio') }}</strong>
                </div>
              @endif
            </div>
          

        <div class="col">
            <label>Localidad</label>
            <input type="text" name="localidad" class="form-control" value="{{ old('localidad') }}">
            @if ($errors->has('localidad'))
                <div id="grado-error" class="error text-danger pl-3" for="localidad" style="display: block;">
                  <strong>{{ $errors->first('localidad') }}</strong>
                </div>
              @endif
            </div>
          
          <div class="col">
            <label>Provincia</label>
            <input type="text" name="provincia" class="form-control" value="{{ old('provincia') }}">
            @if ($errors->has('provincia'))
                <div id="grado-error" class="error text-danger pl-3" for="provincia" style="display: block;">
                  <strong>{{ $errors->first('provincia') }}</strong>
                </div>
              @endif
            </div>
     


  
      </div>

      <br>
      <br>
       
        
        </div>

          <div class="card" style="border: thin solid lightgrey;">
            <br>
          <h4 class="card-tittle text-center"><strong>DATOS DE LA FAMILIA</strong></h4>
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
            <input name="buscarapellidofamilia" class="form-control" type="search" placeholder="Buscar por apellido del familiar" value="{{$apellidofam}}">
            <div class="card-footer">
          <div>
            <button class="btn btn-sm btn-facebook" type="submit" formaction="{{route('alumnos.create')}}">Buscar</button>
            <a href="{{url ('admin/alumnos/create') }}" class="btn btn-sm btn-facebook">Limpiar</a>
          </div>
        </div>
        <div>
          <div class="col">
           <h4> <span class="badge badge-info">(*) En caso que ya se encuentre cargado, seleccione el familiar correspondiente.</span></h4>
          </div>
          <table class="table">
                    <thead class="text-primary">
                      <th>(*)</th>
                      <th>ID</th>
                      <th>DNI</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                    </thead>
                    <tbody>
                      @foreach($familias as $fam)
                        <tr>
                          <td class="v-align-middle">
                          <input type="checkbox" value="{{$fam->id}}" id="check" name="check" onclick="botonalumnos.disabled =this.checked" onclick="deshabilitar('');"></td>
                          <td class="v-align-middle">{{$fam->id}}</td>
                          <td class="v-align-middle">{{$fam->dnifamilia}}</td>
                          <td class="v-align-middle">{{$fam->nombrefamilia}}</td>
                          <td class="v-align-middle">{{$fam->apellidofamilia}}</td>
                          <td class="td-actions td-actions v-align-middle">
                          <a href="{{route('showfam', $fam->id)}}" class="btn btn-info" title="Ver mas Información"><i class="material-icons">person</i></a>
                          <a href="{{ route('editarfam',$fam->id) }}" class="btn btn-warning" title="Modificar familia">
                        <i class="material-icons">edit</i></a>
                        </a>
                          </td>                                      
                      @endforeach
                    </tbody>
                    
                  </table>
                </div>
                  <div class="card-footer mr-auto">
                {{$familias->links() }}
              </div>
              <div class="card-footer">
          <div class=" col-xs-12 col-sm-12 col-md-12 text-center">
          <a href="#" class="btn btn-sm btn-facebook" name="botonalumnos" onclick="mostrar()" id="link" style="color: white;">Crear nuevo familiar</a>
        </div>
      </div>
          <div id="familiar" style="display: none;">
          <div class="row">
            <label class="col-sm-2 col-form-label">DNI</label>
            <div class="col-sm-7">
            <input type="text" name="dnifamilia" class="form-control" value="{{ old('dnifamilia') }}">
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
            <input type="text" name="nombrefamilia" class="form-control" value="{{ old('nombrefamilia') }}">
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
            <input class="form-control" name="apellidofamilia" value="{{ old('apellidofamilia') }}"></input>
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
            <select name="generofamilia" id="opciongenerofamilia" class="form-control" value="{{ old('generofamilia') }}">
                    <option></option>
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
                $("#opciongenerofamilia").val(value="{{ old('generofamilia') }}")
                });
               </script>
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
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
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
            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
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
              <select name="vinculofamiliar" id="opcionvinculo" class="form-control" value="{{ old('vinculofamiliar') }}">

                    <option></option>
                    <option value="Madre">Madre</option>
                    <option value="Padre">Padre</option>
                    <option value="Tutor">Tutor</option>  
                </select>

            <script
                  src="https://code.jquery.com/jquery-3.2.0.min.js"
                  integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I="
                  crossorigin="anonymous">
               </script>
                <script>
                $(function(){
                $("#opcionvinculo").val(value="{{ old('vinculofamiliar') }}")
                });
               </script>
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
                <button type="submit" class="btn btn-sm btn-facebook" formaction="{{ route('alumnos.store') }}" formmethod="POST">Guardar</button>
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