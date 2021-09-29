<?php
    $rutaDir = '../';
    include_once $rutaDir.'config.php';

    isset($_GET['case']) ? $case = $_GET['case'] : $case = null;

    switch($case){
        case 0:
            isset($_GET['infId']) ? $infId = $_GET['infId'] : $infId = null;
            
            $involucrado    = new Involucrado();
			$arrInf 	    = $involucrado->consultarExpediente($infId,'procesado');
			
			if(count($arrInf)>0){
				foreach ($arrInf as $i=>$infrac){
                    $contenido['id'] 	= $infrac["id"];
                    $contenido[0]		= ++$i;
                    $contenido[1]		= $infrac["rim"] ? $infrac["rim"] : 'SIN NÚMERO';
                    $contenido[2]		= $infrac["tipo"];
                    $contenido[3]		= $infrac["ubicacion"];
                    $contenido[4]		= formFechaHora($infrac["fecha"]);
                    $contenido[5]		= $infrac["sancion"]    != null ? $infrac["sancion"]    : 'SIN ESPECIFICAR';
                    $contenido[6]		= $infrac["medida"]     != null ? $infrac["medida"]     : 'SIN ESPECIFICAR';
                    $contenido[7]		= $infrac["usuario"];
                    $data[]             = $contenido;
				}
			}
			else $data = 0;
        break;
        case 1:
            isset($_GET['lista']) ? $lista = $_GET['lista'] : $lista = null;
            
            $conexionBd = new ConexionBd();

			$strSelect  = "invol_id as id,
                        invol_cedula AS cedula,
						invol_nombres AS nombre,
						invol_apellidos AS apellido,
						invol_alias AS alias,
						invol_banda AS banda";
        	$strFrom    = "involucrado";
			$strWhere 	= "invol_id IN (".$lista.")";
            $strOrderBy	= "invol_nombres";

            $arrInfractor = $conexionBd->hacerSelect($strSelect,$strFrom,$strWhere,null,$strOrderBy);

            if(count($arrInfractor)>0){
				foreach ($arrInfractor as $i=>$infrac){
                    $contenido['id'] 	= $infrac["id"];
                    $contenido[0]		= ++$i;
                    $contenido[1]		= $infrac['cedula'];
                    $contenido[2]		= $infrac['nombre'];
                    $contenido[3]		= $infrac["apellido"];
                    $contenido[4]		= $infrac["alias"];
                    $contenido[5]		= $infrac["banda"];
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