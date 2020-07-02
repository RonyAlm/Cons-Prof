<?php 

require 'funcs/conexion.php';
require 'funcs/funcs.php';

$errors = array(); //Para ir colocando todos los errores
if(!empty($_GET)){ //Validar GET
    $tipo_usuario = $_GET['tipo'];
}else{
    header("Location: ../index.php") ;
}

if(!empty($_POST)){ //Para validar si se envia el POST
   $nombre = $mysqli->real_escape_string($_POST['nombre']);   //Para limpiar la cadena que enviamos por POST/ Para evitar el sql Inyection
   $apellido = $mysqli->real_escape_string($_POST['apellido']);
   //dni = $mysqli->real_escape_string($_POST['dni']);
   $usuario = $mysqli->real_escape_string($_POST['usuario']);
   $password = $mysqli->real_escape_string($_POST['password']);
   $con_password = $mysqli->real_escape_string($_POST['con_password']);
   $email = $mysqli->real_escape_string($_POST['email']);
   $captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);

   $activo = 0; //es para cuando registremos el usuario siempre este desactivado
    //Para endicar el privilegio del usuario
   $secret = '6Lc4pqUZAAAAAH6UbWU1veTgtLSbP52J_3LiNyAh';

   if(!$captcha){ //Para validar el captcha
     $errors[] = "Por favor verifica el captcha";
   }
    //Validar todos los datos
   if(isNull ($nombre, $usuario, $password, $con_password, $email)){
      $errors[] = "Debe llenar todos los campos";
   }
   
   if(!isEmail($email)){
       $errors[] = "Dirección de correo inválida";
   }

   if(!validaPassword($password, $con_password)){
       $errors[] = "Las contraseñas no coinciden";
   }

   if(emailExiste($email)){
    $errors[] = "El correo electronico $email ya existe";
   }

   //Para contar si hay errores
   if(count($errors) == 0){
     
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
    
    $arr= json_decode($response, true); //Para ver la respuesta de Google
   
   if($arr['success']){ //Esto indica si se valido o no
      $registroPersona = registroPersona($nombre, $apellido, $email);
      //$mysqli->query("INSERT INTO persona (nombre_persona, apellido_persona, dni_persona, correo_persona) VALUES('$nombre','$apellido','$dni','$email')");//insertar primero persona 
      $pass_hash = hashPassword($password);
      $token = generateToken();
      $persona = $mysqli->insert_id;
      $registro = registraUsuario($usuario, $pass_hash,$activo, $token, $tipo_usuario, $persona);
	  
	  //$registro = $mysqli->query("INSERT INTO usuario (nombre_usuario, password, nombre, correo, activacion, token, rela_tipo, rela_persona) VALUES('$usuario','$password','$nombre','$email','$activo', '$token', '$tipo_usuario','$mysqli->insert_id')");

				
	
      
      if($registro > 0){
        
        $url = 'http://'.$_SERVER["SERVER_NAME"].'/Programacion_Web/ConsProf/login/activar.php?id='.$registro.'&val='.$token;

        $asunto = 'Activar Cuenta - Cons-Prof';
        $cuerpo = "Estimado $nombre: <br/><br/> Para continuar con el proceso de registro, de Click en la siguiente enlace <a href = '$url'> Activar Cuenta</a>";
        
         if (enviarEmail($email, $nombre, $asunto, $cuerpo)){
             //header("location: principal-cliente.php"); Agregar despues en otro documento
            echo "Para terminar el proceso de registro siga las intrucciones que le hemos enviado la
            la direccion de correo electronico: $email"; 
            echo "<br><a href='login.php'>Iniciar Sesion</a>";
            exit;
        } else {
             $errors[] = "Error al enviar Email";
         }

      }else{
          $errors[] = "Error al Registrar";
      }
   }else{
        $errors[] = 'Error al comprobar Captcha';
   }

   
  }


}


?>



<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Acceso Cliente</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <img src="../img/lOGO-2.png" class="logoimg-logr text-center" alt="consprof">
                                        <h3 class="text-center font-h3">Registrate</h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                                            <div id="signupalert" style="display:none" class="alert alert-danger">
                                                <p>Error:</p>
                                                <span></span>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="nombre">Nombre</label>
                                                        <input class="form-control py-4" id="nombre" type="text" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="apellido">Apellido</label>
                                                        <input class="form-control py-4" id="apellido" type="text" name="apellido" placeholder="apellido" value="<?php if(isset($apellido)) echo $apellido; ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="usuario">Usuario</label>
                                                        <input class="form-control py-4" id="usuario" type="text" name="usuario" placeholder="Usuario" value="<?php if(isset($usuario)) echo $usuario; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label class="small mb-1" for="email">Email</label>
                                                            <input class="form-control py-4" id="email" type="email" aria-describedby="emailHelp" name="email" placeholder="Email" value="<?php if(isset($email)) echo $email; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label class="small mb-1" for="password">Contraseña</label>
                                                      <input class="form-control py-4"  type="password" name ="password" placeholder="Contraseña" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirmar Contraseña</label>
                                                        <input class="form-control py-4" type="password" name="con_password" placeholder="Confirmar contraseña" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="captcha" class="small mb-1"></label>
                                                        <center><div class="g-recaptcha kpcha" data-sitekey="6Lc4pqUZAAAAAIgpp8LaqR2kk5XQFlsXRY42cIBA"></div></center>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <button class="btn btn-primary btn-block" type = "submit" >Registrar</button>
                                            </div>
                                        </form>
                                        <?php echo resultBlock($errors); ?>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.php">Ya tiene una cuenta? Iniciar Sessión</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2019</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
