@extends('layouts.main', ['activePage' => 'configuraciones', 'titlePage' => __('')])

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

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
              @if(session('success'))
                    <div class="alert alert-success text-left" role="success">
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
                  <div class="row">
          <div class="col">
            <label><strong>PERÍODO</strong></label>
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
            <label><strong>TURNO</strong></label>

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
          <label><strong>CANTIDAD DE GRADOS</strong></label>

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
              <br>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
              <div class="form-group">
    <label><strong>DIVISIONES</strong></label>
    <br>
    <select class="form-control divisiones" name="divisiones[]" id='divisiones' multiple="multiple" lang="es" style="width: 100%">

      <?php
        $res = preg_replace('/[\[\]\.\;\" "]+/', '', $colegios->divisiones);
        $array=explode(',', $res);
    for ($i=0;$i<=count($array)-1;$i++)    
      {     
       $division=App\Models\Abecedario::where('id',$array[$i])->get();
        foreach ($division as $div) {
          $letradiv="$div->letras";
          $iddiv="$div->id";
        }
      ?>
        <option value="{{$iddiv}}"<?php echo 'selected="selected" ';?>>
       {{$letradiv}}
       </option>
       <?php
      }
      ?>

    </select>
    <script type="text/javascript">

    $('.divisiones').select2({
    placeholder: 'Ingrese las divisiones que desea agregar',
    ajax: {
    url: '/autocomplete/divisiones/',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
      return {
        results:  $.map(data, function (item) {
              return {
                  text: item.letras,
                  id: item.id,
              }

          })

      };

    },
    

    cache: true
    }

});
   $('#divisiones').select2('data');
</script>
<small id="eventoHelp" class="form-text text-muted">Por ejemplo: A.</small>


    @if ($errors->has('divisiones'))
                <div id="divisiones-error" class="error text-danger pl-3" for="divisiones" style="display: block;">
                  <strong>{{ $errors->first('divisiones') }}</strong>
                </div>
              @endif
    </div>

            <div class="form-group">
    <label><strong>ESPACIOS CURRICULARES</strong></label>
    <br>
    <select class="form-control espacioscurriculares" name="espacioscurriculares[]" id='espacioscurriculares' multiple="multiple" lang="es" style="width: 100%">
    </select>
    <small id="eventoHelp" class="form-text text-muted">Por ejemplo: Matemática.</small>
    <!--@if(empty($nuevosespacios))
    @else
    <form action="{{ url('configuraciones/create') }}" method="POST" class="form-horizontal">
   @csrf
    <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>Espacio curricular</th>
                      <th>Grado</th>
                      <th>Especial</th>
                    </thead>
                    <?php
                    $cantidad=count($nuevosespacios)-1;
                    for ($i=0; $i <=$cantidad ; $i++) { 
                    ?>
                    <tr>
                      <td class="v-align-middle">{{$nuevosespacios[$i]}}</td>
                      <td><input type="checkbox" name="cbox2" id="cbox2" value="Grado"></td>
                      <td><input type="checkbox" name="cbox2" id="cbox2" value="Especial"></td>
                    </tr>
                  </table>
                      <?php
                    }
                    ?>
      </div>
      @endif-->
    <script type="text/javascript">
    $('.espacioscurriculares').select2({
    tags: true,
    tokenSeparators: [','],
    placeholder: 'Ingrese los Espacios Curriculares que desea agregar',
    ajax: {
    url: '/autocomplete/espacioscurriculares/',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
      return {
        results:  $.map(data, function (item) {
              return {
                  text: item.nombre,
                  id: item.id

              }
          })
      };

    },

    cache: true
    }

});
   
</script>
    @if ($errors->has('espacioscurriculares'))
                <div id="espacioscurriculares-error" class="error text-danger pl-3" for="espacioscurriculares" style="display: block;">
                  <strong>{{ $errors->first('espacioscurriculares') }}</strong>
                </div>
              @endif
    </div>
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



