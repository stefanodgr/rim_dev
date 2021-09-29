<?php
	$xajax 			= new xajax();							// INSTANCIA DE CLASE XAJAX
	$objResponse 	= new xajaxResponse();					// INSTANCIA DE CLASE XAJAX RESPONSE

	include_once RUTA_SISTEMA.'inc/ajax_ext.php';			// INCLUSION DE ARCHIVOS XAJAX EXTERNOS
		
	$xajax->processRequests();
?>