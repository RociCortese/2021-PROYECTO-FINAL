<div class="sidebar" data-color="orange" data-background-color="white">

  <div class="logo">
    <img style="width:200px" src="img/LogoSnotra.jpg"class="simple-text logo-normal">
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" >

          <i class="material-icons">dashboard</i>
           <strong><p>{{ __('MENU DIRECTIVOS') }}</p></strong> 
        </a>
      </li>
      <li class="nav-item">
        <div class="collapse show" >
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('formulario')}}">
                <i class="material-icons">image</i>
                <span class="sidebar-normal">{{ __('Cargar logo institucional') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      
  </div>
</div>
