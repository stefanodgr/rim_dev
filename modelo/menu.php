<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class Menu extends ClaseBd {
		function declararTabla() {
			$tabla = "menu";
			$atributos['menu_id']['esPk'] = true; 
			$atributos['menu_desc']['esPk'] = false;
			$atributos['menu_link']['esPk'] = false;
			$atributos['menu_padre']['esPk'] = false;
			$atributos['menu_icono']['esPk'] = false;
			$atributos['menu_orden']['esPk'] = false;
			$atributos['menu_activo']['esPk'] = false;
			$strOrderBy = "menu_orden";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>