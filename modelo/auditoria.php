<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Actividad
	* 
	* @author gleal
	*
	*/
	class Auditoria extends ClaseBd{
		function declararTabla(){
			$tabla = "auditoria";
			$atributos['auditoria_id']['esPk'] = true;
			$atributos['auditoria_observ']['esPk'] = false;
			$atributos['auditoria_fecha']['esPk'] = false;
			$atributos['auditoria_link']['esPk'] = false;
			$objetos['Conexion']['id'] = "conex_id";
			$objetos['TipoAuditoria']['id'] = "tipo_auditoria_id";
			$strOrderBy = "auditoria_id desc";
			$this->registrarTabla($tabla, $atributos, $objetos, $strOrderBy);
		}
		function filtroAuditoria($fechaDesde,$fechaHasta,$tipoAuditoria) {
		
			$strSelect = "auditoria_id";
			$strFrom = "auditoria";
			$strWhere = "1=1";

					if($fechaDesde!='' and $fechaHasta!=''){
						$strWhere .= " AND auditoria_fecha BETWEEN '$fechaDesde 00:00:00' AND '$fechaHasta 23:59:59'";
					}
					if($tipoAuditoria!='') $strWhere .= " AND tipo_auditoria_id=$tipoAuditoria";

			$strOrderBy="auditoria_id desc";
			$resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy);
			$arrAuditoria = array();
			foreach ($resultado as $valor) {
				$auditoria_id = $valor['auditoria_id'];
				$miAuditoria = new Auditoria($this->miConexionBd,$auditoria_id);
				$arrAuditoria[] = $miAuditoria;
			}
			return $arrAuditoria;
		}	
	}
?>