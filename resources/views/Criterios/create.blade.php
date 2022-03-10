@extends('layouts.main', ['activePage' => 'criteriosevaluacion', 'titlePage' => __('')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('criterios.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card">
          <div class= "card-header card-header-info">
          <h4 class="card-title">Agregar criterio de evaluación</h4>
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
              <select name="espaciocurricular" id="espaciocurricular" class="form-control" value="{{ old('espaciocurricular') }}">
                <?php
                $nomespacio = preg_replace('/[\[\]\.\;\" "]+/', '', $nombreespacios);
                $contador=count($nomespacio)-1;
                ?>
                <option value=""></option>
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
          <div class="col">
              <br>
              <input type="checkbox" name="aplicaespacios" id="aplicaespacios" value="aplicaespacios" >&nbsp<label>Aplica a todos los espacios curriculares</label>
            </div>
        </div>
        <div class="row">
          @else
          <div class="row">
          <div class="col">
            <label>Grado</label>
              <select name="grado" id="grado" class="form-control" value="{{old('grado') }}">
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
              <br>
              <input type="checkbox" name="aplicagrados" id="aplicagrados" value="aplicagrados">&nbsp<label>Aplica a todos los grados</label>
              <br><input type="checkbox" name="aplicadivisiones" id="aplicadivisiones" value="aplicadivisiones">&nbsp<label>Aplica a todas las divisiones</label>
            </div>
            @endif
        </div>
          
        <br>
        <div class="row">
          <div class="col">
            <label>Criterio de evaluación</label>
              <input type="text" name="criterio" class="form-control" value="{{ old('criterio') }}">
            @if ($errors->has('criterio'))
                <div id="criterio-error" class="error text-danger pl-3" for="criterio" style="display: block;">
                  <strong>{{ $errors->first('criterio') }}</strong>
                </div>
              @endif
          </div>
        <div class="col">
            <label>Ponderación</label>
            <select name="ponderacion" id="ponderacion" class="form-control" value="{{ old('ponderacion') }}">
            <option value=""></option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>   
            </select>
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
             <textarea class="form-control" rows="3" name="descripcion" id="descripcion" style="border: thin solid lightgrey;" aria-describedby="comentHelp" value="{{ old('descripcion') }}" maxlength="150"></textarea>
             <small id="comentHelp" class="form-text text-muted">Este campo es opcional. </small>
            @if ($errors->has('descripcion'))
                <div id="descripcion-error" class="error text-danger pl-3" for="descripcion" style="display: block;">
                  <strong>{{ $errors->first('descripcion') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <!--<div class="text-center">
            <a type="button" class="btn btn-info btn-sm" style="font-size: 0.5em;">
          <i class="bi bi-plus-circle" style="font-size: 2em;color: white;" title="Agregar criterio"></i>
            </a>
          </div>-->
          <br>
          <div class="card-footer">
          <div class=" col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar</button>
                <button type="reset" class="btn btn-sm btn-facebook">Limpiar</button>
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