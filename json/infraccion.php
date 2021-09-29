<?php
    $rutaDir = '../';
    include_once $rutaDir.'config.php';

    isset($_GET['case'])            ? $case         = $_GET['case']         : $case = null;
    isset($_GET['idInfraccion']) 	? $idInfraccion = $_GET['idInfraccion'] : $idInfraccion = null;

    switch($case){
        case 0:
            isset($_GET['tipo'])    ? $tipo     = $_GET['tipo']     : $tipo     = null;
            isset($_GET['filtros']) ? $filtros  = $_GET['filtros']  : $filtros  = null;

            $actividad  = new Actividad();
            $arrInf     = $actividad->listaInfraccion($tipo,$filtros);
			
			if(count($arrInf)>0){
				foreach ($arrInf as $i=>$infrac){
                    $contenido['id'] 	= $infrac["id"];
                    $contenido[0]		= ++$i;
                    $contenido[1]		= $infrac["rim"] ? $infrac["rim"] : 'SIN NÚMERO';
                    $contenido[2]		= $infrac["ubicacion"];
                    $contenido[3]		= $infrac["actividad"];
                    $contenido[4]		= formFechaHora($infrac["fecha"]);
                    $contenido[5]		= $infrac["estado"];
                    $contenido[6]		= $infrac["usuario"];
                    $contenido[7]		= formFechaHora($infrac["registro"]);
                    $data[]             = $contenido;
				}
			}
			else $data = 0;
        break;
        case 1:
			isset($_GET['tipoInvol']) ? $tipoInvol = $_GET['tipoInvol'] : $tipoInvol = null;

            $infraccion = new Actividad();
            $arreglo    = $infraccion->consultarInfraccionInvol($idInfraccion,$tipoInvol);

            $divIni = '<div class="clickeable" onclick="determinarAccion(\'abrir\',this.parentNode);" onmouseover="$(this).parent().parent().addClass(\'onCeldaPlus\');" onmouseout="$(this).parent().parent().removeClass(\'onCeldaPlus\');">';
            $divFin = '</div>';

            if(count($arreglo)>0){
				foreach ($arreglo as $i=>$dato){
                    $contenido['id']    = $dato["id"];
                    $contenido[0]	    = ++$i;

                    switch ($tipoInvol){
                        case 'DETENIDO':
                            $contenido[1]		= $divIni.$dato["cedula"].$divFin;
                            $contenido[2]		= $dato["nombre"];
                            $contenido[3]		= $dato["apellido"];
                            $contenido[4]		= $dato["alias"];
                            $contenido[5]		= $dato["banda"];
                            $contenido[6]		= $dato["metro"]    ? 'TRABAJADOR'      : 'USUARIO';
                            $contenido[7]		= $dato["sancion"]  ? $divIni.$dato["sancion"].$divFin  : $divIni.'SIN ESPECIFICAR'.$divFin;
                            $contenido[8]		= $dato["medida"]   ? $divIni.$dato["medida"].$divFin   : $divIni.'SIN ESPECIFICAR'.$divFin;
                            // $contenido[7]		= $dato["usuario"];
                        break;
                        case 'VICTIMA':
                            $contenido[1]		= $dato["cedula"];
                            $contenido[2]		= $dato["nombre"];
                            $contenido[3]		= $dato["apellido"];
                            // $contenido[4]		= $dato["usuario"];
                        break;
                        case 'FUNCIONARIO':
                            $contenido[1]		= $dato["cedula"];
                            $contenido[2]		= $dato["nombre"];
                            $contenido[3]		= $dato["apellido"];
                            $contenido[4]		= $dato["cuerpo"];
                            // $contenido[5]		= $dato["usuario"];
                        break;
                        case 'PERSONAL METRO':
                            $contenido[1]		= $dato["cedula"];
                            $contenido[2]		= $dato["nombre"];
                            $contenido[3]		= $dato["apellido"];
                            $contenido[4]		= utf8_decode($dato["cargo"]);
                            // $contenido[5]		= $dato["usuario"];
                        break;
                    }
                    $data[] = $contenido;
				}
			}
			else $data = 0;
        break;
        case 2:
            $infraccion = new Actividad();
            $arreglo    = $infraccion->consultarInfraccionDoc($idInfraccion);

            if(count($arreglo)>0){
				foreach ($arreglo as $i=>$dato){
                    $contenido['id'] 	= $dato["id"];
                    $contenido[0]		= ++$i;
                    $contenido[1]		= $dato["tipo"];
                    $contenido[2]		= $dato["numero"];
                    $contenido[3]		= formFecha($dato["fecha"],'Y-m-d');
                    // $contenido[4]		= $dato["usuario"];
                    $data[]             = $contenido;
				}
			}
			else $data = 0;
        break;
        case 3:
            isset($_GET['tipoMaterial']) ? $tipoMaterial = $_GET['tipoMaterial'] : $tipoMaterial = null;
            
            $infraccion = new Actividad();
            $arreglo    = $infraccion->consultarInfraccionMat($idInfraccion,$tipoMaterial);

            if(count($arreglo)>0){
				foreach ($arreglo as $i=>$dato){
                    $contenido['id'] 	= $dato["id"];
                    $contenido[0]		= ++$i;
                    $contenido[1]		= $dato["precinto"];
                    $contenido[2]		= $dato["tipo"];
                    $contenido[3]		= $dato["cantidad"];

                    if($tipoMaterial == 'material'){
                        $contenido[4]		= $dato["unidad"];
                        $contenido[5]		= $dato["descripcion"];
                    }
                    else $contenido[4]		= $dato["descripcion"];
                    
                    // $contenido[6]		= $dato["unidad"];
                    $data[]             = $contenido;
				}
			}
			else $data = 0;
        break;
        case 4:
            $infraccion = new Actividad();
            $arreglo    = $infraccion->consultarInfraccionVeh($idInfraccion);

            if(count($arreglo)>0){
				foreach ($arreglo as $i=>$dato){
                    $contenido['id'] 	= $dato["id"];
                    $contenido[0]		= ++$i;
                    $contenido[1]		= $dato["tipo"];
                    $contenido[2]		= $dato["placa"];
                    $contenido[3]		= $dato["marca"];
                    $contenido[4]		= $dato["modelo"];
                    $contenido[5]		= $dato["color"];
                    $contenido[6]		= $dato["observacion"];
                    // $contenido[3]		= $dato["usuario"];

                    $data[]             = $contenido;
				}
			}
			else $data = 0;
        break;
    }
    
	$arrJson[data] = $data;
    // echo("<pre>");
    // print_r($arrJson);
    // echo("</pre>");
    $json = json_encode($arrJson);
    echo($json);
?>