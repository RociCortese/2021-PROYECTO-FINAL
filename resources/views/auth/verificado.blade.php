
@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'verificado', 'title' => __('')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <div class="card card-login card-hidden mb-3">
            <div class="card-header card-header-primary text-center">
              <p class="card-title"><strong>{{ __('EMAIL VERIFICADO') }}</strong></p>
            </div>
            <div class="card-body" align="center">
                  <div class="logo" align="center">
                    <img style="width:80px" src="img/emailOK.png" >
                </div>
                
              <p class="card-description text-light"></p>
                   {{ __('La cuenta ha sido verificada con éxito. Para poder comenzar a utilizarla dirigase')}} <a href="{{route('login')}}"><br> <u>haciendo clic aquí.</u>  
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection