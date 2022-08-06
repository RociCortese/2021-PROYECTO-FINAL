<?php
$detect = new Mobile_Detect;
if ($detect->isMobile() or $detect->isTablet()) {?>
<div class="sidebar" data-color="azure" data-background-color="white" style="display:none;">
<?php
}
else{?>
<div class="sidebar" data-color="azure" data-background-color="white">
<?php  
}
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
            <li class="nav-item{{ $activePage == 'docente' ? ' active' : '' }}">
              <a class="nav-link" href="{{url('admin/docentes')}}">
                <div class="items-dashboard">
                <i class="bi bi-person-plus"></i>
                <span class="sidebar-normal">{{ __('Registro de Docentes') }} </span>
                </div>
              </a>
            </li>
          <li class="nav-item{{ $activePage == 'alumno' ? ' active' : '' }}">
              <a class="nav-link" href="{{url('admin/alumnos')}}">
                <div class="items-dashboard">
                 <i class="bi bi-person-plus"></i>
                <span class="sidebar-normal">{{ __('Registro de Alumnos') }} </span>
                </div>
              </a>
            </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#añoescolar" aria-expanded="false">
          <div class="items-dashboard">
          <i class="bi bi-calendar4-event"></i>
          <span class="sidebar-normal">Año Escolar</span>
            <b class="caret"></b>
            </div>
        </a>
        <div class="collapse navbar-collapse" id="añoescolar">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'añoescolar' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('añoescolar')}}">
               <div class="items-dashboard"> 
                <i class="bi bi-calendar4-event"></i>
                <span class="sidebar-normal">{{ __('Creación de Año Escolar') }}</span>
                </div>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'armadogrado' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('armadogrado')}}">
                <div class="items-dashboard">
               <i class="bi bi-people"></i>
                <span class="sidebar-normal"> {{ __('Armado de Grados') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#infoacademica" aria-expanded="false">
          <div class="items-dashboard">
          <i class="bi bi-mortarboard"></i>
          <span class="sidebar-normal">Información académica</span>
            <b class="caret"></b>
            </div>
        </a>
        <div class="collapse navbar-collapse" id="infoacademica">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'informacionacademica' ? ' active' : '' }}">
              <a class="nav-link" href="{{url('informacionacademica')}}">
                <div class="items-dashboard">
                 <i class="bi bi-person-plus"></i>
                <span class="sidebar-normal">{{ __('Historial académico') }} </span>
                </div>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'libretas' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('libretas')}}">
                <div class="items-dashboard">
               <i class="bi bi-journal-text"></i>
                <span class="sidebar-normal"> {{ __('Impresión de Informes') }} </span>
                </div>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'pasegrado' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <div class="items-dashboard">
               <i class="bi bi-journal-text"></i>
                <span class="sidebar-normal"> {{ __('Pase de grado') }} </span>
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
<?php 
}
  if (Auth::user()->role =='docente') { ?>
  <div class="sidebar-wrapper">
    <ul class="nav">
     <li class="nav-item{{ $activePage == 'dashboarddocente' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('docente')}}">
          <i class="bi bi-list"></i>
           <strong><p>{{ __('MENU DOCENTES') }}</p></strong> 
        </a>
      </li>
       <li class="nav-item">
        <div class="collapse show">
          <ul class="nav">
      <li class="nav-item{{ $activePage == 'eventos' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('calendario')}}">
                <div class="items-dashboard">
               <i class="bi bi-calendar4-event"></i>
                <span class="sidebar-normal"> {{ __('Eventos') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
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
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#registronotas" aria-expanded="false">
          <div class="items-dashboard">
          <i class="bi bi-award"></i>
          <span class="sidebar-normal">Registro de notas</span>
            <b class="caret"></b>
            </div>
        </a>
        <div class="collapse navbar-collapse" id="registronotas">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'criteriosevaluacion' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('criteriosevaluacion')}}">
               <div class="items-dashboard"> 
                <i class="bi bi-list-check"></i>
                <span class="sidebar-normal">{{ __('Criterios de Evaluación') }}</span>
                </div>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'carganotas' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('buscadornotas')}}">
                <div class="items-dashboard">
               <i class="bi bi-pencil-square"></i>
                <span class="sidebar-normal"> {{ __('Carga de Notas') }} </span>
                </div>
              </a>
            </li>
          </ul>
        </div>
      <?php
      $idpersona= Auth::user()->idpersona;
      $tipodocente=App\Models\Docente::where('id',$idpersona)->get();
      foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
      }
      if($tipodoc=='Grado'){?>
        <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#asistencias" aria-expanded="false">
          <div class="items-dashboard">
          <i class="bi bi-journal-text"></i>
          <span class="sidebar-normal">Asistencias</span>
            <b class="caret"></b>
            </div>
        </a>
        <div class="collapse navbar-collapse" id="asistencias">
          <ul class="nav">
             <li class="nav-item{{ $activePage == 'cargasistenciagrado' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('asistencias')}}">
                <div class="items-dashboard">
               <i class="bi bi-journal-text"></i>
                <span class="sidebar-normal"> {{ __('Registro de Asistencias') }} </span>
                </div>
              </a>
            </li>
             <li class="nav-item{{ $activePage == 'justificacioninasistencias' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('justificacioninasistencias')}}">
                <div class="items-dashboard">
               <i class="bi bi-journal-text"></i>
                <span class="sidebar-normal"> {{ __('Gestión de Justificaciones') }} </span>
                </div>
              </a>
            </li>
           
          </ul>
        </div>
      </li>
       
      <?php 
      }
      if($tipodoc!='Grado'){?>
       <li class="nav-item">
        <div class="collapse show">
          <ul class="nav">
      <li class="nav-item{{ $activePage == 'cargasistencia' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('asistencias.especiales')}}">
        <div class="items-dashboard">
        <i class="bi bi-journal-text"></i>
        <span class="sidebar-normal"> {{ __('Registro de Asistencias') }} </span>
        </div>
        </a>
      </li>
    </ul>
  </div>
      <?php
}
?>
    </li>
  </ul>
  </div>
<?php
}
  if (Auth::user()->role =='familia') { ?>
  <div class="sidebar-wrapper">
    <ul class="nav">
     <li class="nav-item{{ $activePage == 'dashboardfamilia' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('familia')}}">
          <i class="bi bi-list"></i>
           <strong><p>{{ __('MENU FAMILIA') }}</p></strong> 
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'asistenciasfamilia' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('asistenciasalumnos')}}">
                <div class="items-dashboard">
               <i class="bi bi-journal-text"></i>
                <span class="sidebar-normal"> {{ __('Asistencias') }} </span>
                </div>
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
    </ul>
</div>
<?php
}
?>
</div>