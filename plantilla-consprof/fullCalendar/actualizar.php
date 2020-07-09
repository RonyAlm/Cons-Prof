<?php
   require_once('../conexion.php');

   $fecha_edit=$_POST['fecha_edit'];
   $id_edit=$_POST['id_edit'];
   $color_edit=$_POST['color_edit'];
   $titulo_edit=$_POST['evento_edit'];
   $hi_edit=$_POST['hora_inicial_edit'];
   $hf_edit=$_POST['hora_final_edit'];
  

   //var_dump($fecha_edit, $color_edit, $titulo_edit,$hi_edit,$hf_edit);

   //Array asociativo
   $datos= array(
       "id"=>$id_edit,
       "title"=>$titulo_edit,
       "start"=>$fecha_edit." ". $hi_edit,
       "end"=>$fecha_edit." ". $hf_edit,
       "color"=>$color_edit
   );
    //var_dump($datos);
   // Conexion
   $sql = " UPDATE turno SET title = :title,start = :start,end = :end,color = :color WHERE turno.id = :id";
   $query =$base_de_datos->prepare($sql);
   $query->execute($datos);
   $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

   header('Location: ../calendar.php');
?>