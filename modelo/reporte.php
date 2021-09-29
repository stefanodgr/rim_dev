<?php
	class Reporte extends ClaseBd {
		function declararTabla() {
			$tabla = "reporte";
			$atributos['rep_id']['esPk']        = true; 
			$atributos['rep_codigo']['esPk']    = false;
			$atributos['rep_fecha']['esPk']     = false;
			$objetos['Actividad']['id']         = "actividad_id"; 
            $objetos['Conexion']['id']          = "conex_id";
			$strOrderBy = "rep_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}

		function consultarReporte($reporteId, $infraccionId){
			$strSelect 	= 'A.rep_id AS rep_id, 
						B.rel_rep_inv_id AS rel_id';
			$strFrom 	= 'reporte AS A
						INNER JOIN rel_reporte_involucrado AS B ON B.rep_id = A.rep_id ';

			if($reporteId) 		$strWhere = 'rep_id = '.$reporteId;
			if($infraccionId) 	$strWhere = "actividad_id IN (".$infraccionId.")";

			$resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere);

			return $resultado;
		}
	}
?>