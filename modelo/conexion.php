<?php
	class Conexion extends ClaseBd {
		function declararTabla() {
			$tabla = "conexion";
			$atributos['conex_id']['esPk'] = true; 
			$atributos['conex_ip']['esPk'] = false;
			$atributos['conex_ent']['esPk'] = false;
			$atributos['conex_sal']['esPk'] = false;
			$objetos['PerfilUsuario']['id'] = "rel_perfil_id";
			$strOrderBy = "rel_perfil_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}

		function consultarConexion($direccionIp, $idRelPerfilUsu){
			$strSelect 	= '	A.conex_id AS id, 
							D.usuario_login AS login, 
							C.perfil_desc AS perfil, 
							A.conex_ent AS fecha_inicio, 
							A.conex_sal AS fecha_fin,
							A.conex_ip AS ip';
			$strFrom  	= 'conexion AS A
							INNER JOIN rel_perfil_usuario AS B ON B.rel_perfil_id = A.rel_perfil_id
							INNER JOIN perfil AS C ON C.perfil_id = B.perfil_id
							INNER JOIN usuario AS D ON D.usuario_id = B.usuario_id';
			
			if($direccionIp) 	$strWhere 	= "A.conex_ip = '".$direccionIp."' AND A.conex_sal IS null";
			if($idRelPerfilUsu) $strWhere 	= "A.rel_perfil_id = ".$idRelPerfilUsu." AND A.conex_sal IS null";
			if((!$direccionIp) && (!$idRelPerfilUsu)) $strWhere = "conex_sal IS null";
			
			$strOrderBy	= "conex_ent";
			$resultado 	= $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy); 

			return $resultado;
		}

		function cerrarConexion($direccionIp, $conexId){
			$fechaRegistro = formatoFechaHoraBd();

			if($direccionIp) 	$strQuery = "UPDATE conexion set conex_sal = '".$fechaRegistro."' WHERE conex_ip = '".$direccionIp."' AND conex_sal IS NULL";
			if($conexId) 		$strQuery = "UPDATE conexion set conex_sal = '".$fechaRegistro."' WHERE conex_id = ".$conexId." AND conex_sal IS NULL";

			$ctrlMod = $this->miConexionBd->hacerConsulta($strQuery);
			return $ctrlMod;
		}

		function validarConexion($conexId){
			$strSelect 	= '*';
			$strFrom  	= 'conexion';
			$strWhere 	= 'conex_sal IS NULL AND conex_id = '.$conexId;
			$resultado 	= count($this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere));

			return $resultado;
		}
	}
?>