<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class Vehiculo extends ClaseBd {
		function declararTabla() {
			$tabla = "vehiculo";
			$atributos['vehiculo_id']['esPk'] = true;
			$atributos['vehiculo_placa']['esPk'] = false;
			$atributos['vehiculo_modelo']['esPk'] = false;
			$atributos['vehiculo_color']['esPk'] = false;
			$atributos['vehiculo_fecha_reg']['esPk'] = false;
			$objetos['Marca']['id'] = "marca_id";
			$objetos['TipoVehiculo']['id'] = "tipo_vehiculo_id";
			$objetos['Conexion']['id'] = "conex_id";
			$strOrderBy = "vehiculo_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}
	}
?>