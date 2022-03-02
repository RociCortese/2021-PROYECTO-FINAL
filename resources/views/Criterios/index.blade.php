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
                  <div class="row">
                  <div class="col-12 text-right">
                    <a href="#" class="btn btn-sm btn-facebook" title="Crear criterio"><i class="material-icons">add</i></a>
                  </div>
                  </div>
                @if($tipodoc=='Grado')
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
                      <?php
                      $nombreespacio=App\Models\espacioscurriculares::where('id',$criterio->id_espacio)->get();
                      foreach($nombreespacio as $nom){
                        $nombresp="$nom->nombre";
                      ?>
                      <td class="v-align-middle">{{$criterio->id}}</td>
                      <td class="v-align-middle">{{$criterio->id_año}}</td>
                      <td class="v-align-middle">{{$nombresp}}</td>
                      <td class="v-align-middle">{{$criterio->criterio}}</td>      
                    </tr>  
                    <?php
                    }
                    ?>                                        
                    @endforeach
                    </tbody>
                  </table>
                </div>
                @else
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
                      $nombreespacio=App\Models\espacioscurriculares::where('id',$criterio->id_espacio)->get();
                      foreach($nombreespacio as $nom){
                        $nombresp="$nom->nombre";
                      ?>
                      <td class="v-align-middle">{{$criterio->id}}</td>
                      <td class="v-align-middle">{{$criterio->id_año}}</td>
                      <td class="v-align-middle">{{$criterio->id_grado}}</td>
                      <td class="v-align-middle">{{$criterio->criterio}}</td>      
                    </tr>  
                    <?php
                    }
                    ?>                                        
                    @endforeach
                    </tbody>
                  </table>
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


      
