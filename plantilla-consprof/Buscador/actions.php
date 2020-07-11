<?php 
    include_once('../conexion.php');

     if(!empty($_POST['busqueda'])){
        $busqueda = explode(" ",$_POST['busqueda']);
        //$sql = "SELECT * FROM productos WHERE name LIKE '%".$busqueda."%'";
        $sql_profesionales = "SELECT *
          FROM profesional, persona, profesion
          WHERE nombre_persona LIKE '%".$busqueda[0]."%'
          or descripcion_profesion LIKE '%".$busqueda[0]."%'
          AND profesional.rela_persona= persona.id_persona
          AND profesional.rela_profesion=profesion.id_profesion LIMIT 3
          ";
          $query_profesionales = $base_de_datos->prepare($sql_profesionales);
          $query_profesionales->execute();
          $result_profesionales = $query_profesionales->fetchAll(PDO::FETCH_ASSOC);
          //var_dump($result_profesionales);
        //$result = mysqli_query($mysqli,$sql);
            for ($i=1; $i < count($busqueda); $i++) { 
                if(!empty($busqueda[$i])){
                    $sql .= "AND nombre_persona LIKE '%".$busqueda[$i]."%'";
                } 
            }

       foreach($result_profesionales as $profesionales){
?>

  <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
    <div class="card bg-light">
      <div class="card-header text-muted border-bottom-0">
      <?php 
        echo $profesionales['descripcion_profesion'];
      ?>
      </div>
      <div class="card-body pt-0">
        <div class="row"> 
          <div class="col-7">
            <h2 class="lead"><b><?php echo $profesionales['nombre_persona']." ".$profesionales['apellido_persona']; ?></b></h2>
            <p class="text-muted text-sm"><b>Especialidades: </b> <?php echo $profesionales['especialidad']; ?> </p>
            <ul class="ml-4 mb-0 fa-ul text-muted">
              <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Correo: <?php echo  $profesionales['correo_persona']; ?></li>
              <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
            </ul>
          </div>
          <div class="col-5 text-center">
           <img src="data:image/jpg; base64, <?php echo base64_encode ($profesionales['imagen_icono']); ?>" alt="" class="img-circle img-fluid">
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="text-right">
          <a href="#" class="btn btn-sm bg-teal">
            <i class="fas fa-comments"></i>
          </a>
          <a href="#" class="btn btn-sm btn-primary">
            <i class="fas fa-user"></i> Ver Perfil
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php 
      }
    }
      ?>
