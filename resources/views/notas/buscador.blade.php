@extends('layouts.main' , ['activePage' => 'notas', 'titlePage => Buscador de notas'])

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
                <form action="{{route('listadonotas') }}" class="form-horizontal">
                <div class="row">
               @if($tipodoc!='Grado')
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
                @else
                <div class="col">
                <label>Espacio curricular</label>
                <select name="espacio" id="espacio" class="form-control" value="{{ old('espacio')}}">
                <?php
                $nombreespacios = preg_replace('/[\[\]\.\;\""]+/', '', $nombreespacios);
                $cont=count($nombreespacios)-1;
                ?>
                <option value=""></option>
                <?php
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
                <div class="text-right">
                  <button class="btn btn-sm btn-facebook" type="submit">Buscar</button>
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


      
