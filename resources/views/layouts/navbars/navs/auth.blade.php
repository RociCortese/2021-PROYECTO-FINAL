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
                <span class="dropdown-header text-danger"><strong>MENSAJES NO LEIDOS</strong></span>
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
                    <i class="material-icons mr-2">email</i> {{$nombre}}
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
        <li class="nav-item dropdown">
          <a class="nav-link" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-person-circle" style="font-size: 1.5rem; "></i>
            <p class="d-lg-none d-md-block" >
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