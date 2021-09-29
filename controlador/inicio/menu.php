<?php
	$rutaDir = "../../";
	include_once $rutaDir.'config.php';

	$ctrlAcceso = validarConexion();

	if($ctrlAcceso){
		$persNombre 	= $_SESSION['UsuarioNombre'];
		$perfil 		= $_SESSION['PerfilUsuario'];
		$perfilId   	= $_SESSION['IdPerfilUsuario'];
		$usuario 		= $_SESSION['Login'];
		
		if($perfil == 'MASTER'){
			$nroConexiones  = $_SESSION['cantConexion'];
			$conexVisible 	= 'visible';
		}

		$miPerfilMenu = new PerfilMenu($miConexionBd);
		$miPerfilMenu->setObjeto("Perfil",$perfilId);

		$arrMenu = $miPerfilMenu->consultar();

		if(count($arrMenu) >0){
			foreach ($arrMenu as $i=>$item){
				$menu[$i]['activo'] = $item->getObjeto('Menu')->getAtributo('menu_activo');
				$menu[$i]['id'] 	= $item->getObjeto('Menu')->getAtributo('menu_id');
				$menu[$i]['desc'] 	= $item->getObjeto('Menu')->getAtributo('menu_desc');
				$menu[$i]['icono'] 	= $item->getObjeto('Menu')->getAtributo('menu_icono');
				$menu[$i]['link'] 	= $item->getObjeto('Menu')->getAtributo('menu_link');
				$menu[$i]['padre'] 	= $item->getObjeto('Menu')->getAtributo('menu_padre');
				$menu[$i]['orden'] 	= $item->getObjeto('Menu')->getAtributo('menu_orden');
				$orden[$i] 			= $item->getObjeto('Menu')->getAtributo('menu_orden');
			}
		}
		array_multisort($orden,SORT_ASC,$menu);

		if(count($menu) > 0){
			$i = $j = 0;
			foreach ($menu as $unMenu){
				if($unMenu['activo'] == 't'){
					if($unMenu['padre'] == 0){
						$arrPadres[$i]['id']		= $unMenu['desc'];
						$arrPadres[$i]['titulo']	= $unMenu['desc'];
						$arrPadres[$i]['padre']		= "principal";
						$arrPadres[$i]['hijo'] 		= $unMenu['id'];
						$arrPadres[$i]['imagen'] 	= $unMenu['icono'];
						$arrPadres[$i]['url'] 		= $unMenu['link'];
						$i++;
					}
					else{
						$arrHijos[$j]['titulo'] = $unMenu['desc'];
						$arrHijos[$j]['padre']  = $unMenu['padre'];
						$arrHijos[$j]['imagen'] = $unMenu['icono'];
						$arrHijos[$j]['url'] 	= $unMenu['link'];
						$j++;
					}
				}
			}
			
			for ($i = 0; $i<count($arrPadres);$i++) {
				$k=0;
				for ($j = 0; $j < count($arrHijos); $j++) {
					// echo($arrPadres[$i]['hijo']." == ". $arrHijos[$j]['padre']."<br>");
					if($arrPadres[$i]['hijo'] == $arrHijos[$j]['padre']){
						$arreglo[$k] = $arrHijos[$j];
						$k++;					
					}						
				}
				if (count($arreglo)>0) $arrPadres[$i]['items'] = $arreglo;
				$arreglo = null;
			}
			$menu = $arrPadres;		
		}

		// echo("<pre>");
		// print_r($menu);
		// echo("</pre>");
		
		$TBS = new clsTinyButStrong;
		$TBS->LoadTemplate(RUTA_SISTEMA.'vista/inicio/menu.tpl');
		$TBS->MergeBlock('menu',$menu);
		$TBS->Show();
	}
?>