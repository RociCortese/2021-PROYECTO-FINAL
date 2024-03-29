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
</script>
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
            @if($maximogrado=='Seis')
            <div class="col">
            <label>Grado</label>
            <?php
            ?>
            <select name="grado" id="grado" class="form-control" value="{{ old('grado') }}">
              <?php
            $nombredivision = preg_replace('/[\[\]\.\;\" "]+/', '', $nombredivision);
            $contador=count($nombredivision)-1;
            ?>
            <option></option>
            <?php
            for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Primer grado {{$nombredivision[$i]}}">Primer grado {{$nombredivision[$i]}} </option>
            <?php
              }
            for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Segundo grado {{$nombredivision[$i]}}">Segundo grado {{$nombredivision[$i]}} </option>
            <?php
              }
            for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Tercer grado {{$nombredivision[$i]}}">Tercer grado {{$nombredivision[$i]}}</option>
            <?php
              }  
            for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Cuarto grado {{$nombredivision[$i]}}">Cuarto grado {{$nombredivision[$i]}}</option>
            <?php
              }
              for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Quinto grado {{$nombredivision[$i]}}">Quinto grado {{$nombredivision[$i]}}</option>
            <?php
              }
              for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Quinto grado {{$nombredivision[$i]}}">Quinto grado {{$nombredivision[$i]}}</option>
            <?php
              }
              for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Sexto grado {{$nombredivision[$i]}}">Sexto grado {{$nombredivision[$i]}}</option>
              <?php
              }     
              ?>         
          </select>
            @if ($errors->has('grado'))
                <div id="grado-error" class="error text-danger pl-3" for="grado" style="display: block;">
                  <strong>{{ $errors->first('grado') }}</strong>
                </div>
              @endif
            </div>
            @endif

            @if($maximogrado=='Siete')
            <div class="col">
            <label>Grado</label>
            <?php
            ?>
            <select name="grado" id="grado" class="form-control" value="{{ old('grado') }}">
              <?php
            $nombredivision = preg_replace('/[\[\]\.\;\" "]+/', '', $nombredivision);
            $contador=count($nombredivision)-1;
            ?>
            <option value=""></option>
            <?php
            for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Primer grado {{$nombredivision[$i]}}">Primer grado {{$nombredivision[$i]}} </option>
            <?php
              }
            for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Segundo grado {{$nombredivision[$i]}}">Segundo grado {{$nombredivision[$i]}} </option>
            <?php
              }
            for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Tercer grado {{$nombredivision[$i]}}">Tercer grado {{$nombredivision[$i]}}</option>
            <?php
              }  
            for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Cuarto grado {{$nombredivision[$i]}}">Cuarto grado {{$nombredivision[$i]}}</option>
            <?php
              }
              for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Quinto grado {{$nombredivision[$i]}}">Quinto grado {{$nombredivision[$i]}}</option>
            <?php
              }
              for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Quinto grado {{$nombredivision[$i]}}">Quinto grado {{$nombredivision[$i]}}</option>
            <?php
              }
              for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Sexto grado {{$nombredivision[$i]}}">Sexto grado {{$nombredivision[$i]}}</option>
            <?php
              }   
              for ($i=0; $i <=$contador ; $i++) { 
              ?>
                    <option value="Séptimo grado {{$nombredivision[$i]}}">Séptimo grado {{$nombredivision[$i]}}</option>
            <?php
              }     
              ?>         
          </select>
            @if ($errors->has('grado'))
                <div id="grado-error" class="error text-danger pl-3" for="grado" style="display: block;">
                  <strong>{{ $errors->first('grado') }}</strong>
                </div>
              @endif
            </div>
            @endif
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
            @if ($familias->isEmpty())
             <div class=" col-xs-12 col-sm-12 col-md-12 text-right">
                <input type="button" class="btn btn-sm btn-facebook" id="botonalumnos" name="botonalumnos" data-toggle="modal" data-target="#myModal" value="Crear nuevo familiar"></input>
              </div>
                  <div style="margin-left: 10px;"> Aún no hay familias creadas.</div>
                  <br>
                  @else
              <div class="text-right" style="margin-right:10px;">
                <button class="btn btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Filtrar familia"><span class="material-icons">filter_list</span></button>
                    <div class="collapse" id="collapseExample">
                    <div class="card card-body" style="border: thin solid lightgrey;">
                      <form>
                        <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido" aria-label="Search">
                        <div class="text-right"><button class="btn btn-sm btn-facebook"formaction="{{route('alumnos.create')}}" type="submit">Buscar</button>
                      <a href="{{url ('admin/alumnos/create') }}" class="btn btn-sm btn-facebook"> Limpiar </a>
                    </div>
                      </form>
                    </div>
                    </div>
                    <a type="button" class="btn btn-sm btn-facebook" id="botonalumnos" name="botonalumnos" data-toggle="modal" data-target="#myModal" style="color: white;">
                    <i class="material-icons">person_add_alt</i></a>
                  </div>
          <div class="col">
           <h4> <span class="badge badge-info">(*) En caso que ya se encuentre cargado, seleccione el familiar correspondiente.</span></h4>
          </div>
          <br>
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
                          <input type="checkbox" value="{{$fam->id}}" id="check" name="check" onclick="botonalumnos.disabled =this.checked"></td>
                          <td class="v-align-middle">{{$fam->id}}</td>
                          <td class="v-align-middle">{{$fam->dnifamilia}}</td>
                          <td class="v-align-middle">{{$fam->nombrefamilia}}</td>
                          <td class="v-align-middle">{{$fam->apellidofamilia}}</td>
                          <td class="td-actions td-actions v-align-middle">
                         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal{{$fam->id}}" title="Ver información de familia">
                            <i class="bi bi-person"></i>
                          </button>
                          <div class="modal fade bd-example-modal-lg" id="myModal{{$fam->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header" style="background-color: lightblue;">
                          <h5 class="modal-title" id="exampleModalLabel"><strong>Vista detallada del familiar {{$fam->nombrefamilia}} {{$fam->apellidofamilia}}</strong></h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body ">
                            <table class="table">
                              <tr>
                                <td class="v-align-middle" >
                                <label>DNI:</label>  {{$fam->dnifamilia}}
                                </td>
                              </tr>
                              <tr> 
                                <td class="v-align-middle">
                                <label>Género:</label>  {{$fam->generofamilia}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle">
                                <label>Teléfono:</label>  {{$fam->telefono}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle">
                                <label>Email:</label>  {{$fam->email}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle">
                                <label>Vínculo Familiar:</label>  {{$fam->vinculofamiliar}}
                                </td>
                                </tr>                                
                           </table>
                            
                         </div>
                          </div>
                          </div>
                        </div>
                          <a href="{{ route('editarfam',$fam->id) }}" class="btn btn-warning" title="Modificar familia">
                        <i class="bi bi-pencil"></i>
                        
                          </td>                                      
                      @endforeach
                    </tbody>
                    
                  </table>
                </div>
                  <div class="card-footer mr-auto">
                {{$familias->links() }}
              </div>
            </tr>
          </tbody>
        </table>
        @endif
            <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header" style="background-color: lightblue;">
            <h5 class="modal-title" id="exampleModalLabel"><strong>Nueva Familia</strong></h5>
            <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
            </div>
            <div class="modal-body ">
            <form class="form-horizontal" action="{{route('crearfamilia')}}" name="formalumnos" method="POST">
            @csrf
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
        </div>
          <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook" formaction="{{ route('crearfamilia') }}" formmethod="POST">Guardar</button>
                <button type="reset" class="btn btn-sm btn-facebook">Limpiar</button>
          </div>
        </div>
        </form>
                            
                         </div>
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