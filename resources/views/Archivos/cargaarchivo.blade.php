@extends('layouts.main', ['activePage' => 'formulario', 'titlePage' => __('')])

@section('content')
<div class="container">
<style media="screen">

  img{
    max-width: 250px;
    height: auto;
  }
</style>

<div>
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-body">
          <form action="storage/create" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h3>Nuevo Archivo</h3>
            <div>
              <div>
                <input type="file" class="form-control" name="file" id="file" accept="image/*">
              </div>
              <br>
              @error('file')
                <small class="text-danger">{{$message}}</small>
              @enderror  
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
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Cargar</button>
              </div>
            </div>
          </form>
        </div>

        <!--Mostrar imagen cargada en base de datos-->
        <div>
        <h3>Imagen cargada</h3>
        <div class="img-box">
        <?php
        $Host ="localhost";
        $uname = "root";
        $pwd = '';
        $db_name = "centro";

        $result = mysqli_connect($Host,$uname,$pwd) or die("Could not connect to database." .mysqli_error());
        mysqli_select_db($result,$db_name) or die("Could not select the databse." .mysqli_error());
        $userfile = Auth::user()->file_id;
        if(is_null($userfile)){
          $rutaimagen='';
          echo 'Aún no se ha cargado ninguna imagen.';
        }
        else{
        $image_query = mysqli_query($result,"select file, id from files where id=$userfile");
        while($rows = mysqli_fetch_array($image_query))
        {
            $img_src = $rows['file'];
            $id= $rows['id'];
        }
        $rutaimagen='http://127.0.0.1:8000/file/'.$img_src.'';
      }
        ?>
        </div>
        </div>

        <!-- Eliminar imagen carga en base de datos-->

        <?php 
        if(is_null($userfile)){

        }
        else{
        ?>
        <div class="img-block">
        <?php
        echo'<img src="'.$rutaimagen.'" width="300px" height="300px"/>';?>
        </div>
        <div>

        <form action="{{route('delete')}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" class="formEliminar">
          {{csrf_field()}}
          {{method_field('delete')}}
          <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary"  >Eliminar</button>
              </div>
            </div> 
        </form>
         </div>
       <?php } ?>


        
    <!--Mostrar mensaje de alerta al eliminar-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <script>
            (function(){
              'use strict'
              var forms = document.querySelectorAll('.formEliminar')
              Array.prototype.slice.call(forms)
              .forEach(function (form){
                form.addEventListener('submit',function(event) {
                  event.preventDefault()
                  event.stopPropagation()
                  Swal.fire({
                  title: '¿Estás seguro que deseas eliminar?',
                  text: "¡No podrás revertir esto!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, borralo!'
                  }).then((result) => {
                  if (result.isConfirmed) {
                  this.submit();
                  Swal.fire(
                  'Imagen eliminada',
                  'Tu imagen ha sido eliminada.',
                  'success'
    )
  }
})
                },false)
              })
            })()
          </script>

          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <script>
            (function(){
              'use strict'
              var forms = document.querySelectorAll('.formGuardar')
              Array.prototype.slice.call(forms)
              .forEach(function (form){
                form.addEventListener('submit',function(event) {
                  event.preventDefault()
                  event.stopPropagation()
                  Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Tu imagen se ha guardado correctamente',
  showConfirmButton: false,
  timer: 1500
})
                },false)
              })
            })()
          </script>
        </div>
      </div>
    </div>
  </div>

@endsection

