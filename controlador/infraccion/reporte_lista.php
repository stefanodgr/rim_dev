<?php
    $rutaDir = "../../";
	include_once $rutaDir.'config.php';
    use Dompdf\Dompdf;

    $ctrlAcceso = validarConexion();

	if($ctrlAcceso){
        $query = file_get_contents($rutaDir.'documento/txt/query_lista_infraccion.txt');

        $conexionBd         = new ConexionBd();
        $listaInfraccion    = $conexionBd->hacerConsulta($query,true);

        $colorFila = array('filaClara','filaOscura');
        $j=0;

        foreach($listaInfraccion as $i=>$fila){
            $rim = $fila['rim'] ? $fila['rim'] : 'SIN NÚMERO';

            $contLista .= '<tr class="'.$colorFila[$j].'">';
            $contLista .= '<td style="text-align:center;">'.($i+1).'</td>';
            $contLista .= '<td>'.$rim.'</td>';
            $contLista .= '<td>'.$fila['actividad'].'</td>';
            $contLista .= '<td>'.$fila['ubicacion'].'</td>';
            $contLista .= '<td>'.formFechaHora($fila['fecha']).'</td>';
            $contLista .= '<td>'.$fila['estado'].'</td>';
            $contLista .= '</tr>';
            
            if($j==0) $j++;
            else $j--;
        }

        $style      = file_get_contents($rutaDir.'css/reporte.css');
        $htmlIni    = '<html>';
        $htmlFin    = '</html';
        $headIni    = '<head><meta http-equiv="Content-Type" content="text/html;">';
        $headFin    = '</head>';
        $styleIni   = '<style type="text/css">';
        $styleFin   = '</style>';
        $bodyIni    = '<body>';
        $bodyFin    = '</body>';
        $header     = ' 
        <div id="panel_top">
            <div style="height:auto;">
                <img src="'.$rutaDir.'multimedia/imagen/portada/cintillo.jpg" style="width:100%;height:100%">
            </div>
            <br>
        </div>';
        $footer = '
        <div id="panel_foot">
            <div style="height:10px;margin-top:0px;">
                <img src="'.$rutaDir.'multimedia/imagen/portada/ravan.jpg" style="width:100%;height:100%">
            </div>
            <div style="position:relative;width:100%;top:5px;">
                Gerencia de Protección y Seguridad (GPS)<br>
                Centro de Control de Seguridad (CCS)<br>
                Sistema de Registro de Infractores Metro (RIM)
            </div>
            <table id="datos_foot">
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>';
        $body = ('
        <div id="panel_contenido">
            <center><h3 style="font-family: sans-serif;text-decoration: underline;margin-top:0px;">LISTADO DE INFRACCIONES</h3></center>
            <br><br>
            <div id="div_lista">
                <table style="width:100%;margin-top:-15px;" cellspacing="0">
                    <thead>
                        <tr class="td_inf" style="height:40px;text-align:center;font-size:12px;">
                            <th></th>
                            <th>Nro. RIM</th>
                            <th>Tipo de Infracción</th>
                            <th>Estación</th>
                            <th>Fecha/Hora</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>'.$contLista.'</tbody>
                </table>
            </div>
        </div>');
        
        $pdf = $htmlIni.$headIni.$styleIni.$style.$styleFin.$headFin.$bodyIni.$header.$footer.$body.$bodyFin.$htmlFin; 
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdf);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();
        $fontMe = $dompdf->getFontMetrics();
        $fuente = $fontMe->get_font("helvetica", "bold");
        $canvas = $dompdf->get_canvas(); 
        $canvas->page_text(548, 771, "Pág. {PAGE_NUM}/{PAGE_COUNT}",$fuente, 6, array(0,0,0)); 
        $dompdf->stream("prueba.pdf", array("Attachment" => false)); 
        // header("Content-type: application/pdf"); 
        // echo $dompdf->output("prueba.pdf");
        // echo("<pre>");
        // print_r($_dompdf_warnings);
        // echo("</pre>");
    }
?>