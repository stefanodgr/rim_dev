<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/
	class TipoVehiculo extends ClaseBd {
		function declararTabla() {
			$tabla = "tipo_vehiculo";
			$atributos['tipo_vehiculo_id']['esPk'] = true; 
			$atributos['tipo_vehiculo_desc']['esPk'] = false;
			$strOrderBy = "tipo_vehiculo_id";
			$this->registrarTabla($tabla,$atributos,null,$strOrderBy);		
		}
	}
?>