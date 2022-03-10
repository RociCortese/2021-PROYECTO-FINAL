@extends('layouts.main' , ['activePage' => 'criteriosevaluacion', 'titlePage => Criterios'])

@section ('content')
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title "> Criterios de evaluación</h4>  
              </div>
              <div class="card-body">
                @if($tipodoc=='Grado')
                     <div class="text-right">
                       <button class="btn btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><span class="material-icons">filter_list</span></button>
                    <div class="collapse" id="collapseExample">
                    <div class="card card-body" style="border: thin solid lightgrey;">
                      <form>
                        <input name="buscarespecialidad" class="form-control mr-sm-2" type="Search" placeholder="Buscar por espacio curricular" aria-label="Search" value="{{$especialidad}}">
                        <input name="buscarañoescolar" class="form-control mr-sm-2" type="search" placeholder="Buscar por año escolar" aria-label="Search" value="{{$añoescolar}}">
                        <div class="text-right"><button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                        <a href="{{url('criteriosevaluacion')}}" class="btn btn-sm btn-facebook"> Limpiar </a>
                        </div>
                     </form>
                  </div>
                    </div>
                    <a href="{{route('criteriocreate')}}" class="btn btn-sm btn-facebook" title="Crear criterio"><i class="material-icons">add</i></a>
                    </div>

                <!-- TABLA DOCENTE DE GRADO -->
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>ID</th>
                      <th>Año escolar</th>
                      <th>Espacio curricular</th>
                      <th>Criterio</th>
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
                    <tbody>
                    @foreach($datoscriterio as $criterio)
                    <tr>
                      <td class="v-align-middle">{{$criterio->id}}</td>
                      <td class="v-align-middle">{{$criterio->id_año}}</td>
                      <td class="v-align-middle">{{$criterio->id_espacio}}</td>
                      <td class="v-align-middle">{{$criterio->criterio}}</td>
                      <td class="td-actions v-align-middle">
                      <button class="btn btn-info" data-toggle="modal" data-target="#ModalCriterioEvaluacion{{$criterio->id}}"  title="Ver Información Criterio de Evaluación"><i class="bi bi-info-circle"></i></button> 

                         <div class="modal fade bd-example-modal-lg" id="ModalCriterioEvaluacion{{$criterio->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><strong><i class="bi bi-list-check"></i> Vista detallada del Criterio de Evaluación</strong></h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                            <table class="table">
                               <tr>
                                <td class="v-align-middle" >
                                <label><strong>Año Escolar:</strong></label>  {{$criterio->id_año}}
                                </td>
                              </tr>
                               <tr>
                                <td class="v-align-middle" >
                                <label><strong>Espacio Curricular:</strong></label>  {{$criterio->id_espacio}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle" >
                                <label><strong>Criterio de Evaluación:</strong></label>  {{$criterio->criterio}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle" >
                                <label><strong>Descripción:</strong></label>  {{$criterio->descripcion}}
                                </td>
                              </tr>
                           </table>
                         </div>
                       </div>
                     </div>
                   </div>      
                    
                    <button class="btn btn-warning"  title="Editar Criterio de Evaluación"><i class="bi bi-pencil"></i></button>  

                    <button class="btn btn-danger" data-toggle="modal" data-target="#EliminarCriterioEvaluación{{$criterio->id}}" title="Eliminar Criterio de Evaluación">
                            <i class="bi bi-trash"></i>
                          </button>
                          <div class="modal fade" id="EliminarCriterioEvaluación{{$criterio->id}}" role="dialog">
                          <div class="modal-dialog">
                          <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="EliminarCriterioEvaluación"><strong><i class="bi bi-trash"></i>  Eliminar - Criterio de Evaluación</strong></h5> 
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                          <p class="text-center">¿Está seguro que desea eliminar el Criterio de Evaluación <strong>{{$criterio->criterio}}</strong>?</p>
                          </div>
                          <div class="modal-footer justify-content-center">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <form action="{{route('destroycriterio',$criterio->id)}}" method="POST" style="display: inline-block;">
                          @csrf
                          @METHOD('DELETE')
                          <button class="btn btn-success" type="submit" rel="tooltip">Aceptar</button>
                          </form>
                          </div>
                          </div>
                          </div>
                          </div>                                       
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>


                @else
                <!-- TABLA DOCENTE ESPECIAL -->
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>ID</th>
                      <th>Año escolar</th>
                      <th>Grado</th>
                      <th>Criterio</th>
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
                    <tbody>
                    @foreach($datoscriterio as $criterio)
                    <tr>
                      <?php
                      $nombregrado=App\Models\Grado::where('id',$criterio->id_grado)->get();
                      foreach($nombregrado as $nom){
                        $nomgrado="$nom->descripcion";
                      }
                      $nombreespacio=App\Models\espacioscurriculares::where('id',$criterio->id_espacio)->get();
                      foreach($nombreespacio as $nom){
                        $nombresp="$nom->nombre";
                      }
                      ?>
                      <td class="v-align-middle">{{$criterio->id}}</td>
                      <td class="v-align-middle">{{$criterio->id_año}}</td>
                      <td class="v-align-middle">{{$criterio->id_grado}}</td>
                      <td class="v-align-middle">{{$criterio->criterio}}</td> <td class="td-actions v-align-middle">
                      <button class="btn btn-info" data-toggle="modal" data-target="#ModalCriterioEvaluacion{{$criterio->id}}"  title="Ver Información Criterio de Evaluación"><i class="bi bi-info-circle"></i></button> 

                         <div class="modal fade bd-example-modal-lg" id="ModalCriterioEvaluacion{{$criterio->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="ModalCriterioEvaluacion"><strong><i class="bi bi-list-check"></i> Vista detallada del Criterio de Evaluación</strong></h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                            <table class="table">
                               <tr>
                                <td class="v-align-middle" >
                                <label><strong>Año Escolar:</strong></label>  {{$criterio->id_año}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle" >
                                <label><strong>Grado:</strong></label>  {{$criterio->grado}}
                                </td>
                              </tr>
                               <tr>
                                <td class="v-align-middle" >
                                <label><strong>Espacio Curricular:</strong></label>  {{$criterio->nombresp}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle" >
                                <label><strong>Criterio de Evaluación:</strong></label>  {{$criterio->criterio}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle" >
                                <label><strong>Descripción:</strong></label>  {{$criterio->descripcion}}
                                </td>
                              </tr>
                           </table>
                         </div>
                       </div>
                     </div>
                   </div>      
                    
                    <button class="btn btn-warning"  title="Editar Criterio de Evaluación"><i class="bi bi-pencil"></i></button>  

                    <button class="btn btn-danger" data-toggle="modal" data-target="#EliminarCriterioEvaluación{{$criterio->id}}" title="Eliminar Criterio de Evaluación">
                            <i class="bi bi-trash"></i>
                          </button>
                          <div class="modal fade" id="EliminarCriterioEvaluación{{$criterio->id}}" role="dialog">
                          <div class="modal-dialog">
                          <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="EliminarCriterioEvaluación"><strong><i class="bi bi-list-check"></i> Eliminar el Criterio de Evaluación</strong></h5> 
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                          <p class="text-center">¿Está seguro que desea eliminar el Criterio de Evaluación <strong>{{$criterio->criterio}}</strong>?</p>
                          </div>
                          <div class="modal-footer justify-content-center">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <form action="{{route('destroycriterio',$criterio->id)}}" method="POST" style="display: inline-block;">
                          @csrf
                          @METHOD('DELETE')
                          <button class="btn btn-success" type="submit" rel="tooltip">Aceptar</button>
                          </form>
                          </div>
                          </div>
                          </div>
                          </div>     
                    </tr>                              
                    @endforeach
                    </tbody>
                  </table>
                </div>
                @endif
            </div>
            <div class="card-footer mr-auto">
                    {{ $datoscriterio->links() }}
                  </div>
          </div>
        </div>
      </div>
     </div>
   </div>
 </div>
@endsection


      
