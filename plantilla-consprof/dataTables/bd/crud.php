<?php
     //codigo consulta mysqli
  session_start();
  require '../../../login/funcs/conexion.php';
  require '../../../login/funcs/funcs.php';

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
 include_once('../../conexion.php');


 

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
 
 $sentencia_cliente= $base_de_datos->query("SELECT * FROM cliente where rela_persona = $relac_per");
 $personas=$sentenciapersona->fetchAll(PDO::FETCH_OBJ);
 $prof=$sentenciaprof->fetchAll(PDO::FETCH_OBJ);
 $cliente = $sentencia_cliente->fetchAll(PDO::FETCH_OBJ);

  foreach ($cliente as $clientes) {
    $id_cliente=$clientes->id_cliente;
    $rela_persona_cliente=$clientes->rela_persona;
  }
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
  //echo $id_cliente;


  $sentenciadata= $base_de_datos->query("SELECT profesional.id_profesional, turnos.id, persona.nombre_persona, persona.apellido_persona, turnos.start , turnos.end,
   tipo_consulta.descripcio_tipo_consulta, consulta.descripcion_consulta, consulta.precio_consulta 
  FROM turnos,profesional, persona,consulta,cliente, tipo_consulta 
  WHERE turnos.rela_cliente_turno= $id_cliente
  AND cliente.id_cliente = $id_cliente
  AND profesional.id_profesional=turnos.rela_profesional_turno 
  AND consulta.id_consulta=turnos.rela_consulta_turno 
  AND id_tipo_consulta=rela_tipo_consulta
  AND persona.id_persona = profesional.rela_persona");

  $turnos= $sentenciadata->fetchAll(PDO::FETCH_ASSOC);
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$username = (isset($_POST['username'])) ? $_POST['username'] : '';
$first_name = (isset($_POST['first_name'])) ? $_POST['first_name'] : '';
$last_name = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
$gender = (isset($_POST['gender'])) ? $_POST['gender'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$status = (isset($_POST['status'])) ? $_POST['status'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$user_id = (isset($_POST['id_profesional'])) ? $_POST['id_profesional'] : '';


switch($opcion){
    case 1:
        $consulta = "INSERT INTO usuarios (username, first_name, last_name, gender, password, status) VALUES('$username', '$first_name', '$last_name', '$gender', '$password', '$status') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        
        $consulta = "SELECT * FROM usuarios ORDER BY user_id DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);       
        break;    
    case 2:        
        $consulta = "UPDATE usuarios SET username='$username', first_name='$first_name', last_name='$last_name', gender='$gender', password='$password', status='$status' WHERE user_id='$user_id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM usuarios WHERE user_id='$user_id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:        
        $consulta = "DELETE FROM usuarios WHERE user_id='$user_id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
    case 4:    
        //$consulta = "SELECT * FROM usuarios";
        $consulta = "SELECT profesional.id_profesional, persona.nombre_persona, turnos.start ,
        tipo_consulta.descripcio_tipo_consulta, consulta.descripcion_consulta, consulta.precio_consulta 
       FROM turnos,profesional, persona,consulta,cliente, tipo_consulta 
       WHERE turnos.rela_cliente_turno= $id_cliente
       AND cliente.id_cliente = $id_cliente
       AND profesional.id_profesional=turnos.rela_profesional_turno 
       AND consulta.id_consulta=turnos.rela_consulta_turno 
       AND id_tipo_consulta=rela_tipo_consulta
       AND persona.id_persona = profesional.rela_persona";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($data);
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;