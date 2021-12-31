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
                      <th>Acciones</th>
                    </thead>
                    @foreach($grado as $grados)
                    
                    <tr>
                      <td class="v-align-middle">{{$grados->descripcion}}</td>
                      <td class="v-align-middle">{{$grados->id_docentes}}</td>
                      <td class="td-actions v-align-middle">
                        <button class="btn btn-info" data-toggle="modal" title="Ver alumnos" data-target="#ModalAlumnos">
                        <i class="material-icons">person</i>
                        </button>
                             <div class="modal fade bd-example-modal-lg" id="ModalAlumnos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header" style="background-color: lightblue;">
                          <h5 class="modal-title" id="exampleModalLabel"><strong></strong>Alumnos de </h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                            <label><strong>Listado de Alumnos:</strong></label> 
                            
                            <table class="table">
                              <tr>
                                <td class="v-align-middle">
                                
                                
                                </td>
                              </tr>
                           </table>
                  
                          </div>
                       </div>
                     </div>
                   </div>
                           
                      </td>

                      <td class="td-actions v-align-middle">
                        <button class="btn btn-warning" data-toggle="modal" data-target="#myModal" title="Docentes especiales">
                        <i class="material-icons">add_circle_outline</i>
                      </button>
                      <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header" style="background-color: lightblue;">
                          <h5 class="modal-title" id="exampleModalLabel"><strong></strong>Docentes especiales</h5>
                          <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                          </div>
                          <div class="modal-body">
                            <label><strong>Seleccionar docentes especiales</strong></label> 
                            @foreach($docentesespe as $espe)
                            <table class="table">
                              <tr>
                                <td class="v-align-middle">
                                 {{$espe->nombredocente}} {{$espe->apellidodocente}}
                                 {{$espe->especialidad}}
                                 <input type="checkbox" id="check" name="check">
                                </td>
                              </tr>
                           </table>
                           @endforeach
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
