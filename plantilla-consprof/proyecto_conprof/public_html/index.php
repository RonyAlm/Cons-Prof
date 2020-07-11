
    <?php
    include_once('../../conexion.php');

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
       //echo "<script> alert('DATOS ACTUALIZADOS');</script>";
  
       // print_r($resultado);
       //header('Location: proyecto_conprof/public_html/index.php');

       $sentencia_sala=$base_de_datos->query("SELECT `id_sala`, `nombre_sala`, `rela_cliente_sala`, `rela_profesional_sala`
                                             FROM `sala`
                                             WHERE `rela_cliente_sala`=$id_cliente AND `rela_profesional_sala`= $id_profesional");

      $sala=$sentencia_sala->fetchAll(PDO::FETCH_OBJ);

      foreach ($sala as $key) {

        $id_sala=$key->id_sala;
        $rela_cliente=$key->rela_cliente_sala;
        $nombre_sala=$key->nombre_sala;
        $rela_profesional=$key->rela_profesional_sala;
      }

     }else {
       echo "<script> alert('DATOS NO ACTUALIZADOS'); </script>";
     }
  
     $resultado->closeCursor();
  
  // Ingresar sala del cliente
  }




      //////////////////////////////////////////////////////////////////////////////////
     /* include_once('../../conexion.php');

      $id_cliente=3;
      $id_profesional=9;

      $sentencia_sala=$base_de_datos->query("SELECT `id_sala`, `nombre_sala`, `rela_cliente_sala`, `rela_profesional_sala`
                                             FROM `sala`
                                             WHERE `rela_cliente_sala`=$id_cliente AND `rela_profesional_sala`= $id_profesional");

      $sala=$sentencia_sala->fetchAll(PDO::FETCH_OBJ);

      foreach ($sala as $key) {

        $id_sala=$key->id_sala;
        $rela_cliente=$key->rela_cliente_sala;
        $nombre_sala=$key->nombre_sala;
        $rela_profesional=$key->rela_profesional_sala;
      }*/

     ?>
<html itemscope itemtype="http://schema.org/Product" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/html">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="content-type" content="text/html;charset=utf-8">

  </head>
  <body>

      <script src="https://meet.jit.si/external_api.js"></script>
      <script>
          var domain = "meet.jit.si";
          var options = {
              roomName: "<?php echo $nombre_sala; ?>",
              width: 1350,
              height: 650,
              parentNode: undefined,
              requireDisplayName: true,
              enableWelcomePage: true,
              enableClosePage: false,
              configOverwrite: {},

              /*interfaceConfigOverwrite: {
                  filmStripOnly: true
              }*/
          }
          var api = new JitsiMeetExternalAPI(domain, options);
      </script>

  </body>
</html>
