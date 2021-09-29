<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class Marca extends ClaseBd {
		function declararTabla() {
			$tabla = "marca";
			$atributos['marca_id']['esPk'] = true; 
			$atributos['marca_desc']['esPk'] = false;
			$strOrderBy = "marca_desc";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}
	}
?>