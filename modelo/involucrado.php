<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Actividad
	* 
	* @author gleal
	*
	*/
	class Involucrado extends ClaseBd{
		function declararTabla(){
			$tabla = "involucrado";
			$atributos['invol_id']['esPk'] 			= true;
			$atributos['invol_cedula']['esPk'] 		= false;
			$atributos['invol_nombres']['esPk'] 	= false;
			$atributos['invol_apellidos']['esPk'] 	= false;
			$atributos['invol_foto']['esPk'] 		= false;
			$atributos['invol_telf']['esPk'] 		= false;
			$atributos['invol_alias']['esPk'] 		= false;
			$atributos['invol_banda']['esPk'] 		= false;
			$atributos['invol_direccion']['esPk'] 	= false;
			$atributos['invol_placa_carnet']['esPk']= false;
			$atributos['pers_id']['esPk'] 			= false;

			$objetos['Cuerpo']['id'] = "cuerpo_id";

			$strOrderBy = "invol_id";
			$this->registrarTabla($tabla, $atributos, $objetos, $strOrderBy);
		}
		
		function buscarInvolucrado($involId, $involCed, $involNomb, $involApe, $involAlias, $involBanda, $tipoBusq, $tipoInvol, $estadoInf){

			$involNomb  = utf8_encode($involNomb);
            $involApe   = utf8_encode($involApe);
            $involAlias = utf8_encode($involAlias);
            $involBanda = utf8_encode($involBanda);

			$conexionBd = new ConexionBd();

            $strFrom = 'involucrado AS A';

            if($involId != null){
                $strWhere = 'A.invol_id = '.$involId;
            }
            elseif($involCed != null){
                $strWhere = "A.invol_cedula = '".$involCed."'";
            }
            else{
                $arrFiltros = 0;
                if($involNomb != null){
                    if($arrFiltros > 0) $strWhere.= " AND A.invol_nombres LIKE '%".$involNomb."%'";
                    else{
                        $strWhere.= "A.invol_nombres LIKE '%".$involNomb."%'";
                        $arrFiltros++;
                    }
                }
                if($involApe != null){
                    if($arrFiltros > 0) $strWhere.= " AND A.invol_apellidos LIKE '%".$involApe."%'";
                    else{
                        $strWhere.= "A.invol_apellidos LIKE '%".$involApe."%'";
                        $arrFiltros++;
                    }
                }
                if($involAlias != null){
                    if($arrFiltros > 0) $strWhere.= " AND A.invol_alias LIKE '%".$involAlias."%'";
                    else{
                        $strWhere.= "A.invol_alias LIKE '%".$involAlias."%'";
                        $arrFiltros++;
                    }
                }
                if($involBanda != null){
                    if($arrFiltros > 0) $strWhere.= " AND A.invol_banda LIKE '%".$involBanda."%'";
                    else $strWhere.= "A.invol_banda LIKE '%".$involBanda."%'";
                }
            }

            if($tipoBusq == 'infractor'){
                $strSelect  = 'A.invol_id AS id';
                $strFrom    .= ' INNER JOIN rel_activ_invol B ON B.invol_id = A.invol_id
                            INNER JOIN actividad C ON C.actividad_id = B.actividad_id';
                $strGroupBy = 'A.invol_id';

                if($tipoInvol){
                    switch($tipoInvol){
                        case 'detenido':
                            $tipoInvol = 1;
                        break;
                        case 'victima':
                            $tipoInvol = 3;
                        break;
                        case 'funcionario':
                            $tipoInvol = 5;
                        break;
                        case 'personal':
                            $tipoInvol = 4;
                        break;
                        default:
                            $tipoInvol = $tipoInvol;
                        break;
                    }
                    $strWhere.= " AND B.tipo_invol_id = ".$tipoInvol;
                }
                
                if($estadoInf){
                    switch($estadoInf){
                        case 'precarga':
                            $estadoInf = 1;
                        break;
                        case 'corregir':
                            $estadoInf = 2;
                        break;
                        case 'procesado':
                            $estadoInf = 3;
                        break;
                        default:
                            $estadoInf = $estadoInf;
                        break;
                    }
                    $strWhere.= " AND C.status_id = ".$estadoInf;
                }
            }
            else{
                $strSelect  = "distinct(A.invol_id) AS id,
                                A.invol_cedula AS cedula, 
                                A.invol_nombres AS nombre, 
                                A.invol_apellidos AS apellido, 
                                A.invol_telf AS telefono,
                                A.invol_direccion AS direccion,
                                A.invol_foto AS foto,
                                A.invol_alias AS alias,
                                A.invol_banda AS banda,
                                A.invol_placa_carnet AS carne,
                                A.pers_id AS pers_id,
                                B.cuerpo_desc AS cuerpo";
                $strFrom    .= " LEFT JOIN cuerpo AS B ON B.cuerpo_id = A.cuerpo_id";
            }
            
            $arrInvol = $conexionBd->hacerSelect($strSelect,$strFrom,$strWhere,$strGroupBy,null,$ctrol);

			return $arrInvol;
		}

        function consultarExpediente($infractorId,$estadoInf){

            $strSelect  = "B.actividad_id as id,
                        B.activ_num_rim AS rim,
                        C.tipo_activ_desc AS tipo,
                        D.estacion_nombre AS ubicacion,
                        B.actividad_fecha AS fecha,
                        I.sancion_desc as sancion,
                        K.medida_desc as medida,
                        G.usuario_login AS usuario";
        	$strFrom    = "rel_activ_invol AS A
						INNER JOIN actividad AS B ON B.actividad_id = A.actividad_id
						INNER JOIN tipo_actividad AS C ON C.tipo_activ_id = B.tipo_activ_id
						INNER JOIN estacion AS D ON D.estacion_id = B.estacion_id
						INNER JOIN conexion AS E ON E.conex_id = B.conex_id
						INNER JOIN rel_perfil_usuario AS F ON F.rel_perfil_id = E.rel_perfil_id
						INNER JOIN usuario AS G ON G.usuario_id = F.usuario_id
                        LEFT JOIN rel_activ_invol_sancion AS H ON H.rel_activ_invol_id = A.rel_activ_invol_id
                        LEFT JOIN sancion AS I ON I.sancion_id = H.sancion_id
                        LEFT JOIN rel_activ_invol_medida AS J ON J.rel_activ_invol_id = A.rel_activ_invol_id
                        LEFT JOIN medida_cautelar AS K ON K.medida_id = J.medida_id";
            $strWhere 	= 'invol_id= '.$infractorId." AND tipo_invol_id = 1";

            if($estadoInf){
                switch($estadoInf){
                    case 'precarga':
                        $estadoInf  = 1;
                    break;
                    case 'corregir':
                        $estadoInf = 2;
                    break;
                    case 'procesado':
                        $estadoInf = 3;
                    break;
                    default:
                        $estadoInf = $estadoInf;
                    break;
                }
                $strWhere .= " AND B.status_id = ".$estadoInf;
            }

            if($_SESSION['PerfilUsuario'] == 'PRECARGA') $strWhere .= " AND G.usuario_login = '".$_SESSION['Login']."'";
			
			$resultado 	= $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,null,true);

            return $resultado;
        }
	}
?>