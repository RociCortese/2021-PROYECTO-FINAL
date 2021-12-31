@extends('layouts.main', ['activePage' => 'añoescolar', 'titlePage' => __('')])
  
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('armadogrado.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card">
          <div class= "card-header card-header-info">
          <h4 class="card-title">Armado de grados</h4>
          </div>
        <div class="card-body">
           <br>
          <div class="col form-group">
            <label>Seleccionar año escolar</label>
              <select name="año" class="form-control" value="{{ old('año') }}">
                <option value="0"></option>
                @foreach($año as $años)
                <option value="{{$años->descripcion}}">{{$años->descripcion}}</option>
                @endforeach
              </select>
            @if ($errors->has('año'))
                <div id="año-error" class="error text-danger pl-3" for="año" style="display: block;">
                  <strong>{{ $errors->first('año') }}</strong>
                </div>
              @endif
          </div>
          @if($maximogrado=='Seis')
            <div class="col">
            <label>Seleccionar grado</label>
            <select name="grado" id="grado" class="form-control" value="{{ old('grado') }}">
                    <option value=""></option>
                    <option value="Primer grado">Primer grado</option>
                    <option value="Segundo grado">Segundo grado</option>
                    <option value="Tercer grado">Tercer grado</option>
                    <option value="Cuarto grado">Cuarto grado</option>
                    <option value="Quinto grado">Quinto grado</option>
                    <option value="Sexto grado">Sexto grado</option>
                </select>
            @if ($errors->has('grado'))
                <div id="grado-error" class="error text-danger pl-3" for="grado" style="display: block;">
                  <strong>{{ $errors->first('grado') }}</strong>
                </div>
              @endif
            </div>
            @endif
            @if($maximogrado=='Siete')
            <div class="col">
            <label>Seleccionar grado</label>
            <select name="grado" id="grado" class="form-control" value="{{ old('grado') }}">
                    <option value=""></option>
                    <option value="Primer grado">Primer grado</option>
                    <option value="Segundo grado">Segundo grado</option>
                    <option value="Tercer grado">Tercer grado</option>
                    <option value="Cuarto grado">Cuarto grado</option>
                    <option value="Quinto grado">Quinto grado</option>
                    <option value="Sexto grado">Sexto grado</option>
                    <option value="Séptimo grado">Séptimo grado</option>
                </select>
            @if ($errors->has('grado'))
                <div id="grado-error" class="error text-danger pl-3" for="grado" style="display: block;">
                  <strong>{{ $errors->first('grado') }}</strong>
                </div>
              @endif
            </div>
            @endif
          <div class="col form-group">
            <label>Seleccionar docente de grado</label>
              <select name="docente" class="form-control" value="{{ old('docente') }}">
                <option value="0"></option>
                @foreach($docentes as $doc)
                <option value="{{$doc->nombredocente}}">{{$doc->nombredocente}}</option>
                @endforeach
                </select>
            @if ($errors->has('docente'))
                <div id="docente-error" class="error text-danger pl-3" for="docente" style="display: block;">
                  <strong>{{ $errors->first('docente') }}</strong>
                </div>
              @endif
          </div>
          
          
        </div>
     
      <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar</button>
                <button type="reset" class="btn btn-sm btn-facebook">Limpiar</button>
          </div>
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
@endsection