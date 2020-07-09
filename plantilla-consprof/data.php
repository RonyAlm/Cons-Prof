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

 //HACEMOS UNA CONSULTA A LA TABLA USERS PARA EXTRAERME LAS FILAS Y GUARDAMOS $sentenciauser//
 $sentenciauser= $base_de_datos->query("SELECT * FROM usuario,persona WHERE id_usuario = $idUsuario and rela_persona =  $relac_per");
  

 //print_r($sentenciauser);
 $sentenciapersona= $base_de_datos->query("SELECT * FROM persona where id_persona = $relac_per");
 $sentenciaprof= $base_de_datos->query("SELECT * FROM profesional where rela_persona = $relac_per");
 $sentencia_cliente= $base_de_datos->query("SELECT * FROM cliente");

 
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
   //echo $matricula_profesionalUno." ".$especialidad_profesionalUno." ".$profesion_profesionalUno;
    

    $sql_profesion = "SELECT * FROM profesion";
    $query_profesion = $base_de_datos->prepare($sql_profesion);
    $query_profesion->execute();
    $result_profesion = $query_profesion->fetchAll(PDO::FETCH_ASSOC);
    
   
 $usuario=$sentenciauser->fetchAll(PDO::FETCH_OBJ); // fetchAll devuelve toda la fila de la base de datos
 $personas=$sentenciapersona->fetchAll(PDO::FETCH_OBJ);
 $prof=$sentenciaprof->fetchAll(PDO::FETCH_OBJ);
 $cliente = $sentencia_cliente->fetchAll(PDO::FETCH_OBJ);

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
 //echo $id_persona;

 foreach($prof as $profe){
   $id_profesional=$profe->id_profesional;
   $matricula=$profe->matricula;
   $imagen_titulo= $profe->imagen_titulo;
   $imagen_matricula= $profe->imagen_matricula;
   $especialidad= $profe->especialidad;
 }

 if( $rela_tipo == 1 ){
   //HACEMOS UNA CONSULTA A LA TABLA TIPO_ESTUDIO PARA EXTRAERME LAS FILAS Y GUARDAMOS $sentenciatipoestudio //
   $sentenciatipoestudio=$base_de_datos->query("SELECT * FROM tipo_estudio Where rela_profesional = $id_profesional");
   //ALMACENAMOS EN UN ARRAY LA VARIABLE ESTUDIOS COMO PERSONAS.
   $estudios= $sentenciatipoestudio->fetchAll(PDO::FETCH_OBJ);
 }

 //echo $rela_persona_usuario;
 //echo $relac_per;

 //Para traer el turno de ese cliente
 /*'SELECT turnos.id, persona.nombre_persona, turnos.start , turnos.end, consulta.descripcion_consulta 
  FROM turnos,profesional, persona,consulta,cliente, tipo_consulta 
  WHERE turnos.rela_profesional_turno= 9 
  AND profesional.id_profesional = 9 
  AND cliente.id_cliente=turnos.rela_cliente_turno 
  AND consulta.id_consulta=turnos.rela_consulta_turno 
  AND id_tipo_consulta=rela_tipo_consulta 
  AND turnos.rela_cliente_turno = cliente.id_cliente 
  AND persona.id_persona = cliente.rela_persona '; */
 echo $id_profesional;
 $sentenciadata= $base_de_datos->query("SELECT turnos.id, persona.nombre_persona, turnos.start , turnos.end, consulta.descripcion_consulta, tipo_consulta.descripcio_tipo_consulta, consulta.precio_consulta 
                                        FROM turnos,profesional, persona,consulta,cliente, tipo_consulta 
                                        WHERE turnos.rela_profesional_turno= $id_profesional 
                                        AND profesional.id_profesional = $id_profesional 
                                        AND cliente.id_cliente=turnos.rela_cliente_turno 
                                        AND consulta.id_consulta=turnos.rela_consulta_turno 
                                        AND id_tipo_consulta=rela_tipo_consulta 
                                        AND turnos.rela_cliente_turno = cliente.id_cliente 
                                        AND persona.id_persona = cliente.rela_persona ");


  $turnos= $sentenciadata->fetchAll(PDO::FETCH_ASSOC);

  //print_r($turnos);


 ?>





<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Consultas Pendientes</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">



</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
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

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php 
                 if( $rela_tipo == 1 ){
                  
            ?>

            <li class="nav-item">
              <a href="starter.php" class="nav-link">
                <i class=" fas fa-tachometer-alt"> </i>
                <p>
                  Administrar Consultas
                </p>
              </a>
            </li>
            <?php } ?>

            <!--<li class="nav-item">
              <a href="perfil.php" class="nav-link active">
                <i class="nav-icon fas fa-th"> </i>
                <p>
                  Perfil
                </p>
              </a>
            </li>-->

            <li class="nav-header">SERVICIO DISPONIBLE</li>

            <li class="nav-item has-treeview">
                <a href="calendar.php" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Agendar turno
                  </p>
                </a>
            </li>

            </li>

            <li class="nav-item">
              <a href="cliente.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Cliente

                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="modals.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Atender

                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="data.php" class="nav-link active">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Consultas Pendientes
                </p>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="data_cliente.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Consultas Cliente
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabla de Consultas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Casa</a></li>
              <li class="breadcrumb-item active">Tabla de Datos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">


            <div class="card">

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Cliente</th>
                    <th>Consulta</th>
                    <th>Nombre de Consulta</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php foreach ($turnos as $key): ?>


                  <tr>

                    <td><?php echo $key['nombre_persona']; ?></td>
                    <td><?php echo $key['descripcio_tipo_consulta']; ?></td>
                    <td><?php echo $key['descripcion_consulta']; ?></td>
                    <td><?php echo $key['precio_consulta']; ?></td>
                    <td><?php echo $key['start']; ?></td>
                    <td>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                        Iniciar
                      </button>
                    </td>

                  </tr>
                  <?php endforeach; ?>


                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Cliente</th>
                    <th>Consulta</th>
                    <th>Nombre de Consulta</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Crear Sala de Videollamada</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="administrar_perfil.php"  method="POST">
                <input type="hidden" name="id_tuno" value="">
                <input type="hidden" name="id_cliente" value="1">
                <input type="hidden" name="id_profesional" value="3" required>
                <div class="form-group row">
                  <label for="inputName" class="col-sm-3 col-form-label">Nombre de la Sala</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombre_salas" placeholder="Ingrese un nombre" required>
                  </div>
                </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" name="nombre_sala" >Crear</button>
            </div>
          </form>
        </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


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
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });



    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });

    $('.toastsDefaultDefault').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultTopLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'topLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomRight').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomRight',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultAutohide').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        autohide: true,
        delay: 750,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultNotFixed').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        fixed: false,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultFull').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        icon: 'fas fa-envelope fa-lg',
      })
    });
    $('.toastsDefaultFullImage').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        image: 'dist/img/user3-128x128.jpg',
        imageAlt: 'User Picture',
      })
    });
    $('.toastsDefaultSuccess').click(function() {
      $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultInfo').click(function() {
      $(document).Toasts('create', {
        class: 'bg-info',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultWarning').click(function() {
      $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultDanger').click(function() {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultMaroon').click(function() {
      $(document).Toasts('create', {
        class: 'bg-maroon',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
  });

</script>
</body>
</html>
