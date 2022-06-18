@extends('layouts.main' , ['activePage' => 'alumno', 'titlePage => Alumnos'])

@section ('content')
 
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title"> Alumnos</h4>
                <p class="card-category">Alumnos Registrados</p>    
              </div>
              @if($colegio->isEmpty())
                <br>
               <div class="col-md-12 text-center">
              <h4><span class="badge badge-warning">Para poder cargar los alumnos, antes deberá cargar la información del colegio.</span></h4>
              </div>
              <br>
              @else
              <div class="card-body">
                @if ($alumnos->isEmpty())
               @if(empty($nombre) && empty($apellido) && empty($dni))
               <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{url ('admin/alumnos/create') }}" class="btn btn-sm btn-facebook" title="Registrar alumno"><i class="material-icons">person_add_alt</i></a>
                  </div>
                </div>
                  <div> Aún no hay Alumnos creados.</div>
                  @else
                  <div class="card card-body" style="border: thin solid lightgrey;">
                  <form>
                      <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido" value="{{$apellido}}">
                       <input name="buscarnombre" class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" aria-label="Search" value="{{$nombre}}">
                        <input name="buscardni" class="form-control mr-sm-2" type="search" placeholder="Buscar por DNI" aria-label="Search" value="{{$dni}}">
                      <div class="text-right">
                      <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                      <a href="{{url ('admin/alumnos') }}" class="btn btn-sm btn-facebook"> Limpiar </a>
                    </div>
                    </form> 
                  </div>
                  <div class="text-center"><h4><span class="badge badge-warning">Lo sentimos. No encontramos resultados para el filtro aplicado.</span></h4></div>
                  @endif
            @else
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>ID</th>
                      <th>DNI</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Acciones</th>
                    </thead>
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

                      <div class="text-right">
                      <button class="btn btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Filtrar alumnos"><span class="material-icons">filter_list</span></button>


                    <div class="collapse" id="collapseExample">
                    <div class="card card-body" style="border: thin solid lightgrey;">
                      <form>
                        
                        <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido" aria-label="Search" value="{{$apellido}}">
                        <input name="buscarnombre" class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" aria-label="Search" value="{{$nombre}}">
                        <input name="buscardni" class="form-control mr-sm-2" type="search" placeholder="Buscar por DNI" aria-label="Search" value="{{$dni}}">
                        <div class="text-right">
                          <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                          <a href="{{url ('admin/alumnos') }}" class="btn btn-sm btn-facebook"> Limpiar </a>
                        </div>
                    </form>
                  </div>
                    </div>
                    <a href="{{url ('admin/alumnos/create') }}" class="btn btn-sm btn-facebook">
                    <i class="material-icons">person_add_alt</i></a>
                </div>

                      @foreach($alumnos as $alu)
                       
                        <tr>
                          <td class="v-align-middle">{{$alu->id}}</td>
                          <td class="v-align-middle">{{$alu->dnialumno}}</td>
                          <td class="v-align-middle">{{$alu->nombrealumno}}</td>
                          <td class="v-align-middle">{{$alu->apellidoalumno}}</td>
                          <td class="td-actions td-actions v-align-middle">

                          <button class="btn btn-info" data-toggle="modal" data-target="#myModal{{$alu->id}}" title="Ver Información Alumno">
                            <i class="bi bi-person"></i>

                          </button>
                          <div class="modal fade bd-example-modal-lg" id="myModal{{$alu->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><strong>Vista detallada del alumno {{$alu->nombrealumno}} {{$alu->apellidoalumno}}</strong></h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body ">
                            <table class="table">
                              <tr>
                                <td class="v-align-middle" >
                                <label>DNI:</label>  {{$alu->dnialumno}}
                                </td>
                                <td class="v-align-middle">
                                <label>Género:</label>  {{$alu->generoalumno}}
                                </td>
                                <td class="v-align-middle">
                                <label>Fecha de nacimiento:</label>  {{$alu->fechanacimiento}}
                                </td> 
                              </tr>
                              <tr>
                                <td class="v-align-middle">
                                <label>Domicilio:</label>  {{$alu->domicilio}}
                                </td>
                                <td class="v-align-middle">
                                <label>Localidad:</label>  {{$alu->localidad}}
                                </td>
                                <td class="v-align-middle">
                                <label>Provincia:</label>  {{$alu->provincia}}
                                </td>
                                </tr>
                           </table>
                           <?php
                           $infofamilia=App\Models\Familia::where('id',$alu->familias_id)->get();
                           ?>
                           @foreach($infofamilia as $infofam)
                            <div class="author">
                            <h5 class="tittle mt-3"><strong>Familiar: {{$infofam->nombrefamilia}} {{$infofam->apellidofamilia}}</strong></h5>
                          </div>
                            <table class="table">
                              <tr>
                                <td class="v-align-middle" >
                                <label>DNI:</label>  {{$infofam->dnifamilia}}
                                </td>
                                <td class="v-align-middle">
                                <label>Género:</label>  {{$infofam->generofamilia}}
                                </td>
                                <td class="v-align-middle">
                                <label>Teléfono celular:</label>  {{$infofam->telefono}}
                                </td> 
                              </tr>
                              <tr>
                                <td class="v-align-middle">
                                <label>Email:</label>  {{$infofam->email}}
                                </td>
                                <td class="v-align-middle">
                                <label>Vínculo familiar:</label>  {{$infofam->vinculofamiliar}}
                                </td>
                                </tr>
                           </table>
                           @endforeach
                         </div>
                          </div>
                          </div>
                        </div>

                          <a href="{{route('editaralumno',$alu->id)}}" class="btn btn-warning" title="Modificar alumno"><i class="bi bi-pencil"></i></a>
                          <button class="btn btn-danger" data-toggle="modal" data-target="#myModal2{{$alu->id}}">
                            <i class="bi bi-trash"></i>

                          </button>
                          <div class="modal fade" id="myModal2{{$alu->id}}" role="dialog">
                          <div class="modal-dialog">
                          <div class="modal-content">
                          <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                          <p class="text-center">¿Está seguro que desea eliminar el alumno {{$alu->nombrealumno}}  {{$alu->apellidoalumno}}?</p>
                          </div>
                          <div class="modal-footer justify-content-center">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <form action="{{route('destroy',$alu->id)}}" method="POST" style="display: inline-block;">
                          @csrf
                          @METHOD('DELETE')
                          <button class="btn btn-success" type="submit" rel="tooltip">Aceptar</button>
                          </form>
          
        </div>
      </div>
      
    </div>
  </div>              
                      </td>

                        </tr>  

                      @endforeach

                          
                        
                           </td>
                                              
                    </tr>                                       
                     

                    </tbody>
                    
                  </table>
                </div>
                @endif
                
              </div>
              <div class="card-footer mr-auto">
                {{$alumnos->links() }}
                
              </div>
              @endif
            </div>
            
          </div>
        </div>
        
      </div>
       
     </div>

   </div>
 </div>
@endsection

