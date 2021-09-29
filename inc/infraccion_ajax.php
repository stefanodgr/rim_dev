<?php
    // -------------------------- REGISTRO DE FUNCIONES XAJAX -------------------------- //
        $xajax->registerFunction('buscarInfraccion');
        $xajax->registerFunction('registrarInfraccion');
        $xajax->registerFunction('modificarInfraccion');
        $xajax->registerFunction('removerInfraccion');
        $xajax->registerFunction('buscarPersonal');
        $xajax->registerFunction('buscarInvolucrado');
        $xajax->registerFunction('agregarInvolucrado');
        $xajax->registerFunction('removerInvolucrado');
        $xajax->registerFunction('agregarDocumento');
        $xajax->registerFunction('removerDocumento');
        $xajax->registerFunction('agregarMaterial');
        $xajax->registerFunction('removerMaterial');
        $xajax->registerFunction('buscarPlaca'); 
        $xajax->registerFunction('agregarVehiculo'); 
        $xajax->registerFunction('buscarSancion'); 
        $xajax->registerFunction('buscarMedida');
        $xajax->registerFunction('aplicarSancionMedida');
        $xajax->registerFunction('subirFotoInvol');
        $xajax->registerFunction('cargarEvidencia');
        $xajax->registerFunction('removerEvidencia');
        $xajax->registerFunction('generarReporteInfraccion');
    // --------------------------------------------------------------------------------- //

    // -------------------------------- FUNCIONES XAJAX -------------------------------- //
        function buscarInfraccion($infraccionId){
            global $objResponse;
            
            $objResponse->addScriptCall(limpiarFichaInfraccion);
            $actividad = new Actividad();
            $infraccion = $actividad->buscarInfraccion($infraccionId);
            
            if(is_array($infraccion)){
                $infracId 	    = $infraccion[0]["id"];
                $infracRim	    = $infraccion[0]["rim"];
                $infracLin	    = utf8_decode($infraccion[0]["linea"]);
                $infracEst	    = utf8_decode($infraccion[0]["estacion"]);
                $infracLugar    = utf8_decode($infraccion[0]["lugar"]);
                $infracAct	    = utf8_decode($infraccion[0]["actividad"]);
                $infracFecha    = formFechaHora($infraccion[0]["fecha"]);
                $infracFechaReg = formFechaHoraSegundo($infraccion[0]["registro"]);
                $infracEdo	    = $infraccion[0]["estado"];
                $infracDescrip	= utf8_decode($infraccion[0]["descripcion"]);
                $infracUsu	    = $infraccion[0]["usuario"];

                $objResponse->addAssign('infraccion_id'     ,'value',$infracId);
                $objResponse->addAssign('filt_fecha_inf'    ,'value',$infracFecha);
                $objResponse->addAssign('filt_rim_inf'      ,'value',$infracRim);
                $objResponse->addAssign('filt_lugar'        ,'value',$infracLugar);
                $objResponse->addAssign('filt_descripcion'  ,'value',$infracDescrip); 
                $objResponse->addAssign('filt_usuario'      ,'value',$infracUsu);
                $objResponse->addAssign('filt_registro'     ,'value',$infracFechaReg);
                $objResponse->addScriptCall(selectManual,'filt_actividad',$infracAct);
                $objResponse->addScriptCall(selectManual,'filt_ubicacion',$infracLin);
                $objResponse->addScriptCall(selectManual,'filt_estado',$infracEdo); 
                $objResponse->addScriptCall(cargarEstacion,2);
                $objResponse->addScriptCall(seleccionarLinea,'filt_ubicacion2',$infracEst);
                $objResponse->addScriptCall(cargarIfrInfraccion,$infracId,$infracEdo);
                $objResponse->addScript('xajax_cargarEvidencia('.$infracId.',"'.$infracEdo.'");');
            }
            return $objResponse;
        }

        function registrarInfraccion($infFecha,$infLugar,$infDesc,$infAct,$infUbic,$infUbic2){
            global $objResponse;

            $fechaRegistro  = formatoFechaHoraBd();
            $infFecha       = formFechaHoraBd($infFecha,'d-m-Y H:i');

            // $objResponse->addAlert($infFecha." -- ".$infLugar." -- ".$infDesc." -- ".$infAct." -- ".$infUbic." -- ".$infUbic2);
            $actividad = new Actividad();
            $actividad->setAtributo('actividad_fecha'       ,$infFecha); 
            $actividad->setAtributo('actividad_fecha_reg'   ,$fechaRegistro);
            $actividad->setAtributo('actividad_lugar'       ,utf8_encode(strtoupper($infLugar)));
            $actividad->setAtributo('actividad_descrip'     ,utf8_encode(strtoupper($infDesc)));
            $actividad->setObjeto('TipoActividad',      $infAct);
            $actividad->setObjeto('Status',     '1');
            $actividad->setObjeto('Estacion',   $infUbic2);
            $actividad->setObjeto('Conexion',   $_SESSION['IdConexion']);

            $ctrlInsAct = $actividad->registrar();

            if($ctrlInsAct){
                $relacion = new RelActividadStatus();
                $ctrlInsRel = $relacion->registrarStatus($actividad->getAtributo('actividad_id'),'1');

                if($ctrlInsRel){
                    $objResponse->addScriptCall(aceptarGestInfraccion,1,$actividad->getAtributo('actividad_id'));
                } 
                else{
                    $objResponse->addAlert('Error2');
                }
            }
            else{
                $objResponse->addAlert('Error1');
            } 

            return $objResponse;
        }

        function modificarInfraccion($infId,$infFecha,$infLugar,$infDesc,$infAct,$infEstado,$infUbic,$infUbic2,$ctrlEstado){
            global $objResponse;

            $nvoNumRim = generarNumRim();
            $infFecha  = formFechaHoraBd($infFecha,'d-m-Y H:i');

            $conexionBd = new ConexionBd();
            $conexionBd->hacerConsulta('BEGIN');

            $actividad  = new Actividad($conexionBd,$infId);
            $actividad->setAtributo('actividad_fecha'   ,$infFecha);
            $actividad->setAtributo('actividad_lugar',  utf8_encode(strtoupper($infLugar)));
            $actividad->setAtributo('actividad_descrip',utf8_encode(strtoupper($infDesc)));
            $actividad->setObjeto('TipoActividad',      $infAct);
            $actividad->setObjeto('Status',     $infEstado);
            $actividad->setObjeto('Estacion',   $infUbic2); 
            // $actividad->setObjeto('Conexion',   $_SESSION['IdConexion']); // AL HABLITAR ESTA LÍNEA EL USUARIO QUE MODIFIQUE LA INFRACCIÓN SERA EL NUEVO DUEÑO DE LA INFRACCIÓN (NO RECOMENDABLE)

            $ctrlUpd = $actividad->modificar();

            if($ctrlUpd){
                if($ctrlEstado == 'true'){
                    
                    $relacion = new RelActividadStatus($conexionBd);

                    if(($infEstado == 2)||($infEstado == 3)){
                        if($_SESSION['PerfilUsuario'] == 'MASTER'){
                            $ctrlInsRel = $relacion->registrarStatus($infId,$infEstado);
                        }
                        else{
                            $ctrlInsRel = false;
                            $objResponse->addAlert(utf8_decode('ERROR: No posee los permisos necesarios para procesar esta infracción.'));
                            return $objResponse;
                        }
                    }
                    else $ctrlInsRel = $relacion->registrarStatus($infId,$infEstado);

                    if($ctrlInsRel){
                        if($infEstado == 3){
                            $actividad->setAtributo('activ_num_rim',$nvoNumRim);
                            $ctrlRim = $actividad->modificar();

                            if($ctrlRim){
                                $conexionBd->hacerConsulta('COMMIT');
                                $objResponse->addAssign('filt_rim_inf','value',$nvoNumRim);
                                $objResponse->addScriptCall(aceptarGestInfraccion,2);
                                $objResponse->addScript("xajax_generarReporteInfraccion(".$infId.")");
                            }
                            else{
                                $conexionBd->hacerConsulta('ROLLBACK');
                                $objResponse->addAlert('Error3');
                            }
                        }
                        else{
                            $conexionBd->hacerConsulta('COMMIT');
                            $objResponse->addScriptCall(aceptarGestInfraccion);
                        }
                    }
                    else{
                        $conexionBd->hacerConsulta('ROLLBACK');
                        $objResponse->addAlert('Error2');
                    }
                }
                else{
                    $conexionBd->hacerConsulta('COMMIT');
                    $objResponse->addScriptCall(aceptarGestInfraccion);
                }
            }
            else{
                $conexionBd->hacerConsulta('ROLLBACK');
                $objResponse->addAlert('Error1');
            } 

            return $objResponse;
        }

        function removerInfraccion($arrInfraccion){
            global $objResponse;

            foreach($arrInfraccion as $i=>$infraccionId){

                $actividad = new Actividad(null,$infraccionId);
                $estado = $actividad->getObjeto('Status')->getAtributo('status_desc');
                unset($actividad);

                if(($estado != 'PROCESADO') && ($_SESSION['PerfilUsuario'] == 'MASTER')){       // SOLO USUARIOS MASTER PUEDEN REMOVER INFRACCIONES MIENTRAS NO ESTÉS PROCESADAS
                // if($_SESSION['PerfilUsuario'] == 'MASTER'){                                  // SOLO USUARIOS MASTER PUEDEN REMOVER INFRACCIÓNES SIN IMPORTAR SI ESTÁN PROCESADAS
                // if($estado != 'PROCESADO'){                                                  // CUALQUIER USUARIO PUEDE REMOVER INFRACCIONES MIENTRAS NO ESTÉN PROCESADAS
                // if(1 = 1){                                                                   // CUALQUIER USUARIO PUEDE REMOVER INFRACCIONES SIN IMPORTAR QUE ESTÉN PROCESADAS                                            // CUALQUIER USUARIO PUEDEN REMOVER INFRACCIONES
                    $conexionBd = new ConexionBd();
                    $conexionBd->hacerConsulta("BEGIN");
                    $strWhere   = "actividad_id in (".$infraccionId.")";

                    // ELIMINAR MATERIAL COMISADO RELACIONADO //
                    $strFrom    = "material_comisado";
                    $ctrlDelMat = $conexionBd->hacerDelete($strFrom,$strWhere);
                    // -------------------------------------- //

                    if($ctrlDelMat){

                        // ELIMINAR DOCUMENTOS RELACIONADOS //
                        $strFrom    = "documento";
                        $ctrlDelDoc = $conexionBd->hacerDelete($strFrom,$strWhere);
                        // --------------------------------- //

                        if($ctrlDelDoc){

                            // ELIMINA DE LA CARPETA DE EVIDENCIAS LAS FOTOS RELACIONADAS A LA INFRACCIÓN EN CUESTIÓN //
                            $fotoAdicional  = new FotoAdicional();
                            $arrEvidencia   = $fotoAdicional->obtenerEvidencia($infraccionId);
                            if(count($arrEvidencia) > 0) foreach($arrEvidencia as $i=>$fotoEvidencia) $arrFotoEvid[$i] = $fotoEvidencia->getAtributo('foto_desc'); 
                            // -------------------------------------------------------------------------------------- //

                            // ELIMINAR FOTOS ADICIONALES RELACIONADAS //
                            $strFrom        = "foto_adicional";
                            $ctrlDelFoto    = $conexionBd->hacerDelete($strFrom,$strWhere);
                            // --------------------------------------- //

                            if($ctrlDelFoto){

                                if(count($arrFotoEvid) > 0) foreach($arrFotoEvid as $foto) removerEvidencia($foto,$infraccionId);
                                
                                // ELIMINAR STATUS RELACIONADOS //
                                $strFrom        = "rel_activ_status";
                                $ctrlDelStatus   = $conexionBd->hacerDelete($strFrom,$strWhere);
                                // --------------------------------- //

                                if($ctrlDelStatus){

                                    // PARA OBTENER TODOS LOS ID DE LAS RELACIONES DE ACTIVIDAD CON INVOLUCRADO //
                                    $relActivInvol  = new RelActividadInvolucrado();
                                    $relActivInvol->setObjeto('Actividad',$infraccionId);
                                    $arrRelActiv    = $relActivInvol->consultar();
                                    foreach($arrRelActiv as $i=>$id) $arreglo[$i] = $id->getAtributo('rel_activ_invol_id');
                                    $arrActInvId = implode(',',$arreglo);
                                    // ------------------------------------------------------------------------ //

                                    // ELIMINAR SANCIONES RELACIONADAS //
                                    if($arrActInvId != null){
                                        $strFrom        = "rel_activ_invol_sancion";
                                        $strWhereRel    = "rel_activ_invol_id in (".$arrActInvId.")";
                                        $ctrlDelSancion = $conexionBd->hacerDelete($strFrom,$strWhereRel);
                                    }
                                    else $ctrlDelSancion = true;
                                    // ------------------------------- //

                                    if($ctrlDelSancion){
                                        if($arrActInvId != null){
                                            // ELIMINAR MEDIDAS CAUTELARES RELACIONADAS //
                                            $strFrom        = "rel_activ_invol_medida";
                                            $ctrlDelMedida  = $conexionBd->hacerDelete($strFrom,$strWhereRel);
                                        }
                                        else $ctrlDelMedida = true;
                                        // ---------------------------------------- //

                                        if($ctrlDelMedida){
                                            
                                            // GUARDA EN UN ARREGLO LOS ID DE TODOS LOS INVOLUCRADOS EN LA INFRACCIÓN // 
                                            $actividad  = new Actividad();
                                            $arrInvol   = $actividad->consultarInfraccionInvol($infraccionId);
                                            if(count($arrInvol) > 0) foreach($arrInvol as $i=>$involucrado) $arrInv[$i] = $involucrado['id'];
                                            unset($actividad);
                                            // ----------------------------------------------------------------------- //

                                            // ELIMINAR INVOLUCRADOS RELACIONADOS //
                                            $strFrom        = "rel_activ_invol";
                                            $ctrlDelInvol   = $conexionBd->hacerDelete($strFrom,$strWhere);
                                            // ---------------------------------- //

                                            if($ctrlDelInvol){
                                                // ELIMINA DE LA TABLA INVOLUCRADO LAS PERSONAS QUE NO POSEAN MÁS INFRACCIONES REGISTRADAS EN EL SISTEMA //
                                                // TAMBIÉN ELIMINA DE LA CARPETA DE INFRACTORES LAS IMÁGENES ASOCIADAS A CADA INVOLUCRADO SI EL MISMO NO SE ENCUENTRA REGISTRADO EN OTRA INFRACCIÓN //
                                                eliminarInvolucrado($arrInv);   
                                                // ------------------------------------------------------------------------------------------------------- //
                                                
                                                $reporte = new Reporte($conexionBd);
                                                $arrReporteInf = $reporte->consultarReporte(null,$infraccionId);
                                                unset($reporte);

                                                if(count($arrReporteInf) > 0){
                                                    $idRep = $arrReporteInf[0]['rep_id'];

                                                    foreach($arrReporteInf as $i=>$reporte) $arrRelRep[] = $reporte['rel_id'];

                                                    $stringRelRep = implode(',',$arrRelRep);

                                                    // ELIMINAR RELACION DE REPORTES CON INFRACCIÓN //
                                                    $strFrom        = "rel_reporte_involucrado";
                                                    $strWhereRelRep = "rel_rep_inv_id IN (".$stringRelRep.")";
                                                    $ctrlDelRelRep  = $conexionBd->hacerDelete($strFrom,$strWhereRelRep);
                                                    // -------------------------------------------- //
                                                }
                                                else{
                                                    $ctrlDelRelRep  = true;
                                                    $ctrlDelRep     = true;
                                                }

                                                if($ctrlDelRelRep){

                                                    if(!$ctrlDelRep){
                                                        // ELIMINAR REPORTE //
                                                        $strFrom        = "reporte";
                                                        $strWhereRep    = "rep_id = ".$idRep;
                                                        $ctrlDelRep     = $conexionBd->hacerDelete($strFrom,$strWhereRep);
                                                        // ---------------- //
                                                    }

                                                    if($ctrlDelRep){
                                                        // ELIMINAR ACTIVIDAD //
                                                        $strFrom        = "actividad";
                                                        $ctrlDelInf     = $conexionBd->hacerDelete($strFrom,$strWhere);
                                                        // ------------------ //

                                                        if($ctrlDelInf){
                                                            $conexionBd->hacerConsulta("COMMIT");
                                                            $objResponse->addScriptCall(recargarIframeInfraccion,'inf');
                                                        }
                                                        else{
                                                            $objResponse->addAlert(utf8_decode('ERROR10H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR LA ACTIVIDAD
                                                            $conexionBd->hacerConsulta("ROLLBACK");
                                                            return $objResponse;
                                                        }
                                                    }
                                                    else{
                                                        $objResponse->addAlert(utf8_decode('ERROR9H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR EL REPORTE 
                                                        $conexionBd->hacerConsulta("ROLLBACK");
                                                        return $objResponse;                                             
                                                    }
                                                }
                                                else{
                                                    $objResponse->addAlert(utf8_decode('ERROR8H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR RELACIÓN DE REPORTES CON ACTIVIDADES
                                                    $conexionBd->hacerConsulta("ROLLBACK");
                                                    return $objResponse;
                                                }
                                            }
                                            else{
                                                $objResponse->addAlert(utf8_decode('ERROR7H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR INVOLUCRADOS DE LA ACTIVIDAD
                                                $conexionBd->hacerConsulta("ROLLBACK");
                                                return $objResponse;
                                            }
                                        }
                                        else{
                                            $objResponse->addAlert(utf8_decode('ERROR6H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR MEDIDAS CAUTELARES ASOCIADAS A LA ACTIVIDAD
                                            $conexionBd->hacerConsulta("ROLLBACK");
                                            return $objResponse; 
                                        }
                                    }
                                    else{
                                        $objResponse->addAlert(utf8_decode('ERROR5H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR SANCIONES ASOCIADAS A LA ACTIVIDAD
                                        $conexionBd->hacerConsulta("ROLLBACK");
                                        return $objResponse; 
                                    }
                                }
                                else{
                                    $objResponse->addAlert(utf8_decode('ERROR4H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR INVOLUCRADOS EN LA ACTIVIDAD
                                    $conexionBd->hacerConsulta("ROLLBACK");
                                    return $objResponse;
                                }
                            }
                            else{
                                $objResponse->addAlert(utf8_decode('ERROR3H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR FOTOS ADICIONALES RELACIONADAS A LA ACTIVIDAD
                                $conexionBd->hacerConsulta("ROLLBACK");
                                return $objResponse;
                            }
                        }
                        else{
                            $objResponse->addAlert(utf8_decode('ERROR2H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR DOCUMENTOS RELACIONADOS A LA ACTIVIDAD
                            $conexionBd->hacerConsulta("ROLLBACK");
                            return $objResponse;
                        }
                    }
                    else{
                        $objResponse->addAlert(utf8_decode('ERROR1H: Comuníquese con el administrador del sistema.')); // ERROR AL ELIMINAR MATERIAL COMISADO Y MEDIOS DE COMISIÓN RELACIONADOS A LA ACTIVIDAD
                        $conexionBd->hacerConsulta("ROLLBACK");
                        return $objResponse;
                    }
                }
                else{
                    if($estado == 'PROCESADO'){
                        $objResponse->addAlert(utf8_decode('ERROR9H: No puede eliminar infracciones que ya han sido procesadas.')); // ERROR AL ELIMINAR. LA ACTIVIDAD NO PUEDE ESTAR PROCESADA
                    }
                    else{
                        $objResponse->addAlert(utf8_decode('ERROR10H: No posee los permisos necesarios para realizar esta acción.')); // ERROR AL ELIMINAR. SOLO USUARIOS MASTER PUEDEN ELIMINAR INFRACCIONES
                    }
                }
            }
            return $objResponse;
        }

        function buscarPersonal($persNac,$persCed,$persCarne){
            global $objResponse;

            $ctrlCedula = false;
            $ctrlCarne  = false;
            $ctrlExiste = false;
            
            if($persCed){
                $ctrlCedula = true;

                // FORMATEO DE CÉDULA //
                $cedula     = formatoCedula($persNac, $persCed);
                $string     = str_split($cedula);
                $involNac   = $string[0];

                foreach($string as $i=>$caracter) if($i !=0 ) $persCedula.=$caracter; 
                // ------------------ //
            }
            if($persCarne) $ctrlCarne = true;
           
            $personal = new Personal();

            if($ctrlCedula) $arrPers = $personal->buscarPersonal(null,$cedula);
            else{
                if($ctrlCarne) $arrPers = $personal->buscarPersonal(null,null,$persCarne);
            }

            if(count($arrPers) > 0){
                $ctrlExiste     = true;
                $persId         = $arrPers[0]['id']; 
                $persNombre     = utf8_decode($arrPers[0]['nombre']);
                $persApellido   = utf8_decode($arrPers[0]['apellido']);
                $persTelefono   = $arrPers[0]['telefono'];
                $persDireccion  = utf8_decode($arrPers[0]['direccion']);
                $persCarne      = $arrPers[0]['carne'];
                $persCargo      = $arrPers[0]['cargo'];
                $persUnidad     = $arrPers[0]['gerencia'];
                $persFoto       = gestionFotoInvol('consultar','../sictra/fotos/'.$arrPers[0]['cedula']);
                $persCedula     = substr($arrPers[0]['cedula'], 1);
            }

            if($ctrlExiste){
                // PARA OBTENER EL ID CON EL CUAL SE ENCUENTRA REGISTRADO EN LA TABLA INVOLUCRADO //
                $involucrado = new Involucrado();
                $involucrado->setAtributo('invol_cedula',$arrPers[0]['cedula']);
                $invol = $involucrado->consultar();

                if(count($invol) > 0) $involId = $invol[0]->getAtributo('invol_id');
                else $involId = 0;
                // ------------------------------------------------------------------------------ //

                $objResponse->addAssign('inv_id'            ,'value',$involId);
                $objResponse->addAssign('pers_id'           ,'value',$persId);
                $objResponse->addAssign('inv_cedula'        ,'value',$persCedula);
                $objResponse->addAssign('inv_nombre'        ,'value',$persNombre);
                $objResponse->addAssign('inv_apellido'      ,'value',$persApellido);
                $objResponse->addAssign('inv_cargo'         ,'value',$persCargo);
                $objResponse->addAssign('inv_telefono'      ,'value',$persTelefono);
                $objResponse->addAssign('inv_direccion'     ,'value',$persDireccion);
                $objResponse->addAssign('inv_carne'         ,'value',$persCarne);
                $objResponse->addAssign('inv_foto'          ,'src',$persFoto);

                $objResponse->addScriptCall(habilitarAgregar,1);
            }
            else{
                if($ctrlCedula) $objResponse->addAlert(utf8_decode("La cédula ingresada no se encuentra registrada en el sistema. Por favor verifique."));
                else{
                    if($ctrlCarne) $objResponse->addAlert(utf8_decode("El número de carné ingresado no se encuentra registrada en el sistema. Por favor verifique."));
                }
            }

            return $objResponse;
        }

        function buscarInvolucrado($involNac,$involCed,$involTipo,$involCarne,$accion){
            global $objResponse;
            
            // $objResponse->addAlert($involNac." -- ".$involCed." -- ".$involTipo." -- ".$involCarne);

            switch($involNac){
                case 'V':
                case 'P':
                case 'E':
                    $cedula = formatoCedula($involNac, $involCed);
                break;
                case 'J':
                case 'G':
                case 'C':
                    $cedula = formatoRif($involNac, $involCed);
                break;
            }

            // FORMATEO DE CÉDULA/RIF //
            $string     = str_split($cedula);
            $involNac   = $string[0];
            foreach($string as $i=>$caracter) if($i !=0 ) $involCedula.=$caracter;
            // ------------------ //
            
            $involucrado = new Involucrado();
            $arrInvol = $involucrado->buscarInvolucrado(null,$cedula);           // BÚSQUEDA DE INVOLUCRADO EN TABLA INVOLUCRADO

            if(count($arrInvol) > 0){
                $ctrlExiste = true;

                $involId        = $arrInvol[0]['id'];
                $involNombre    = utf8_decode($arrInvol[0]['nombre']);
                $involApellido  = utf8_decode($arrInvol[0]['apellido']);
                $involTelefono  = $arrInvol[0]['telefono'];
                $involDireccion = utf8_decode($arrInvol[0]['direccion']);
                $involAlias     = utf8_decode($arrInvol[0]['alias']);
                $involBanda     = utf8_decode($arrInvol[0]['banda']);
                $involCarne     = $arrInvol[0]['carne'];
                $involMetro     = $arrInvol[0]['pers_id'] ? $arrInvol[0]['pers_id'] : 0;
                $involCuerpo    = $arrInvol[0]['cuerpo'];
                $involFoto      = $arrInvol[0]['foto'];

                if($involCuerpo){
                    $ctrlFunc = true;
                }
                if($involMetro != 0){
                    $ctrlPers   = true;
                    $personal   = new Personal();
                    $arrPers    = $personal->buscarPersonal($involMetro);
                    $involCargo = $arrPers[0]['cargo'];
                    $involFoto  = gestionFotoInvol('consultar','../sictra/fotos/'.$cedula); 
                }
                else{
                    if($involFoto == 't') $involFoto = gestionFotoInvol('consultar','multimedia/imagen/infractor/'.$cedula);
                    else $involFoto = 'multimedia/imagen/infractor/siluetaHombre.png';
                }
            }
            else{
                $personal = new Personal();
                $arrPers =  $personal->buscarPersonal(null,$cedula);         // BÚSQUEDA DE INVOLUCRADO EN TABLA PERSONAL

                if(count($arrPers) > 0){
                    $ctrlExiste = true;
                    $ctrlPers   = true;

                    $involId        = 0;
                    $involNombre    = utf8_decode($arrPers[0]['nombre']);
                    $involApellido  = utf8_decode($arrPers[0]['apellido']);
                    $involTelefono  = $arrPers[0]['telefono'];
                    $involDireccion = utf8_decode($arrPers[0]['direccion']);
                    $involFoto      = gestionFotoInvol('consultar','../sictra/fotos/'.$cedula); 
                    $involAlias     = null;
                    $involBanda     = null;
                    $involCarne     = $arrPers[0]['carne'];
                    $involMetro     = $arrPers[0]['id'];
                    $involCargo     = $arrPers[0]['cargo'];
                    $involCuerpo    = null;
                    // $objResponse->addAlert('encontrado en personal');
                }
            }

            if($ctrlExiste){

                $ctrlInfraccion = count($involucrado-> buscarInvolucrado($involId, null, null, null, null, null, 'infractor',null,'procesado'));
                
                $objResponse->addAssign('inv_id'            ,'value',$involId);
                $objResponse->addAssign('inv_cedula'        ,'value',$involCedula);
                $objResponse->addAssign('inv_nombre'        ,'value',$involNombre);
                $objResponse->addAssign('inv_apellido'      ,'value',$involApellido);
                $objResponse->addAssign('inv_telefono'      ,'value',$involTelefono); 
                $objResponse->addAssign('inv_direccion'     ,'value',$involDireccion);
                $objResponse->addAssign('inv_alias'         ,'value',$involAlias);
                $objResponse->addAssign('inv_banda'         ,'value',$involBanda);
                $objResponse->addAssign('inv_cargo'         ,'value',$involCargo);
                $objResponse->addAssign('pers_id'           ,'value',$involMetro);
                $objResponse->addAssign('inv_foto'          ,'src',$involFoto);

                if($ctrlFunc){
                    $objResponse->addAssign('inv_placa','value',$involCarne);
                    $objResponse->addScriptCall(selectManual,'selCuerpo',$involCuerpo);
                    
                    if($involTipo == 'funcionario'){
                        if(!$ctrlInfraccion){
                            $objResponse->addScriptCall(camposFunc,1);
                        } 
                    }
                    else{
                        $objResponse->addScriptCall(infFuncionario,1);
                        $objResponse->addScriptCall(camposFunc,2);
                    }
                }
                else $objResponse->addScriptCall(camposFunc,1);
           
                if($ctrlPers){
                    $objResponse->addScriptCall(infMetro,1);
                    $objResponse->addScriptCall(camposMetro,2);
                    $objResponse->addAssign('inv_carne','value',$involCarne);
                }

                if($accion == 'consulta'){
                    $objResponse->addScriptCall(camposGeneral,2);
                    $objResponse->addScriptCall(camposDet,2);
                    $objResponse->addScriptCall(habilitarAgregar,3);
                }
                else{
                    if(!$ctrlInfraccion){
                        $objResponse->addScriptCall(camposGeneral,1);
                        $objResponse->addScriptCall(camposDet,1);
                        if($ctrlPers) $objResponse->addScriptCall(camposGeneral,4);
                    }
                    $objResponse->addScriptCall(habilitarAgregar,1);
                }
                if($involTipo == 'detenido'){
                    $expInfractor = count($involucrado->consultarExpediente($involId,'procesado'));
                    if($expInfractor > 1) $objResponse->addScriptCall(infReincidencia,1);
                }
            }
            else{
                $objResponse->addAlert(utf8_decode('Cédula ó RIF no encontrado. Ingrese los datos del involucrado y presione Agregar.'));
                $objResponse->addScriptCall(limpiarFichaInvol);
                $objResponse->addScriptCall(selectManual,'inv_nac',$involNac);
                $objResponse->addAssign('inv_cedula','value',$involCedula);
                $objResponse->addScriptCall(habilitarAgregar,2);
                $objResponse->addScriptCall(camposGeneral,3);
            }

            return $objResponse;
        }

        function agregarInvolucrado($tipoInvol,$infraccionId,$invId,$persId,$invNac,$invCedula,$invCarne,$invNombre,$invApellido,$invFotoExt,$invCargo,$invCuerpo,$invPlaca,$invAlias,$invBanda,$invTelefono,$invDireccion,$invFoto){
            
            global $objResponse;

            // $objResponse->addAlert($invFotoExt." -- ".$invFoto);
            // return $objResponse;
            
            $ctrlUpload     = false;
            $fechaRegistro  = formatoFechaHoraBd();
            $cedula         = formatoCedula($invNac, $invCedula);
            $conexionBd     = new ConexionBd();
            $conexionBd->hacerConsulta("BEGIN");
            $relacion = new RelActividadInvolucrado($conexionBd);
            
            if($invId == 0){    // SI LA PERSONA A AGREGAR NO SE ENCUENTRA REGISTRADA EN LA TABLA INVOLUCRADO
                $involucrado = new Involucrado($conexionBd);
                
                $involucrado->setAtributo('invol_cedula',   $cedula);
                $involucrado->setAtributo('invol_nombres',  utf8_encode(strtoupper($invNombre)));
                $involucrado->setAtributo('invol_apellidos',utf8_encode(strtoupper($invApellido)));
                $involucrado->setAtributo('invol_alias',    utf8_encode(strtoupper($invAlias)));
                $involucrado->setAtributo('invol_banda',    utf8_encode(strtoupper($invBanda)));
                $involucrado->setAtributo('invol_direccion',utf8_encode(strtoupper($invDireccion)));
                $involucrado->setAtributo('invol_telf',     $invTelefono);
                
                if($persId){    // SI EL INVOLUCRADO ES PERSONAL METRO
                    $involucrado->setAtributo('pers_id',$persId);
                    $involucrado->setAtributo('invol_placa_carnet',$invCarne);
                    $involucrado->setAtributo('invol_foto', true);
                }
                else{
                    if($tipoInvol == 1){ 
                        if($invFoto != null){
                            $ctrlUpload = true;
                            $rutaFoto   = "multimedia/imagen/infractor/".$cedula.".".$invFotoExt;
                            
                            $involucrado->setAtributo('invol_foto', true);
                        }   
                    }         
                }

                if($tipoInvol == 5){    // SI SE ESTÁ AGREGANDO UN FUNCIONARIO
                    $involucrado->setObjeto('Cuerpo',$invCuerpo);
                    $involucrado->setAtributo('invol_placa_carnet',strtoupper($invPlaca));
                }

                $ctrlNvo = $involucrado->registrar();

                if(!$ctrlNvo){
                    $exito = false;
                    $msjError = utf8_decode('ERROR1C: Comuníquese con el administrador del sistema.'); //Error al agregar el involucrado
                }
                else{
                    $invId = $involucrado->getAtributo('invol_id');
                    $relacion->setAtributo('rel_activ_fecha_reg',$fechaRegistro); 
                    $relacion->setObjeto('Involucrado',     $invId);
                    $relacion->setObjeto('TipoInvolucrado', $tipoInvol);
                    $relacion->setObjeto('Actividad',       $infraccionId); 
                    $relacion->setObjeto('Conexion',        $_SESSION['IdConexion']);

                    $ctrlInsRel = $relacion->registrar();

                    if(!$ctrlInsRel){
                        $exito = false;
                        $msjError = utf8_decode('ERROR2C: Comuníquese con el administrador del sistema.'); //Error al guardar relacion
                    }
                    else $exito = true;
                }
            }
            else{               // SI LA PERSONA A AGREGAR SE ENCUENTRA REGISTRADA EN LA TABLA INVOLUCRADO
                $relacion->consultarIdRelacion($infraccionId,$invId) ? $ctrlRel = false : $ctrlRel = true;

                if($ctrlRel) $relacion->setObjeto('Involucrado',$invId);
                
                $involucrado    = new Involucrado($conexionBd,$invId);
                $ctrlInfraccion = count($involucrado-> buscarInvolucrado($invId, null, null, null, null, null, 'infractor',null,'procesado'));

                if(!$ctrlInfraccion){
                    $involucrado->setAtributo('invol_nombres',      utf8_encode(strtoupper($invNombre)));
                    $involucrado->setAtributo('invol_apellidos',    utf8_encode(strtoupper($invApellido)));
                    $involucrado->setAtributo('invol_alias',        utf8_encode(strtoupper($invAlias)));
                    $involucrado->setAtributo('invol_banda',        utf8_encode(strtoupper($invBanda)));
                    $involucrado->setAtributo('invol_direccion',    utf8_encode(strtoupper($invDireccion)));
                    $involucrado->setAtributo('invol_telf',         $invTelefono);
                }
                
                if($persId){            // SI EL INVOLUCRADO ES PERSONAL METRO
                    $involucrado->setAtributo('pers_id',$persId);
                    $involucrado->setAtributo('invol_placa_carnet',$invCarne);
                }
                else{
                    if(!$ctrlInfraccion){
                        if($tipoInvol == 1){ 
                            if($invFoto != 'undefined'){
                                $ctrlUpload = true;
                                $rutaFoto   = "multimedia/imagen/infractor/".$cedula.".".$invFotoExt;
                                $involucrado->setAtributo('invol_foto', true);
                            }   
                        }
                    }
                }

                if($tipoInvol == 5){    // SI SE ESTÁ AGREGANDO UN FUNCIONARIO
                    if(!$ctrlInfraccion){
                        $involucrado->setObjeto('Cuerpo',$invCuerpo);
                        $involucrado->setAtributo('invol_placa_carnet',strtoupper($invPlaca));
                    }
                }
                
                $ctrlMod = $involucrado->modificar();

                if(!$ctrlMod){
                    $exito = false;
                    $msjError = utf8_decode('ERROR3C: Comuníquese con el administrador del sistema.'); //Error al actualizar la información del involucrado
                } 
                else{
                    if($ctrlRel){
                        $relacion->setAtributo('rel_activ_fecha_reg',$fechaRegistro); 
                        $relacion->setObjeto('TipoInvolucrado', $tipoInvol);
                        $relacion->setObjeto('Actividad',       $infraccionId); 
                        $relacion->setObjeto('Conexion',        $_SESSION['IdConexion']);
                        $ctrlInsRel = $relacion->registrar();

                        if(!$ctrlInsRel){
                            $exito = false;
                            $msjError = utf8_decode('ERROR4C: Comuníquese con el administrador del sistema.'); //Error al guardar relacion
                        }
                        else $exito = true;
                    }
                    else $exito = true;
                }
            }
            if($exito){
                $conexionBd->hacerConsulta('COMMIT');
                $objResponse->addScript("$('#btn_invol_atr').click();");
                $objResponse->addScriptCall(recargarIframeInfraccion,$tipoInvol);
                if($ctrlUpload){
                    gestionFotoInvol('remover',null,null,$cedula);
                    gestionFotoInvol('subir',$rutaFoto,$invFoto);
                }
            }
            else{
                $conexionBd->hacerConsulta('ROLLBACK');
                $objResponse->addAlert($msjError);
            }

            return $objResponse;
        }

        function removerInvolucrado($tipoInvol,$infraccionId,$arrInv){
            global $objResponse;
            
            if(count($arrInv) < 2) $arrDel = $arrInv[0];
            else $arrDel = implode(',',$arrInv);

            $conexionBd = new ConexionBd();
            $strFrom    = 'rel_activ_invol';
            $strWhere   = 'invol_id in ('.$arrDel.') AND actividad_id = '.$infraccionId;

            $ctrlDel = $conexionBd->hacerDelete($strFrom,$strWhere);

            if($ctrlDel){
                eliminarInvolucrado($arrInv);

                switch ($tipoInvol){
                    case 'det': // DETENIDO    
                        $objResponse->addScriptCall(recargarIframeInfraccion,1);
                    break;
                    case 'vic': // VICTIMA
                        $objResponse->addScriptCall(recargarIframeInfraccion,3);
                    break;
                    case 'fun': // FUNCIONARIO
                        $objResponse->addScriptCall(recargarIframeInfraccion,5);
                    break;
                    case 'per': // PERSONAL METRO
                        $objResponse->addScriptCall(recargarIframeInfraccion,4);
                    break;
                }
            }
            else $objResponse->addAlert("Error al remover involucrado(s).");

            return $objResponse;
        }
        
        function agregarDocumento($infraccionId,$tipoDoc,$numDoc,$fechaDoc){
            global $objResponse;

            $fechaRegistro = formatoFechaHoraBd();

            $documento = new Documento();
            $documento->setAtributo('documento_num',        strtoupper($numDoc));
            $documento->setAtributo('documento_fecha_doc',  formFechaHoraBd($fechaDoc,'d-m-Y'));
            $documento->setAtributo('documento_fecha_reg',  $fechaRegistro);
            $documento->setObjeto('Actividad',      $infraccionId);
            $documento->setObjeto('TipoDocumento',  $tipoDoc);
            $documento->setObjeto('Conexion',       $_SESSION['IdConexion']);

            $ctrlNvo = $documento->registrar();

            if($ctrlNvo){
                $objResponse->addScript("$('#btn_doc_atr').click();");
                $objResponse->addScriptCall(recargarIframeInfraccion,'doc');
            }
            else{
                $objResponse->addAlert(utf8_decode('ERROR1D: Comuníquese con el administrador del sistema.')); //ERROR AL AGREGAR DOCUMENTO
            }

            return $objResponse;
        }

        function removerDocumento($infraccionId,$arrDoc){
            global $objResponse;

            if(count($arrDoc) < 2) $arrDel = $arrDoc[0];
            else $arrDel = implode(',',$arrDoc);

            $conexionBd = new ConexionBd();
            $strFrom    = 'documento';
            $strWhere   = 'documento_id in ('.$arrDel.') AND actividad_id = '.$infraccionId;

            $ctrlDel = $conexionBd->hacerDelete($strFrom,$strWhere);

            if($ctrlDel) $objResponse->addScriptCall(recargarIframeInfraccion,'doc');
            else $objResponse->addAlert("Error al eliminar");

            return $objResponse;
        }

        function agregarMaterial($infraccionId,$idMat,$cantMat,$uniMat,$precMat,$descMat,$tipoMaterial){
            global $objResponse;

            $fechaRegistro = formatoFechaHoraBd();

            $material = new MaterialComisado();
            $material->setAtributo('material_comisado_desc',utf8_encode(strtoupper($descMat)));
            $material->setAtributo('material_comisado_cant',$cantMat);
            $material->setAtributo('mat_com_fecha_reg',     $fechaRegistro);
            $material->setAtributo('mat_com_precinto',      strtoupper($precMat));
            $material->setObjeto('Actividad',   $infraccionId);
            $material->setObjeto('TipoMaterial',$idMat);
            $material->setObjeto('Conexion',    $_SESSION['IdConexion']);

            if($tipoMaterial == 'material') $material->setAtributo('material_comisado_unid',$uniMat);

            $ctrlNvo = $material->registrar();

            if($ctrlNvo){
                if($tipoMaterial == 'material'){
                    $objResponse->addScript("$('#btn_mat_atr').click();");
                    $objResponse->addScriptCall(recargarIframeInfraccion,'mat');
                }
                else{
                    $objResponse->addScript("$('#btn_med_atr').click();");
                    $objResponse->addScriptCall(recargarIframeInfraccion,'med');
                }
            }
            else{
                $objResponse->addAlert(utf8_decode('ERROR1E: Comuníquese con el administrador del sistema.')); //ERROR AL AGREGAR MATERIAL COMISADO
            }
            return $objResponse;
        }

        function removerMaterial($tipoMaterial,$infraccionId,$arrMat){
            global $objResponse;

            if(count($arrMat) < 2) $arrDel = $arrMat[0];
            else $arrDel = implode(',',$arrMat);

            $conexionBd = new ConexionBd();
            $strFrom    = 'material_comisado';
            $strWhere   = 'material_comisado_id in ('.$arrDel.') AND actividad_id = '.$infraccionId;

            $ctrlDel = $conexionBd->hacerDelete($strFrom,$strWhere);

            if($ctrlDel){
                $objResponse->addScriptCall(recargarIframeInfraccion,$tipoMaterial);
            }
            else $objResponse->addAlert("Error al eliminar");

            return $objResponse;
        }

        function buscarPlaca($placa){
            global $objResponse;

            $vehiculo = new Vehiculo();
            $vehiculo->setAtributo('vehiculo_placa',strtoupper($placa));
            $arrVehiculo = $vehiculo->consultar();

            if(count($arrVehiculo) > 0){
                $idVeh      = $arrVehiculo[0]->getAtributo('vehiculo_id');
                $placaVeh   = $arrVehiculo[0]->getAtributo('vehiculo_placa');
                $modelVeh   = $arrVehiculo[0]->getAtributo('vehiculo_modelo');
                $colorVeh   = $arrVehiculo[0]->getAtributo('vehiculo_color');
                $marcaVeh   = $arrVehiculo[0]->getObjeto('Marca')->getAtributo('marca_desc');
                $tipoVeh    = $arrVehiculo[0]->getObjeto('TipoVehiculo')->getAtributo('tipo_vehiculo_desc');

                $objResponse->addAssign('veh_id',       'value',$idVeh);
                $objResponse->addAssign('veh_placa',    'value',$placaVeh);
                $objResponse->addAssign('veh_modelo',   'value',$modelVeh);
                $objResponse->addAssign('veh_color',    'value',$colorVeh);

                $objResponse->addScriptCall(selectManual,'selTipoVehi',$tipoVeh);
                $objResponse->addScriptCall(selectManual,'selMarca',$marcaVeh);
                $objResponse->addScriptCall(camposVeh,1);
            }
            else {
                $objResponse->addAlert(utf8_decode('Placa no encontrada. Ingrese los datos del nuevo vehículo y presione Agregar.'));
                $objResponse->addScriptCall(camposVeh,2);
                $objResponse->addScriptCall(camposVeh,4);
                $objResponse->addAssign('veh_placa','value',strtoupper($placa));
            }

            return $objResponse;
        }

        function agregarVehiculo($infraccionId,$idVeh,$placaVeh,$modelVeh,$colorVeh,$descVeh,$tipoVeh,$marcaVeh){
            global $objResponse;

            $fechaRegistro = formatoFechaHoraBd();

            if($idVeh){
                $ctrlMaterial = true;
            }
            else{
                $vehiculo = new Vehiculo();
                $vehiculo->setAtributo('vehiculo_placa',    strtoupper($placaVeh));
                $vehiculo->setAtributo('vehiculo_modelo',   strtoupper($modelVeh));
                $vehiculo->setAtributo('vehiculo_color',    strtoupper($colorVeh));
                $vehiculo->setAtributo('vehiculo_fecha_reg',$fechaRegistro);
                $vehiculo->setObjeto('Marca',       $marcaVeh);
                $vehiculo->setObjeto('TipoVehiculo',$tipoVeh);
                $vehiculo->setObjeto('Conexion',    $_SESSION['IdConexion']);

                $ctrlNvoVeh = $vehiculo->registrar();

                if($ctrlNvoVeh){
                    $idVeh = $vehiculo->getAtributo('vehiculo_id');
                    $ctrlMaterial = true;
                }
                else $objResponse->addAlert(utf8_decode('ERROR1F: Comuníquese con el administrador del sistema.')); //ERROR AL AGREGAR VEHÍCULO
            }

            if($ctrlMaterial){
                $matComis = new MaterialComisado();
                $matComis->setAtributo('material_comisado_cant',    '1');
                $matComis->setAtributo('material_comisado_desc',    utf8_encode(strtoupper($descVeh)));
                $matComis->setAtributo('mat_com_fecha_reg',         $fechaRegistro);
                $matComis->setObjeto('TipoMaterial','4');
                $matComis->setObjeto('Actividad',   $infraccionId);
                $matComis->setObjeto('Vehiculo',    $idVeh);
                $matComis->setObjeto('Conexion',    $_SESSION['IdConexion']);

                $ctrlNvoMatCom = $matComis->registrar();

                if($ctrlNvoMatCom){
                    $objResponse->addScript("$('#btn_veh_atr').click();");
                    $objResponse->addScriptCall(recargarIframeInfraccion,'veh');
                }
                else{
                    $objResponse->addAlert('Error al insertar en material comisado.');
                }
            }
            return $objResponse;
        }

        function removerVehiculo($infraccionId,$arrVeh){
            global $objResponse;

            if(count($arrVeh) < 2) $arrDel = $arrVeh[0];
            else $arrDel = implode(',',$arrVeh);

            $conexionBd = new ConexionBd();
            $strFrom    = 'material_comisado';
            $strWhere   = 'material_comisado_id in ('.$arrDel.') AND actividad_id = '.$infraccionId;

            $ctrlDel = $conexionBd->hacerDelete($strFrom,$strWhere);

            if($ctrlDel) {
                if($tipoMaterial == 'mat') $objResponse->addScriptCall(recargarIframeInfraccion,'mat');
                else $objResponse->addScriptCall(recargarIframeInfraccion,'med');
            }
            else $objResponse->addAlert("Error al eliminar");

            return $objResponse;
        }

        function buscarSancion($idInfractor, $idInfraccion){
            global $objResponse;

            $sancion = new Sancion();
            $arrSancion = $sancion->consultarSancion($idInfractor, $idInfraccion);

            if(count($arrSancion) > 0){
                $tipoSujeto = $arrMedida[0]['personal'] ? 'trabajador' : 'usuario';
                $objResponse->addAssign('rel_san_med_id',   'value',$arrSancion[0]['id']);
                $objResponse->addAssign('sanc_fecha',       'value',formFecha($arrSancion[0]['fecha']));
                $objResponse->addAssign('sanc_observ',      'value',utf8_decode($arrSancion[0]['observacion']));
                $objResponse->addScriptCall(selectManual,'selSancion',$arrSancion[0]['desc_sancion']);
                $objResponse->addScriptCall(gestionFichaSancionMedida,'sancion',0,$tipoSujeto);
                $objResponse->addScriptCall(cargarArrSanMed,0);
            }
            else{
                $involucrado = new Involucrado(null,$idInfractor);
                $tipoSujeto = $involucrado->getAtributo('pers_id') ? 'trabajador' : 'usuario'; 
                $objResponse->addScriptCall(gestionFichaSancionMedida,'sancion',0,$tipoSujeto);
            }

            $objResponse->addAssign('san_med_infractor_id','value',$idInfractor);

            return $objResponse;
        }

        function buscarMedida($idInfractor, $idInfraccion){
            global $objResponse;

            $medida = new MedidaCautelar();
            $arrMedida = $medida->consultarMedida($idInfractor, $idInfraccion);

            if(count($arrMedida) > 0){
                $objResponse->addAssign('rel_san_med_id',   'value',$arrMedida[0]['id']);
                $objResponse->addAssign('sanc_fecha',       'value',formFecha($arrMedida[0]['fecha']));
                $objResponse->addAssign('sanc_observ',      'value',utf8_decode($arrMedida[0]['observacion']));
                $objResponse->addScriptCall(selectManual,'selMedida',$arrMedida[0]['desc_medida']);
                $objResponse->addScriptCall(gestionFichaSancionMedida,'medida',0);
                $objResponse->addScriptCall(cargarArrSanMed,0);
            }
            else{
                $objResponse->addScriptCall(gestionFichaSancionMedida,'medida',0);
            }

            $objResponse->addAssign('san_med_infractor_id','value',$idInfractor);

            return $objResponse;
        }

        function aplicarSancionMedida($tipo,$arrSancionMedida){
            global $objResponse;

            $id = $arrSancionMedida['rel_san_med_id'] == 0 ? null : $arrSancionMedida['rel_san_med_id'];

            if($tipo == 'sancion'){
                $sancionMedida = new RelActividadInvolucradoSancion(null,$id);
                $sancionMedida->setAtributo('fecha_sancion',    formFechaHoraBd($arrSancionMedida['sanc_fecha'],'d-m-Y'));
                $sancionMedida->setObjeto('Sancion',            $arrSancionMedida['selSancion']);
            }
            else{
                $sancionMedida = new RelActividadInvolucradoMedida(null,$id);
                $sancionMedida->setAtributo('fecha_medida', $arrSancionMedida['sanc_fecha']);
                $sancionMedida->setObjeto('MedidaCautelar', $arrSancionMedida['selMedida']); 
            }

            $sancionMedida->setAtributo('observacion', utf8_encode(strtoupper($arrSancionMedida['sanc_observ'])));
            $sancionMedida->setObjeto('Conexion', $_SESSION['IdConexion']); 

            if($id){
                $ctrlApl = $sancionMedida->modificar();
                $msjError = utf8_decode('ERROR2G: Comuníquese con el administrador del sistema.'); //ERROR AL MODIFICAR SANCIÓN/MEDIDA
            }
            else{
                $relacion = new RelActividadInvolucrado();
                $relActivInvolId = $relacion->consultarIdRelacion($arrSancionMedida['infraccion_id'],$arrSancionMedida['infractor_id']);
                
                $sancionMedida->setObjeto('RelActividadInvolucrado',$relActivInvolId);
                $ctrlApl = $sancionMedida->registrar();
                $msjError = utf8_decode('ERROR1G: Comuníquese con el administrador del sistema.'); //ERROR AL REGISTRAR SANCIÓN/MEDIDA
            }

            if($ctrlApl){
                $objResponse->addScriptCall(recargarIframeInfraccion,'1');
                $objResponse->addScript("$('#btn_san_atr').click();");
            }
            else{
                $objResponse->addAlert($msjError);
            }

            return $objResponse;
        }

        function cargarEvidencia($infraccionId,$estado){
            global $objResponse;

            $fotoAdicional  = new FotoAdicional();
            $arrEvidencia   = $fotoAdicional->obtenerEvidencia($infraccionId);
            $cantidadEvid   = count($arrEvidencia);

            if($cantidadEvid > 0){
                foreach($arrEvidencia as $i=>$evidencia){
                    $infracEvid[$i]['name'] = $evidencia->getAtributo('foto_desc');
                    $segmento = explode('.', $infracEvid[$i]['name']);
                    $infracEvid[$i]['type'] = $segmento[1];
                    $infracEvid[$i]['file'] = 'multimedia/imagen/evidencia/'.$evidencia->getAtributo('foto_desc');

                    switch ($infracEvid[$i][type]){
                        case 'jpg':
                        case 'jpeg':
                        case 'jpe':
                            $infracEvid[$i][type] = 'image/jpeg';
                        break;
                        case 'png':
                            $infracEvid[$i][type] = 'image/png';
                        break;
                    }
                }
            }
            $infracEvid = json_encode($infracEvid);
            $objResponse->addScriptCall(cargarEvidenciaInfraccion,$infracEvid,$estado,$cantidadEvid);

            return $objResponse;
        }
        
        function removerEvidencia($fotoDesc,$infracId){
            global $objResponse;

            $conexionBd = new ConexionBd();
            $ctrlDel = $conexionBd->hacerDelete('foto_adicional',"foto_desc = '".$fotoDesc."' AND actividad_id = ".$infracId);

            if($ctrlDel) unlink('multimedia/imagen/evidencia/'.$fotoDesc);
            else $objResponse->addAlert("Error removiendo evidencia.");

            return $objResponse;
        }

        function generarReporteInfraccion($infId){
            global $objResponse;

            $hash  = hashReporte($infId);
            $fecha = formatoFechaHoraBd();

            $reporte = new Reporte();
            $reporte->setAtributo('rep_codigo',$hash);
            $reporte->setAtributo('rep_fecha',$fecha);
            $reporte->setObjeto('Actividad',$infId);
            $reporte->setObjeto('Conexion',$_SESSION['IdConexion']);
            $ctrlRep = $reporte->registrar();

            if($ctrlRep){
                $repId = $reporte->getAtributo('rep_id');
                $infraccion = new Actividad();;
                $arrInvol = $infraccion->consultarInfraccionInvol($infId);

                foreach($arrInvol as $i=>$involucrado){
                    $relacion = new RelReporteInvolucrado();
                    $relacion->setObjeto('Reporte',$repId);
                    $relacion->setAtributo('invol_cedula',$involucrado['cedula']);
                    $relacion->setObjeto('TipoInvolucrado',$involucrado['tipo']);
                    $relacion->registrar();
                    unset($relacion);
                }
            }

            return $objResponse;
        }
    // --------------------------------------------------------------------------------- //
?>