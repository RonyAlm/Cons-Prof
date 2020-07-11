$(document).ready(function() {
    var id_cliente, opcion;
    opcion = 4;
        
    tablaUsuarios = $('#tablaUsuarios').DataTable({  
        "ajax":{            
            "url": "dataTables/bd/crud_2.php", 
            "method": 'POST', //usamos el metodo POST
            "data":{opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        
        "columns":[
            {"data": "id_cliente"},
            {"data": "nombre_persona"},
            {"data": "descripcio_tipo_consulta"},
            {"data": "descripcion_consulta"},
            {"data": "precio_consulta"},
            {"data": "start"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>videocam</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
        ]
    });     
    
    var fila; //captura la fila, para editar o eliminar
    //submit para el Alta y Actualización
    
            
     
    
    //para limpiar los campos antes de dar de Alta una Persona
    
    
    //Editar        
    $(document).on("click", ".btnEditar", function(){		        
        opcion = 2;//editar
        fila = $(this).closest("tr");	        
        user_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
        /*username = fila.find('td:eq(1)').text();
        first_name = fila.find('td:eq(2)').text();
        last_name = fila.find('td:eq(3)').text();
        gender = fila.find('td:eq(4)').text();
        password = fila.find('td:eq(5)').text();
        status = fila.find('td:eq(6)').text();*/
        $(".id_cliente").val(user_id);		
        $('#modal-default').modal('show');		   
    });
    
    
    
         
    }); 