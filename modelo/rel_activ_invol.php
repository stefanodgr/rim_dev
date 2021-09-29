<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Cargo
	* 
	* @author gleal
	*
	*/

	class RelActividadInvolucrado extends ClaseBd {
		function declararTabla() {
			$tabla = "rel_activ_invol";
			$atributos['rel_activ_invol_id']['esPk'] 	= true;
			$atributos['rel_activ_fecha_reg']['esPk'] 	= false;
			$objetos['Involucrado']['id'] 				= "invol_id";
			$objetos['Actividad']['id'] 				= "actividad_id";
			$objetos['Conexion']['id'] 					= "conex_id";
			$objetos['TipoInvolucrado']['id'] 			= "tipo_invol_id";
			$objetos['CargoInvolucrado']['id'] 			= "cargo_invol_id";
			$objetos['Cuerpo']['id'] 					= "cuerpo_id";
			
			$strOrderBy = "rel_activ_invol_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}
		function filtroInvolucrado($idTipoInvolucrado,$cedula,$nombre,$alias,$banda) {
			$strSelect = "rel_activ_invol_id";
			$strFrom = "rel_activ_invol,involucrado";
			$strWhere = "rel_activ_invol.invol_id=involucrado.invol_id and 1=1";
			
			if($idTipoInvolucrado!='' ){
				$strWhere .= "AND rel_activ_invol.tipo_invol_id = '$idTipoInvolucrado' ";
			}

			if($nombre!='' ){
				$strWhere .= "AND rel_activ_invol.invol_id = involucrado.invol_id AND invol_nombres ilike '%$nombre%' ";
			}
			if($alias!='' ){
				$strWhere .= "AND rel_activ_invol.invol_id = involucrado.invol_id AND invol_alias ilike '%$alias%' ";
			}
			if($banda!='' ){
				$strWhere .= "AND rel_activ_invol.invol_id = involucrado.invol_id AND invol_banda ilike '%$banda%' ";
			}
			if($cedula!='' ){
				$strWhere .= "AND involucrado.invol_cedula = '$cedula' ";
			}		
			//if($tipoAuditoria!='') $strWhere .= " AND tipo_auditoria_id=$tipoAuditoria";

			$strOrderBy="rel_activ_invol_id";
			//file_put_contents(RUTA_SISTEMA."log/filtroInvolucrado.txt", "select $strSelect from $strFrom where $strWhere order by $strOrderBy");
			$resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy);
			$arrInvolucrado = array();
			foreach ($resultado as $valor) {
				$rel_activ_invol_id = $valor['rel_activ_invol_id'];
				$miInvolucrado = new RelActividadInvolucrado($this->miConexionBd,$rel_activ_invol_id);
				$arrInvolucrado[] = $miInvolucrado;
			}
			return $arrInvolucrado;
		}

		function consultarIdRelacion($idInfraccion,$idInvolucrado){
			$this->setObjeto('Actividad',	$idInfraccion);
			$this->setObjeto('Involucrado',	$idInvolucrado);
			$objeto = $this->consultar();
			count($objeto) > 0 ? $resultado = $objeto[0]->getAtributo('rel_activ_invol_id') : $resultado = 0;
			return $resultado;
		}
	}
?>