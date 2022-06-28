@extends('layouts.main' , ['activePage' => 'libretas', 'titlePage => Impresión de libretas'])

@section ('content')
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title ">Informes de progreso escolar</h4>
              </div>
             @if(sizeof($infogrado)==0)
              <br>

          <div class="col-md-12 text-center">
          <h4><span class="badge badge-warning">Aún no hay Informes creados para el Grado y Periodo seleccionado </span></h4>
          <u><strong><a class="text-primary" href="{{route('libretas')}}">Volver al buscador.</a></strong></u>
          </div>

          <br>
          @else
              <div class="card-body">
                @foreach($infoaño as $año)
                  <div class="text-left">
                  <h5><span class="badge badge-success">El año escolar activo es el {{$año->descripcion}}.</span></h5>
                  </div>
                @endforeach
                <form action="{{route('listadoalumnos')}}" class="form-horizontal">
                <div class="row">
                <div class="col">
                <label>Grado</label>
                <select name="grado" id="grado" class="form-control" value="">
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
                <div class="col">
                <label>Período</label>
                <select name="periodo" id="periodo" class="form-control" value="{{old('periodo') }}">
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
                    <th>Acciones</th>
                    </thead>                    
                    <tbody>
                    <?php 
                    $contador=count($nombrealumno)-1;
                    for ($i=0; $i<=$contador ; $i++) { ?>
                      <tr>
                      <td class="v-align-middle">{{$nombrealumno[$i]}} {{$apellidoalumno[$i]}}</td>
                    <?php 
                    $nombrecompleto=$nombrealumno[$i].' '.$apellidoalumno[$i];
                    ?>
                      <td class="td-actions v-align-middle">
                        <form action="{{route('generarlibreta',$nombrecompleto)}}">
                          <div style="display: none;">
                          <input type="text" value="{{$periodo}}" name="periodo">
                          </div>
                        <button class="btn btn-success" title="Descargar informe">
                        <i class="bi bi-download"></i>
                        </button>
                        </form>
                        <!--<form action="{{route('compartirinforme',$nombrecompleto)}}">
                          <div style="display: none;">
                          <input type="text" value="{{$periodo}}" name="periodo">
                          </div>
                        <button class="btn btn-info" title="Compartir informe">
                        <i class="bi bi-share"></i>
                        </button>
                        </form>-->
                      </td>
                    </tr>
                    <?php 
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="text-center">
                <form action="{{route('generartodosinformes')}}">
                  <div style="display: none;">
                  <input type="text" value="{{$periodo}}" name="periodo">
                  <input type="text" value="{{$grado}}" name="grado">
                  </div>
                  <button class="btn btn-sm btn-facebook" title="Descargar todos los informes">Descargar todos los informes
                  </button>
                  </form>
               </div>
           
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

