<?php
	$rutaDir = '';
	include_once 'config.php';

	isset($_SESSION['IdConexion']) ? $ctrlCerrarConexion = true : $ctrlCerrarConexion = false;
	
	// --------------- CARGA DE FUNCIONALIDADES XAJAX --------------- //
		$xajax->printJavascript('libreria/');
	// -------------------------------------------------------------- //
	
	$ctrlIniciar = false;

	if($ctrlCerrarConexion){
		$conexion = new Conexion();
		$ctrlConexion = $conexion->cerrarConexion(null,$_SESSION['IdConexion']);
		session_destroy();

		if($ctrlConexion) $ctrlIniciar = true;
	}
	else $ctrlIniciar = true;
	
	if($ctrlIniciar){
		$TBS = new clsTinyButStrong;
		$TBS->LoadTemplate('vista/inicio/index.tpl');
		$TBS->Show();
	}
	else echo(utf8_decode("ERROR DEL SISTEMA: Intente cargar la página nuevamente"));
?>
