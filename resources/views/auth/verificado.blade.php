@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'verificado', 'title' => __('')])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('La cuenta ha sido verificada con éxito. Para poder comenzar a utilizarla dirigase')}} <a href="{{route('login')}}"> aquí </div>
            </div>
        </div>
    </div>
</div>
@endsection
