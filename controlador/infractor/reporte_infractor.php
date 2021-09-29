<?php
    $rutaDir = "../../";
	include_once $rutaDir.'config.php';
    use Dompdf\Dompdf;

    $ctrlAcceso = validarConexion();

	if($ctrlAcceso){
        isset($_POST['param0']) ? $infId = $_POST['param0'] : $infId = 0;

        if(!$_POST) return false;

        $involucrado    = new Involucrado();
        $sancion        = new Sancion();
        $medida         = new MedidaCautelar();
        $datosInvol     = $involucrado->buscarInvolucrado($infId);
        $datosExped     = $involucrado->consultarExpediente($infId);
        $datosSancion   = $sancion->consultarSancion($infId);
        $datosMedida    = $medida->consultarMedida($infId);

        if($datosInvol[0]['foto'] == 't'){
            if($datosInvol[0]['pers_id']) {
                $foto = gestionFotoInvol('consultar',$rutaDir.'../sictra/fotos/'.$datosInvol[0]['cedula']);
            }
            else{
                $foto = gestionFotoInvol('consultar',$rutaDir.'multimedia/imagen/infractor/'.$datosInvol[0]['cedula']);
            }
        }

        $colorFila = array('filaClara','filaOscura');
        $j=0;

        foreach($datosExped as $i=>$fila){
            $contExped .= '<tr class="'.$colorFila[$j].'">';
            $contExped .= '<td style="text-align:center;">'.($i+1).'</td>';
            $contExped .= '<td>'.$fila['rim'].'</td>';
            $contExped .= '<td>'.$fila['tipo'].'</td>';
            $contExped .= '<td>'.$fila['ubicacion'].'</td>';
            $contExped .= '<td>'.formFechaHora($fila['fecha']).'</td>';
            $contExped .= '</tr>';

            if($j==0) $j++;
            else $j--;
        }
        $j=0;
        if(count($datosSancion) > 0){
            foreach($datosSancion as $i=>$fila){
                $contSancion .= '<tr class="'.$colorFila[$j].'">';
                $contSancion .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contSancion .= '<td>'.$fila['rim'].'</td>';
                $contSancion .= '<td>'.$fila['desc_sancion'].'</td>';
                $contSancion .= '<td>'.$fila['observacion'].'</td>';
                $contSancion .= '<td>'.formFechaHora($fila['fecha']).'</td>';
                $contSancion .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
        }
        else $vistaSancion = 'oculto';
        $j=0;
        if(count($datosMedida) > 0){
            foreach($datosMedida as $i=>$fila){
                $contMedida .= '<tr class="'.$colorFila[$j].'">';
                $contMedida .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contMedida .= '<td>'.$fila['rim'].'</td>';
                $contMedida .= '<td>'.$fila['desc_medida'].'</td>';
                $contMedida .= '<td>'.$fila['observacion'].'</td>';
                $contMedida .= '<td>'.formFechaHora($fila['fecha']).'</td>';
                $contMedida .= '</tr>';
                
                if($j==0) $j++;
                else $j--;
            }
        }
        else $vistaMedida = 'oculto';

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
        $footer     = '
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
            <center><h3 style="font-family: sans-serif;text-decoration: underline;margin-top:0px;">EXPEDIENTE DEL INFRACTOR</h3></center>
            <br>
            <div id="div_ficha">
                <div class="titulo_seccion">FICHA DEL INFRACTOR:</div>
                <br>
                <div class="div_tbl" style="float:left;width:67.5%;">
                    <div class="div-tbl-fi">
                        <table style="position:relative;width:100%;height:28px;">
                            <tr>
                                <td class="td_inf dark" style="width:15%;">Cédula</td>
                                <td class="td_dato" style="width:85%;">'.$datosInvol[0]['cedula'].'</td>
                            </tr>
                        </table>
                    </div>
                    <div class="div-tbl-fi">
                        <table style="position:inherit;width:100%;height:28px;">
                            <tr>
                                <td class="td_inf dark" style="width:15%;">Nombre:</td>
                                <td class="td_dato" style="width:85%;">'.$datosInvol[0]['nombre']." ".$datosInvol[0]['apellido'].'</td>
                            </tr>
                        </table>
                    </div>
                    <div class="div-tbl-fi">
                        <table style="position:inherit;width:100%;height:28px;">
                            <tr>
                                <td class="td_inf dark" style="width:15%;">Alias:</td>
                                <td class="td_dato" style="width:85%;">'.$datosInvol[0]['alias'].'</td>
                            </tr>
                        </table>
                    </div>
                    <div class="div-tbl-fi">
                        <table style="position:inherit;width:100%;height:28px;">
                            <tr>
                                <td class="td_inf dark" style="width:15%;">Banda:</td>
                                <td class="td_dato" style="width:85%;">'.$datosInvol[0]['banda'].'</td>
                            </tr>
                        </table>
                    </div>
                    <div class="div-tbl-fi">
                        <table style="position:inherit;width:100%;height:28px;">
                            <tr>
                                <td class="td_inf dark" style="width:15%;">Teléfono:</td>
                                <td class="td_dato" style="width:85%;">'.$datosInvol[0]['telefono'].'</td>
                            </tr>
                        </table>
                    </div>
                    <div class="div-tbl-fi" style="height: 86px;">
                        <table style="position:inherit;width:100%;height:86px;">
                            <tr>
                                <td class="td_inf dark" style="width:15%;">Dirección:</td>
                                <td class="td_dato" style="width:85%;">'.$datosInvol[0]['direccion'].'</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="width:14px;float:left;"></div>
                <table style="position:relative;width:218px;height:225px;float:left;margin-top:-2px;">
                    <tr>
                        <td class="dark" style="border:0px solid gray;">
                            <img src="'.$foto.'" style="width:99%; height:225px;border:0.5px solid black;">
                        </td>
                    </tr>
                </table>
            </div>
            <br><br><br>
            <div class="div_seccion">
                <div class="div_subseccion">
                    <div class="titulo_seccion">DETALLES DEL EXPEDIENTE DEL INFRACTOR:</div>
                    <br>
                    <div class="titulo_subseccion">INFRACCIONES: '.count($datosExped).' registro(s).</div>
                    <table style="width:100%;">
                        <thead>
                            <tr class="td_inf" style="height:40px;text-align:center;font-size:12px;">
                                <th class="indice"></th>
                                <th>Nro. RIM</th>
                                <th>Tipo de Infracción</th>
                                <th>Estación</th>
                                <th>Fecha/Hora</th>
                            </tr>
                        </thead>
                        <tbody>'.$contExped.'</tbody>
                    </table>
                </div>
                <br><br>
                <div class="div_subseccion">
                    <div class="titulo_subseccion">SANCIONES: '.count($datosSancion).' registro(s).</div>
                    <table class="'.$vistaSancion.'"  style="width:100%;" cellspacing="0">
                        <thead>
                            <tr class="td_inf" style="height:40px;text-align:center;font-size:12px;">
                                <th class="indice"></th>
                                <th>Nro. RIM</th>
                                <th>Tipo de Sanción</th>
                                <th>Observación</th>
                                <th>Fecha/Hora</th>
                            </tr>
                        </thead>
                        <tbody>'.$contSancion.'</tbody>
                    </table>
                </div>
                <br><br>
                <div class="div_subseccion">
                    <div class="titulo_subseccion">MEDIDAS CAUTELARES: '.count($datosMedida).' registro(s).</div>
                    <table class="'.$vistaMedida.'" style="width:100%;" cellspacing="0">
                        <thead>
                            <tr class="td_inf" style="height:40px;text-align:center;font-size:12px;">
                                <th class="indice"></th>
                                <th>Nro. RIM</th>
                                <th>Tipo de Medida</th>
                                <th>Observación</th>
                                <th>Fecha/Hora</th>
                            </tr>
                        </thead>
                        <tbody>'.$contMedida.'</tbody>
                    </table>
                </div>
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
    }
?>