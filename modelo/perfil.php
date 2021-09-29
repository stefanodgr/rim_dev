<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class Perfil extends ClaseBd {
		function declararTabla() {
			$tabla = "perfil";
			$atributos['perfil_id']['esPk'] = true; 
			$atributos['perfil_desc']['esPk'] = false;
			$strOrderBy = "perfil_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>