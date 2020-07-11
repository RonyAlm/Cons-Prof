<?php 
require_once('conexion.php');
//require_once('libreria.php');

$profesion=$_POST['profesion'];




	$sql="SELECT id_profesional,
	         nombre_persona,
			 apellido_persona,
			 rela_profesion,
			 rela_persona
		from profesional,persona
		where rela_profesion='$profesion' and rela_persona = id_persona";
    
	$query =$base_de_datos->prepare($sql);
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);
	
	$cadena="<label>Profesional: </label> 
	<select id='select_profesional' name='select_profesional' class='form-control select2bs4' style='width: 100%;'>";
	

	foreach($result as $fila){
		$profesional=$fila['id_profesional'];
		$cadena=$cadena.'<option value='.$profesional.'>'.utf8_encode($fila['nombre_persona']).' '.utf8_encode($fila['apellido_persona']).'</option>';
		
	}
	echo  $cadena."</select>";

	



	$sql_2="SELECT id_consulta, rela_profesional, precio_consulta, descripcion_consulta, rela_tipo_consulta,
	descripcio_tipo_consulta from consulta,tipo_consulta where consulta.rela_profesional= $profesional
	and rela_tipo_consulta = id_tipo_consulta";

	$query_2 =$base_de_datos->prepare($sql_2);
	$query_2->execute();
	$result_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);

	$cadena_2="<label>Consulta: </label> 
	<select id='select_consulta'  name='select_consulta'  class='form-control select2bs4' style='width: 100%;'>";

	foreach($result_2 as $fila_2){
		$cadena_2=$cadena_2.'<option value='.$fila_2['id_consulta'].'>'.$fila_2['descripcio_tipo_consulta'].' - '.$fila_2['descripcion_consulta'].' $'.$fila_2['precio_consulta'].'</option>';
	}
	echo  $cadena_2."</select>";

	
	

?>