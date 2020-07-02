<?php

  include('conexion.php');

  // actualizamos los datos que se encuentra en el FORMULARIO del perfil

if (isset($_POST["actualizar_datos"])) {

    $id_user=$_POST["id_user"];

    $id_user=$_POST["id_user"];
    $nombre_user=$_POST["nombre"];
    $email_user=$_POST["email"];
    $especialidad=$_POST["edad"];
    $fecha_nac_user=$_POST["fecha_nac"];
    $cuil_user=$_POST["cuil"];
    $matricula_user=$_POST["matricula"];
    $direccion_user=$_POST["direccion"];
    $descripcion_user=$_POST["descripcion_user"];



  $sentencia= $base_de_datos->query("UPDATE `users` SET `name`='$nombre_user',
                                            `email`='$email_user',
                                            `especialidad`='$especialidad',
                                            `direccion`='$direccion_user',
                                            `fcha_nac`='$fecha_nac_user',
                                            `cuil`='$cuil_user',
                                            `matricula`='$matricula_user'

                                     WHERE `id`=$id_user");


    if ($sentencia) {

      echo "datos actualizados";
      header('location:perfil.php');
    }else {
      // header('location:perfil.php');
      echo "datos no actualizados";
    }

   }


   // se AGREGA los estudios del profesional

   if (isset($_POST['agregar_estudios'])) {

     $id_user=$_POST['id_user'];

     $tipos_estudioss= $_POST['estudios'];

     $nombre_institucion= $_POST['nombre_institucion'];

     $fecha_des_has= $_POST['fecha_des_has'];



     $sql= "INSERT INTO tipo_estudio (tipos_estudio, nombre_institucion, fecha_des_has, rela_users)
            VALUES(:tipos_estudio, :nombre_institucion, :fecha_des_has, :rela_users)";

      $resultado= $base_de_datos->prepare($sql);

      $resultado->execute(array(':tipos_estudio'=>$tipos_estudioss, ':nombre_institucion'=>$nombre_institucion,
                                ':fecha_des_has'=>$fecha_des_has, ':rela_users'=>$id_user));

      if ($resultado) {
        echo "<script> alert('DATOS ACTUALIZADOS'); </script>";

        // print_r($resultado);
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
       $carpeta_destino= $_SERVER['DOCUMENT_ROOT'] . '/plantilla-consprof/imagenes_servidor/';


       // MOVEMOS LA IMAGEN DEL DIRECTORIO TEMPORAR AL DIRECTORIO ESCOGIDO
       move_uploaded_file($_FILES['imagen_titulo']['tmp_name'],$carpeta_destino.$nombre_imagen1);

       move_uploaded_file($_FILES['imagen_matricula']['tmp_name'],$carpeta_destino.$nombre_imagen2);

     }else {
       echo "Solo se pueden subir imagenes jpg/jpeg/png/gif";
     }

     }else {
       echo "El tamaño de la imagen es demasiado grande";
     }

     $sql= "UPDATE `users` SET `imagen_titulo`='$nombre_imagen1',
                              `imagen_matricula`= '$nombre_imagen2'
            WHERE id= '$id_user'";

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



  $sentencia_imagen= $base_de_datos->query("UPDATE `users` SET `imagen_icono`='$imagen'

                                     WHERE `id`=$id_user");

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


 ?>
