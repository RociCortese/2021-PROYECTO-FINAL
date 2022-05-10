@extends('layouts.main' , ['activePage' => 'cargasistencia', 'titlePage => Registro de Asistencias'])

@section ('content')
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title "> Asistencias</h4>
                <p class="card-category">Registro de asistencias</p>    
              </div>
              <div class="card-body">
              @foreach($infoaño as $año)
                <div class="text-left">
                <h5><span class="badge badge-success">El año escolar activo es el {{$año->descripcion}}.</span></h5>
                </div>
              @endforeach
              <div class="col">
              <label>Mes</label>
              <select name="mes" id="mes" class="form-control">
                <option value=""></option>
                <?php
                $cont=count($meses)-1;
                for($i=0;$i<=$cont;$i++){
                    ?>
                <option value="{{$meses[$i]}}">{{$meses[$i]}}</option>
                <?php
                }
                ?>
                </select>
              </div>
              <div class="text-right">
                  <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
              </div>
              <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>Alumnos</th>
                      <?php 
                      for ($i=1; $i <=30 ; $i++) {?>
                      <th>
                      {{$i}}
                      <?php 
                      }
                      ?>
                      </th>
                    </thead>                    
                    <tbody>
                    @foreach($infoasistencia as $infoasist)
                    <tr>
                      <td class="v-align-middle">{{$infoasist->nombrealumno}}</td>
                      <td>
                      <?php 
                      if($infoasist->estado=='No registrada'){?>
                      <i class="bi bi-circle-fill" style="color:#c5c6c8;"></i>
                      <?php 
                      }  
                      if($infoasist->estado=='Presente'){?>
                      <i class="bi bi-circle-fill" style="color:#77dd77;"></i>  
                      <?php 
                      } 
                      if($infoasist->estado=='Ausente'){?>
                      <i class="bi bi-circle-fill" style="color:#ff6961;"></i> 
                      <?php 
                      }
                      if($infoasist->estado=='Tarde'){?>
                       <i class="bi bi-circle-fill" style="color:#fdfd96;"></i>
                       <?php 
                       }
                       ?> 
                      </td>
                    </tr>

                    @endforeach
                    </tbody>
                  </table>
                </div>
                 <br>
                  <div class="text-right">
                  <a class="btn btn-sm btn-facebook" href="{{url ('asistencias/create') }}">Cargar Asistencia</a>
                  <a class="btn btn-sm btn-facebook" href="{{url ('asistencias/edita') }}">Editar Asistencia</a>
              </div>
              <br>
              <div class="row">
                <i class="bi bi-circle-fill" style="color:#c5c6c8;"></i>&nbspNo registrada&nbsp
                <i class="bi bi-circle-fill" style="color:#77dd77;"></i>&nbspPresente&nbsp
                <i class="bi bi-circle-fill" style="color:#ff6961;"></i>&nbspAusente&nbsp
                <i class="bi bi-circle-fill" style="color:#fdfd96;"></i>&nbspTarde&nbsp
              </div>
              </div>
                  
            </div>
          </div>
        </div>
      </div>
     </div>
   </div>
 </div>
@endsection


      
