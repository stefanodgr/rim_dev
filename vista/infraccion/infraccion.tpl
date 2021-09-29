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
                <div id='div_opc'>
                    <label>
                        <input type="radio" id='opc_bas' name="opc_bus" value='basica' checked='checked'>&nbsp&nbspConsulta Básica&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    </label>
                    <label>
                        <input type="radio" id='opc_ava' name="opc_bus" value='avanzada'>&nbsp&nbspConsulta Avanzada
                    </label>
                </div>
				<div id='div_filtros' style="top:10px;">
					<div class='div-tbl'>
						<div class="div-tbl-fi" style='justify-content: center;height: 60px;'>
							<div class="div-tbl-co" style='width:90px;'>
								<input type="text" class='div-inp-trans' disabled value='Actividad:'>
							</div>
							<div class="div-tbl-co" style='width:300px;'>
								<select id="selActividad">
									<option value="0" selected>TODAS</option>
									<option value="[tipoActividad.tipo_activ_id;block=option;noerr]">
										[tipoActividad.tipo_activ_desc;block=option;noerr]
									</option>
								</select>
							</div>
                            <div class="div-tbl-co" style='width:45px;'></div>
                            <div class="div-tbl-co" style='width:65px;'>
								<input type="text" class='div-inp-trans' disabled value='Estado:'>
							</div>
							<div class="div-tbl-co" style='width:145px;'>
								<select id='selStatus'>
									<option value='0'>TODOS</option>
									<option value='[estado.id;noerr;block=option;]'>[estado.desc;noerr]</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi avanzado oculto" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:90px;'>
								<input type="text" class='div-inp-trans' disabled value='Ubicación:'>
							</div>
							<div class="div-tbl-co" style='width:200px;'>
								<select id="selLinea">
									<option id='opc_lin_todas' value="0" selected>TODAS</option>
									<option value="[lineas.linea_id;block=option;noerr]">
										[lineas.linea_nombre;block=option;noerr]
									</option>
								</select>
							</div>
							<div class="div-tbl-co" style='width:10px;'></div>
							<div class="div-tbl-co" id='col_sel_est' style='width:345px;'>
							</div>
						</div>
						<div class="div-tbl-fi avanzado oculto" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:90px;'>
								<input type="text" class='div-inp-trans' disabled value='Fecha:'>
							</div>
							<div class="div-tbl-co" style='width:100px;'>
								<input type="text" id='f_desde' class='div-inp-dis' placeholder="Desde..." disabled>
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content:center;'>
								<input type="image" id='btn_f_desde' src="multimedia/imagen/icono/calendar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:100px;'>
								<input type="text" id='f_hasta' class='div-inp-dis' placeholder="Hasta..." disabled>
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content:center;'>
								<input type="image" id='btn_f_hasta' src="multimedia/imagen/icono/calendar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
                            <div class="div-tbl-co" style='width:275px;justify-content:center;'></div>
						</div>
                        <div class="div-tbl-fi avanzado oculto" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:90px;'>
								<input type="text" class='div-inp-trans' disabled value='Nro. RIM:'>
							</div>
							<div class="div-tbl-co" style='width:100px;'>
								<input type="text" id='filt_rim' class='div-inp-ena'>
							</div>
                            <div class="div-tbl-co" style='width:455px;justify-content:center;'></div>
						</div>
						<div class="div-tbl-fi avanzado oculto" style="height:15px;"></div>
						<div class="div-tbl-fi" style='height:45px;justify-content:center;top:-10px;'>
							<div class="div-tbl-co" style='width:645px;justify-content: center;'>
								<input type="button" id='btn_busq_infraccion' 	class='btn_hg btnAzul2' 								style='width:120px;' 					value='Consultar'>
								<input type="button" id='btn_rep_lista' 		class='btn_hg btnVioleta [var.ctrlReporteLista;noerr]' 	style='width:120px;margin-left:20px;' 	value='Reporte PDF'>
							</div>
						</div>
					</div>
				</div>
                <div id='div_infraccion' >
                    <iframe id='ifr_infraccion' name='ifr_infraccion' src='controlador/infraccion/infraccion.php?case=1&tipo=inicial' scrolling='no'></iframe>
                </div>
                <div id='ficha_infraccion' class='oculto'>
                    <div class='div-tbl'>
						<div class="div-tbl-fi" style="height:30px;">
							<div id='titulo_ficha_inf' class="modal_titulo div-tbl-co" style='width:100%;'>- Ficha de Infracción -</div>
						</div>
						
						<div class="div-tbl-fi" style="height:15px;"></div>
						<div class="div-tbl-fi oculto" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Id:'>
							</div>
							<div class="div-tbl-co" style='width:100px;'>
								<input type="text" id='infraccion_id' class='div-inp-dis' disabled>
							</div>
						</div>
						<div class="div-tbl-fi" style="width:100%;height:20px;border-radius:4px;justify-content: center;">
							<div class="div-tbl-co" style='width:85px;'>
								<input type="text" class='div-inp-trans inf_registro' value='Registrado por:' disabled>
							</div>
							<div class="div-tbl-co" style='width:120px;justify-content: center;'>
								<input type="text" id='filt_usuario' class='div-inp-trans inf_registro' disabled> 
							</div>
							<div class="div-tbl-co" style='width:280px;justify-content: center;'></div>
							<div class="div-tbl-co" style='width:75px;'>
								<input type="text" class='div-inp-trans inf_registro' value='Fecha / Hora:' disabled>
							</div>
							<div class="div-tbl-co" style='width:110px;justify-content: center;'>
								<input type="text" id='filt_registro' style="text-align: right;" class='div-inp-trans inf_registro' disabled> 
							</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:80px;justify-content: center;'>
								<input type="text" class='div-inp-trans' value='Fecha:' disabled>
							</div>
							<div class="div-tbl-co" style='width:170px;'>
								<input type="text" id='filt_fecha_inf' class='div-inp-dis' onchange='validaFecha(this.value);' disabled>
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content:center;'>
								<input type="image" id='btn_filt_fecha_inf' src="multimedia/imagen/icono/calendar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
                            <div class="div-tbl-co" style='width:130px;'></div>
                            <div class="div-tbl-co celda_rim_sup1" style='width:105px;height: 45px;'>
								<input type="text" class='div-inp-trans' value='  Número RIM:' disabled>
							</div>
                            <div class="div-tbl-co celda_rim_sup2" style='width:155px;height: 45px;'>
								<input type="text" id='filt_rim_inf' class='div-inp-dis rim' style="height:90%;width:97%;" disabled>
							</div>
						</div>
						<div class="div-tbl-fi" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Actividad:' disabled>
							</div>
							<div class="div-tbl-co" style='width:330px;'>
								<select id="filt_actividad" disabled>
									<option value="0" selected>SELECCIONAR</option>
									<option value="[tipoActividad2.tipo_activ_id;block=option;noerr]">
										[tipoActividad2.tipo_activ_desc;block=option;noerr]
									</option>
								</select>
							</div>
                            <div class="div-tbl-co celda_rim_inf1" style='width:105px;'>
								<input type="text" class='div-inp-trans' value='  Estado:' disabled>
							</div>
                            <div class="div-tbl-co celda_rim_inf2" style='width:155px;'>
								<select id='filt_estado' style="width:97%;" disabled>
									<option value='[estado2.id;noerr;block=option;]'>[estado2.desc;noerr]</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Ubicación:' disabled>
							</div>
							<div class="div-tbl-co" style='width:330px;'>
								<select id="filt_ubicacion" disabled>
									<option id='opc_ubi_todas' value="0" selected>SELECCIONAR</option>
									<option value="[ubicacion.linea_id;block=option;noerr]">
										[ubicacion.linea_nombre;block=option;noerr]
									</option>
								</select>
							</div>
							<div class="div-tbl-co" style='width:260px;'></div>
						</div>
                        <div id='fila_aux_ubi' class="div-tbl-fi oculto" style='justify-content: center;' >
                            <div class="div-tbl-co" style='width:80px;'></div>
                            <div class="div-tbl-co" id='col_filt_ubicacion2' style='width:330px;'></div>
							<div class="div-tbl-co" style='width:260px;'></div>
                        </div>
						<div class="div-tbl-fi" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Lugar:'>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='filt_lugar' class='div-inp-dis' disabled>
							</div>
							<div class="div-tbl-co" style='width:370px;'></div>
						</div>
						<div class="div-tbl-fi" style='justify-content: center;'>
							<div class="div-tbl-co" style='width:400px;'>
								<input type="text" class='div-inp-trans' value='Descripción del Procedimiento / Modus Operandi:' disabled>
							</div>
							<div class="div-tbl-co" style='width:270px;'></div>
						</div>
                         <div class="div-tbl-fi" style="height:150px;top:-14px;justify-content:center;">
							<div class="div-tbl-co" style='width:670px;'>
								<textarea  id="filt_descripcion" class = 'div-inp-dis' style="position:relative;width:100%;resize:none;overflow-y:scroll;" disabled></textarea>
							</div>
						</div>
						<!--<div class="div-tbl-fi" style="height:10px;"></div>-->
						<div class="div-tbl-fi" style="height:60px;justify-content: center;">
							<div class="div-tbl-co" style='width:calc(100% - 40px);justify-content:center;border:1px solid #d8d8d8;border-radius:6px;'>
								<input type="button" id='btn_infraccion_mod' class='btn_hg btnAzul btn_infraccion_0 oculto' 						style='width:132px;' 					value='Modificar'>
								<input type="button" id='btn_infraccion_det' class='btn_hg btnCeleste btn_infraccion_0' 							style='width:132px;margin-left:20px;'  	value='Detalles' title="Mostrar detalles">
								<input type="button" id='btn_infraccion_rep' class='btn_hg btnVioleta btn_infraccion_0 [var.ctrlReporteInf;noerr]' 	style='width:132px;margin-left:20px;'	value='Reporte PDF'>
								<input type="button" id='btn_infraccion_atr' class='btn_hg btnAzul3 btn_infraccion_0' 								style='width:132px;margin-left:20px;'  	value='Atrás'>
								<input type="button" id='btn_infraccion_ace' class='btn_hg btnVerde btn_infraccion_1 oculto' 						style='width:132px;margin-left:20px;'  	value='Aceptar'>
								<input type="button" id='btn_infraccion_can' class='btn_hg btnRojo btn_infraccion_1 oculto' 						style='width:132px;margin-left:30px;'  	value='Cancelar'>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:15px;"></div>
						<div id='div_inf_detalles' class='oculto'>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);'>
									<iframe id='ifr_infraccion_det' name="ifr_infraccion_det" scrolling='no'></iframe>
								</div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);'>
									<iframe id='ifr_infraccion_vic' name="ifr_infraccion_vic" scrolling='no'></iframe>
								</div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);'>
									<iframe id='ifr_infraccion_fun' name="ifr_infraccion_fun" scrolling='no'></iframe>
								</div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);'>
									<iframe id='ifr_infraccion_per' name="ifr_infraccion_per" scrolling='no'></iframe>
								</div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);'>
									<iframe id='ifr_infraccion_doc' name="ifr_infraccion_doc" scrolling='no'></iframe>
								</div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);'>
									<iframe id='ifr_infraccion_mat' name="ifr_infraccion_mat" scrolling='no'></iframe>
								</div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);'>
									<iframe id='ifr_infraccion_med' name="ifr_infraccion_med" scrolling='no'></iframe>
								</div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);'>
									<iframe id='ifr_infraccion_veh' name="ifr_infraccion_veh" scrolling='no'></iframe>
								</div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co area_titulo_head" style='width:calc(100% - 40px);'>Fotos Adicionales</div>
							</div>
							<div class="div-tbl-fi" style='justify-content: center;height:260px;'>
								<div class="div-tbl-co" style='width:calc(100% - 40px);border-left:1px solid #d8d8d8;border-right:1px solid #d8d8d8;'>
									<form id='form_file' target='ifr_submit' method="post" enctype="multipart/form-data">
										<iframe id='ifr_submit' name='ifr_submit' class='oculto' style="width:100%;height:300px;"></iframe>
									</form>
								</div>
							</div>
							<div class="div-tbl-fi" style='justify-content: center;'>
								<div class="div-tbl-co area_titulo_foot" style='width:calc(100% - 40px);'></div>
							</div>
							<div class="div-tbl-fi" style="height:20px;"></div>
						</div>
					</div> 
                </div>
				<div id='ficha_involucrado' class='oculto'>
					<div class='div-tbl'>
						<div class="div-tbl-fi" style="height: 30px;">
							<div class="modal_titulo div-tbl-co" style='width:620px;'></div>
						</div>
						<div id='filt_tipo_pers' class="div-tbl-fi oculto" style="margin-top:10px;">
							<div class="div-tbl-co" style="width:calc(100% - 40px);justify-content:center;margin-left:20px;border:1px solid #d8d8d8;border-radius: 6px 6px 6px 6px;">
								<label style='cursor:pointer;'>
									<input type="radio" id='opc_nat' name="opc_vic" value='natural' checked='checked'>&nbsp&nbspPersona Natural&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								</label>
								<label style='cursor:pointer;'>
									<input type="radio" id='opc_jur' name="opc_vic" value='juridica'>&nbsp&nbspPersona Jurídica
								</label>
							</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi oculto">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Invol. Id:' disabled>
							</div>
							<div class="div-tbl-co" style='width:100px;'>
								<input type="text" id='inv_id' class='div-inp-dis' disabled>
							</div>
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Pers. Id:' disabled>
							</div>
							<div class="div-tbl-co" style='width:100px;'>
								<input type="text" id='pers_id' class='div-inp-dis' disabled>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" id='inv_tipo_pers' class='div-inp-trans' value='Cédula:' disabled>
							</div>
							<div class="div-tbl-co" style='width:50px;'>
								<select class="dsR170" id="inv_nac" size="1" style='height:30px;font-weight: bold;'>
									<option value="V" class='vic_nat'>V</option>
									<option value="E" class='vic_nat'>E</option>
									<option value="P" class='vic_nat'>P</option>
									<option value="J" class='vic_jur oculto'>J</option>
									<option value="G" class='vic_jur oculto'>G</option>
									<option value="C" class='vic_jur oculto'>C</option>
								</select> 
							</div>
							<div class="div-tbl-co" style='width:140px;'>
								<input type="text" id='inv_cedula' class='div-inp-ena' maxlength="9">
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content: center'>
								<input type="image" id='btn_busq_invol' src="multimedia/imagen/icono/buscar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co inv_foto" style='width:220px;height:260px;top:115px;flex-flow: row wrap;justify-content: center;'>
								<img id='inv_foto' class='img_inf' src='multimedia/imagen/infractor/siluetaHombre.png' style='width:100%; height:225px;border:1px solid gray;cursor:pointer;'>
								<input type="file" id='inv_foto_load' style="width:85px;margin-top:5px;height:30px;cursor:not-allowed;" disabled>
							</div>
						</div>
						<div class="div-tbl-fi fi_inv_per" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Carné:' disabled>
							</div>
							<div class="div-tbl-co" style='width:100px;'>
								<input type="text" id='inv_carne' class='div-inp-dis inv_per' disabled='disabled'>
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content: center'>
								<input type="image" id='btn_busq_pers' src="multimedia/imagen/icono/buscar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
						</div>
						<div class="div-tbl-fi" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>	
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Nombre:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='inv_nombre' class='div-inp-dis inv_gen' disabled='disabled'>
							</div>
						</div>
						<div class="div-tbl-fi vic_nat" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Apellido:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='inv_apellido' class='div-inp-dis inv_gen' disabled='disabled'>
							</div>
						</div>
						<div class="div-tbl-fi fi_inv_per" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Cargo:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='inv_cargo' class='div-inp-dis inv_per' disabled='disabled'>
							</div>
						</div>
						<div class="div-tbl-fi fi_inv_fun" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Cuerpo:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<select id="selCuerpo" disabled>
									<option value="0" selected>SELECCIONAR</option>
									<option value="[cuerpo.id;block=option;noerr]">
										[cuerpo.desc;block=option;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi fi_inv_fun" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Placa:' disabled>
							</div>
							<div class="div-tbl-co" style='width:100px;'>
								<input type="text" id='inv_placa' class='div-inp-dis inv_fun' disabled='disabled'>
							</div>
						</div>
						<div class="div-tbl-fi fi_inv_det" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Alias:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='inv_alias' class='div-inp-dis inv_det' disabled='disabled'>
							</div>
						</div>
						<div class="div-tbl-fi fi_inv_det" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Banda:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='inv_banda' class='div-inp-dis inv_det' disabled='disabled'>
							</div>
						</div>
						<div class="div-tbl-fi" style="width:340px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Teléfono:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<input type="text" id='inv_telefono' class='div-inp-dis inv_gen' disabled='disabled'>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:10px;width:100px;"></div>
						<div class="div-tbl-fi" style="height:90px;top:15px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Dirección:' disabled>
							</div>
							<div class="div-tbl-co" style='width:460px;'>
								<textarea  id="inv_direccion" class = 'div-inp-dis inv_gen' style="position:relative;width:100%;resize:none;" disabled='disabled'></textarea>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:15px;"></div>
						<div class="div-tbl-fi inf-metro-inv oculto">
							<div class="div-tbl-co" style='width:100%;justify-content: center;color: darkred;'>
								<strong><h4>TRABAJADOR METRO</h4></strong>
							</div>
						</div>
						<div class="div-tbl-fi inf-func-inv oculto">
							<div class="div-tbl-co" style='width:100%;justify-content: center;color: darkblue;'>
								<strong><h4>FUNCIONARIO</h4></strong>
							</div>
						</div>
						<div class="div-tbl-fi inf-rei-inv oculto" style='height:10px;'></div>
						<div class="div-tbl-fi inf-rei-inv oculto">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co inf_reincidente_inf">
								<img src = 'multimedia/imagen/icono/advertencia.png' width="30px" height="30px"></img>&nbsp;<strong><h4>REINCIDENTE</h4></strong>
							</div>
							<div class="div-tbl-co" style='width:20px;'></div>
						</div>
						<div class="div-tbl-fi inf-rei-inv oculto" style='height:10px;'></div>
						<div class="div-tbl-fi" style="height:60px;">
							<div class="div-tbl-co" style='width:calc(100% - 40px);left:20px;justify-content:center;'>
								<input type="button" id='btn_invol_agr' class='btn_hg btnAzul btn_invol_0 deshabilitado' 				style='width:132px;' 					value='Agregar' disabled>
								<input type="button" id='btn_invol_lim' class='btn_hg btnCeleste btn_invol_0 oculto' 					style='width:132px;margin-left:30px;'  	value='Limpiar'>
								<input type="button" id='btn_invol_atr' class='btn_hg btnAzul3 btn_invol_0' 							style='width:132px;margin-left:30px;'  	value='Atrás'>
								<input type="button" id='btn_invol_ace' class='btn_hg btnVerde btn_invol_2 oculto deshabilitado' 		style='width:132px;' 					value='Aceptar' disabled>
								<input type="button" id='btn_invol_can' class='btn_hg btnRojo btn_invol_2 oculto' 						style='width:132px;margin-left:30px;' 	value='Cancelar'>
							</div>
						</div>
					</div> 
				</div>
				<div id='ficha_documento' class='oculto'>
					<div class='div-tbl'>
						<div class="div-tbl-fi" style="height: 30px;">
							<div class="modal_titulo div-tbl-co" style='width:620px;'>- Agregar Documento -</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Tipo Doc.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<select id="selDocumento" style='width:140px;'>
									<option value="0" selected>SELECCIONAR</option>
									<option value="[tipoDoc.id;block=option;noerr]">
										[tipoDoc.desc;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Número.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:140px;'>
								<input type="text" id='doc_numero' class='div-inp-ena'>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Fecha.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:114px;'>
								<input type="text" id='doc_fecha' class='div-inp-dis' onchange='validaFecha(this.value);' disabled>
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content:center;'>
								<input type="image" id='btn_doc_fecha' src="multimedia/imagen/icono/calendar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:60px;">
							<div class="div-tbl-co" style='width:calc(100% - 40px);left:20px;justify-content:center;'>
								<input type="button" id='btn_doc_agr' class='btn_hg btnAzul btn_invol_0' 	style='width:132px;cursor:pointer;' 	value='Agregar'>
								<input type="button" id='btn_doc_atr' class='btn_hg btnAzul3 btn_invol_0' 	style='width:132px;margin-left:30px;'  	value='Atrás'>
							</div>
						</div>
					</div> 
				</div>
				<div id='ficha_material' class='oculto'>
					<div class='div-tbl'>
						<div class="div-tbl-fi" style="height: 30px;">
							<div class="modal_titulo div-tbl-co" style='width:620px;'>- Agregar Material Comisado -</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Material:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<select id="selMaterial" style="width:200px">
									<option value="0" selected>SELECCIONAR</option>
									<option value="[tipoMat.id;block=option;noerr]">
										[tipoMat.desc;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Cantidad:' disabled>
							</div>
							<div class="div-tbl-co" style='width:120px;'>
								<input type="text" id='mat_cant' class='div-inp-ena'>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Unidad:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<select id="selUnidad" style='width:120px;'>
									<option value="0" selected>SELECCIONAR</option>
									<option value="[unidad.id;block=option;noerr]">
										[unidad.desc;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Precinto.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:200px;'>
								<input type="text" id='mat_prec' class='div-inp-ena'>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:90px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Observ.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:460px;'>
								<textarea  id="mat_descrip" class = 'div-inp-ena' style="position:relative;width:100%;resize:none;"></textarea>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:60px;">
							<div class="div-tbl-co" style='width:calc(100% - 40px);left:20px;justify-content:center;'>
								<input type="button" id='btn_mat_agr' class='btn_hg btnAzul btn_invol_0' 	style='width:132px;cursor:pointer;' 	value='Agregar'>
								<input type="button" id='btn_mat_atr' class='btn_hg btnAzul3 btn_invol_0' 	style='width:132px;margin-left:30px;'  	value='Atrás'>
							</div>
						</div>
					</div> 
				</div>
				<div id='ficha_medio' class='oculto'>
					<div class='div-tbl'>
						<div class="div-tbl-fi" style="height: 30px;">
							<div class="modal_titulo div-tbl-co" style='width:620px;'>- Agregar Medio de Comisión -</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Medio:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<select id="selMedio" style="width:200px">
									<option value="0" selected>SELECCIONAR</option>
									<option value="[tipoMed.id;block=option;noerr]">
										[tipoMed.desc;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Cantidad:' disabled>
							</div>
							<div class="div-tbl-co" style='width:120px;'>
								<input type="text" id='med_cant' class='div-inp-ena'>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Precinto.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:200px;'>
								<input type="text" id='med_prec' class='div-inp-ena'>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:90px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Observ.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:460px;'>
								<textarea  id="med_descrip" class = 'div-inp-ena' style="position:relative;width:100%;resize:none;"></textarea>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:60px;">
							<div class="div-tbl-co" style='width:calc(100% - 40px);left:20px;justify-content:center;'>
								<input type="button" id='btn_med_agr' class='btn_hg btnAzul btn_invol_0' 	style='width:132px;cursor:pointer;' 	value='Agregar'>
								<input type="button" id='btn_med_atr' class='btn_hg btnAzul3 btn_invol_0' 	style='width:132px;margin-left:30px;'  	value='Atrás'>
							</div>
						</div>
					</div> 
				</div>
				<div id='ficha_vehiculo' class='oculto'>
					<div class='div-tbl'>
						<div class="div-tbl-fi" style="height: 30px;">
							<div class="modal_titulo div-tbl-co" style='width:620px;'>- Agregar Vehículo (Medio de Comisión) -</div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi oculto">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Id Veh.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:120px;'>
								<input type="text" id='veh_id' class='div-inp-dis' disabled>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Placa:' disabled>
							</div>
							<div class="div-tbl-co" style='width:140px;'>
								<input type="text" id='veh_placa' class='div-inp-ena' >
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content: center'>
								<input type="image" id='btn_busq_placa' src="multimedia/imagen/icono/buscar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Tipo:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<select id="selTipoVehi" style="width:170px" disabled>
									<option value="0" selected>SELECCIONAR</option>
									<option value="[tipoVehi.id;block=option;noerr]">
										[tipoVehi.desc;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Marca:' disabled>
							</div>
							<div class="div-tbl-co" style='width:220px;'>
								<select id="selMarca" style="width:170px" disabled>
									<option value="0" selected>SELECCIONAR</option>
									<option value="[marca.id;block=option;noerr]">
										[marca.desc;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Modelo:' disabled>
							</div>
							<div class="div-tbl-co" style='width:120px;'>
								<input type="text" id='veh_modelo' class='div-inp-dis' disabled>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Color:' disabled>
							</div>
							<div class="div-tbl-co" style='width:120px;'>
								<input type="text" id='veh_color' class='div-inp-dis' disabled>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:90px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' value='Observ.:' disabled>
							</div>
							<div class="div-tbl-co" style='width:460px;'>
								<textarea  id="veh_descrip" class = 'div-inp-dis' style="position:relative;width:100%;resize:none;" disabled></textarea>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:60px;">
							<div class="div-tbl-co" style='width:calc(100% - 40px);left:20px;justify-content:center;'>
								<input type="button" id='btn_veh_agr' 	class='btn_hg btnAzul btn_invol_0' 				style='width:132px;cursor:pointer;' 	value='Agregar'>
								<input type="button" id='btn_veh_lim' 	class='btn_hg btnCeleste btn_invol_0 oculto' 	style='width:132px;margin-left:30px;'  	value='Limpiar'>
								<input type="button" id='btn_veh_atr' 	class='btn_hg btnAzul3 btn_invol_0' 			style='width:132px;margin-left:30px;'  	value='Atrás'>
							</div>
						</div>
					</div> 
				</div>
				<div id='ficha_sancion_medida' class='oculto'>
					<div class='div-tbl'>
						<div class="div-tbl-fi" style="height: 30px;">
							<div class="modal_titulo div-tbl-co tit_sancion" style='width:680px;'></div>
						</div>
						<div class="div-tbl-fi" style="height: 10px;"></div>
						<div class="div-tbl-fi oculto">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:130px;'>
								<input type="text" class='div-inp-trans' value='Id:' disabled>
							</div>
							<div class="div-tbl-co" style='width:120px;'>
								<input type="text" id='rel_san_med_id' class='div-inp-dis' disabled>
							</div>
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:130px;'>
								<input type="text" class='div-inp-trans' value='Id Infractor:' disabled>
							</div>
							<div class="div-tbl-co" style='width:120px;'>
								<input type="text" id='san_med_infractor_id' class='div-inp-dis' disabled>
							</div>
						</div>
						<div class="div-tbl-fi fi_san">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:130px;'>
								<input type="text" class='div-inp-trans' value='Sanción Aplicada:' disabled>
							</div>
							<div class="div-tbl-co" style='width:505px;'>
								<select id="selSancion">
									<option value="0" selected>SELECCIONAR</option>
									<option value="[sancion.id;block=option;noerr]" class='[sancion.tipo;noerr;]'>
										[sancion.desc;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi fi_med">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:130px;'>
								<input type="text" class='div-inp-trans' value='Medida Cautelar:' disabled>
							</div>
							<div class="div-tbl-co" style='width:505px;'>
								<select id="selMedida">
									<option value="0" selected>SELECCIONAR</option>
									<option value="[medida.id;block=option;noerr]">
										[medida.desc;noerr]
									</option>
								</select>
							</div>
						</div>
						<div class="div-tbl-fi">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:130px;'>
								<input type="text" class='div-inp-trans' value='Fecha Aplicación:' disabled>
							</div>
							<div class="div-tbl-co" style='width:114px;'>
								<input type="text" id='sanc_fecha' class='div-inp-dis' onchange='validaFecha(this.value);' disabled>
							</div>
							<div class="div-tbl-co" style='width:30px;justify-content:center;'>
								<input type="image" id='btn_sanc_fecha' src="multimedia/imagen/icono/calendar.png" class='btn_general' style='width:23px;height:23px;'>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:90px;">
							<div class="div-tbl-co" style='width:20px;'></div>
							<div class="div-tbl-co" style='width:130px;'>
								<input type="text" class='div-inp-trans' value='Observación:' disabled>
							</div>
							<div class="div-tbl-co" style='width:505px;'>
								<textarea  id="sanc_observ" class = 'div-inp-ena' style="position:relative;width:100%;resize:none;"></textarea>
							</div>
						</div>
						<div class="div-tbl-fi" style="height:60px;">
							<div class="div-tbl-co" style='width:calc(100% - 40px);left:20px;justify-content:center;'>
								<input type="button" id='btn_san_apl' class='btn_hg btnAzul btn_invol_0' 	style='width:132px;cursor:pointer;' 	value='Aplicar'>
								<input type="button" id='btn_san_atr' class='btn_hg btnAzul3 btn_invol_0' 	style='width:132px;margin-left:30px;'  	value='Atrás'>
							</div>
						</div>
					</div> 
				</div>
            </div>
			<div class='preview' style="visibility: hidden;">
				<input type="image" class='img-preview'>
			</div>
			<div class='conexion'>

			</div>
		</div>    
	</body>
</html>