@extends('layouts.main' , ['activePage' => 'docente', 'titlePage => Docentes'])

@section ('content')
 
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary" style="background-color: grey;">
                <h4 class="card-title "> Docentes</h4>
                <p class="card-category">Docentes Registrados</p>    
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">

                    <a href="{{url ('admin/docentes/create') }}" class="btn btn-sm btn-facebook">Agregar Docente</a>
                  </div>
                </div>
               
                @if ($docentes->isEmpty())
                <div>Aún no hay docentes creados.</div>
                
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
                      <input name="buscarnombre" class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre">
                      <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido">
                      <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                    </form>
                    <a href="{{url ('admin/docentes') }}" class="btn btn-sm btn-facebook"> Limpiar </a>
                    

                                  
                                        <tbody>
                                          @foreach($docentes as $doc)
                                          <tr>
                                            <td class="v-align-middle">{{$doc->id}}</td>
                                            <td class="v-align-middle">{{$doc->dni}}</td>
                                            <td class="v-align-middle">{{$doc->nombre}}</td>
                                            <td class="v-align-middle">{{$doc->apellido}}</td>
                                            <td class="td-actions v-align-middle">
                                              <a href="{{ route('ver',$doc->id) }}" class="btn btn-info" title="Ver información">
                                                <i class="material-icons">person</i></a>
                                              </a></td>                                                  
                                          </tr>                                          
                                          @endforeach

                    </tbody>
                    
                  </table>
                  
                </div>
             @endif
                
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

      
