<?php
   //codigo consulta mysqli
   session_start();
   require '../../login/funcs/conexion.php';
   require '../../login/funcs/funcs.php';

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
  include_once('../conexion.php');


  
 
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

 ?>

<?php 
    include_once('../conexion.php');

     if(!empty($_POST['busqueda'])){
        $busqueda = explode(" ",$_POST['busqueda']);
        //$sql = "SELECT * FROM productos WHERE name LIKE '%".$busqueda."%'";
        $sql_profesionales = "SELECT *
          FROM profesional, persona, profesion
          WHERE nombre_persona LIKE '%".$busqueda[0]."%'
          or descripcion_profesion LIKE '%".$busqueda[0]."%'
          AND profesional.rela_persona= persona.id_persona
          AND profesional.rela_profesion=profesion.id_profesion LIMIT 3
          ";
          $query_profesionales = $base_de_datos->prepare($sql_profesionales);
          $query_profesionales->execute();
          $result_profesionales = $query_profesionales->fetchAll(PDO::FETCH_ASSOC);
          //var_dump($result_profesionales);
        //$result = mysqli_query($mysqli,$sql);
            for ($i=1; $i < count($busqueda); $i++) { 
                if(!empty($busqueda[$i])){
                    $sql .= "AND nombre_persona LIKE '%".$busqueda[$i]."%'";
                } 
            }

       foreach($result_profesionales as $profesionales){
?>

  <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
    <div class="card bg-light">
        <form action="administrar_perfil.php" method="post">
            <input type="hidden" name="id_profesional" value="<?php echo $profesionales['id_profesional']; ?>" >
            <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>" >
      <div class="card-header text-muted border-bottom-0">
      <?php 
        echo $profesionales['descripcion_profesion'];
      ?>
      </div>
      <div class="card-body pt-0">
        <div class="row"> 
          <div class="col-7">
            <h2 class="lead"><b><?php echo $profesionales['nombre_persona']." ".$profesionales['apellido_persona']; ?></b></h2>
            <p class="text-muted text-sm"><b>Especialidades: </b> <?php echo $profesionales['especialidad']; ?> </p>
            <ul class="ml-4 mb-0 fa-ul text-muted">
              <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Correo: <?php echo  $profesionales['correo_persona']; ?></li>
              <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
            </ul>
          </div>
          <div class="col-5 text-center">
           <img src="data:image/jpg; base64, <?php echo base64_encode ($profesionales['imagen_icono']); ?>" alt="" class="img-circle img-fluid">
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="text-right">
          <a href="#" class="btn btn-sm bg-teal">
            <i class="fas fa-comments"></i>
          </a>
          <a class="btn btn-sm btn-warning">
            <button type="submit" name="añadir_favorito" style="padding: 8px; border: none; text-decoration: none; background-color: transparent;" class="fas fa-star btn-warning"></button> Favorito
          </a>
        </div>
      </div>
      </form>
    </div>
  </div>
  <?php 
      }
    }
      ?>
