<?php

    session_start();
    
	require 'funcs/conexion.php';
	require 'funcs/funcs.php';

	$errors = array(); //Para recibir los errores

	if(!empty($_POST)){ //Validar POST
		
		$usuario = $mysqli->real_escape_string($_POST['usuario']);
		$password = $mysqli->real_escape_string($_POST['password']);

		if(isNullLogin($usuario, $password)){
           $errors[] = "Debe llenar todos los campos";
		}

		$errors[] = login($usuario, $password);

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
        <title>Login - Cons-Prof</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Iniciar Sesión</h3></div>
                                    <div class="card-body">
                                        <form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                                            <div class="form-group">
                                                <label class="small mb-1" for="usuario">Usuario</label>
                                                <input class="form-control py-4" id="usuario" name="usuario" type="text" placeholder="Ingrese su usuario o correo" required />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Contraseña</label>
                                                <input class="form-control py-4" id="password" type="password" name="password" placeholder="Ingrese su contraseña" required />
                                            </div>
                                            
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="recupera.php">Se te olvidó tu contraseña?</a>
                                                <button class="btn btn-primary" type="submit">Iniciar sesión</button>
                                            </div>
                                        </form>
                                        <?php echo resultBlock($errors); ?> <!--Para mostrar los errores-->
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="registro.php">No tiene una cuenta? Registrate aquí!</a></div>
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
                            <div class="text-muted">Cons-Prof &copy; Análisis 2020</div>
                            <div>
                                <a href="#">Todos los derechos reservados</a>
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
