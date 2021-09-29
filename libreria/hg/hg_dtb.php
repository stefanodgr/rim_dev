<?php
    function crearDtsTbl($siglas,$encabezado,$columna,$tipo,$formato,$relacion,$default,$visible){

        $col = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

        for($i=0;$i<=count($encabezado);$i++){
            if($i==0){
                $dtsTbl[$i]['encabezado'] = '';
                $dtsTbl[$i]['default'] = $dtsTbl[$i]['relacion'] = $dtsTbl[$i]['formato'] = $dtsTbl[$i]['tipo'] = $dtsTbl[$i]['columna'] = '';
                $dtsTbl[$i]['header'] = "id_".$siglas."_ind_0";
            }
            else{
                $encabezado     [$i-1] != '' ? $dtsTbl[$i]['encabezado']  = $encabezado   [$i-1] : $dtsTbl[$i]['encabezado']  = 'null';
                $columna        [$i-1] != '' ? $dtsTbl[$i]['columna']     = $columna      [$i-1] : $dtsTbl[$i]['columna']     = 'null';
                $tipo           [$i-1] != '' ? $dtsTbl[$i]['tipo']        = $tipo         [$i-1] : $dtsTbl[$i]['tipo']        = 'null';
                $formato        [$i-1] != '' ? $dtsTbl[$i]['formato']     = $formato      [$i-1] : $dtsTbl[$i]['formato']     = 'null';
                $relacion       [$i-1] != '' ? $dtsTbl[$i]['relacion']    = $relacion     [$i-1] : $dtsTbl[$i]['relacion']    = 'null';
                $default        [$i-1] != '' ? $dtsTbl[$i]['default']     = $default      [$i-1] : $dtsTbl[$i]['default']     = 'null';
                $dtsTbl[$i]['header']  = "id_".$siglas."_".$col[$i-1]."0";
            }
            $visible[$i] == 'false' ? $dtsTbl[$i]['visible'] = 'hidden' : $dtsTbl[$i]['visible'] = 'null';
        }
        return $dtsTbl;
    }

    function cargarFilaVacia($cantColum, $tipo){   // RECIBE COMO PARÁMETROS LA CANTIDAD DE COLUMNAS DE LA TABLA INCLUYENDO LA COLUMNA INDICE Y EL TIPO DE CONSULTA; JSON O CONTROLADOR

        if($tipo ==  "controlador"){
            for($i=0;$i<$cantColum;$i++){
                if($i == 0) $columna[$i] = 1;
                else $columna[$i] = null;
            }
            $fila[0]['id']      = 0;
            $fila[0]['columna'] = $columna;
            $data[] 			= $fila[0];
        }
        else{
           for($i=0;$i<$cantColum;$i++){
                if($i == 0) $contenido[0] = 1;
                else $contenido[$i] = null;
            }
            $data[] = $contenido;
        }

        return $data;
    }
?>