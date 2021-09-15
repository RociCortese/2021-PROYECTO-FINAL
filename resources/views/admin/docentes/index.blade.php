
@extends('layouts.main' , ['activePage' => 'docente', 'titlePage => Docentes'])

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

                    <a href="{{url ('admin/docentes/create') }}" class="btn btn-sm btn-facebook">Agregar Docente</a>
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
                    </thead
                                <form>
                                <input name="buscarnombre" class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" aria-label="Search">
                                <input name="buscarapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido" aria-label="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                              </form>
                                  
                                        <tbody>
                                          @foreach($docentes as $doc)
                                          <tr>
                                            <td class="v-align-middle">{{$doc->id}}</td>
                                            <td class="v-align-middle">{{$doc->dni}}</td>
                                            <td class="v-align-middle">{{$doc->nombre}}</td>
                                            <td class="v-align-middle">{{$doc->apellido}}</td>
                                            <td class="v-align-middle">{{$doc->acciones}}</td>
                                                                                                 
                                          </tr>                                          
                                          @endforeach

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

      
