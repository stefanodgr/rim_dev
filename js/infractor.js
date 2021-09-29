/* ------------------------------- FUNCIONES JS UTILIZADAS EN EL MÓDULO INFRACTORES ------------------------------- */
    var arrActual       = new Array();
    var arrModificado   = new Array();
    var accion          = null;

    $(document).ready(function(){
        /* ----------------- BOTON CONSULTAR (LUPA) --------------- */
        $('#panel_right').on('click','#btn_busq_infractor', function(){		    // CLICK EN EL BOTÓN LUPA BÚSQUEDA DE FICHA
            if(rastroInfraccion == null) buscarInfractor();
        });
        /* -------------------------------------------------------- */
        
        /* -------------------- BOTON CONSULTAR ------------------- */
        $('#panel_right').on('click','#btn_infractor_bus', function(){		    // DETECTA CLICK EN EL BOTON 'btn_infractor_bus' (Consultar)
            if(rastroInfraccion != null){
                $('#panel_left #opcion_Infracciones').click();
                setTimeout(function(){
                    cargarInfraccion(rastroInfraccion)
                    rastroInfraccion = null;
                },250);
            }
            else buscarInfractor();
        });
        /* -------------------------------------------------------- */

        /* -------------------- BOTON EXPEDIENTE ------------------- */
        // $('#panel_right').on('click','#btn_infractor_exp', function(){ 		// DETECTA CLICK EN EL BOTON 'btn_infractor_exp' (Ver Expediente)
        //     $('#ficha_infractor').addClass('oculto');
        //     $('#exped_infractor').removeClass('oculto');
        //     window.frames['ifr_infractor_exp'].dimensiones();
        // });
        /* -------------------------------------------------------- */

        /* ------------------- BOTON REPORTE PDF ------------------ */
        $('#panel_right').on('click','#btn_infractor_rep', function(){ 		    // DETECTA CLICK EN EL BOTON 'btn_infractor_rep' (Generar Reporte)
            if((snPerfUsu == 'MASTER') || (snPerfUsu == 'GERENCIAL')){
                var infractorId = $('#filt_id').val();
                var rutaReporte = 'controlador/infractor/reporte_infractor.php';
                var arrParam    = new Array(infractorId);
                formReporte(rutaReporte,arrParam);
            }
        });
        /* -------------------------------------------------------- */

        /* -------------------- BOTON MODIFICAR ------------------- */
        $('#panel_right').on('click','#btn_infractor_mod', function(){ 		// DETECTA CLICK EN EL BOTON 'btn_infractor_exp' (Modificar)
            accion = 'modificar';
            cargarDatos();
            gestBtnAceptar(0);
            gestionBtnInfractor(2);
            $('.modal_titulo').text('- Modificar Datos -');
            $('.frm_0').prop('disabled',false).removeClass('div-inp-dis').addClass('div-inp-ena');
            $('.frm_1').prop('disabled',false).removeClass('div-inp-dis').addClass('div-inp-ena');
            $('#filt_nac').prop('disabled',false);
            $('#filt_foto_load').prop('disabled',false).css('cursor','pointer');

            if($('.inf-metro').is(':visible')) $('.frm_2').prop('disabled',true).removeClass('div-inp-ena').addClass('div-inp-dis');
        });
        /* -------------------------------------------------------- */

        /* --------------------- BOTON LIMPIAR -------------------- */
        $('#panel_right').on('click','#btn_infractor_lim', function(){ 		// DETECTA CLICK EN EL BOTON 'btn_infractor_lim' (Limpiar)
            if(rastroInfraccion != null){
                $('#panel_left #opcion_Infracciones').click();
                setTimeout(function(){
                    cargarInfraccion(rastroInfraccion)
                    rastroInfraccion = null;
                },250);
            }
            else{
                $('.frm_0').val('').prop('disabled',false).removeClass('div-inp-dis').addClass('div-inp-ena');
                $('.frm_1').val('');
                $('#filt_nac').val('').prop('disabled',false);
                $('#btn_busq_infractor').prop('disabled',false);
                $('#filt_foto').attr('src','multimedia/imagen/infractor/siluetaHombre.png');
                $('#filt_foto_load').prop('disabled',true).css('cursor','not-allowed');
                $('.modal_titulo').text('- Búsqueda de Infractor -');
                $('.inf-metro').addClass('oculto');
                $('#exped_infractor').addClass('oculto');
                $('#ifr_infractor_exp').attr('src','');
                $('#btn_infractor_rep').addClass('oculto');
                document.getElementById('filt_nac').options[0].selected = 'selected';
                gestionBtnInfractor(0);
                infReincidenciaInf(2);
                accion = null;
            }
        });
        /* -------------------------------------------------------- */

        /* ---------------------- BOTON FICHA --------------------- */
        // $('#panel_right').on('click','#btn_infractor_fic', function(){ 		// DETECTA CLICK EN EL BOTON 'btn_infractor_fic' (Atrás)
        //     $('#exped_infractor').addClass('oculto');
        //     $('#ficha_infractor').removeClass('oculto');
        //     $('#ifr_infractor_exp').blur();
        // });
        /* -------------------------------------------------------- */

        /* --------------------- BOTON ACEPTAR -------------------- */
        $('#panel_right').on('click','#btn_infractor_ace', function(){ 		// DETECTA CLICK EN EL BOTON 'btn_infractor_ace' (Aceptar)
            cargarDatos();
            if(accion == 'modificar') modificarInfractor();       
        });
        /* -------------------------------------------------------- */

        /* --------------------- BOTON CANCELAR ------------------- */
        $('#panel_right').on('click','#btn_infractor_can', function(){ 		// DETECTA CLICK EN EL BOTON 'btn_infractor_can' (Cancelar)
            $('.modal_titulo').text('- Ficha del Infractor -');
            $('#filt_foto_load').prop('disabled',true).css('cursor','not-allowed');
            gestBtnAceptar(0);
            restaurarDatos();
            gestionBtnInfractor(1);
            bloquearFiltros();
            accion = null;
            arrActual.length        = 0;
            arrModificado.length   = 0;
        });
        /* -------------------------------------------------------- */

        $('#panel_right').on('keypress','.frm_0',function(e){ 				// DETECTA EL PULSO DE UNA TECLA SOBRE LOS ELEMENTOS CON CLASE 'frm_0'
            if(e.which != 13){									            // SI LA TECLA PULSADA ES DIFERENTE DE LA TECLA ENTER
                if(e.which != 8){ 								            // SI LA TECLA PULSADA ES DIFERENTE DE LA TECLA BORRAR
                    var idElement = this.id;
                    if(idElement == 'filt_cedula'){
                        var ctrl = validarCadena(e,'num');
                        return ctrl;
                    }
                }
            }
            else{
                switch(accion){
                    case null:
                        buscarInfractor();
                    break;
                    case 'modificar': $('#btn_infractor_ace').click();
                    break;
                }
                this.blur();
            }
        });

        $('#panel_right').on('change','#filt_nac',function(){
            gestBtnAceptar(null,this.id,this.value);
        });

        $('#panel_right').on('keyup','.edit',function(e){
            if(e.which != 13){
                if(accion == 'modificar'){
                    var valor   = this.value;
                    var id      = this.id;
                    var existe  = false;
                    gestBtnAceptar(null,id,valor);
                }
            }
        });

        $('#panel_right').on('change','#filt_foto_load',function(e){        // AL DETECTAR CAMBIO EN LA FOTO
			cargarFotoInvol(e.target.files,'infractor');
		});
    });

    function gestBtnAceptar(habilitar,id,valor){

        if((habilitar == 0) || (habilitar == 1)){
            if(habilitar == 1) $('#btn_infractor_ace').prop('disabled',false).removeClass('deshabilitado');
            else $('#btn_infractor_ace').prop('disabled',true).addClass('deshabilitado');;
        }
        else{
            var existe  = false;

            if(arrModificado.length <= 0){
                if(valor != arrActual[id]) arrModificado[0] = id;
            }
            else{
                var longitud= arrModificado.length;
                var existe  = verifExisElement(arrModificado,id);

                if(!existe) arrModificado[longitud] = id;
                else{
                    var posicion = verifPosElement(arrModificado,id);

                    if(valor != arrActual[id]) arrModificado[posicion] = id;
                    else arrModificado = delPosArr(arrModificado,posicion);
                }
            }
            if(arrModificado.length > 0) gestBtnAceptar(1);
            else gestBtnAceptar(0);
        }
    }

    function buscarInfractor(tipo,idInfractor){
        var filtTipoCedula 	= document.getElementById('filt_nac')		.value;
        var filtCedula 		= document.getElementById('filt_cedula')	.value.toUpperCase();
        var filtNombre 		= document.getElementById('filt_nombre')	.value.toUpperCase();
        var filtApellido 	= document.getElementById('filt_apellido')	.value.toUpperCase();
        var filtAlias 		= document.getElementById('filt_alias')	    .value.toUpperCase();
        var filtBanda 		= document.getElementById('filt_banda')	    .value.toUpperCase();

        if(tipo){
            if(tipo == 'infraccion'){
                $('#btn_infractor_lim').val('Atrás');
                $('#btn_infractor_bus').val('Atrás');
                xajax_buscarInfractor(idInfractor);
            }
        }
        else{
            if((filtCedula == '')&&(filtNombre == '')&&(filtApellido == '')&&(filtAlias == '')&&(filtBanda == '')) {
                alert("ERROR: Debe establecer al menos un parámetro de búsqueda.")
                document.getElementById('filt_cedula').focus();
            }
            else xajax_buscarInfractor(null,filtTipoCedula,filtCedula,filtNombre,filtApellido,filtAlias,filtBanda);
        }
    }

    function modificarInfractor(){
        arrActual['filt_cedula']     = arrActual['filt_cedula'].toUpperCase();
        arrActual['filt_nombre']     = arrActual['filt_nombre'].toUpperCase();
        arrActual['filt_apellido']   = arrActual['filt_apellido'].toUpperCase();
        arrActual['filt_alias']      = arrActual['filt_alias'].toUpperCase();
        arrActual['filt_banda']      = arrActual['filt_banda'].toUpperCase();
        arrActual['filt_telefono']   = arrActual['filt_telefono'].toUpperCase();
        arrActual['filt_direccion']  = arrActual['filt_direccion'].toUpperCase();
        arrActual['filt_foto']       = arrActual['filt_foto'];

        if (confirm('¿Confirmar modificación de datos de infractor?')) xajax_modificarInfractor(arrActual['filt_id'],arrActual['filt_nac'],arrActual['filt_cedula'],arrActual['filt_nombre'],arrActual['filt_apellido'],arrActual['filt_alias'],arrActual['filt_banda'],arrActual['filt_telefono'],arrActual['filt_direccion'],arrActual['filt_foto']);
    }

    function mostrarInfractor(infractorId,infractorNombre,$metroId){
        $('#lista_infractor').addClass('oculto'); 
        $('#ficha_infractor').removeClass('oculto'); 
        $('.modal_titulo').text('- Ficha del Infractor -');

        bloquearFiltros();
        gestionBtnInfractor(1);
        cargarExpediente(infractorId,infractorNombre);

        if($metroId != '') $('.inf-metro').removeClass('oculto');
        $('#exped_infractor').removeClass('oculto');

        if(snPerfUsu == 'MASTER') $('#btn_infractor_rep').removeClass('oculto');
    }

    function bloquearFiltros(){
        $('.frm_0, .frm_1').prop('disabled',true);
        $('.frm_0, .frm_1').removeClass('div-inp-ena').addClass('div-inp-dis');
        $('#filt_nac').prop('disabled',true);
        $('#btn_busq_infractor').prop('disabled',true);
    }

    function buscarCedula(infNac,infCed){
        $('#btn_infractor_lim').click();
        $('#filt_nac')      .val(infNac);
        $('#filt_cedula')   .val(infCed);
        $('#btn_infractor_bus').click();
    }

    function listaInfractor(lista){
        $('#ifr_lista_infractor').attr('src','controlador/infractor/infractor.php?case=2&lista='+lista);
        $('#ficha_infractor').addClass('oculto');
        $('#exped_infractor').addClass('oculto');
        $('#lista_infractor').removeClass('oculto');
    }

    function cargarExpediente(infractorId,infractorNombre){
        var ifr = document.getElementById('ifr_infractor_exp');
        ifr.src = 'controlador/infractor/infractor.php?case=1&infId='+infractorId+"&infNombre="+infractorNombre;
    }

    function gestionBtnInfractor(caso){
        switch (caso){
            case 0: 	
                $('.btn_infractor_0').removeClass('oculto');
                $('.btn_infractor_1').addClass('oculto');
                $('.btn_infractor_2').addClass('oculto');
            break;
            case 1:
                // if(snPerfUsu == 'MASTER') $('#btn_infractor_rep').removeClass('oculto');    //TEMPORAL
                $('.btn_infractor_0').addClass('oculto');
                $('.btn_infractor_1').removeClass('oculto');
                $('.btn_infractor_2').addClass('oculto');
            break;
            case 2: 
                // if(snPerfUsu == 'MASTER') $('#btn_infractor_rep').addClass('oculto');       //TEMPORAL
                $('.btn_infractor_0').addClass('oculto');
                $('.btn_infractor_1').addClass('oculto');
                $('.btn_infractor_2').removeClass('oculto');
            break;
        }
        // if(snPerfUsu != 'MASTER'){
        //     if(!$('#btn_infractor_mod').hasClass('oculto')) $('#btn_infractor_mod').addClass('oculto');
        // }
    }

    function cargarDatos(){
        arrActual['filt_id']         = $('#filt_id').val();
        arrActual['filt_nac']        = $('#filt_nac').val();
        arrActual['filt_cedula']     = $('#filt_cedula').val();
        arrActual['filt_nombre']     = $('#filt_nombre').val();
        arrActual['filt_apellido']   = $('#filt_apellido').val();
        arrActual['filt_alias']      = $('#filt_alias').val();
        arrActual['filt_banda']      = $('#filt_banda').val();
        arrActual['filt_telefono']   = $('#filt_telefono').val();
        arrActual['filt_direccion']  = $('#filt_direccion').val();
        arrActual['filt_foto']       = $('#filt_foto').attr('src').split(",",2)[1] == '' ? '' : $('#filt_foto').attr('src').split(",",2)[1];
        // arrActual['filt_foto_ext']   = $('#filt_foto').attr('src').split(",",2)[1] == '' ? '' : $('#filt_foto').attr('src').split(",",2)[1];
    }

    function restaurarDatos(){
        $('#filt_id')       .val(arrActual['filt_id']);
        $('#filt_nac')      .val(arrActual['filt_nac']);
        $('#filt_cedula')   .val(arrActual['filt_cedula']);
        $('#filt_nombre')   .val(arrActual['filt_nombre']);
        $('#filt_apellido') .val(arrActual['filt_apellido']);
        $('#filt_alias')    .val(arrActual['filt_alias']);
        $('#filt_banda')    .val(arrActual['filt_banda']);
        $('#filt_telefono') .val(arrActual['filt_telefono']);
        $('#filt_direccion').val(arrActual['filt_direccion']);
        $('#filt_foto')     .attr('src',arrActual['filt_foto']);

        arrActual.length = 0;
    }

    function infReincidenciaInf(opc){
        var opc = parseInt(opc);

        switch(opc){
            case 1:
                $('.inf_reincidencia').show();
            break;
            case 2:
                $('.inf_reincidencia').hide();
            break;
        }
    }
    
/* ---------------------------------------------------------------------------------------------------------------- */