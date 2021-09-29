<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class TipoAuditoria extends ClaseBd {
		function declararTabla() {
			$tabla = "tipo_auditoria";
			$atributos['tipo_auditoria_id']['esPk'] = true; 
			$atributos['tipo_auditoria_desc']['esPk'] = false;
			$strOrderBy = "tipo_auditoria_desc";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>