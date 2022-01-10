@extends('layouts.main', ['activePage' => 'añoescolar', 'titlePage' => __('Año escolar')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
        	<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title ">Armado de grados</h4>
              </div>
              @if($colegio->isEmpty())
                <br>
               <div class="col-md-12">
              <h4><span class="badge badge-warning">Para poder armar los diferentes grados, antes deberá cargar la información del colegio.</span></h4>
              </div>
              @else
              @if($todoestado->isEmpty())
              <br>
               <div class="col-md-12">
              <h4><span class="badge badge-warning">Para poder armar los diferentes grados, antes deberá crear el año escolar.</span></h4>
              </div>
              @else
              <div class="card-body">
                <label class="col-sm-12"><strong>El año escolar que se encuentra activo es el {{$descripcionaño}}.</strong></label>
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{route('armadogrado.create') }}" class="btn btn-sm btn-facebook">Crear grado</a>
                  </div>
                  <div class="col form-group">
            <label>Seleccionar otro año escolar</label>
              <select name="buscaraño" class="form-control" value="{{ old('año') }}">
                <option></option>
                @foreach($todoestado as $todoest)
                <option value="{{$todoest->descripcion}}">{{$todoest->descripcion}}</option>
                @endforeach
              </select>
            @if ($errors->has('año'))
                <div id="año-error" class="error text-danger pl-3" for="año" style="display: block;">
                  <strong>{{ $errors->first('año') }}</strong>
                </div>
              @endif
          </div>
                  <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>Grado</th>
                      <th>Docente</th>
                      <th>Alumnos</th>
                      <th>Docentes especiales</th>
                      <th>Acciones</th>
                    </thead>
                    @foreach($grado as $grados)
                    <tr>
                      <?php 
                      $nombredoc=App\Models\Docente::all()->where('id',$grados->id_docentes);
                      ?>
                      <td class="v-align-middle">{{$grados->descripcion}}</td>
                      @foreach($nombredoc as $nombres)
                      <td class="v-align-middle">{{$nombres->nombredocente}}</td>
                      @endforeach
                      <td class="td-actions v-align-middle">
                        <button class="btn btn-info" data-target="#ModalAlumnos{{$grados->id}}"data-toggle="modal" title="Ver alumnos">
                        <i class="material-icons">person</i>
                        </button>
                        <div class="modal fade bd-example-modal-lg" id="ModalAlumnos{{$grados->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header" style="background-color: lightblue;">
                          <h5 class="modal-title" id="exampleModalLabel"><strong></strong>Alumnos de {{$grados->descripcion}}</h5>

                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                            <label><strong>Listado de Alumnos:</strong></label> 
                            <table class="table">
                              <tr>
                                <td class="v-align-middle">
                                <?php
                                $prueba=$grados->descripcion;
                                $otraprueba=App\Models\Alumno::where('grado',$prueba)->get();
                                ?>
                                  @foreach($otraprueba as $pru)
                                  {{$pru->nombrealumno}}  {{$pru->apellidoalumno}}
                                  <br>
                                  @endforeach

                                </td>
                              </tr>
                           </table>
                  
                          </div>
                       </div>
                     </div>
                   </div>
                 </td>
                      <td class="td-actions v-align-middle">
                        <button class="btn btn-warning" data-toggle="modal" data-target="#myModal{{$grados->id}}" title="Docentes especiales">
                        <i class="material-icons">add_circle_outline</i>
                      </button>
                      <div class="modal fade bd-example-modal-lg" id="myModal{{$grados->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header" style="background-color: lightblue;">
                          <h5 class="modal-title" id="exampleModalLabel"><strong></strong>Docentes especiales</h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                            <label><strong>Seleccionar docentes especiales</strong></label> 
                            @foreach($docentesespe as $espe)
                            <form action="{{route('armado.especiales',$grados->id)}}" method="POST" class="form-horizontal">
                            @csrf
                            <table class="table">
                              <tr>
                                <td class="v-align-middle">
                                  <input type="checkbox" id="check" name="id_docentesespe[]" value="{{$espe->id}}" <?php 
                                  $longitud= strlen($grados->id_docentesespe); 
                                  for($i=2;$i<=$longitud;$i=$i+4){
                                    $doce=$grados->id_docentesespe[$i];
                                    if($espe->id==$doce) echo 'checked="" ';
                                  }
                                  ?>>
                                 {{$espe->nombredocente}} {{$espe->apellidodocente}}
                                 {{$espe->especialidad}}
                                 
                                </td>
                              </tr>
                           </table>
                           @endforeach
                            <div class="card-footer">
                            <div class="  col-xs-12 col-sm-12 col-md-12 text-right ">
                            <button type="submit" class="btn btn-sm btn-facebook">Guardar</button>
                            </div>
                            </div>
                            </form>
                          </div>
                       </div>
                     </div>
                   </div>
                  
                    </td>
                    <td class="td-actions v-align-middle">
                    <a href="{{ route('editargrado',$grados->id) }}" class="btn btn-warning" title="Modificar grado">
                    <i class="material-icons">edit</i></a>
                    </td>
                    </tr>
                    
                    @endforeach
                  </table>
                </div>
                </div> 
          </div>
          @endif
          @endif
              
              </div>

                </div> 
                </div> 
              </div>
        </div>
    </div>
</div>
@endsection
