@extends('layouts.main', ['activePage' => 'formulario', 'titlePage' => __('Colegio')])

@section('content')
<style media="screen">

  img{
    max-width: 250px;
    height: auto;
  }
</style>
<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">

<div class="content">
  <div class="container-fluid">
<?php
if($colegio->isEmpty()){?>
    <div class="row">
      <div class=" col-md-12"> 
          <form action="storage/create" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <div class="card">
            <div class= "card-header card-header-info">
            <h4 class="card-title">Cargar información de colegio</h4>
            </div>
            <div class="card-body">
            <div class="row">
                <label class="col-sm-2 col-form-label">Nombre del Colegio</label>
                <div class="col-sm-7">
                <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" value="{{ old('nombre') }}">
                @error('nombre')
                <small class="text-danger">{{$message}}</small>
              @enderror 
              </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Gestión</label>
                <div class="col-sm-2">
                  <div class="form-check form-check-radio">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="gestion" id="exampleRadios1" value="privada" >Privada.
                    <span class="circle">
                    <span class="check"></span>
                    </span>
                    </label>
                    </div>
                     </div>
                     <div class="col-sm-2">
                    <div class="form-check form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="gestion" id="exampleRadios2" value="pública" checked>Pública.
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                    </div>
                @error('gestion')
                <small class="text-danger">{{$message}}</small>
              @enderror 
              </div>
             <div class="row">
                <label class="col-sm-2 col-form-label">Teléfono</label>
                <div class="col-sm-7">
                <input type="text" class="form-control" name="telefono" id="telefono" autocomplete="off" value="{{ old('telefono') }}">
                @error('telefono')
                <small class="text-danger">{{$message}}</small>
              @enderror 
              </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Dirección</label>
                <div class="col-sm-7">
                <input type="text" class="form-control" name="direccion" id="direccion" autocomplete="off" value="{{ old('direccion') }}">
                @error('direccion')
                <small class="text-danger">{{$message}}</small>
              @enderror 
              </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Localidad</label>
                <div class="col-sm-7">
                <input type="text" class="form-control" name="localidad" id="localidad" autocomplete="off" value="{{ old('localidad') }}">
                @error('localidad')
                <small class="text-danger">{{$message}}</small>
              @enderror 
              </div>
            </div>
             <div class="row">
                <label class="col-sm-2 col-form-label">Provincia</label>
                <div class="col-sm-7">
                <input type="text" class="form-control" name="provincia" id="provincia" autocomplete="off" value="{{ old('provincia') }}">
                @error('provincia')
                <small class="text-danger">{{$message}}</small>
              @enderror 
              </div>
            </div>
             <div class="row">
                <label class="col-sm-2 col-form-label">Correo electrónico</label>
                <div class="col-sm-7">
                <input type="text" class="form-control" name="email" id="email" autocomplete="off" value="{{ old('email') }}">
                @error('email')
                <small class="text-danger">{{$message}}</small>
              @enderror 
              </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Logo institucional</label>
                <div class="col-sm-7">
                <input type="file" class="form-control" name="file" id="file" accept="image/*" value="{{ old('file') }}">
                @error('file')
                <small class="text-danger">{{$message}}</small>
              @enderror  
              </div>
            </div>
              <br>
              
            </div>
            <!--Previsualizar la imagen que se va a cargar-->
             <div id="imagePreview">
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
            <div class="card-footer">
          <div class="  col-xs-12 col-sm-12 col-md-12 text-center ">
                <button type="submit" class="btn btn-sm btn-facebook">Guardar</button>
              </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php 
    }
    else {?>
<div class="card">
    <div class= "card-header card-header-primary" style="background-color: grey;">
    <h4 class="card-title">Información de colegio</h4>
    </div>
 <div class="card-body row justify-content-center">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-user" style="border: 5px solid grey">
         <div class="card-body ">
           <p class="card-text">
           <div class="author">
  @if(session('success'))
                    <div class="alert alert-success" role="success">
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
      @foreach($colegio as $col)
          <h3 class="tittle mt-3 text-center">Establecimiento {{$col->nombre}}</h3>
                          <p class="description">
                            <table class="table">
                              <tr>
                                <td class="v-align-middle">
                                  <label>Teléfono</label>&nbsp;&nbsp;{{$col->telefono}}
                                </td>
                                <td>
                                  <label>Dirección</label>&nbsp;&nbsp;{{$col->direccion}}
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <label>Localidad</label>&nbsp;&nbsp;{{$col->localidad}}
                                </td>
                                <td>
                                  <label>Provincia</label>&nbsp;&nbsp;{{$col->provincia}}
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <label>Email</label>&nbsp;&nbsp;{{$col->email}}
                                </td>
                                <td>
                            <label>Logo institucional</label>&nbsp;&nbsp;
                        <?php
        $Host ="localhost";
        $uname = "root";
        $pwd = '';
        $db_name = "centro";

        $result = mysqli_connect($Host,$uname,$pwd) or die("Could not connect to database." .mysqli_error());
        mysqli_select_db($result,$db_name) or die("Could not select the databse." .mysqli_error());
        $image_query = mysqli_query($result,"select file from files where id=$col->files_id");
        while($rows = mysqli_fetch_array($image_query))
        {
            $img_src = $rows['file'];
        }
        $rutaimagen='http://127.0.0.1:8000/file/'.$img_src.'';
        echo'<img src="'.$rutaimagen.'" width="120px" height="120px" class="first" onClick="click()"/>';?>
        <script>
        document.querySelector(".first").addEventListener("click", function() {
        Swal.fire({
  title: 'Sweet!',
  text: 'Modal with a custom image.',
  imageUrl: '$rutaimagen',
  imageWidth: 400,
  imageHeight: 200,
  imageAlt: 'Custom image',
})
        </script>
      </td>
    </tr>
      </table>
        <div class="text-right">
        <a href="{{route('edit',$col->id)}}">
            <button class="btn btn-sm btn-facebook" value="Editar">
              Editar
            </button>
        </a>
        </div>

      </div>
                                                              
        @endforeach
      </p>
              
                </div>
              </div>
            </div>
          </div>
        </div>
      
<?php
}?>

    </div>
  </div>
</div>

@endsection

