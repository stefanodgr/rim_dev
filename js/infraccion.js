/* -------------------------- FUNCIONES JS UTILIZADAS EN EL MÓDULO DE INFRACCIONES -------------------------- */ 
    var arrAct      = new Array();
    var arrMod      = new Array();
    var arrFileFoto = new Array();
    var ctrlActIfr  = false;
    var accion      = null;

    $(document).ready(function(){
        $('#panel_right').on('click','input[name = opc_bus]',function(){    // SELECCIÓN DE BÚSQUEDA
			seleccionBusqueda(this);
		});
        $('#panel_right').on('click','input[name = opc_vic]',function(){    // SELECCIÓN DE TIPO DE VICTIMA
			var tipoPers = $(this).val();
            camposVic(tipoPers);
            $('#btn_invol_lim').click();
		});
		$('#panel_right').on('change','#selLinea',function(){               // CARGA DE SELECT ESTACIONES
			cargarEstacion(1);
		});
        $('#panel_right').on('change','#filt_ubicacion',function(){         // CARGA DE SELECT ESTACIONES
			if(accion != '') cargarEstacion(3);
            else cargarEstacion(2);
		});
        $('#panel_right').on('click','#btn_busq_infraccion',function(){     // BOTÓN BÚSQUEDA DE INFRACCIÓN
			buscarInfraccion();
		});
        $('#panel_right').on('click','#btn_rep_lista',function(){           // BOTÓN REPORTE DE LISTA INFRACCIÓN		
            if(snPerfUsu == 'MASTER'){
                var rutaReporte = 'controlador/infraccion/reporte_lista.php';
                formReporte(rutaReporte);
            }
		});
        $('#panel_right').on('click','#opc_lin_todas',function(){           // LIMPIEZA DE SELECT ESTACIONES
			limpiarEstacion();
		});
        $('#panel_right').on('click','#filt_fecha_inf',function(){          // DISPARADOR DE DATETIMEPICKER AL PULSAR IMAGEN DE CALENDARIO 
            $('#filt_fecha_inf').datetimepicker({
                timepicker: true,
                format: 	'd-m-Y H:i',
                mask:       '39-19-2299 29:59',
                weeks:		true,
                dayOfWeekStart : 1,
                timepickerScrollbar:false
            });
        });
        $('#panel_right').on('click','#btn_filt_fecha_inf',function(){      // DISPARADOR DE DATETIMEPICKER AL PULSAR IMAGEN DE CALENDARIO EN FICHA DE INFRACCIÓN
            if(!$('#filt_fecha_inf').prop('disabled')){
                $('#filt_fecha_inf').datetimepicker({
                    timepicker: true,
                    format: 	'd-m-Y H:i',
                    mask:       '39-19-2299 29:59',
                    weeks:		true,
                    dayOfWeekStart : 1,
                    timepickerScrollbar:false
                });
                $('#filt_fecha_inf').datetimepicker('show');
            }
        });
        $('#panel_right').on('click','#btn_infraccion_mod',function(){      // BOTÓN MODIFICAR INFRACCIÓN
            var estado = $('#filt_estado').val();

            if(estado != 3){
                $('.btn_infraccion_0').addClass('oculto');
                $('.btn_infraccion_1').removeClass('oculto');
                camposInfraccion(1);
                cargarArrActual();
                accion = 'modificar';
            }
        });
        $('#panel_right').on('click','#btn_infraccion_det',function(){      // BOTÓN DETALLES INFRACCIÓN
            var cargarDetalle = gestionBtnDetalle();

            if(cargarDetalle){
                if($('#div_inf_detalles').hasClass('oculto')){
                    $('#div_inf_detalles').removeClass('oculto');
                    $('#btn_infraccion_det').attr('title','Ocultar detalles');
                    redimensionarIframesInf();
                }
                else{
                    $('#div_inf_detalles').addClass('oculto');
                    $('#btn_infraccion_det').attr('title','Mostrar detalles');
                }
            }
        });
        $('#panel_right').on('click','#btn_infraccion_rep',function(){      // BOTÓN REPORTE DE INFRACCIÓN  
            if(snPerfUsu == 'MASTER'){
                var infraccionId = $('#infraccion_id').val();
                var rutaReporte = 'controlador/infraccion/reporte_infraccion.php';
                var arrParam    = new Array(infraccionId);
                formReporte(rutaReporte,arrParam);
            }
        });
        $('#panel_right').on('click','#btn_infraccion_atr',function(){      // BOTÓN ATRÁS DE FICHA DE INFRACCIÓN (VOLVER A LISTADO DE INFRACCIONES)
            if(rastroInfractor != null){
                $('#panel_left #opcion_Infractores').click();
                setTimeout(function(){
                    xajax_buscarInfractor(rastroInfractor);
                    rastroInfractor = null;
                },250);
            }
            else{
                $('#ficha_infraccion').addClass('oculto');
                $('#div_opc').show();
                $('#div_filtros').removeClass('oculto');
                $('#div_infraccion').removeClass('oculto');
                $('#ifr_submit').attr('src','');
                limpiarFichaInfraccion();
                limpiarIfrInfraccion();
                if(ctrlActIfr){
                    recargarIframeInfraccion('inf');
                    ctrlActIfr = false;
                }
                if(!$('#div_inf_detalles').hasClass('oculto')) $('#div_inf_detalles').addClass('oculto');
                window.frames['ifr_infraccion'].$('#tbl').find('.celdaSeleccionada').removeClass('celdaSeleccionada');
                window.frames['ifr_infraccion'].$('#tbl').find('.onCeldaPlus').removeClass('onCeldaPlus');
            }
        });
        $('#panel_right').on('click','#btn_infraccion_ace',function(){      // BOTÓN ACEPTAR MODIFICACIÓN/REGISTRO DE INFRACCIÓN         
            
            var ctrlEstado  = false;
            var infId       = $('#infraccion_id').val();
            var infFecha    = $('#filt_fecha_inf').val();
            var infLugar    = $('#filt_lugar').val();
            var infDesc     = $('#filt_descripcion').val();
            var infAct      = $('#filt_actividad').val();
            var infEstado   = $('#filt_estado').val();
            var infUbic     = $('#filt_ubicacion').val();
            var infUbic2    = $('#filt_ubicacion2').val();

            if(!infFecha){
                alert('ERROR: Debe ingresar la fecha de ocurrencia de la infracción.');
                return false;
            }
            if(!infLugar){
                alert('ERROR: Debe ingresar el lugar de ocurrencia de la actividad.');
                return false;
            }
            if(infAct == 0){
                alert('ERROR: Debe especificar una actividad.');
                return false;
            }
            if((infUbic == 0)||(infUbic2 == 0)){
                alert('ERROR: Debe especificar la ubicación ocurrencia de la actividad.');
                return false;
            }
            if((infDesc == null)||(infDesc == '')){
                alert('ERROR: Debe indicar una breve descripción de la actividad.');
                return false;
            }
            if(infEstado != arrAct['filt_estado']) ctrlEstado = true;
            if(infId){
                if((ctrlEstado)&&(infEstado == 3)){
                    if(confirm('NOTA: Las infracciones con estado <PROCESADO> no podrán ser modificadas nuevamente.\n¿Desea procesar esta infracción?')){
                        xajax_modificarInfraccion(infId,infFecha,infLugar,infDesc,infAct,infEstado,infUbic,infUbic2,ctrlEstado);
                    }
                    else{
                        return false;
                    }
                }
                else{
                    xajax_modificarInfraccion(infId,infFecha,infLugar,infDesc,infAct,infEstado,infUbic,infUbic2,ctrlEstado);
                }
            }
            else xajax_registrarInfraccion(infFecha,infLugar,infDesc,infAct,infUbic,infUbic2);
        });   
        $('#panel_right').on('click','#btn_infraccion_can',function(){      // BOTÓN CANCELAR MODIFICACIÓN/REGISTRO DE INFRACCIÓN
            $('.btn_infraccion_1').addClass('oculto');
            $('.btn_infraccion_0').removeClass('oculto');
            gestionBtnDetalle();
            gestionBtnReporteInf();

            if(accion == 'registrar'){
                $('#btn_infraccion_atr').click();
                limpiarFichaInfraccion();
                $('#titulo_ficha_inf').text('- Ficha de Infracción -');
            } 
            else{
                var idInfraccion = $('#infraccion_id').val()
                limpiarFichaInfraccion();
                window.frames['ifr_infraccion'].document.getElementById(arrAct['infraccion_id']).children[1].click();
            }
            camposInfraccion(2);
            accion = null;
            arrAct.length = 0;
        }); 
        $('#panel_right').on('change','#inv_foto_load',function(e){         // AL DETECTAR CAMBIO EN LA FOTO
			cargarFotoInvol(e,'involucrado');
		});
        $('#panel_right').on('keypress','#inv_cedula',function(e){          // DISPARADOR DE BÚSQUEDA DE INVOLUCRADO POR CÉDULA EN FICHA DE INVOLUCRADO
            if(e.which != 13){									            // SI LA TECLA PULSADA ES DIFERENTE DE LA TECLA ENTER
                if(e.which != 8){ 								            // SI LA TECLA PULSADA ES DIFERENTE DE LA TECLA BORRAR
                    var ctrl = validarCadena(e,'num');
                    return ctrl;
                }
            }
            else{
                buscarInvolucrado('cedula');
            }
        });
        $('#panel_right').on('click','#btn_busq_invol',function(){          // BOTÓN BÚSQUEDA DE INVOLUCRADO DE FICHA DE INVOLUCRADO
            buscarInvolucrado('cedula');
        });
        $('#panel_right').on('keypress','#inv_carne',function(e){           // DISPARADOR DE BÚSQUEDA DE INVOLUCRADO POR CARNÉ EN FICHA DE INVOLUCRADO
            if(e.which == 13){									            // SI LA TECLA PULSADA ES DIFERENTE DE LA TECLA ENTER
                buscarInvolucrado('carne');
            }
        });
        $('#panel_right').on('click','#btn_busq_pers',function(){           // BOTÓN BÚSQUEDA DE INVOLUCRADO DE FICHA DE INVOLUCRADO
            buscarInvolucrado('carne');
        });
        $('#panel_right').on('keypress','#veh_placa',function(e){           // DISPARADOR DE BÚSQUEDA DE PLACA EN FICHA DE VEHÍCULO
            if(e.which == 13){									            // SI LA TECLA PULSADA ES DIFERENTE DE LA TECLA ENTER
                buscarPlaca();
            }
        });
        $('#panel_right').on('click','#btn_busq_placa',function(){          // BOTÓN BÚSQUEDA DE PLACA DE FICHA DE VEHÍCULO
            buscarPlaca();
        });
        $('#panel_right').on('click','#btn_doc_fecha',function(){           // DISPARADOR DE DATETIMEPICKER AL PULSAR IMAGEN DE CALENDARIO EN FICHA DE DOCUMENTO         
            $('#doc_fecha').datetimepicker({
                timepicker: false,
                format: 	'd-m-Y',
                mask:       '39-19-2299',
                weeks:		true,
                dayOfWeekStart : 1,
                timepickerScrollbar:false
            });
            $('#doc_fecha').datetimepicker('show');
        });
        $('#panel_right').on('click','#btn_sanc_fecha',function(){          // DISPARADOR DE DATETIMEPICKER AL PULSAR IMAGEN DE CALENDARIO EN FICHA DE SANCIÓN         
            $('#sanc_fecha').datetimepicker({
                timepicker: false,
                format: 	'd-m-Y',
                mask:       '39-19-2299',
                weeks:		true,
                dayOfWeekStart : 1,
                timepickerScrollbar:false
            });
            $('#sanc_fecha').datetimepicker('show');
        });
        $('#panel_right').on('click','#btn_invol_agr',function(){           // BOTÓN AGREGAR DE FICHA DE INVOLUCRADO
            agregarInvolucrado();
        });
        $('#panel_right').on('click','#btn_doc_agr',function(){             // BOTÓN AGREGAR DE FICHA DE DOCUMENTO
            agregarDocumento();
        });
        $('#panel_right').on('click','#btn_mat_agr',function(){             // BOTÓN AGREGAR DE FICHA DE MATERIAL COMISADO
            agregarMaterial();
        });
        $('#panel_right').on('click','#btn_med_agr',function(){             // BOTÓN AGREGAR DE FICHA DE MEDIO DE COMISIÓN
            agregarMedio();
        });
        $('#panel_right').on('click','#btn_veh_agr',function(){             // BOTÓN AGREGAR DE FICHA DE VEHÍCULO
            agregarVehiculo();
        });
        $('#panel_right').on('click','#btn_san_apl',function(){             // BOTÓN APLICAR DE FICHA DE DE SANCIONES Y MEDIDAS
            cargarArrSanMed(1);
            
            if($('.fi_san').is(":visible")){    // SE ESTÁ APLICANDO SANCIÓN
                var tipo = 'sancion';
                if(arrMod['selSancion'] == '0'){
                    alert("ERROR: Debe seleccionar una SANCIÓN.");
                    return false
                }
            }
            else{                               // SE ESTÁ APLICANDO MEDIDA CAUTELAR
                var tipo = 'medida';
                if(arrMod['selMedida'] == '0'){
                    alert("ERROR: Debe seleccionar una MEDIDA CAUTELAR.");
                    return false
                }
            }
            if(arrMod['sanc_fecha'] == ''){
                if(tipo == 'sancion') alert("ERROR: Debe definir la fecha en que fue aplicada la sanción");
                else alert("ERROR: Debe definir la fecha en que fue aplicada la medida cautelar");
                return false
            }
            xajax_aplicarSancionMedida(tipo,arrMod);
        });
        $('#panel_right').on('click','#btn_invol_atr',function(){           // BOTÓN ATRÁS DE FICHA DE INVOLUCRADO (VOLVER A FICHA DE INFRACCIÓN)
            $('#ficha_involucrado').addClass('oculto');
            $('#ficha_infraccion').removeClass('oculto');
            $('#inv_cedula').removeClass('busq_det busq_vic busq_fun busq_per');
            restaurarFichaInvol();
        });
        $('#panel_right').on('click','#btn_doc_atr',function(){             // BOTÓN ATRÁS DE FICHA DE DOCUMENTO (VOLVER A FICHA DE INFRACCION)
            $('#ficha_documento').addClass('oculto');
            $('#ficha_infraccion').removeClass('oculto');
            restaurarFichaDoc();
        });
        $('#panel_right').on('click','#btn_mat_atr',function(){             // BOTÓN ATRÁS DE FICHA DE MATERIAL COMISADO (VOLVER A FICHA DE INFRACCION)
            $('#ficha_material').addClass('oculto');
            $('#ficha_infraccion').removeClass('oculto');
            restaurarFichaMat();
        });
        $('#panel_right').on('click','#btn_med_atr',function(){             // BOTÓN ATRÁS DE FICHA DE MEDIO DE COMISIÓN (VOLVER A FICHA DE INFRACCION)
            $('#ficha_medio').addClass('oculto');
            $('#ficha_infraccion').removeClass('oculto');
            restaurarFichaMed();
        });
        $('#panel_right').on('click','#btn_veh_atr',function(){             // BOTÓN ATRÁS DE FICHA DE VEHÍCULO (VOLVER A FICHA DE INFRACCION)
            $('#ficha_vehiculo').addClass('oculto');
            $('#ficha_infraccion').removeClass('oculto');
            restaurarFichaVeh(true);
        });
        $('#panel_right').on('click','#btn_san_atr',function(){             // BOTÓN ATRÁS DE FICHA DE SANCIONES Y MEDIDAS
            $('#ficha_sancion_medida').addClass('oculto');
            $('#ficha_infraccion').removeClass('oculto');
            restaurarFichaSan();
            arrAct.length = 0;
            arrMod.length = 0;
        });
        $('#panel_right').on('click','#btn_invol_lim',function(){           // BOTÓN LIMPIAR DE FICHA DE INVOLUCRADO
            limpiarFichaInvol();
            deshabilitarCamposInvol();
            infReincidencia(2);
        }); 
        $('#panel_right').on('click','#btn_veh_lim',function(){             // BOTÓN LIMPIAR DE FICHA DE VEHÍCULO
            restaurarFichaVeh(true);
            $('#veh_placa').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        });
        $('#panel_right').on('click','#btn_infraccion_upload',function(){   // BOTÓN GUARDAR EVIDENCIA DE INFRACCIÓN
            var infraccionId = $('#infraccion_id').val();
            $('#form_file').attr('action','controlador/infraccion/infraccion.php?case=3&activId='+infraccionId);
            $('#form_file').submit();
        });
        $('#panel_right').on('click','.fileuploader-item-inner',function(){ // CLICK EN FOTO EVIDENCIA
            var src = $(this).find('img').attr('src');

            $('.preview').css('visibility','visible');
            $('.contenido').addClass('oculto');

            $('.img-preview').attr('src',src);
        });
        
	});
    function seleccionBusqueda(opcion){
        if(opcion.value == 'basica') $('.avanzado').addClass('oculto');
        else $('.avanzado').removeClass('oculto');
    }
    function buscarInfraccion(){
        var filtActividad   = $('#selActividad').val();
        var filtEstado      = $('#selStatus').val();
        var filtLinea       = $('#selLinea').val();
        var filtEstacion    = $('#sel_estacion').val();
        var filtDesde       = $('#f_desde').val();
        var filtHasta       = $('#f_hasta').val();
        var filtRim         = $('#filt_rim').val();

        arrFiltros    = new Array();
        arrFiltros[0] = filtActividad;
        arrFiltros[1] = filtEstado;
        arrFiltros[2] = filtLinea;
        arrFiltros[3] = filtEstacion;
        arrFiltros[4] = filtDesde;
        arrFiltros[5] = filtHasta;
        arrFiltros[6] = filtRim;

        // alert(filtActividad+" --"+filtEstado+" --"+filtLinea+" --"+filtEstacion+" --"+filtDesde+" --"+filtHasta+" --"+filtRim);

        var opcion = document.getElementsByName('opc_bus');
        if(opcion[0].checked){
            $('#ifr_infraccion').attr('src','controlador/infraccion/infraccion.php?case=1&tipo=basica&filtros='+arrFiltros);
        }
        else{
            $('#ifr_infraccion').attr('src','controlador/infraccion/infraccion.php?case=1&tipo=avanzada&filtros='+arrFiltros);
        }
    }
    function aceptarGestInfraccion(opc,infraccionId,arrEvidencia){
        $('.btn_infraccion_1').addClass('oculto');
        $('.btn_infraccion_0').removeClass('oculto');
        gestionBtnDetalle();
        gestionBtnReporteInf();
        camposInfraccion(2);
        arrAct.length = 0;
        ctrlActIfr = true;
        accion = null;

        opc = parseInt(opc);
        switch(opc){
            case 1:
                $('#titulo_ficha_inf').text('- Ficha de Infracción -');
                xajax_buscarInfraccion(infraccionId);
            break;
            case 2:
                $('#btn_infraccion_mod').addClass('oculto');
                var idInfraccion = $('#infraccion_id').val();
                cargarIfrInfraccion(idInfraccion,'PROCESADO');
                xajax_cargarEvidencia(idInfraccion,'PROCESADO');
            break;
        }
    }
    function cargarIfrInfraccion(idInfraccion,estado){

        var cargarDetalle = gestionBtnDetalle();
        gestionBtnReporteInf();
        
        if(estado == 'PROCESADO'){
            if(!$('#btn_infraccion_mod').hasClass('oculto')) $('#btn_infraccion_mod').addClass('oculto');
        }
        else{
            if($('#btn_infraccion_mod').hasClass('oculto')) $('#btn_infraccion_mod').removeClass('oculto');
        }
        
        if(cargarDetalle){
            $('#ifr_infraccion_det').attr('src','controlador/infraccion/infraccion.php?case=2&idInfraccion='+idInfraccion+'&tipoInvol=DETENIDO&infEstado='+estado);
            $('#ifr_infraccion_vic').attr('src','controlador/infraccion/infraccion.php?case=2&idInfraccion='+idInfraccion+'&tipoInvol=VICTIMA&infEstado='+estado);
            $('#ifr_infraccion_fun').attr('src','controlador/infraccion/infraccion.php?case=2&idInfraccion='+idInfraccion+'&tipoInvol=FUNCIONARIO&infEstado='+estado);
            $('#ifr_infraccion_per').attr('src','controlador/infraccion/infraccion.php?case=2&idInfraccion='+idInfraccion+'&tipoInvol=PERSONAL METRO&infEstado='+estado);
            $('#ifr_infraccion_doc').attr('src','controlador/infraccion/infraccion.php?case=2&idInfraccion='+idInfraccion+'&tipoInvol=DOCUMENTO&infEstado='+estado);
            $('#ifr_infraccion_mat').attr('src','controlador/infraccion/infraccion.php?case=2&idInfraccion='+idInfraccion+'&tipoInvol=MATERIAL&infEstado='+estado);
            $('#ifr_infraccion_med').attr('src','controlador/infraccion/infraccion.php?case=2&idInfraccion='+idInfraccion+'&tipoInvol=MEDIO&infEstado='+estado);
            $('#ifr_infraccion_veh').attr('src','controlador/infraccion/infraccion.php?case=2&idInfraccion='+idInfraccion+'&tipoInvol=VEHICULO&infEstado='+estado);
        }
        else $('#btn_infraccion_det').addClass('oculto');
    }
    function cargarEvidenciaInfraccion(arrEvidencia,estado,cantidad){
        $('.area_titulo_foot').empty();

        if(estado == 'PROCESADO'){
            var html = '<div>Total: '+cantidad+' registro(s)</div>';
            $('.area_titulo_foot').prepend(html);
        }
        else{
            var html = '<div id="btnTbl"><input type="image" id="btn_infraccion_upload" class="btn_dtb" src="libreria/hg/images/dtb_guardar.png" title="Guardar Fotos"></div>';
            $('.area_titulo_foot').prepend(html);
        }

        $('.fileuploader').remove();
        arrEvidencia = JSON.parse(arrEvidencia);
        cargarSubmitFoto(arrEvidencia,estado);
    }
    function limpiarFichaInfraccion(){
        $('#infraccion_id')     .val('');
        $('#filt_usuario')      .val('');
        $('#filt_registro')     .val('');
        $('#filt_fecha_inf')    .val('');
        $('#filt_rim_inf')      .val('');
        $('#filt_lugar')        .val('');
        $('#filt_descripcion')  .val('');
        document.getElementById('filt_actividad')   .options[0].selected = 'selected';
        document.getElementById('filt_estado')      .options[0].selected = 'selected';
        document.getElementById('filt_ubicacion')   .options[0].selected = 'selected';
        $('#col_filt_ubicacion2').empty();
        $('#fila_aux_ubi').addClass('oculto');
    }
    function limpiarIfrInfraccion(){
        $('#ifr_infraccion_det').attr('src','').parent().parent().css('height','40px');
        $('#ifr_infraccion_vic').attr('src','').parent().parent().css('height','40px');
        $('#ifr_infraccion_fun').attr('src','').parent().parent().css('height','40px');
        $('#ifr_infraccion_per').attr('src','').parent().parent().css('height','40px');
        $('#ifr_infraccion_doc').attr('src','').parent().parent().css('height','40px');
        $('#ifr_infraccion_mat').attr('src','').parent().parent().css('height','40px');
        $('#ifr_infraccion_med').attr('src','').parent().parent().css('height','40px');
        $('#ifr_infraccion_veh').attr('src','').parent().parent().css('height','40px');
    }
    function redimensionarIframesInf(){
        window.frames['ifr_infraccion_det'].dimensiones();
        window.frames['ifr_infraccion_vic'].dimensiones();
        window.frames['ifr_infraccion_fun'].dimensiones();
        window.frames['ifr_infraccion_per'].dimensiones();
        window.frames['ifr_infraccion_doc'].dimensiones();
        window.frames['ifr_infraccion_mat'].dimensiones();
        window.frames['ifr_infraccion_med'].dimensiones();
        window.frames['ifr_infraccion_veh'].dimensiones();
    }
    function gestionBtnDetalle(){
        var estado = $('#filt_estado').val();

        if(estado == 3){
            if((snPerfUsu != 'MASTER') && (snPerfUsu != 'GERENCIAL')) var cargarDetalle = false;
            else var cargarDetalle = true;
        }
        else var cargarDetalle = true;

        if(cargarDetalle) $('#btn_infraccion_det').removeClass('oculto');
        else $('#btn_infraccion_det').addClass('oculto');

        return cargarDetalle;
    }
    function gestionBtnReporteInf(){
        if((snPerfUsu == 'MASTER') || (snPerfUsu == 'GERENCIAL')) $('#btn_infraccion_rep').removeClass('oculto');
        else $('#btn_infraccion_rep').addClass('oculto');
    }
    function cargarArrActual(){
        arrAct['infraccion_id']   = $('#infraccion_id').val();
        arrAct['filt_usuario']    = $('#filt_usuario').val();
        arrAct['filt_registro']   = $('#filt_registro').val();
        arrAct['filt_rim_inf']    = $('#filt_rim_inf').val();
        arrAct['filt_fecha_inf']  = $('#filt_fecha_inf').val();
        arrAct['filt_lugar']      = $('#filt_lugar').val();
        arrAct['filt_descripcion']= $('#filt_descripcion').val();
        arrAct['filt_actividad']  = $('#filt_actividad').val();
        arrAct['filt_estado']     = $('#filt_estado').val();
        arrAct['filt_ubicacion']  = $('#filt_ubicacion').val();
        arrAct['filt_ubicacion2'] = $('#filt_ubicacion2').val();
    }
    function cargarArrSanMed(opc){
        opc = parseInt(opc);
        switch(opc){
            case 0:
                arrAct['infraccion_id']     = $('#infraccion_id').val();
                arrAct['infractor_id']      = $('#san_med_infractor_id').val();
                arrAct['rel_san_med_id']    = $('#rel_san_med_id').val();
                arrAct['sanc_fecha']        = $('#sanc_fecha').val();
                arrAct['sanc_observ']       = $('#sanc_observ').val();
                arrAct['selSancion']        = $('#selSancion').val();
                arrAct['selMedida']         = $('#selMedida').val();
            break;
            case 1:
                arrMod['infraccion_id']     = $('#infraccion_id').val();
                arrMod['infractor_id']      = $('#san_med_infractor_id').val();
                arrMod['rel_san_med_id']    = $('#rel_san_med_id').val() ? $('#rel_san_med_id').val() : 0;
                arrMod['sanc_fecha']        = $('#sanc_fecha').val();
                arrMod['sanc_observ']       = $('#sanc_observ').val();
                arrMod['selSancion']        = $('#selSancion').val();
                arrMod['selMedida']         = $('#selMedida').val();
            break;
        }
        
    }
    function restaurarInfraccion(){
        $('#filt_fecha_inf')    .val(arrAct['filt_fecha_inf']);
        $('#filt_lugar')        .val(arrAct['filt_lugar']);
        $('#filt_descripcion')  .val(arrAct['filt_descripcion']);
        $('#filt_actividad')    .val(arrAct['filt_actividad']);
        $('#filt_estado')       .val(arrAct['filt_estado']);
        $('#filt_ubicacion')    .val(arrAct['filt_ubicacion']);
        $('#filt_ubicacion2')   .val(arrAct['filt_ubicacion2']);
    }
    function buscarInvolucrado(tipo){
        
        var nac     = $('#inv_nac').val();
        var cedula  = $('#inv_cedula').val();
        var carne   = $('#inv_carne').val();

        if($('#opc_nat').prop('checked')) var documento = 'cédula'
        else var documento = 'rif'

        switch(tipo){
            case 'cedula':
                if(!cedula){
                    alert('ERROR: Debe ingresar un número de '+documento+' para proceder con la búsqueda.');
                    return false;
                }
            break;
            case 'carne':
                if(!carne){
                    alert('ERROR: Debe ingresar un número de carné para proceder con la búsqueda.');
                    return false;
                }
            break;
        }

        deshabilitarCamposInvol();

        if($('#inv_cedula').hasClass('busq_det')){
            xajax_buscarInvolucrado(nac,cedula,'detenido');
        }
        if($('#inv_cedula').hasClass('busq_vic')){
            xajax_buscarInvolucrado(nac,cedula,'victima');
        }
        if($('#inv_cedula').hasClass('busq_fun')){
            xajax_buscarInvolucrado(nac,cedula,'funcionario');
        }
        if($('#inv_cedula').hasClass('busq_per')){
            var carne = $('#inv_carne').val();
            xajax_buscarPersonal(nac,cedula,carne);
        }
    }
    function mostrarFichaInvol(tipoInvol){
        $('#ficha_infraccion').addClass('oculto');
        $('#ficha_involucrado').removeClass('oculto');

        switch(tipoInvol){
            case 'detenido':
                $('.fi_inv_fun, .fi_inv_per').addClass('oculto');
                $('#ficha_involucrado .modal_titulo').text('- Agregar Detenido -');
                $('#inv_cedula').addClass('busq_det');
            break;
            case 'victima':
                $('.fi_inv_det, .fi_inv_fun, .fi_inv_per, .inv_foto').addClass('oculto');
                $('#ficha_involucrado .modal_titulo').text('- Agregar Víctima -');
                $('#inv_cedula').addClass('busq_vic');
                $('#filt_tipo_pers').removeClass('oculto');
            break;
            case 'funcionario':
                $('.fi_inv_det, .fi_inv_per, .inv_foto').addClass('oculto');
                $('#ficha_involucrado .modal_titulo').text('- Agregar Funcionario -');
                $('#inv_cedula').addClass('busq_fun');
            break;
            case 'personal':
                $('.fi_inv_det, .fi_inv_fun').addClass('oculto');
                $('#ficha_involucrado .modal_titulo').text('- Agregar Personal Metro -');
                $('#inv_cedula').addClass('busq_per');
                $('#inv_carne').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
            break;
        }
    }
    function mostrarFichaDoc(){
        $('#ficha_infraccion').addClass('oculto');
        $('#ficha_documento').removeClass('oculto');
    }
    function mostrarFichaMat(){
        $('#ficha_infraccion').addClass('oculto');
        $('#ficha_material').removeClass('oculto');
    }
    function mostrarFichaMed(){
        $('#ficha_infraccion').addClass('oculto');
        $('#ficha_medio').removeClass('oculto');
    }
    function mostrarFichaVeh(){
        $('#ficha_infraccion').addClass('oculto');
        $('#ficha_vehiculo').removeClass('oculto');
    }
    function gestionFichaSancionMedida(tipo,opc,sujeto){
        $('#ficha_infraccion').addClass('oculto');
        $('#ficha_sancion_medida').removeClass('oculto');
        opc = parseInt(opc);

        if(tipo == 'sancion'){
            switch(opc){
                case 0:
                    $('.tit_sancion').text('- Ficha de Sanción -');
                    $('.fi_med').addClass('oculto');
                    if(sujeto == 'trabajador') $('.sanc_usu').addClass('oculto');
                    else $('.sanc_tra').addClass('oculto');
                break;
            }
        }
        else{
            switch(opc){
                case 0:
                    $('.tit_sancion').text('- Ficha de Medida Cautelar -');
                    $('.fi_san').addClass('oculto');
                break;
            }
        }
    }
    function restaurarFichaInvol(){
        if(!$('#filt_tipo_pers').hasClass('oculto')) $('#filt_tipo_pers').addClass('oculto');
        $('.fi_inv_det, .fi_inv_fun, .fi_inv_per, .inv_foto').removeClass('oculto');
        $('#opc_nat').click();
        $('#btn_invol_agr').prop('disabled',true).addClass('deshabilitado').removeClass('oculto');
        infReincidencia(2);
        limpiarFichaInvol();
        deshabilitarCamposInvol();
    }
    function restaurarFichaDoc(){
        $('#doc_numero').val(''); 
        $('#doc_fecha').val('');
        document.getElementById('selDocumento').options[0].selected='selected';
    }
    function restaurarFichaMat(){
        $('#mat_prec').val(''); 
        $('#mat_cant').val(''); 
        $('#mat_descrip').val(''); 
        document.getElementById('selMaterial').options[0].selected='selected';
        document.getElementById('selUnidad').options[0].selected='selected';
    }
    function restaurarFichaMed(){
        $('#med_prec').val(''); 
        $('#med_cant').val('');
        $('#med_descrip').val(''); 
        document.getElementById('selMedio').options[0].selected='selected';
    }
    function restaurarFichaVeh(bloquear){
        $('#veh_id')        .val(''); 
        $('#veh_placa')     .val('');
        $('#veh_modelo')    .val('');
        $('#veh_color')     .val(''); 
        $('#veh_descrip')   .val(''); 
        document.getElementById('selTipoVehi')  .options[0].selected='selected';
        document.getElementById('selMarca')     .options[0].selected='selected';
        $('#btn_veh_lim').addClass('oculto');

        if(bloquear) camposVeh(3);
    }
    function restaurarFichaSan(){
        $('#rel_san_med_id')        .val(''); 
        $('#san_med_infractor_id')  .val('');
        $('#sanc_fecha')            .val('');
        $('#sanc_observ')           .val('');
        document.getElementById('selSancion')   .options[0].selected='selected';
        document.getElementById('selMedida')    .options[0].selected='selected';
        $('.fi_san, .fi_med, .sanc_usu, .sanc_tra').removeClass('oculto');
    }
    function limpiarFichaInvol(){
        $('#inv_id')       .val('');
        $('#pers_id')      .val('');
        $('#inv_cedula')   .val('').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_carne')    .val('').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_nombre')   .val('');
        $('#inv_apellido') .val('');
        $('#inv_cargo')    .val('');
        $('#inv_placa')    .val('');
        $('#inv_alias')    .val('');
        $('#inv_banda')    .val('');
        $('#inv_telefono') .val('');
        $('#inv_direccion').val(''); 
        $('#inv_nac').prop('disabled',false);
        $('#btn_busq_invol').prop('disabled',false);
        $('#inv_foto').attr('src','multimedia/imagen/infractor/siluetaHombre.png');

        if($('#opc_nat').prop('checked')) document.getElementById('inv_nac').options[0].selected = 'selected';
        else document.getElementById('inv_nac').options[3].selected = 'selected';
        
        document.getElementById('selCuerpo').options[0].selected = 'selected';
        $('#btn_invol_lim').addClass('oculto');
        $('#btn_invol_agr').prop('disabled',true).addClass('deshabilitado');
        infMetro(2);
        infFuncionario(2);


        if($('#inv_cedula').hasClass('busq_det')){
            $('.fi_inv_fun, .fi_inv_per').addClass('oculto');
            $('#inv_foto_load').prop('disabled',false);
        }
        if($('#inv_cedula').hasClass('busq_vic')){
            $('.fi_inv_det, .fi_inv_fun, .fi_inv_per, .inv_foto').addClass('oculto');
        }
        if($('#inv_cedula').hasClass('busq_fun')){
            $('.fi_inv_det, .fi_inv_per, .inv_foto').addClass('oculto');
        }
        if($('#inv_cedula').hasClass('busq_per')){
            $('.fi_inv_det, .fi_inv_fun').addClass('oculto');
        }
    }
    function habilitarAgregar(tipo){
        switch (tipo){
            case '1': // INVOLUCRADO TIPO DETENIDO, VICTIMA O FUNCIONARIO ENCONTRADO EN TABLA INVOLUCRADO
                $('#inv_nac').prop('disabled',true);
                $('#inv_cedula').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#inv_carne').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#btn_invol_agr').prop('disabled',false).removeClass('deshabilitado');
                $('#btn_invol_lim').prop('disabled',false).removeClass('oculto');
                // $('#inv_foto_load').prop('disabled',false).css('cursor','pointer'); //TEMPORAL
            break;
            case '2': // INVOLUCRADO BUSCADO NO ENCONTRADO 
                $('#btn_invol_agr').prop('disabled',false).removeClass('deshabilitado');
                habilitarCamposInvol();
            break;
            case '3':
                $('#inv_nac').prop('disabled',true);
                $('#inv_cedula').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
            break;
        }
    }
    function habilitarCamposInvol(){
        $('#inv_carne')    .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_nombre')   .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_apellido') .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_placa')    .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_alias')    .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_banda')    .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_telefono') .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#inv_direccion').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        $('#selCuerpo').prop('disabled',false).css('cursor','pointer');
        $('#inv_foto_load').prop('disabled',false).css('cursor','pointer');
    }
    function deshabilitarCamposInvol(){
        // $('#inv_carne')    .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        $('#inv_nombre')   .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        $('#inv_apellido') .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        $('#inv_placa')    .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        $('#inv_alias')    .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        $('#inv_banda')    .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        $('#inv_telefono') .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        $('#inv_direccion').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        $('#selCuerpo')    .prop('disabled',true).css('cursor','not-allowed');
        $('#inv_foto_load').prop('disabled',true).css('cursor','allowed');
    }
    function agregarInvolucrado(){
        var infraccionId    = $('#infraccion_id').val();
        var invId           = $('#inv_id').val();
        var persId          = $('#pers_id').val();
        var invNac          = $('#inv_nac').val();
        var invCedula       = $('#inv_cedula').val().trim();
        var invCarne        = $('#inv_carne').val().trim();
        var invNombre       = $('#inv_nombre').val().trim();
        var invApellido     = $('#inv_apellido').val().trim();    
        var invCargo        = $('#inv_cargo').val();
        var invCuerpo       = $('#selCuerpo').val();
        var invPlaca        = $('#inv_placa').val();
        var invAlias        = $('#inv_alias').val().trim();
        var invBanda        = $('#inv_banda').val().trim();
        var invTelefono     = $('#inv_telefono').val().trim();
        var invDireccion    = $('#inv_direccion').val().trim();
        var error           = false;

        /*if(persId){
            var invFoto     = $('#inv_foto').attr('src') == 'multimedia/imagen/infractor/siluetaHombre.png' ? '' : $('#inv_foto').attr('src');
            var segmento    = invFoto.split('.');
            var longitud    = segmento.length;
            var invFotoExt  = segmento[longitud - 1].toLowerCase();
        }*/
        if((!persId) || (persId == 0)){
            var invFoto     = $('#inv_foto').attr('src') == 'multimedia/imagen/infractor/siluetaHombre.png' ? '' : $('#inv_foto').attr('src').split(",",2)[1];
            var invFotoExt  = $('#inv_foto').attr('name');
        }
        
        if(invCedula == '') {
            alert("ERROR: El campo CÉDULA no puede estar vacío.");
            return false;
        }
        if(invNombre == '') {
            alert("ERROR: El campo NOMBRE no puede estar vacío.");
            return false;
        }
        if(invApellido == '') {
            if($('#opc_nat').prop('checked')){
                alert("ERROR: El campo APELLIDO no puede estar vacío.");
                return false;
            }
        }
        
        if($('#inv_cedula').hasClass('busq_det')) var tipoInvol = 1;
        if($('#inv_cedula').hasClass('busq_vic')) var tipoInvol = 3;
        if($('#inv_cedula').hasClass('busq_fun')) var tipoInvol = 5;
        if($('#inv_cedula').hasClass('busq_per')) var tipoInvol = 4;
        
        xajax_agregarInvolucrado(tipoInvol,infraccionId,invId,persId,invNac,invCedula,invCarne,invNombre,invApellido,invFotoExt,invCargo,invCuerpo,invPlaca,invAlias,invBanda,invTelefono,invDireccion,invFoto);
    }
    function agregarDocumento(){
        var infraccionId    = $('#infraccion_id').val();
        var tipoDoc         = $('#selDocumento').val();
        var numDoc          = $('#doc_numero').val();
        var fechaDoc        = $('#doc_fecha').val();

        if(tipoDoc == 0){
            alert("ERROR: Debe elegir un tipo de documento.");
            return false;
        }
        if(!numDoc){
            alert("ERROR: Debe especificar el número de identificación del documento.");
            return false;
        }
        if(!fechaDoc){
            alert("ERROR: Debe especificar la fecha de elaboración del documento.");
            return false;
        }
        xajax_agregarDocumento(infraccionId,tipoDoc,numDoc,fechaDoc);
    }
    function agregarMaterial(){ 
        var infraccionId    = $('#infraccion_id').val();
        var idMat           = $('#selMaterial').val();
        var cantMat         = $('#mat_cant').val();
        var uniMat          = $('#selUnidad').val();
        var precMat         = $('#mat_prec').val();
        var descMat         = $('#mat_descrip').val();

        if(idMat == 0){
            alert("ERROR: Debe elegir un tipo de material.");
            return false;
        }
        if(!cantMat){
            alert("ERROR: Debe especificar la cantidad del tipo de material comisado.");
            return false;
        }
        if(uniMat == 0){
            alert("ERROR: Debe especificar la unidad de medida del tipo de material comisado.");
            return false;
        }
        // alert(idMat+" -- "+cantMat+" -- "+uniMat+" -- "+precMat+" -- "+descMat);
        xajax_agregarMaterial(infraccionId,idMat,cantMat,uniMat,precMat,descMat,'material');
    }
    function agregarMedio(){ 
        var infraccionId    = $('#infraccion_id').val();
        var idMed           = $('#selMedio').val();
        var cantMed         = $('#med_cant').val();
        var precMed         = $('#med_prec').val();
        var descMed         = $('#med_descrip').val();

        if(idMed == 0){
            alert("ERROR: Debe elegir un tipo de medio de comisión.");
            return false;
        }
        if(!cantMed){
            alert("ERROR: Debe especificar la cantidad del tipo de medio de comisión incautado.");
            return false;
        }
        // alert(idMed+" -- "+cantMed+" -- "+precMed+" -- "+descMed);
        xajax_agregarMaterial(infraccionId,idMed,cantMed,null,precMed,descMed,'medio');
    }
    function agregarVehiculo(){
        var infraccionId    = $('#infraccion_id').val();
        var idVeh           = $('#veh_id').val();
        var placaVeh        = $('#veh_placa').val();
        var modelVeh        = $('#veh_modelo').val();
        var colorVeh        = $('#veh_color').val();
        var descVeh         = $('#veh_descrip').val();
        var tipoVeh         = $('#selTipoVehi').val();
        var marcaVeh        = $('#selMarca').val();

        if(!placaVeh){
            alert("ERROR: Debe ingresar la placa del vehículo.");
            return false;
        }
        if(tipoVeh == 0){
            alert("ERROR: Debe especificar el tipo de vehículo.");
            return false;
        }
        if(marcaVeh == 0){
            alert("ERROR: Debe especificar la marca del vehículo.");
            return false;
        }
        if(!modelVeh){
            alert("ERROR: Debe especificar el modelo del vehículo.");
            return false;
        }
        if(!colorVeh){
            alert("ERROR: Debe especificar el modelo del vehículo.");
            return false;
        }

        // alert(idVeh+" -- "+placaVeh+" -- "+modelVeh+" -- "+colorVeh+" -- "+descVeh+" -- "+tipoVeh+" -- "+marcaVeh);
        xajax_agregarVehiculo(infraccionId,idVeh,placaVeh,modelVeh,colorVeh,descVeh,tipoVeh,marcaVeh);
    }
    function buscarPlaca(){
        var placa = $('#veh_placa').val();

        if(!placa){
            alert('ERROR: Debe ingresar una placa para proceder con la búsqueda.');
            return false;
        }

        camposVeh(3);
        xajax_buscarPlaca(placa);
    }
    function infMetro(opcion){
        if(opcion == '1') {
            $('.inf-metro-inv').removeClass('oculto');
            $('.fi_inv_per').removeClass('oculto');
        }
        else $('.inf-metro-inv').addClass('oculto');
    }
    function infFuncionario(opcion){
        if(opcion == '1') {
            $('.inf-func-inv').removeClass('oculto');
            $('.fi_inv_fun').removeClass('oculto');
        }
        else $('.inf-func-inv').addClass('oculto');
    }
    function infReincidencia(opc){
        var opc = parseInt(opc);

        switch(opc){
            case 1:
                $('.inf-rei-inv').removeClass('oculto');
            break;
            case 2:
                $('.inf-rei-inv').addClass('oculto');
            break;
        }
    }
    function camposInfraccion(opc){
        opc = parseInt(opc);
        switch (opc){
            case 1:
                $('#filt_fecha_inf').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#filt_lugar').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#filt_descripcion').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#filt_actividad').prop('disabled',false);
                $('#filt_estado').prop('disabled',false);
                $('#filt_ubicacion').prop('disabled',false);
                $('#filt_ubicacion2').prop('disabled',false);
            break;
            case 2:
                $('#filt_fecha_inf').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#filt_lugar').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#filt_descripcion').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#filt_actividad').prop('disabled',true);
                $('#filt_estado').prop('disabled',true);
                $('#filt_ubicacion').prop('disabled',true);
                $('#filt_ubicacion2').prop('disabled',true);
            break;
            case 3:
                $('#filt_fecha_inf').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#filt_lugar').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#filt_descripcion').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#filt_actividad').prop('disabled',false);
                $('#filt_ubicacion').prop('disabled',false);
                $('#filt_ubicacion2').prop('disabled',false);
            break;
        }
    }
    function camposVic(opc){
        if(opc == 'natural'){
            $('#inv_tipo_pers').val('Cédula:');
            $('.vic_jur').addClass('oculto');
            $('.vic_nat').removeClass('oculto');
            document.getElementById('inv_nac').options[0].selected = 'selected';
        }
        else{
            $('#inv_tipo_pers').val('RIF:');
            $('.vic_nat').addClass('oculto');
            $('.vic_jur').removeClass('oculto');
            document.getElementById('inv_nac').options[3].selected = 'selected';
        }
    }
    function camposMetro(opc){
        if(opc == '1'){
            $('.fi_inv_per .inv_per').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        }
        else{
            $('.fi_inv_per .inv_per, #inv_nombre, #inv_apellido').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
            $('#inv_foto_load').prop('disabled',true);
        }
    }
    function camposFunc(opc){
        if(opc == '1'){
            $('.fi_inv_fun .inv_fun').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
            $('#selCuerpo').prop('disabled',false).css('cursor','pointer');
        }
        else{
            $('.fi_inv_fun .inv_func').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
            $('#selCuerpo').prop('disabled',true).css('cursor','not-allowed');
            $('#inv_foto_load').prop('disabled',true);
        }
    }
    function camposDet(opc){
        if(opc == '1'){
            $('.fi_inv_det .inv_det').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
        }
        else{
            $('.fi_inv_det .inv_det').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
        }
    }
    function camposGeneral(opc){
        opc = parseInt(opc);

        switch(opc){
            case 1:
                $('.inv_gen').removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#inv_foto_load').prop('disabled',false);
            break;
            case 2:
                $('.inv_gen').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#btn_invol_lim').addClass('oculto');
                $('#inv_foto_load').prop('disabled',true);
            break;
            case 3:
                $('#inv_nac').prop('disabled',true);
                $('#inv_cedula').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#btn_invol_lim').removeClass('oculto');
            break;
            case 4:
                $('#inv_nombre, #inv_apellido, #inv_telefono, #inv_direccion').removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#inv_foto_load').prop('disabled',true);
            break;
        }
    }
    function camposVeh(opc){
        opc = parseInt(opc);
        switch(opc){
            case 1:   // HABILITA CAMPO DESCRIPCION
                $('#veh_placa')     .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#veh_descrip')   .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#btn_veh_lim')   .removeClass('oculto');
            break;
            case 2:   // HABILITA CAMPOS
                $('#veh_color')     .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#veh_modelo')    .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#veh_descrip')   .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#selTipoVehi')   .prop('disabled',false);
                $('#selMarca')      .prop('disabled',false);
                restaurarFichaVeh();
            break;
            case 3:   // DESHABILITA CAMPOS
                $('#veh_placa')     .removeClass('div-inp-dis').addClass('div-inp-ena').prop('disabled',false);
                $('#veh_color')     .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#veh_modelo')    .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#veh_descrip')   .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#selTipoVehi')   .prop('disabled',true);
                $('#selMarca')      .prop('disabled',true);
            break;
            case 4:   // DESHABILITA CAMPO PLACA
                $('#veh_placa')     .removeClass('div-inp-ena').addClass('div-inp-dis').prop('disabled',true);
                $('#btn_veh_lim')   .removeClass('oculto');
            break;
        }
    }
    function recargarIframeInfraccion(opc){
        switch (opc){
            case 'inf': // LISTA DE INFRACCIONES
                window.frames['ifr_infraccion'].recargar();
            break;
            case '1':   // DETENIDO
                window.frames['ifr_infraccion_det'].recargar();
            break;
            case '3':   // VÍCTIMA
                window.frames['ifr_infraccion_vic'].recargar();
            break;
            case '5':   // FUNCIONARIO
                window.frames['ifr_infraccion_fun'].recargar();
            break;
            case '4':   // PERSONAL METRO
                window.frames['ifr_infraccion_per'].recargar();
            break;
            case 'doc': // DOCUMENTO
                window.frames['ifr_infraccion_doc'].recargar();
            break;
            case 'mat': // MATERIAL COMISAD0
                window.frames['ifr_infraccion_mat'].recargar();
            break;
            case 'med': // MEDIO DE COMISIÓN
                window.frames['ifr_infraccion_med'].recargar();
            break;
            case 'veh': // VEHÍCULO
                window.frames['ifr_infraccion_veh'].recargar();
            break;
        }
    }
    function cargarSubmitFoto(arrEvidencia,estado){
        var inputFiles = '<input type="file" name="files">';
        $("#form_file").prepend(inputFiles);

        $('input[name="files"]').fileuploader({
            extensions: ['jpg','jpeg','png'],
            changeInput: ' ',
            limit: 8,
            theme: 'thumbnails',
            enableApi: true,
            addMore: true,
            listInput: true,
            itemPrepend: false,
            files: arrEvidencia,
            thumbnails:{
                box: '<div class="fileuploader-items">' +
                        '<ul class="fileuploader-items-list">' +
                            '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner">+</div></li>' +
                        '</ul>' +
                    '</div>',
                item: '<li class="fileuploader-item">' +
                        '<div class="fileuploader-item-inner">' +
                            '<div class="thumbnail-holder">${image}</div>' +
                            '<div class="actions-holder">' +
                                '<a class="fileuploader-action fileuploader-action-remove" title="Remove"><i class="remove"></i></a>' +
                            '</div>' +
                            '<div class="progress-holder">${progressBar}</div>' +
                        '</div>' +
                    '</li>',
                item2: '<li class="fileuploader-item">' +
                        '<div class="fileuploader-item-inner">' +
                            '<div class="thumbnail-holder">${image}</div>' +
                            '<div class="actions-holder">' +
                                '<a class="fileuploader-action fileuploader-action-remove" title="Remove"><i class="remove"></i></a>' +
                            '</div>' +
                        '</div>' +
                    '</li>',
                startImageRenderer: true,
                canvasImage: false,
                _selectors: {
                    list:   '.fileuploader-items-list',
                    item:   '.fileuploader-item',
                    start:  '.fileuploader-action-start',
                    retry:  '.fileuploader-action-retry',
                    remove: '.fileuploader-action-remove'
                },
                onItemShow: function(item, listEl){
                    if(estado == 'PROCESADO'){
                        $('.fileuploader-thumbnails-input').remove();
                        $('.actions-holder').remove();
                    }     
                    else{
                        var cantImagenes = listEl[0].childElementCount;
                    
                        var plusInput = listEl.find('.fileuploader-thumbnails-input');
                        plusInput.insertAfter(item.html);
                        
                        if(item.format == 'image') {
                            item.html.find('.fileuploader-item-icon').hide();
                        }

                        if(cantImagenes == 9){
                            $('.fileuploader-thumbnails-input').css('display','none');   
                        }
                    }  
                },
            },
            afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));
            
                plusInput.on('click', function() {
                    api.open();
                });
                
                var cantImagenes = listEl[0].childElementCount;
                if(cantImagenes >= 9){
                    $('.fileuploader-thumbnails-input').css('display','none'); 
                }               
            },
            onRemove: function(item, listEl, parentEl, newInputEl, inputEl){
                if(item.appended){
                    var infraccionId = $('#infraccion_id').val();
                    xajax_removerEvidencia(item.name,infraccionId);
                }
                if(!$('.fileuploader-thumbnails-input').is(":visible")) $('.fileuploader-thumbnails-input').css('display','inline-block');
                return true;
            },
            captions: {
                button: function(options) { return 'Choose ' + (options.limit == 1 ? 'File' : 'Files'); },
                feedback: function(options) { return 'Choose ' + (options.limit == 1 ? 'file' : 'files') + ' to upload'; },
                feedback2: function(options) { return options.length + ' ' + (options.length > 1 ? ' files were' : ' file was') + ' chosen'; },
                drop: 'Drop the files here to Upload',
                paste: '<div class="fileuploader-pending-loader"><div class="left-half" style="animation-duration: ${ms}s"></div><div class="spinner" style="animation-duration: ${ms}s"></div><div class="right-half" style="animation-duration: ${ms}s"></div></div> Pasting a file, click here to cancel.',
                removeConfirmation: '¿Confirmar la eliminación de esta imagen?',
                errors: {
                    filesLimit:     'ERROR: Solo puede cargar ${limit} archivos.',
                    filesType:      'ERROR: Solo puede cargar imagenes con extensión ${extensions}.',
                    fileSize:       'ERROR: El archivo ${name} es muy pesado! El tamaño maximo por archivo es de ${fileMaxSize}MB.',
                    filesSizeAll:   'ERROR: Files that you choosed are too large! Please upload files up to ${maxSize} MB.',
                    fileName:       'ERROR: Ya se encuentra cargado otro archivo con el nombre ${name}.',
                    folderUpload:   'ERROR: No está permitida la carga de carpetas.'
                }
            }
        });
    }
/* ---------------------------------------------------------------------------------------------------------- */