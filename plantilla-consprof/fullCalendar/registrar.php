<?php
   require_once('../conexion.php');
   if(!empty($_POST)){
   $profesional=$_POST['select_profesional'];
   $Consulta=$_POST['select_consulta'];
   $fecha=$_POST['fecha'];
   $evento=$_POST['evento'];
   $hora_inicial=$_POST['hora_inicial'];
   $hora_final=$_POST['hora_final'];
   $color=$_POST['color'];
   $cliente = $_POST['id_cliente'];
   //var_dump($fecha, $evento, $hora_inicial, $hora_final, $color, $profesional, $Consulta );

   //Array asociativo
   /*$datos= array(
       "title"=>$evento,
       "start"=>$fecha." ".$hora_inicial,
       "end"=>$fecha." ".$hora_final,
       "color"=>$color,
       "profesional"=>$profesional,
       "cliente"=>$cliente,
       "consulta"=>$Consulta
   );*/
    
   // Conexion
     $sql = "INSERT INTO turnos(title,start, end, color, rela_profesional_turno, rela_cliente_turno, rela_consulta_turno ) VALUES('$evento', '$fecha''$hora_inicial','$fecha''$hora_final', '$color', '$profesional', '$cliente', '$Consulta')";
     $query = $base_de_datos->query($sql);
     /*$query->execute();
     $resultado = $query->fetchAll(PDO::FETCH_ASSOC);*/
    
     //var_dump($query);
     header('Location: ../calendar.php');
   }
?>