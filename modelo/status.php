<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class Status extends ClaseBd {
		function declararTabla() {
			$tabla = "status";
			$atributos['status_id']['esPk'] = true; 
			$atributos['status_desc']['esPk'] = false;
			$strOrderBy = "status_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}
	}
?>