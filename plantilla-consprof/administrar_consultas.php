<?php

  include_once('conexion.php');
  if (isset($_POST['agregar_consulta'])) {

    $id_user=$_POST['id_user'];

    $tipo_consulta= $_POST['tipo_consulta'];

    $descripcion_consulta= $_POST['descripcion_consulta'];

    $precio= $_POST['precio'];


       $sql= "INSERT INTO consulta (precio_consulta, descripcion_consulta, rela_users,rela_tipo_consulta)
              VALUES(:precio_consulta, :descripcion_consulta, :rela_users, :rela_tipo_consulta)";

        $resultado= $base_de_datos->prepare($sql);

        $resultado->execute(array(':precio_consulta'=>$precio,':descripcion_consulta'=>$descripcion_consulta,
                                   ':rela_users'=>$id_user, ':rela_tipo_consulta'=>$tipo_consulta));

        if ($resultado) {
          echo "<script> alert('DATOS ACTUALIZADOS'); </script>";

          // print_r($resultado);
          header('Location:starter.php');
        }else {
          echo "<script> alert('DATOS NO ACTUALIZADOS'); </script>";
        }

        $resultado->closeCursor();


  }

  if (isset($_POST["editar_datos"])) {

    $id_user=$_POST['id_user'];

    $descripcion_consulta= $_POST['descripcion_consulta'];

    $precio= $_POST['precio'];

    $sentencia= $base_de_datos->query("UPDATE `consulta` SET `precio_consulta`='$precio',
                                              `descripcion_consulta`='$descripcion_consulta'

                                       WHERE `id_consulta`=$id_user");

        if ($sentencia) {

         echo "datos actualizados";
         header('location:starter.php');
        }else {
         // header('location:perfil.php');
         echo "datos no actualizados";
        }

  }

 ?>
