<?php
	/**
	*
	* Esta clase es extendida de clase_bd @link ClaseBd
	* permite tener acceso a los campos de la tabla referencial Actividad
	*
	* @author gleal
	*
	*/
	class Actividad extends ClaseBd {
		private $actividades;
		function declararTabla() {
			$tabla                                    = "actividad";
			$atributos['actividad_id']['esPk']        = true;
			$atributos['activ_num_rim']['esPk']       = false;
			$atributos['actividad_fecha']['esPk']     = false;
			$atributos['actividad_fecha_reg']['esPk'] = false;
			$atributos['actividad_lugar']['esPk']     = false;
			$atributos['actividad_descrip']['esPk']   = false;
			$objetos['Conexion']['id']                = "conex_id";
			$objetos['Status']['id']                  = "status_id";
			$objetos['TipoActividad']['id']           = "tipo_activ_id";
			$objetos['Estacion']['id']                = "estacion_id";
			$strOrderBy                               = "actividad_id";
			$this->registrarTabla($tabla, $atributos, $objetos, $strOrderBy);
		}

		function buscarInfraccion($idInfraccion){
			$strSelect  = "A.actividad_id AS id,
                        A.activ_num_rim AS rim,
						H.linea_nombre AS linea,
                        B.estacion_nombre AS estacion,
						A.actividad_lugar AS lugar,
						A.actividad_descrip AS descripcion,
                        C.tipo_activ_desc AS actividad,
                        A.actividad_fecha AS fecha,
						A.actividad_fecha_reg AS registro,
                        D.status_desc AS estado,
                        G.usuario_login AS usuario";

        	$strFrom    = "actividad AS A
                        INNER JOIN estacion AS B ON B.estacion_id = A.estacion_id
                        INNER JOIN tipo_actividad AS C ON C.tipo_activ_id = A.tipo_activ_id
                        INNER JOIN status AS D ON D.status_id = A.status_id
                        INNER JOIN conexion AS E ON E.conex_id = A.conex_id
                        INNER JOIN rel_perfil_usuario AS F ON F.rel_perfil_id = E.rel_perfil_id
                        INNER JOIN usuario AS G ON G.usuario_id = F.usuario_id
                        INNER JOIN linea AS H ON H.linea_id = B.linea_id";
			$strWhere 	= "A.actividad_id = ".$idInfraccion;

			$infraccion = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere);

			if($infraccion) return $infraccion;
			else return false;
		}

		function listaInfraccion($tipo,$filtros){

			if($filtros) $filtros = explode(',',$filtros);

			$strSelect  = "A.actividad_id AS id,
                        A.activ_num_rim AS rim,
                        B.estacion_nombre AS ubicacion,
                        C.tipo_activ_desc AS actividad,
                        A.actividad_fecha AS fecha,
                        D.status_desc AS estado,
                        G.usuario_login AS usuario,
                        A.actividad_fecha_reg AS registro";
        	$strFrom    = "actividad AS A
                        INNER JOIN estacion AS B ON B.estacion_id = A.estacion_id
                        INNER JOIN tipo_actividad AS C ON C.tipo_activ_id = A.tipo_activ_id
                        INNER JOIN status AS D ON D.status_id = A.status_id
                        INNER JOIN conexion AS E ON E.conex_id = A.conex_id
                        INNER JOIN rel_perfil_usuario AS F ON F.rel_perfil_id = E.rel_perfil_id
                        INNER JOIN usuario AS G ON G.usuario_id = F.usuario_id
                        INNER JOIN linea AS H ON H.linea_id = B.linea_id";
            $strOrderBy = "A.actividad_id desc";
            
            if($tipo == 'inicial'){
                if($_SESSION['PerfilUsuario'] != 'GERENCIAL'){
                    $strWhere = "D.status_id in (1,2)";
                }
                else{
                    $strWhere = "D.status_id = '3'";
                }
            }
            else{
                $length = 0;
                if($filtros[0] != 0){
                    $strWhere = 'C.tipo_activ_id='.$filtros[0];
                    $length++;
                }
                if($filtros[1] != 0){
                    if($_SESSION['PerfilUsuario'] == 'GERENCIAL') $filtros[1] = '3';
                    if($length > 0) $strWhere .= ' AND D.status_id='.$filtros[1];
                    else{
                        $strWhere = 'D.status_id='.$filtros[1];
                        $length++;
                    }
                }
                if($tipo == 'avanzada'){
                    if($filtros[2] != 0){
                        if($length  > 0) $strWhere .= ' AND H.linea_id='.$filtros[2];
                        else{
                            $strWhere = 'H.linea_id='.$filtros[2];
                            $length++;
                        }
                        if($filtros[3] != 0){
                            if($length  > 0) $strWhere .= ' AND B.estacion_id='.$filtros[3];
                            else{
                                $strWhere = 'B.estacion_id='.$filtros[2];
                                $length++;
                            }
                        }
                    }
                    if($filtros[4] != null){
                        $filtros[4] = formFechaBd($filtros[4],'d/m/Y');

                        if($filtros[5] != null){
                            $filtros[5] = formFechaBd($filtros[5],'d/m/Y');

                            if($length  > 0) $strWhere.= " AND A.actividad_fecha BETWEEN '".$filtros[4]." 00:00:00' AND '".$filtros[5]." 23:59:59'";
                            else{
                                $strWhere = "A.actividad_fecha BETWEEN '".$filtros[4]." 00:00:00' AND '".$filtros[5]." 23:59:59'";
                                $length++;
                            }
                        }
                        else{
                            if($length  > 0) $strWhere.= " AND A.actividad_fecha BETWEEN '".$filtros[4]." 00:00:00' AND '".$filtros[4]." 23:59:59'";
                            else{
                                $strWhere = "A.actividad_fecha BETWEEN '".$filtros[4]." 00:00:00' AND '".$filtros[4]." 23:59:59'";
                                $length++;
                            }
                        }
                        
                    }
                    else{
                        if($filtros[5] != null){
                            $filtros[5] = formFechaBd($filtros[5],'d/m/Y');

                            if($length  > 0) $strWhere.= " AND A.actividad_fecha < '".$filtros[5]." 23:59:59'";
                            else{
                                $strWhere = "A.actividad_fecha < '".$filtros[5]." 23:59:59'";
                                $length++;
                            }
                        }
                    }
                    if($filtros[6] != null){
                        if($length > 0) $strWhere .= " AND A.activ_num_rim like ('%".$filtros[6]."%')";
                        else{
                            $strWhere = "A.activ_num_rim like ('%".$filtros[6]."%')";
                            $length++;
                        }
                    }
                }
            }
            if($_SESSION['PerfilUsuario'] == 'PRECARGA'){
                if(($length > 0) || ($tipo == 'inicial')) $strWhere .= " AND G.usuario_login='".$_SESSION['Login']."'";
                else{
                    $strWhere = "G.usuario_login='".$_SESSION['Login']."'";
                    $length++;
                }
            }
			
			$resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy,true);

			return $resultado;
		}

		function consultarUltNumRim(){
			$annioAct = date('Y');
			$annioSig = $annioAct + 1;

			$strSelect 	= 'activ_num_rim AS ult_num_rim';
			$strFrom 	= 'actividad';
			$strWhere 	= "status_id = 3
						AND actividad_fecha_reg >= '".$annioAct."-01-01' 
						AND actividad_fecha_reg < '".$annioSig."-01-01'";
			$strOrderBy = 'activ_num_rim desc limit 1';

			$resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy);
            file_put_contents(RUTA_SISTEMA."documento/txt/utim.txt", $resultado[0]['ult_num_rim']);

			return $resultado;
		}

        function consultarInfraccionInvol($idInfraccion,$tipoInvol){
            
            $strSelect  = 'A.invol_id as id,
                        A.invol_cedula AS cedula,
                        A.invol_nombres AS nombre,
                        A.invol_apellidos AS apellido,
                        A.invol_alias AS alias,
                        A.invol_banda AS banda,
                        A.pers_id AS metro,
                        A.invol_placa_carnet as carnet,
                        G.cuerpo_desc AS cuerpo,
                        C.tipo_invol_id AS tipo,
                        F.usuario_login AS usuario';
            $strFrom    = 'involucrado AS A
                        INNER JOIN rel_activ_invol AS B ON B.invol_id = A.invol_id
                        INNER JOIN tipo_involucrado AS C ON C.tipo_invol_id = B.tipo_invol_id
                        INNER JOIN conexion AS D on D.conex_id = B.conex_id 
                        INNER JOIN rel_perfil_usuario AS E ON E.rel_perfil_id = D.rel_perfil_id
                        INNER JOIN usuario AS F ON F.usuario_id = E.usuario_id
                        LEFT JOIN cuerpo AS G ON G.cuerpo_id = A.cuerpo_id';
            
            $strWhere   = "B.actividad_id =".$idInfraccion;

            if($tipoInvol) $strWhere.= "AND C.tipo_invol_desc = '".$tipoInvol."'";

            if($tipoInvol == 'DETENIDO'){
                $strSelect  .= ' ,I.sancion_desc AS sancion,
	                        K.medida_desc AS medida';
                $strFrom    .= ' LEFT JOIN rel_activ_invol_sancion AS H ON H.rel_activ_invol_id = B.rel_activ_invol_id
                            LEFT JOIN sancion AS I ON I.sancion_id = H.sancion_id
                            LEFT JOIN rel_activ_invol_medida AS J ON J.rel_activ_invol_id = B.rel_activ_invol_id
                            LEFT JOIN medida_cautelar AS K ON K.medida_id = J.medida_id';
            }
            
            $resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy);

            foreach($resultado as $i=>$trabajador){
                $personal   = new Personal();
                $arrPers    = $personal->buscarPersonal($trabajador['metro']);

                $resultado[$i]['cargo'] = $arrPers[0]['cargo'];

                unset($personal);
                unset($arrPers);
            }

            return $resultado;
        }

        function consultarInfraccionMat($idInfraccion,$tipoMaterial){

            $strSelect  = 'A.material_comisado_id AS id,
                        A.mat_com_precinto AS precinto,
                        B.tipo_mat_desc AS tipo,
                        A.material_comisado_cant AS cantidad,
                        A.material_comisado_unid AS unidad,
                        A.material_comisado_desc AS descripcion,
                        E.usuario_login AS usuario';
            $strFrom    = 'material_comisado AS A
                        INNER JOIN tipo_material AS B ON B.tipo_mat_id = A.tipo_mat_id
                        INNER JOIN conexion AS C on C.conex_id = A.conex_id 
                        INNER JOIN rel_perfil_usuario AS D ON D.rel_perfil_id = C.rel_perfil_id
                        INNER JOIN usuario AS E ON E.usuario_id = D.usuario_id'; 
            $strWhere   = "A.actividad_id =".$idInfraccion;

            if($tipoMaterial == 'material') $strWhere.=" AND B.categoria = 'MATERIAL'";
            else $strWhere.=" AND B.categoria = 'MEDIO COMISION' AND A.tipo_mat_id != 4";

            $resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere);

            return $resultado;
        }

        function consultarInfraccionVeh($idInfraccion){

            $strSelect  = 'A.material_comisado_id AS id,
                        E.tipo_vehiculo_desc AS tipo,
                        C.vehiculo_placa AS placa,
                        D.marca_desc AS marca,
                        C.vehiculo_modelo AS modelo,
                        C.vehiculo_color AS color,
                        A.material_comisado_desc AS observacion,
                        H.usuario_login AS usuario';
            $strFrom    = 'material_comisado AS A
                        INNER JOIN tipo_material AS B ON B.tipo_mat_id = A.tipo_mat_id
                        INNER JOIN vehiculo AS C ON C.vehiculo_id = A.vehiculo_id
                        INNER JOIN marca AS D ON D.marca_id = C.marca_id
                        INNER JOIN tipo_vehiculo AS E ON E.tipo_vehiculo_id = C.tipo_vehiculo_id
                        INNER JOIN conexion AS F on F.conex_id = A.conex_id 
                        INNER JOIN rel_perfil_usuario AS G ON G.rel_perfil_id = F.rel_perfil_id
                        INNER JOIN usuario AS H ON H.usuario_id = G.usuario_id';
            $strWhere   = "A.actividad_id =".$idInfraccion;

            $resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere);

            return $resultado;
        }

        function consultarInfraccionDoc($idInfraccion){

            $strSelect  = 'A.documento_id as id,
                        A.documento_num as numero,
                        A.documento_fecha_doc as fecha,
                        B.tipo_doc_desc as tipo,
                        E.usuario_login as usuario';
            $strFrom    = 'documento AS A 
                        INNER JOIN tipo_documento AS B ON B.tipo_doc_id = A.tipo_doc_id
                        INNER JOIN conexion AS C on C.conex_id = A.conex_id 
                        INNER JOIN rel_perfil_usuario AS D ON D.rel_perfil_id = C.rel_perfil_id
                        INNER JOIN usuario AS E ON E.usuario_id = D.usuario_id';
            $strWhere   = "A.actividad_id =".$idInfraccion;

            $resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy);

            return $resultado;
        }
	}
?>