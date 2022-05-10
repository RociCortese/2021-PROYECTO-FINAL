@extends('layouts.main', ['activePage' => 'Editar asistencia', 'titlePage' => __('')])
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('asistencia.update') }}" method="POST" class="form-horizontal">
        @csrf
        @METHOD('PUT')
        <div class="card">
          <div class= "card-header card-header-info">
          <h4 class="card-title">Editar asistencia</h4>
          </div>
        <div class="card-body">
        <div class="row">
          <div class="col">
            <label>Fecha</label>
              <input type="date" id="fechaActual"  name="diaasistencia" class="form-control" >
            @if ($errors->has('diaasistencia'))
                <div id="diaasistencia-error" class="error text-danger pl-3" for="diaasistencia" style="display: block;">
                  <strong>{{ $errors->first('diaasistencia') }}</strong>
                </div>
              @endif
          </div>
          <div class="col">
            <br>
           <button type="submit" class="btn btn-sm btn-facebook " >Editar Fecha</button>
          </div>
        </div>
        <br>
        <div class="table-responsive">
          <table class="table">
            <thead class="text-primary">
              <th>Alumnos</th>
              <th>Asistencia</th>
              <th>Tardanza</th>
            </thead>                    
            <tbody>
              
          
           
     
            </tbody>
          </table>
        </div>
        </div>
          <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar asistencia</button>
          </div>
        </div>
      </div>
       </form>
        </div>
      </div>
    </div>
  </div>
@endsection