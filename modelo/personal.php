<?php
	// TABLA PERTENECIENTE A BD SICTRA
	class Personal extends ClaseBd {
		function declararTabla() {
			$tabla                              	= "personal";
			$atributos['pers_id']['esPk']     		= true;
			$atributos['pers_nombres']['esPk']   	= false;
			$atributos['pers_apellidos']['esPk'] 	= false;
			$atributos['pers_ci']['esPk']        	= false;
			$atributos['pers_carnet']['esPk']    	= false;
			$atributos['pers_fec_nac']['esPk']   	= false;
			$atributos['pers_direc']['esPk']     	= false;
			$atributos['pers_sexo']['esPk']      	= false;
			$atributos['pers_tlf_local']['esPk'] 	= false;
			$atributos['pers_tlf_cel']['esPk']   	= false;
			$atributos['pers_fec_ing']['esPk']   	= false;
			$atributos['pers_cod_sap']['esPk'] 		= false;
			$atributos['pers_grupo']['esPk']   		= false;

			$objetos['Cargo']['id']             	= "cargo_id";
			$objetos['Unidad']['id']             	= "unidad_id";
			$strOrderBy                             = "pers_id";
			$this->registrarTabla($tabla, $atributos, $objetos, $strOrderBy);
		}

		function buscarPersonal($persId,$persCed,$persCarne){

            $conexionBd = new ConexionBd('sictra');

            $strSelect  = 'A.pers_id AS id,
                        A.pers_ci AS cedula,
                        A.pers_carnet AS carne,
                        A.pers_nombres AS nombre,
                        A.pers_apellidos AS apellido,
                        A.pers_tlf_local AS telefono,
                        A.pers_direc AS direccion,
                        B.cargo_nombre AS cargo,
                        C.unidad_nombre AS gerencia';
            $strFrom    = 'personal AS A 
                        INNER JOIN cargo AS B ON B.cargo_id = A.cargo_id
	                    INNER JOIN unidad AS C ON C.unidad_id = A.unidad_id';
			
			if($persId) 	$strWhere = "A.pers_id = '".$persId."'";
			if($persCed) 	$strWhere = "A.pers_ci = '".$persCed."'";
			if($persCarne) 	$strWhere = "A.pers_carnet = '".$persCarne."'";

            $arrPers = $conexionBd->hacerSelect($strSelect,$strFrom,$strWhere);

			return $arrPers;
		}
	}
?>