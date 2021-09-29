// ------------------------------- FUNCIONES JS UTILIZADAS POR LE MENÚ DEL SISTEMA ------------------------------- //
    var menuAct;
    var subMenuAct;
    var snLogin;
    var snPersNomb;
    var snPerfUsu;
    var snIdUsu;
    var snIdPerfUsu;
    var snIdRelPerfUsu;
    var snNivel;	
    var snConex;
    var snExpire;

    $(document).ready(function(){
        cargarConexion();
        $('#panel_left').on('click','.panel-heading',function(){    // CLICK EN OPCIÓN DEL MENÚ 
            var controlador = $(this).attr('name');
            if(menuAct == null){
                menuAct = this;
                $(menuAct).addClass('menu-selected');
            }
            else{
                $(menuAct).removeClass('menu-selected');
                menuAct = this;
                $(menuAct).addClass('menu-selected');
            }
            if(subMenuAct != null){
                if(this.parentNode.id != 'Referenciales'){
                    $(subMenuAct).removeClass('sub-selected');
                    subMenuAct = null;
                }
            }
            abrirControlador(controlador);
		});
        $('#panel_left').on('click','.opcion',function(){           // CLICK EN SUB-OPCION DEL MENÚ
            // alert("sub_opcion");
            var controlador = $(this).attr('name');
			if(subMenuAct == null){
                subMenuAct = this;
                $(this).addClass('sub-selected');
            }
            else{
                $(subMenuAct).removeClass('sub-selected');
                subMenuAct = this;
                $(this).addClass('sub-selected');
            }
            abrirControlador(controlador);
		});
        $('.div_conex_accion').on('click',function(){               // CLICK EN DIV DE INFORMACIÓN DE USUARIOS CONECTADOS
            if($('.div_conex_accion').hasClass('marcado')){
                var ctrlInicio      = $('#logo_sistema').is(":hidden");
                var ctrlContenido   = $('.contenido').is(":hidden");

                $('#panel_right').css('background-color','#ECECEC');

                $('.div_conex_accion').removeClass('marcado');
                $('#div_conexion').remove();

                if(ctrlInicio){
                    $('#logo_sistema').show();
                }
                if(ctrlContenido){
                    $('.contenido').show();
                }
            }
            else{
                $('.div_conex_accion').addClass('marcado');
                var ctrlInicio      = $('#logo_sistema').is(":visible");
                var ctrlContenido   = $('.contenido').is(":visible");
                var div     = document.getElementById('panel_right');
                var divConex= document.createElement("div");
                var ifrConex= document.createElement("iframe");
                $('#panel_right').css('background-color','rgb(219, 219, 219)');

                divConex.setAttribute('id','div_conexion');
                divConex.setAttribute('style','position:absolute;width:70%;height:300px;left:15%;top:100px;');
                ifrConex.setAttribute('id','ifr_conexion');
                ifrConex.setAttribute('name','ifr_conexion');
                ifrConex.setAttribute('style','position: relative;width:99.8%;height:100%;border:none;');
                ifrConex.setAttribute('src','controlador/inicio/conexion.php');

                if(ctrlInicio){
                    $('#logo_sistema').hide();
                }
                if(ctrlContenido){
                    $('.contenido').hide();
                }
                
                div.appendChild(divConex);
                divConex.appendChild(ifrConex);
            }
        });
	});
    function abrirControlador(controlador){
        if(controlador!="#"){
            switch (controlador){
                case "Cerrar Sesión":
                    xajax_cerrarSesion();           
                break;
                default:
                    $('.xdsoft_datetimepicker').remove();
                    $.get(controlador, function(urlExt){
                        $("#panel_right").html(urlExt);
                    });
                break;
            }
        }
    }
    function cargarConexion(){
        setTimeout(function(){
            xajax_cargarConexion();
            cargarConexion();
        }, 30000);
    }
    function reiniciarIndex(){
        window.location.reload();  
    }
// --------------------------------------------------------------------------------------------------------------- //