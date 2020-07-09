<?php 
require_once('conexion.php');
$profesional=$_POST['profesional'];


	$sql="SELECT * FROM `profesional` WHERE profesional.id_profesional= $profesional
    ";
    
	$query =$base_de_datos->prepare($sql);
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);
	
	
	

	foreach($result as $fila){
        $profesional=$fila['id_profesional'];
        echo '<input type="hidden" name="id_profesional" id="id_profe_prueba" value='.$profesional.'>';
	}
   


	
	

?>