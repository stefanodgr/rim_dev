/* ------------------------------------ FUNCIONES JS UTILIZADAS EN TODO EL SISTEMA ------------------------------------ */
    var rastroInfractor     = null;
    var rastroInfraccion    = null;

    $(document).ready(function() {     
        $('#panel_right').on('click','#toggle_menu',function(){
            if($('#panel_left').hasClass('toggle_activo')){
                $(this).removeClass('rotar');
                $('#panel_left').removeClass('toggle_activo');
                $("#panel_left").animate({
                    // 'left': "0px"
                });
                var anchoActual = $("#panel_right").width();
                var anchoNvo = anchoActual - 285;
                $("#panel_right").animate({
                    'width':anchoNvo,
                    'left': "285px"
                });
            }
            else{
                $(this).addClass('rotar');
                $('#panel_left').addClass('toggle_activo');
                $("#panel_left").animate({
                    // 'left': "-300px"
                });
                $("#panel_right").animate({
                    'left': "0px",
                    'width':"100%"
                });
            }
        });
        $('#panel_right').on('click','#btn_f_desde',function(){
            $('#f_desde').datetimepicker({
                timepicker: false,
                format: 	'd/m/Y',
                weeks:		true,
                dayOfWeekStart : 1,
                timepickerScrollbar:false,
                onShow:function( ct ){
                    this.setOptions({
                        maxDate:jQuery('#f_hasta').val()?jQuery('#f_hasta').val():false
                    })
                }
            });
            $('#f_desde').datetimepicker('show');
        });
        $('#panel_right').on('click','#btn_f_hasta',function(){
            $('#f_hasta').datetimepicker({
                timepicker: false,
                format: 	'd/m/Y',
                weeks:		true,
                dayOfWeekStart : 1,
                timepickerScrollbar:false,
                onShow:function( ct ){
                    this.setOptions({
                        minDate:jQuery('#f_desde').val()?jQuery('#f_desde').val():false
                    })
                }
            });
            $('#f_hasta').datetimepicker('show');
        });
        $('#panel_right').on('click','.img_inf',function(e){                // AL HACER CLICK EN LA FOTO
            var src         = $(this).attr('src');
            var silueta     = 'multimedia/imagen/infractor/siluetaHombre.png';
            
			if(src != silueta){
                $('.contenido').addClass('oculto');
                $('.preview').css('visibility','visible');
                $('.img-preview').attr('src',src);
            }
		});
        $('#panel_right').on('click','.img-preview',function(){             // AL HACER CLICK EN LA VISTA PREVIA DE LA FOTO
            $('.preview').css('visibility','hidden');
            $('.img-preview').attr('src','');
            $('.contenido').removeClass('oculto');
		});
    });
	function dimensionDtb(dtb,ancho,alto){
        switch(dtb){
            case 'exp': 
                $('#ifr_infractor_exp').parent().parent().css('height',alto);
            break;
            case 'inf': 
                $('#ifr_infraccion').parent().css('height',alto);
            break;
            case 'aud':
                $('#ifr_aud').parent().css('height',alto);
            break; 
            case 'ref':
                $('#ifr_ref').parent().css('height',alto);
            break;
            case 'ubi':
                $('#ifr_ref').parent().css('height',alto);
            break; 
            case 'lug':
                $('#ifr_ref_aux').parent().css('height',alto);
            break;
            case 'det':
                $('#ifr_infraccion_det').parent().parent().css('height',alto);
            break; 
            case 'vic':
                $('#ifr_infraccion_vic').parent().parent().css('height',alto);
            break;
            case 'fun':
                $('#ifr_infraccion_fun').parent().parent().css('height',alto);
            break;
            case 'per':
                $('#ifr_infraccion_per').parent().parent().css('height',alto);
            break;
            case 'doc':
                $('#ifr_infraccion_doc').parent().parent().css('height',alto);
            break;
            case 'mat':
                $('#ifr_infraccion_mat').parent().parent().css('height',alto);
            break;
            case 'med':
                $('#ifr_infraccion_med').parent().parent().css('height',alto);
            break;
            case 'veh':
                $('#ifr_infraccion_veh').parent().parent().css('height',alto);
            break;
            case 'con':
                $('#ifr_conexion').parent().css('height',alto + 20);
            break;
        }
	}
    function apertura(siglas,idReg,elementTr,elementTd){
        switch (siglas){
            case 'exp':
                rastroInfractor = $('#filt_id').val();
                
                $('#panel_left #opcion_Infracciones').click();
                setTimeout(function(){
                    cargarInfraccion(idReg)
                },250);
                
            break;
            case 'ubi':
                $("#div_ref").animate({
                    'width': "48.9%",
                    'left':'0%'
                });
                window.frames['ifr_ref'].dimensiones();
                $('#div_ref_aux').show();
                $('#ifr_ref_aux').attr('src','controlador/referencial/referencial.php?case=8&ubiId='+idReg);
                $('#ifr_ref').blur();
                
            break;
            case "inf":
                cargarInfraccion(idReg)
            break;
            case 'lis':
            break;
            case 'det':
                var celda           = $(elementTd).index();
                var infraccionId    = $('#infraccion_id').val();

                switch (celda){
                    case 1:
                        // rastroInfraccion = infraccionId;
                        // $('#panel_left #opcion_Infractores').click();
                        // setTimeout(function(){
                        //     buscarInfractor('infraccion',idReg);
                        // },250);

                        var nroCedula   = '';
                        var cedula      = $(elementTd).text();
                        var fragmento   = cedula.split('');
                        var nac         = fragmento[0];

                        for(var i=0; i<fragmento.length; i++){
                            if(i > 0) nroCedula += fragmento[i];
                        }
                        
                        agregar('det');
                        $('#btn_busq_invol').prop('disabled',true);
                        $('#ficha_involucrado .modal_titulo').text('- Detenido -');
                        $('#btn_invol_agr').addClass('oculto');
                        $('#btn_invol_lim').addClass('oculto');
                        xajax_buscarInvolucrado(nac,nroCedula,'detenido',null,'consulta');
                    break;
                    case 7:
                        xajax_buscarSancion(idReg,infraccionId);
                    break;
                    case 8:
                        xajax_buscarMedida(idReg,infraccionId);
                    break;
                }
                $('#ifr_infraccion_det').blur();
            break;
        } 
    }
    function capturar(siglas,idReg,elementTr,elementTd){
        switch (siglas){
            case 'lis':
                $('#ifr_lista_infractor').attr('src','');
                $('#ifr_lista_infractor').blur();
                xajax_buscarInfractor(idReg);
            break;
        } 
    }
    function cerrarLista(siglas){
        switch (siglas){
            case 'lis':
                $('#ifr_lista_infractor').attr('src','');
                $('#lista_infractor').addClass('oculto'); 
                $('#ficha_infractor').removeClass('oculto'); 
            break;
        } 
    }
    function agregar(siglas){
        switch (siglas){
            case 'inf':
                $('#div_opc')           .hide();
                $('#div_filtros')       .addClass('oculto');
                $('#div_infraccion')    .addClass('oculto');
                $('#ficha_infraccion')  .removeClass('oculto');
                $('#ifr_infraccion')    .blur();
                $('.btn_infraccion_0')  .addClass('oculto');
                $('.btn_infraccion_1')  .removeClass('oculto');
                camposInfraccion(3);
                accion = 'registrar';
                $('#titulo_ficha_inf').text('- Nueva Infracción -');
                $('#ifr_infraccion').blur();
            break;
            case 'det':
                mostrarFichaInvol('detenido');
                $('#ifr_infraccion_det').blur();
            break;
            case 'vic':
                mostrarFichaInvol('victima');
                $('#ifr_infraccion_vic').blur();
            break;
            case 'fun':
                mostrarFichaInvol('funcionario');
                $('#ifr_infraccion_fun').blur();
            break;
            case 'per':
                mostrarFichaInvol('personal');
                $('#ifr_infraccion_per').blur();
            break;
            case 'doc':
                mostrarFichaDoc();
                $('#ifr_infraccion_doc').blur();
            break;
            case 'mat':
                mostrarFichaMat();
                $('#ifr_infraccion_mat').blur();
            break;
            case 'med':
                mostrarFichaMed();
                $('#ifr_infraccion_med').blur();
            break;
            case 'veh':
                mostrarFichaVeh();
                $('#ifr_infraccion_veh').blur();
            break;
        }
        $('#ifr_infraccion'+siglas).blur();
    }
    function eliminar(siglas,arreglo){
        var infraccionId = $('#infraccion_id').val();
        switch (siglas){
            case 'inf':
                xajax_removerInfraccion(arreglo);
            break;
            case 'det':
            case 'vic':
            case 'fun':
            case 'per':
                xajax_removerInvolucrado(siglas,infraccionId,arreglo);                
            break;
            case 'doc':
                xajax_removerDocumento(infraccionId,arreglo);
            break;
            case 'mat':
            case 'med':
            case 'veh':
                xajax_removerMaterial(siglas,infraccionId,arreglo);
            break;
        }
        $('#ifr_infraccion_'+siglas).blur();
    }
    function validaFecha(fecha){
        // alert("validando");
        var array_fecha = fecha.split("-");
        if(array_fecha.length!=3)  return false;
        
        var ano;
        ano = array_fecha[2];
        ano = parseInt(array_fecha[2],10);
        if(isNaN(ano))   return false;   
        if(ano.length<4) return false;
        var mes;
        mes = parseInt(array_fecha[1],10);
        if(isNaN(mes))   return false;   
        var dia;
        dia = parseInt(array_fecha[0],10);
        if(isNaN(dia))   return false;   
        

        if(mes==1 && dia<=31 || mes==2 && dia<=28 || mes==3 && dia<=31 || mes==4 && dia<=30 || mes==5 && dia<=31 || mes==6 && dia<=30 || mes==7 && dia<=31 || mes==8 && dia<=31 || mes==9 && dia<=30 || mes==10 && dia<=31 || mes==11 && dia<=30 || mes==12 && dia<=31){
            
            return true;
        }else{
                if(mes==2 && dia==29){
                    if(bisiesto(ano)){
                        return true; 
                        //alert('A�o Bisiesto');
                    }else return false;
                }
            }

    }
    function cargarEstacion(opc){
        var ajax = true;
        if(opc == 1) {
            var idLinea = $('#selLinea').val();
            var linea = $('#selLinea').text();
            if(idLinea == 0){
                limpiarEstacion();
                ajax = false;
            }
        }
        else{
            var idLinea = $('#filt_ubicacion').val();
            var linea = $('#filt_ubicacion').text();
            if(idLinea == 0) {
                limpiarEstacion();
                $('#fila_aux_ubi').addClass('oculto');
                ajax = false;
            }
        }
        if(ajax) xajax_cargarEstacion(opc, idLinea);
    }
    function limpiarEstacion(){

        if($('#sel_estacion')) $('#sel_estacion').remove();
        if($('#filt_ubicacion2')) $('#filt_ubicacion2').remove();
    }
    function selectManual(idSelect,valor){
        var select = document.getElementById(idSelect);
        var cantOpc= select.options.length;
        for(var i=1;i<cantOpc;i++){
            var opcion = select.options[i].text;
            if(opcion == valor){
                var pos = select.options[i].selected = 'selected';
            }
        }
    }
    function seleccionarLinea(idSelect,valor){
        var select = document.getElementById(idSelect);
        if(select == null) {
            setTimeout(function(){
                seleccionarLinea(idSelect,valor);
            },50);
        }
        else selectManual(idSelect,valor);
        
    }
    function cargarInfraccion(idReg){
        $('#div_opc').hide();
        $('#div_filtros').addClass('oculto');
        $('#div_infraccion').addClass('oculto');
        $('#ficha_infraccion').removeClass('oculto');
        $('#ifr_infraccion').blur();
        xajax_buscarInfraccion(idReg);
    }
    function cargarFotoInvol(evento,opc){
        
        if(opc == 'infractor')      var campoFoto = 'filt_foto';
        if(opc == 'involucrado')    var campoFoto = 'inv_foto';

        var input   = evento.target;
        var size    = input.files[0].size / 1000;
        var formato = input.files[0].type;
        var nombre  = input.files[0].name.toLowerCase();

        console.log(input.files[0]);

        if ((!formato.match('jpg')) && (!formato.match('jpeg'))){
            alert('ERROR: Sólo puede cargar fotos con formato jpg/jpeg.');
            return false;
        }
        if (size > 700){
            alert('ERROR: El tamaño de la foto seleccionada no puede ser mayor a 700kb.');
            return false;
        }

        if(nombre.match('.jpg'))    var extension = 'jpg';
        if(nombre.match('.jpeg'))   var extension = 'jpeg';
        if(nombre.match('.png'))    var extension = 'png';

        var reader = new FileReader();
        reader.onload = function(){
            console.log(reader);
            var dataURL = reader.result;
            var output  = document.getElementById(campoFoto);
            output.src  = dataURL;
            output.name = extension;

            if(opc == 'infractor'){
                gestBtnAceptar(null,'filt_foto',dataURL);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
    function formReporte(rutaReporte,arrParametros){
        var div = document.getElementById('panel_right');
        var form = document.createElement("form");
        form.setAttribute('id','form_reporte');
        form.setAttribute('target','_BLANK');
        form.setAttribute('method','post');
        form.setAttribute('action',rutaReporte);
        form.setAttribute('style','display:none');

        if(arrParametros){
            for(var i=0; i < arrParametros.length; i++){
                var input = document.createElement("input");
                input.setAttribute("type","hidden");
                input.setAttribute("name", "param"+i);
                input.setAttribute("value",arrParametros[i]);
                form.appendChild(input);
                input = null;
            }
        }
        
        div.appendChild(form);
        $('#form_reporte').submit();
        $('#form_reporte').remove();
    }
/* -------------------------------------------------------------------------------------------------------------------- */