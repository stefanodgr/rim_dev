<?php
	$rutaDir = "../../";
	include_once $rutaDir.'config.php';
	
	session_unset(); 
	
	$TBS = new clsTinyButStrong;
	$TBS->LoadTemplate($rutaDir.'vista/inicio/login.tpl');
	$TBS->Show();
?>