<?php
   //codigo consulta mysqli
   session_start();
   require '../login/funcs/conexion.php';
   require '../login/funcs/funcs.php';

   if(!isset($_SESSION['id_usuario'])){
       header("Location: login.php");
   }

   $idUsuario = $_SESSION['id_usuario'];

   $sql = "SELECT id_usuario, nombre_persona, rela_persona FROM usuario,persona WHERE id_usuario = '$idUsuario'";
   $result = $mysqli->query($sql);
   $row = $result->fetch_assoc();
   $relac_per = $row['rela_persona'];
   
   //fin consulta mysqli
   
   
   
   // //codigo consulta PDO
  include_once('conexion.php');

  $sql_profesional = "SELECT * FROM profesional,profesion Where rela_persona= $relac_per and rela_profesion = id_profesion";
     $query_profesional = $base_de_datos->prepare($sql_profesional);
     $query_profesional->execute();
     $result_profesional = $query_profesional->fetchAll(PDO::FETCH_ASSOC);

     foreach( $result_profesional as $unprofesional){
       $id_profesionalUno = $unprofesional['id_profesional'];
       $matricula_profesionalUno = $unprofesional['matricula'];
       $especialidad_profesionalUno = $unprofesional['especialidad'];
       $profesion_profesionalUno = $unprofesional['descripcion_profesion'];
       $imagen_tituloUno= $unprofesional['imagen_titulo'];
       $imagen_matriculaUno= $unprofesional['imagen_matricula'];
     }
     
 

  //HACEMOS UNA CONSULTA A LA TABLA USERS PARA EXTRAERME LAS FILAS Y GUARDAMOS $sentenciauser//
  $sentenciauser= $base_de_datos->query("SELECT * FROM usuario,persona WHERE id_usuario = $idUsuario and rela_persona =  $relac_per");
  //HACEMOS UNA CONSULTA A LA TABLA TIPO_ESTUDIO PARA EXTRAERME LAS FILAS Y GUARDAMOS $sentenciatipoestudio //
  $sentenciatipoestudio=$base_de_datos->query("SELECT * FROM tipo_estudio ");
  
  $sentenciapersona= $base_de_datos->query("SELECT * FROM persona where id_persona = $relac_per");
  $sentenciaprof= $base_de_datos->query("SELECT * FROM profesional");
  $sentencia_cliente= $base_de_datos->query("SELECT * FROM cliente");
  $sentenciatipoconsulta= $base_de_datos->query("SELECT * FROM tipo_consulta ");
  $sentenciaconsulta= $base_de_datos->query("SELECT * FROM consulta ,tipo_consulta, profesional WHERE consulta.rela_profesional= $id_profesionalUno and rela_tipo_consulta = id_tipo_consulta and profesional.rela_persona = $relac_per ");

  //ALMACENAMOS EN UN ARRAY LA VARIABLE ESTUDIOS COMO PERSONAS.
  $estudios= $sentenciatipoestudio->fetchAll(PDO::FETCH_OBJ);
  $usuario=$sentenciauser->fetchAll(PDO::FETCH_OBJ); // fetchAll devuelve toda la fila de la base de datos
  $personas=$sentenciapersona->fetchAll(PDO::FETCH_OBJ);
  $prof=$sentenciaprof->fetchAll(PDO::FETCH_OBJ);
  $cliente = $sentencia_cliente->fetchAll(PDO::FETCH_OBJ);
  $consultas=$sentenciaconsulta->fetchAll(PDO::FETCH_OBJ);
  $ptipo_consultas=$sentenciatipoconsulta->fetchAll(PDO::FETCH_OBJ);

  foreach ($cliente as $clientes) {
    $id_cliente=$clientes->id_cliente;
    $rela_persona_cliente=$clientes->rela_persona;
  }

  //print_r($personas);
  //RECORREMOS EL ARRAY PERSONAS PARA ASIGNARLE CADA ELEMENTO DELA TABLA A UNA VARIABLE
  foreach ($usuario as $cosas) {
    $id_user=$cosas->id_usuario;
    $nombre_usuario=$cosas->nombre_usuario;
    $rela_tipo=$cosas->rela_tipo;
    $rela_persona_usuario = $cosas->rela_persona;
  }

  foreach($personas as $persona){
    $id_persona=$persona->id_persona;
    $nombre_persona=$persona->nombre_persona;
    $apellido_persona=$persona->apellido_persona;
    $dni_persona=$persona->dni_persona;
    $correo_persona=$persona->correo_persona;
    $direccion=$persona->direccion;
    $cuil_persona=$persona->cuil_persona;
    $dni_persona=$persona->dni_persona;
    $imagen_perfil=$persona->imagen_icono;
  }

  foreach($prof as $profe){
    $id_profesional=$profe->id_profesional;
    $matricula=$profe->matricula;
    $imagen_titulo= $profe->imagen_titulo;
    $imagen_matricula= $profe->imagen_matricula;
    $especialidad= $profe->especialidad;
  }
 
  //echo $rela_persona_usuario;
  //echo $relac_per;

 ?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Consprof | Administración de consultas</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="inicio.php" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contacto</a>
        </li>
      </ul>

      <!-- FORMULARIO DE BUSCAR -->
      <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Buscar">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    <?php echo "$nombre_persona"; ?>
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
        <!--Codigo Rony-->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo 'Bienvenido '.utf8_decode($row['nombre_persona']).'              '; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Configuración</a>
                        <a class="dropdown-item" href="perfil.php">Mi perfil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../login/logout.php">Salir</a>
                    </div>
                </li>
        </ul>
        <!--Fin Codigo Rony-->

      </ul>
    </nav>
    <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="starter.php" class="brand-link">
      <!--<img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>-->
      <img src="../img/lOGO-2.png" class="brand-text font-weight-light" alt="" id="logoimg">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img class="img-circle elevation-2" alt="User Image" src="data:image/jpg; base64, <?php echo base64_encode ($imagen_perfil); ?> "/>
        </div>
        <div class="info">
          <a href="perfil.php" class="d-block"><?php echo "$nombre_persona"." ".$apellido_persona; ?></a>
        </div>
      </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item has-treeview">
                  <a href="inicio.php" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                      Inicio
                    </p>
                  </a>
              </li>
            <?php 
                 if( $rela_tipo == 1 ){
                  
            ?>
            <li class="nav-item">
              <a href="starter.php" class="nav-link active">
                <i class="nav-icon fas fa-wrench"> </i>
                <p>
                  Administrar Consultas
                </p>
              </a>
            </li>
            <?php  }  ?>
            
        


            <li class="nav-item">
              <a href="data.php" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <p>
                  Consultas Pendientes
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-box"></i>
                  <p>
                    Consultas rapidas
                  </p>
                </a>
            </li>

            

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Administrar Consultas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Administrar Consultas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#perfil" data-toggle="tab">Consulta</a></li>

                  <li class="nav-item"><a class="nav-link " href="#settings" data-toggle="tab">Configuración</a></li>
                </ul>
              </div><!-- /.card-header -->


              <!-- RECORREMOS EL ARRAY PERSONAS CON UN FOREACH Y EXTRAEMOS LOS DATOS DE LA TABLA USERS -->
              <!-- INSERTAMOS LO QUE ENCUENTRA EN LA TABLA USERS Y MOSTRAMOS EN LA PAG PERFIL -->

              <!-- COMIENZA TODO EL DESMADRE -->
              <div class="card-body">
                <div class="tab-content">

                  <div class="active tab-pane" id="perfil">

                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-primary card-outline">
                          <div class="card-header">
                            <h3 class="card-title">
                              <i class="fas fa-edit"></i>
                              Consultas
                            </h3>
                          </div>
                          <section class="content">
                            <div class="container-fluid">

                              <div class="row">
                                <?php foreach ($consultas as $hola) { ?>

                                  <div class="col-12 col-md-6">
                                  <!-- DIRECT CHAT -->

                                  <div class="card direct-chat direct-chat-primary">
                                    <div class="card-header">
                                      <h3 class="card-title"><?php echo $hola->descripcio_tipo_consulta?></h3>

                                      <div class="card-tools">

                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                          <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Editar consulta"
                                                data-widget="chat-pane-toggle">
                                          <i class="fas fa-edit"></i>
                                        </button>

                                      </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                      <!-- Conversations are loaded here -->
                                      <div class="direct-chat-messages">
                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg">
                                          <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name float-left"></span>

                                          </div>
                                          <!-- /.direct-chat-infos -->

                                          <!-- /.direct-chat-img -->
                                          <div class="cajaConsulta">
                                             <?php echo $hola->descripcion_consulta?>
                                          </div>
                                          <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                        <div class="direct-chat-msg right">
                                          <div class="direct-chat-infos clearfix" style="margin-right: 4px;">
                                            <span class="direct-chat-name float-right"> Precio: $<?php echo $hola->precio_consulta?></span>
                                          </div>
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                      </div>
                                      <!--/.direct-chat-messages-->

                                      <!-- Contacts are loaded here -->
                                    <div class="direct-chat-contacts ">

                                      <form action="administrar_consultas.php"  method="POST">
                                        <input type="hidden" name="id_user" value="<?php echo $hola->id_consulta?>">

                                        <div class="row">
                                          <div class="col-sm-12">
                                            <!-- textarea -->
                                            <div class="form-group">
                                              <label>Descripcion de la consulta</label>
                                              <textarea class="form-control" name="descripcion_consulta" rows="2"><?php echo $hola->descripcion_consulta?></textarea>
                                            </div>
                                          </div>
                                        <!-- /.contacts-list -->

                                      </div>

                                      <div class="row">
                                        <div class="col-sm-12">
                                          <!-- textarea -->
                                          <div class="form-group">
                                            <label style="margin-left: 2%;" >Precio de la consulta</label>
                                            <div class="clearfix"></div>
                                            <input type="number"  class="form-control" style="width: 31%; float: left; margin-right: 47%; margin-left: 2%;" name="precio" value="<?php echo $hola->precio_consulta?>">
                                            <button type="submit" class="btn btn-success" style="width: 19% ;" name="editar_datos">Editar</button>
                                            <div class="clearfix"></div>
                                          </div>
                                        </div>
                                      <!-- /.contacts-list -->

                                    </div>
                                      <div class="card-footer float-right">

                                          <div class="input-group ">

                                              

                                          </div>

                                      </div>

                                    </form>
                                  </div>
                                      <!-- /.direct-chat-pane -->

                                    </div>
                                    <!-- /.card-body -->

                                    <!-- /.card-footer-->
                                  </div>
                                  <!--/.direct-chat -->
                              </div>
                              <?php } ?>

                              </div>

                            </div>
                          </section>
                          <!-- /.card -->
                        </div>
                      </div>
                      <!-- /.col -->
                    </div>

                  </div>

                  <!-- FIN DEL ROW -->



                  <!-- RECORREMOS EL ARRAY PERSONAS EXTRAEMOS LOS DATOS DE LA TABLA USERS -->
                  <!-- INSERTAMOS LO QUE ENCUENTRA EN LA TABLA USERS Y MOSTRAMOS EN LA PAG CONFIGURACION -->
                  <!-- ASIGNAMOS EN UN INPUT EL NAME PARA PODER EXTRAER DE UN METODO POST LO QUE EL USUARIO QUIERA EDITAR -->
                  <!-- PARA PODER MOSTRAR LOS DATOS QUE TENGO EN LA TABLA USERS INSERTO EN UN VALUE UN PHP CON LA
                       VARIABLE QUE LE CORESPONDE (ESA VARIABLE SE ENCUENTRA DENTRO DEL FOREACH QUE ESTA AL PRINCIPIO DEL PHP PERFIL.PHP)-->
                  <div class="tab-pane" id="settings">


                    <form class="form-horizontal" action="administrar_consultas.php" method="post">
                      <input type="hidden" name="id_user" value="<?php echo $id_profesionalUno; ?>">
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Agregar Consultas</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Consultas </strong>
                        
                          <div class="card-body">
                           
                            <div class="row">

                              <div class="col-3">
                                <h3 class="card-title">Tipo de Consulta</h3>
                                <select class="form-control" name= "tipo_consulta" required>
                                  <option value="1">General</option>
                                  <option value="2">Específico</option>

                                </select>
                              </div>

                              <div class="col-5">
                                <h3 class="card-title">Descripción de la Consulta</h3>
                                <input type="text" name="descripcion_consulta" class="form-control" placeholder="Ingrese una descripción" required>
                              </div>
                              <div class="col-2">
                                <h3 class="card-title">Precio $</h3>
                                <input type="number" name="precio" class="form-control" placeholder="Ingrese un precio" required>
                              </div>
                            </div>
                            <br>
                            <button type="submit" id= "agregar" class="btn btn-success float-right" name="agregar_consulta">Agregar</button>
                          </div>

                        <!-- </div> -->
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </form>

                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.2
    </div>
    <strong> Lic. Tic &copy; 2020 <a href="#"> ConsProf</a>.</strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
