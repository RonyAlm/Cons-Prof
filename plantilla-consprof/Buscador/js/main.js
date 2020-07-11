$(document).ready(function(){
   $('#search').keyup(function(event){
      event.preventDefault();
      let data = $('#form-busqueda').serializeArray();
        $.post({
            url:'Buscador/actions.php',
            data:data,
            success: function(response){
                $('#response').html(response);
            }
        })
   })
});