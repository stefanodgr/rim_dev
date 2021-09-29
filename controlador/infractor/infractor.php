<?php
	$rutaDir = "../../";
	include_once $rutaDir.'config.php';

	$ctrlAcceso = validarConexion();

	if($ctrlAcceso){
		$TBS = new clsTinyButStrong;

		$perfilUsuario = $_SESSION['PerfilUsuario'];

		isset($_GET['case']) 		? $case 	= $_GET['case'] 	: $case 	= 0;
		isset($_GET['lista']) 		? $lista 	= $_GET['lista'] 	: $lista 	= null;
		isset($_GET['infId']) 		? $infId 	= $_GET['infId'] 	: $infId 	= null;
		isset($_GET['infNombre']) 	? $infNombre= $_GET['infNombre']: $infNombre= null;

		$titulo = 'Infractores';

		switch($case){
			case 0:
				$miLinea    = new Linea($miConexionBd);
				$arrLinea = $miLinea->consultar();

				if($perfilUsuario=="MASTER") $btnReporte='<input  type="button" id="btnReporte" value="REPORTE HISTORIAL" onclick="ReporteHistorial();"/>';
				
				foreach ($arrLinea as $i=>$unaLinea){
					$Lineas[$i]['linea_id'] 	= $unaLinea->getAtributo('linea_id');
					$Lineas[$i]['linea_nombre'] = $unaLinea->getAtributo('linea_nombre');
				}	
				
				//Cargamos las Actividades o Infracciones que llenan el select selActividad
				$miTipoActividad  = new TipoActividad($miConexionBd);

				$arrTipoActividad = $miTipoActividad->consultar();

				foreach ($arrTipoActividad as $i=>$unTipoActividad){
					$TipoActividad[$i]['tipo_activ_id'] 	= $unTipoActividad->getAtributo('tipo_activ_id');
					$TipoActividad[$i]['tipo_activ_desc'] 	= $unTipoActividad->getAtributo('tipo_activ_desc');
				}	

				$miStatus   = new Status($miConexionBd);
				$arrStatus = $miStatus->consultar();

				foreach ($arrStatus as $i=>$unStatus){
					$estado[$i]['id'] 	= $unStatus->getAtributo('status_id');
					$estado[$i]['desc'] = $unStatus->getAtributo('status_desc');
				}

				$vista = $rutaDir.'vista/infractor/infractor.tpl';
				$TBS->LoadTemplate($vista);
				$TBS->MergeBlock('lineas',$Lineas);
				$TBS->MergeBlock('TipoActividad',$TipoActividad);
				$TBS->MergeBlock('estado',$estado);
			break;
			case 1:
				// $descTabla 		= 'Expediente de: '.$infNombre;
				$descTabla 		= 'Expediente del Infractor';
				$siglas 		= 'exp';
				$encabezado		= array('Nro. RIM','Tipo de Infracción','Ubicación','Fecha','Sanción','Medida Cautelar','Registrado por');
				$ctrlFuncion	= true;	
				$dtsTbl 		= crearDtsTbl($siglas,$encabezado);

				$opcDtbPag 		= true;				
				$opcDtbPagTyp 	= 'full_numbers';
				$opcDtbFil 		= true;			
				$opcDtbInf 		= true;			
				$opcDtbCanFil 	= 10;
				// $sWTitulo 		= 60;	
				// $sWSearch 		= 40;
				
				$vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
				$rutaJson 	= $rutaDir.'json/infractor.php?case=0&infId='.$infId;

				$TBS -> LoadTemplate($vista);
				$TBS -> MergeBlock('dtsTbl',$dtsTbl);
			break;
			case 2:
				if(is_array($lista)) $lista = implode(',',$lista);
				else $lista = $lista;

				$descTabla 		= 'Seleccione una persona de la lista:';
				$siglas 		= 'lis';
				$encabezado		= array('Cédula','Nombre','Apellido','Alias','Banda');
				$ctrlFuncion	= true;	
				$ctrlBtnTipo 	= 'C';
				$dtsTbl 		= crearDtsTbl($siglas,$encabezado);

				$opcDtbPag 		= true;				
				$opcDtbPagTyp 	= 'full_numbers';
				$opcDtbFil 		= true;			
				$opcDtbInf 		= false;			
				$opcDtbCanFil 	= 10;
				// $sWTitulo 		= 60;	
				// $sWSearch 		= 40;
				
				$vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
				$rutaJson 	= $rutaDir.'json/infractor.php?case=1&lista='.$lista;

				$TBS -> LoadTemplate($vista);
				$TBS -> MergeBlock('dtsTbl',$dtsTbl);
			break;
		}
		$TBS->Show();
	}
?>