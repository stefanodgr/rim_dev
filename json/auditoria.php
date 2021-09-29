<?php
	$rutaDir = '../';
    include_once $rutaDir.'config.php';

    isset($_GET['case']) ? $case = $_GET['case'] : $case = null;

    switch($case){
        case 0: 
            isset($_GET['tipoAudit']) 	    ? $tipoAudit    = $_GET['tipoAudit']    : $tipoAudit    = null;
            isset($_GET['fechaDesde']) 	    ? $fechaDesde   = $_GET['fechaDesde']   : $fechaDesde 	= null;
            isset($_GET['fechaHasta']) 	    ? $fechaHasta   = $_GET['fechaHasta']   : $fechaHasta 	= null;      
            // $fechaDesde = formatoFechaBd($fechaDesde);
			// $fechaHasta = formatoFechaBd($fechaHasta);
            $conexionBd = new ConexionBd();

			$strSelect  = "A.auditoria_id AS id,
                        B.tipo_auditoria_desc AS tipo,
                        A.auditoria_observ AS observacion,
                        E.usuario_login AS usuario,
                        A.auditoria_fecha AS fecha,
                        C.conex_ip AS ip";
        	$strFrom    = "auditoria AS A
                        INNER JOIN tipo_auditoria AS B ON B.tipo_auditoria_id = A.tipo_auditoria_id
                        INNER JOIN conexion AS C ON C.conex_id = A.conex_id
                        INNER JOIN rel_perfil_usuario AS D ON D.rel_perfil_id = C.rel_perfil_id
                        INNER JOIN usuario AS E ON E.usuario_id = D.usuario_id";
            $strWhere   = null;
            $strOrderBy = 'A.auditoria_fecha desc';
            $arrFiltros = 0;

            if($tipoAudit != null){
                $strWhere.= "B.tipo_auditoria_id = '".$tipoAudit."'";
                $arrFiltros++;
            }

            if($arrFiltros > 0){
                if(($fechaDesde != null)&&($fechaHasta != null)) $strWhere.= " AND auditoria_fecha BETWEEN '".$fechaDesde." 00:00:00' AND '".$fechaHasta." 23:59:59'";       
                else {
                    if($fechaDesde != null) $strWhere.= " AND auditoria_fecha = '".$fechaDesde."'";
                }
            }
            else{
                if(($fechaDesde != null)&&($fechaHasta != null)) $strWhere.= "auditoria_fecha BETWEEN '".$fechaDesde." 00:00:00' AND '".$fechaHasta." 23:59:59'";
                else{
                    if($fechaDesde != null) $strWhere.= "auditoria_fecha = '".$fechaDesde."'";
                }
                    
            }
			
			$arreglo = $conexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy);
			
			if(count($arreglo)>0){
				foreach ($arreglo as $i=>$dato){
                    $contenido['id'] 	= $dato["id"];
                    $contenido[0]		= ++$i;
                    $contenido[1]		= utf8_encode($dato["tipo"]);
                    $contenido[2]		= utf8_encode($dato["observacion"]);
                    $contenido[3]		= $dato["usuario"];
                    $contenido[4]		= formFechaHoraSegundo($dato["fecha"]);
                    $contenido[5]		= $dato["ip"];
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