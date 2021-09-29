<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
		
		<!-- -------------------------------- INCLUSIÓN DE ESTILOS -------------------------------- -->
		<!-- -------------------------------------------------------------------------------------- -->
		
		<!-- -------------------------------- INCLUSIÓN DE SCRIPTS -------------------------------- -->
		<!-- -------------------------------------------------------------------------------------- -->
			
		<!-- -------------------------------- FUNCIONES JAVASCRIPT -------------------------------- -->
			<script type="text/javascript">
               consultarAuditoria(true);
            </script>  
            
		<!-- -------------------------------------------------------------------------------------- -->
	</head>
	<body>
        <!--id="btnCrear_ref" class="btn_dtb" src="../../libreria/hg/images/dtb_agregar.png" title="Nuevo Registro" onclick="agregarFila('tbl');" type="image"-->
		<div class='contenedor'>
			<div class='titulo'>
                <div>[var.titulo;noerr;] :.</div>
                <div>
                    <input type='image' id='toggle_menu' src="multimedia/imagen/icono/menu.png" style="width:15px;height:15px;transition-duration: 0.5s;">
                </div>
            </div>
            <div class='contenido'>		
                <div id='div_filtros'>
                    <div class='div-tbl'>
                        <div class="div-tbl-fi" style="height:10px;"></div>
                        <div class="div-tbl-fi" style="justify-content:center;">
						    <div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Acción:'>
							</div>
							<div class="div-tbl-co" style='width:170px;'>
								<select id="selTipoAud" style='font-weight: bold;'>
									<option value="0" selected>TODAS</option>
									<option value="[tipoAuditoria.tipoId;block=option;noerr]">[tipoAuditoria.tipoDesc;noerr]</option>
								</select>
							</div>
                            <div class="div-tbl-co" style='width:30px;'></div>
                            <div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Período:'>
							</div>
							<div class="div-tbl-co" style='width:170px;'>
								<select id="selFecha" style='font-weight: bold;'>
                                    <option  value="HOY" selected onclick="cambiaFecha(this.value);">HOY</option>
                                    <option id='opt_hoy' value="AYER" onclick="cambiaFecha(this.value);">AYER</option>
                                    <option value="SEMANA ACTUAL" onclick="cambiaFecha(this.value);">SEMANA ACTUAL</option>
                                </select>
							</div>
                        </div>
                        <div class="div-tbl-fi" style="justify-content:center;">
                            <div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Desde:'>
							</div>
                            <div class="div-tbl-co" style='width:140px;'>
                                <input type="text" id='f_desde'class='div-inp-dis' disabled>
                            </div>
                            <div class="div-tbl-co" style='width:30px;justify-content:center;'>
                                <input type="image" id='btn_f_desde' src="multimedia/imagen/icono/calendar.png" class='btn_general' style='width:23px;height:23px;'>
                            </div>
                            <div class="div-tbl-co" style='width:30px;'></div>
                            <div class="div-tbl-co" style='width:80px;'>
								<input type="text" class='div-inp-trans' disabled value='Hasta:'>
							</div>
                            <div class="div-tbl-co" style='width:140px;'>
                                <input type="text" id='f_hasta' class='div-inp-dis' disabled>
                            </div>
                            <div class="div-tbl-co" style='width:30px;justify-content:center;'>
                                <input type="image" id='btn_f_hasta' src="multimedia/imagen/icono/calendar.png" class='btn_general' style='width:23px;height:23px;'>
                            </div>
                        </div>
                        <div class="div-tbl-fi" style="height:50px;justify-content: center;">
                            <div class="div-tbl-co" style='width:150px;justify-content: center;'>
                                <input type="button" id='btn_auditoria_bus' class='btn_hg btnAzul2' style='width:120px;' value='Consultar'>
                            </div>
                        </div>
                    </div>
                </div>	
                <div id='div_tbl_aud'>
                    <iframe id='ifr_aud' name='ifr_aud' src='controlador/auditoria/auditoria.php?case=1' scrolling='no'></iframe>
                </div>		
            </div>
		</div>    
	</body>
</html>