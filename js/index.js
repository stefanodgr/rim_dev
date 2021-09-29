$(document).ready(function(){      	
    $.get("controlador/inicio/login.php", function(urlExt){
        $("#panel_center").html(urlExt);
    });
});