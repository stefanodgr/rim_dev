<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class MaterialComisado extends ClaseBd {
		function declararTabla() {
			$tabla = "material_comisado";
			$atributos['material_comisado_id']['esPk'] = true;
			$atributos['material_comisado_desc']['esPk'] = false;
			$atributos['material_comisado_cant']['esPk'] = false;
			$atributos['material_comisado_unid']['esPk'] = false;
			$atributos['mat_com_fecha_reg']['esPk'] = false;
			$atributos['mat_com_precinto']['esPk'] = false;
			$objetos['Actividad']['id'] = "actividad_id";
			$objetos['Conexion']['id'] = "conex_id";
			$objetos['TipoMaterial']['id'] = "tipo_mat_id";
			$objetos['Vehiculo']['id'] = "vehiculo_id";
			$strOrderBy = "material_comisado_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}
	}
?>