<div class="sidebar" data-color="azure" data-background-color="white">

  <!--<div class="logo">
    <img style="width:200px" src="img/LogoSnotra.jpg"class="simple-text logo-normal">
  </div>-->
  <?php
  if (Auth::user()->role =='directivo') { ?>
                
  <div class="sidebar-wrapper">
    <ul class="nav">
     <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('directivo')}}">
          <i class="bi bi-list"></i>
           <strong><p>{{ __('MENU DIRECTIVOS') }}</p></strong> 
        </a>
      </li>
    
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#micolegio" aria-expanded="false">
          <div class="items-dashboard">
          <i class="bi bi-mortarboard"></i>
          <span class="sidebar-normal">Mi Colegio</span>
            <b class="caret"></b>
            </div>
        </a>
        <div class="collapse navbar-collapse" id="micolegio">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'formulario' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('formulario')}}">
                <div class="items-dashboard" >
                <i class="bi bi-info-circle"></i>
                <span class="sidebar-normal">{{ __('Informacion de Colegio') }}</span>
                </div>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'configuraciones' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('configuraciones')}}">
                <div class="items-dashboard">
               <i class="bi bi-gear"></i>
                <span class="sidebar-normal"> {{ __('Configuraciones Básicas') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </li>
        <li class="nav-item">
        <div class="collapse show">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'docente' ? ' active' : '' }}">
              <a class="nav-link" href="{{url('admin/docentes')}}">
                <div class="items-dashboard">
                <i class="bi bi-person-plus"></i>
                <span class="sidebar-normal">{{ __('Registro de docentes') }} </span>
                </div>
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
                <div class="items-dashboard">
                 <i class="bi bi-person-plus"></i>
                <span class="sidebar-normal">{{ __('Registro de alumnos') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#añoescolar" aria-expanded="false">
          <div class="items-dashboard">
          <i class="bi bi-calendar4-event"></i>
          <span class="sidebar-normal">Año escolar</span>
            <b class="caret"></b>
            </div>
        </a>
        <div class="collapse navbar-collapse" id="añoescolar">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'añoescolar' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('añoescolar')}}">
               <div class="items-dashboard"> 
                <i class="bi bi-calendar4-event"></i>
                <span class="sidebar-normal">{{ __('Creación de año escolar') }}</span>
                </div>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'armadogrado' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('armadogrado')}}">
                <div class="items-dashboard">
               <i class="bi bi-people"></i>
                <span class="sidebar-normal"> {{ __('Armado de grados') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </li>
          <li class="nav-item{{ $activePage == 'eventos' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('calendario')}}">
                <div class="items-dashboard">
               <i class="bi bi-calendar4-event"></i>
                <span class="sidebar-normal"> {{ __('Eventos') }} </span>
                </div>
              </a>
            </li>

      <li class="nav-item">
        <div class="collapse show" >
          <ul class="nav">
          <li class="nav-item{{ $activePage == 'chatdirectivo' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('chatify')}}">
                <div class="items-dashboard">
                <i class="bi bi-chat-dots"></i>
                <span class="sidebar-normal">{{ __('Central de mensajes') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
  <?php 
}
?>
 <?php
  if (Auth::user()->role =='docente') { ?>
  <div class="sidebar-wrapper">
    <ul class="nav">
     <li class="nav-item{{ $activePage == 'dashboarddocente' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('docente')}}">
          <i class="bi bi-list"></i>
           <strong><p>{{ __('MENU DOCENTES') }}</p></strong> 
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'eventos' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('calendario')}}">
                <div class="items-dashboard">
               <i class="bi bi-calendar4-event"></i>
                <span class="sidebar-normal"> {{ __('Eventos') }} </span>
                </div>
              </a>
            </li>
      <li class="nav-item">
        <div class="collapse show" >
          <ul class="nav">
          <li class="nav-item{{ $activePage == 'chatdocente' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('chatify')}}">
                <div class="items-dashboard">
                <i class="bi bi-chat-dots"></i>
                <span class="sidebar-normal">{{ __('Central de mensajes') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </li>
  </div>

<?php
}
?>
 <?php
  if (Auth::user()->role =='familia') { ?>
  <div class="sidebar-wrapper">
    <ul class="nav">
     <li class="nav-item{{ $activePage == 'dashboardfamilia' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('familia')}}">
          <i class="bi bi-list"></i>
           <strong><p>{{ __('MENU FAMILIA') }}</p></strong> 
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'eventos' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('eventosfamilia')}}">
                <div class="items-dashboard">
               <i class="material-icons">event</i>
                <span class="sidebar-normal"> {{ __('Eventos') }} </span>
                </div>
              </a>
            </li>
      <li class="nav-item">
        <div class="collapse show" >
          <ul class="nav">
          <li class="nav-item{{ $activePage == 'chatfamilia' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('chatify')}}">
                <div class="items-dashboard">
                <i class="bi bi-chat-dots"></i>
                <span class="sidebar-normal">{{ __('Central de mensajes') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </li>
  </div>

<?php
}
?>
</div>