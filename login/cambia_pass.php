<?php
	
	require 'funcs/conexion.php';
	require 'funcs/funcs.php';
	
	if(empty($_GET['user_id'])){
		header ('Location: login.php');
	}

	if(empty($_GET['token'])){
		header ('Location: login.php');
	}

	$user_id = $mysqli->real_escape_string($_GET['user_id']);
	$token = $mysqli->real_escape_string($_GET['token']);

	if(!verificaTokenPass($user_id, $token)){
		echo "No se pudo verificar los datos";
		exit;
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
        <title>Recuperar Contraseña - Cons-Prof</title>
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Modificar contraseña</h3></div>
                                    <div class="card-body">
                                        <form role="form" action="guarda_pass.php" method="POST" autocomplete="off">

                                            <input type="hidden" id="user_id" name="user_id" value ="<?php echo $user_id; ?>" />
							
							                <input type="hidden" id="token" name="token" value ="<?php echo $token; ?>" />

                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Nueva constraseña</label>
                                                <input class="form-control py-4" id="password" name="password" type="password" placeholder="Escriba una nueva contraseña" required />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="con_password">Confirmar constraseña</label>
                                                <input class="form-control py-4" id="con_password" name="con_password" type="password" placeholder="Confirmar la nueva contraseña" required />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" type="submit">Modificar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.php">Iniciar Sesión</a></div>
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
                            <div class="text-muted">ConsProf &copy; Análisis 2020</div>
                            <div>
                                <a href="#">Todo los derechos reservado</a>
                               
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
