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


  
 
  //Consulta General;
  //HACEMOS UNA CONSULTA A LA TABLA USERS PARA EXTRAERME LAS FILAS Y GUARDAMOS $sentenciauser//
  $sentenciauser= $base_de_datos->query("SELECT * FROM usuario,persona WHERE id_usuario = $idUsuario 
                                         AND rela_persona =  $relac_per");
  $usuario=$sentenciauser->fetchAll(PDO::FETCH_OBJ); // fetchAll devuelve toda la fila de la base de datos
  foreach ($usuario as $cosas) {
    $id_user=$cosas->id_usuario;
    $nombre_usuario=$cosas->nombre_usuario;
    $rela_tipo=$cosas->rela_tipo;
    $rela_persona_usuario = $cosas->rela_persona;
  }

  
  $sentenciapersona= $base_de_datos->query("SELECT * FROM persona where id_persona = $relac_per");
  $sentenciaprof= $base_de_datos->query("SELECT * FROM profesional where rela_persona = $relac_per");
  if($rela_tipo == 1){
    $sentencia_cliente= $base_de_datos->query("SELECT * FROM cliente");
  } elseif ($rela_tipo == 2){
    $sentencia_cliente= $base_de_datos->query("SELECT * FROM cliente where rela_persona = $relac_per");
  }
  

    
     /*$sql_profesional = "SELECT * FROM profesional Where rela_persona= $relac_per";
     $query_profesional = $base_de_datos->prepare($sql_profesional);
     $query_profesional->execute();
     $result_profesional = $query_profesional->fetchAll(PDO::FETCH_ASSOC);

     foreach( $result_profesional as $unprofesional){
       $id_profesionalUno = $unprofesional['id_profesional'];
       $matricula_profesionalUno = $unprofesional['matricula'];
       $especialidad_profesionalUno = $unprofesional['especialidad'];
       //$profesion_profesionalUno = $unprofesional['descripcion_profesion'];
       $imagen_tituloUno= $unprofesional['imagen_titulo'];
       $imagen_matriculaUno= $unprofesional['imagen_matricula'];
     }*/
     //echo $id_profesionalUno;
    //echo $matricula_profesionalUno." ".$especialidad_profesionalUno." ".$profesion_profesionalUno;
     

     $sql_profesion = "SELECT * FROM profesion";
     $query_profesion = $base_de_datos->prepare($sql_profesion);
     $query_profesion->execute();
     $result_profesion = $query_profesion->fetchAll(PDO::FETCH_ASSOC);
     
    
  
  $personas=$sentenciapersona->fetchAll(PDO::FETCH_OBJ);
  $prof=$sentenciaprof->fetchAll(PDO::FETCH_OBJ);
  $cliente = $sentencia_cliente->fetchAll(PDO::FETCH_OBJ);

  foreach ($cliente as $clientes) {
    $id_cliente=$clientes->id_cliente;
    $rela_persona_cliente=$clientes->rela_persona;
  }

  //print_r($personas);
  //RECORREMOS EL ARRAY PERSONAS PARA ASIGNARLE CADA ELEMENTO DELA TABLA A UNA VARIABLE
  

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
  //echo $id_persona;

  foreach($prof as $profe){
    $id_profesional=$profe->id_profesional;
    $matricula=$profe->matricula;
    $imagen_titulo= $profe->imagen_titulo;
    $imagen_matricula= $profe->imagen_matricula;
    $especialidad= $profe->especialidad;
  }


    $sentenciauser= $base_de_datos->query("SELECT * FROM `favorito`, `profesional`, `cliente`
                                            WHERE`rela_cliente_favorito` = $id_cliente
                                            and `rela_profesional_favorito`= `id_profesional`");

    $personas=$sentenciauser->fetchAll(PDO::FETCH_OBJ);

    

 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cons-Prof | Favorito</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="starter.php" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contacto</a>
        </li>
      </ul>

      <!-- FORMULARIO DE BUSCAR -->
      <form class="form-inline ml-3" id="form-busqueda">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" name="busqueda" id="search" placeholder="Buscar.." aria-label="Buscar">
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
                    <?php echo $nombre_persona; ?>
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
                    <?php echo 'Bienvenido '.$nombre_persona.'              '; ?><i class="fas fa-user fa-fw"></i></a>
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
      <a href="perfil.php" class="brand-link">
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
            <a href="perfil.php" class="d-block"><?php  echo $nombre_persona." ".$apellido_persona; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu fa-video es para icono de la camara-->
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
              <a href="starter.php" class="nav-link">
                <i class="nav-icon fas fa-wrench"> </i>
                <p>
                  Administrar Consultas
                </p>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="data.php" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <p>
                  Consultas Pendientes
                </p>
              </a>
            </li>

            <?php } ?>

            <?php 
                 if( $rela_tipo == 2 ){
                  
            ?>
            <li class="nav-header">SERVICIO DISPONIBLE</li>

            <li class="nav-item has-treeview">
                <a href="calendar.php" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Agendar turno
                  </p>
                </a>
            </li>

            <li class="nav-item">
              <a href="data_cliente.php" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <p>
                  Consultas Pendientes
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="favorito.php" class="nav-link active">
                  <i class="nav-icon far fa-star"></i>
                  <p>
                    Favorito
                  </p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="favorito.php" class="nav-link">
                  <i class="nav-icon fas fa-box"></i>
                  <p>
                    Consultas rapidas
                  </p>
                </a>
            </li>
            
            <?php } ?>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contacts</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Contacts</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">
            <?php foreach ($personas as $key) {?>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                  <?php echo " $key->especialidad "?>
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?php echo " $key->name" ?></b></h2>
                      <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dirección: <?php echo " $key->direccion"?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Matricula: <?php echo "$key->matricula" ?></li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="data:image/jpg; base64, <?php echo base64_encode ($key->imagen_icono); ?> " alt="" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">

                    <a  class="btn btn-sm btn-warning">
                      <i  class="fas fa-user" class="submit"></i> Favorito
                    </a>
                  </div>
                </div>
              </div>
            </div>
              <?php   }?>

          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item"><a class="page-link" href="#">6</a></li>
              <li class="page-item"><a class="page-link" href="#">7</a></li>
              <li class="page-item"><a class="page-link" href="#">8</a></li>
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
