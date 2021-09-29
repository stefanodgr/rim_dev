<?php
	/**
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial TipoSancion
	* @author gleal
	*/
	class MedidaCautelar extends ClaseBd {
		function declararTabla() {
			$tabla = "medida_cautelar";
			$atributos['medida_id'] 	['esPk'] = true; 
			$atributos['medida_desc'] 	['esPk'] = false;
			$strOrderBy = "medida_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

		function consultarMedida($idDetenido,$idInfraccion){
			$strSelect 	= "B.rel_activ_invol_medida_id AS id,
						C.medida_desc AS desc_medida,
						B.fecha_medida AS fecha,
						B.observacion AS observacion,
						D.pers_id as personal,
						E.activ_num_rim AS rim";
			$strFrom 	= "rel_activ_invol AS A
						INNER JOIN rel_activ_invol_medida AS B ON B.rel_activ_invol_id = A.rel_activ_invol_id
						INNER JOIN medida_cautelar AS C ON C.medida_id = B.medida_id
						INNER JOIN involucrado AS D ON D.invol_id = A.invol_id
						INNER JOIN actividad AS E ON E.actividad_id = A.actividad_id";

			if($idInfraccion){
				$strWhere = "A.actividad_id = ".$idInfraccion;
				$ctrlIdAct = true;
			}
			if($idDetenido){
				if($ctrlIdAct == true) $strWhere .= " AND A.invol_id = ".$idDetenido;
				else $strWhere = "A.invol_id = ".$idDetenido;
			}

			$resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere);
			
			return $resultado;
		}
	}
?>