@extends('layouts.main' , ['activePage' => 'alumno', 'titlePage => Docentes'])

@section ('content')
 
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title"> Alumnos</h4>
                <p class="card-category">Alumnos Registrados</p>    
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{url ('admin/alumnos/create') }}" class="btn btn-sm btn-facebook">Agregar Alumno</a>
                  </div>
                  
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>ID</th>
                      <th>DNI</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th class="text-right">Acciones</th>
                    </thead>
                    <tbody>
                      @foreach($alumnos as $alu)
                                          <tr>
                                            <td class="v-align-middle">{{$alu->id}}</td>
                                            <td class="v-align-middle">{{$alu->dni}}</td>
                                            <td class="v-align-middle">{{$alu->nombre}}</td>
                                            <td class="v-align-middle">{{$alu->apellido}}</td>
                                            <td class="v-align-middle">{{$alu->acciones}}</td>
                                                                                                 
                                          </tr>                                          
                                          @endforeach
                    </tbody>
                    
                  </table>
                </div>
                
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

