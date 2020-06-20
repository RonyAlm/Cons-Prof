<?php
	
	require 'funcs/conexion.php';
	require 'funcs/funcs.php';
	
	$user_id = $mysqli->real_escape_string($_POST['user_id']);
	$token = $mysqli->real_escape_string($_POST['token']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$con_password = $mysqli->real_escape_string($_POST['con_password']);

     if(validaPassword($password, $con_password)){

		 $pass_hash = hashPassword($password);

		 if(cambiaPassword($pass_hash, $user_id, $token)){
			echo "La contraseña ha sido modificada exitosamente! ";
			echo "<br> <a href = 'login.php'> Iniciar Sesion </a>";
		} else{
			echo "Error al modificar la contraseña";
		}
	 }else{
		 echo  "Las contraseñas no coinciden";
	 }

	
	
?>	