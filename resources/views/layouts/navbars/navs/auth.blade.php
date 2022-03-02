<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
  
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="#"></a>
    </div>
   
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <a class="nav-link posicion" data-toggle="dropdown" href="#">
                  <i class="bi bi-chat-dots" style="font-size: 1.5rem; "></i>
                  <?php
                  use App\Models\ChMessage as Message;
                  use App\Models\User;
                  use Carbon\Carbon;
                  $cantidad=Message::where('to_id',Auth::user()->id)->where('seen',0)->count();
                  ?>
                    <span class="num">{{$cantidad}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <?php
                if($cantidad==0)
                {
                  ?>
                  <span class="dropdown-header" >No hay mensajes para leer.</span>
                  <?php
                }
                else{
                    ?>
                <span class="dropdown-header" style="color: #007991;"><strong>MENSAJES NO LEÍDOS</strong></span>
                <span class="dropdown-header" >Tienes {{$cantidad}} mensajes para leer.</span>
                <?php

                  $usuario=Message::all()->where('to_id',Auth::user()->id)->where('seen',0)->sortByDesc('created_at')->unique('from_id');
                  $count = 0;

                  foreach($usuario as $usu)
                    { 
                      if($count == 5){
                        break;
                      }
                      $fromcolegio= "$usu->from_id";
                      $nombreusuario=User::all()->where('id',$fromcolegio);
                      foreach($nombreusuario as $nom)
                          {
                           $nombre= "$nom->name";
                         }
                         $tiempo=$usu->created_at->diffForHumans();
                      ?>
                      <a href="{{url('chatify',$usu->from_id)}}" class="dropdown-item">
                    <i class="bi bi-envelope-fill" style="font-size: 1rem;">&nbsp</i> {{$nombre}}
                      <span class="ml-3 pull-right text-muted text-sm">{{$tiempo}}</span>
                      <?php
                      $count++;
                    }
                  ?>
                  </a>
                  
                  <a href="{{ route('chatify') }}"><span class="dropdown-header text-right">Ver todos los mensajes</span></a>
                  <?php
                    };

                  ?>


                </div>
              </li>
      </ul>
      <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <?php
                  use App\Models\Event;
                  use App\Models\estadoevento;
                  $eventosparticipantes=estadoevento::where('id_participante',Auth::user()->id)->get();
                  $count=0;
                  foreach($eventosparticipantes as $eventpart)
                  {
                  $evento=Event::where('id',$eventpart->id_evento)->get();
                  foreach($evento as $event){
                  $fechaevento="$event->fecha";
                  if($fechaevento>=date("Y-m-d")){
                  $count++;
                  }
                }
                }
                  ?>
                <a class="nav-link posicion" data-toggle="dropdown" href="#">
                  <i class="bi bi-bell" style="font-size: 1.5rem; "></i>
                    <span class="num">{{$count}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="width:500%;">
                <?php
                if($count==0)
                {
                  ?>
                  <span class="dropdown-header" >No tiene próximos eventos.</span>
                  <?php
                }
                else{
                    ?>
                <span class="dropdown-header" style="color: #007991; margin-left:-4%;"><strong>PRÓXIMOS EVENTOS</strong></span>
                <?php
                  $count = 0;
                  $nuevoseventos=estadoevento::where('id_participante',Auth::user()->id)->get();
                  $rolparticipante=User::where('id',Auth::user()->id)->pluck("role");
                    $rolparticipante = preg_replace('/[\[\]\.\;\" "]+/', '', $rolparticipante);
                  foreach($nuevoseventos as $nueveventos){
                    if($count == 3){
                        break;
                      }
                  $idevento="$nueveventos->id_evento";
                  $infoevento=Event::where('id',$idevento)->get();
                  foreach($infoevento as $nuevo)
                    { 
                      $month= "$nuevo->fecha";
                      $titulo="$nuevo->titulo";
                    if($rolparticipante=='familia'){
                    if($month>=date("Y-m-d")){ 
                    ?>
                    <a href="{{route('eventosfamilianotif',$nuevo->id)}}" class="dropdown-item">
                    <i class="bi bi-calendar-event" style="font-size: 1rem;margin-left:-10%">&nbsp &nbsp</i><span>{{$titulo}}</span>
                    <span class="ml-3 text-muted">{{\Carbon\Carbon::parse($month)->diffForHumans()}}</span>
                    </a>
                    <?php }
                  }
                    if($rolparticipante=='docente'){
                    if($month>=date("Y-m-d")){ 
                    ?>
                    <a href="{{route('calendariodocente',$month)}}" class="dropdown-item">
                    <i class="bi bi-calendar-event" style="font-size: 1rem;margin-left:-10%">&nbsp &nbsp</i><span> {{$titulo}}</span>
                    <span class="ml-3 text-muted">{{\Carbon\Carbon::parse($month)->diffForHumans()}}</span>
                    </a>
                    <?php }
                  }
                    if($rolparticipante=='directivo'){
                    if($month>=date("Y-m-d")){ 
                    ?>
                    <a href="{{route('calendariodirectivo',$month)}}" class="dropdown-item">
                    <i class="bi bi-calendar-event" style="font-size: 1rem;margin-left:-10%">&nbsp &nbsp</i><span> {{$titulo}}</span>
                    <span class="ml-3 text-muted">{{\Carbon\Carbon::parse($month)->diffForHumans()}}</span>
                    </a>
                    <?php } }
                    }
                    }?>
                    <span class="dropdown-header text-center" >Solo se muestran los próximos tres eventos.</span>
                    <?php $count++;
                  }
                
                  ?>
                </div>
              </li>
      </ul>
      <ul class="navbar-nav">
       <li class="nav-item dropdown">
        <li class="nav-item dropdown">
          <a class="nav-link" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-person-circle" style="font-size: 1.5rem; "></i>
            <p class="d-lg-none d-md-block">

              {{ __('Account') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>&nbsp &nbsp{{ __('Mis datos') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right" style="font-size: 1.5rem;"></i>&nbsp &nbsp {{ __('Cerrar sesión') }}</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>