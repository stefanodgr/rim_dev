<?php
    $rutaDir = '../';
    include_once $rutaDir.'config.php';

    isset($_GET['case']) ? $case = $_GET['case'] : $case = null;

    switch($case){
        case 0:
            // TIPOS DE ACTIVIDAD //
            $objeto     = new TipoActividad();
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('tipo_activ_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('tipo_activ_desc');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 1:
            // TIPOS DE DOCUMENTOS //
            $objeto     = new TipoDocumento();
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('tipo_doc_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('tipo_doc_desc');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 2:
            // CUERPOS DE SEGURIDAD //
            $objeto     = new Cuerpo();
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('cuerpo_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('cuerpo_desc');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 3:
            // TIPOS DE VEHÍCULOS //
            $objeto     = new TipoVehiculo();
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('tipo_vehiculo_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('tipo_vehiculo_desc');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 4:
            // MARCAS DE VEHÍCULOS //
            $objeto     = new Marca();
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('marca_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('marca_desc');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 5:
            // MATERIAL COMISADO //
            $objeto     = new TipoMaterial();
            $objeto->setAtributo('categoria','MATERIAL');
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('tipo_mat_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('tipo_mat_desc');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 6:
            // MEDIOS DE COMISIÓN //
            $objeto     = new TipoMaterial();
            $objeto->setAtributo('categoria','MEDIO COMISION');
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('tipo_mat_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('tipo_mat_desc');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 7:
            // LINEAS //
            $objeto     = new Linea();
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('linea_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('linea_nombre');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 8:
            // ESTACIONES //
            isset($_GET['ubiId']) ? $ubiId = $_GET['ubiId'] : $ubiId = null;

            $objeto     = new Estacion();
            $objeto->setObjeto('Linea',$ubiId);
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('estacion_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('estacion_nombre');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
        case 9:
            // SANCIONES //

            $objeto     = new Sancion();
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('sancion_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('sancion_desc');
                    $contenido[2]   = $dato->getAtributo('sancion_tipo');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(3,'json');
        break;
        case 10:
            // MEDIDAS CAUTELARES //

            $objeto     = new MedidaCautelar();
            $arreglo    = $objeto->consultar();

            if(count($arreglo)>0){
                foreach ($arreglo as $i=>$dato){
                    $contenido['id']= $dato->getAtributo('medida_id');
                    $contenido[0]	= ++$i;
                    $contenido[1]   = $dato->getAtributo('medida_desc');
                    $data[]         = $contenido;
                }
            }
			else $data = cargarFilaVacia(2,'json');
        break;
    }
    
	$arrJson[data] = $data;
    // echo("<pre>");
    // print_r($arrJson);
    // echo("</pre>");
    $json = json_encode($arrJson);
    echo($json);
?>