<?php
    // -------------------------- REGISTRO DE FUNCIONES XAJAX -------------------------- //
        $xajax->registerFunction('buscarInfractor');
        $xajax->registerFunction('modificarInfractor');
    // --------------------------------------------------------------------------------- //

    // -------------------------------- FUNCIONES XAJAX -------------------------------- //
        function buscarInfractor($infractorId, $infractorNac, $infractorCed, $infractorNomb, $infractorApe, $infractorAlias, $infractorBanda){
            global $objResponse;
            if($infractorCed) $cedula = formatoCedula($infractorNac, $infractorCed);

            $involucrado = new Involucrado();
            $arrInfractor = $involucrado->buscarInvolucrado($infractorId, $cedula, $infractorNomb, $infractorApe, $infractorAlias, $infractorBanda, 'infractor',1,'procesado'); // SOLO INFRACCIONES PROCESADAS
            // $arrInfractor = $involucrado->buscarInvolucrado($infractorId, $cedula, $infractorNomb, $infractorApe, $infractorAlias, $infractorBanda, 'infractor',1);     //TEMPORAL PARA CONSULTAR INFRACTORES SIN IMPORTAR ESTADO DE LA INFRACCIÓN

            if(count($arrInfractor) > 0){
                if(count($arrInfractor) == 1){
                    $infractorId = $arrInfractor[0]['id'];
                    unset($arrInfractor);

                    $arrInfractor = $involucrado->buscarInvolucrado($infractorId);
                    
                    $infId      = $arrInfractor[0]['id'];
                    $infNombre  = utf8_decode($arrInfractor[0]['nombre']);
                    $infApellido= utf8_decode($arrInfractor[0]['apellido']);
                    $infAlias   = utf8_decode($arrInfractor[0]['alias']);
                    $infBanda   = utf8_decode($arrInfractor[0]['banda']);
                    $infTelf    = $arrInfractor[0]['telefono'];
                    $infDirecc  = utf8_decode($arrInfractor[0]['direccion']);
                    $infMetro   = utf8_decode($arrInfractor[0]['pers_id']);
                    $infFoto    = utf8_decode($arrInfractor[0]['foto']);

                    if($infFoto == 't'){
                        if($infMetro) $infFoto = gestionFotoInvol('consultar','../sictra/fotos/'.$arrInfractor[0]['cedula']);
                        else $infFoto = gestionFotoInvol('consultar','multimedia/imagen/infractor/'.$arrInfractor[0]['cedula']);
                    }
                    else $infFoto = 'multimedia/imagen/infractor/siluetaHombre.png';

                    $string     = str_split($arrInfractor[0]['cedula']);
                    $infNac     = $string[0];

                    foreach($string as $i=>$caracter) if($i !=0 ) $infCedula.=$caracter; 

                    $objResponse->addAssign('filt_id'        ,'value',$infId);
                    $objResponse->addAssign('filt_nac'       ,'value',$infNac);
                    $objResponse->addAssign('filt_cedula'    ,'value',$infCedula);
                    $objResponse->addAssign('filt_nombre'    ,'value',$infNombre);
                    $objResponse->addAssign('filt_apellido'  ,'value',$infApellido);
                    $objResponse->addAssign('filt_alias'     ,'value',$infAlias);
                    $objResponse->addAssign('filt_banda'     ,'value',$infBanda);
                    $objResponse->addAssign('filt_telefono'  ,'value',$infTelf);
                    $objResponse->addAssign('filt_direccion' ,'value',$infDirecc);
                    $objResponse->addAssign('filt_foto'      ,'src',$infFoto); 

                    $expInfractor = count($involucrado->consultarExpediente($infractorId,'procesado'));
                    if($expInfractor > 1) $objResponse->addScriptCall(infReincidenciaInf,1);
                    
                    $objResponse->addScriptCall(mostrarInfractor,$infId,$infNombre.' '.$infApellido,$infMetro);

                }
                else{
                    foreach($arrInfractor as $i=>$infractor) $lista[$i] = $infractor['id'];
                    $objResponse->addScriptCall(listaInfractor,$lista);
                }
            }
            else{
                $objResponse->addAlert(utf8_decode("No se encontró ningún registro que coincida con los datos suministrados."));
            }
            return $objResponse;
        }
        
        function modificarInfractor($infractorId, $infractorNac, $infractorCed, $infractorNomb, $infractorApe, $infractorAlias, $infractorBanda, $infractorTelf, $infractorDirec, $infractorFoto){
            global $objResponse;

            $infractorNomb  = utf8_encode($infractorNomb);
            $infractorApe   = utf8_encode($infractorApe);
            $infractorAlias = utf8_encode($infractorAlias);
            $infractorBanda = utf8_encode($infractorBanda);
            $infractorDirec = utf8_encode($infractorDirec);

            $involucrado = new Involucrado(null,$infractorId);
            $involucrado->setAtributo('invol_cedula',$infractorNac.$infractorCed);
            $involucrado->setAtributo('invol_nombres',$infractorNomb);
            $involucrado->setAtributo('invol_apellidos',$infractorApe);
            $involucrado->setAtributo('invol_alias',$infractorAlias);
            $involucrado->setAtributo('invol_banda',$infractorBanda);
            $involucrado->setAtributo('invol_telf',$infractorTelf);
            $involucrado->setAtributo('invol_direccion',$infractorDirec);

            if($infractorFoto != 'undefined'){
                $ctrlUpload = true;
                $rutaFoto   = "multimedia/imagen/infractor/".$infractorNac.$infractorCed.".jpg";
                $involucrado->setAtributo('invol_foto', true);
            } 

            if($involucrado->modificar()){
                
                $objResponse->addScript("$('#btn_infractor_lim').click();");
                $objResponse->addScript('xajax_buscarInfractor("'.$infractorId.'")');
                if($ctrlUpload){
                    gestionFotoInvol('remover',null,null,$infractorNac.$infractorCed);
                    gestionFotoInvol('subir',$rutaFoto,$infractorFoto);
                }
            }
            else $objResponse->addAlert('Error al modificar');

            return $objResponse;
        }
    // --------------------------------------------------------------------------------- //
?>