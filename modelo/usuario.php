<?php
	/**
	* 
	* Esta clase es extendida de clase_bd @link ClaseBd 
	* permite tener acceso a los campos de la tabla referencial Actividad
	* 
	* @author gleal
	*
	*/
	class Usuario extends ClaseBd{
		function declararTabla(){
			$tabla = "usuario";
			$atributos['usuario_id']['esPk'] = true;
			$atributos['usuario_login']['esPk'] = false;
			$atributos['usuario_clave']['esPk'] = false;
			$atributos['usuario_nombre']['esPk'] = false;
			$atributos['usuario_cedula']['esPk'] = false;
			$atributos['usuario_carnet']['esPk'] = false;
			$strOrderBy = "usuario_id";
			$this->registrarTabla($tabla, $atributos, null, $strOrderBy);
		}
	/**
		* consulta de accesos de usuarios logueados
		* si no estan logueados no muestra los formularios (sesiones)
		*/
		
		function totalConsultar() {
			$miConexionBd = new ConexionBd();
			$datos = $this->getDatos();
			$strWhere = "1=1";
			foreach ($datos as $campo=>$valor) {
				if (comprobarVar($valor)) {
					$strWhere .= " AND $campo = '".strMayus($valor)."'";
				}
			}
			$resultado = $miConexionBd->hacerSelect("COUNT(*) AS cantidad",
			"usuario",$strWhere);
			return comprobarVar($resultado[0]['cantidad']) ?
			intval($resultado[0]['cantidad']) : 0;
		}
	}
?>