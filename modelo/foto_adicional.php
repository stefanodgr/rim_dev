<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class FotoAdicional extends ClaseBd {
		function declararTabla() {
			$tabla = "foto_adicional";
			$atributos['foto_id']['esPk'] = true;
			$atributos['foto_desc']['esPk'] = false;
			$atributos['foto_fecha_reg']['esPk'] = false;
			$objetos['Actividad']['id'] = "actividad_id";
			$objetos['Conexion']['id'] = "conex_id";
			$strOrderBy = "foto_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}

		function obtenerEvidencia($infracId){
			$this->setObjeto('Actividad',$infracId);
			$resultado = $this->consultar();

			return $resultado;
		}
	}
?>