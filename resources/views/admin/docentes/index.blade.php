@extends('layouts.main' , ['activePage' => 'docente', 'titlePage => Docentes'])

@section ('content')
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title "> Docentes</h4>
                <p class="card-category">Docentes Registrados</p>    
              </div>
              @if($colegio->isEmpty())
                <br>
               <div class="col-md-12">
              <h4><span class="badge badge-warning">Para poder cargar los docentes, antes deberá cargar la información del colegio.</span></h4>
              </div>

              @else
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">

                    <a href="{{url ('admin/docentes/create') }}" class="btn btn-sm btn-facebook">Registrar Docente</a>
                  </div>
                </div>
               
                @if ($docentes->isEmpty())
                  @if(empty($apellido))
                  <div> Aún no hay docentes creados.</div>
                  @else
                  <form>
                      <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido" value="{{$apellido}}">
                      <input name="buscarnombre" class="form-control mr-sm-2" type="search" placeholder="Buscar por Nombre" aria-label="Search">
                        <input name="buscardni" class="form-control mr-sm-2" type="search" placeholder="Buscar por DNI" aria-label="Search">
                      <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                      <a href="{{url ('admin/docentes') }}" class="btn btn-sm btn-facebook"> Limpiar </a>
                    </form> 
                  <div>No se encontraron resultados para el filtro aplicado.</div>

                  @endif
            @else
          
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary ">
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
                    

                       <div class="text-right"><button class="btn btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="bi bi-funnel-fill"></i></button></div>

                       <br>

                    <div class="collapse" id="collapseExample">
                    <div class="card card-body" style="border: thin solid lightgrey;">
                      <form>
                        <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por Apellido" aria-label="Search">
                        <input name="buscarnombre" class="form-control mr-sm-2" type="search" placeholder="Buscar por Nombre" aria-label="Search">
                        <input name="buscardni" class="form-control mr-sm-2" type="search" placeholder="Buscar por DNI" aria-label="Search">
                        <div class="text-right"><button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                      </form>
                    <a href="{{url ('admin/docentes') }}" class="btn btn-sm btn-facebook"> Limpiar </a>
                  </div>
                    </div>
                    </div>

                                           
                    <tbody>
                    @foreach($docentes as $doc)
                    <tr>
                      <td class="v-align-middle">{{$doc->id}}</td>
                      <td class="v-align-middle">{{$doc->dnidocente}}</td>
                      <td class="v-align-middle">{{$doc->nombredocente}}</td>
                      <td class="v-align-middle">{{$doc->apellidodocente}}</td>
                      <td class="td-actions v-align-middle">
                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal{{$doc->id}}" title="Ver Información Docente">
                            <i class="bi bi-person"></i>
                          </button>
                          <div class="modal fade bd-example-modal-lg" id="myModal{{$doc->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header" style="background-color: lightblue;">
                          <h5 class="modal-title" id="exampleModalLabel"><strong>Vista detallada del Docente</strong></h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                            <div class="author">
                            <h5 class="tittle mt-3"><strong>DOCENTE: {{$doc->nombredocente}} {{$doc->apellidodocente}} </strong></h5>
                          </div>
                            <table class="table">
                              <tr>
                                <td class="v-align-middle" >
                                <label><strong>DNI:</strong></label>  {{$doc->dnidocente}}
                                </td>
                                <td class="v-align-middle">
                                <label><strong>Género:</strong></label>  {{$doc->generodocente}}
                                </td>
                                <td class="v-align-middle">
                                <label><strong>Fecha de nacimiento:</strong></label>  {{$doc->fechanacimientodoc}}
                                </td>
                              </tr>
                             
                              <tr>
                                <td class="v-align-middle">
                                <label><strong>Domicilio:</strong></label>  {{$doc->domiciliodocente}}
                                </td>
                                <td class="v-align-middle">
                                <label><strong>Localidad:</strong></label>  {{$doc->localidaddocente}}
                                </td>
                                <td class="v-align-middle">
                                <label><strong>Provincia:</strong></label>  {{$doc->provinciadocente}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle">
                                <label><strong>Teléfono:</strong></label>  {{$doc->telefonodocente}}
                                </td>
                                <td class="v-align-middle">
                                <label><strong>Email:</strong></label>  {{$doc->emaildocente}}
                                </td>
                              </tr>
                              <tr>
                                <td class="v-align-middle">
                                <label><strong>Legajo:</strong></label>  {{$doc->legajo}}
                                </td>
                                <td class="v-align-middle">
                                <label><strong>Especialidad:</strong></label>  {{$doc->especialidad}}
                                </td>
                              </tr>
                           </table>
                         </div>
                       </div>
                     </div>
                   </div>
                        <a href="{{ route('editardocente',$doc->id) }}" class="btn btn-warning" title="Modificar docente">
                        <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#myModal2{{$doc->id}}" title="Eliminar docente">
                            <i class="bi bi-trash"></i>
                          </button>
                          <div class="modal fade" id="myModal2{{$doc->id}}" role="dialog">
                          <div class="modal-dialog">
                          <div class="modal-content">
                          <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                          <p class="text-center">¿Está seguro que desea eliminar el docente {{$doc->nombredocente}}  {{$doc->apellidodocente}}?</p>
                          </div>
                          <div class="modal-footer justify-content-center">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <form action="{{route('destroydoc',$doc->id)}}" method="POST" style="display: inline-block;">
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
                    </tbody>
                  </table>
                </div>
             @endif
              </div>
              <div class="card-footer mr-auto">
                    {{ $docentes->links() }}
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


      
