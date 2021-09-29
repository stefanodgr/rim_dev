<?php
    $rutaDir = '../../';
	$rutaControlador = $_SERVER['PHP_SELF'];	// OBTIENE LA UBICACIÓN DEL ARCHIVO INCLUYENDO EL NOMBRE DEL MISMO

	include_once $rutaDir.'config.php';

	// ------------------- XAJAX ------------------- //
		include_once RUTA_SISTEMA.'inc/ajax.php';
		$xajax->printJavascript('../../libreria');
	// --------------------------------------------- //

	isset($_GET['estado']) ? $estado = $_GET['estado'] : $estado = 0;
	
	$TBS = new clsTinyButStrong;

	$titulo = "Prueba de DataTable Funcional cargado desde controlador";
	
	switch ($estado){
	
		case 0:
			$ruta = $rutaDir.'libreria/hg/hg.tpl';
			$TBS->LoadTemplate($ruta);
		break;
		case 1:
			// ------------------------ CUANDO SE CARGA EL DATATABLE DESDE EL CONTROLADOR ----------------------- //
				
				$objeto 	= new Involucrado();
				$arreglo   = $objeto->consultar();
				
				if(count($arreglo)>0){
					foreach($arreglo as $i=>$dato){
						$columna[0] 		= ++$i;
						$columna[1] 		= trim($dato->getAtributo('invol_cedula'));
						$columna[2] 		= trim($dato->getAtributo('invol_nombres'));
						$fila[$i]['id'] 	= trim($dato->getAtributo('invol_id'));
						$fila[$i]['columna']= $columna;
						$data[] 			= $fila[$i];
					}
				}
				else $data = cargarFilaVacia(2,'controlador');

				// echo("<pre>");
				// print_r($data);
				// echo("</pre>");
			// --------------------------------------------------------------------------------------------------- //

			$nombreTabla	= "involucrado";					// NOMBRE DE LA TABLA EN LA BD. 	NOTA: DEFINIR SÓLO SI SE ACTIVA EL TIPO DE BOTÓN <'A'>
			$idTabla 		= "invol_id";						// CAMPO PK DE LA TABLA EN LA BD 	NOTA: DEFINIR SÓLO SI SE ACTIVA EL TIPO DE BOTÓN <'A'>
			$descTabla 		= "Descripción de la tabla";		// TÍTULO QUE APARECERÁ EN LA PARTE SUPERIOR DEL DATATABLE
			$siglas 		= 'sig';							// SIGLAS QUE PERMITEN IDENTIFICAR AL DATATABLE Y AL IFRAME EN QUE SE ENCUENTRA (DEBE SER DE TRES CARACTERES PREFERIBLEMENTE)
			// $tipoCampoPk	= 'serial';							// VARIABLE QUE DEFINE EL TIPO DE PK DE LA TABLA: <OPCIONES: 'serial'> NOTA: AGREGAR ESTA VARIABLE SÓLO SI EL CAMPO PK DE LA BD ES DE TIPO SERIAL.  //
			
			$encabezado = array('Columna1','Columna2');			// ARREGLO QUE ALMACENA LOS NOMBRES DE LAS COLUMNAS A MOSTRAR EN EL DATATABLE
			$columna 	= array('campoBd1','campoBd2');			// ARREGLO QUE ALMACENA LOS NOMBRES DE LOS CAMPOS DE LA BD ASOCIADOS A LAS COLUMNAS A MOSTRAR. 	NOTA: SÓLO LLENAR SI SE ACTIVA EL TIPO DE BOTÓN <'A'>
			$tipo 		= array('text','text');					// ARREGLO QUE ALMACENA LOS TIPOS DE CELDA ASOCIADOS A CADA COLUMNA EDITABLE EDITAR. 			NOTA: SÓLO LLENAR SI SE ACTIVA EL TIPO DE BOTÓN <'A'>
																// OPCIONES: <'text'> 			: PARA CAMPOS DE TEXTO 	
																//			 <'select'> 		: PARA CAMPOS TIPO SELECT	
																//			 <'checkbox'> 		: PARA CAMPOS QUE INCORPOREN UN CHECKBOX
																// 			 <'datepicker'>		: PARA CAMPOS QUE AL SER PULSADOS DESPLIEGAN UN CALENDARIO O UN SELECTOR DE HORA. DEPENDE DEL FORMATO.
																// 			 <'popup'>			: PARA CAMPOS QUE AL SER PULSADOS DESPLIEGAN UNA LISTA

			$formato	= array('alphanum','alphanum');			// ARREGLO QUE ALMACENA LOS FORMATOS DE LAS CELDAS. NOTA: SÓLO LLENAR SI SE ACTIVA EL TIPO DE BOTÓN <'A'> Y EL TIPO DE CELDA ESTÉ DEFINIDO COMO TEXTO O DATEPICKER.
																// OPCIONES: <'alpha'> 			: SOLO LETRAS  
																// 			 <'num'> 			: SOLO NÚMEROS  
																// 			 <'alphanum'> 		: NÚMEROS Y LETRAS
																// 			 <'datetime'> 		: DATEPICKER CON SELECTOR DE FECHA Y HORA
																// 			 <'date'> 			: DATEPICKER CON SELECTOR DE FECHA.
																// 			 <'time'> 			: DATEPICKER CON SELECTOR HORA.
																// 			 <''> Ó <'null'>	: PERMITE CUALQUIER FORMATO

			//$relacion	= array('','');							// ARREGLO QUE ALMACENA LAS RELACIONES DE DEPENDENCIA ENTRE CAMPOS. SE ESCRIBEN LAS LETRAS DE LAS COLUMNAS RELACIONADAS A CADA CAMPO. NOTA: SÓLO LLENAR SI SE ACTIVA EL TIPO DE BOTÓN <'A'>	Y EL TIPO DE CELDA ESTÉ DEFINIDO COMO POPUP		
			//$default	= array('','');							// ARREGLO QUE ALMACENA LOS VALORES POR DEFECTO PARA CELDAS TIPO POPOUP. SE ESCRIBE INFORMACIÓN REFERENTE LA VENTANA QUE ABRIRÁ POR DEFECTO LA CELDA AL SER PULSADA. NOTA: SÓLO LLENAR SI SE ACTIVA EL TIPO DE BOTÓN <'A'> 
			//$visible	= array('','');							// ARREGLO QUE PERMITE DEFINIR QUE COLUMNAS SERAN VISIBLES PARA EL USUARIO. POR DEFECTO TODAS LAS COLUMNAS SON VISIBLES, PARA MODIFICAR ESTE COMPORTAMIENTO ES NECESARIO ESTABLECER EN 'false' LA POSICIÓN DE LA COLUMNA CORRESPONDIENTE. EJ: SI DE TRES COLUMNAS SE QUIERE OCULTAR LA COLUMNA CENTRAL EL ARREGLO DEBE ESTAR DEFINIDO DE LA SIGUIENTE FORMA: <$visible = new Array('','false','');>
						
			// ---------------------------- VARIABLES QUE PERMITEN ACTIVAR LAS FUNCIONALIDADES DEL DATATABLE (EDITABLE - SELECCIONABLE - DE APERTURA) ----------------------------- //
				
				$ctrlFuncion	= true;		// ACTIVA LAS FUNCIONALIDADES DEL DATATABLE. OPCIONES: <true> : <false> . NOTA: SI SE SELECCIONA LA OPCIÓN 'false' EL DATATABLE SOLO FUNCIONARÁ PARA REALIZAR CONSULTAS.
				$ctrlBtnTipo 	= "A";		// TIPOS DE BOTON A ACTIVAR EN EL DATATABLE. DEFINIR SÓLO CUANDO LA VARIABLE "$ctrlFuncion" ESTÉ EN 'true'.
											// OPCIONES:<'A'> -> ACTIVA LOS BOTONES DE AGREGAR, MODIFICAR, ELIMINAR Y EXPORTAR A EXCEL; 
											// 			<'B'> -> MUESTRA LOS BOTONES ACEPTAR Y CANCELAR SELECCIÓN. PERMITE SELECCIONAR MULTIPLES FILAS.
											//			<'C'> -> MUESTRA SOLO EL BOTON DE CANCELAR. PERMITE SELECCIONAR UNA SOLA FILA.
											//			<'D'> -> MUESTRA SOLO EL BOTON DE AGREGAR. PERO A DIFERENCIA DEL BOTÓN "A", EN ESTE CASO SE INVOCA A UNA FUNCIÓN PERSONALIZADA LLAMADA "agregar" QUE DEBE SER IMPLEMENTADA EN EL TPL EN EL QUE SE ENCUENTRA EL IFRAME QUE CONTIENE A LA TABLA. NOTA: REVISAR EL EL ARCHIVO "hg_dtb.js" LA DEFINICIÓN DE LA FUNCIÓN "agregar()" ESTABLECIDA EN LA FUNCION "determinarAccion()".
											//			<'E'> -> MUESTRA EL BOTON AGREGAR PRESENTE EN EL BOTÓN TIPO "D" Y A SU VEZ INCORPORA EL BOTÓN ELIMINAR, QUE AL SER PULSADO INVOCA A LA FUNCION PERSONALIZADA LLAMADA "eliminar()". LA IMPLEMENTACIÓN DE ESTA FUNCIÓN DEBE REALIZARSE EN EL TPL EN EL QUE SE ENCUENTRA EL IFRAME QUE CONTIENE A LA TABLA. NOTA: REVISAR EL EL ARCHIVO "hg_dtb.js" LA DEFINICIÓN DE LA FUNCIÓN "eliminar() ESTABLECIDA EN LA FUNCION "determinarAccion()".
											// NOTA: CUALQUIER OTRA LETRA U OPCIÓN DIFERENTE A: -> <'A'>,<'B'>,<'C'>,<'D'> Ó <'E'> NO ACTIVARÁ NINGÚN BOTÓN; SOLO ACTIVARÁ LA OPCIÓN DE APERTURA EN FUNCIÓN A LA FILA SELECCIONADA.					
			// -------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
				
			$dtsTbl 	= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato,$relacion,$default,$visible);	// FUNCIÓN QUE ORGANIZA LOS DATOS SUMINISTRADOS POR LOS ARREGLOS EN CADA UNOS DE LOS TH DEL DATATABLE	
		
			// ----------------------------------------- VARIABLES QUE PERMITEN AÑADIR DATOS EXTRAS DE MANERA FORZADA AL QUERY FINAL SQL ------------------------------------------ //
				/*
				$cmpExtTbl 	= 'campoFor1,campoFor2,campoFor3';			// CAMPOS EXTRA A AÑADIR (STRING SEPARADO POR COMA)
				$valExtTbl	= 'valFor1,valFor2,valFor3';				// VALORES EXTRA A AÑADIR (STRING SEPARADO POR COMA) ASOCIADOS A LOS CAMPOS DEFINIDOS EN $cmpExtTbl
				*/
			// -------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
			
			// ----------------------------------------- DATOS DE TABLA RELACIÓN. NOTA: SÓLO AGREGAR ESTAS VARIABLES CUANDO SEA NECESARIO ----------------------------------------- //

				// DESCRIPCIÓN: ESTAS VARIABLES PERMITEN REALIZAR UNA INSERCIÓN EN UNA TABLA DE RELACIÓN A PARTIR DE DOS TABLAS, TOMANDO PARA ELLO EL ID DEL REGISTRO DE LA PRIMERA TABLA Y UTILIZANDO UN CAMPO ÚNICO DE LA SEGUNDA TABLA PARA HALLAR EL ID DE DICHO REGISTRO.
				/*
				$nombTblRel     = 'rel_comp_area';        	// NOMBRE DE LA TABLA RELACIÓN EN LA QUE SE INSERTARAN LOS DATOS
				$cmpTblRel      = 'area_id,comp_id';     	// CAMPOS A LLENAR DE LA TABLA RELACIÓN (NORMALMENTE LOS CAMPOS SON LOS PK O ID DE LAS 2 TABLAS DE ORIGEN)
				$valTblRel      = $idReg;					// LOS VALORES PERTENECIENTES A LOS CAMPOS DEFINIDOS EN $cmpTblRel. SI SÓLO SE POSEE UN ID COLOCARLO EN LA POSICIÓN CORRESPONDIENTE Y MEDIANTE $cmpRefTbl HALLAR EL ID FALTANTE.
				$cmpRefTbl      = 'comp_descrip';         	// CAMPO DE LA TABLA PRINCIPAL USADO COMO REFERENCIA PARA HALLAR EL ID DEL REGISTRO QUE SE AGREGARÁ A LA TABLA DE RELACIÓN.
				*/
			// -------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
			
			// ----------------------------------------- VARIABLES QUE PERMITEN AÑADIR DATOS EXTRAS DE MANERA FORZADA AL WHERE DEL QUERY FINAL SQL (PARA UPDATE) ------------------------------------------ //
				/*
				$cmpWrExtTbl 	= 'campo1,campo2'; 		// CAMPOS EXTRA A AÑADIR (STRING SEPARADO POR COMA)
				$valWrExtTbl	= 'valor1,valor2'; 		// VALORES EXTRA A AÑADIR (STRING SEPARADO POR COMA) ASOCIADOS A LOS CAMPOS DEFINIDOS EN $cmpWrExtTbl
				*/
			// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //

			// -------  PARA INCRUSTAR SELECTS DENTRO DE LAS CELDAS EDITABLES. SOLO EN EL CASO DE QUE EXISTAN UNA O VARIAS CELDAS TIPO SELECT  ------- //
				/*	
				// SELECT POR CONSULTA A LA BD		
				$entes = new EntesSeguridad();
				$arrEntes = $entes->consultar();

				foreach ($arrEntes as $i=>$unEnte){
					$option['id'] 		= utf8_encode(trim($unEnte->getAtributo("CodEnte")));		// EL CAMPO ID CONTIENE EL VALOR QUE SE GUARDARÁ EN LA BD
					$option['valor'] 	= utf8_encode(trim($unEnte->getAtributo("DescEnte")));		// EL CAMPO VALOR CONTIENE EL VALOR VISIBLE AL USUARIO EN EL DATATABLE

					$select_descente['columna'] 	= 'descente';		// IMPORTANTE: EL CAMPO COLUMNA CONTIENE EL NOMBRE DE LA COLUMNA BD A LA QUE SERA ASOCIADA EL SELECT AL MOMENTO DE EDITAR
					$select_descente['editable'] 	= true;				// PERMITE CONTROLAR SI AL SELECT SE LE PODRÁN AREGAR NUEVAS OPCIONES O NO. OPCIONES: <true> : <false>
					$select_descente['opcion'][] 	= $option;			// GUARDAR EN ESTA POSICIÓN EL ARREGLO DE OPCIONES DEFINIDO DE FORMA MANUAL O AUTOMÁTICA MEDIANTE CONSULTA A LA BD.
					unset($option);
				}
				*/
				/*
				// SELECT MANUAL
				$option[0]['id']		= 0;
				$option[0]['valor'] 	= 'NO';
				$option[1]['id'] 		= 1;
				$option[1]['valor'] 	= 'SI';
				$select_descente['columna'] = 'descente';
				$select_descente['editable']= true;
				$select_descente['opcion'] 	= $option;
				*/
				// $select = array($select_descente);		// AREGLO QUE COTENDRÁ LOS SELECTS CREADOS. PASAR CADA SELECT COMO PARÁMETROS SEPARADOS POR COMA.
				
			// ------------------------------------------------------------------------------- //

			// PARAMETROS DE INICIACIÓN DEL DATATABLE //
				$opcDtbPag 		= true;								// HABILITA LA PAGINACIÓN: 									<OPCIONES: true, false> //
				$opcDtbPagTyp 	= 'full_numbers';					// DEFINE EL TIPO DE PAGINADOR A UTILIZAR: 					<OPCIONES: 'simple', 'simple_numbers', 'full', 'full_numbers'> //
				$opcDtbFil 		= true;								// MUESTRA EL FILTRO DE BUSQUEDA: 							<OPCIONES: true, ''> //
				$opcDtbInf 		= '';								// MUESTRA INFORMACION DE CANTIDAD DE REGISTROS:			<OPCIONES: true, ''> //
				$opcDtbCanFil 	= 5;								// DEFINE LA CANTIDAD DE FILAS QUE SE MOSTRARAN POR PAGINA:	<OPCIONES: #(UN NUMERO)> //
				// $sWTitulo 		= 65;							// DEFINE EL TAMAÑO DEL ANCHO DEL DIV QUE CONTIENE EL TÍTULO DE LA TABLA. POR DEFECTO ES 65%. //
				// $sWSearch 		= 10;							// DEFINE EL TAMAÑO DEL ANCHO DEL INPUT DE BUSQUEDA DEL DATATABLE. //
			// -------------------------------------- //

			$ruta = $rutaDir.'libreria/hg/hg_dtb.tpl';							// RUTA DEL TPL DONDE SE ENCUENTRA LA PLANTILLA DEL DATATABLE EDITABLE

			$TBS -> LoadTemplate($ruta);
			$TBS -> MergeBlock('dtsTbl',$dtsTbl);
			$TBS -> MergeBlock('data',$data);					// SÓLO CUANDO LA CARGA DEL DATATABLE NO SE EJECUTA MEDIANTE JSON.
			// $TBS -> MergeBlock('select',$select);			// SÓLO CUANDO SE HAN DEFINIDO SELECT PARA SER CARGADOS EN EL DATATABLE. 

			// echo("<pre>");
			// print_r($select);
			// echo("</pre>");
		break;
	}
	$TBS->Show();
?>