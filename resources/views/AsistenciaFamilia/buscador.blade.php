@extends('layouts.main' , ['activePage' => 'asistenciasfamilia', 'titlePage => Visualización de asistencias'])

@section ('content')
 <div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title ">Justificación de inasistencias</h4>
              </div>
              <div class="card-body">
                @foreach($infoaño as $año)
                  <div class="text-left">
                  <h5><span class="badge badge-success">El año escolar activo es el {{$año->descripcion}}.</span></h5>
                  </div>
                @endforeach
                @if(empty($success))
            @else
            <div class="alert alert-success">
            {{$success}}
            </div>
            <script type="text/javascript">
            window.setTimeout(function() {
            $(".alert-success").fadeTo(400, 0).slideUp(400, function(){
            $(this).remove(); 
            });
            }, 1000);
            </script>
            @endif
                <form action="#" class="form-horizontal">
                <?php 
                $contadorasis=count($infoasistencia)-1;
                for($i=0;$i<=$contadorasis;$i++){
                foreach($infoasistencia[$i] as $infoasist[$i]){?>
                <strong><u><p>Alumno {{$infoasist[$i]->nombrealumno}}</p></u></strong>
                <?php
                break;
                }
                ?>
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Justificación</th>
                    </thead>                    
                    <tbody>
                    <?php 
                    foreach($infoasistencia[$i] as $infoasist[$i]){?>
                    <tr>
                     <td>
                     <?php
                     if($infoasist[$i]->justificacion==0){?>
                      <i class="bi bi-x-circle-fill" style="color:#ff6961 ;" title="No justificada"></i>
                      <?php 
                     }  
                     else{?>
                      <i class="bi bi-check-circle-fill" style="color:#77dd77 ;" title="Justificada"></i>
                     <?php 
                     }
                     ?>
                     </td>
                     <td>{{\Carbon\Carbon::parse($infoasist[$i]->fecha)->format('d-m-Y')}}</td>
                     <td class="td-actions v-align-middle">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#myModal{{$infoasist[$i]->id}}"> <i class="bi bi-journal-check"></i>
                      </button> 
                      <div class="modal fade bd-example-modal-lg" id="myModal{{$infoasist[$i]->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                      <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"><strong>Justificación de inasistencia</strong></h5>
                      <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                      </div>
                      <div class="modal-body">
                      <form action="{{route('enviarjustificacion',$infoasist[$i]->id)}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @METHOD('PUT')
                      <label>Comentario</label>
                      <textarea class="form-control" rows="3" name="justificacion" id="justificacion" style="border: thin solid lightgrey;" aria-describedby="comentHelp" placeholder="Ingrese aquí el motivo de la inasistencia" maxlength="200"></textarea>
                      <br>
                      <label>Archivo adjunto</label>
                      <input type="file" class="form-control" name="file" id="file" value="{{ old('file') }}">
                      <div class="modal-footer">
                      <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                      <button type="submit" class="btn btn-sm btn-facebook">Enviar justificación</button>
                    </div>
                  </div>
                </form>
                      </div>
                      </div>
                     </div>
                   </div>
                     </td>
                    </tr>
                    <?php 
                  }
                  ?>
                    </tbody>
                  </table>
                  </div>
                  
                  <?php 
                    }
                    ?>
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

