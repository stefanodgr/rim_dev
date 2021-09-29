<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class Documento extends ClaseBd {
		function declararTabla() {
			$tabla = "documento";
			$atributos['documento_id']['esPk'] = true;
			$atributos['documento_num']['esPk'] = false;
			$atributos['documento_fecha_reg']['esPk'] = false;
			$atributos['documento_fecha_doc']['esPk'] = false;
			$objetos['Actividad']['id'] = "actividad_id";
			$objetos['Conexion']['id'] = "conex_id";
			$objetos['TipoDocumento']['id'] = "tipo_doc_id";
			$strOrderBy = "documento_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}
	}
?>