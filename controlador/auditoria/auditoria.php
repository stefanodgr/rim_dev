<?php
    $rutaDir = "../../";
	include_once $rutaDir.'config.php';

	$ctrlAcceso = validarConexion();

	if($ctrlAcceso){
		$TBS = new clsTinyButStrong;

		isset($_GET['case']) 		? $case 		= $_GET['case'] 		: $case 		= 0;
		isset($_GET['tipoAudit']) 	? $tipoAudit 	= $_GET['tipoAudit'] 	: $tipoAudit 	= null;
		isset($_GET['fechaDesde']) 	? $fechaDesde 	= $_GET['fechaDesde'] 	: $fechaDesde 	= null;
		isset($_GET['fechaHasta']) 	? $fechaHasta 	= $_GET['fechaHasta'] 	: $fechaHasta 	= null;

		$titulo = 'Auditoría';

		switch($case){
			case 0:
				$miTipoAuditoria   = new TipoAuditoria();
				$arrTipoAuditoria = $miTipoAuditoria->consultar();

				foreach ($arrTipoAuditoria as $i=>$unTipoAuditoria){
					$tipoAuditoria[$i]['tipoId']     = $unTipoAuditoria->getAtributo('tipo_auditoria_id');
					$tipoAuditoria[$i]['tipoDesc']   = $unTipoAuditoria->getAtributo('tipo_auditoria_desc');
				}	
				$tipoActividadId=0;

				$vista = $rutaDir.'vista/auditoria/auditoria.tpl';

				$TBS = new clsTinyButStrong;
				$TBS->LoadTemplate($vista);
				$TBS->MergeBlock('tipoAuditoria',$tipoAuditoria);
			break;
			case 1:
				$descTabla 		= 'Registro de Auditoría';
				$siglas 		= 'aud';
				$encabezado		= array('Tipo de Auditoria','Observación','Usuario','Fecha / Hora','Dirección IP');
				$ctrlFuncion	= false;
				$dtsTbl 		= crearDtsTbl($siglas,$encabezado);

				$opcDtbPag 		= true;				
				$opcDtbPagTyp 	= 'simple_numbers'; 
				$opcDtbFil 		= true;			
				$opcDtbInf 		= true;			
				$opcDtbCanFil 	= 50;

				$vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
				$rutaJson 	= $rutaDir."json/auditoria.php?case=0&tipoAudit=".$tipoAudit."&fechaDesde=".$fechaDesde."&fechaHasta=".$fechaHasta;
				
				$TBS -> LoadTemplate($vista);
				$TBS -> MergeBlock('dtsTbl',$dtsTbl);
			break;
		}
		$TBS->Show();
	}
?>