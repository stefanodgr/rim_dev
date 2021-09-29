<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class RelActividadInvolucradoSancion extends ClaseBd {
		function declararTabla() {
			$tabla = "rel_activ_invol_sancion";
			$atributos['rel_activ_invol_sancion_id']['esPk'] = true;
			$atributos['fecha_sancion'] 			['esPk'] = false;
			$atributos['observacion'] 				['esPk'] = false;
			$objetos['RelActividadInvolucrado'] ['id'] = "rel_activ_invol_id";
			$objetos['Sancion'] 				['id'] = "sancion_id";
			$objetos['Conexion'] 				['id'] = "conex_id";
			$strOrderBy = "rel_activ_invol_sancion_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}
	}
?>