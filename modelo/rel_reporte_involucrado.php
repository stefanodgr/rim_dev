<?php
	class RelReporteInvolucrado extends ClaseBd {
		function declararTabla() {
			$tabla = "rel_reporte_involucrado";
			$atributos['rel_rep_inv_id']['esPk']    = true; 
			$atributos['invol_cedula']['esPk']      = false;
			$objetos['Reporte']['id']       		= "rep_id";
			$objetos['TipoInvolucrado']['id']       = "tipo_invol_id";
			$strOrderBy = "rel_rep_inv_id";
			$this->registrarTabla($tabla,$atributos,$objetos,$strOrderBy);		
		}

		function consultarInvolReporte($involCedula,$tipoInvol){
			$strSelect 	= 'A.invol_cedula AS cedula,
						A.invol_nombres AS nombre,
						A.invol_apellidos AS apellido,
						A.invol_alias AS alias,
						A.invol_banda AS banda,
						A.pers_id AS metro,
						A.invol_placa_carnet as carnet,
						G.cuerpo_desc AS cuerpo';
			$strFrom    = 'involucrado AS A
						INNER JOIN rel_reporte_involucrado AS B ON B.invol_cedula = A.invol_cedula
						INNER JOIN tipo_involucrado AS C ON C.tipo_invol_id = B.tipo_invol_id
						LEFT JOIN cuerpo AS G ON G.cuerpo_id = A.cuerpo_id';
				
			$strWhere   = "A.invol_cedula = '".$involCedula."' AND C.tipo_invol_desc ='".$tipoInvol."'";
			$strOrderBy = "A.invol_cedula";

			$resultado = $this->miConexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy);

			foreach($resultado as $i=>$trabajador){
                $personal   = new Personal();
                $arrPers    = $personal->buscarPersonal($trabajador['metro']);

                $resultado[$i]['cargo'] = $arrPers[0]['cargo'];

                unset($personal);
                unset($arrPers);
            }

			return $resultado;
		}
	}
?>