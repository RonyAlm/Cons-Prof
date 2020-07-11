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

  

  
  /* if( $rela_tipo == 1 ){  
    //HACEMOS UNA CONSULTA A LA TABLA TIPO_ESTUDIO PARA EXTRAERME LAS FILAS Y GUARDAMOS $sentenciatipoestudio //
    $sentenciatipoestudio=$base_de_datos->query("SELECT * FROM tipo_estudio Where rela_profesional = $id_profesional");
    //ALMACENAMOS EN UN ARRAY LA VARIABLE ESTUDIOS COMO PERSONAS.
    $estudios= $sentenciatipoestudio->fetchAll(PDO::FETCH_OBJ);
   //echo $id_profesionalUno;
                 
  //echo $rela_persona_usuario;
  //echo $relac_per;
  $sql_profesional = "SELECT * FROM profesional,profesion Where id_profesional= $id_profesional And rela_profesion= id_profesion";
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
    //echo $id_profesionalUno;
  } //echo $matricula_profesionalUno." ".$especialidad_profesionalUno." ".$profesion_profesionalUno;*/

  /*'SELECT persona.nombre_persona, persona.apellido_persona, persona.imagen_icono, persona.correo_persona, profesion.descripcion_profesion
FROM profesional, persona, profesion
WHERE profesional.rela_persona= persona.id_persona
AND profesional.rela_profesion=profesion.id_profesion'*/

  
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Consprof | Perfil Usuario</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">



  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">



  <!-- page specific plugin styles -->
  <link rel="stylesheet" href="assets/css/colorbox.min.css" />

  <!-- ace styles -->
  <link rel="stylesheet" href="assets/css/ace-part2.min.css"  />

  <link rel="stylesheet" href="css/style.css"  />






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
                <a href="favorito.php" class="nav-link">
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
    <section class="content-header" >
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bienvenido..</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a  href="#">Inicio</a></li>
              <?php 
                 if( $rela_tipo == 1 ){
              ?>
              <li class="breadcrumb-item active">Inicio del Profesional</li>
              <?php } elseif( $rela_tipo == 2 ){ ?>
              <li class="breadcrumb-item active">Inicio del Cliente</li>
              <?php } ?>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" id="user-profile-2">
      <div class="container-fluid">
        <div class="row">
            <!--<div class="col-sm-12" style="background-color: #0199AE; height: 40px; width: 100%;">
            </div>
            <div class="col-sm-12 fondoPantalla"> -->
              <!--7777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777-->
                        <!-- Default box -->
                <div class="card card-solid fondoPantalla">
                  <div class="card-body pb-0">
                    <div class="row d-flex align-items-stretch" id="response">
                    
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
              <!--7777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777-->
            <!--</div>-->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.1
    </div>
    <strong> Lic. Tic &copy; 2020 <a href="#"> ConsProf</a>.</strong> Todos los derechos reservados.
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


<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>

<!--busquedad-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="Buscador/js/main.js"></script>


<!-- page specific plugin scripts -->
<script src="assets/js/jquery.colorbox.min.js"></>
<script >
   $(document).ready(function() {
          //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
   });
</script>

<script >
     $(document).ready(function() {
        //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    });


    $('#avatar2').on('click', function(){
    var modal =
    '<div class="modal fade">\
      <div class="modal-dialog">\
      <div class="modal-content">\
      <div class="modal-header">\
        <button type="button" class="close" data-dismiss="modal">&times;</button>\
        <h4 class="blue">Editar Imagen</h4>\
      </div>\
      \
      <form class="no-margin" method="POST" action="administrar_perfil.php" enctype="multipart/form-data">\
      <div class="modal-body">\
      <input type="hidden" name="id_user" value="<?php echo $id_persona?>">\
        <div class="space-4"></div>\
        <div style="width:75%;margin-left:12%;"><input type="file" name="imagen" /></div>\
      </div>\
      \
      <div class="modal-footer center">\
        <button type="submit" class="btn btn-sm btn-success" name="actualizar_iconos"><i class="ace-icon fa fa-check"></i> Editar</button>\
        <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancelar</button>\
      </div>\
      </form>\
      </div>\
    </div>\
    </div>';


    var modal = $(modal);
    modal.modal("show").on("hidden", function(){
      modal.remove();
    });

    var working = false;

    var form = modal.find('form:eq(0)');
    var file = form.find('input[type=file]').eq(0);
    file.ace_file_input({
      style:'well',
      btn_choose:'Click to choose new avatar',
      btn_change:null,
      no_icon:'ace-icon fa fa-picture-o',
      thumbnail:'small',
      before_remove: function() {
        //don't remove/reset files while being uploaded
        return !working;
      },
      allowExt: ['jpg', 'jpeg', 'png', 'gif'],
      allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
    });

    form.on('submit', function(){
      if(!file.data('ace_input_files')) return false;

      file.ace_file_input('disable');
      form.find('button').attr('disabled', 'disabled');
      form.find('.modal-body').append("<div class='center'><i class='ace-icon fa fa-spinner fa-spin bigger-150 orange'></i></div>");

      var deferred = new $.Deferred;
      working = true;
      deferred.done(function() {
        form.find('button').removeAttr('disabled');
        form.find('input[type=file]').ace_file_input('enable');
        form.find('.modal-body > :last-child').remove();

        modal.modal("hide");

        var thumb = file.next().find('img').data('thumb');
        if(thumb) $('#avatar2').get(0).src = thumb;

        working = false;
      });


      setTimeout(function(){
        deferred.resolve();
      } , parseInt(Math.random() * 800 + 800));

      return false;
    });
     })
</script>


    <script type="text/javascript">
          jQuery(function($) {
        var $overflow = '';
        var colorbox_params = {
        rel: 'colorbox',
        reposition:true,
        scalePhotos:true,
        scrolling:false,
        previous:'<i class="ace-icon fa fa-arrow-left"></i>',
        next:'<i class="ace-icon fa fa-arrow-right"></i>',
        close:'&times;',
        current:'{current} of {total}',
        maxWidth:'100%',
        maxHeight:'100%',
        onOpen:function(){
          $overflow = document.body.style.overflow;
          document.body.style.overflow = 'hidden';
        },
        onClosed:function(){
          document.body.style.overflow = $overflow;
        },
        onComplete:function(){
          $.colorbox.resize();
        }
        };

        $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
        $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon


        $(document).one('ajaxloadstart.page', function(e) {
        $('#colorbox, #cboxOverlay').remove();
        });
        })
    </script>
</body>
</html>
