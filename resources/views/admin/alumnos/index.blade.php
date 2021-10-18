@extends('layouts.main' , ['activePage' => 'alumno', 'titlePage => Alumnos'])

@section ('content')
 
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary" style="background-color: grey;"">
                <h4 class="card-title"> Alumnos</h4>
                <p class="card-category">Alumnos Registrados</p>    
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{url ('admin/alumnos/create') }}" class="btn btn-sm btn-default">Agregar Alumno</a>
                  </div>
                </div>
                @if ($alumnos->isEmpty())
               <i><strong><div>Aún no hay alumnos creados</div></strong></i> 
                
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
                    
                    <div class="text-right"><button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><span class="material-icons">filter_list</span></button></div>

                    <div class="collapse" id="collapseExample">
                    <div class="card card-body" style="border: thin solid lightgrey;">
                      <form>
                        <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por Apellido" aria-label="Search">
                        <div class="text-right"><button class="btn btn-sm btn-facebook" type="submit">Buscar</button></div>
                      </form>
                    <div class="text-right"><a href="{{url ('admin/alumnos') }}" class="btn btn-sm btn-facebook"> Limpiar </a></div>
                    </div>
                    </div>

                    <tbody>

                      @foreach($alumnos as $alu)
                       
                        <tr>
                          <td class="v-align-middle">{{$alu->id}}</td>
                          <td class="v-align-middle">{{$alu->dnialumno}}</td>
                          <td class="v-align-middle">{{$alu->nombrealumno}}</td>
                          <td class="v-align-middle">{{$alu->apellidoalumno}}</td>
                         <td class="td-actions v-align-middle">
                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal{{$alu->id}}" title="Ver Información Docente">
                            <i class="material-icons">person</i>
                          </button>
                            
                          <div class="modal fade bd-example-modal-lg" id="myModal{{$alu->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header" style="background-color: lightblue;">
                          <h5 class="modal-title" id="exampleModalLabel"><strong>Vista detallada del alumno</strong></h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body ">
                            <div class="author">
                            <h5 class="tittle mt-3"><strong>ALUMNO: {{$alu->nombrealumno}} {{$alu->apellidoalumno}}</strong></h5>
                          </div>
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
                        
                           </td>
                           @endforeach                                            
                    </tr>                                        
                     
                    </tbody>
                    
                  </table>
                </div>
                @endif
                
              </div>
              <div class="card-footer mr-auto">
                {{$alumnos->links() }}
                
              </div>
                
              
            </div>
            
          </div>
        </div>
        
      </div>
       
     </div>

   </div>
 </div>
@endsection

