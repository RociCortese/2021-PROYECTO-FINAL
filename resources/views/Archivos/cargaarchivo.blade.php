@extends('layouts.main', ['class' => 'off-canvas-sidebar','activePage' => 'formulario', 'title' => __()]) 

@section('content')
<div class="container">
<style media="screen">

  img{
    max-width: 250px;
    height: auto;
  }
</style>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-body">
          <form action="storage/create" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div>
              <h3>Nuevo Archivo</h3>
              <div>
                </div>
                <input type="file" class="form-control" name="file" id="file" accept="image/*">
                <br>
                @error('file')
                  <small class="text-danger">{{$message}}</small>

                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Cargar</button>
              </div>
            </div>
          </form>

          <div id="imagePreview">


          </div>

          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
          <script type="text/javascript">
            (function(){
           function filePreview(input){
            if(input.files && input.files[0]){
              var reader = new FileReader();
              reader.onload= function(e){
                $('#imagePreview').html("<img src='"+e.target.result+"'/>");
              }
              reader.readAsDataURL(input.files[0]);
            }
           }
        $('#file').change(function(){
          filePreview(this);
        });
      })();
           </script>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection