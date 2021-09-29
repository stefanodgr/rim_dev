<?php
	function devolverLoginSesion() {
		session_start();
		return isset($_SESSION['Login']) ? $_SESSION['Login'] : null;
	}

	function validarConexion(){
		$conexion 	= new Conexion();
		$ctrl 		= $conexion->validarConexion($_SESSION['IdConexion']);
		
		if($ctrl > 0){
			$_SESSION['exp'] = time() + EXP;
			cantConexiones();
			return true;
		}
		else return false;
	}
	function cantConexiones(){
		$conexion       = new Conexion();
		$arrConexion    = $conexion->consultarConexion();
		$cantidadConex  = count($arrConexion);
		$_SESSION['cantConexion'] = $cantidadConex;
	}

	function sinAcentos($cadena) {
		$cadena = str_replace("Ã¡","a",$cadena);
		$cadena = str_replace("Ã©","e",$cadena);
		$cadena = str_replace("Ã­","i",$cadena);
		$cadena = str_replace("Ã³","o",$cadena);
		$cadena = str_replace("Ãº","u",$cadena);
		$cadena = str_replace("Ã�","A",$cadena);
		$cadena = str_replace("Ã‰","E",$cadena);
		$cadena = str_replace("Ã�","I",$cadena);
		$cadena = str_replace("Ã“","O",$cadena);
		$cadena = str_replace("Ãš","U",$cadena);
		return $cadena;
	}

	function strMinus($cadena) {
		$cadena = aceptarComilla($cadena);
		return utf8_encode(strtolower((utf8_decode($cadena))));
	}

	function strMayus($cadena) {
		$cadena = aceptarComilla($cadena);
		return utf8_encode(strtoupper((utf8_decode($cadena))));
	}

	function comprobarVar($variable) {
		if (isset($variable) and strcmp(trim($variable),"") != 0)
		return true;
		else
		return false;
	}

	function aceptarComilla($cadena) {
		$cadena=trim($cadena);
		return str_replace("'","\'",$cadena);
	}

	function limpiarPalabra($palabra) {
		$resultado = trim($palabra);
		$valor = stripos($resultado," ");
		if ($valor)
		return "";
		else
		return $resultado;
	}

	function formatoFechaHoraBd() {
		ini_set('date.timezone','UTC');
		$tiempoMod =  time() - 14400;//16200    -4.5 GMT (Caracas - Venezuela)
		return date("Y-m-d H:i:s",$tiempoMod);
	}

	function fechaPasada($anos) {
		$fechaActual = formatoFecha();
		$dia = substr($fechaActual,0,2);
		$mes = substr($fechaActual,3,2);
		$ano = substr($fechaActual,6,4);
		$tiempo = mktime(0,0,0,$mes,$dia,($ano - $anos));
		return date("d/m/Y",$tiempo);
	}

	function restarFechas($fecha1,$fecha2,$anos) {
		$dia1 = substr($fecha1,0,2);
		$mes1 = substr($fecha1,3,2);
		$ano1 = substr($fecha1,6,4);
		$dia2 = substr($fecha2,0,2);
		$mes2 = substr($fecha2,3,2);
		$ano2 = substr($fecha2,6,4);
		$tiempo1 = mktime(0,0,0,$mes1,$dia1,$ano1);
		$tiempo2 = mktime(0,0,0,$mes2,$dia2,$ano2);
		$tiempoDif = $tiempo1 - $tiempo2;
		if ($tiempoDif < 0) {
			return false;
		} else {
			if ($anos === true) {
				return date("Y",$tiempoDif) - 1970;
			} else {
				$diasDif = $tiempoDif / (60 * 60 * 24);
				return $diasDif;
			}
		}
	}

	function formatoFecha($fecha,$mesDia) {
		if (isset($fecha) and strcmp($fecha,"") != 0) {
			$hora=substr($fecha,11,8);
			if ($mesDia === true) {
				$fechaNueva = substr($fecha,3,2)."-";
				$fechaNueva .= substr($fecha,0,2)."-";
				$fechaNueva .= substr($fecha,6,4);
			} else {
				$fechaNueva = substr($fecha,8,2)."-";
				$fechaNueva .= substr($fecha,5,2)."-";
				$fechaNueva .= substr($fecha,0,4);
			}
			if($hora!='') $fechaNueva.=" $hora";
			return $fechaNueva;
		} else {
			ini_set('date.timezone','UTC');
			$tiempoMod =  time() - 14400;//16200    -4.5 GMT (Caracas - Venezuela)
			return date("d/m/Y",$tiempoMod);
		}
	}
	function formatoHora($fechaHora) {
		if (isset($fechaHora) and strcmp($fechaHora,"") != 0) {
			$hora = substr($fechaHora,11,8);
			return $hora;
		} else {
			ini_set('date.timezone','UTC');
			$tiempoMod =  time() - 14400;//16200    -4.5 GMT (Caracas - Venezuela)
			return date("H:i:s",$tiempoMod);
		}
	}
	function formatoFechaBd($fecha,$otroFormato) {
		if (isset($fecha)) {
			// Se chequea que la fecha este separada por "/" o "-" y que sean 3 valores
			$arregloFecha = split('[/]',$fecha);
			if ((!isset($arregloFecha)) or count($arregloFecha) != 3) {
				$arregloFecha = split('[-]',$fecha);
				if ((!isset($arregloFecha)) or count($arregloFecha) != 3) {
					return null;
				}
			}
			// Se chequea que sean valores enteros
			foreach ($arregloFecha as $i=>$valor) {
				if ((!is_numeric($valor)) or intval($valor) < 1) {
					return null;
				} else {
					if (intval($valor) < 10 and strlen(trim($valor)) == 1) {
						$arregloFecha[$i] = "0$valor";
					}
				}
			}
			// Se chequea que la fecha tenga formato correcto
			$fecha = $arregloFecha[0]."/".$arregloFecha[1]."/".$arregloFecha[2];
			if (!verificarFormatoFecha($fecha)) {
				return null;
			}
			if (strlen($arregloFecha[2]) == 4 and intval($arregloFecha[2]) > 2038 or intval($arregloFecha[2]) < 1970) {
				return $arregloFecha[2]."-".$arregloFecha[1]."-".$arregloFecha[0];
			} else {
				// Se toma la marca de tiempo UNIX de la fecha
				$marcaTiempo = mktime(0,0,0,$arregloFecha[1],$arregloFecha[0],$arregloFecha[2]);
				return date(((comprobarVar($otroFormato)) ? $otroFormato : "Y-m-d"),$marcaTiempo);
			}
		} else {
			ini_set('date.timezone','UTC');
			$tiempoMod =  time() - 14400;//16200    -4.5 GMT (Caracas - Venezuela)
			return date(((comprobarVar($otroFormato)) ? $otroFormato : "Y-m-d"),$tiempoMod);
		}
	}

	function formatoHoraBd() {
		ini_set('date.timezone','UTC');
		$tiempoMod =  time() - 14400;//16200    -4.5 GMT (Caracas - Venezuela)
		return date("H:i:s",$tiempoMod);
	}

	function verificarFormatoFecha($fecha,$ddmmyyyy) {
		$fecha = str_replace("-","/",trim($fecha));
		if (isset($fecha) and strcmp($fecha,"") != 0) {
			if (strlen($fecha) != 10 and ((!isset($ddmmyyyy)) or $ddmmyyyy === false))
			return false;
			$arregloFecha = split('[/]',$fecha);
			if (isset($arregloFecha) and count($arregloFecha) == 3) {
				$mesesDias[1] = 31;
				$mesesDias[3] = 31;
				$mesesDias[4] = 30;
				$mesesDias[5] = 31;
				$mesesDias[6] = 30;
				$mesesDias[7] = 31;
				$mesesDias[8] = 31;
				$mesesDias[9] = 30;
				$mesesDias[10] = 31;
				$mesesDias[11] = 30;
				$mesesDias[12] = 31;
				// Verifico el aÃ±o
				if (!is_numeric($arregloFecha[2]) or intval($arregloFecha[2]) > 9999
				or intval($arregloFecha[2]) < 1900)
				return false;
				// Verifico los meses
				if (!is_numeric($arregloFecha[1]) or intval($arregloFecha[1]) > 12
				or intval($arregloFecha[1]) < 1)
				return false;
				// Verifico los dias
				if (!is_numeric($arregloFecha[0]) or intval($arregloFecha[0]) > 31
				or intval($arregloFecha[0]) < 1)
				return false;
				// Verifico la cantidad de dias por meses (excepto febrero)
				if (intval($arregloFecha[1]) != 2) {
					if (intval($arregloFecha[0]) > $mesesDias[intval($arregloFecha[1])])
					return false;
				} else {
					// Verifico la cantidad de dï¿½as para febrero
					if (((intval($arregloFecha[2]) % 4) == 0) and (intval($arregloFecha[0]) > 29)) {
						return false;
					}
					if (((intval($arregloFecha[2]) % 4) != 0) and (intval($arregloFecha[0]) > 28)) {
						return false;
					}
				}
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	function formatoDouble($valor,$formatoBd) {
		$valor = "$valor";
		$tamano = strlen($valor);
		$separador1 = $formatoBd ? "." : ",";
		$separador2 = $formatoBd ? "," : ".";
		for ($i=0;$i < $tamano;$i++) {
			if (strcmp($valor[$i],$separador2) == 0) {
				$valor[$i] = $separador1;
				return $valor;
			}
		}
		return $valor;
	}

	/**
	* 
	* funcion que calcula la diferencia de tiempo
	* @param unknown_type $dtime
	* @param unknown_type $atime
	* pp
	*/
	function getTimeDiff($dtime,$atime){
	
	$nextDay=$dtime>$atime?1:0;
	$dep=EXPLODE(':',$dtime);
	$arr=EXPLODE(':',$atime);
	$diff=ABS(MKTIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-MKTIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));
	$hours=FLOOR($diff/(60*60));
	$mins=FLOOR(($diff-($hours*60*60))/(60));
	$secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
	IF(STRLEN($hours)<2){$hours="0".$hours;}
	IF(STRLEN($mins)<2){$mins="0".$mins;}
	IF(STRLEN($secs)<2){$secs="0".$secs;}
	RETURN $hours.':'.$mins.':'.$secs;
	}

	/**
	* 
	* funcion que calcula la quincena de la fecha dada
	* @param date $fecha
	* @return integer
	* jg
	*/
	function calcularQuincena($fecha){
		$date = strtotime($fecha);
		$mes= date("m", $date); // Obtiene el mes de la fecha dada
		$dia= date("d", $date); // Obtiene el dia de la fecha dada
		return  $dia<=15? $mes*2-1:$mes*2;
	}

	function formatoCedula($nac, $cedula){

		$cedula = str_pad($cedula, 8, 0, STR_PAD_LEFT); 
		$cedula = $nac.$cedula;

		return $cedula;
	}

	function formatoRif($tipo,$rif){

		$rif = str_pad($rif, 9, 0, STR_PAD_LEFT); 
		$rif = $tipo.$rif;

		return $rif;
	}

	function formFecha($fecha,$formato){

		if(!$formato) $formato = 'Y-m-d H:i:s';

		$nuevaFecha = date_format(date_create_from_format($formato, $fecha), 'd-m-Y');

		return $nuevaFecha;
	}
	function formFechaHora($fecha,$formato){

		if(!$formato) $formato = 'Y-m-d H:i:s';

		$nuevaFecha = date_format(date_create_from_format($formato, $fecha), 'd-m-Y H:i');

		return $nuevaFecha;
	}
	function formFechaHoraSegundo($fecha,$formato){

		if(!$formato) $formato = 'Y-m-d H:i:s';

		$nuevaFecha = date_format(date_create_from_format($formato, $fecha), 'd-m-Y H:i:s');

		return $nuevaFecha;
	}
	function formFechaPers($fecha,$formatoActual,$formatoDeseado){

		$nuevaFecha = date_format(date_create_from_format($formatoActual, $fecha), $formatoDeseado);

		return $nuevaFecha;
	}
	function formFechaBd($fecha,$formatoActual){
		
		$nuevaFecha = date_format(date_create_from_format($formatoActual, $fecha), 'Y-m-d');

		return $nuevaFecha;
	}
	function formFechaHoraBd($fecha,$formatoActual){

		$nuevaFecha = date_format(date_create_from_format($formatoActual, $fecha), 'Y-m-d H:i:s');

		return $nuevaFecha;
	}

	function obtenerIP(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			return $_SERVER['HTTP_CLIENT_IP'];
		}
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			 return $_SERVER['REMOTE_ADDR'];
		}
	}

	function generarNumRim(){
		$conexion  = new ConexionBd();
		$actividad = new Actividad($conexion);
		$arrRim = $actividad->consultarUltNumRim();
		$ultNumRim = $arrRim[0]['ult_num_rim'];

		if($ultNumRim){
			$fragmentos = explode('-',$ultNumRim);
			$nvoNumRim = $fragmentos[0]."-".str_pad(($fragmentos[1]+1), 5, 0, STR_PAD_LEFT);
		}
		else $nvoNumRim = date('Y')."-".str_pad(1, 5, 0, STR_PAD_LEFT);

		return $nvoNumRim;
	}

	function subirFotoInvol($archivo,$rutaDestino){
		$archivo = base64_decode($archivo);
		file_put_contents($rutaDestino, $archivo);
	}

	function gestionFotoInvol($accion,$ruta,$contenido,$cedula){

		$extension 	= array('.jpg','.jpeg','.png','.JPG','.JPEG','.PNG');

		switch($accion){
			case 'subir':
				$archivo = base64_decode($contenido);
				file_put_contents($ruta,$archivo);
			break;
			case 'consultar':
				foreach($extension as $i=>$ext){
					$evaluar = $ruta.$ext;
					if(file_exists($evaluar)) $archivo = $evaluar;
				}
				return $archivo;
			break;
			case 'remover':
				$ruta = 'multimedia/imagen/infractor/';
				foreach($extension as $i=>$ext){
					$archivo = $ruta.$cedula.$ext;
					if(file_exists($archivo)) unlink($archivo);
				}
			break;
		}
	}

	function eliminarInvolucrado($arrInv){

		$conexionBd 	= new ConexionBd();

		foreach($arrInv as $i=>$registro){
			$relInvol       =  new RelActividadInvolucrado();
			$relInvol       -> setObjeto('Involucrado',$registro);
			$arrInvol       = $relInvol->consultar();

			if(count($arrInvol) <= 0){
				$involucrado    =  new Involucrado(null,$registro);
				$involCedula    = $involucrado->getAtributo('invol_cedula');

				$strFrom    = 'involucrado';
				$strWhere   = 'invol_id = '.$registro;
				$ctrlDelInv = $conexionBd->hacerDelete($strFrom,$strWhere);

				if($ctrlDelInv){
					gestionFotoInvol('remover',null,null,$involCedula);
					unset($involucrado);
				}
			}
		}
	}

	function hashReporte($id){
		$string = $_SESSION['Login'].$id;
		$clave  = strtoupper(sha1($string)."pdf");
		$word 	= $_SESSION['UsuarioCarne'];
		$hash  	= substr($clave,0,2).substr($word,0,2).substr($clave,2,2).substr($word,2,2).substr($clave,4,2).substr($word,4,2).substr($clave,6,2);
		return $hash;
	}
?>