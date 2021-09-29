<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
		
		<!-- -------------------------------- INCLUSIÓN DE ESTILOS -------------------------------- -->
		<!-- -------------------------------------------------------------------------------------- -->
		
		<!-- -------------------------------- INCLUSIÓN DE SCRIPTS -------------------------------- -->
		<!-- -------------------------------------------------------------------------------------- -->
			
		<!-- -------------------------------- FUNCIONES JAVASCRIPT -------------------------------- -->
		<!-- -------------------------------------------------------------------------------------- -->
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
                <div id='div_ref'>
                    <iframe id='ifr_ref' name='ifr_ref' src='[var.rutaReferencial;noerr;]' scrolling='no'></iframe>
                </div>
				<div id='div_ref_aux' class='oculto'>
                    <iframe id='ifr_ref_aux' name='ifr_ref_aux' scrolling='no'></iframe>
                </div>
            </div>
		</div>    
	</body>
</html>