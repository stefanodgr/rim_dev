/* ------------------------------- FUNCIONES JS UTILIZADAS LA PANTALLA DE LOGIN ------------------------------- */
    $(document).ready(function() {
        $('#panel_center').on('keypress','#box_datos',function(e){                     
            if(e.which == 13) validarBoton();
        });
        $('#panel_center').on('mouseover','#div_logo_adv',function(){
            $('#div_login_adv').show();
        });
        $('#panel_center').on('mouseout','#div_logo_adv',function(){
            $('#div_login_adv').hide();
        });
        $('#panel_center').on('focus','#id_inp_usuario',function(){
            $('.ico_user').css('background','url("multimedia/imagen/portada/ico_user_2.png")');
        });
        $('#panel_center').on('blur','#id_inp_usuario',function(){
            $('.ico_user').css('background','url("multimedia/imagen/portada/ico_user.png")');
        });
        $('#panel_center').on('focus','#id_inp_password',function(){
            $('.ico_password').css('background','url("multimedia/imagen/portada/ico_password_2.png")');
        });
        $('#panel_center').on('blur','#id_inp_password',function(){
            $('.ico_password').css('background','url("multimedia/imagen/portada/ico_password.png")');
        });
        $('#panel_center').on('focus','#id_inp_passnew',function(){
            $('.ico_passnew').css('background','url("multimedia/imagen/portada/ico_password_2.png")');
        });
        $('#panel_center').on('blur','#id_inp_passnew',function(){
            $('.ico_passnew').css('background','url("multimedia/imagen/portada/ico_password.png")');
        });
        $('#panel_center').on('mouseover','#div_logo_adv',function(){
            $('#box_login').removeClass('back_log').addClass('back_adv');
            $('#box_datos').hide();
            $('#div_login_adv').show();
        });
        $('#panel_center').on('mouseout','#div_logo_adv',function(){
            $('#box_login').removeClass('back_adv').addClass('back_log');
            $('#div_login_adv').hide();
            $('#box_datos').show();
        });
    });

    function validarBoton(){
        if($('#btn_ingresar').is(":visible")) validarLogin();
        else validarCambio();
    }

    function validarLogin(){
        var idUsuario       = document.getElementById('id_inp_usuario');
        var idContraseña    = document.getElementById('id_inp_password');
        var labelError      = document.getElementById('id_lbl_error');
        var textError       = document.getElementById('id_txt_error');
        var msgError        = '';
        
        if((idUsuario.value == "")||(idContraseña.value == "")){
            if(idUsuario.value == ""){    
                msgError = "ERROR: El campo USUARIO no puede estar vacio.";
                idUsuario.focus();
            }
            else{
                msgError = "ERROR: El campo CONTRASEÑA no puede estar vacio.";
                idContraseña.focus();
            }
            labelError.className = 'visible';
            textError.innerHTML = msgError; 
        }
        else {
            labelError.className = 'oculto';
            textError.innerHTML = '';
            xajax_validarLogin(idUsuario.value,idContraseña.value);
        }
    }

    function cambiarClave(){
        var msg = 'Su clave debe ser cambiada por una clave personalizada de mínimo 6 caracteres.';

        // $('#id_lbl_acceso')     .html('<strong>Cambio de clave</strong>');
        $('#id_inp_usuario')    .parent().hide();
        $('#id_inp_password')   .parent().css('top', '-20px');
        $('#id_inp_password')   .val('').focus();
        $('#id_inp_passnew')    .parent().show();
        $('#btn_ingresar')      .hide();
        $('#btn_cambiar')       .show();
        msgLogin(msg);
    }

    function validarCambio(){
        var msgError        = '';
        var error           = false;
        var usuario         = $('#id_inp_usuario')  .val();
        var nvaClave        = $('#id_inp_password') .val();
        var confNvaClave    = $('#id_inp_passnew')  .val();
        var cantLetras      = nvaClave.length;

        if(cantLetras >= 6){
            if(nvaClave === confNvaClave) xajax_cambiarClave(usuario, nvaClave);
            else{
                $('#id_inp_password').focus();
                msgError = "ERROR: Las contraseñas ingresadas no coinciden.";
                error = true;
            }
        }
        else{
            $('#id_inp_password').focus();
            msgError = "ERROR: La nueva contraseña debe contener mínimo 6 caracteres.";
            error = true;
        }

        if(error) msgLogin(msgError);
    }

    function msgLogin(msg){
        $('#id_lbl_error').show();
        $('#id_txt_error').text(msg);
    }

    function limpiarCamposLogin(){
        $('#id_inp_usuario')    .val('').parent().show();
        $('#id_inp_usuario')    .focus();
        $('#id_inp_password')   .val('').parent().css('top','0px');
        $('#id_inp_passnew')    .val('').parent().hide();
        $('#btn_ingresar')      .show();
        $('#btn_cambiar')       .hide();
        // $('#id_lbl_acceso')     .html('<strong>Acceso al sistema</strong>');
    }

    function mostrarMenu(perfil, conexion){
        $('#panel_center').remove();
        $('#panel_left, #panel_right').show();
        $.get("controlador/inicio/menu.php", function(urlExt){
            $("#panel_left").html(urlExt);
        });
    }
    
    function sessionJs(login,persNomb,perfUsu,idUsu,idPerfUsu,idRelPerfUsu,nivel,conex,cxpire){
        snLogin         = login;
        snPersNomb      = persNomb;
        snPerfUsu       = perfUsu;
        snIdUsu         = idUsu;
        snIdPerfUsu     = idPerfUsu;
        snIdRelPerfUsu  = idRelPerfUsu;
        snNivel         = nivel;
        snConex         = conex;
        snExpire        = cxpire;
    }

    function validarSesion(intervalo){
        setTimeout(function(){
            xajax_validarSesion();
        }, intervalo);
    }
/* ------------------------------------------------------------------------------------------------------------ */