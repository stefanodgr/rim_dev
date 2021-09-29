<?php
	$rutaDir = '../../';
    include_once $rutaDir.'config.php';
	
	// -- USANDO CLASE BD -- //

		$entesSeg 	= new EntesSeguridad();
		$arrEntes   = $entesSeg->consultar();
		
		if(count($arrEntes)>0){
			foreach($arrEntes as $i=>$unEnte){
				$contenido['id'] 	= trim($unEnte->getAtributo('codente'));
				$contenido[0]		= ++$i;			// ÍNDICE
				$contenido[1]		= trim($unEnte->getAtributo('descente'));
				$data[]             = $contenido;
			}
		}
		else {
			$data = cargarFilaVacia(2,'json'); // DEVUELVE UNA FILA VACÍA LISTA PARA EDITAR
			// $data = 0; 	// DEVUELVE UNA FILA CON EL MENSAJE 'No existen registros en la tabla'. 
		}
		

	// --------------------- //

	// -- USANDO CONEXION BD -- //
		/*
		$miConexionBd 	= new ConexionBd();
		$arrEntes 	= $miConexionBd->hacerSelect("*","entesseguridad",null,null,"codente");

		if(count($arrEntes)>0){
			foreach($arrEntes as $i=>$unEnte) {
				$contenido['id']= $unEnte['codente'];
				$contenido[0]	= ++$i;				// ÍNDICE	
				$contenido[1] 	= $unEnte['descente'];
				$data[] 		= $contenido;
			}
		}
		else $data = cargarFilaVacia(2,'json');
		*/
	// ----------------------- //

	$arrJson[data] = $data;
	$json = json_encode($arrJson);
	echo($json);

   	 
   	// $arrDec = json_decode($json);
	// echo("<hr><pre>");
    // print_r($json);
 	// echo("</pre><hr>");
?>