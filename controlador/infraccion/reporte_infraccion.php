<?php
    $rutaDir = "../../";
	include_once $rutaDir.'config.php';
    use Dompdf\Dompdf;

    $ctrlAcceso = validarConexion();

	if($ctrlAcceso){

        if(!$_POST) return false;
        isset($_POST['param0']) ? $infraccionId = $_POST['param0'] : $infraccionId = null;

        $infraccion = new Actividad();
        $evidencia  = new FotoAdicional();
        $ctrlRep    = false;

        $datosInfraccion    = $infraccion->buscarInfraccion($infraccionId);
        $datosMaterial      = $infraccion->consultarInfraccionMat($infraccionId,'material');
        $datosMedio         = $infraccion->consultarInfraccionMat($infraccionId,'medio');
        $datosVehiculo      = $infraccion->consultarInfraccionVeh($infraccionId);
        $datosDocumento     = $infraccion->consultarInfraccionDoc($infraccionId);
        $fotosEvidencia     = $evidencia->obtenerEvidencia($infraccionId); 

        $infNroRim     = $datosInfraccion[0]['rim'];
        $infTipo       = $datosInfraccion[0]['actividad'];
        $infFecha      = $datosInfraccion[0]['fecha'];
        $infFechaReg   = $datosInfraccion[0]['registro'];
        $infEstado     = $datosInfraccion[0]['estado'];
        $infLinea      = $datosInfraccion[0]['linea'];
        $infEstacion   = $datosInfraccion[0]['estacion'];
        $infLugar      = $datosInfraccion[0]['lugar'];
        $infObserv     = $datosInfraccion[0]['descripcion'];

        if($infNroRim){     // EN EL CASO DE QUE LA INFRACCION POSEA UN NÚMERO RIM SE CONSULTA EL REPORTE GENERADO AL MOMENTO DE QUE SE PROCESÓ LA INFRACCIÓN
            $reporte    = new Reporte();
            $reporte->setObjeto('Actividad',$infraccionId);
            $arrReporte = $reporte->consultar();
            $ctrlRep    = count($arrReporte);

            if($ctrlRep){
                $reporteId  = $arrReporte[0]->getAtributo('rep_id');
                $hashRep    = $arrReporte[0]->getAtributo('rep_codigo');

                $reporteInvol = new RelReporteInvolucrado();
                $reporteInvol->setObjeto('Reporte',$reporteId);
                $arrReporteInvol = $reporteInvol->consultar();

                foreach($arrReporteInvol as $i=>$involucrado){
                    $involTipo      = $involucrado->getObjeto('TipoInvolucrado')->getAtributo('tipo_invol_desc');
                    $involCedula    = $involucrado->getAtributo('invol_cedula');

                    $involucrado = $reporteInvol->consultarInvolReporte($involCedula,$involTipo);

                    $datos['cedula']    = $involCedula;
                    $datos['nombre']    = $involucrado[0]['nombre'];
                    $datos['apellido']  = $involucrado[0]['apellido'];
                    $datos['alias']     = $involucrado[0]['alias'];
                    $datos['banda']     = $involucrado[0]['banda'];
                    $datos['carnet']    = $involucrado[0]['carnet'];
                    $datos['cuerpo']    = $involucrado[0]['cuerpo'];
                    $datos['cargo']     = $involucrado[0]['cargo'];

                    switch($involTipo){
                        case 'DETENIDO':
                        $datosDetenido[] = $datos;
                        break;
                        case 'VICTIMA':
                            $datosVictima[] = $datos;
                        break;
                        case 'FUNCIONARIO':
                            $datosFuncionario[] = $datos;
                        break;
                        case 'PERSONAL METRO':
                            $datosPersonal[] = $datos;
                        break;
                    }
                }
            }
        }

        if(!$ctrlRep){  // SI NO POSEE NÚMERO RIM SE CONSULTAN LOS DATOS QUE TIENE CARGADA LA INFRACCIÓN EN ESTATUS DE PRECARGA
            $datosDetenido      = $infraccion->consultarInfraccionInvol($infraccionId,'DETENIDO');
            $datosVictima       = $infraccion->consultarInfraccionInvol($infraccionId,'VICTIMA');
            $datosFuncionario   = $infraccion->consultarInfraccionInvol($infraccionId,'FUNCIONARIO');
            $datosPersonal      = $infraccion->consultarInfraccionInvol($infraccionId,'PERSONAL METRO');
        }
        
        $colorFila = array('filaClara','filaOscura');
        $j=0;

        if(count($datosDetenido) > 0){      //CONSULTA DE DETENIDOS
            foreach($datosDetenido as $i=>$fila){
                $contDetenido   .= '<tr class="'.$colorFila[$j].'">';
                $contDetenido   .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contDetenido   .= '<td>'.$fila['cedula'].'</td>';
                $contDetenido   .= '<td>'.strtoupper($fila['nombre']).' '.$fila['apellido'].'</td>';
                $contDetenido   .= '<td>'.$fila['alias'].'</td>';
                $contDetenido   .= '<td>'.$fila['banda'].'</td>';
                $contDetenido   .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
            $j=0;
        }
        else $vistaDetenido = 'oculto';
        if(count($datosVictima) > 0){       //CONSULTA DE VÍCTIMAS
            foreach($datosVictima as $i=>$fila){
                $contVictima    .= '<tr class="'.$colorFila[$j].'">';
                $contVictima   .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contVictima   .= '<td>'.$fila['cedula'].'</td>';
                $contVictima   .= '<td>'.strtoupper($fila['nombre']).' '.$fila['apellido'].'</td>';
                $contVictima   .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
            $j=0;
        }
        else $vistaVictima = 'oculto';
        if(count($datosFuncionario) > 0){   //CONSULTA DE FUNCIONARIOS
            foreach($datosFuncionario as $i=>$fila){
                $contFuncionario    .= '<tr class="'.$colorFila[$j].'">';
                $contFuncionario    .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contFuncionario    .= '<td>'.$fila['cedula'].'</td>';
                $contFuncionario    .= '<td>'.strtoupper($fila['nombre']).' '.$fila['apellido'].'</td>';
                $contFuncionario    .= '<td>'.$fila['carnet'].'</td>';
                $contFuncionario    .= '<td>'.$fila['cuerpo'].'</td>';
                $contFuncionario    .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
            $j=0;
        }  
        else $vistaFuncionario = 'oculto';
        if(count($datosPersonal) > 0){      //CONSULTA DE PERSONAL METRO
            foreach($datosPersonal as $i=>$fila){
                $contPersonal   .= '<tr class="'.$colorFila[$j].'">';
                $contPersonal   .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contPersonal   .= '<td>'.$fila['cedula'].'</td>';
                $contPersonal   .= '<td>'.strtoupper($fila['nombre']).' '.$fila['apellido'].'</td>';
                $contPersonal   .= '<td>'.$fila['carnet'].'</td>';
                $contPersonal   .= '<td>'.$fila['cargo'].'</td>';
                $contPersonal   .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
            $j=0;
        }
        else $vistaPersonal = 'oculto';
        if(count($datosMaterial) > 0){      //CONSULTA DE MATERIALES COMISADOS
            foreach($datosMaterial as $i=>$fila){
                $contMaterial  .= '<tr class="'.$colorFila[$j].'">';
                $contMaterial  .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contMaterial  .= '<td>'.$fila['precinto'].'</td>';
                $contMaterial  .= '<td>'.$fila['tipo'].'</td>';
                $contMaterial  .= '<td>'.$fila['cantidad'].'</td>';
                $contMaterial  .= '<td>'.$fila['unidad'].'</td>';   
                $contMaterial  .= '<td>'.$fila['descripcion'].'</td>';
                $contMaterial  .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
            $j=0;
        }
        else $vistaMaterial = 'oculto';
        if(count($datosMedio) > 0){         //CONSULTA DE MEDIOS DE COMISIÓN
            foreach($datosMedio as $i=>$fila){
                $contMedio  .= '<tr class="'.$colorFila[$j].'">';
                $contMedio  .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contMedio  .= '<td>'.$fila['precinto'].'</td>';
                $contMedio  .= '<td>'.$fila['tipo'].'</td>';
                $contMedio  .= '<td>'.$fila['cantidad'].'</td>'; 
                $contMedio  .= '<td>'.$fila['descripcion'].'</td>';
                $contMedio  .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
            $j=0;
        }
        else $vistaMedio = 'oculto';
        if(count($datosVehiculo) > 0){      //CONSULTA DE VEHÍCULOS INCAUTADOS
            foreach($datosVehiculo as $i=>$fila){
                $contVehiculo  .= '<tr class="'.$colorFila[$j].'">';
                $contVehiculo  .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contVehiculo  .= '<td>'.$fila['tipo'].'</td>';
                $contVehiculo  .= '<td>'.$fila['placa'].'</td>';
                $contVehiculo  .= '<td>'.$fila['marca'].'</td>'; 
                $contVehiculo  .= '<td>'.$fila['modelo'].'</td>';
                $contVehiculo  .= '<td>'.$fila['color'].'</td>';
                $contVehiculo  .= '<td>'.$fila['observacion'].'</td>';
                $contVehiculo  .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
            $j=0;
        }
        else $vistaVehiculo = 'oculto';
        if(count($datosDocumento) > 0){     //CONSULTA DE DOCUMENTOS RELACIONADOS
            foreach($datosDocumento as $i=>$fila){
                $contDocumento  .= '<tr class="'.$colorFila[$j].'">';
                $contDocumento  .= '<td style="text-align:center;">'.($i+1).'</td>';
                $contDocumento  .= '<td>'.$fila['tipo'].'</td>';
                $contDocumento  .= '<td>'.$fila['numero'].'</td>';
                $contDocumento  .= '<td>'.formFecha($fila['fecha'],'Y-m-d').'</td>';
                $contDocumento  .= '</tr>';

                if($j==0) $j++;
                else $j--;
            }
            $j=0;
        }
        else $vistaDocumento = 'oculto';

        $letras = array('A','B','C','D','E','F','G','H','I','J','K','L','M');
        
        foreach($fotosEvidencia as $i=>$foto){
            $contEvidencia .= '<div class="div_subseccion">';
            if($i==0) $contEvidencia .= '<div class="titulo_subseccion">EVIDENCIA(S) ASOCIADA(S): '.count($fotosEvidencia).' registro(s).</div>';
            $contEvidencia .= '<table style="width:100%;" cellspacing="0">';
            $contEvidencia .= '<tr class="td_inf" style="text-align:center;font-size:12px;">';
            $contEvidencia .= '<th>Evidencia '.$letras[$i].'</th>';
            $contEvidencia .= '</tr>';
            $contEvidencia .= '<tr>';
            $contEvidencia .= '<td style="text-align:center;height:378px;">';
            $contEvidencia .= '<img src="'.$rutaDir.'multimedia/imagen/evidencia/'.$foto->getAtributo('foto_desc').'" style="border:0.5px solid black;max-width:700px;max-height:360px;">';
            $contEvidencia .= '</td>';
            $contEvidencia .= '</tr>';
            $contEvidencia .= '</table>';
            $contEvidencia .= '</div>';
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
                    <td>'.$hashRep.'</td>
                    <td></td>
                </tr>
            </table>
        </div>';
        $body = ('
            <div id="panel_contenido">
                <center><h3 style="font-family: sans-serif;text-decoration: underline;;margin-top:0px;">REPORTE DE INFRACCIÓN</h3></center>
                <br>
                <div class="div_seccion">
                    <div class="titulo_seccion">FICHA DE LA INFRACCIÓN:</div>
                    <br>
                    <table style="width:100%;" cellspacing="0">
                        <thead>
                            <tr class="td_inf" style="text-align:center;font-size:12px;">
                                <th>Nro. RIM</th>
                                <th>Fecha de Ocurrencia</th>
                                <th>Fecha de Registro</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="filaClara" style="font-size:11px;text-align:center;">
                                <td >'.$infNroRim.'</td>
                                <td >'.$infFecha.'</td>
                                <td >'.$infFechaReg.'</td>
                                <td >'.$infEstado.'</td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;" cellspacing="0">
                        <thead>
                            <tr class="td_inf" style="text-align:center;font-size:12px;">
                                <th>Tipo de Infracción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="filaClara" style="text-align:center;font-size:11px;">
                                <td>'.$infTipo.'</td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;" cellspacing="0">
                        <thead>
                            <tr class="filaOscura" style="text-align:center;font-size:12px;">
                                <th colspan=3>Sitio de Ocurrencia</th>
                            </tr>
                            <tr class="td_inf" style="text-align:center;font-size:12px;">
                                <th>Línea</th>
                                <th>Estación</th>
                                <th>Lugar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="filaClara" style="font-size:11px;text-align:center;">
                                <td>'.$infLinea.'</td>
                                <td>'.$infEstacion.'</td>
                                <td>'.$infLugar.'</td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;" cellspacing="0">
                        <thead>
                            <tr class="td_inf" style="text-align:center;font-size:12px;">
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="div_observ">'.$infObserv.'</div>
                </div>
                <br><br>
                <div class="div_seccion">
                    <div class="div_subseccion">
                        <div class="titulo_seccion">DETALLES DE LA INFRACCIÓN:</div>
                        <br>
                        <div class="titulo_subseccion">DETENIDO(S): '.count($datosDetenido).' registro(s).</div>
                        <table class="'.$vistaDetenido.'" style="width:100%;" cellspacing="0">
                            <thead>
                                <tr class="td_inf" style="text-align:center;font-size:12px;">
                                    <th class="indice"></th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Alias</th>
                                    <th>Banda</th>
                                </tr>
                            </thead>
                            <tbody>'.$contDetenido.'</tbody>
                        </table>
                    </div>
                    <br><br>
                    <div class="div_subseccion">
                        <div class="titulo_subseccion">VÍCTIMA(S): '.count($datosVictima).' registro(s).</div>
                        <table class="'.$vistaVictima.'" style="width:100%;" cellspacing="0">
                            <thead>
                                <tr class="td_inf" style="text-align:center;font-size:12px;">
                                    <th class="indice"></th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>'.$contVictima.'</tbody>
                        </table>
                    </div>
                    <br><br>
                    <div class="div_subseccion">
                        <div class="titulo_subseccion">FUNCIONARIO(S) DE CUERPOS DE SEGURIDAD: '.count($datosFuncionario).' registro(s).</div>
                        <table class="'.$vistaFuncionario.'" style="width:100%;" cellspacing="0">
                            <thead>
                                <tr class="td_inf" style="text-align:center;font-size:12px;">
                                    <th class="indice"></th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Carné / Placa</th>
                                    <th>Cuerpo</th>
                                </tr>
                            </thead>
                            <tbody>'.$contFuncionario.'</tbody>
                        </table>
                    </div>
                    <br><br>
                    <div class="div_subseccion">
                        <div class="titulo_subseccion">PERSONAL METRO: '.count($datosPersonal).' registro(s).</div>
                        <table class="'.$vistaPersonal.'" style="width:100%;" cellspacing="0">
                            <thead>
                                <tr class="td_inf" style="text-align:center;font-size:12px;">
                                    <th class="indice"></th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Carné</th>
                                    <th>Cargo</th>
                                </tr>
                            </thead>
                            <tbody>'.$contPersonal.'</tbody>
                        </table>
                    </div>
                    <br><br>
                    <div class="div_subseccion">
                        <div class="titulo_subseccion">MATERIAL COMISADO: '.count($datosMaterial).' registro(s).</div>
                        <table class="'.$vistaMaterial.'" style="width:100%;" cellspacing="0">
                            <thead>
                                <tr class="td_inf" style="text-align:center;font-size:12px;">
                                    <th class="indice"></th>
                                    <th>Precinto</th>
                                    <th>Material</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>'.$contMaterial.'</tbody>
                        </table>
                    </div>
                    <br><br>
                    <div class="div_subseccion">
                        <div class="titulo_subseccion">MEDIO(S) DE COMISIÓN INCAUTADO(S): '.count($datosMedio).' registro(s).</div>
                        <table class="'.$vistaMedio.'" style="width:100%;" cellspacing="0">
                            <thead>
                                <tr class="td_inf" style="text-align:center;font-size:12px;">
                                    <th class="indice"></th>
                                    <th>Precinto</th>
                                    <th>Medio</th>
                                    <th>Cantidad</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>'.$contMedio.'</tbody>
                        </table>
                    </div>
                    <br><br>
                    <div class="div_subseccion">
                        <div class="titulo_subseccion">VEHÍCULO(S) INCAUTADO(S): '.count($datosVehiculo).' registro(s).</div>
                        <table class="'.$vistaVehiculo.'" style="width:100%;" cellspacing="0">
                            <thead>
                                <tr class="td_inf" style="text-align:center;font-size:12px;">
                                    <th class="indice"></th>
                                    <th>Tipo</th>
                                    <th>Placa</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Color</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>'.$contVehiculo.'</tbody>
                        </table>
                    </div>
                    <br><br>
                    <div class="div_subseccion">
                        <div class="titulo_subseccion">DOCUMENTO(S) ASOCIADOS: '.count($datosDocumento).' registro(s).</div>
                        <table class="'.$vistaDocumento.'" style="width:100%;" cellspacing="0">
                            <thead>
                                <tr class="td_inf" style="text-align:center;font-size:12px;">
                                    <th class="indice"></th>
                                    <th>Tipo</th>
                                    <th>Número</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>'.$contDocumento.'</tbody>
                        </table>
                    </div>
                    <br><br>
                    '.$contEvidencia.'
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