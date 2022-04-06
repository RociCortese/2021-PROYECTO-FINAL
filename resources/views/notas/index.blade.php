@extends('layouts.main' , ['activePage' => 'notas', 'titlePage => Registro de notas'])

@section ('content')
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title ">Registro de notas</h4>
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
                for($i=0;$i<=$cont;$i++){?>
                <option value="{{$nombresgrado[$i]}}">{{$nombresgrado[$i]}}</option>
                <?php
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
                for($i=0;$i<=$cont;$i++){?>
                <option value="{{$nombreespacios[$i]}}">{{$nombreespacios[$i]}}</option>
                <?php
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
                <div class="col">
                <label>Período</label>
                <select name="periodo" id="periodo" class="form-control" value="{{$periodo}}">
                <option value="{{$periodo}}">{{$periodo}}</option>
                @if($informacionperiodo=='Bimestre')
                <option value="Primer período">Primer período</option>
                <option value="Segundo período">Segundo período</option>
                <option value="Tercer período">Tercer período</option>
                <option value="Cuarto período">Cuarto período</option>
                @endif
                @if($informacionperiodo=='Trimestre')
                <option value="Primer período">Primer período</option>
                <option value="Segundo período">Segundo período</option>
                <option value="Tercer período">Tercer período</option>
                @endif
                @if($informacionperiodo=='Cuatrimestre')
                <option value="Primer período">Primer período</option>
                <option value="Segundo período">Segundo período</option>
                @endif
                @if($informacionperiodo=='Semestre')
                <option value="Primer período">Primer período</option>
                <option value="Segundo período">Segundo período</option>
                @endif
                </select>
                @if ($errors->has('periodo'))
                <div id="periodo-error" class="error text-danger pl-3" for="periodo" style="display: block;">
                  <strong>{{ $errors->first('periodo') }}</strong>
                </div>
                @endif
                </div>
                </div>
                <br>
                <div class="text-right">
                  <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
                </div>
                </form>
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>Alumnos</th>
                      @foreach($infocriterios as $infocrit) 
                      <th>{{$infocrit->criterio}}</th>
                      @endforeach
                      <th>Observaciones</th>
                      <th>Nota final</th>
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
                    @foreach($infoalumnos as $infoalu)              
                    <tbody>
                    <tr>
                      <td class="v-align-middle">{{$infoalu->nombrealumno}} {{$infoalu->apellidoalumno}}</td>
                      @foreach($infocriterios as $infocrit)
                      <td class="v-align-middle">
                        <select name="calificacion" id="calificacion" class="form-control">
                        <?php
                        $califi = preg_replace('/[\[\]\.\;\""]+/', '', $califi);
                        $cont=count($califi)-1;
                        ?>
                        <option value=""></option>
                        <?php
                        for($i=0;$i<=$cont;$i++){?>
                        <option value="{{$califi[$i]}}">{{$califi[$i]}}</option>
                        <?php
                        }
                        ?>
                        </select>
                        
                        
                      </td>
                      @endforeach  
                        <td class="v-align-middle">
                        <form action="{{route('notas.update',$infoalu->id)}}" method="POST" class="form-horizontal">
                        @csrf
                        @METHOD('PUT')
                        <a style="color: #00bcd4;font-size: 1.5em;"data-toggle="modal" data-target="#myModal{{$infoalu->id}}" title="Observaciones">
                            <i class="bi bi-journals"></i>
                          </a>
                          <div class="modal fade bd-example-modal-lg" id="myModal{{$infoalu->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><strong>Observaciones del alumno {{$infoalu->nombrealumno}} {{$infoalu->apellidoalumno}}</strong></h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                            <textarea class="form-control" rows="3" name="observacion" id="observacion" style="border: thin solid lightgrey;" aria-describedby="comentHelp" value="{{ old('observacion') }}" maxlength="150"></textarea>
                            <div class="modal-footer">
                    <div class="  col-xs-12 col-sm-12 col-md-12 text-right">
                    <button type="submit" class="btn btn-sm btn-facebook">Agregar observación</button>
                    </div>
                  </div>
                            
                         </div>
                       </div>
                     </div>
                   </div>
                 </form>
                      </td>
                      <td class="v-align-middle"></td>                       
                    </tr>                                        
                    </tbody>
                    @endforeach
                  </table>
                </div>
                <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar cambios</button>
          </div>
        </div>
      </form>
            </div>
          </div>
        </div>
      </div>
     </div>
   </div>
 </div>
</div>
@endsection


      
