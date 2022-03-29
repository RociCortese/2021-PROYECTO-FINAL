@extends('layouts.main', ['activePage' => 'criteriosevaluacion', 'titlePage' => __('')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('criterios.update',$id->id) }}" method="POST" class="form-horizontal">
        @csrf
        @METHOD('PUT')
        <div class="card">
          <div class= "card-header card-header-info">
          <h4 class="card-title">Editar Criterio de Evaluación</h4>
          </div>
        <div class="card-body">
        @foreach($infoaño as $año)
          <div class="text-left">
            <h5><span class="badge badge-info">El año escolar activo es el {{$año->descripcion}}.</span></h5>
          </div>
        @endforeach
        <div class="row">
          @if($tipodoc=='Grado')
          <div class="col">
            <label>Espacio curricular</label>
          <select name="espaciocurricular" id="espaciocurricular" class="form-control" value="{{ $id->id_espacio }}">
                <?php
                $nomespacio = preg_replace('/[\[\]\.\;\" "]+/', '', $nombreespacios);
                $contador=count($nomespacio)-1;
                ?>
                <option value="{{$id->id_espacio}}"<?php echo 'selected="selected" ';?>>{{$id->id_espacio}}</option>
                <?php
                for ($i=0; $i <=$contador ; $i++) {
                ?>
                <option value="{{$nomespacio[$i]}}">{{$nomespacio[$i]}}</option>
                <?php
                }
                ?>
              </select>
              
            @if ($errors->has('espaciocurricular'))
                <div id="espaciocurricular-error" class="error text-danger pl-3" for="espaciocurricular" style="display: block;">
                  <strong>{{ $errors->first('espaciocurricular') }}</strong>
                </div>
              @endif
          </div>
        </div>
        
        <div class="row">
         
          @else
          <div class="col">
            <label>Grado</label>
              <select name="grado" id="grado" class="form-control" value="{{$id->id_grado }}">
                    <option value=""></option>
                    <?php
                    $cont=count($nombresgrado)-1;
                    for($i=0;$i<=$cont;$i++){?>
                    <option value="{{$nombresgrado[$i]}}"<?php echo 'selected="selected" ';?>>{{$id->id_grado}}{{$nombresgrado[$i]}}</option>
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
            @endif
        </div>
          
        <br>
        <div class="row">
          <div class="col">
            <label>Criterio de evaluación</label>
              <input type="text" name="criterio" class="form-control" value="{{$id->criterio}}">
            @if ($errors->has('criterio'))
                <div id="criterio-error" class="error text-danger pl-3" for="criterio" style="display: block;">
                  <strong>{{ $errors->first('criterio') }}</strong>
                </div>
              @endif
          </div>
  <div class="col">
            <label>Ponderación</label>
            <br>
            <small class="form-text" id="etiqueta"></small>
            <input id="input" name="ponderacion" type="range" min="1" max="5" step="1" list="opciones" value="{{$id->ponderacion}}" >
            <datalist id="opciones">
            <option value="1" label="1">
            <option value="2" label="2">
            <option value="3" label="3">
            <option value="4" label="4">
            <option value="5" label="5">
            </datalist>
            <script type="text/javascript">
            var elInput = document.querySelector('#input');
            if (elInput) {
            var etiqueta = document.querySelector('#etiqueta');
            if (etiqueta) {
            if(elInput.value=={{$id->ponderacion}}){
            etiqueta.innerHTML = "Ponderación muy baja";
            document.getElementById('etiqueta').style.color = '#008000';
                  if(elInput.value=='1'){
            etiqueta.innerHTML = "Ponderación muy baja";
            document.getElementById('etiqueta').style.color = '#008000';
            }
            if(elInput.value=='2'){
            etiqueta.innerHTML = "Ponderación baja";
            document.getElementById('etiqueta').style.color = '#57a639';
            }
            if(elInput.value=='3'){
            etiqueta.innerHTML = "Ponderación media";
            document.getElementById('etiqueta').style.color = '#cccc00';
            }
            if(elInput.value=='4'){
            etiqueta.innerHTML = "Ponderación alta";
            document.getElementById('etiqueta').style.color = '#FF8000';
            }
            if(elInput.value=='5'){
            etiqueta.innerHTML = "Ponderación muy alta";
            document.getElementById('etiqueta').style.color = '#FF0000';
            }
            }
            elInput.addEventListener('input', function() {
            if(elInput.value=='1'){
            etiqueta.innerHTML = "Ponderación muy baja";
            document.getElementById('etiqueta').style.color = '#008000';
            }
            if(elInput.value=='2'){
            etiqueta.innerHTML = "Ponderación baja";
            document.getElementById('etiqueta').style.color = '#57a639';
            }
            if(elInput.value=='3'){
            etiqueta.innerHTML = "Ponderación media";
            document.getElementById('etiqueta').style.color = '#cccc00';
            }
            if(elInput.value=='4'){
            etiqueta.innerHTML = "Ponderación alta";
            document.getElementById('etiqueta').style.color = '#FF8000';
            }
            if(elInput.value=='5'){
            etiqueta.innerHTML = "Ponderación muy alta";
            document.getElementById('etiqueta').style.color = '#FF0000';
            }
            }, false);
            }
            }
            </script>
            <small class="form-text text-muted">Permite darle un peso al criterio de evaluación para luego obtener una nota final.</small>   
            @if ($errors->has('ponderacion'))
                <div id="ponderacion-error" class="error text-danger pl-3" for="ponderacion" style="display: block;">
                  <strong>{{ $errors->first('ponderacion') }}</strong>
                </div>
              @endif
        </div>
        </div>
        <br>
        <div class="row">
        <div class="col">
          <label>Descripción</label>
             <textarea class="form-control" rows="3" name="descripcion" id="descripcion" style="border: thin solid lightgrey;" aria-describedby="comentHelp" value="{{$id->descripcion}}" maxlength="150">{{ old('descripcion', $id->descripcion) }}</textarea>
             <small id="comentHelp" class="form-text text-muted">Este campo es opcional. </small>
            @if ($errors->has('descripcion'))
                <div id="descripcion-error" class="error text-danger pl-3" for="descripcion" style="display: block;">
                  <strong>{{ $errors->first('descripcion') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <br>
          <div class="card-footer">
          <div class=" col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar Cambios</button>
          </div>
        </div>
      </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection