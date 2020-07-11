<?php

  include('conexion.php');

  // actualizamos los datos que se encuentra en el FORMULARIO del perfil

if (isset($_POST["actualizar_datos"])) {
  
     $tipo_usuario=$_POST["rela_tipo"];
     $id_profesion=$_POST["profesion"];
     $id_profesional=$_POST["id_profesional"];
     $id_persona=$_POST["id_user"];
     $nombre_user=$_POST["nombre"];
     $apellido_user=$_POST["apellido"];
     $email_user=$_POST["email"];
     $especialidad=$_POST["especialidad"];
     $dni=$_POST["dni"];
     $cuil_user=$_POST["cuil"];
     $matricula_user=$_POST["matricula"];
     $direccion_user=$_POST["direccion"];
     

    echo $id_profesion;
    echo $id_profesional;

  $sentencia= $base_de_datos->query("UPDATE `persona` SET `nombre_persona`='$nombre_user',
                                            `apellido_persona`='$apellido_user',
                                            `correo_persona`='$email_user',
                                            `direccion`='$direccion_user',
                                            `dni_persona`='$dni',
                                            `cuil_persona`='$cuil_user' where `id_persona` = '$id_persona'");
  if($tipo_usuario == 1){
    $sentencia2= $base_de_datos->query("UPDATE `profesional` SET  `matricula`='$matricula_user',`especialidad`='$especialidad',`rela_profesion`= $id_profesion WHERE `rela_persona` =  $id_persona AND id_profesional = $id_profesional");
  }
  
  
  //$sentencia2= $base_de_datos->query("UPDATE `cliente` SET  `matricula`='$matricula_user',`especialidad`='$especialidad',`rela_profesion`= $id_profesion WHERE `rela_persona` =  $id_persona AND id_profesional = $id_profesional");
   //var_dump($sentencia2);
 

    if ($sentencia) {
      
      echo "datos actualizados";
      header('location:perfil.php');
      //print_r ($sentencia);
    }else {
      // header('location:perfil.php');
      echo "datos no actualizados";
    }

   }


   // se AGREGA los estudios del profesional

   if (isset($_POST['agregar_estudios'])) {

     $id_profesional=$_POST['id_user'];

     $tipos_estudioss= $_POST['estudios'];

     $nombre_institucion= $_POST['nombre_institucion'];

     $fecha_des_has= $_POST['fecha_des_has'];



     $sql= "INSERT INTO tipo_estudio (descrip_tipo_estudio, nombre_institucion, fecha_des_has, rela_profesional)
            VALUES(:descrip_tipo_estudio, :nombre_institucion, :fecha_des_has, :rela_profesional)";

      $resultado= $base_de_datos->prepare($sql);

      $resultado->execute(array(':descrip_tipo_estudio'=>$tipos_estudioss, ':nombre_institucion'=>$nombre_institucion,
                                ':fecha_des_has'=>$fecha_des_has, ':rela_profesional'=>$id_profesional));

      if ($resultado) {
        echo "<script> alert('DATOS ACTUALIZADOS'); </script>";

         //print_r($resultado);
        header('Location:perfil.php');
      }else {
        echo "<script> alert('DATOS NO ACTUALIZADOS'); </script>";
      }

      $resultado->closeCursor();

   }

   // se agrega las imagenes de los estudios universitarios y matricula

   if (isset($_POST['agregar_imagenes'])) {

     $id_user=$_POST['id_user'];

     $nombre_imagen1=$_FILES['imagen_titulo']['name'];
     $nombre_imagen2=$_FILES['imagen_matricula']['name'];

     $tipo_imagen1=$_FILES['imagen_titulo']['type'];
     $tipo_imagen2=$_FILES['imagen_matricula']['type'];

     $tamano_imagen1=$_FILES['imagen_titulo']['size'];
     $tamano_imagen2=$_FILES['imagen_matricula']['size'];


     if ($tamano_imagen1<=2000000 && $tamano_imagen2<=3000000 ) {
       if ($tipo_imagen1=='image/jpeg' && $tipo_imagen2=='image/jpeg' || $tipo_imagen1=='image/jpg' && $tipo_imagen2=='image/jpg' ||
            $tipo_imagen1=='image/png' && $tipo_imagen2=='image/png' || $tipo_imagen1=='image/gif' && $tipo_imagen2=='image/gif') {


       //RUTA DE LA CARPETA DESTINO EN EL SERVIDOR DONDE VAMOS A GUARDAR LAS IMAGENES
       
       $carpeta_destino= $_SERVER['DOCUMENT_ROOT'] . '/Programacion_Web/ConsProf/plantilla-consprof/imagenes_servidor/';


       // MOVEMOS LA IMAGEN DEL DIRECTORIO TEMPORAR AL DIRECTORIO ESCOGIDO
       move_uploaded_file($_FILES['imagen_titulo']['tmp_name'],$carpeta_destino.$nombre_imagen1);

       move_uploaded_file($_FILES['imagen_matricula']['tmp_name'],$carpeta_destino.$nombre_imagen2);

     }else {
       echo "Solo se pueden subir imagenes jpg/jpeg/png/gif";
     }

     }else {
       echo "El tamaño de la imagen es demasiado grande";
     }

     $sql= "UPDATE `profesional` SET `imagen_titulo`='$nombre_imagen1',
                              `imagen_matricula`= '$nombre_imagen2'
            WHERE id_profesional= '$id_user'";

     $resultado= $base_de_datos->query($sql);

     if ($resultado) {

       echo "datos actualizados";
       header('location:perfil.php');
     }else {
       // header('location:perfil.php');
       echo "datos no actualizados";
     }

    }

  // se Actuliza el icono del perfil

  if (isset($_POST["actualizar_iconos"])) {
//se guarda el archivo en una carpeta temporal

  $id_user=$_POST['id_user'];

  $tipo_imagen1=$_FILES['imagen']['type'];

  if ($tipo_imagen1=='image/jpeg' || $tipo_imagen1=='image/jpg' ||
       $tipo_imagen1=='image/png' || $tipo_imagen1=='image/gif') {

  $imagen= addslashes(file_get_contents($_FILES['imagen']['tmp_name']));


  echo $tipo_imagen1;
  echo "<br>";



  $sentencia_imagen= $base_de_datos->query("UPDATE `persona` SET `imagen_icono`='$imagen'

                                     WHERE `id_persona`=$id_user");

  if ($sentencia_imagen) {
    echo "se agrego la imagen";
    header('location:perfil.php');
  }else {
    echo "no se agrego";
  }

}else {
   echo "Solo se pueden subir imagenes jpg/jpeg/png/gif";
}

}

// crear sala

if (isset($_POST['nombre_sala'])) {

  $nombre_sala=$_POST["nombre_salas"];
  $id_cliente=$_POST["id_cliente"];
  $id_profesional=$_POST["id_profesional"];



  $sentencia_sala= "INSERT INTO `sala`(`nombre_sala`, `rela_cliente_sala`, `rela_profesional_sala`)
         VALUES(:nombre_sala, :rela_cliente_sala, :rela_profesional_sala)";

   $resultado= $base_de_datos->prepare($sentencia_sala);

   $resultado->execute(array(':nombre_sala'=>$nombre_sala,
                             ':rela_cliente_sala'=>$id_cliente, ':rela_profesional_sala'=>$id_profesional));

   if ($resultado) {
     echo "<script> alert('DATOS ACTUALIZADOS');</script>";

     // print_r($resultado);
     header('Location: proyecto_conprof/public_html/index.php');
   }else {
     echo "<script> alert('DATOS NO ACTUALIZADOS'); </script>";
   }

   $resultado->closeCursor();

// Ingresar sala del cliente
}

if (isset($_POST['ingresar_sala'])) {

  $entrar_sala=$_POST["entrar_sala"];
  $id_cliente=$_POST["id_cliente"];
  $id_profesional=$_POST["id_profesional"];


  $sentencia_sala=$base_de_datos->query("SELECT `id_sala`, `nombre_sala`, `rela_cliente_sala`, `rela_profesional_sala`
                                         FROM `sala`
                                         WHERE `rela_cliente_sala`=$id_cliente AND `rela_profesional_sala`= $id_profesional");

  $sala=$sentencia_sala->fetchAll(PDO::FETCH_OBJ);

  foreach ($sala as $key) {

    $id_sala=$key->id_sala;
    $rela_cliente=$key->rela_cliente;
    $nombre_sala=$key->nombre_sala;
    $rela_profesional=$key->rela_profesional;
  }
  
   if ($nombre_sala == $entrar_sala) {
     echo "<script> alert('DATOS ACTUALIZADOS'); </script>";
       echo $id_sala;
       echo $rela_cliente;
     header("Location: https://meet.jit.si/$entrar_sala");
   }else {
     echo "<script> alert('DATOS NO ACTUALIZADOS'); </script>";
   }

}

if (isset($_POST['añadir_favorito'])) {


  $id_cliente=$_POST["id_cliente"];
  $id_profesional=$_POST["id_users"];


  $sentencia_favorito=$base_de_datos->query("INSERT INTO `favorito`(`rela_cliente_favorito`, `rela_profesional_favorito`)
                                          VALUES ($id_cliente,$id_profesional)");

  $favorito=$sentencia_favorito->fetchAll(PDO::FETCH_OBJ);

  if ($favorito) {
    echo "<script> alert('DATOS ACTUALIZADOS'); </script>";

    // print_r($resultado);


  }else {
    echo "<script> alert('DATOS NO ACTUALIZADOS'); </script>";
    header('Location: favorito.php');
  }
}

 ?>
