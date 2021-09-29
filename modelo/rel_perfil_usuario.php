<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class PerfilUsuario extends ClaseBd {
		function declararTabla() {
			$tabla = "rel_perfil_usuario";
			$atributos['rel_perfil_id']['esPk'] = true; 
			$atributos['rel_perfil_activo']['esPk'] = false;
			$atributos['rel_perfil_fecha_ini']['esPk'] = false;
			$atributos['rel_perfil_fecha_fin']['esPk'] = false;
			$objetos['Usuario']['id'] = "usuario_id";
			$objetos['Perfil']['id'] = "perfil_id";
			$strOrderBy = "rel_perfil_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}

	}
?>