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
                    <a href="{{url ('admin/alumnos/create') }}" class="btn btn-sm btn-facebook">Agregar Alumno</a>
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
                    <form>
                        <input name="buscarnombre" class="form-control mr-sm-2" type="search" placeholder="Buscar por Nombre" aria-label="Search">
                        <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por Apellido" aria-label="Search">
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
                          <a href="{{route('show', $alu->id)}}" class="btn btn-info" title="Ver mas Información"><i class="material-icons">person</i></a></a></td>
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

