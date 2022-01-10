@extends('layouts.main' , ['activePage' => 'eventos', 'titlePage => Formulario Evento'])

@section ('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form form action="{{ asset('/Evento/create/') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card">
          <div class= "card-header card-header-info">
          <h4 class="card-title">Crear nuevo Evento</h4>
          </div>
        <div class="card-body">
      <a class="btn btn-sm btn-default"  href="{{ asset('/Evento/index') }}"><i class="material-icons">arrow_back</i></a>

       <div class="form-group">
                <label>Tipo de Evento</label>
                <select name="tipo" id="tipoevento" class="form-control" >
                    <option value="">Seleccione una opción</option>
                    <option value="Acto Escolar">Acto Escolar</option>
                    <option value="Reunión">Reunión</option>
                </select>
                <script 
                  src="https://code.jquery.com/jquery-3.2.0.min.js"
                  integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I="
                  crossorigin="anonymous">
               </script>
                <script>
                $(function(){
                $("#tipoevento").val(value="{{ old('tipo') }}")
                });
               </script>
            @if ($errors->has('tipo'))
                <div id="tipo-error" class="error text-danger pl-3" for="tipo" style="display: block;">
                  <strong>{{ $errors->first('tipo') }}</strong>
                </div>
              @endif
              
            </div>
    
    <div class="form-group">
    <label >Título del Evento</label>
    <input type="text" class="form-control" name="titulo" aria-describedby="eventoHelp" value="{{ old('titulo') }}">
    <small id="eventoHelp" class="form-text text-muted">Por ejemplo: Acto fin de año.</small>
    @if ($errors->has('titulo'))
                <div id="titulo-error" class="error text-danger pl-3" for="titulo" style="display: block;">
                  <strong>{{ $errors->first('titulo') }}</strong>
                </div>
              @endif
    </div>

     <div class="form-group">
    <label>Comentario sobre el evento.</label>
    <textarea class="form-control" rows="3" name= "descripcion" style="border: thin solid lightgrey;" aria-describedby="comentHelp" value="{{ old('descripcion') }}"></textarea>
    <small id="comentHelp" class="form-text text-muted">Este campo es opcional.</small>
    </div>

  <div class="form-group">
    <label >Lugar del Evento</label>
    <input type="text" class="form-control" name="lugar" value="{{ old('lugar') }}">
    @if ($errors->has('lugar'))
                <div id="lugar-error" class="error text-danger pl-3" for="lugar" style="display: block;">
                  <strong>{{ $errors->first('lugar') }}</strong>
                </div>
              @endif
    </div>

    <div class="form-group">
          <label>Fecha - Hora del Evento</label>
            <input type="datetime-local" name="fecha" class="form-control"  value="{{ old('fecha') }}">
            @if ($errors->has('fecha'))
                <div id="fecha-error" class="error text-danger pl-3" for="fecha" style="display: block;">
                  <strong>{{ $errors->first('fecha') }}</strong>
                </div>
              @endif
          </div>

  <div class="form-group">
    <label>Participantes</label>
    <input type="text" class="form-control" name="participantes">
    @if ($errors->has('participantes'))
                <div id="participantes-error" class="error text-danger pl-3" for="participantes" style="display: block;">
                  <strong>{{ $errors->first('participantes') }}</strong>
                </div>
              @endif
    </div>

      

</div>
  <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar</button>
          </div>
        </div>
      </form>
    </div> 
    </div> 
    </div> 
    </div> 
    </div> 


  
@endsection