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
            <li class="nav-item{{ $activePage == 'formulario' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('formulario')}}">
                <i class="material-icons">info</i>
                <span class="sidebar-normal">{{ __('Información de colegio') }} </span>
              </a>
            </li>
          </ul>
        </div>
        <li class="nav-item">
        <div class="collapse show" >
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'docente' ? ' active' : '' }}">
              <a class="nav-link" href="{{url('admin/docentes')}}">
                <i class="material-icons">how_to_reg</i>
                <span class="sidebar-normal">{{ __('Registro de docentes') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <div class="collapse show" >
          <ul class="nav">
          <li class="nav-item{{ $activePage == 'alumno' ? ' active' : '' }}">
              <a class="nav-link" href="{{url('admin/alumnos')}}">
                <i class="material-icons">how_to_reg</i>
                <span class="sidebar-normal">{{ __('Registro de alumnos') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
  </div>
</div>
