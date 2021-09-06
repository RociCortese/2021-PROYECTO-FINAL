<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <title>Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/estilos.css') }}">

  </head>
  <body>
    <div class="container mt-5">
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-5">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="input-group form">
                      </div>
                    </div>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="navbar navbar-inverse" role="banner">
                      <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                      </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="page-content">
        <div class="row">
          
          <div class="col-md-2">
            <div class="sidebar content-box" style="display: block;">

              <ul class="list-group">
                  <li class="list-group-item">
                    <a href="{{ url('admin/docentes') }}"> Docentes</a>
                  </li>
              </ul>
            </div>
          </div>
        
            <div class="col-md-10">

        <!--<nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Alumnos</li>
          </ol>
        </nav>-->
        
        <div class="row">

          <div class="col-md-12">

              <div class="content-box-large">

                <div class="panel-heading">
                <div class="panel-title"><h2>Docentes</h2></div>             
                    
              </div>
                
                <div class="panel-body">


                <div class="card">

                              <div class="card-block">
                                <a href="{{url ('admin/docentes/create') }}" class="btn btn-success mt-4 ml-3">  Agregar
                                </a>
                                  
                                  <section class="example mt-4">
                                      
                                    <div class="table-responsive">                                      
                                      
                                      <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                          <tr>
                                            <th>DNI</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Fecha de nacimiento</th>
                                            <th>Género</th>
                                            <th>Domicilio</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th>Estado civil</th>
                                            <th>Teléfono</th>
                                            <th>Correo electrónico</th>
                                            <th>Legajo</th>
                                            <th>Especialidad</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($docentes as $doc)
                                          <tr>
                                            <td class="v-align-middle">{{$doc->dni}}</td>
                                            <td class="v-align-middle">{{$doc->nombre}}</td>
                                            <td class="v-align-middle">{{$doc->apellido}}</td>
                                            <td class="v-align-middle">{{$doc->fechanacimiento}}</td>
                                            <td class="v-align-middle">{{$doc->genero}}</td>
                                            <td class="v-align-middle">{{$doc->domicilio}}</td>
                                            <td class="v-align-middle">{{$doc->localidad}}</td>
                                            <td class="v-align-middle">{{$doc->provincia}}</td>
                                            <td class="v-align-middle">{{$doc->estadocivil}}</td>
                                            <td class="v-align-middle">{{$doc->telefono}}</td>
                                            <td class="v-align-middle">{{$doc->email}}</td>
                                            <td class="v-align-middle">{{$doc->legajo}}</td>
                                            <td class="v-align-middle">{{$doc->especialidad}}</td>                                                     
                                          </tr>                                          
                                          @endforeach
                                        </tbody>
                                      </table>
                                    </div>
                                  </section>
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

      <script crossorigin="anonymous" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script crossorigin="anonymous" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script crossorigin="anonymous" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        function ConfirmDelete()
        {
        var x = confirm("Estas seguro de Eliminar?");
        if (x)
          return true;
        else
          return false;
        }
    </script>
  
  </body>

</html> 