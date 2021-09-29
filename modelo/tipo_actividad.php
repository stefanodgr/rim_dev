<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class TipoActividad extends ClaseBd {
		function declararTabla() {
			$tabla = "tipo_actividad";
			$atributos['tipo_activ_id']['esPk'] = true; 
			$atributos['tipo_activ_desc']['esPk'] = false;
			$strOrderBy = "tipo_activ_desc";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>