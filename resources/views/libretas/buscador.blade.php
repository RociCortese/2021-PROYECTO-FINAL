@extends('layouts.main' , ['activePage' => 'libretas', 'titlePage => Impresión de libretas'])
<?php
$detect = new Mobile_Detect;
?>
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
               
              <div class="card-body">
                @foreach($infoaño as $año)
                  <div class="text-left">
                  <?php 
                  if ($detect->isMobile() or $detect->isTablet()) {?> 
                  <h5><span class="badge badge-success">El año escolar activo es el {{$año->descripcion}}.</span></h5>
                  <?php 
                  }
                  else{?>
                  <h5><span class="badge badge-success">El año escolar activo es el {{$año->descripcion}}.</span></h5>  
                  <?php 
                  }
                  ?>
                  </div>
                @endforeach
                <form action="{{route('listadoalumnos')}}" class="form-horizontal">
                <div class="row">
                <div class="col">
                <label>Grado</label>
                <select name="grado" id="grado" class="form-control" value="">
                <option value=""></option>
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
                <option value=""></option>
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
                <div style="display : flex; flex-direction : row;">
                  <div>
                  <strong><p>Si busca a través del último período podrá descargar los informes finales.</p></strong>
                  </div>
                <div style="margin-left:43%;">
                  <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
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

