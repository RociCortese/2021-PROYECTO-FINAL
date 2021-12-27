@extends('layouts.main', ['activePage' => 'editarañoescolar', 'titlePage' => __('')])
  
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class=" col-md-12"> 
        <form action="{{ route('actualizaraño',$id->id) }}" method="POST" class="form-horizontal">
        @csrf
        @METHOD('PUT')
        <div class="card">
          <div class= "card-header card-header-info">
          <h4 class="card-title">Editar año escolar</h4>
          </div>
        <div class="card-body">
           <br>
          <div class="col form-group">
            <label>Año escolar</label>
              <select name="descripcion" class="form-control" value="{{$id->descripcion}}">
                <option value="0" <?php echo 'selected="selected" ';?>>{{$id->descripcion}}</option>
                      <?php  for($i=2021;$i<=2032;$i++) { echo "<option value='".$i."'>".$i."</option>"; } ?>
                </select>
            @if ($errors->has('descripcion'))
                <div id="descripcion-error" class="error text-danger pl-3" for="descripcion" style="display: block;">
                  <strong>{{ $errors->first('descripcion') }}</strong>
                </div>
              @endif
          </div>
          <br>
          <div class="col form-group">
          <label>Fecha inicio</label>
            <input type="date" name="fechainicio" class="form-control" min="<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 1 month"));?>" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 1 years"));?>" value="{{$id->fechainicio}}">
            @if ($errors->has('fechainicio'))
                <div id="fechainicio-error" class="error text-danger pl-3" for="fechainicio" style="display: block;">
                  <strong>{{ $errors->first('fechainicio') }}</strong>
                </div>
              @endif
          </div>
          <div class="col form-group">
          <label>Fecha fin</label>
            <input type="date" name="fechafin" class="form-control" min="<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 1 month"));?>" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 2 years"));?>" value="{{$id->fechafin}}">
            @if ($errors->has('fechafin'))
                <div id="fechafin-error" class="error text-danger pl-3" for="fechafin" style="display: block;">
                  <strong>{{ $errors->first('fechafin') }}</strong>
                </div>
              @endif
          </div>            
          <div class="text-right">
            <h4><span class="badge badge-danger">*Recuerde que todos los campos son obligatorios.</span></h4>
          </div>
          </div>
          <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar cambios</button>
                <button type="reset" class="btn btn-sm btn-facebook">Limpiar</button>
          </div>
        </div>
      </div>
      </form>
        </div>
        
      </div>
    </div>
  </div>
@endsection