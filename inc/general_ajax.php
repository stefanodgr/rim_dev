<?php
    // -------------------------- REGISTRO DE FUNCIONES XAJAX -------------------------- //
        $xajax->registerFunction('cargarEstacion'); 
        $xajax->registerFunction('auditoria');
        $xajax->registerFunction('cargarConexion');
    // --------------------------------------------------------------------------------- //

    // -------------------------------- FUNCIONES XAJAX -------------------------------- //
        function cargarEstacion($opc, $idLinea, $accion){
            global $objResponse;
            
            $estacion = new Estacion();
            $estacion->setObjeto("Linea",$idLinea);
            $arrEstacion = $estacion->consultar();
            unset($estacion);

            if(count($arrEstacion) > 0){
                $size=0;
                foreach($arrEstacion as $i=>$estacion){
                    $idEstacion     = $estacion->getAtributo('estacion_id');
                    $nombreEstacion = utf8_decode($estacion->getAtributo('estacion_nombre'));
                    $opciones.="<option value='".$idEstacion."'>".$nombreEstacion."</option>";
                    $cantidad = strlen($nombreEstacion);
                    if($cantidad > $size) $size = $cantidad;
                }
                switch($opc){
                    case 1:
                        $html="<select id='sel_estacion' style='size:".$size."'><option value='0'>TODAS</option>";
                    break;
                    case 2:
                        $html="<select id='filt_ubicacion2' style='size:".$size."' disabled><option value='0'>SELECCIONAR</option>";
                    break;
                    case 3:
                        $html="<select id='filt_ubicacion2' style='size:".$size."'><option value='0'>SELECCIONAR</option>";
                    break;
                }

                $html.=$opciones;
                $html.="</select>";

                if($opc == 1) $objResponse->addAssign('col_sel_est','innerHTML',$html);
                else{
                    $objResponse->addAssign('col_filt_ubicacion2','innerHTML',$html);
                    $objResponse->addScript("$('#fila_aux_ubi').removeClass('oculto')");
                }
                
            }
            return $objResponse;
        }

        function auditoria($tipo,$arrDatos){
            global $objResponse;

            $miAuditoria = new Auditoria();

            $fechaRegistro = formatoFechaHoraBd();
            				
            //INICIO DE SESION
            $miAuditoria = new Auditoria();

            switch($tipo){
                case 'registrar':
                    $tipoAuditoria = 1;
                    $observacion="INICIO LA SESION CON PERFIL: $PerfilUsuario";	
                break;
                case 'modificar':
                    $tipoAuditoria = 2;
                    $observacion="INICIO LA SESION CON PERFIL: $PerfilUsuario";	
                break;
                case 'eliminar':
                    $tipoAuditoria = 3;
                    $observacion="INICIO LA SESION CON PERFIL: $PerfilUsuario";	
                break;
                case 'status':
                    $tipoAuditoria = 4;
                    $observacion="INICIO LA SESION CON PERFIL: $PerfilUsuario";	
                break;
                case 'consulta':
                    $tipoAuditoria = 5;
                    $observacion="INICIO LA SESION CON PERFIL: $PerfilUsuario";	
                break;
                case 'iniciar':
                    $tipoAuditoria = 6;
                    $observacion="INICIO LA SESION CON PERFIL: $PerfilUsuario";	
                break;
                case 'cerrar':
                    $tipoAuditoria = 7;
                    $observacion="INICIO LA SESION CON PERFIL: $PerfilUsuario";	
                break;
                case 'reporte':
                    $tipoAuditoria = 8;
                    $observacion="INICIO LA SESION CON PERFIL: $PerfilUsuario";	
                break;
            }

            $miAuditoria->setAtributo("auditoria_fecha",    $fechaRegistro);
            $miAuditoria->setAtributo("auditoria_observ",   $observacion);
            $miAuditoria->setObjeto("Conexion",     $_SESSION['IdConexion']);
            $miAuditoria->setObjeto("TipoAuditoria",$tipoAuditoria);
            $exitoRegistrarAuditoria = $miAuditoria->registrar();

            return $objResponse;
        }

        function cargarConexion(){
            global $objResponse;
            
            $cantidadConex = $_SESSION['cantConexion'];
            $objResponse->addAssign('inp_inf_conex_val','value',$cantidadConex);

            return $objResponse;
        }
    // --------------------------------------------------------------------------------- //
?>