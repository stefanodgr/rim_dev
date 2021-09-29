<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class RelActividadInvolucradoMedida extends ClaseBd {
		function declararTabla() {
			$tabla = "rel_activ_invol_medida";
			$atributos['rel_activ_invol_medida_id'] ['esPk'] = true;
			$atributos['fecha_medida'] 				['esPk'] = false;
			$atributos['observacion'] 				['esPk'] = false;
			$objetos['RelActividadInvolucrado'] ['id'] = "rel_activ_invol_id";
			$objetos['MedidaCautelar'] 			['id'] = "medida_id";
			$objetos['Conexion'] 				['id'] = "conex_id";
			$strOrderBy = "rel_activ_invol_medida_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}
	}
?>