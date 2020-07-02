<?php 

require 'login/funcs/conexion.php';
require 'login/funcs/funcs.php';

    

    $sql = "SELECT id, tipo FROM tipo_usuario ORDER BY tipo";
    $result = $mysqli->query($sql);

     
	
    
    
    
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cons-Prof</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="shortcut icon" href="img/lOGO-CAMARA.png" type="image/x-icon">
</head>

<body>
<section id="contenido">
    <!--Inicio de Cabecera-->
    <section id="cabecera">
        <header id="header">
            
              <img src="img/lOGO-2.png" alt="" id="logoimg">  
            
        </header>
        <div class="clearfix"></div>
        <nav id="menu">
            <ul>
                <li><a href="#">MENU</a></li>
                <li><a href="#">ACERCA DE CONSPROF</a></li>
                <li><a href="#">CONTACTO</a></li>
                <li>
                    <a href="#">INICIAR SESIÓN</a>
                    <ul>
                       <form action="login/login.php" method="GET">
                            <?php 
                            while ($row = $result->fetch_assoc()) { ?>
                                <li><button  name="tipo" class="btn-menu" type="submit" value="<?php echo $row['id']; ?>"> ACCESO <?php echo $row['tipo']; ?></button></li>
                            <?php  } ?>
                        </form>
                    </ul>
                </li>
            </ul>
        </nav>
    </section>
    <!--Fin de Cabecera-->

    <!--Inicio del Footer-->
    <div class="clearfix"></div>
    <footer id="footer">
        <p>&copy; Todos los derechos reservado</p>
        <p>CONSPROF</p>
    </footer>
    <!--Fin del Footer-->


</section>

   

</body>

</html>