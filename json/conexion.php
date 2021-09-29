<?php
	$rutaDir = '../';
    include_once $rutaDir.'config.php';

    isset($_GET['case']) ? $case = $_GET['case'] : $case = null;

    switch($case){
        case 0: 
            $objeto     = new Conexion();
            $arreglo    = $objeto->consultarConexion();

			if(count($arreglo)>0){
				foreach ($arreglo as $i=>$dato){
                    $contenido['id'] 	= $dato["id"];
                    $contenido[0]		= ++$i;
                    $contenido[1]		= $dato["login"];
                    $contenido[2]		= $dato["perfil"];
                    $contenido[3]		= formFechaHoraSegundo($dato["fecha_inicio"]);
                    $contenido[4]		= $dato["ip"];
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