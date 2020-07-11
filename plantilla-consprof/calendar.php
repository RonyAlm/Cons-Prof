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
  //HACEMOS UNA CONSULTA A LA TABLA TIPO_ESTUDIO PARA EXTRAERME LAS FILAS Y GUARDAMOS $sentenciatipoestudio //
  $sentenciatipoestudio=$base_de_datos->query("SELECT * FROM tipo_estudio");
  $sentenciapersona= $base_de_datos->query("SELECT * FROM persona where id_persona = $relac_per");
  $sentenciaprof= $base_de_datos->query("SELECT * FROM profesional");
  
  $sentenciatipoconsulta= $base_de_datos->query("SELECT * FROM tipo_consulta ");
  $sentenciaconsulta= $base_de_datos->query("SELECT id_consulta, precio_consulta, descripcion_consulta, descripcio_tipo_consulta FROM consulta ,tipo_consulta, profesional WHERE rela_profesional= id_profesional and rela_tipo_consulta=id_tipo_consulta ");
  
     

     $sql_profesion = "SELECT * FROM profesion";
     $query_profesion = $base_de_datos->prepare($sql_profesion);
     $query_profesion->execute();
     $result_profesion = $query_profesion->fetchAll(PDO::FETCH_ASSOC);

     $sql_cliente = "SELECT id_cliente FROM cliente,usuario,persona WHERE cliente.rela_persona = id_persona AND usuario.rela_persona= id_persona AND id_usuario = $idUsuario ";
     $query_cliente = $base_de_datos->prepare($sql_cliente);
     $query_cliente->execute();
     $result_cliente = $query_cliente->fetchAll(PDO::FETCH_ASSOC);

     foreach ($result_cliente as $cli) {
      $id_cliente=$cli['id_cliente'];
    }
    //echo $id_cliente;
     $sql = "SELECT * FROM turnos Where rela_cliente_turno = $id_cliente ";
     $query = $base_de_datos->prepare($sql);
     $query->execute();
     $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

  //ALMACENAMOS EN UN ARRAY LA VARIABLE ESTUDIOS COMO PERSONAS.
  $estudios= $sentenciatipoestudio->fetchAll(PDO::FETCH_OBJ);
  $usuario=$sentenciauser->fetchAll(PDO::FETCH_OBJ); // fetchAll devuelve toda la fila de la base de datos
  $personas=$sentenciapersona->fetchAll(PDO::FETCH_OBJ);
  $prof=$sentenciaprof->fetchAll(PDO::FETCH_OBJ);
  //$cliente = $sentencia_cliente->fetchAll(PDO::FETCH_OBJ);
  $consultas=$sentenciaconsulta->fetchAll(PDO::FETCH_OBJ);
  $ptipo_consultas=$sentenciatipoconsulta->fetchAll(PDO::FETCH_OBJ);

  
  
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
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> ConsProf | Agendar turnos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link href='fullCalendar/css/fullcalendar.css' rel='stylesheet'>
  <!--<link rel="stylesheet" href="plugins/fullcalendar/main.min.css">
  <link rel="stylesheet" href="plugins/fullcalendar-daygrid/main.min.css">
  <link rel="stylesheet" href="plugins/fullcalendar-timegrid/main.min.css">
  <link rel="stylesheet" href="plugins/fullcalendar-bootstrap/main.min.css">-->
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!--bootstrap-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
   <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
        
        <!--Codigo Rony-->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo 'Bienvenido '.utf8_decode($nombre_persona).'              '; ?><i class="fas fa-user fa-fw"></i></a>
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
              <a href="starter.php" class="nav-link">
                <i class=" fas fa-tachometer-alt"> </i>
                <p>
                  Administrar Consultas
                </p>
              </a>
            </li>
            <?php  }  ?>

          

              <li class="nav-header">SERVICIO DISPONIBLE</li>

              <li class="nav-item has-treeview">
                <a href="calendar.php" class="nav-link active">
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
            <h1>Agendar turno</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Agendar turno</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

           <!--77777777777777777777777777777777777777777 Comienza el step 7777777777777777777777777777777777777777777777777-->
        
           <!--77777777777777777777777777777777777777777 Termina el step 7777777777777777777777777777777777777777777777777-->

          <div class="col-md-3">
            <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Horarios Ocupados</h4>
                </div>
                <div class="card-body">
                  <!-- the events -->
                  <div id="external-events">
                  <?php 
                  foreach($resultado as $fila){
                  ?>
                    <div class="external-event" style="background: <?php echo $fila['color'] ?>; height: auto; ">Fecha desde: <?php echo $fila['start'] ?></br> Hasta: <?php echo $fila['start'] ?></div>
                  <?php } ?>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Create Event</h3>
                </div>
                <div class="card-body">
                  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                    </ul>
                  </div>
                  <!-- /btn-group -->
                  
                  <div class="input-group">
                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                    <div class="input-group-append">
                      <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                    </div>
                    <!-- /btn-group -->
                  </div>
                  <!-- /input-group -->
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
          
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendario"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <!-- Modal -->
  <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agendar turno</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="fullCalendar/registrar.php" method="post">
          
                <input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $id_cliente?>">
                <div class="form-group">
                  <label>Profesion: </label>
                  <select  id="select_profesion" class="form-control select2bs4" style="width: 100%;">
                  <?php 
                    foreach($result_profesion as $fila){
                  ?>
                    <option value="<?php echo $fila['id_profesion']; ?>"><?php echo $fila['descripcion_profesion']; ?></option>
                    
                  <?php } ?>
                  </select>
                 
                </div>
                <div class="form-group" id="select_profesional">
                   
                </div>
                <div class="form-group" id="select_consulta">
                   
                </div>
                
            
                <div class="form-group">
                  <label for="">Fecha:</label>
                  <input type="text" id="fecha" name="fecha" style="width: 100%; text-align: center; border: 1px solid #ccc; border-radius: 5px;"
                  required>
                </div>
                <div class="form-group">
                  <label for="">Titulo:</label><label for="" style="margin-left: 76%;">Color:</label></br>
                  <input type="text" id="evento" name="evento" style="width: 85%;"  required>
                  <input type="color" id="color" name="color" style="height: 26px;" required>
                </div>
                <div class="form-group">
                  <label for="">Hora inicial:</label>
                  <input type="time" id="hora_inicial" name="hora_inicial" style="width: 26%; text-align: center;"required>
                  
                  <label for="" style="margin-left: 38px;">Hora final:</label>
                  <input type="time" id="hora_final" name="hora_final" style="width: 26%; text-align: center;" required>
                </div>

            
            
            

            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Evento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="fullCalendar/actualizar.php" method="post">
            <label for="">Fecha:</label>
            <input type="text" id="fecha_edit" name="fecha_edit">
            </br>
            <input type="text" id="id_edit" name="id_edit" style="display: none;">
            

            <label for="">Evento:</label>
            <input type="text" id="evento_edit" name="evento_edit">
            </br>

            <label for="">Hora inicial:</label>
            <input type="time" id="hora_inicial_edit" name="hora_inicial_edit">
            </br>
            
            <label for="">Hora final:</label>
            <input type="time" id="hora_final_edit" name="hora_final_edit">
            </br>

            <label for="">Color:</label>
            <input type="color" id="color_edit" name="color_edit">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--Fin del Modal-->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.2
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
<script src="fullCalendar/js/jquery.js"></script>
<!-- <script src="plugins/jquery/jquery.min.js"></script> -->

<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- fullCalendar 2.2.5 -->

<!-- Bootstrap, JS, Popper.js, and jQuery -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<!-- FullCalendar -->
<script src='fullCalendar/js/moment.min.js'></script>
<script src='fullCalendar/js/fullcalendar/fullcalendar.min.js'></script>
<script src='fullCalendar/js/fullcalendar/fullcalendar.js'></script>
<script src='fullCalendar/js/fullcalendar/locale/es.js'></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>


<script type="text/javascript">
	$(document).ready(function(){
		//$('#select_consulta').val(9);
  
  
    

    recargarLista();
    //recargarListaConsult();
  
    

		$('#select_profesion').change(function(){
			recargarLista();
    });
    
    /*$('#select_profesional').change(function(){
			recargarListaConsult();
		});*/
    
	})
</script>


<script type="text/javascript">
  function recargarLista(){
		$.ajax({
			type:"POST",
			url:"datos.php",
      data:"profesion=" + $('#select_profesion').val(),
			success:function(r){
        $('#select_profesional').html(r);
			}
		});
  }
</script>

<script type="text/javascript">
	
  
</script>

<script>
    $(document).ready(function() {

    
    $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })

    $('#calendario').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,listWeek,listDay'
          },
          views: {
            listDay: { buttonText: 'Hoy' },
            listWeek: { buttonText: 'Semanas' }
          },
          editable: true,
          eventLimit: true, // allow "more" link when too many events
          selectable: true,
          selectHelper: true,
          navLinks: true, // can click day/week names to navigate views
          
          
         events:[
              <?php 
                  foreach($resultado as $fila){

                  
                ?>
                 {
                    id: '<?php echo $fila['id'] ?>',
                    title:"<?php echo $fila['title'] ?>",
                    start:'<?php echo $fila['start'] ?>',
                    end: '<?php echo $fila['end'] ?>',
                    color: '<?php echo $fila['color'] ?>',
                    editable: true
                    
                    
                  
                 },
               <?php } ?>  
               {
                  start: '2020-07-18',
                  end: '2020-07-19',
                  constraint: 'availableForMeeting', // defined below
                  overlap: false, //dias bloquedaodo
                  rendering: 'background',
                  color: '#ccc'
                }, 
          /* 
             title:'Primer Evento',
             start:'2020-06-26 08:00:00',
             end: '2020-06-28 24:00:00',
             //className: 'nombre de la clase de estilos css'
             editable: true //para que el evento se pueda mover
           */
         ],
         dayClick: function(fecha){
              $("#modal_cargar").modal("show");
              //alert(fecha.format());
              $("#fecha").val(fecha.format());
              
         },
         
         eventDrop: function(event, delta, revertFunc) {
          
         
          
          // alert(" id: "+event.id + " - Evento: "+event.title + "- Fecha inicio: " + event.start.format() + "- Fecha fin: " + event.end.format());
          
              
              //alert(fecha.format());
              if (!confirm("Seguro que quieres editar?")) {
                revertFunc();
              }else{
                $("#modal_editar").modal("show");
                $("#id_edit").val(event.id);
                $("#fecha_edit").val(event.start.format('YYYY-MM-DD'));
                $("#hora_inicial_edit").val(event.start.format('HH:mm'));
                $("#hora_final_edit").val(event.end.format('HH:mm'));
                $("#evento_edit").val(event.title);
                $("#color_edit").val(event.color);
              }

             
          
          

          },

          eventResize: function(event, delta, revertFunc) {

            alert(event.title + " end is now " + event.end.format());

            if (!confirm("is this okay?")) {
              revertFunc();
            }

          },

          eventRender: function(event, element) {
            element.bind('dblclick', function() {
              //Para eliminar
              $('#ModalEdit #id').val(event.id);
              $('#ModalEdit #title').val(event.title);
              $('#ModalEdit #color').val(event.color);
              $('#modal_cargar').modal('show');
            });
          }

        


          

            

           




    })

});

</script>


<!-- Page specific script -->

</body>
</html>
