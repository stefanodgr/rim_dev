<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class Cuerpo extends ClaseBd {
		function declararTabla() {
			$tabla = "cuerpo";
			$atributos['cuerpo_id']['esPk'] = true; 
			$atributos['cuerpo_desc']['esPk'] = false;
			$strOrderBy = "cuerpo_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>