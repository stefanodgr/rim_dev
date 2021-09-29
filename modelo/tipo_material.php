<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class TipoMaterial extends ClaseBd {
		function declararTabla() {
			$tabla = "tipo_material";
			$atributos['tipo_mat_id']['esPk'] = true; 
			$atributos['tipo_mat_desc']['esPk'] = false;
			$atributos['categoria']['esPk'] = false;
			$strOrderBy = "tipo_mat_desc";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>