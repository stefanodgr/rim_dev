<?php
	$rutaDir = "../../";
	include_once $rutaDir.'config.php';

    $ctrlAcceso = validarConexion();

	if($ctrlAcceso){
        $TBS = new clsTinyButStrong;

        $descTabla 		= 'Usuarios Conectados';
        $nombreTabla	= "conexion";
        $siglas 		= 'con';
        $encabezado		= array('Login','Perfil','Inicio de Sesión','Dirección Ip');	
        $ctrlFuncion	= false;	

        $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

        $opcDtbPag 		= true;				
        $opcDtbPagTyp 	= 'simple_numbers';
        $opcDtbFil 		= true;			
        $opcDtbInf 		= true;			
        $opcDtbCanFil 	= 10;

        $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
        $rutaJson 	= $rutaDir.'json/conexion.php?case=0';

    
        $TBS -> LoadTemplate($vista);
        $TBS -> MergeBlock('dtsTbl',$dtsTbl);
        $TBS->Show();
    }
?>