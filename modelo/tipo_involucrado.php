<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class TipoInvolucrado extends ClaseBd {
		function declararTabla() {
			$tabla = "tipo_involucrado";
			$atributos['tipo_invol_id']['esPk'] = true; 
			$atributos['tipo_invol_desc']['esPk'] = false;
			$strOrderBy = "tipo_invol_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>