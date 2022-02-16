@extends('layouts.main', ['activePage' => 'dashboardfamilia', 'titlePage' => __('Dashboard Docente')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class= "card-header card-header-info">
              <h4 class="card-title">Próximos eventos</h4>
              </div>
                <div class="card-body" style="display: flex;justify-content:space-around;flex-wrap: wrap;">
                  @if($eventosproximos->isEmpty())
              <div> No tienes próximos eventos.</div>
              @else
                <?php
                foreach ($eventosproximos as $event) {
                  ?>
                <div class="card" style="border: solid lightgrey;width: 300px">
                  <div class="card-body">
                  <?php 
                  $participantesevent=explode(' ', $event->participantes);
                  $cantidad=count($participantesevent)-1;
                  for($i=0; $i<=$cantidad; $i++){   
                  $estadoevento= App\Models\estadoevento::where('id_participante',$participantesevent[$i])->get();
                  foreach ($estadoevento as $estevent) {
                    $estadoevent="$estevent->estado";
                    if($estadoevent=='Pendiente'){?>
                      <div class="text-right">
                      <i title="Pendiente" class="bi bi-clock  text-center" style="color: #36D1DC;font-size: 2em;"></i>
                      </div>
                    <?php }
                    if($estadoevent=='Aceptado'){?>
                      <div class="text-right">
                      <i title="Aceptado" class="bi bi-check-circle" style="color: #3DC515; font-size: 2em;"></i>
                      </div>
                    <?php }
                    if($estadoevent=='Rechazado'){?>
                      <div class="text-right">
                      <i title="Rechazado" class="bi bi-x-circle text-center" style="color: #FC0417; font-size: 2em;"></i>
                      </div>
                    <?php }
                }
              }
              ?>
                  <table class="table">
                    <tr>
                      <td>
                        <label>Título:</label>  {{$event->titulo}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Fecha:</label>  {{ \Carbon\Carbon::parse($event->fecha)->format('d/m/Y')}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Hora:</label>  {{$event->hora}}
                      </td> 
                    </tr>
                  </table>
                  
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                  <button href="#" class="btn btn-sm btn-facebook" data-toggle="modal" data-target="#myModal{{$event->id}}">Ver más información</button>
                  <div class="modal fade bd-example-modal-lg text-left" id="myModal{{$event->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <div class="modal-header">
                  <i class="material-icons">event</i><h5 class="modal-title" id="exampleModalLabel"><strong>Vista detallada del evento {{$event->titulo}}</strong></h5>
                  <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                  </div>
                  <div class="modal-body ">
                  <table class="table">
                  <tr>
                  <td class="v-align-middle" >
                    <label>Creador del evento:</label>  {{$event->creador}}
                  </td>
                  </tr>
                  <tr>
                  <td class="v-align-middle" >
                    <label>Tipo de evento:</label>  {{$event->tipo}}
                  </td>
                  </tr>
                  <tr>
                  <td class="v-align-middle">
                    <label>Descripción:</label>  {{$event->descripcion}}
                  </td>
                  </tr>
                  <tr>
                  <td class="v-align-middle">
                    <label>Fecha:</label>  {{ \Carbon\Carbon::parse($event->fecha)->format('d/m/Y')}}
                  </td>
                  </tr>
                  <tr> 
                  <td class="v-align-middle">
                    <label>Hora:</label>  {{$event->hora}}
                  </td>
                  </tr>
                  <tr> 
                  <td class="v-align-middle">
                    <label>Lugar:</label>  {{$event->lugar}}
                  </td>
                  </tr>
                  </table>
                  <?php if($event->tipo=='Reunión'){?>
                  <form method="POST" action="{{route('actualizarestadoevento')}}">
                    @csrf
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                  <input type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal" value="Rechazar"></input>

                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                  <div class="modal-content">
      <div class="modal-header" style="background-color: #F9EAE7;">
        <i title="Rechazado" class="bi bi-x-circle text-center" style="color: #FC0417; font-size: 1.5em;"></i> &nbsp<h5 class="modal-title" id="exampleModalLabel"><strong>Rechazo</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group text-left">
            <label for="message-text" class="col-form-label">Motivo de rechazo</label>
            <br>
            <textarea id="message-text" style="width: 100%;"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button href="{{route('actualizarestadoevento')}}" type="button" class="btn btn-sm btn-facebook">Guardar</button>
      </div>
    </div>
  </div>
</div>
                  <a href="{{route('actualizarestadoevento')}}"type="submit" class="btn btn-sm btn-success">Aceptar</a>
                  </div>
                  <?php 
                }
                ?>
                            
                         </div>
                          </div>
                          </div>
                        </div>
                  </div>
                  </div>
                           
                  </div>
                   
                <?php
            }?>
            @endif
                </div>
                
                    </div>
                    <div class="card">
              <div class= "card-header card-header-info">
              <h4 class="card-title">Eventos anteriores</h4>
              </div>
              <div class="card-body">
              <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>Título</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Más información</th>
                    </thead>
                          <?php
                foreach ($eventosanteriores as $eventant) {
                  ?>
                    <tr>
                      <td class="v-align-middle" >
                        {{$eventant->titulo}}
                      </td>
                    
                    
                      <td class="v-align-middle" >
                      {{ \Carbon\Carbon::parse($eventant->fecha)->format('d/m/Y')}}
                      </td>
                   
                      <td class="v-align-middle" >
                        {{$eventant->hora}}
                      </td> 
                       <td class="td-actions td-actions v-align-middle">
                  <button href="#" class="btn btn-info" data-toggle="modal" data-target="#myModal{{$eventant->id}}">
                    <i class="material-icons">info</i></button>
                  <div class="modal fade bd-example-modal-lg text-left" id="myModal{{$eventant->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <div class="modal-header" style="background-color: lightblue;">
                  <i class="material-icons">event</i><h5 class="modal-title" id="exampleModalLabel"><strong>Vista detallada del evento {{$eventant->titulo}}</strong></h5>
                  <button type="button" class="close" data-dismiss="modal" title="Cerrar">&times;</button>
                  </div>
                  <div class="modal-body ">
                  <table class="table">
                  <tr>
                  <td class="v-align-middle" >
                    <label>Creador del evento:</label>  {{$eventant->creador}}
                  </td>
                  </tr>
                  <tr>
                  <td class="v-align-middle" >
                    <label>Tipo de evento:</label>  {{$eventant->tipo}}
                  </td>
                  </tr>
                  <tr>
                  <td class="v-align-middle">
                    <label>Descripción:</label>  {{$eventant->descripcion}}
                  </td>
                  </tr>
                  <tr>
                  <td class="v-align-middle">
                    <label>Fecha:</label>  {{ \Carbon\Carbon::parse($eventant->fecha)->format('d/m/Y')}}
                  </td>
                  </tr>
                  <tr> 
                  <td class="v-align-middle">
                    <label>Hora:</label>  {{$eventant->hora}}
                  </td>
                  </tr>
                  <tr> 
                  <td class="v-align-middle">
                    <label>Lugar:</label>  {{$eventant->lugar}}
                  </td>
                  </tr>
                  </table>
                </div>
              </div>
                            
                         </div>
                          </div>
                          </div>
                        </div>
                  </div>
                  </td>
                </tr>
              </table>
                    <?php
            }?>
                  </table>
                  
                 
                  </div>
                     <div class="card-footer mr-auto">
                {{$eventosanteriores->links() }}
                
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

