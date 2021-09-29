<?php
	// Clase para realizar la conexion con la BD
	class ConexionBd {
		private $enlace;
		private $ejecutar;
		private $consultaPendiente;
		private $esInformix;

		// Conecta con la Base de Datos
		function __construct($enlace,$ejecutar) {
			
			$this->consultaPendiente = "";
			$this->ejecutar = isset($ejecutar) ? $ejecutar : true;

			if (isset($enlace)){
				switch ($enlace){
					case 'sictra':
						$this->enlace = pg_connect("dbname=".ZA." port=5432 host=".WA." user=".XA." password=".YA);
					break; 
				}
			}

			else {
				$this->enlace = pg_connect("dbname=".Z." port=".V." host=".W." user=".X." password=".Y);
			}		
		}
		
		// Realiza las consultas a la Base de Datos
		function hacerSelect($strSelect, $strFrom, $strWhere, $strGroupBy, $strOrderBy, $ctrl) {

			$consulta = isset($strSelect)?"SELECT $strSelect":"";
			$consulta .= isset($strFrom)?" FROM $strFrom":"";
			$consulta .= (isset($strWhere) and (strcmp($strWhere, "") != 0))?" WHERE $strWhere":"";
			$consulta .= isset($strGroupBy)?" GROUP BY $strGroupBy":"";
			$consulta .= isset($strOrderBy)?" ORDER BY $strOrderBy":"";
			$consulta .= ";";
			$tiempoMod = time()-16200;
			$archivo   = "hacerSelect_$strFrom_".date("Ymd-His", $tiempoMod);
			
			file_put_contents(RUTA_SISTEMA."log/hacerSelect.txt", $consulta);
			if($ctrl == true) file_put_contents(RUTA_SISTEMA."documento/txt/query_lista_infraccion.txt", $consulta);
			
			if (!($resultado = $this->hacerConsulta($consulta, true))) {
				return null;
			}

			return $resultado;
		}
		// Realiza los ingreso a la Base de Datos
		function hacerInsert($strInsertInto, $strValues, $strReturning) {
			
			$consulta = isset($strInsertInto)?"INSERT INTO ".$strInsertInto:"";
			$consulta .= isset($strValues)?" VALUES ($strValues)":"";
			$consulta .= isset($strReturning)?" RETURNING $strReturning":"";
			$consulta .= ";";

			file_put_contents(RUTA_SISTEMA."log/hacerInsert.txt", $consulta);

			$resultado = $this->hacerConsulta($consulta, comprobarVar($strReturning));

			if ($strReturning === true) {
				if ($resultado === false) {
					return false;
				} 
				else {
					return pg_fetch_array($resultado, 0, PGSQL_ASSOC);
				}
			} 
			else {
				return $resultado;
			}
		}
		// Realiza la eliminacion en la Base de Datos
		function hacerDelete($strDeleteFrom, $strWhere) {
			$consulta = isset($strDeleteFrom)?"DELETE FROM $strDeleteFrom":"";
			$consulta .= isset($strWhere)?" WHERE $strWhere":"";
			$consulta .= ";";

			file_put_contents(RUTA_SISTEMA."log/hacerDelete.txt", $consulta);

			return $this->hacerConsulta($consulta);
		}

		// Realiza las actualizaciones en la Base de Datos
		function hacerUpdate($strUpdate, $strSet, $strWhere) {
			$consulta = isset($strUpdate)?"UPDATE $strUpdate":"";
			$consulta .= isset($strSet)?" SET $strSet":"";
			$consulta .= isset($strWhere)?" WHERE $strWhere":"";
			$consulta .= ";";

			file_put_contents(RUTA_SISTEMA."log/hacerUpdate.txt", $consulta);

			return $this->hacerConsulta($consulta);
		}

		// Realiza la ejecución de las consultas pendientes
		function hacerConsultasPendientes() {
			if (!($this->ejecutar)) {
				$this->ejecutar          = true;
				$consulta                = $this->consultaPendiente;
				$this->consultaPendiente = "";
				$resultado               = $this->esInformix?ifx_query($consulta, $this->enlace):
				pg_query($this->enlace, $consulta);
				if ($resultado) {
					return true;
				} 
				else {
					return false;
				}
			} 
			else{
				return false;
			}
		}

		// Realiza la ejecución de una consulta
		function hacerConsulta($consulta, $devolver) {

			file_put_contents(RUTA_SISTEMA."log/hacerConsulta.txt", $consulta);
			$_SESSION['exp'] = time() + EXP;

			if ($this->ejecutar) {
				$resultado = pg_query($this->enlace, $consulta);
				//file_put_contents(RUTA_SISTEMA."log/hacerConsulta.txt", $consulta);
				if ($resultado) {
					if (isset($devolver) and $devolver){
						$i = 0;
						while ($linea = pg_fetch_array($resultado, $i, PGSQL_ASSOC)) {
							$arreglo[] = $linea;
							$i++;
						}
						return $arreglo;
					} 
					else {
						return true;
					}
				} 
				else {
					if (defined("RUTA_SISTEMA")) {
						ini_set('date.timezone', 'UTC');
						$tiempoMod = time()-16200;
						$archivo   = date("Ymd-His", $tiempoMod);
						$error     = $this->devolverError();
						$error .= chr(13).$consulta;
						file_put_contents(RUTA_SISTEMA."log/$archivo.txt", $error);
					}
					return false;
				}
			} 
			else {
				$this->consultaPendiente .= $consulta;
				return true;
			}
		}

		// Devuelve el ultimo error en las consultas
		function devolverError() {
			return $this->esInformix?ifx_errormsg():pg_last_error($this->enlace);
		}

		function noEjecutar() {
			$this->ejecutar          = false;
			$this->consultaPendiente = "";
		}

		function siEjecutar() {
			$this->ejecutar          = true;
			$this->consultaPendiente = "";
		}
	}
?>