@extends('layouts.main', ['activePage' => 'configuraciones', 'titlePage' => __('')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12">
<form action="{{ url('configuraciones/create') }}" method="POST" class="form-horizontal">
   @csrf
  <div class="card">
            <div class= "card-header card-header-info">
            <h4 class="card-title">Configuraciones</h4>
            <p class="card-category">Configuraciones básicas</p>
            </div>
            <div class="card-body">
                  <div class="row">
          <div class="col">
            <label>Período</label>
            <br>
            @foreach($colegio as $colegios)
            <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="periodo" value="Bimestre" <?php if($colegios->periodo=='Bimestre') echo 'checked ';?>>Bimestre
                  <span class="circle">
                      <span class="check"></span>
                  </span>

                </label>
              </div>
              <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="periodo" value="Trimestre"<?php if($colegios->periodo=='Trimestre') echo 'checked ';?>>Trimestre
                  <span class="circle">
                      <span class="check"></span>
                  </span>
                </label>
              </div>
              <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="periodo" value="Cuatrimestre"<?php if($colegios->periodo=='Cuatrimestre') echo 'checked ';?>>Cuatrimestre
                  <span class="circle">
                      <span class="check"></span>
                  </span>
                </label>
              </div>
              <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="periodo"  value="Semestre" <?php if($colegios->periodo=='Semestre') echo 'checked ';?>>Semestre
                  <span class="circle">
                      <span class="check"></span>
                  </span>
                </label>
              </div>

            @if ($errors->has('periodo'))
                <div id="periodo-error" class="error text-danger pl-3" for="periodo" style="display: block;">
                  <strong>{{ $errors->first('periodo') }}</strong>
                </div>
              @endif
         <br>
         <br>
            <label>Turno</label>
            <br>
            <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="turno"  value="Mañana"<?php if($colegios->turno=='Mañana') echo 'checked ';?>>Mañana
                  <span class="circle">
                      <span class="check"></span>
                  </span>
                </label>
              </div>
              <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="turno" value="Tarde"<?php if($colegios->turno=='Tarde') echo 'checked ';?>>Tarde
                  <span class="circle">
                      <span class="check"></span>
                  </span>
                </label>
              </div>
              <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="turno" value="Ambos"<?php if($colegios->turno=='Ambos') echo 'checked ';?>>Ambos
                  <span class="circle">
                      <span class="check"></span>
                  </span>
                </label>
              </div>
              

            @if ($errors->has('turno'))
                <div id="turno-error" class="error text-danger pl-3" for="turno" style="display: block;">
                  <strong>{{ $errors->first('turno') }}</strong>
                </div>
              @endif
          <br>
          <br>
          <label>Cantidad de grados</label>
            <br>
            <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="grados"  value="Seis"<?php if($colegios->grados=='Seis') echo 'checked ';?>>Seis Grados
                  <span class="circle">
                      <span class="check"></span>
                  </span>
                </label>
              </div>
              <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="grados"  value="Siete"<?php if($colegios->grados=='Siete') echo 'checked ';?>>Siete Grados
                  <span class="circle">
                      <span class="check"></span>
                  </span>
                </label>
              </div>
              @if ($errors->has('turno'))
                <div id="grados-error" class="error text-danger pl-3" for="grados" style="display: block;">
                  <strong>{{ $errors->first('grados') }}</strong>
                </div>
              @endif
            </div>
              
              @endforeach
          </div>
<div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-right ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar</button>
          </div>
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