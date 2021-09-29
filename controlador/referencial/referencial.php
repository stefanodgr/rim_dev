<?php
	$rutaDir = "../../";
	include_once $rutaDir.'config.php';

    $ctrlAcceso = validarConexion();

	if($ctrlAcceso){
        $TBS = new clsTinyButStrong;

        $perfilUsuario=$_SESSION['PerfilUsuario'];

        isset($_GET['estado'])  ? $estado   = $_GET['estado']   : $estado   = null;
        isset($_GET['case'])    ? $case     = $_GET['case']     : $case     = null;
        isset($_GET['ubiId'])   ? $ubiId    = $_GET['ubiId']    : $ubiId    = null;

        $titulo = 'Referenciales';

        //se verifica la sesion y acceso del usuario
        $miConexionBd = new ConexionBd();
        $miUsuario = new Usuario($miConexionBd);
        validarConexion($miUsuario);

        if($estado){
            unset($estado);
            $rutaReferencial = 'controlador/referencial/referencial.php?case='.$case;
            $vista = $rutaDir.'vista/referencial/referencial.tpl';
            $TBS->LoadTemplate($vista);
        }
        else{
            switch($case){
                case 0:     
                    // TIPOS DE ACTIVIDAD //
                    $descTabla 		= 'Tipos de Actividad';
                    $nombreTabla	= "tipo_actividad";
                    $idTabla        = 'tipo_activ_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('tipo_activ_desc');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=0';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 1:
                    // TIPOS DE DOCUMENTOS //
                    $descTabla 		= 'Tipos de Documentos';
                    $nombreTabla	= "tipo_documento";
                    $idTabla        = 'tipo_doc_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('tipo_doc_desc');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=1';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 2:
                    // CUERPOS DE SEGURIDAD //
                    $descTabla 		= 'Cuerpos de Seguridad';
                    $nombreTabla	= "cuerpo";
                    $idTabla        = 'cuerpo_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('cuerpo_desc');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=2';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 3:
                    // TIPOS DE VEHÍCULOS //
                    $descTabla 		= 'Tipos de Vehículos';
                    $nombreTabla	= "tipo_vehiculo";
                    $idTabla        = 'tipo_vehiculo_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('tipo_vehiculo_desc');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=3';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 4:
                    // MARCAS DE VEHÍCULOS //
                    $descTabla 		= 'Marcas de Vehículos';
                    $nombreTabla	= "marca";
                    $idTabla        = 'marca_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('marca_desc');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=4';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 5:
                    // MATERIAL COMISADO //
                    $descTabla 		= 'Material Comisado';
                    $nombreTabla	= "tipo_material";
                    $idTabla        = 'tipo_mat_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('tipo_mat_desc');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $cmpExtTbl 	= 'categoria';
                    $valExtTbl	= 'MATERIAL';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=5';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 6:
                    // MEDIOS DE COMISIÓN //
                    $descTabla 		= 'Medios de Comisión';
                    $nombreTabla	= "tipo_material";
                    $idTabla        = 'tipo_mat_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('tipo_mat_desc');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $cmpExtTbl 	= 'categoria';
                    $valExtTbl	= 'MEDIO COMISION';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=6';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 7:
                    // LINEAS //
                    $descTabla 		= 'Ubicaciones';
                    $nombreTabla	= "linea";
                    $idTabla        = 'linea_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ubi';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('linea_nombre');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';                

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;					
                    $sWSearch 		= 100;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=7';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 8:
                    // ESTACIONES //
                    $descTabla 		= 'Estaciones y Estructuras';
                    $nombreTabla	= "estacion";
                    $idTabla        = 'estacion_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'lug';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('estacion_nombre');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $cmpExtTbl 	= 'linea_id';
                    $valExtTbl	= $ubiId;

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    $sWSearch 		= 100;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=8&ubiId='.$ubiId;

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
                case 9:
                    // SANCIONES //
                    $descTabla 		= 'Sanciones';
                    $nombreTabla	= "sancion";
                    $idTabla        = 'sancion_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción','Aplicable a');
                    $columna 	    = array('sancion_desc','sancion_tipo');					
                    $tipo 		    = array('text','select');
                    $formato	    = array('alphanum');

                    $option[0]['id']		= 'USUARIO';
                    $option[0]['valor'] 	= 'USUARIO';
                    $option[1]['id'] 		= 'PERSONAL METRO';
                    $option[1]['valor'] 	= 'PERSONAL METRO';
                    $select_sancion_tipo['columna'] = 'sancion_tipo';
                    $select_sancion_tipo['editable']= true;;
                    $select_sancion_tipo['opcion'] 	= $option;

                    $select = array($select_sancion_tipo);

                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    $sWSearch 		= 100;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=9';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                    $TBS -> MergeBlock('select',$select);
                break;
                case 10:
                    // MEDIDAS CAUTELARES //
                    $descTabla 		= 'Medidas Cautelares';
                    $nombreTabla	= "medida_cautelar";
                    $idTabla        = 'medida_id';
                    $tipoCampoPk	= 'serial';
                    $siglas 		= 'ref';
                    $encabezado		= array('Descripción');
                    $columna 	    = array('medida_desc');					
                    $tipo 		    = array('text');
                    $formato	    = array('alphanum');
                    $ctrlFuncion	= true;	
                    $ctrlBtnTipo    = 'A';

                    $dtsTbl 		= crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato);

                    $opcDtbPag 		= true;				
                    $opcDtbPagTyp 	= 'simple_numbers';
                    $opcDtbFil 		= true;			
                    $opcDtbInf 		= false;			
                    $opcDtbCanFil 	= 10;
                    $sWSearch 		= 100;
                    
                    $vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';
                    $rutaJson 	= $rutaDir.'json/referencial.php?case=10';

                    $TBS -> LoadTemplate($vista);
                    $TBS -> MergeBlock('dtsTbl',$dtsTbl);
                break;
            }
        }
        $TBS->Show();
    }
?>