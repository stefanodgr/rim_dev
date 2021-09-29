<?php
    // -------------------------- REGISTRO DE FUNCIONES XAJAX -------------------------- //
        $xajax->registerFunction('validarLogin');
        $xajax->registerFunction('cambiarClave');
        $xajax->registerFunction('cerrarSesion');
        $xajax->registerFunction('validarSesion');
    // --------------------------------------------------------------------------------- //

    // -------------------------------- FUNCIONES XAJAX -------------------------------- //
        function validarLogin($login, $clave){  // VALIDA LA INFORMACIÓN INGRESADA PARA PROCEDER AL INICIO DE SESIÓN EN EL SISTEMA 
            global $objResponse; 

            $miUsuario  = new Usuario();
            $login      = strMayus(limpiarPalabra($login));
            $miUsuario  ->setAtributo("usuario_login", $login);
            
            $claveHash      = strtoupper(sha1(sha1(limpiarPalabra($login.$clave))));
            $arrUsuario     = $miUsuario->consultar();
            $cantUsuario    = count($arrUsuario);

            if ($cantUsuario == 1) $claveBD = $arrUsuario[0]->getAtributo("usuario_clave");
            else $claveBD = "";

            $resultado      = false;
            $claveValida    = false;
            $claveInicial   = false;

            if((strtoupper($claveBD) == "METRO") && (strtoupper($clave) == "METRO")) $claveInicial = true; //verificamos si la clave inicial es METRO lo cual indica si debemos cambiar la clave
            
            if($claveHash == $claveBD) $claveValida = true; // VALIDA HASH USUARIO CON HASH BD
            
            if ($cantUsuario == 1 && !$claveInicial && $claveValida) {
            
                // session_destroy();
                // session_start();

                $idUsuario  = $arrUsuario[0]->getAtributo("usuario_id");
                $persNombre = $arrUsuario[0]->getAtributo('usuario_nombre')." ($login)";
                $usuCarne   = $arrUsuario[0]->getAtributo('usuario_carnet');

                $miPerfilUsuario   = new PerfilUsuario();
                $miPerfilUsuario->setObjeto("Usuario",$idUsuario);
                $arregloPerfilUsuario = $miPerfilUsuario->consultar();
                $cantPerfilUsuario = count($arregloPerfilUsuario);

                if($cantPerfilUsuario > 0){
                    $activo             = $arregloPerfilUsuario[0]->getAtributo("rel_perfil_activo");
                    $fechaIni           = $arregloPerfilUsuario[0]->getAtributo("rel_perfil_fecha_ini");
                    $fechaFin           = $arregloPerfilUsuario[0]->getAtributo("rel_perfil_fecha_fin");
                    $PerfilUsuario      = $arregloPerfilUsuario[0]->getObjeto("Perfil")->getAtributo("perfil_desc");
                    $IdPerfilUsuario    = $arregloPerfilUsuario[0]->getObjeto("Perfil")->getAtributo("perfil_id");
                    $idRelPerfilUsuario = $arregloPerfilUsuario[0]->getAtributo("rel_perfil_id");
                }

                $fecha = date("Y-m-d");
                
                if (($fechaFin != '') && ($fechaFin <= $fecha)){    //si la fecha de uso del sistema a expirado no deja ingresar al usuario
                    $objResponse->addAlert("Usuario ".$login." no tiene acceso al sistema.");
                }
                else{
                    $direccionIp    = obtenerIP();
                    $miConexion     = new Conexion();

                    // $arrConexionIp  = $miConexion->consultarConexion($direccionIp);

                    // if(count($arrConexionIp) > 0){
                    //     foreach($arrConexionIp as $i=>$unaConexion){
                    //         $idConexOld = $unaConexion['id'];
                    //         cerrarSesion($idConexOld);
                    //     }
                    // }

                    $arrConexionPerfil = $miConexion->consultarConexion(null,$idRelPerfilUsuario);

                    if(count($arrConexionPerfil) > 0){
                        foreach($arrConexionPerfil as $i=>$unaConexion){
                            $idConexOld = $unaConexion['id'];
                            cerrarSesion($idConexOld);
                        }
                    }

                    $miConexion->setAtributo("conex_ent",   formatoFechaHoraBd());
			        $miConexion->setAtributo("conex_ip",    $direccionIp);
                    $miConexion->setObjeto("PerfilUsuario", $idRelPerfilUsuario);
                    $ctrlConexion = $miConexion->registrar();

                    if($ctrlConexion){
                        // -- SE GUARDA UN REGISTRO DE AUDITORIA DE LOS CAMBIOS REALIZADOS -- //
                        /*$fechaRegistro  = formatoFechaHoraBd();
                        $conexionId     = $_SESSION['IdConexion'];
                        $observacion    = "INICIO LA SESION CON PERFIL: $PerfilUsuario";					
                        $tipoAuditoria  = 6; //INICIO DE SESION

                        $miAuditoria = new Auditoria();
                        $miAuditoria->setAtributo("auditoria_fecha", $fechaRegistro);
                        $miAuditoria->setAtributo("auditoria_observ", $observacion);
                        $miAuditoria->setObjeto("Conexion",$conexionId);
                        $miAuditoria->setObjeto("TipoAuditoria",$tipoAuditoria);
                        $exitoRegistrarAuditoria = $miAuditoria->registrar();*/
                        // ------------------------------------------------------------------ //

                        $_SESSION['Login']              = $login;  
                        $_SESSION['UsuarioNombre']      = $persNombre;
                        $_SESSION['UsuarioCarne']       = $usuCarne;
                        $_SESSION['PerfilUsuario']      = $PerfilUsuario;
                        $_SESSION['IdUsuario']          = $idUsuario;
                        $_SESSION['IdPerfilUsuario']    = $IdPerfilUsuario;
                        $_SESSION['IdRelPerfilUsuario'] = $idRelPerfilUsuario;		
                        $_SESSION['IdConexion']         = $miConexion->getAtributo("conex_id");
                        $_SESSION['exp']                = time() + EXP;    
                        $_SESSION['direccionIp']        = $direccionIp;

                        $snLogin        = $login;
                        $snPersNomb     = $persNombre;
                        $snPerfUsu      = $PerfilUsuario;
                        $snIdUsu        = $idUsuario;
                        $snIdPerfUsu    = $IdPerfilUsuario;
                        $snIdRelPerfUsu = $idRelPerfilUsuario;
                        $snNivel        = $nivelUsuario;
                        $snConex        = $conexionId;
                        $snExpire       = $_SESSION['exp'];
                        $snMaxTime      = EXP;

                        validarSesion($snMaxTime);
                        cantConexiones(); 
                        $objResponse->addScriptCall('mostrarMenu');
                        $objResponse->addScriptCall('sessionJs',$snLogin,$snPersNomb,$snPerfUsu,$snIdUsu,$snIdPerfUsu,$snIdRelPerfUsu,$snNivel,$snConex,$snExpire);
                    }
                    else{
                        $objResponse->addAlert("Usuario ".$login." Ingreso Correcto No Registro Conexion");
                    }
                }	
            }else{
                if($claveInicial) {
                    $_SESSION['ctrlPass'] = true;
                    $objResponse->addScriptCall('cambiarClave');
                }
                else {
                    $objResponse->addScriptCall('msgLogin',utf8_decode('ERROR: Usuario y/o contraseña incorrectos.'));
                    $objResponse->addScriptCall('limpiarCamposLogin');
                }	
            }

            return $objResponse;
        }

        function cambiarClave($login, $clave){  // CAMBIO DE CLAVE
            global $objResponse;

            if($_SESSION['ctrlPass']){
                $miUsuario  = new Usuario();
                $login      = strMayus(limpiarPalabra($login));
                $miUsuario->setAtributo("usuario_login", $login);
                $arrUsuario = $miUsuario->consultar();

                $idUsuario  = $arrUsuario[0]->getAtributo("usuario_id");

                $miUsuario->setAtributo("usuario_id", $idUsuario);
                $miUsuario->setAtributo("usuario_clave", strtoupper(sha1(sha1($login.$clave))));
                $resultado  = $miUsuario->modificar();

                if($resultado){
                    $objResponse->addScriptCall(msgLogin, utf8_decode('Contraseña cambiada con éxito. Ingrese con su nueva contraseña.'));
                    $objResponse->addScriptCall(limpiarCamposLogin);
                    unset($_SESSION['ctrlPass']);
                }
                else $objResponse->addScriptCall(msgLogin,utf8_decode('ERROR: Ocurrió un problema al intentar cambiar la contraseña.'));
            }
            else $objResponse->addAlert(utf8_decode("ADVERTENCIA: Cualquier intento de hackeo o manipulación del sistema será gravemente penalizado. Evite sanciones."));
            
            return $objResponse;
        }

        function cerrarSesion($conexId){        // CIERRA LA SESIÓN ACTUAL
            global $objResponse;

            $fechaRegistro  = formatoFechaHoraBd();
            $ctrlIndex      = false;

            if(!$conexId){
                $ctrlIndex  = true;
                $conexId    = $_SESSION['IdConexion'];

                // SE GUARDA UN REGISTRO DE AUDITORIA DEL CIERRE DE SESION //
                // $tipoAuditoria  = 7;//CIERRE DE SESION
                // $PerfilUsuario  = $_SESSION['PerfilUsuario'];
                // $observacion    = "CERRO LA SESION CON PERFIL: $PerfilUsuario";
                // $miAuditoria    = new Auditoria();
                // $miAuditoria->setAtributo("auditoria_fecha", $fechaRegistro);
                // $miAuditoria->setAtributo("auditoria_observ", $observacion);
                // $miAuditoria->setObjeto("Conexion",$conexId);
                // $miAuditoria->setObjeto("TipoAuditoria",$tipoAuditoria);
                // $exitoRegistrarAuditoria = $miAuditoria->registrar();	
                // ------------------------------------------------------- //
            }

            $conexion = new Conexion();
            $ctrlConexion = $conexion->cerrarConexion(null, $conexId);

            if($ctrlConexion){
                if($ctrlIndex){
                    session_unset();
                    session_destroy();
                    $objResponse->addScriptCall(reiniciarIndex);
                }
            }
            else $objResponse->addScript('console.log("Error al intentar cerrar las conexiones previas");');            

            return $objResponse;
        }

        function validarSesion($snMaxTime){               // VERIFICA SI HA TRANSCURRIDO EL TIEMPO DE INACTIVIDAD MÁXIMA PARA PROCEDER A CERRAR LA SESIÓN DE FORMA AUTOMÁTICA
            global $objResponse;
            
            if($snMaxTime) $tiempoRestante = $snMaxTime;
            else $tiempoRestante = $_SESSION['exp'] - time();

            if($tiempoRestante <= 0) cerrarSesion();
            else $objResponse->addScriptCall('validarSesion',($tiempoRestante * 1000));

            return $objResponse;
        }
    // --------------------------------------------------------------------------------- //
?>