<?php
	/**
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Sancion
	* @author gleal
	*/
	class Sancion extends ClaseBd {
		function declararTabla() {
			$tabla = "sancion";
			$atributos['sancion_id'] 	['esPk'] = true; 
			$atributos['sancion_desc'] 	['esPk'] = false;
			$atributos['sancion_tipo'] 	['esPk'] = false;
			$strOrderBy = "sancion_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

		function consultarSancion($idDetenido,$idInfraccion){
			$strSelect 	= "B.rel_activ_invol_sancion_id AS id,
						C.sancion_desc AS desc_sancion,
						B.fecha_sancion AS fecha,
						B.observacion AS observacion,
						D.pers_id as personal,
						E.activ_num_rim AS rim";
			$strFrom 	= "rel_activ_invol AS A
						INNER JOIN rel_activ_invol_sancion AS B ON B.rel_activ_invol_id = A.rel_activ_invol_id
						INNER JOIN sancion AS C ON C.sancion_id = B.sancion_id
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