
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
  
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="#"></a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">Toggle navigation</span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
    
      <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <a class="nav-link posicion" data-toggle="dropdown" href="#">
                  <i class="material-icons small" title="Mensajes">email</i>
                  <?php
                  use App\Models\ChMessage as Message;
                  use App\Models\User;
                  $cantidad=Message::where('to_id',Auth::user()->id)->where('seen',0)->count();
                  ?>
                    <span class="badge badge-danger">{{$cantidad}}</span>
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
                <span class="dropdown-header" >Tienes {{$cantidad}} mensajes para leer.</span>
                <?php
                  $usuario=Message::all()->where('to_id',Auth::user()->id)->where('seen',0);
                  foreach($usuario as $usu)
                    {   
                      $fromcolegio= "$usu->from_id";
                      $nombreusuario=User::all()->where('id',$fromcolegio);
                      foreach($nombreusuario as $nom)
                          {
                           $nombre= "$nom->name";
                           $tiempo=$nom->created_at->diffForHumans();
                         }
                      ?>
                      <a href="#" class="dropdown-item">
                    <i class="material-icons mr-2">email</i> {{$nombre }}
                      <span class="ml-3 pull-right text-muted text-sm">{{$tiempo}}</span>
                  </a>
                  <?php
                    };
                  }
                  ?>
                  
              
        
               
                </div>
              </li>
      </ul>

      <ul class="navbar-nav">
       <li class="nav-item dropdown">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">person</i>
            <p class="d-lg-none d-md-block">
              {{ __('Account') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Mis datos') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Cerrar sesión') }}</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
