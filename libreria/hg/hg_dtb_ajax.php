<?php	
	// -------------------------- REGISTRO DE FUNCIONES XAJAX -------------------------- //
	
		$xajax->registerFunction('gestHgDtb');

	// ----------------------- FIN DE REGISTRO DE FUNCIONES XAJAX ---------------------- //
	
	// -------------------------------- FUNCIONES XAJAX -------------------------------- //

        function gestHgDtb($tipoAccion ,$arrQuery, $tipo, $content){
	 	
			$objResponse = new xajaxResponse();
			
			$ctrlMsj = false;
			$mensaje = '';
            
            switch ($tipoAccion) {
                case 1:                             // INSERT
                    $insert     = $arrQuery[0];
                    $controlIns = false;
                    $ctrlRel    = false;

                    /* if(count($insert[1]) > 0) $ctrlRel = true;
                    
                      if($ctrlRel == false){
                        foreach ($insert[0] as $i=>$unInsert){
                            $objResponse->addAlert($unInsert);
                        }
                    }
                    else{
                        foreach ($insert[0] as $i=>$unInsert){
                            foreach($insert[1] as $j=>$unInsertAct){
                                $objResponse->addAlert($unInsert);
                                $objResponse->addAlert($unInsertAct);
                            }
                        }
                    }   */
                    
                    $miConexionBdIns = new ConexionBd();
                    $miConexionBdIns->hacerConsulta("BEGIN;");
                   
                    if($ctrlRel == false){
                        foreach($insert[0] as $i=>$unInsert){
                            $controlIns     = $miConexionBdIns->hacerConsulta($unInsert);
                            if(!$controlIns) break; 
                        }
                    }
                    else{
                        foreach($insert[0] as $i=>$unInsert){
                            foreach($insert[1] as $i=>$unInsertAct){
                                $controlIns     = $miConexionBdIns->hacerConsulta($unInsert);
                                $controlInsAct  = $miConexionBdIns->hacerConsulta($unInsertAct);
                                if(!$controlIns) break;
                            }
                        }
                    }

                    if(!$controlIns){
                        $ctrlMsj = true;
                        $mensaje .= "Error al insertar nuevo(s) registro(s).\n";
                        $miConexionBdIns->hacerConsulta("ROLLBACK;");
                    }
                    else {
                        $mensaje .= "Registro(s) insertado(s) de manera exitosa.\n";
                        $miConexionBdIns->hacerConsulta("COMMIT;");     
                    }  
                    
                break;
                case 2:                             // UPDATE
                    $update     = $arrQuery[0];
                    $controlUpd = false;
                    
                    /* foreach ($update[0] as $i=>$unUpdate){
                        $objResponse->addAlert($unUpdate);
                    } */
                    
                    $miConexionBdUpd = new ConexionBd();
                    $miConexionBdUpd->hacerConsulta("BEGIN");

                    foreach($update[0] as $i=>$unUpdate){
                        $controlUpd = $miConexionBdUpd->hacerConsulta($unUpdate);
                        if(!$controlUpd) break;
                    }
                    if (!$controlUpd) {
                        $ctrlMsj = true;
                        $mensaje .= "Error al guardar modificaciones.";
                        $miConexionBdUpd->hacerConsulta("ROLLBACK");
                    }
                    else {
                        //$mensaje .= utf8_decode("Modificaciones guardadas con éxito.");
                        $miConexionBdUpd->hacerConsulta("COMMIT");
                    } 
                break;
                case 3:                             // INSERT Y UPDATE
                    $insert     = $arrQuery[0];
                    $update     = $arrQuery[1];
                    $controlIns = false;
                    $controlUpd = false;
                    $ctrlRel    = false;

                    if(count($insert[1]) > 0) $ctrlRel = true;
                    
                    /* if($ctrlRel == false){
                        foreach ($insert[0] as $i=>$unInsert){
                            $objResponse->addAlert($unInsert);
                        }
                    }
                    else{
                        foreach ($insert[0] as $i=>$unInsert){
                            foreach($insert[1] as $j=>$unInsertAct){
                                $objResponse->addAlert($unInsert);
                                $objResponse->addAlert($unInsertAct);
                            }
                        }
                    }
                    foreach ($update[0] as $i=>$unUpdate){
                        $objResponse->addAlert($unUpdate);
                    } */
                     
                    $miConexionBdIns = new ConexionBd();
                    $miConexionBdIns->hacerConsulta("BEGIN");
                    
                    if($ctrlRel == false){
                        foreach($insert[0] as $i=>$unInsert){
                            $controlIns     = $miConexionBdIns->hacerConsulta($unInsert);
                            if(!$controlIns) break;
                        }
                    }
                    else{
                        foreach($insert[0] as $i=>$unInsert){
                            foreach($insert[1] as $i=>$unInsertAct){
                                $controlIns     = $miConexionBdIns->hacerConsulta($unInsert);
                                $controlInsAct  = $miConexionBdIns->hacerConsulta($unInsertAct);
                                if(!$controlIns) break;
                            }
                        }
                    }
                    if(!$controlIns){
                        $ctrlMsj = true;
                        $mensaje .= "Error al insertar nuevo(s) registro(s).\n";
                        $miConexionBdIns->hacerConsulta("ROLLBACK");
                    }
                    else {
                        //$mensaje .= "Registro(s) insertado(s) de manera exitosa.\n";
                        $miConexionBdIns->hacerConsulta("COMMIT");     
                    }

                    $miConexionBdUpd = new ConexionBd();
                    $miConexionBdUpd->hacerConsulta("BEGIN");

                    foreach($update[0] as $i=>$unUpdate){
                        $controlUpd = $miConexionBdUpd->hacerConsulta($unUpdate);
                        if(!$controlUpd) break; 
                    }
                    if (!$controlUpd) {
                        $ctrlMsj = true;
                        $mensaje .= "Error al guardar modificaciones.";
                        $miConexionBdUpd->hacerConsulta("ROLLBACK");
                    }
                    else {
                        //$mensaje .= utf8_decode("Modificaciones guardadas con éxito.");
                        $miConexionBdUpd->hacerConsulta("COMMIT");
                    } 
                break;
                case 4:
                    $controlDel         = false;
                    $miConexionBdDel    = new ConexionBd();
                    $miConexionBdDel    ->hacerConsulta("BEGIN");
                    $controlDel         = $miConexionBdDel->hacerConsulta($arrQuery[0]);
                    
                    if (!$controlDel){
                        $ctrlMsj = true;
                        $mensaje .= "Error eliminando el registro.";
                        $miConexionBdDel->hacerConsulta("ROLLBACK");
                    }
                    else{
                        if(count($arrQuery) > 1){
                            // $objResponse->addAlert("as");
                             //VALIDAR SI ESE ID YA EXISTE EN LA TABLA RELACIÓN PARA EVITAR BORRARLO.
                        }
                        else  $miConexionBdDel->hacerConsulta("COMMIT");
                    }
                    // if(count($arrQuery) < 2){
                        // SE REALIZA TAMBIEN DELETE A LA TABLA RELACIONAL
                    // }
                break;
            }
			if($ctrlMsj == true){$objResponse->addAlert($mensaje);}
			if(($tipo == 'boton')||($tipo == 'paginacion')){
                if ($content['tag'] == "name") $objResponse->addScript('window.frames["'.$content['valor'].'"].recargar();');
                else $objResponse->addScript('window.frames["'.$content['valor'].'"].contentWindow.recargar();');
            }
			if($tipo == 'eliminar') $objResponse->addScriptCall(eliminarRegistros,true);

			return $objResponse;
		}
	// ---------------------------- FIN DE FUNCIONES XAJAX ----------------------------- //
?>