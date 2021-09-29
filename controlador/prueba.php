<?php
    $rutaDir = "../";
	include_once $rutaDir.'config.php';

    $conexionBd = new ConexionBd();
    $resultado = $conexionBd->hacerConsulta("select distinct(A.invol_cedula) as cedula
                                from involucrado A 
                                    inner join rel_activ_invol B on B.invol_id = A.invol_id
                                    inner join tipo_involucrado C on C.tipo_invol_id = B.tipo_invol_id
                                where B.tipo_invol_id = 1 order by cedula
                                ",true);

    foreach($resultado as $i => $involucrado){
        $infractor[$i] = $involucrado['cedula'];
    }
    echo("<pre>");
    print_r($infractor);
    echo("</pre>");

    // $evaluar = $ruta.$ext;
    
    // if(file_exists($evaluar)) $archivo = $evaluar;
?>