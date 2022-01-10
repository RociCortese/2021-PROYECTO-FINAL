@extends('layouts.main', ['activePage' => 'dashboardfamilia', 'titlePage' => __('Dashboard Docente')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card" style="width: 18rem;">
              <img class="card-img-top">
                <div class="card-body">
                <h5 class="card-title">Eventos</h5>
                   <p class="card-text">Proximos eventos</p>
                   <a href="#" class="btn btn-primary">Go somewhere</a>
                      </div>
                    </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

