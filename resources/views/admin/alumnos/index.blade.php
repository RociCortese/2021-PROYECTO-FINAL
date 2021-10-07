@extends('layouts.main' , ['activePage' => 'alumno', 'titlePage => Alumnos'])

@section ('content')
 
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary" style="background-color: grey;">
                <h4 class="card-title"> Alumnos</h4>
                <p class="card-category">Alumnos Registrados</p>    
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{url ('admin/alumnos/create') }}" class="btn btn-sm btn-facebook">Agregar Alumno</a>
                  </div>
                </div>
                @if ($alumnos->isEmpty())
                  @if(empty($apellido))
                  <div> Aún no hay alumnos creados.</div>
                  @else
                  <form>
                      <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido" value="{{$apellido}}">
                      <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                      <a href="{{url ('admin/alumnos') }}" class="btn btn-sm btn-facebook"> Limpiar </a>
                    </form> 
                  <div>No se encontraron resultados para el filtro aplicado.</div>

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
                    <form>
                        <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido" aria-label="Search" value="{{$apellido}}">
                        <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                    </form>
                    <a href="{{url ('admin/alumnos') }}" class="btn btn-sm btn-facebook"> Limpiar </a>
                    <tbody>
                      @foreach($alumnos as $alu)
                        <tr>
                          <td class="v-align-middle">{{$alu->id}}</td>
                          <td class="v-align-middle">{{$alu->dnialumno}}</td>
                          <td class="v-align-middle">{{$alu->nombrealumno}}</td>
                          <td class="v-align-middle">{{$alu->apellidoalumno}}</td>
                          <td class="td-actions td-actions v-align-middle">
                          <a href="{{route('show', $alu->id)}}" class="btn btn-info" title="Ver mas Información"><i class="material-icons">person</i></a></a>
                          <button class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$alu->id}}">
                            <i class="material-icons">delete_outline</i>
                          </button>
                          <div class="modal fade" id="myModal{{$alu->id}}" role="dialog">
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

