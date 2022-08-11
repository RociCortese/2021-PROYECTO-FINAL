@extends('layouts.main' , ['activePage' => 'notas', 'titlePage => Registro de notas'])
@section ('content')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title ">Registro de notas finales</h4>
              </div>
              <div class="card-body">
                @foreach($infoaño as $año)
                  <div class="text-left">
                  <h5><span class="badge badge-success">El año escolar activo es el {{$año->descripcion}}.</span></h5>
                  </div>
                @endforeach
                <form>
                <div class="row">
                @if($tipodoc!='Grado')
                <div class="col">
                <label>Grado</label>
                <select name="grado" id="grado" class="form-control" value="{{$grado}}">
                <option value="{{$grado}}">{{$grado}}</option>
                <?php
                $cont=count($nombresgrado)-1;
                for($i=0;$i<=$cont;$i++){
                  if($nombresgrado[$i]!=$grado){
                    ?>
                <option value="{{$nombresgrado[$i]}}">{{$nombresgrado[$i]}}</option>
                <?php
                }
              }
                ?>
                </select>
                @if ($errors->has('grado'))
                <div id="grado-error" class="error text-danger pl-3" for="grado" style="display: block;">
                  <strong>{{ $errors->first('grado') }}</strong>
                </div>
                @endif
                </div>
                @else
                <div class="col">
                <label>Espacio curricular</label>
                <select name="espacio" id="espacio" class="form-control" value="{{$espacio}}">
                <option value="{{$espacio}}">{{$espacio}}</option>
                <?php
                $nombreespacios = preg_replace('/[\[\]\.\;\""]+/', '', $nombreespacios);
                $cont=count($nombreespacios)-1;
                for($i=0;$i<=$cont;$i++){
                if($nombreespacios[$i]!=$espacio){
                  ?>
                <option value="{{$nombreespacios[$i]}}">{{$nombreespacios[$i]}}</option>
                <?php
                }
              }
                ?>
                </select>
                @if ($errors->has('espacio'))
                <div id="espacio-error" class="error text-danger pl-3" for="espacio" style="display: block;">
                  <strong>{{ $errors->first('espacio') }}</strong>
                </div>
                @endif
                </div>
                @endif
                </div>
                <br>
                <div class="text-right">
                  <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                </div>
                </form>
                <form class="form-horizontal" method="POST">
                  @csrf
                  @METHOD('PUT')
                <div style="display: none;">
                  @if($tipodoc=='Grado')
                  <input type="text" value="{{$espacio}}" name="espacio">
                  @endif
                  @if($tipodoc!='Grado')
                  <input type="text" value="{{$grado}}" name="grado">
                  @endif
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>Alumnos</th>
                      @if($informacionperiodo=='Bimestre') 
                      <th>Primer período</th>
                      <th>Segundo período</th>
                      <th>Tercer período</th>
                      <th>Cuarto período</th>
                      <?php 
                      $cantidadperiodo=4;
                      ?>
                      @endif
                      @if($informacionperiodo=='Trimestre') 
                      <th>Primer período</th>
                      <th>Segundo período</th>
                      <th>Tercer período</th>
                      <?php 
                      $cantidadperiodo=3;
                      ?>
                      @endif
                      @if($informacionperiodo=='Cuatrimestre') 
                      <th>Primer período</th>
                      <th>Segundo período</th>
                      <?php 
                      $cantidadperiodo=2;
                      ?>
                      @endif
                      @if($informacionperiodo=='Semestre') 
                      <th>Primer período</th>
                      <th>Segundo período</th>
                      <?php 
                      $cantidadperiodo=2;
                      ?>
                      @endif
                      <th>Nota final &nbsp<a data-toggle="popover" title="Cálculo Nota Final" data-content="La nota final es obtenida automáticamente de acuerdo a las calificaciones cargadas para cada período."><i class="bi bi-exclamation-circle" class="text-primary" ></i></a>  </th>
                      <th>Observación final</th>
                    </thead>
                    <script >$('[data-toggle="popover"]').popover();  </script>
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
                    <?php
                    $contadoralu=count($idalumnos)-1;
                    for ($i=0; $i <=$contadoralu ; $i++) {?>  
                    <tr>
                      <td class="v-align-middle">{{$nombresalumnos[$i]}}</td>
                      <?php 
                      $notasespacio=[];
                      for($l=0;$l<$cantidadperiodo;$l++){
                      $notasespacio[$l]='-';
                      }
                      ?>
                      @foreach($infoinformes as $info)
                      @if($info->id_alumno==$idalumnos[$i] and $info->periodo!='Final')
                      <?php 
                      if($info->periodo=='Primer período'){
                      $notasespacio[0]=$info->nota;
                      }
                      elseif($info->periodo=='Segundo período'){
                      $notasespacio[1]=$info->nota;
                      }
                      elseif($info->periodo=='Tercer período'){
                      $notasespacio[2]=$info->nota;
                      }
                      elseif($info->periodo=='Cuarto período'){
                      $notasespacio[3]=$info->nota;
                      }
                      ?>
                      @endif
                      @endforeach
                      <?php 
                      for($m=0;$m<$cantidadperiodo;$m++){?>
                      <td class="v-align-middle">
                      <label name="calificacion" id="calificacion" style="color: #3C4858;">
                        {{$notasespacio[$m]}}
                        </label>
                      </td> 
                      <?php   
                      }
                      ?>
                       <td class="v-align-middle">
                          <?php
                        foreach($infoinformes as $infoinf){
                         $idalumno="$infoinf->id_alumno";
                              if($idalumno==$idalumnos[$i] and $infoinf->periodo=='Final'){
                                ?>
                                <input name="notafinal[]" id="notafinal" class="form-control" value="{{$infoinf->nota}}" disabled></input>
                        <?php
                        }
                      }
                        ?>
                      </td>  
                      <td class="v-align-middle">
                        <a style="color: #00bcd4;font-size: 1.5em;"data-toggle="modal" data-target="#myModal{{$idalumnos[$i]}}" title="Observaciones">
                            <i class="bi bi-journals"></i>
                          </a>
                          <div class="modal fade bd-example-modal-lg" id="myModal{{$idalumnos[$i]}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><strong>Observaciones del alumno {{$nombresalumnos[$i]}}</strong></h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                              <div class="text-right"><small class="form-text text-muted contador" id="contador">150 caracteres restantes.</small></div>
                              <textarea placeholder="Ingrese aquí la observación." class="form-control" rows="3" name="observacion[]" id="observacion" style="border: thin solid lightgrey;" aria-describedby="comentHelp"  maxlength="150" value="{{$infoinf->observacion}}">{{$infoinf->observacion}}</textarea>
                             
                            <div class="modal-footer">
                            <div class="  col-xs-12 col-sm-12 col-md-12 text-right">
                            <button formaction="{{route('observacionfinal.update',$idalumnos[$i])}}" type="submit" class="btn btn-sm btn-facebook">Agregar observación</button>
                            </div>
                  </div>
                  <script type="text/javascript">
                  var limit = 150;
                  $(function() {
                  $("#observacion").on("input", function () {
                  //al cambiar el texto del txt_detalle
                  var init = $(this).val().length;
                  total_characters = (limit - init);
                  $('#contador').html(total_characters + " caracteres restantes.");
                  });
                  });
                  </script>
                         </div>
                       </div>
                     </div>
                   </div>
                      </td>                   
                    </tr>
                    <?php 
                  }
                  ?>                                       

                    </tbody>
                    
                       
                  </table>
                  
                </div>
             
      </form>
                        <?php
                        $califi = preg_replace('/[\[\]\.\;\""]+/', '', $califi);
                        if($infoco==NULL)
                        {
                        $califica = preg_replace('/[\[\]\.\;\""]+/', '', $califica);
                        $cont=count($califi)-1;
                        ?>
                        <h5><span class="badge badge-warning">Referencias:

                        <?php
                        for($k=0;$k<=$cont;$k++){?>
                          <strong>{{$califi[$k]}}</strong>: {{$califica[$k]}}
                        <?php
                        }
                        ?>
                      </span></h5>
                      <?php
                    }
                    ?>
            </div>
          </div>
          
        </div>
      </div>
     </div>
   </div>
 </div>
</div>
@endsection