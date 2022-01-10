@extends('layouts.main' , ['activePage' => 'eventos', 'titlePage => Calendario de Eventos'])

@section ('content')
<div class="content">
   <div class="container-fluid">
     <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title"> Calendario</h4>
                <p class="card-category">Calendario de Eventos</p>    
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">
                  <a class="btn btn-sm btn-facebook text-right"  href="{{ url('/evento/form') }}">Crear Evento </a>


                    @if(session('success'))
                    <div class="alert alert-success text-left" role="success">
                    {{session('success')}}
                    </div>
                    <script type="text/javascript">
                    window.setTimeout(function() {
                    $(".alert-success").fadeTo(400, 0).slideUp(400, function(){
                    $(this).remove(); 
                    });
                    }, 1000);
                    </script>
                    @endif
      <div class="row header-calendar" style="margin-right:10px;">
       <div class="col" style="display: flex; justify-content: space-between; padding: 10px;">
          <a  href="{{ asset('/Evento/index/') }}/<?= $data['last']; ?>" style="margin:10px;">
            <i class="material-icons" style="font-size:50px;color:white;">chevron_left</i>
          </a>
          <h2 style="font-weight:bold;margin:10px;"><?= $mespanish; ?> <small><?= $data['year']; ?></small></h2>
          <a  href="{{ asset('/Evento/index/') }}/<?= $data['next']; ?>" style="margin:10px;">
            <i class="material-icons" style="font-size:50px;color:white;">navigate_next</i>
          </a>
        </div>
      </div>


        <div class="row" style="margin-right:10px;">
        <div class="col header-col">Lunes</div>
        <div class="col header-col">Martes</div>
        <div class="col header-col">Miercoles</div>
        <div class="col header-col">Jueves</div>
        <div class="col header-col">Viernes</div>
        <div class="col header-col">Sabado</div>
        <div class="col header-col">Domingo</div>
        </div>
      <!-- inicio de semana -->
      @foreach ($data['calendar'] as $weekdata)
        <div class="row" style="margin-right:10px;">
          <!-- ciclo de dia por semana -->
          @foreach  ($weekdata['datos'] as $dayweek)

          @if  ($dayweek['mes']==$mes)
            <div class="col box-day">
              {{ $dayweek['dia']  }}
              <!-- evento -->
              @foreach  ($dayweek['evento'] as $event) 
                  <a class="badge badge-primary" href="{{ asset('/Evento/details/') }}/{{ $event->id }}">
                    {{ $event->titulo }}
                  </a>
              @endforeach
            </div>
          @else
          <div class="col box-dayoff">
          </div>
          @endif


          @endforeach
        </div>
      @endforeach

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