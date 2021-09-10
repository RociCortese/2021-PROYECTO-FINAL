@extends('layouts.main' , ['activepage' => 'docente', 'titlePage => Docentes'])

@section ('content')
 
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title"> Docentes</h4>
                <p class="card-category">Docentes Registrados</p>    
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="" class="btn btn-sm btn-facebook">Agregar Docente</a>
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
                      @forech($docentes as $doc)
                      <tr>
                        <td>{{$doc->iddocente}}</td>
                        <td>{{$doc->dni}}</td>
                        <td>{{$doc>nombre}}</td>
                        <td>{{$doc->apellido}}</td>
                        <td></td>
                      </tr>
                      @endforech
                    </tbody>
                    
                  </table>
                </div>
                
              </div>
              <div class="card-footer mr-auto">
                {{$docentes->links() }}
                
              </div>
                
              
            </div>
            
          </div>
        </div>
        
      </div>
       
     </div>

   </div>
 </div>

@endsection

