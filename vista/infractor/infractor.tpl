<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
	</head>
	<body>
		<div class='contenedor'>
			<div class='titulo'>
				<div>[var.titulo;noerr;] :.</div>
                <div>
                    <input type='image' id='toggle_menu' src="multimedia/imagen/icono/menu.png" style="width:15px;height:15px;transition-duration: 0.5s;">
                </div>
			</div>
            <div class='contenido'>
				<div id='ficha_infractor'>
					<div class='div-tbl'>
						<div class="div-tbl-fi" style="height: 30px;">
							<div class="modal_titulo div-tbl-co" style='width:620px;'>- Búsqueda de Infractor -</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Cédula:'>
							</div>
							<div class="div-tbl-co" style='width:50px;'>
								<select class="dsR170 frm_2" id="filt_nac" size="1" style='height:30px;font-weight: bold;'>
									<option value="V">V</option>
									<option value="E">E</option>
									<option value="P">P</option>
								</select> 
							</div>
							<div class="div-tbl-co" style='width:140px;'>
								<input type="text" id='filt_cedula' class='div-inp-ena frm_0 frm_2 edit' >
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content: center'>
								<input type="image" id='btn_busq_infractor' src="multimedia/imagen/icono/buscar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
							<div class="div-tbl-co" style='width:220px;height:260px;top:115px;flex-flow: row wrap;justify-content: center;margin-left:19px;'>
								<img id='filt_foto' class='img_inf' src='multimedia/imagen/infractor/siluetaHombre.png' style='width:100%; height:225px;border:1px solid gray;cursor:pointer;'>
								<input type="file" id='filt_foto_load' style="width:85px;margin-top:5px;height:30px;cursor:not-allowed;display:none;" disabled>
								<div style="width:85px;margin-top:5px;height:30px;cursor:not-allowed;"></div>
							</div>
						</div>
						<div class="div-tbl-fi" style="width: 320px;">
							<div class="div-tbl-co" style='width:20px;'></div>	
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Nombre:'>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='filt_nombre' class='div-inp-ena frm_0 frm_2 edit'>
							</div>
						</div>
						<div class="div-tbl-fi" style="width: 320px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Apellido:'>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='filt_apellido' class='div-inp-ena frm_0 frm_2 edit'>
							</div>
						</div>
						<div class="div-tbl-fi" style="width: 320px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Alias:'>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='filt_alias' class='div-inp-ena frm_0 edit'>
							</div>
						</div>
						<div class="div-tbl-fi" style="width: 320px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Banda:'>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='filt_banda' class='div-inp-ena frm_0 edit'>
							</div>
						</div>
						<div class="div-tbl-fi" style="width: 320px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Teléfono:'>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='filt_telefono' class='div-inp-dis frm_1 edit' disabled>
							</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi" style="height:90px;top:15px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Dirección:'>
							</div>
							<div class="div-tbl-co" style='width:460px;'>
								<textarea  id="filt_direccion" class = 'div-inp-dis frm_1 edit' style="position:relative;width:100%;resize:none;" disabled='disabled'></textarea>
							</div>
						</div>
						<div class="div-tbl-fi inf-metro oculto">
							<div class="div-tbl-co" style='width:100%;justify-content: center;color: darkred;'>
								<strong><h4>TRABAJADOR METRO</h4></strong>
							</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi" style="height:60px;">
							<div class="div-tbl-co" style='width:calc(100% - 40px);left:20px;justify-content:center;'>
								<input type="button" id='btn_infractor_bus' class='btn_hg btnAzul2 btn_infractor_0' 							style='width:120px;' 					value='Consultar'>
								<!-- <input type="button" id='btn_infractor_mod' class='btn_hg btnAzul btn_infractor_1 oculto' 						style='width:132px;'					value='Modificar'> -->
								<!--<input type="button" id='btn_infractor_exp' class='btn_hg btnAmarillo btn_infractor_1 oculto' 				style='width:132px;margin-left:30px;' 	value='Ver Expediente'>-->
								<input type="button" id='btn_infractor_rep' class='btn_hg btnVioleta oculto' 									style='width:132px;margin-left:30px;' 	value='Reporte PDF'>
								<input type="button" id='btn_infractor_lim' class='btn_hg btnCeleste btn_infractor_1 oculto' 					style='width:132px;margin-left:30px;'  	value='Limpiar'>
								<input type="button" id='btn_infractor_ace' class='btn_hg btnVerde btn_infractor_2 oculto deshabilitado' 		style='width:132px;' 					value='Aceptar' disabled>
								<input type="button" id='btn_infractor_can' class='btn_hg btnRojo btn_infractor_2 oculto' 						style='width:132px;margin-left:30px;' 	value='Cancelar'>
							</div>
						</div>
						<div class="div-tbl-fi oculto">
							<div class="div-tbl-co" style="width:30px;">
								<input type="text" id='filt_id' class="div-inp-dis" disabled>
							</div>
						</div>
					</div> 
				</div>
				<div id='exped_infractor' class="oculto">
					<div class='inf_reincidencia' style='display:none;'><img src = 'multimedia/imagen/icono/advertencia.png' width="30px" height="30px"></img>&nbsp; Esta persona posee más de una infracción registrada en el sistema.</div>
					<div class='div-tbl' style='top:10px;'>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:100%;justify-content: center;'>
								<iframe id='ifr_infractor_exp' name='ifr_infractor_exp' scrolling='no'></iframe>
							</div>
						</div>
						<!--<div class="div-tbl-fi" style="height:50px;width:100%;">
							<div class="div-tbl-co" style='width:100%;justify-content:center;'>
								<input type="button" id='btn_infractor_fic' class='btn_hg btnAzul3' style='width:132px;' value='Atŕas'>
							</div>
						</div>-->
					</div>
				</div>
				<div id='lista_infractor' class='oculto'>
					<iframe id='ifr_lista_infractor' name='ifr_lista_infractor' scrolling='no'></iframe>
				</div>
            </div>
			<div class='preview' style="visibility: hidden;">
				<input type="image" class='img-preview'>
			</div>
		</div>    
	</body>
</html>