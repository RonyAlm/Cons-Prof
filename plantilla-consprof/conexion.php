<?php

define("SERVIDOR","localhost");
 define("USUARIO","root");
 define("PASSWORD","");
 define("BD","db_consprof_0.3");

  $servidor= "mysql:dbname=".BD.";host=".SERVIDOR;

  try {
    $base_de_datos = new PDO($servidor,USUARIO,PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    // echo "<script>alert('conectado...')</script>";


  } catch (PDOException $e) {
    echo "<script>alert('Error...')</script>";
    die('Error' . $e->getMessage());
    echo "Linea del error" . $e->getLine();
  }


 ?>
