<?php
	$rutaDir = "../../";
	include_once $rutaDir.'config.php';

	$ctrlAcceso = validarConexion();

	if($ctrlAcceso){
		isset($_GET['case']) 			? $case 		= $_GET['case'] 		: $case 		= null;
		isset($_GET['idInfraccion']) 	? $idInfraccion = $_GET['idInfraccion'] : $idInfraccion = null;

		$perfilUsuario = $_SESSION['PerfilUsuario'];

		$TBS = new clsTinyButStrong;
		
		$titulo = 'Infracciones';
		
		switch($case){
			case 0:
				$linea    = new Linea($miConexionBd);
				$arrLinea = $linea->consultar();
				unset($linea);

				$perfilUsuario == "MASTER" ? $ctrlReporteLista 	= '' : $ctrlReporteLista = 'oculto';

				if(($perfilUsuario == "MASTER") || ($perfilUsuario == 'GERENCIAL')) $ctrlReporteInf = '';
				else $ctrlReporteInf = 'oculto';
				
				foreach ($arrLinea as $i=>$linea){
					$lineas[$i]['linea_id'] 	= $linea->getAtributo('linea_id');
					$lineas[$i]['linea_nombre'] = $linea->getAtributo('linea_nombre');
				}	
				
				//Cargamos las Actividades o Infracciones que llenan el select selActividad
				$tipoActividad  = new TipoActividad();
				$arrTipoActividad = $tipoActividad->consultar();
				unset($tipoActividad);

				foreach ($arrTipoActividad as $i=>$actividad){
					$tipoActividad[$i]['tipo_activ_id'] 	= $actividad->getAtributo('tipo_activ_id');
					$tipoActividad[$i]['tipo_activ_desc'] 	= $actividad->getAtributo('tipo_activ_desc');
				}	

				$miStatus   = new Status($miConexionBd);
				$arrStatus = $miStatus->consultar();

				foreach ($arrStatus as $i=>$unStatus){
					$estado[$i]['id'] 	= $unStatus->getAtributo('status_id');
					$estado[$i]['desc'] = $unStatus->getAtributo('status_desc');

					// if($perfilUsuario == "GERENCIAL"){
					// 	if($unStatus->getAtributo('status_desc') == 'PROCESADO'){
					// 		$estado[$i]['id'] 	= $unStatus->getAtributo('status_id');
					// 		$estado[$i]['desc'] = $unStatus->getAtributo('status_desc');
					// 	}
					// }
					// else{
					// 	$estado[$i]['id'] 	= $unStatus->getAtributo('status_id');
					// 	$estado[$i]['desc'] = $unStatus->getAtributo('status_desc');
					// }
				}

				$cuerpo   	= new Cuerpo($miConexionBd);
				$arrCuerpo 	= $cuerpo->consultar();
				unset($cuerpo);

				foreach ($arrCuerpo as $i=>$unCuerpo){
					$cuerpo[$i]['id'] 	= $unCuerpo->getAtributo('cuerpo_id');
					$cuerpo[$i]['desc'] = $unCuerpo->getAtributo('cuerpo_desc');
				}

				$tipoDoc   	= new TipoDocumento($miConexionBd);
				$arrTipoDoc = $tipoDoc->consultar();
				unset($tipoDoc);

				foreach ($arrTipoDoc as $i=>$unTipoDoc){
					$tipoDoc[$i]['id'] 	= $unTipoDoc->getAtributo('tipo_doc_id');
					$tipoDoc[$i]['desc']= $unTipoDoc->getAtributo('tipo_doc_desc');
				}

				$tipoMat   	= new TipoMaterial($miConexionBd);
				$tipoMat->setAtributo('categoria','MATERIAL');
				$arrTipoMat = $tipoMat->consultar();
				unset($tipoMat);

				foreach ($arrTipoMat as $i=>$unTipoMat){
					$tipoMat[$i]['id'] 	= $unTipoMat->getAtributo('tipo_mat_id');
					$tipoMat[$i]['desc']= $unTipoMat->getAtributo('tipo_mat_desc');
				}

				$arrUnidad[0]="UNIDAD";
				$arrUnidad[1]="BOLSA";
				$arrUnidad[2]="CAJA";
				$arrUnidad[3]="PAQUETE";

				foreach ($arrUnidad as $i=>$unaUnidad){
					$unidad[$i]['id'] 	= $unaUnidad;
					$unidad[$i]['desc'] = $unaUnidad;
				}

				$tipoMed = new TipoMaterial($miConexionBd);
				$tipoMed->setAtributo('categoria','MEDIO COMISION');
				$arrTipoMed = $tipoMed->consultar();
				unset($tipoMed);

				foreach ($arrTipoMed as $i=>$unTipoMed){
					if($unTipoMed->getAtributo('tipo_mat_desc') != 'VEHICULO'){
						$tipoMed[$i]['id'] 	= $unTipoMed->getAtributo('tipo_mat_id');
						$tipoMed[$i]['desc']= $unTipoMed->getAtributo('tipo_mat_desc');
					}
				}

				$tipoVehi = new TipoVehiculo($miConexionBd);
				$arrTipoVehi = $tipoVehi->consultar();
				unset($tipoVehi);

				foreach ($arrTipoVehi as $i=>$unTipoVehi){
					$tipoVehi[$i]['id'] 	= $unTipoVehi->getAtributo('tipo_vehiculo_id');
					$tipoVehi[$i]['desc'] 	= $unTipoVehi->getAtributo('tipo_vehiculo_desc');
				}

				$marca = new Marca($miConexionBd);
				$arrMarca = $marca->consultar();
				unset($marca);

				foreach ($arrMarca as $i=>$unaMarca){
					$marca[$i]['id'] 	= $unaMarca->getAtributo('marca_id');
					$marca[$i]['desc'] 	= $unaMarca->getAtributo('marca_desc');
				}

				$sancion = new Sancion($miConexionBd);
				$arrSancion = $sancion->consultar();
				unset($sancion);

				foreach ($arrSancion as $i=>$unaSancion){
					$sancion[$i]['id'] 	= $unaSancion->getAtributo('sancion_id');
					$sancion[$i]['desc']= $unaSancion->getAtributo('sancion_desc');

					if($unaSancion->getAtributo('sancion_tipo') == 'USUARIO') $sancion[$i]['tipo'] = 'sanc_usu';
					else $sancion[$i]['tipo'] = 'sanc_tra';
				}

				$medida = new MedidaCautelar($miConexionBd);
				$arrMedida = $medida->consultar();
				unset($medida);

				foreach ($arrMedida as $i=>$unaMedida){
					$medida[$i]['id'] 	= $unaMedida->getAtributo('medida_id');
					$medida[$i]['desc'] = $unaMedida->getAtributo('medida_desc');
				}

				$vista = $rutaDir.'vista/infraccion/infraccion.tpl';

				$TBS->LoadTemplate($vista);
				$TBS->MergeBlock('lineas',$lineas);
				$TBS->MergeBlock('ubicacion',$lineas);
				$TBS->MergeBlock('tipoActividad',$tipoActividad);
				$TBS->MergeBlock('tipoActividad2',$tipoActividad);
				$TBS->MergeBlock('estado',$estado);
				$TBS->MergeBlock('estado2',$estado);
				$TBS->MergeBlock('cuerpo',$cuerpo);
				$TBS->MergeBlock('tipoDoc',$tipoDoc);
				$TBS->MergeBlock('tipoMat',$tipoMat);
				$TBS->MergeBlock('unidad',$unidad);
				$TBS->MergeBlock('tipoMed',$tipoMed);
				$TBS->MergeBlock('tipoVehi',$tipoVehi);
				$TBS->MergeBlock('marca',$marca);
				$TBS->MergeBlock('sancion',$sancion);
				$TBS->MergeBlock('medida',$medida);
			break;
			case 1:	
				isset($_GET['tipo']) 	? $tipo 	= $_GET['tipo'] 	: $tipo 	= null;
				isset($_GET['filtros']) ? $filtros 	= $_GET['filtros'] 	: $filtros 	= null;

				$descTabla 		= 'Listado de Infracciones';
				$siglas 		= 'inf';
				$encabezado		= array('Nro. RIM','Ubicación','Actividad','Fecha','Estado','Registrado por','Fecha Registro');

				if($_SESSION['PerfilUsuario'] == 'CONSULTA'){
					$ctrlFuncion= false;
					$opcDtbInf 	= true;
				}
				else{
					$ctrlFuncion	= true;
					$ctrlBtnTipo 	= 'E';
					$opcDtbInf 		= false;
				}
				
				$dtsTbl 		= crearDtsTbl($siglas,$encabezado);
				$opcDtbPag 		= true;				
				$opcDtbPagTyp 	= 'full_numbers';
				$opcDtbFil 		= true;				
				$opcDtbCanFil 	= 10;
				
				switch($tipo){
					case 'inicial':
						$rutaJson 	= $rutaDir.'json/infraccion.php?case=0&tipo=inicial';
					break;
					case 'basica':
						$rutaJson 	= $rutaDir.'json/infraccion.php?case=0&filtros='.$filtros;
					break;
					case 'avanzada':
						$rutaJson 	= $rutaDir.'json/infraccion.php?case=0&tipo=avanzada&filtros='.$filtros;
					break;
				}

				$vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';

				$TBS -> LoadTemplate($vista);
				$TBS -> MergeBlock('dtsTbl',$dtsTbl);
			break;
			case 2:
				isset($_GET['tipoInvol']) 	? $tipoInvol  	= $_GET['tipoInvol']  	: $tipoInvol  	= null;
				isset($_GET['infEstado']) 	? $infEstado 	= $_GET['infEstado'] 	: $infEstado 	= null;

				switch($tipoInvol){

					case 'DETENIDO':
						$descTabla 	= 'Detenidos';
						$siglas 	= 'det';
						$encabezado	= array('Cédula','Nombre','Apellido','Alias','Banda','Sujeto','Sanción','Medida');
						$json 		= $rutaDir.'json/infraccion.php?case=1&idInfraccion='.$idInfraccion.'&tipoInvol='.$tipoInvol;
					break;
					case 'VICTIMA': 
						$descTabla 	= 'Víctimas';
						$siglas 	= 'vic';  
						$encabezado	= array('Cédula','Nombre','Apellido');
						$json 		= $rutaDir.'json/infraccion.php?case=1&idInfraccion='.$idInfraccion.'&tipoInvol='.$tipoInvol;
					break;
					case 'FUNCIONARIO': 
						$descTabla 	= 'Funcionarios';
						$siglas 	= 'fun';  
						$encabezado	= array('Cédula','Nombre','Apellido','Cuerpo');
						$json 		= $rutaDir.'json/infraccion.php?case=1&idInfraccion='.$idInfraccion.'&tipoInvol='.$tipoInvol;
					break;
					case 'PERSONAL METRO': 
						$descTabla 	= 'Personal Metro';
						$siglas 	= 'per';  
						$encabezado	= array('Cédula','Nombre','Apellidos','Cargo');
						$json 		= $rutaDir.'json/infraccion.php?case=1&idInfraccion='.$idInfraccion.'&tipoInvol='.$tipoInvol;
					break;
					case 'DOCUMENTO': 
						$descTabla 	= 'Documentos';
						$siglas 	= 'doc';  
						$encabezado	= array('Tipo','Número','Fecha');
						$json 		= $rutaDir.'json/infraccion.php?case=2&idInfraccion='.$idInfraccion;
					break;
					case 'MATERIAL': 
						$descTabla 	= 'Material Comisado';
						$siglas 	= 'mat';  
						$encabezado	= array('Precinto','Material','Cantidad','Unidad','Descripcion');
						$json 		= $rutaDir.'json/infraccion.php?case=3&idInfraccion='.$idInfraccion.'&tipoMaterial=material';
					break;
					case 'MEDIO': 
						$descTabla 	= 'Medio de Comisión';
						$siglas 	= 'med';  
						$encabezado	= array('Precinto','Medio','Cantidad','Descripcion');
						$json 		= $rutaDir.'json/infraccion.php?case=3&idInfraccion='.$idInfraccion.'&tipoMaterial=medio';
					break;
					case 'VEHICULO': 
						$descTabla 	= 'Vehículos -> Medio de Comisión';
						$siglas 	= 'veh';  
						$encabezado	= array('Tipo','Placa','Marca','Modelo','Color','Observación');
						$json 		= $rutaDir.'json/infraccion.php?case=4&idInfraccion='.$idInfraccion;
					break;
					// case 'DETENIDO': $siglas = 'det'; break;
				}

				$dtsTbl 		= crearDtsTbl($siglas,$encabezado);

				if($infEstado != 'PROCESADO'){
					$ctrlFuncion 	= true;
					$ctrlBtnTipo 	= 'E';
					$opcDtbInf 		= false;	
				}
				else{
					$ctrlFuncion 	= false;
					$opcDtbInf 		= true;	
				}

				$opcDtbPag 		= false;				
				$opcDtbPagTyp 	= 'full_numbers';
				$opcDtbFil 		= false;		
				// $opcDtbCanFil 	= 10;
				
				$rutaJson 	= $json;
				$vista 		= $rutaDir.'libreria/hg/hg_dtb_json.tpl';

				$TBS -> LoadTemplate($vista);
				$TBS -> MergeBlock('dtsTbl',$dtsTbl);
			break;
			case 3:
				isset($_GET['activId']) ? $activId = $_GET['activId'] : $activId = null;

				$extensions = array('jpg','jpeg','png');
				$opciones 	= array('limit' 		=> 8,
									'maxSize' 		=> null,
									'fileMaxSize' 	=> null,
									'extensions' 	=> $extensions,
									'required' 		=> false,
									'uploadDir' 	=> $rutaDir.'multimedia/imagen/evidencia/',
									'title' 		=> $activId.'_{random}',
									'replace' 		=> true,
									'listInput' 	=> true,
									'files' 		=> null);

				$FileUploader 	= new FileUploader('files',$opciones);
				$resultado 		= $FileUploader->upload();

				if(($resultado['isSuccess']) && (count($resultado['files']) > 0)){
					$ctrlUpload 	= 1;
					$arrImagenes 	= $resultado['files'];
					$fechaRegistro  = formatoFechaHoraBd();
					$conexionBd 	= new ConexionBd();
					$conexionBd->hacerConsulta("BEGIN");

					foreach($arrImagenes as $i=>$imagen){
						$evidencia = new FotoAdicional($conexionBd);
						$evidencia->setAtributo('foto_desc',		$imagen['name']);
						$evidencia->setAtributo('foto_fecha_reg',	$fechaRegistro);
						$evidencia->setObjeto('Actividad', 	$activId);
						$evidencia->setObjeto('Conexion', 	$_SESSION['IdConexion']);
						
						$ctrlRegUpl = $evidencia->registrar();
						if(!$ctrlRegUpl){
							$conexionBd->hacerConsulta('ROLLBACK');
							echo('ERROR: Hubo un problema al cargar las imágenes');
							break;
						}
						else unset($evidencia);
					}
					if($ctrlRegUpl){
						$conexionBd->hacerConsulta('COMMIT');
						echo('Imágen(es) cargada(s) correctamente.');
					}
				}
				else{
					$ctrlUpload = 1;

					foreach($resultado['warnings'] as $i=>$error){
						echo("ERROR: ".$error);
						$msjError = $error;
					}
				}
				$vista = $rutaDir.'vista/infraccion/load_evidencia.tpl';
				$TBS -> LoadTemplate($vista);
			break;
		}
		$TBS->Show();
	}
?>