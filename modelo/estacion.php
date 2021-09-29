<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Actividad
	* 
	* @author gleal
	*
	*/
	class Estacion extends ClaseBd {
		function declararTabla() {
			$tabla = "estacion";
			$atributos['estacion_id']['esPk'] = true; 
			$atributos['estacion_nombre']['esPk'] = false;
			$objetos['Linea']['id'] = "linea_id";
			$strOrderBy = "estacion_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}
	}
?>