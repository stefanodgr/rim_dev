<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class RelActividadStatus extends ClaseBd {
		function declararTabla() {
			$tabla = "rel_activ_status";
			$atributos['rel_activ_status_id']['esPk'] = true;
			$atributos['rel_activ_fecha']['esPk'] = true;
			$objetos['Status']['id'] = "status_id";
			$objetos['Actividad']['id'] = "actividad_id";
			$objetos['Conexion']['id'] = "conex_id";
			$strOrderBy = "rel_activ_status_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}

		function registrarStatus($infId,$infEstado){
			$fechaRegistro = formatoFechaHoraBd();

			$this->setAtributo('rel_activ_fecha',$fechaRegistro); 
			$this->setObjeto('Actividad'   ,$infId);
			$this->setObjeto('Status'      ,$infEstado);
			$this->setObjeto('Conexion'    ,$_SESSION['IdConexion']);
			$ctrlIns = $this->registrar();

			return $ctrlIns;
		}
	}
?>