@extends('layouts.main', ['activePage' => 'armadogrado', 'titlePage' => __('Año escolar')])

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
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{route('armadogrado.create') }}" class="btn btn-sm btn-facebook">Crear grado</a>
                  </div>
                  <div class="col form-group">
            <label>Seleccionar año escolar</label>
              <select name="buscaraño" class="form-control" value="{{ old('año') }}">
                <option value="0"></option>
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
                                  <input type="checkbox" id="check" name="id_docentesespe[]" value="{{$espe->id}}" <?php if($espe->id==$grados->id_docentesespe) echo 'checked="" ';?>>
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
                    </tr>
                    
                    @endforeach
                  </table>
                </div>
                </div> 
          </div>
              
              </div>

                </div> 
                </div> 
              </div>
        </div>
    </div>
</div>
@endsection
