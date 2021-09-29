<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class Linea extends ClaseBd {
		function declararTabla() {
			$tabla = "linea";
			$atributos['linea_id']['esPk'] = true; 
			$atributos['linea_nombre']['esPk'] = false;
			$strOrderBy = "linea_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>