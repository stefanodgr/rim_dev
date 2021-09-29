/* *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*- */
/* ---------------------------------------------------------------------------------------------------------------------------- */										
/* --------------------------------------- FUNCIONES PARA CONTROL DE DATATABLE EDITABLE --------------------------------------- */											
/* ---------------------------------------------------------------------------------------------------------------------------- */
/* *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*- */	

/* ---------------------------------------------------- VARIABLES GLOBALES ---------------------------------------------------- */

	var columna 		= new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	var siglas 			= document.getElementById('siglas').value;
	var ctrlFuncDtb 	= document.getElementById('ctrlFunDtb').value;
	var tipoBtnDtb 		= document.getElementById('tipoBtnDtb').value;
	var ctrlInf 		= document.getElementById('ctrlInf').value;
	var json 			= document.getElementById('ctrlJson').value;
	var frameContent 	= loadContent();
/* ----------------------------------------------------------------------------------------------------------------------------	*/
																																		
/* --------------------- ARREGLOS QUE CONTENDRAN LOS DATOS NECESARIOS PARA EJECUTAR LA ACCIÓN SOBRE LA BD ---------------------	*/																																										

	var arrCampos 	= new Array();		//ALMACENA LOS CAMPOS DE LA BD QUE SERAN AFECTADOS										
	var arrValores	= new Array();		//ALMACENA LOS VALORES QUE SERAN INSERTADOS O MODIFICADOS EN LA BD 						
	var arrInicial	= new Array();		//ALMACENA LOS VALORES INICIALES QUE POSEIAN LAS CELDAS MODIFICADAS 					
	var arrId 		= new Array();		//ALMACENA LOS ID DE LAS CELDAS DEL DATA TABLE EN LAS QUE SE ENCUENTRAN LOS DATOS 		
	var arrIdReg 	= new Array();		//ALMACENA LOS ID DE LOS REGISTROS QUE SERAN AFECTADOS 									
	var arrPos 		= new Array();		//ALMACENA LOS ID DE LAS CELDAS DEL DATA TABLE EN LAS QUE SE ENCUENTRAN LOS DATOS 		
	var arrElim 	= new Array();		//ALMACENA LOS ID DE LOS REGISTROS DE LA BASE DE DATOS QUE SE VAN A ELIMINAR  
	var arrRegGest 	= new Array();		//ALMACENA LOS ID DE LOS REGISTROS DE LA BASE DE DATOS QUE SE VAN A ELIMINAR O SELECCIONAR 	
/* ----------------------------------------------------------------------------------------------------------------------------	*/

/* --------------------------------------------------- FUNCIONES JAVASCRIPT --------------------------------------------------- */ 
	
	function loadFnDtb(){
		if(ctrlFuncDtb){
			$('#tbl tbody').on('mouseover',function(e){
				if(e.target.tagName == "TD") manejarClases(e.target.parentNode,"agregarPlus");
			});
			$('#tbl tbody').on('mouseout',function(e){
				if(e.target.tagName == "TD") manejarClases(e.target.parentNode,"removerPlus");
			});
		}
		else{
			$('#tbl tbody').on('mouseover',function(e){
				if(e.target.tagName == "TD") manejarClases(e.target.parentNode,"agregar");
			});
			$('#tbl tbody').on('mouseout',function(e){
				if(e.target.tagName == "TD") manejarClases(e.target.parentNode,"remover");
			});
		}
		
		$('#tbl tbody').on('click',function(e){
			var ctrlIndice 	= $(e.target).hasClass('indice');
			var celda 		= e.target;
			var element 	= $(this);
			var ctrlInput	= celda != '[object HTMLTableCellElement]';
			var idRow  		= celda.parentNode.id;
			
			if(ctrlFuncDtb){
				switch(tipoBtnDtb){
					case 'A':
						if((idRow) && (idRow != 0)){
							if(ctrlIndice) manejarClases(celda.parentNode,"marcaMutiple","eliminar");
							else{
								if(!ctrlInput){
									if (element.hasClass('click')){
										element.removeClass('click');
										determinarAccion('editar', celda);
									}
									else{
										element.addClass('click');
										setTimeout(function(){
											if (element.hasClass('click')){
												element.removeClass('click');
												determinarAccion('abrir', celda);
											}
										}, 250);          
									}
								}
							}
						}
						else determinarAccion('editar', celda);
					break;
					case 'B':
						if(!ctrlIndice) manejarClases(celda.parentNode,'marcaMutiple','seleccionar'); 
					break;
					case 'C':
						if(!ctrlIndice) determinarAccion('capturar',celda,'unico');
					break;
					case 'D':
						if(!ctrlIndice){
							if (element.hasClass('click')){
								element.removeClass('click');
								determinarAccion('editar', celda, 'avanzado');
							}
							else{
								element.addClass('click');
								setTimeout(function(){
									if (element.hasClass('click')){
										element.removeClass('click');
										determinarAccion('abrir', celda);
									}
								}, 250);          
							}
						}
					break;
					case 'E':
						if(!ctrlIndice){
							if (element.hasClass('click')){
								element.removeClass('click');
								determinarAccion('editar', celda, 'avanzado');
							}
							else{
								element.addClass('click');
								setTimeout(function(){
									if (element.hasClass('click')){
										element.removeClass('click');
										determinarAccion('abrir', celda);
									}
								}, 250);          
							}
						}
						else{
							manejarClases(celda.parentNode,"marcaMutiple","eliminar");
						}
					break;
					default:
						if(!ctrlIndice) determinarAccion('abrir',celda);
					break;
				}
			}
		});
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function loadContent(){
		var frameContent = new Array();
		frameContent["valor"]     = window.frameElement.name;
		frameContent["tag"]     = "name";
	
		if(frameContent["valor"] == ''){
			frameContent["valor"]      = window.frameElement.id;
			frameContent["tag"]     = "id";
		}

		return frameContent;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	/*- ----------------------------------------------------------------------------------------- -*/
	function cargarDatosTbl(){
		var dTable 			= $('#tbl').dataTable();
		var rowCountTotal	= dTable.fnGetNodes().length; 
		var valUltId 		= getLastId('tbl');

		document.getElementById('idUltReg').value = valUltId;
		document.getElementById('cantReg').value  = rowCountTotal;	
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function crearCoordenadas(idTbl){
		var dtb 	    = $('#'+idTbl).dataTable(); 
		var rowCount    = dtb.fnGetNodes().length;
		var cellCount	= $("#"+idTbl).find('th').length;

		for (var i = 0; i<rowCount; i++){
			var id = dtb.fnGetNodes(i).id;
			for(var j = 0; j<cellCount; j++){
				if (j == 0) dtb.fnGetNodes(i).cells[j].id = "id_"+siglas+"_ind_"+id;
				else{
					dtb.fnGetNodes(i).cells[j].id 		= "id_"+siglas+"_"+columna[j-1]+[i+1];
					dtb.fnGetNodes(i).cells[j].headers 	= "id_"+siglas+"_"+columna[j-1]+"0";
				}
			}
		}
		$('#ctrlReady').val('1');
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	/*function crearIndices(idTbl){
		var dtb 	    = $('#'+idTbl).dataTable(); 
		var rowCount    = dtb.fnGetNodes().length;

		for (var i = 0; i<rowCount; i++){
			dtb.fnGetNodes(i).cells[0].classList.add("indice");
		}
	}*/
	/*- ----------------------------------------------------------------------------------------- -*/
	function pintarFilas(idTabla){
		var dtb 	    = $('#'+idTabla).dataTable(); 
		var rowCount    = dtb.fnGetNodes().length;
		var j 			= 0;

		for (var i = 0; i<rowCount; i++){
			dtb.fnGetNodes(i).cells[0].classList.add("indice");
			if(j==0) {
				dtb.fnGetNodes(i).classList.add("filaClara");
				j++;
			}
			else {
				dtb.fnGetNodes(i).classList.add("filaOscura");
				j--;
			}
		}
		// $("#"+idTabla+" tr:odd").css("background-color", "#EFEFEF"); // filas impares
		// $("#"+idTabla+" tr:even").css("background-color", "#E7E7E7"); // filas pares
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function agregarTblTitulo(titulo,sWTitulo,filtBusq,sWSearch){
		if((titulo) || (filtBusq)){
			if(titulo){
				if(filtBusq){
					if(sWTitulo){
						$("div.ui-corner-tr").prepend('<div id="tituloTabla"><label>'+titulo+'</label></div');
						if(sWSearch){
							$('#tbl_filter > label > input[type="search"]').css('width',sWSearch+'px');
						}
					}
					else{
						if(sWSearch){
							$('#tbl_filter > label > input[type="search"]').css('width',sWSearch+'px');
							$("div.ui-corner-tr").prepend('<div id="tituloTabla"><label>'+titulo+'</label></div');
						}
						else{
							$("div.ui-corner-tr").prepend('<div id="tituloTabla"><label>'+titulo+'</label></div');
						}
					}
				}
				else{
					$("div.ui-corner-tr").prepend('<div id="tituloTabla"><label>'+titulo+'</label></div');
				}
			}
			else{
				if(sWSearch) $('#tbl_filter > label > input[type="search"]').css('width',sWSearch+'px');
			}
			$('.ui-corner-tl, .ui-corner-tr').css('padding','0px 8px');
		}


			/*if(titulo){
				if(sWTitulo != ''){
					$("div.ui-corner-tr").prepend('<div id="tituloTabla" style="width:'+sWTitulo+'%;"><label>'+titulo+'</label></div');
					$('#tbl_filter').css('width',100-sWTitulo+"%");
				}
				else{
					$("div.ui-corner-tr").prepend('<div id="tituloTabla"><label>'+titulo+'</label></div');
				}
			}
			if(filtBusq){
				if(sWSearch) {
					if()
					$('#tbl_filter').css('width','100%');
					$('#tbl_filter > label > input[type="search"]').css('width',sWSearch+'px');
				}
				if(!titulo) $('#tbl_filter').css('width',"100%");
			}
			
		}*/
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function agregarTblBtn(rutaDir,filtPag){
		if((tipoBtnDtb) || (filtPag)){
			if(tipoBtnDtb){
				var funAgregar 	= "determinarAccion('agregar');"
				var funEliminar = "determinarAccion('eliminar');"
				var funAceptar	= "determinarAccion('capturar',null,'multiple');";
				var funCancelar	= "determinarAccion('cancelar');";
				
				switch (tipoBtnDtb){
					case 'A':
						var idTbl = 'tbl';
						var divBtn = '<div id = "btnTbl">';
						divBtn += '<input type = "image" 	id = "btnCrear_'+siglas+'"		class="btn_dtb" 				src="'+rutaDir+'libreria/hg/images/dtb_agregar.png" 	title="Nuevo Registro" 		onclick="agregarFila(\'tbl\');"			/>';
						divBtn += '<input type = "image" 	id = "btnModificar_'+siglas+'"	class="btn_dtb deshabilitado" 	src="'+rutaDir+'libreria/hg/images/dtb_guardar.png" 	title="Guardar Cambios" 	onclick="guardarCambios();" 	disabled/>';
						divBtn += '<input type = "image" 	id = "btnEliminar_'+siglas+'"	class="btn_dtb deshabilitado" 	src="'+rutaDir+'libreria/hg/images/dtb_eliminar.png" 	title="Eliminar Registros" 	onclick="eliminarRegistros();" 	disabled/>';
						// divBtn += '<input type = "image" 	id = "btnExcel_'+siglas+'"		class="btn_dtb" 				src="'+rutaDir+'libreria/hg/images/dtb_excel.png" 		title="Exportar Excel" 		onclick="prueba();"						/>';
						divBtn += '</div>';
						$("div.ui-corner-br").prepend(divBtn);
					break;
					case 'B':
						var divBtn = '<div id = "btnTbl">';
						divBtn += '<div id = "btnAceptarSel_'+siglas+'"		class="btnOperacion btnVerde deshabilitado" onclick="'+funAceptar+'" 	>Aceptar</div>';
						divBtn += '<div id = "btnCancelarSel_'+siglas+'"	class="btnOperacion btnRojo" 				onclick="'+funCancelar+'" 	>Cancelar</div>';
						divBtn += '</div>';
						$("div.ui-corner-br").prepend(divBtn);
					break;
					case 'C':
						var divBtn = '<div id = "btnTbl">';
						divBtn += '<div id = "btnCancelarSel_'+siglas+'"	class="btnOperacion btnRojo" 				onclick="'+funCancelar+'" 	>Cancelar</div>';
						divBtn += '</div>';
						$("div.ui-corner-br").prepend(divBtn);
					break;
					case 'D':
						var divBtn = '<div id = "btnTbl">';
						divBtn += '<input type = "image" 	id = "btnCrear_'+siglas+'"		class="btn_dtb"	src="'+rutaDir+'libreria/hg/images/dtb_agregar.png" 	 title="Nuevo Registro" 	onclick="'+funAgregar+'"/>';
						divBtn += '</div>';
						$("div.ui-corner-br").prepend(divBtn);
					break;
					case 'E':
						var divBtn = '<div id = "btnTbl">';
						divBtn += '<input type = "image" 	id = "btnCrear_'+siglas+'"		class="btn_dtb"					src="'+rutaDir+'libreria/hg/images/dtb_agregar.png" 	title="Nuevo Registro" 		onclick="'+funAgregar+'"/>';
						divBtn += '<input type = "image" 	id = "btnEliminar_'+siglas+'"	class="btn_dtb deshabilitado"	src="'+rutaDir+'libreria/hg/images/dtb_eliminar.png" 	title="Eliminar Registro" 	onclick="'+funEliminar+'" disabled/>';
						divBtn += '</div>';
						$("div.ui-corner-br").prepend(divBtn);
					break;
				}
				$('.ui-corner-bl,.ui-corner-br').css('padding','6px 8px');
			}
			if(filtPag){
				if(!tipoBtnDtb){
					if(ctrlInf){
						// $('#tbl_info').css({'width':'30%','margin-right':'0%'});
						// $('#tbl_paginate').css({'width':'70%','margin-right':'0%'});
					}
					else{
						// $('#tbl_paginate').css({'width':'100%','margin-left':'0%'});
					}
					$('.ui-corner-bl,.ui-corner-br').css('padding','0px 8px');
				}
				
			}
		}
	}
	/* ------------------------------------------------------------------------------------------ -*/
	function determinarAccion(accion,celda,tipoAccion){
		if(celda){
			var elementTr = celda.parentNode;
			var elementTd = celda;
		}
		switch (accion){
			case 'abrir':
				var idReg 	= elementTr.id;
				if(window.parent.apertura) {
					window.parent.apertura(siglas,idReg,elementTr,elementTd);
					manejarClases(elementTr,'marcaUnica');
				}
				else console.log("ERROR: Debe definir la función <apertura> en el tpl.");
			break;
			case 'editar':
				if(!tipoAccion){
					var columBd = document.getElementById(elementTd.headers).abbr;
					columBd != 'null' ? control = true : control = false;
					if(control) modificarValor(elementTd);
				}
				else{
					var idReg 	= elementTr.id;
					if(window.parent.modificar) window.parent.modificar(siglas,idReg,elementTr,elementTd);
					else console.log("ERROR: Debe definir la función <modificar> en el tpl.");
				}
			break;
			case 'capturar':
				if(tipoAccion == 'unico'){
					var idReg 	= elementTr.id;	
					if(window.parent.capturar) window.parent.capturar(siglas,idReg,elementTr,elementTd);
					else console.log("ERROR: Debe definir la función <capturar> en el tpl.");
				}
				if(tipoAccion == 'multiple'){
					if(window.parent.capturarMultiple){
						var arrFilas = arrRegGest;
						limpiarSeleccion('seleccion');
						window.parent.capturarMultiple(siglas,arrFilas);
						arrRegGest.length = 0;
						document.getElementById('arrRegGest').value = '';
					}
					else console.log("ERROR: Debe definir la función <capturarMultiple> en el tpl.");
				}
			break;
			case 'agregar':
				if(window.parent.agregar) window.parent.agregar(siglas);
				else console.log("ERROR: Debe definir la función <agregar> en el tpl.");
			break;
			case 'eliminar':
				if(window.parent.eliminar) window.parent.eliminar(siglas, arrRegGest);
				else console.log("ERROR: Debe definir la función <eliminar> en el tpl.");
			break;
			case 'cancelar':
				if(window.parent.cerrarLista){
					limpiarSeleccion('seleccion');
					arrRegGest.length = 0;
					document.getElementById('arrRegGest').value = '';
					window.parent.cerrarLista(siglas);
				}
				else console.log("ERROR: Debe definir la función <cerrarLista> en el tpl.");
			break;
			/*- ----------------------------------------------------------------------------------------- -*/
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function modificarValor(celda,ctrlAct){
		/**
		 * Función que permite editar la celda sobre la que se haga click o doble click según sea el caso.
		 * 
		 * @param HTML_element celda Valor enviado desde el evento onclick de la celda. Parametro "this".
		 */

		var campoBd    	= document.getElementById(celda.headers).abbr;
		var headers 	= document.getElementById(celda.headers);		//ALMACENA TODA LA INFROMACIÓN DE GUÍA NECESARIA PARA EL DTB
		var ctrlSelInp 	= false;
		
		if(ctrlAct == 'modificar'){		//VALIDA SI SE ESTA ACCEDIENDO A LA FUNCIÓN DIRECTAMENTE DESDE EL DATATABLE O DESDE LA FUNCION ACTUALIZAR POR CONVERSION DE TIPO DE CELDA 
			var tipoCelda   = 'text';
			var valorAnt    = valActual.value;
			ctrlSelInp      = true;
			celda.innerHTML = '';
			idActual.value  = '';
		}
		
		if (campoBd != ""){	//PARA VALIDAR SI LA CELDA SELECCIONADA POSEE ASOCIADO UN CAMPO DE LA BD QUE PUEDA MODIFICARSE MANUALMENTE
			
			/*-------------------------------------*/
			//PERMITE MODIFICAR OTRA CELDA SIN HABER REALIZADO MODIFICACIONES EN LA CELDA ANTERIOR, HACIENDO QUE LA ANTERIOR MANTENGA EL VALOR ORIGINAL
			
			if ((idActual.value != '')&&(idActual.value != celda.id)){ 
				var idRestaurar = idActual.value; 		// ID DEL CAMPO A RESTAURAR 
				document.getElementById(idRestaurar).innerHTML = valActual.value;
				idActual.value 		= '';
				valActual.value 	= '';
				campoActual.value	= '';
				posActual.value 	= '';
			}
			/*------------------------------------*/
			
			if (idActual.value == ''){ 		
				if (idActual != celda.id){ 												//EVITA QUE SE PRESIONE DOS VECES SOBRE LA MISMA CELDA 			
					idActual.value 		= celda.id; 									//RETIENE EN UN INPUT DE CONTROL EL ID ACTUAL DE LA CELDA A MODIFICAR 
					
					if(ctrlAct != 'modificar'){
						valActual.value = celda.innerHTML;								//RETIENE EN UN INPUT DE CONTROL EL VALOR ACTUAL DE LA CELDA A MODIFICAR 
					}
					else{
						valActual.value = valorAnt;
					}
					
					campoActual.value 	= document.getElementById(celda.headers).abbr;	//RETIENE EN UN INPUT DE CONTROL EL CAMPO DE LA BD AL QUE HACE REFERENCIA LA CELDA A MODIFICAR 			
					
					var clase 			= headers.className;
					var arrClase 		= clase.split(' ');
					var formatoCelda 	= arrClase[1];
					var columRelacion   = arrClase[2];
					var columPadre      = arrClase[3];
					var ctrlCeldaPadre  = false;
					var coordenada 	= idActual.value.split('_')[2];
					var numFila 	= extraerNum(coordenada); 						//EXTRAE DE LA COORDENADA DE LA CELDA EL NUMERO DE LA FILA EN EDICION			
					var idReg 		= $('#'+idActual.value).parent().attr('id');
					
					if(ctrlSelInp == false){
						var ctrlSelect  = arrClase[0].indexOf("select");
						if(ctrlSelect != -1) tipoCelda = "select";
						else tipoCelda = arrClase[0];
					}

					// if(idReg == undefined) idReg = "nuevo";
					// else alert("existe");
					regActual.value = idReg;				
					posActual.value = numFila;
					
					if (arrClase[2]!= 'null'){
						var columRelacion = arrClase[2];
						//alert("hay relacion");

						//ctrlColumRelacion = columRelacion.indexOf("|"); 	//VERIFICA SI EL CAMPO SE ENCUENTRA RELACIONADO A MAS DE UNA COLUMNA
						
						//if(ctrlColumRelacion != -1){
						//	arrRelacion = columRelacion.split('|');	
						//}
						//else{
							var idCeldaPadre 	= "id_" + siglas + "_" + columRelacion + numFila;
							var elementRelac 	= document.getElementById(idCeldaPadre);
							var valIdCeldaPadre = elementRelac.innerHTML;
							//alert(idCeldaPadre + "--" + valIdCeldaPadre);
						//}
						ctrlCeldaPadre = true;					
					}	
					//--------------------------------------------------------------------------------------------------------//
					switch (tipoCelda){		
						case 'text':
							var input = document.createElement("input");
							input.setAttribute("id", celda.id+'_n');
							input.setAttribute("type","text");
							input.setAttribute("onblur", "actualizarValor(this,"+celda.id+");");
							input.setAttribute("onfocus","this.value = this.value");
							input.setAttribute("style","width:calc(100% - 20px);");

							if(ctrlAct != 'modificar'){
								input.setAttribute('value',valActual.value);
							}
							else{
								input.setAttribute('value','');
								input.setAttribute("placeholder","Ingrese la nueva opción");
							}
							celda.innerHTML = '';
							celda.appendChild(input);
							element = $('#'+celda.id+'_n');
							element.focus();
							valor = element.val();
							element.val('');
							element.val(valor);
							
							// PARA CONTROLAR Y VALIDAR EL TIPO DE CONTENIDO QUE PUEDE ESCRIBIRSE EN LAS CELDAS //
								
							element.keypress(function(e) {
								if(e.which == 13) element.blur();
								if(formatoCelda != 'null'){
									var controlFormato = true;
									controlFormato = validarFormatoCelda(e,formatoCelda);

									if(controlFormato[0] == false){
										//alert(controlFormato[1])
										return false;
									}
								}
							});
							// -------------------------------------------------------------------------------- //
						break;
						case 'select':
							var columna 	= $('#'+celda.headers).attr('abbr');
							var selColumna 	= document.getElementById('sel_'+columna);
							if(!selColumna){
								console.log('ERROR: Debe asociar el select <select_'+columna+'> a una columna existente o esta columna no posee ningún select asociado.');
								return false;
							}
							var cantOpc 	= selColumna.options.length;
							var ctrlSelEdit = selColumna.name ? true : false;
							var ctrlNvaOpc 	= false;
							var select 		= document.createElement("select");

							select.setAttribute("id", celda.id+'_n');
							select.setAttribute("type","text");
							select.setAttribute("onblur", "actualizarValor(this,"+celda.id+");");
							select.setAttribute("onfocus","this.value = this.value");
							select.setAttribute("style","width:100%;height:25px");
							select.innerHTML = selColumna.innerHTML;

							for(var i=0; i<cantOpc; i++){
								if(select.options[i].text == valActual.value) select.selectedIndex = i;	// VERIFICA SI EN LA LISTA DE OPCIONES SE ENCUENTRA EL VALOR QUE POSEE ACTUALMENTE LA CELDA, SI EXISTE LO SELECCIONA //
								if(select.options[i].value == "- Nueva Opción -" ) ctrlNvaOpc = true;  	// RECORRE EL ARREGLO DE OPCIONES PARA VERIFICAR SI YA ESTÁ CREADA LA OPCION - Nueva Opción - //
							}
							celda.innerHTML = '';			// LIMPIA LA CELDA PARA LUEGO INSERTAR EL NUEVO CONTENIDO
							celda.appendChild(select);		// INSERTA EN LA CELDA EL SELECT CREADO
							
							if(ctrlSelEdit == true){		// VERIFICA SI EL SELECT PERMITE AÑADR NUEVAS OPCIONES
								if(ctrlNvaOpc == false){	// VERIFICA QUE NO EXISTA LA OPCION - Nueva Opción - EN LA LISTA DE OPCIONES 
									var nvaOpcion = document.createElement("option");		// CREACIÓN DE LA NUEVA OPCIÓN 
									nvaOpcion.setAttribute("style","color:darkred; font-weight:bolder; text-align:center;background:lightgray;");
									nvaOpcion.setAttribute('onclick','modificarValor('+celda.id+',"modificar"); return false;');
									nvaOpcion.innerHTML = ('- Nueva Opción -');
									select.appendChild(nvaOpcion);	// SE INSERTA LA NUEVA OPCIÓN EN EL SELECT CORRESPONDIENTE
								}
							}

							element = $('#'+celda.id+'_n');
							element.focus();
							element.keypress(function(e) {
								if(e.which == 13) element.blur();
							});

							if (ctrlCeldaPadre == true){
								element = $('#'+celda.id+'_n');
								element.on("change", function(){
									indSelected = lista.selectedIndex;
									opcSelected = lista.options[indSelected];
									valSelected = opcSelected.innerHTML;
									valAntElement = elementRelac.innerHTML;			//GUARDA EL VALOR ACTUAL DE LA CELDA RELACIONADA POR SI ES NECESARIO REUTILIZARLA MAS ADELANTE
									elementRelac.innerHTML = '';
									elementRelac.abbr = valSelected;
								});
							}
						break;
						case 'checkbox':
							var checkbox = document.createElement("input");
							checkbox.setAttribute("id", celda.id+'_n');
							checkbox.setAttribute("type","checkbox");
							checkbox.setAttribute("onblur", "actualizarValor(this,"+celda.id+");");
							checkbox.setAttribute("onfocus","this.value = this.value");
							checkbox.setAttribute("style","width:100%;height:25px");

							if(valActual.value == "SI") checkbox.setAttribute("checked","checked");

							celda.innerHTML = '';
							celda.appendChild(checkbox);

							element = $('#'+celda.id+'_n');
							element.focus();
							element.keypress(function(e) {
								if(e.which == 13) element.blur();
							});
						break;
						case 'datepicker':
							if(formatoCelda){
								var formatoDatePicker;
								var date = false
								var time = false;
								var molde = false;

								if(valActual.value == '') var ctrlEmpty = true;

								switch (formatoCelda){
									case 'date':
										formatoDatePicker = 'd/m/Y';
										date = true;
										if(ctrlEmpty == true) molde = '39/19/9999';
									break;
									case 'time':
										formatoDatePicker = 'H:i';
										time = true;
										if(ctrlEmpty == true) molde = '29:59';
									break;
									case 'datetime':
										formatoDatePicker = 'd/m/Y H:i';
										date = true;
										time = true;
										if(ctrlEmpty == true) molde = '39/19/9999 29:59';
									break;
								}
							}
							var input = document.createElement("input");
							input.setAttribute("id", celda.id+'_n');
							input.setAttribute("type","text");
							input.setAttribute("onblur", "actualizarValor(this,"+celda.id+");");
							input.setAttribute("onfocus","this.value = this.value");
							input.setAttribute('value',valActual.value);
							input.setAttribute("style","width:100%;height:25px");
							celda.innerHTML = '';
							celda.appendChild(input);

							$('#'+celda.id+"_n").datetimepicker({
								datepicker: date,
								timepicker: time,
								mask:		molde,
								lang:		'es',
								format: 	formatoDatePicker,
								weeks:		true,
								dayOfWeekStart : 1,
								timepickerScrollbar:false
							});
							$('#'+celda.id+"_n").datetimepicker('show');
						break;
						case 'popup':
							if (ctrlCeldaPadre == false){
								alert("tomar default");
								//alert(celda.abbr +"--"+celda.id);
								//xajax_abrirVentana(celda.abbr, celda.id);
								//ruta="../lista_falla.php?opcion=actividadEstandar&celda="+celda;
								/*ruta="../lista_falla.php?opcion=Rutinas";	

								window.open(ruta,'','width=800,height=410,scrollbars=yes,top=100,left=200,resizable=yes,directories=yes,location=no,menubar=no');*/
							}	
							else{
								alert("tomar padre");
								//alert(valIdCeldaPadre+"--"+celda.id);
								//xajax_abrirVentana(celda.abbr, celda.id);
							}
						break;
					}
					/* -------------------------------------------------------------------------------------------------------- */
				}
			}
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function actualizarValor(nvoElemento,celda){
		/**
		 * Función encargada de tomar el valor escrito en el input de la celda y asignarselo a la misma. 
		 * Solo se ejecuta al exitir un cambio en el valor original de la celda.
		 * 
		 * @param HTML_element nvoElemento Valor enviado desde el evento onchange de la celda.
		 * @param HTML_element celda Valor enviado desde el evento onchange de la celda.
		 */
	
		var idTabla = document.getElementById('idTabla').value;
		var valor 	= detNvoValor(nvoElemento);

		if(valor[0] == "- Nueva Opción -"){   		// VALIDA SI LA CELDA ES TIPO SELECT Y SE REQUIERE CONVERTIRLA EN UNA CELDA DE TEXTO
			modificarValor(celda,"modificar");
			return false;
		}
		
		if (valActual.value != valor[0]){
			var campo 			= document.getElementById(celda.headers).abbr;
			var id 				= celda.id;
			var ctrlLlenar 		= true;													//PARA CONTROLAR SI SE LLENARÁN LOS ARREGLOS DURANTE EL PROCESO DE ACTUALIZACIÓN
			var control 		= new Array();

			control = validarCelda(campo,valor[0],id);	
			
			if (control[0]== true){
				//document.getElementById(id).style.background = '#F2F2F2';
				celda.innerHTML = valor[0];
				
				// var detectFecha = nvoElemento.value.indexOf("/"); 						//DETECTA SI EL VALOR QUE ESTA SIENDO MODIFICADO ES UNA FECHA
				
				// if (detectFecha != -1){													//SI EL VALOR A MODIFICAR ES UNA FECHA ENTONCES SE PROCEDE A ORDENAR LA FECHA Y ASIGNAR EL VALOR AL NUEVO ELEMENTO				
				// 	nvoElemento.value = ordenarFecha(nvoElemento.value);	
				// }	
			
				var valoresNuevos 		= document.getElementById('valNuevo').value;		//INPUT DE CONTROL DE VALORES NUEVOS 
				var valoresViejos 		= document.getElementById('valAnterior').value;		//INPUT DE CONTROL DE VALORES VIEJOS 
				var idModificado 		= document.getElementById('idModificado').value;	//INPUT DE CONTROL DE ID NUEVOS 
				var campoModificado 	= document.getElementById('campoModificado').value;	//INPUT DE CONTROL DE CAMPOS BD MODIFICADOS 
				var regModificado 		= document.getElementById('regModificado').value;	//INPUT DE CONTROL DE REGISTROS MODIFICADOS
				var posModificado 		= document.getElementById('posModificado').value;	//INPUT DE CONTROL DE POSICION DEL REGISTRO POR OT
				
				ctrlLlenar = verifValInicial(valActual.value, idActual.value, valor[0]);
				
				if(ctrlLlenar == true){
					llenarArreglos(valor[1]);				//LLAMADO A FUNCIÓN ENCARGADA DE LLENAR LOS ARREGLOS QUE CONTIENEN LOS DATOS NECESARIOS PARA LA ACCIÓN SOBRE LA BD 
				}

				// if (idModificado == ''){						//PARA EL CASO EN QUE NO SE HAYA REALIZADO UNA MODIFICACIÓN PREVIA
				// 	document.getElementById('valNuevo').value = valoresNuevos = valor;  //Valnuevo = nvo elemento, documen..=valnuevo...
					
				// 	document.getElementById('valAnterior').value 	= valoresViejos 	= valActual.value;
				// 	document.getElementById('idModificado').value 	= idModificado		= idActual.value;
				// 	document.getElementById('campoModificado').value= campoModificado	= campoActual.value;
				// 	document.getElementById('regModificado').value 	= regModificado 	= regActual.value;
				// 	document.getElementById('posModificado').value 	= posModificado 	= posActual.value;
				// } 
				// else {
				// 	document.getElementById('valNuevo').value 		= valoresNuevos 	+"|"+	valor;	
				// 	document.getElementById('valAnterior').value 	= valoresViejos 	+"|"+	valActual.value;
				// 	document.getElementById('idModificado').value 	= idModificado 		+"|"+	idActual.value;
				// 	document.getElementById('campoModificado').value= campoModificado 	+"|"+	campoActual.value;
				// 	document.getElementById('regModificado').value 	= regModificado 	+"|"+	regActual.value;
				// 	document.getElementById('posModificado').value 	= posModificado		+"|"+	posActual.value;
				// }
				//cleanArrActual();
			}

			if ((control[0]== false)||(control[0]== '2')){
				celda.innerHTML = valor[0];
				//cleanArrActual();	
			}
		}
		else celda.innerHTML = valor[0];

		recargarInputArreglo();
		cleanArrActual();
		
		if(arrId.length >0){
			$('#btnModificar_'+siglas).removeClass('deshabilitado');
			$('#btnModificar_'+siglas).prop('disabled',false);
		}
		else{
			$('#btnModificar_'+siglas).addClass('deshabilitado');
			$('#btnModificar_'+siglas).prop('disabled',true);
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function guardarCambios(tipo) { 
		var mensaje = '';
		
		if(tipo == 'paginacion') mensaje = "¿Desea guardar los cambios realizados?\nNOTA: Al cambiar de pagina perderá los registros nuevos que no hayan sido guardados.";
		else mensaje = "¿Desea guardar los cambios realizados?";
		
		if(confirm(mensaje) == true){
			var indUpdate 		= new Array();
			var indInsert 		= new Array();
			var regUpdate		= new Array();
			var regInsert 		= new Array();
			var controlPk		= new Array();
			var queryInsert 	= new Array();
			var queryUpdate 	= new Array();
			var control 		= true;							// USADA PARA VALIDAR SI EL VALOR SE GUARDARÁ EN LA PRIMERA POSICION DEL ARREGLO 
			var controlAjax 	= true;
			var controlExisPk	= true;
			var controlAcc 		= '';
			var ins 			= 0;
			var upd 			= 0;
			var cantInsert		= 0;	
			var cantUpdate		= 0;
			var cantQueryIns	= 0;	
			var cantQueryUpd	= 0;
			var nvoIdReg 		= 0;
			var nombreTabla 	= document.getElementById('nombreTabla').value;
			var idTabla 		= document.getElementById('idTabla').value;
			var table 			= document.getElementById('tbl');			
			var valUltId		= document.getElementById('idUltReg').value;
			var cmpExtTbl		= document.getElementById('cmpExtTbl').value;
			var valExtTbl		= document.getElementById('valExtTbl').value;
			var nombTblRel		= document.getElementById('nombTblRel').value;	
			var cmpRefRel		= document.getElementById('cmpRefTbl').value;
			var cmpTblRel		= document.getElementById('cmpTblRel').value;
			var valTblRel		= document.getElementById('valTblRel').value;	
			var cmpWrExtTbl		= document.getElementById('cmpWrExtTbl').value;
			var valWrExtTbl		= document.getElementById('valWrExtTbl').value;
			
			controlPk = verifSolicPk(table.id,idTabla);	//CHEQUEA SI ENTRE LOS CAMPOS DISPONIBLES PARA MODIFICAR SE ENCUENTRA EL QUE CONTIENE LA PK DE LA TABLA

			if (tipo == undefined) tipo = 'boton';
			
			//var codOt = window.parent.document.getElementById('id_bus_num_ot').value;
					
			for (var i=0; i<arrValores.length;i++){
				for(var j=0;j<arrValores.length;j++){
					if (arrPos[j] == arrPos[i]){
						if((arrIdReg[j] == 0)||(arrIdReg[j] == 'undefined')){			// SI NO POSEE ID DE REGISTRO SE LLENA EL ARREGLO DE INDICES INSERT 
							if(control==true){
								indInsert[ins]=j;
								control=false;
							}
							else{indInsert[ins]+="|"+j;}
							controlAcc = 'insert';
						}
						else{							// DE LO CONTRARIO SE LLENA EL ARREGLO DE INDICES UPDATE
							if(control==true){
								indUpdate[upd]=j;
								control=false;
							}
							else{indUpdate[upd]+="|"+j;}
							controlAcc = "update";
						}					
					}				
				}
				if (controlAcc == "insert") ins ++;
				if (controlAcc == "update")	upd ++;

				controlAcc 	= '';
				control 	= true;
			}
			
			for (var k=0;k<indInsert.length;k++) regInsert = compValArr(regInsert, indInsert[k]);
			for (var l=0;l<indUpdate.length;l++) regUpdate = compValArr(regUpdate, indUpdate[l]);			

			cantInsert = regInsert.length;			// CANTIDAD DE NUEVOS REGISTROS A SER INSERTADOS
			cantUpdate = regUpdate.length;			// CANTIDAD DE REGISTROS A SER ACTUALIZADOS
			
			nvoIdReg = (valUltId);	// DEVUELVE EL VALOR DEL NUEVO ID CONSECUTIVO; TOMA EL VALOR DEL ULTIMO ID GENERADO Y LE RESTA LA CANTIDAD DE NUEVOS REGISTROS PARA DETERMINAR EL VALOR DEL ULTIMO ID OBTENIDO POR BD
			
			if (cantInsert > 0){
				if (controlPk[0] == true){
					controlExisPk 		= false;				
					var controlCant 	= 0;
					var indArr 			= 0;				
					var controlError 	= 0;
					
					for (var m = 0; m <regInsert.length; m++){
						controlCant = regInsert[m].toString().indexOf("|");  
						if (controlCant == -1){
							indArr = regInsert[m];
							if (arrCampos[indArr]==idTabla){
								controlError += 1;
							}
						}
						else{
							indArr = regInsert[m].split('|');
							for (var n = 0; n<indArr.length; n++){
								//alert(arrCampos[indArr[n]]+" = "+idTabla+" ? ");
								if (arrCampos[indArr[n]]==idTabla){
									controlError += 1;
								}
							}			
						}
					}	
					if (controlError == cantInsert) controlExisPk = true;
					if (controlExisPk == true){
						queryInsert = crearQuery(regInsert,"insert",nombreTabla,idTabla,nvoIdReg,'manual',cmpExtTbl,valExtTbl,nombTblRel,cmpRefRel,cmpTblRel,valTblRel);
						cantQueryIns = queryInsert[0].length;
					}
					else{					
						alert("El campo <"+controlPk[1]+"> no puede estar vacío");
						controlAjax = false;
					}
				}
				else{
					//alert(cantReg+"--"+idTabla);
					var tipoCampPk = document.getElementById('tipoCampPk').value;				
					
					if(tipoCampPk == 'serial'){
						queryInsert = crearQuery(regInsert,"insert",nombreTabla,idTabla,nvoIdReg,'manual',cmpExtTbl,valExtTbl,nombTblRel,cmpRefRel,cmpTblRel,valTblRel,cmpWrExtTbl,valWrExtTbl);
						cantQueryIns = queryInsert[0].length;
					}
					else{					
						queryInsert = crearQuery(regInsert,"insert",nombreTabla,idTabla,nvoIdReg,'consecutivo',cmpExtTbl,valExtTbl,nombTblRel,cmpRefRel,cmpTblRel,valTblRel,cmpWrExtTbl,valWrExtTbl);
						cantQueryIns = queryInsert[0].length;
					}
				}
			}
			if (cantUpdate > 0){
				queryUpdate = crearQuery(regUpdate,"update",nombreTabla,idTabla,null,null,null,null,null,null,null,null,cmpWrExtTbl,valWrExtTbl);
				cantQueryUpd = queryUpdate[0].length;
			}
			if ((cantQueryIns < 1) && (cantQueryUpd < 1)){
				alert("No hay ningún cambio que registrar");
				controlAjax = false;
			}
			if (controlAjax == true){
				var arrQuery 	= new Array();
				if ((cantQueryIns == 0) || (cantQueryUpd == 0)){
					if(cantQueryIns == 0){
						//alert("1");
						arrQuery[0] = queryUpdate;
						window.parent.xajax_gestHgDtb(2,arrQuery,tipo,frameContent);
					}
					else{
						//alert("2");
						arrQuery[0] = queryInsert;
						window.parent.xajax_gestHgDtb(1,arrQuery,tipo,frameContent);
					}
				}
				else{
					//alert("3");
					arrQuery[0] = queryInsert;
					arrQuery[1] = queryUpdate;
					window.parent.xajax_gestHgDtb(3,arrQuery,tipo,frameContent);
				}
			}
			
		}
		else{
			if(tipo == 'paginacion'){				// ELIMINA DE LOS ARREGLOS LOS REGISTROS NUEVOS QUE NO HAN SIDO GUARDADOS AL MOMENTO DE CAMBIAR DE PÁGINA SIN ACEPTAR LA OPCIÓN DE GUARDAR
				var control = true;
				
				for(control; control == true;){
					var posicion = verifPosElement(arrIdReg,'undefined');				
					
					arrCampos 	= delPosArr(arrCampos, 	posicion);
					arrValores 	= delPosArr(arrValores, posicion);
					arrId 		= delPosArr(arrId, 		posicion);
					arrIdReg 	= delPosArr(arrIdReg, 	posicion);
					arrPos 		= delPosArr(arrPos, 	posicion);
					
					cargarDatosTbl();
					control = verifExisElement(arrIdReg,'undefined');				
				}
				recargarInputArreglo();

				if(arrId.length >0){
					document.getElementById('btnModificar').classList.remove("deshabilitado");
					document.getElementById('btnModificar').disabled = '';
				}
				else{
					document.getElementById('btnModificar').classList.add("deshabilitado");
					document.getElementById('btnModificar').disabled = 'disabled';
				}
			}
		}
		if(tipo == 'eliminar') eliminarRegistros(true);
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function eliminarRegistros(ctrlEliminar){
		var i 				= 0;
		var nombTbl 		= document.getElementById('nombreTabla').value;
		var nombTblRel 		= document.getElementById('nombTblRel').value;
		var idTabla 		= document.getElementById('idTabla').value;
		var cantRegDel		= arrRegGest.length;
		var tabla			= null;
		var ctrlRel 		= false;
		var queryDelete 	= new Array();
		
		if(!ctrlEliminar) ctrlEliminar = false;
		
		if(nombTblRel != '') {
			ctrlRel = true;
		}
		
		if (cantRegDel > 0){
			if(ctrlEliminar == false){
				if(arrId.length > 0){
					if(confirm("Antes de borrar los registros seleccionados se procederá a guardar los cambios hechos en la tabla")==true) { guardarCambios("eliminar"); }
				}
				else{
					if(confirm('¿Desea eliminar los registros seleccionados?')==true) eliminarRegistros(true);
				}
			}
			else{
				
				queryDelete[0] = "delete from "+nombTbl+" where "+idTabla+" in ('";

				if(ctrlRel) queryDelete[1] 	= "delete from "+nombTblRel+" where "+idTabla+" in ('";
				
				for(i; i <cantRegDel;i++){
					if(i != (cantRegDel)-1){
						queryDelete[0] += arrRegGest[i] + "','";

						ctrlRel == true ? queryDelete[1] += arrRegGest[i] + "','" : null;
					}
					else{
						queryDelete[0] += arrRegGest[i] + "'";
						
						ctrlRel == true ? queryDelete[1] += arrRegGest[i] + "'" : null;
					}		
				}
				queryDelete[0] += ")";

				if(ctrlRel) queryDelete[1] += ")";

				window.parent.xajax_gestHgDtb(4,queryDelete,'boton',frameContent);	
			}
		}
		else{
			alert("No hay registros seleccionados para ser eliminados");
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function agregarFila(idTablaPpal) {
		goLastPage();																	// UBICA EL DATATABLE EN LA ÚLTIMA PAGINA ANTES DE AGREGAR LA NUEVA FILA	
		var columna 		= new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');	
		var idTabla 		= document.getElementById('idTabla').value;			
		var cantRegActual 	= document.getElementById('cantReg').value;
		var idUltReg		= document.getElementById('idUltReg').value = getLastId(idTablaPpal);
		var celda 			= '';	
		// var nvoValIdReg		= 0;														//CAPTURARÁ EL VALOR QUE LE SERÁ ASIGNADO AL ID DE LA NUEVA FILA
		var dTable 			= $('#'+idTablaPpal).dataTable();  	  
		var table 			= document.getElementById(idTablaPpal);						// CAPTURA EL ELEMENTO TABLA MEDIANTE SU ID      
		var lmtFilas 		= document.getElementById('lmtFilas').value;
		var rowCount 		= table.rows.length -1;
		var rowCountTotal	= dTable.fnGetNodes().length; 								// CAPTURA LA CANTIDA DE FILAS ACTUALES DE LA TABLA 						 	 																 
		var cellCount 		= $("#"+idTablaPpal).find('th').length;						// CAPTURA LA CANTIDAD DE COLUMNAS PRESENTES EN LA TABLA EN FUNCION A LA ULTIMA FILA												  	
		var controlPk 		= verifSolicPk(idTablaPpal,idTabla);						// PARA VERIFICAR SI ALGUNO DE LOS CAMPOS A LLENAR DEL DATATABLE ES EL PK DE LA TABLA
		
		if(cantRegActual == '') var nvoIndice = document.getElementById('cantReg').value = rowCountTotal + 1;
		else var nvoIndice = document.getElementById('cantReg').value = parseInt(cantRegActual) + 1;

		//if(rowCount <= lmtFilas){
			var rowInsert = table.insertRow(rowCount+1);
			rowInsert.setAttribute("class","filaClara");
			rowInsert.id = 0;

			// if(controlPk[0] == false) nvoValIdReg = idUltReg + 1;	// SI NO EXISTE CAMPO PK A LLENAR EL ID DEL REGISTRO DE LA TABLA ES UN VALOR CONSECUTIVO 
							
			for (var i = 0; i <cellCount;i++){	
				celda = rowInsert.insertCell(i);					// INSERTA UNA NUEVA COLUMNA A LA FILA POR CADA COLUMNA CONTADA EN LA FILA ANTERIOR 	  		
				if(i==0){
					celda.setAttribute("class"	, "indice");
					celda.innerHTML = nvoIndice;					// ASIGNA A LA CELDA INDICE EL NUEVO VALOR
					
					if(controlPk[0] == false) celda.setAttribute("id", "id_"+siglas+"_ind_"+nvoIndice);
					else celda.setAttribute("id", "id_"+siglas+"_ind_"+nvoIndice);
					celda.setAttribute("abbr", nvoIndice);		
				}
				else{ 	
					celda.setAttribute("class", dTable.fnGetNodes(0).children[i].className);
					celda.setAttribute("headers", dTable.fnGetNodes(0).children[i].headers);
					
					if(controlPk[0] == false) celda.setAttribute("id", "id_"+siglas+"_"+columna[i-1]+nvoIndice);	
					else celda.setAttribute("id", "id_"+siglas+"_"+columna[i-1]+nvoIndice);  			
				}
			}							
		// }
		// else{
		// 	alert("No puede agregar más filas a la tabla actual. Guarde las modificaciones e intente nuevamente.");
		// 	return false;
		// }
		dimensiones();
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function manejarClases(elemento, accion, tipoAccion){			// GESTIONA LA ACTIVACIÓN O DESACTIVACIÓN DE CLASES ENCARGADAS DE DAR COLOR A LAS FILAS
		var cantCol = elemento.children.length;
		var idReg 	= elemento.id;
		
		if (accion =='agregar') $(elemento).addClass('onCelda');
		if (accion =='remover') $(elemento).removeClass('onCelda');
		if (accion =='agregarPlus') $(elemento).addClass('onCeldaPlus');
		if (accion =='removerPlus') $(elemento).removeClass('onCeldaPlus');
		if (accion =='marcaMutiple'){
			var tipoSombra = '';
			
			switch (tipoAccion){
				case 'eliminar':
					gestInd(elemento,'eliminar');
					tipoSombra = 'celdaDelSeleccionada';
				break;
				case 'seleccionar':
					gestInd(elemento,'seleccion');
					tipoSombra = 'celdaMultiSeleccionada';
				break;
			}
			if(idReg != ''){
				for (var i=1; i<cantCol; i++){
					var td = elemento.children[i];
					if($(td).hasClass(tipoSombra)) $(td).removeClass(tipoSombra);
					else $(td).addClass(tipoSombra);
				}
			}
		}
		if (accion =='marcaUnica'){
			var dTable = $('#tbl').dataTable();
			var cantFilas = dTable.fnGetNodes().length;
			var cantColum = dTable.fnGetNodes(0).children.length;
			
			for (var i=0; i<cantFilas; i++){
				for(var j=1; j<cantColum; j++){
					var celda = dTable.fnGetNodes(i).children[j];
					if(elemento.id == dTable.fnGetNodes(i).id){
						if (!$(celda).hasClass('celdaSeleccionada')) {
							$(celda).addClass('celdaSeleccionada');
						}
					}
					else{
						if ($(celda).hasClass('celdaSeleccionada')) {
							$(celda).removeClass('celdaSeleccionada');
						}
					}
				}
			}
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function gestInd(elemento,accion){					// DETERMINA QUE ACCIÓN REALIZAR AL PULSAR SOBRE LA CELDA INDICE
		var idReg 			= elemento.id;
		var controlExist 	= false;
		var cantReg 		= arrRegGest.length;
		var posReg			= 0;
		var btn				= '';
		
		switch (accion){
			case 'eliminar':
				btn = 'btnEliminar_';
				if(idReg != ''){
					if(cantReg <= 0){
						arrRegGest[cantReg] = idReg;
						document.getElementById('arrRegGest').value = arrRegGest;
					}
					else{
						controlExist = verifExisElement(arrRegGest,idReg);
						
						if (controlExist ==  true){
							posReg = verifPosElement(arrRegGest, idReg);
							arrRegGest = delPosArr(arrRegGest, posReg);
							document.getElementById('arrRegGest').value = arrRegGest;
						}
						else{
							arrRegGest[cantReg] = idReg;
							document.getElementById('arrRegGest').value = arrRegGest;
						}	
					}
				}
				if(arrRegGest.length > 0){
					document.getElementById(btn+siglas).classList.remove("deshabilitado");
					document.getElementById(btn+siglas).disabled = '';
				}
				else{
					document.getElementById(btn+siglas).classList.add("deshabilitado");
					document.getElementById(btn+siglas).disabled = 'disabled';
				}
			break;
			
			case 'seleccion':
				btn = 'btnAceptarSel_';
				if(idReg != ''){
					if(cantReg <= 0){
						arrRegGest[cantReg] = elemento;
						document.getElementById('arrRegGest').value = arrRegGest;
					}
					else{
						controlExist = verifExisElement(arrRegGest,elemento);
						
						if (controlExist ==  true){
							posReg = verifPosElement(arrRegGest, elemento);
							arrRegGest = delPosArr(arrRegGest, posReg);
							document.getElementById('arrRegGest').value = arrRegGest;
						}
						else{
							arrRegGest[cantReg] = elemento;
							document.getElementById('arrRegGest').value = arrRegGest;
						}	
					}
				}
				
				if(arrRegGest.length > 0) document.getElementById(btn+siglas).className = "btnOperacion btnVerde";
				else document.getElementById(btn+siglas).className = "btnOperacion btnVerde deshabilitado";
			break;
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/	
	function crearQuery(arreglo,tipoQuery,nombreTabla,idTabla,valIdTabla,tipoIdTabla,cmpExtTbl,valExtTbl,nombTblRel,cmpRefRel,cmpTblRel,valTblRel,cmpWrExtTbl,valWrExtTbl){
		/**
		 * FUNCIÓN QUE CREA EL QUERY DE LA ACCIÓN A EJECUTAR EN LA BASE DE DATOS
		 * 
		 * @param array arreglo 		ARREGLO QUE CONTIENE LOS INDICES DE TODAS LAS ACCIONES A REALIZAR SOBRE LA BD
		 * @param string tipoQuery		ACCIÓN A EJECUTAR SOBRE LA BD (insert,update)
		 * @param string tabla 			NOMBRE DE LA TABLA SOBRE LA CUAL SE EJECUTARA EL QUERY
		 * @param string idTabla		NOMBRE DEL CAMPO ID DE LA TABLA (NECESARIO SI LA ACCIÓN ES UN UPDATE
		 * 
		 * @returns string
		 */
		var control 		= true;
		var ctrlExt	        = false;
		var ctrlRel	        = false;
		var ctrlWrExt    	= false;
		var ctrlSubQuery    = false;
		var controlCant 	= '';
		var cadena 			= '';  
		var strInsertAct    = '';
		var strValuesAct    = '';
		var subQuery        = '';
		var posQueryAct     = 0;
		var ultCmpRel       = 0;
		var cantCmpRel      = 0;
		var query 			= new Array();
		var queryAct 		= new Array();
		var arrQuery        = new Array();

		for(var r=0; r < arrValores.length; r++) arrValores[r] = arrValores[r].toUpperCase();
	
		if(cmpExtTbl){
			valExtTbl	= valExtTbl.split(',');
			ctrlExt 	= true;
		}
		if(nombTblRel){
			cmpTblRel 	= cmpTblRel.split(',');
			valTblRel 	= valTblRel.split(',');
			ctrlRel 	= true;
		}
		if(cmpWrExtTbl){
			var andExt 	= '';
			cmpWrExtTbl	= cmpWrExtTbl.split(',');
			valWrExtTbl	= valWrExtTbl.split(',');
			ctrlWrExt 	= true;
			for(var q = 0; q < cmpWrExtTbl.length; q++) andExt += 'AND ' + cmpWrExtTbl[q] + " = '" + valWrExtTbl[q] + "' ";
		}
		
		for (var m = 0; m < arreglo.length;m++){
			
			var strInsert = "";
			var strValues = "";
			var strUpdate = "UPDATE " + nombreTabla + " SET ";                     
			var strWhere  = " WHERE " + idTabla + " = ";
			
			controlCant = arreglo[m].toString().indexOf("|");                  		 // VERIFICA SI EXISTE MAS DE UN VALOR EN ESA POSICION DEL ARREGLO     //
			
			if (controlCant == '-1'){                                                // SI SOLO EXISTE UN VALOR SOLO SE REALIZA UPDATE A UN CAMPO DEL REGISTRO	//
				if (tipoQuery == 'update'){
					if(ctrlWrExt) query[m] = strUpdate + arrCampos[arreglo[m]] +" = '"+ trim(arrValores[arreglo[m]]) +"' "+ strWhere + "'" +arrIdReg[arreglo[m]]+ "' " + andExt; 
					else query[m] = strUpdate + arrCampos[arreglo[m]] +" = '"+ trim(arrValores[arreglo[m]]) +"' "+ strWhere + "'" +arrIdReg[arreglo[m]]+ "' ";  
				}
				if (tipoQuery == 'insert'){
					if (arrValores[arreglo[m]] != ''){					             // VERIFICA QUE NO SE INSERTEN CAMPOS EN BLANCO
						if (nombreTabla == "HHot"){
							query[m] = "INSERT INTO " + nombreTabla + " (" + arrCampos[arreglo[m]]+ ", cod_hhot) VALUES (" +" '"+ trim(arrValores[arreglo[m]])+"' "+ ", "+arrPos[arreglo[m]]+")";
						}
						else {
							if (tipoIdTabla == "consecutivo"){

								if(valIdTabla == undefined) valIdTabla = 1;		// PARA INICIALIZAR EL VALOR DEL ID CUANDO LA TABLA NO POSEE NINGÚN REGISTRO
								else if(m == 0) valIdTabla++;			// PARA INCREMENTAR EN UNO EL ID DE FORMA MANUAL DURANTE LA PRIMERA VUELTA GENERANDO EL NUEVO ID

								if(ctrlExt == true){
									for(var p = 0; p < valExtTbl.length; p++){
										if(p == 0){
											query[m] = "INSERT INTO " + nombreTabla + " (" + arrCampos[arreglo[m]]+ ","+idTabla+","+cmpExtTbl+") VALUES ('" + trim(arrValores[arreglo[m]])+"','"+valIdTabla+"','"+valExtTbl[p]+"'";
										}
										else{
											query[m] += ",'" + valExtTbl[p] + "'";
										}
									}
									query[m] += ")";	
								}
								else{
									query[m] = "INSERT INTO " + nombreTabla + " (" + arrCampos[arreglo[m]]+ ","+idTabla+") VALUES ('" + trim(arrValores[arreglo[m]])+"','"+valIdTabla+"')";
								}
							}
							else{
								if(ctrlExt == true){
									for(var p = 0; p < valExtTbl.length; p++){
										if(p == 0){
											query[m] = "INSERT INTO " + nombreTabla + " (" + arrCampos[arreglo[m]]+","+cmpExtTbl+") VALUES ('" + trim(arrValores[arreglo[m]])+"','"+valExtTbl[p]+"'";
										}
										else{
											query[m] += ",'" + valExtTbl[p] + "'";
										}
									}
									query[m] += ")";
								}
								else{
									query[m] = "INSERT INTO " + nombreTabla + " (" + arrCampos[arreglo[m]]+") VALUES ('" + trim(arrValores[arreglo[m]])+"')";
								}
							}
						}
						valIdTabla ++; // INCREMENTA EN UNO EL ID DE FORMA AUTOMÁTICA POR CADA NUEVA FILA
						
						if(ctrlRel == true){
							cantCmpRel = cmpTblRel.length;
							if(arrCampos[m]==cmpRefRel){
								if(cantCmpRel==1){
									if((valTblRel[0]==null)||(valTblRel[0]=='')||(valTblRel[0]==' ')){
										subQuery = "SELECT "+cmpTblRel[0]+" FROM "+nombreTabla+" WHERE "+cmpRefRel+" = '"+trim(arrValores[m])+"'";
										ctrlSubQuery = true;
									}
									if(ctrlSubQuery == true){queryAct[m] = "INSERT INTO " + nombTblRel + " ("+cmpTblRel[0]+") VALUES ("+subQuery+")";}
									else{queryAct[m] = "INSERT INTO " + nombTblRel + " ("+cmpTblRel[0]+") VALUES ('"+valTblRel[0]+"')";}
								}
								else{
									for(var w=0;w<cantCmpRel;w++){
										posQueryAct = queryAct.length;
										ultCmpRel = cantCmpRel -1;
										
										if((valTblRel[w]==null)||(valTblRel[w]=='')||(valTblRel[w]==' ')){
											subQuery = "(SELECT "+cmpTblRel[w]+" FROM "+nombreTabla+" WHERE "+cmpRefRel+" = '"+trim(arrValores[m])+"')";
											ctrlSubQuery = true;
										}
										switch (w){
											case 0:
												strInsertAct = "INSERT INTO " + nombTblRel + " ("+cmpTblRel[w];
												strValuesAct = "VALUES ('"+valTblRel[w]+"'";
											break;
											case ultCmpRel:
												strInsertAct += ", "+cmpTblRel[w]+") ";
												if(ctrlSubQuery == true){strValuesAct += ", "+subQuery+")";}
												else{strValuesAct += ", '"+valTblRel[w]+"')";}
											break;
											default:
												strInsertAct += ", "+cmpTblRel[w];
												if(ctrlSubQuery == true){strValuesAct += ", "+subQuery+"";}
												else{strValuesAct += ", '"+valTblRel[w]+"'";}
											break;
										}
										ctrlSubQuery = false;
									}
									queryAct[m] = strInsertAct + strValuesAct;
								}
							}
						}
					}         	
				}
				//alert(queryAct[m]);
			}
			else {                                            // SI EXISTE MAS DE UN VALOR SIGNIFICA QUE SE MODIFICARON VARIOS CAMPOS DEL REGISTRO                   //
				cadena = arreglo[m].toString().split('|');    // SE CREA UN ARREGLO POR REGISTRO MODIFICADO LLENANDOLO CON LOS VALORES QUE ESTEN ENTRE "|"           //
			
				for (var n = 0; n < cadena.length; n++){ 
					if(control == true){ 
						if(tipoQuery == 'update'){
							query[m] = strUpdate + arrCampos[cadena[n]] +" = '"+ trim(arrValores[cadena[n]])+"' ";
							control = false;
						}
						if(tipoQuery == 'insert'){
							if(arrValores[cadena[n]] != ''){
								strInsert = "INSERT INTO " + nombreTabla + " (" + arrCampos[cadena[n]];
								strValues = " VALUES ('" + trim(arrValores[cadena[n]])+"'";
								control = false;
							}
						}					
					}
					else{  
						if(tipoQuery == 'update'){
							query[m] += ", "+arrCampos[cadena[n]] +" = '"+ trim(arrValores[cadena[n]])+"' ";
						}
						if(tipoQuery == 'insert'){
							if(arrValores[cadena[n]] != ''){
								strInsert += ", "+ arrCampos[cadena[n]];
								strValues += ", '"+ trim(arrValores[cadena[n]]) + "'";
							}
						}
					}
					if (n==(cadena.length)-1){
						if(tipoQuery == 'update'){
							if(ctrlWrExt) query[m] += strWhere + "'" + arrIdReg[cadena[n]] + "' " + andExt;
							else query[m] += strWhere + "'" + arrIdReg[cadena[n]] + "'";
						}
						if(tipoQuery == 'insert'){
							if (nombreTabla=="HHot"){
								strInsert += ", cod_hhot";
								strValues += ", '" + arrPos[cadena[n]] + "";
							}
							else{
								if(control == false){
									if (tipoIdTabla == "consecutivo"){
										if(m==0) valIdTabla++;
										if(ctrlExt == true){
											for(var p = 0; p < valExtTbl.length; p++){
												if(p == 0){
													strInsert += ", " + idTabla + ", " + cmpExtTbl;
													strValues += ", '" + valIdTabla + "', '"+ valExtTbl[p] + "'";
												}
												else{
													strValues += ",'" + valExtTbl[p] + "'";
												}
											}
										} 
										else{
											strInsert += ", " + idTabla;
											strValues += ", '" + valIdTabla + "'"; 
										}
									}
									else{
										if(ctrlExt == true){
											for(var p = 0; p < valExtTbl.length; p++){
												if(p == 0){
													strInsert += ", " + cmpExtTbl;	
													strValues += ", '" + valExtTbl[p] + "'";
												}
												else{
													strValues += ", '" + valExtTbl[p] + "'";
												}
											}
										}		
									} 
								}                       
							}
							if(control == false){
								strInsert += ")";
								strValues += ")";
								query[m] = strInsert + strValues;
							}
							valIdTabla++;
						}
					}
					if(ctrlRel == true){
						cantCmpRel = cmpTblRel.length;
						if(arrCampos[cadena[n]]==cmpRefRel){
							if(cantCmpRel==1){
								if((valTblRel[0]==null)||(valTblRel[0]=='')||(valTblRel[0]==' ')){
									subQuery = "SELECT "+cmpTblRel[0]+" FROM "+nombreTabla+" WHERE "+cmpRefRel+" = '"+trim(arrValores[cadena[n]])+"'";
									ctrlSubQuery = true;
								}
								if(ctrlSubQuery == true){queryAct[m] = "INSERT INTO " + nombTblRel + " ("+cmpTblRel[0]+") VALUES ("+subQuery+")";}
								else{queryAct[m] = "INSERT INTO " + nombTblRel + " ("+cmpTblRel[0]+") VALUES ('"+valTblRel[0]+"')";}
							}
							else{
								for(var w=0;w <cantCmpRel;w++){
									posQueryAct = queryAct.length;
									ultCmpRel   = cantCmpRel -1;
									
									if((valTblRel[w]==null)||(valTblRel[w]=='')||(valTblRel[w]==' ')){                                
										subQuery = "(SELECT "+cmpTblRel[w]+" FROM "+nombreTabla+" WHERE "+cmpRefRel+" = '"+trim(arrValores[cadena[n]])+"')";
										
										ctrlSubQuery = true;
									}
									switch (w){
										case 0:
											strInsertAct = "INSERT INTO " + nombTblRel + " ("+cmpTblRel[w];
											strValuesAct = "VALUES ('"+valTblRel[w]+"'";
										break;
										case ultCmpRel:
											strInsertAct += ", "+cmpTblRel[w]+") ";
											if(ctrlSubQuery == true){strValuesAct += ", "+subQuery+")";}
											else{strValuesAct += ", '"+valTblRel[w]+"')";}
										break;
										default:
											strInsertAct += ", "+cmpTblRel[w];
											if(ctrlSubQuery == true){strValuesAct += ", "+subQuery+"";}
											else{strValuesAct += ", '"+valTblRel[w]+"'";}
										break;
									}
									ctrlSubQuery = false;
								}
								queryAct[m] = strInsertAct + strValuesAct;
							}
							//alert(queryAct[m]);
						}
					}
				}
				control = true;     	// SE REINICIA LA VARIABLE DE CONTROL PARA INDICAR QUE EL SIGUIENTE ARREGLO COMENZARA A LLENARSE DESDE CERO
			}	
		}
		if (query == null){arrQuery[0] = null;}
		else{arrQuery[0] = query;}
		
		if (queryAct != null){arrQuery[1] = queryAct;}
		
		return arrQuery;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function verifValInicial(valor, id, elemento){
		/**
		 * Función encargada de llenar el arreglo de valores iniciales, al tiempo que compara el valor ingresado con el valor inicial de la celda ->
		 * -> de ser iguales borra del arreglo de modificaciones cualquier referencia existente a la celda en cuestión
		 *
		 * @param HTML_element valor 	Valor que posee la celda actual antes de ser modificada.
		 * @param HTML_element id 		Id de la celda que esta siendo modificada.
		 * @param HTML_element elemento Valor que esta siendo ingresado actualmente por el usuario.
		 */		
		
		var posArrInicial = arrInicial.length;
		var ctrlLlenar = true;
		
		if (posArrInicial == 0){
			arrInicial[posArrInicial] = valor;	
		}
		else{
			var controlExiste = verifExisElement(arrId,id);
			if (controlExiste == false){
				arrInicial[posArrInicial] = valor;
			}
			else{
				var posArrId 		= verifPosElement(arrId,id);
				if(arrInicial[posArrId] == elemento){
					ctrlLlenar 	= false;
					arrCampos 	= delPosArr(arrCampos, posArrId);
					arrValores 	= delPosArr(arrValores, posArrId);
					arrId 		= delPosArr(arrId, posArrId);
					arrIdReg 	= delPosArr(arrIdReg, posArrId);
					arrPos 		= delPosArr(arrPos, posArrId);
					arrInicial 	= delPosArr(arrInicial, posArrId);
				}
			}
		}
		return ctrlLlenar;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function detNvoValor(nvoElemento){					// DETERMINA EL NUEVO VALOR QUE SE ESCRIBIRÁ EN EL ARREGLO DE VALORES
		switch (nvoElemento.type){
			case "text":
				var valorCelda = nvoElemento.value;

				if(valorCelda == '__/__/____ __:__') {
					valorCelda 	= '';
				}
				if((valorCelda == '') && (nvoElemento.placeholder == 'Ingrese la nueva opción')){    // VERIFICA SI EL NUEVO VALOR ES VACÍO CUANDO LA FUNCIÓN ESTA SIENDO ACCEDIDA DESDE UNA CELDA SELECT CONVERTIDA EN TEXTO
					valorCelda  = nvoElemento.name;         
				}
				var valorBd = valorCelda;
			break;
			case "checkbox":
				if(nvoElemento.checked == true) {
					var valorCelda  = "SI";			// VALOR VISIBLE EN EL DATATABLE MOSTRADO AL USUARIO
					var valorBd		= 1;
				}
				else {
					var valorCelda  = "NO";
					var valorBd		= 0;
				}
			break;
			case "select-one":
				var opcSelected = nvoElemento.selectedIndex;
				var idSelected 	= nvoElemento.options[opcSelected].id;
				var valorCelda  = nvoElemento.options[opcSelected].value;

				if((idSelected == '')||(idSelected == null)){
					// var valorCelda = '';
				}
				else var valorBd = idSelected;

				if (campoActual.value == 'MostrarCTM'){
					if(valorCelda == 'SI') var valorBd = 1;
					if(valorCelda == 'NO') var valorBd = 0;
				}
			break;
		}

		valor 		= new Array();
		valor[0] 	= valorCelda;
		valor[1] 	= valorBd;

		return valor;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function liberarInputCelda(celda,valor){
		/**
		 * Función encargada de eliminar el input de la celda en el caso de que se haga click fuera de ella y de la tabla.
		 * 
		 * @param HTML_element celda Valor enviado desde el evento onblur de la celda.
		 * @param HTML_element valor Valor enviado desde el evento onblur de la celda.
		 */
		
		celda.innerHTML 	= valor;
		idActual.value 		= '';		 
		valActual.value 	= '';
		campoActual.value	= '';
		regActual.value		= '';
		posActual.value		= '';	
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function llenarArreglos(nvoValor){     
		/**
		 * Función encargada de llenar los arreglos que se utilizaran para crear el query a ejecutar en la BD
		 * 
		 * @param HTML_element nvoElemento Valor enviado desde la función "actualizarValor" al realizar el llamado.
		 */            
		var longitud = arrValores.length;
		var control  = false;                                           // VARIABLE DE CONTROL QUE PERMITE IDENTIFICAR SI ALGUN CAMPO FUE MODIFICADO MAS DE DOS VECES ANTES DE EJECUTAR LA ACCIÓN SOBRE LA BD
	
		for (var i=0;i<=longitud;i++){                       			// RECORRE EL ARREGLO BUSCANDO CAMPOS QUE YA HAYAN SIDO MODIFICADOS	
			if (arrId[i] == idActual.value){               				// SI SE CONSIGUE ALGUN CAMPO QUE YA HAYA SIDO MODIFICADO SE SOBREESCRIBIRÁ CON EL NUEVO VALOR	
				arrValores[i] 	= nvoValor;
				control 		= true;
			}
		}
		if (control == false){                               			// DE NO CONSEGUIRSE NINGUNA MODIFICACION PREVIA SE LE AÑADE AL ARREGLO UNA NUEVA POSICION CON EL NUEVO VALOR       
			arrValores[longitud]	= nvoValor;
			arrId[longitud]  		= idActual.value;
			arrCampos[longitud]     = campoActual.value;
			arrIdReg[longitud]      = regActual.value;
			arrPos[longitud]  		= posActual.value;
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function recargarInputArreglo(){				//PERMITE VISUALIZAR EN INPUT DE TEXTO EL CONTENIDO DE LOS ARREGLOS		
		document.getElementById('arrVal').value		= arrValores;				 
		document.getElementById('arrId').value		= arrId;
		document.getElementById('arrCamp').value	= arrCampos;
		document.getElementById('arrIdReg').value	= arrIdReg;
		document.getElementById('arrPos').value		= arrPos;
		document.getElementById('arrInicial').value	= arrInicial;
		document.getElementById('arrRegGest').value	= arrRegGest;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function cleanArrActual(){
		idActual.value 		= '';		
		valActual.value 	= '';
		campoActual.value	= '';
		regActual.value		= '';
		posActual.value		= '';
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function cleanArreglos(){
		arrCampos.length 	= 0;										
		arrValores.length 	= 0;		 						
		arrInicial.length 	= 0;		 					
		arrId.length 		= 0; 				 		
		arrIdReg.length 	= 0; 			 									
		arrPos.length 		= 0; 				 		
		arrElim.length 		= 0; 			  
		arrRegGest.length 	= 0; 			 
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function extIdRegistro(numFila){  				//EXTRAE EL ID DEL REGISTRO QUE SE ENCUENTRA ALOJADO EN EL TR O FILA		
		var cantFilas = $('#tbl').dataTable().fnGetNodes().length;		
		numFila =  numFila -1;

		if(numFila < cantFilas) var idReg = $('#tbl').dataTable().fnGetNodes(numFila).id;
		else var idReg = '';
		
		return idReg;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function goLastPage(){							//VERIFICA SI EL DATATABLE SE ENCUENTRA POSICIONADO EN LA ULTIMA PÁGINA DE RESULTADOS		
		var control = false;

		if($('#tbl_next').hasClass('ui-state-disabled')) control = true;
		else{
			$("#tbl").dataTable().fnPageChange('last');
			control = false;
		}
		return control;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function getLastId(idTbl){
		var dTable 			= $('#'+idTbl).dataTable();
		var rowCountTotal	= dTable.fnGetNodes().length; 
		var valUltId 		= 0;

		for (var x = 0; x < rowCountTotal; x++){	
			var valIdActual = parseInt(dTable.fnGetNodes(x).id);
			if (valIdActual > valUltId) valUltId = valIdActual;
		}
		return valUltId;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function validarCelda(campo,valNvo,id){
		var control = true;
		var mensaje = '';
		var arrControl 	= new Array();
		
		if(id == ''){		// PARA VALIDAR CUANDO SE HA MODIFICADO UNA NUEVA FILA COLOCANDOLE UN VALOR VACÍO  //
			if((valNvo == '')||(valNvo == "__/__/____ __:__")){
				var existe = verifExisElement(arrId, id);
				if(existe == true){
					control = '2';
					var posicion = verifPosElement(arrId, id);
					arrCampos 	= delPosArr(arrCampos, posicion);
					arrValores 	= delPosArr(arrValores, posicion);
					arrId 		= delPosArr(arrId, posicion);
					arrIdReg 	= delPosArr(arrIdReg, posicion);
					arrPos 		= delPosArr(arrPos, posicion);
				}			
			}
		}
		arrControl=[control,mensaje];

		return arrControl;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function verifSolicPk(idDtb, campoPk){			//VERIFICA SI ENTRE LOS CAMPOS A LLENAR DEL DATATABLE SE ENCUENTRA EL CAMPO PK DE LA TABLA. DEVUELVE TRUE O FALSE Y LA DESCRIPCIÓN DEL CAMPO
		var tabla 		= document.getElementById(idDtb);			
		var cantColums 	= $("#"+idDtb).find('th').length;
		var controlPk 	= false;
		arrControl = new Array();
		
		for (var i = 1; i<cantColums;i++){	
			campoBd = document.getElementById(tabla.rows[1].cells[i].headers).abbr;	
		
			if (campoBd == campoPk){
				var thColum 	= document.getElementById(tabla.rows[1].cells[i].headers);
				var descCampo 	= thColum.getAttribute('name');
				controlPk 		= true;	
			}
		}
		arrControl[0] = controlPk;
		arrControl[1] = descCampo;

		return arrControl;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function limpiarSeleccion(tipo){
		for(var i=0; i<arrRegGest.length;i++){
			if(tipo) var arrCeldas = arrRegGest[i].cells;
			else var arrCeldas = document.getElementById(arrRegGest[i]).cells;
			for(var j=0; j < arrCeldas.length; j++) arrCeldas[j].classList.remove('celdaMultiSeleccionada');
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function verifModPend(){
		if(arrId.length > 0){
			var controlExis = verifExisElement(arrIdReg,0);
			if (controlExis == true) {
				guardarCambios("paginacion");
			}
		}	
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function crearSelect(cantSelect, arrOpcion){
		var letraMay = new Array('A','B','C','D','E','F','G','H','I','J');

		for (var i = 0; i <cantSelect;i++){
			var ind = i+1;
			$("#lista"+ind).append('<select id="select'+letraMay[i]+'" style="width:100%;">'+arrOpcion[i]+'</select>');
		}
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function compValArr(arreglo, valor){			//ELIMINA LOS VALORES REPETIDOS DE UN ARREGLO
		/**
		 * FUNCIÓN ENCARGADA DE ELIMINAR LOS VALORES REPETIDOS DE UN ARREGLO
		 * 
		 * @param array arreglo	ARREGLO QUE SE LLENARÁ CON LOS NUEVOS VALORES
		 * @param string valor	VALORES QUE SE EVALUARAN
		 * 
		 * @returns array
		 */

		var longitud = arreglo.length;
		var check = false;
		
		if (longitud==0) arreglo[longitud]=valor;
		else{	
			for (var i=0;i<arreglo.length;i++) if (arreglo[i]==valor) check = true;
			if(check==false) arreglo[longitud]=valor;
		}
		return arreglo;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function verifExisElement(arreglo,valBusq){	 	//VERIFICA LA EXISTENCIA DE UN VALOR ESPECIFICO EN EL ARREGLO A CONSULTAR	
		var i = 0;
		var control = false;

		for (i; i<arreglo.length;i++) if (valBusq == arreglo[i]) control = true;

		return control;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function verifPosElement(arreglo, valBusq){  	//DEVUELVE LA POSICION DEL ARREGLO EN LA QUE SE ENCUENTRA EL VALOR BUSCADO		
		var i = 0;
		var posElement = 0;
			
		for (i; i<arreglo.length;i++) if(arreglo[i] == valBusq) posElement = i;

		return posElement;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function verifPosElementMult(arreglo, valBusq){ //DEVUELVE LA POSICION DEL ARREGLO EN LA QUE SE ENCUENTRA EL VALOR BUSCADO		
		var i = 0;
		var j = 0;
		var posElement = new Array();
			
		for (i; i<arreglo.length;i++){
			if(arreglo[i] == valBusq){	
				posElement[j]  = i;
				j++;
			}
		}
		return posElement;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function delPosArr(arreglo, posDel){			//ELIMINA LA POSICION DEL ARREGLO QUE CONTENGA EL VALOR BUSCADO	
		var i = 0;
		var j = 0;
		var arregloN = new Array();	
		
		for (i;i<arreglo.length;i++){
			if (i != posDel){
				arregloN[j] = arreglo[i];
				j++;
			}
		}
		return arregloN;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function validarFormatoCelda(e, formatoCelda){	
		var control = true;
		var valor = String.fromCharCode(e.which);
		var arrControl = new Array();
		var mensaje = '';

		if(e.which != 8){ 			// VALIDA QUE NO SE HAYA PISADO LA TECLA BACKSPACE
			control = validarCadena(valor, formatoCelda);
			if(control == false){
				switch (formatoCelda){
					case 'num':
						mensaje = 'Este campo solo admite caracteres numéricos';
					break;
					case 'alpha':
						mensaje ='Este campo solo admite caracteres alfabéticos';
					break;
					case 'alphanum':
						mensaje = 'Este campo no admite caracteres especiales';
					break;
				}
			}
		}
		arrControl[0] = control;
		arrControl[1] = mensaje;

		return arrControl;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function validarCadena(valor,tipo){
		var control = true;
		var validar = null;
		
		switch (tipo) {
			case 'alphanum':
				validar = /[^\wÑñ ]/;	
			break;
			case 'alpha':
				validar = /[^A-Za-zÑñ ]/;		
			break;
			case 'num':
				validar = /[^0-9]/;	
			break;
		}
		control = valor.match(validar); 
		
		if (control == null) control = true;
		else control = false;

		return control;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function ordenarFecha(fecha){	
		var arrFecha = fecha.split('/');
		var aux0 = arrFecha[0];
		var aux1 = arrFecha[1];
		arrFecha[0]=aux1;
		arrFecha[1]=aux0;
		var nvaFecha = arrFecha[0]+"/"+arrFecha[1]+"/"+arrFecha[2];
		
		return nvaFecha;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function extraerNum(cadena){ 					//EXTRAE LOS NUMEROS DE UNA CADENA DE CARACTERES
		/**
		 * Función encargada de evaluar una cadena de caracteres y extraer los numeros presentes en ella.
		 * 
		 * @param string cadena Variable que contiene el valor de la cadena a evaluar
		 */

		cadena = cadena.replace(/[^\d]/g, '');
		return cadena;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function trim(cadena){
		var nvaCadena = cadena.toString().replace(/^\s+/g,'').replace(/\s+$/g,'');
		return nvaCadena;
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function dimensiones(){
		var width 	= $('body').width();
		var height 	= $('body').height() + 5;
		if(window.parent.dimensionDtb) window.parent.dimensionDtb(siglas,width,height);
	}
	/*- ----------------------------------------------------------------------------------------- -*/
	function recargar(){
		cleanArreglos();
		recargarInputArreglo();
		
		$('#ctrlReady').val('0');
		$('#btnModificar_'+siglas).addClass('deshabilitado').prop('disabled',true);
		$('#btnEliminar_'+siglas).addClass('deshabilitado').prop('disabled',true);

		if(json){
			$('#tbl').DataTable().ajax.reload(function(){
				pintarFilas('tbl');
				dimensiones();
				if(tipoBtnDtb == 'A') crearCoordenadas('tbl');
				else $('#ctrlReady').val('1');
			});
		}
		else window.location.assign(window.location.href);

		if(window.parent.reloadDtb) window.parent.reloadDtb();
		else console.log("ERROR: Debe definir la función <reloadDtb> en el tpl.(opcional)");
	}
/* ----------------------------------------------------------------------------------------------------------------------------	*/
/* DESARROLLADOR: HÉCTOR GONZÁLEZ 																								*/
/* *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*- */	