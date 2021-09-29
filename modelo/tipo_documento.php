<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class TipoDocumento extends ClaseBd {
		function declararTabla() {
			$tabla = "tipo_documento";
			$atributos['tipo_doc_id']['esPk'] = true; 
			$atributos['tipo_doc_desc']['esPk'] = false;
			$strOrderBy = "tipo_doc_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}

	}
?>