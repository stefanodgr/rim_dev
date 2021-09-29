<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class PerfilMenu extends ClaseBd {
		function declararTabla() {
			$tabla = "rel_perfil_menu";
			$atributos['rel_perfil_menu_id']['esPk'] = true; 
			$objetos['Perfil']['id'] = "perfil_id";
			$objetos['Menu']['id'] = "menu_id";
			$strOrderBy = "rel_perfil_menu_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}

	}
?>