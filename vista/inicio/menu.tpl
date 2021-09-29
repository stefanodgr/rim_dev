<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Menú Principal</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>

        <!-- -------------------------------- INCLUSIÓN DE ESTILOS -------------------------------- -->
            <link href="libreria/fileuploader/css/jquery.fileuploader.css" 						media="all" rel="stylesheet">
			<link href="libreria/fileuploader/css/jquery.fileuploader-theme-thumbnails.css" 	media="all" rel="stylesheet">
            <link href="libreria/bootstrap/css/bootstrap.css"   rel="stylesheet"    type="text/css"/>
            <link href="libreria/hg/css/datetimepicker.css"	    rel="stylesheet"	type="text/css"/>
			<link href="libreria/hg/css/hg_buttons.css"			rel="stylesheet"	type="text/css"/>
			<link href="libreria/hg/css/hg_table_div.css"	    rel="stylesheet"	type="text/css"/>
            <link href="css/menu.css?[var.nocache]"             rel="stylesheet" 	type="text/css"/>
            <link href="css/contenedor.css?[var.nocache]"		rel="stylesheet"	type="text/css"/>
			<link href="css/infractor.css?[var.nocache]"		rel="stylesheet"	type="text/css"/>
			<link href="css/infraccion.css?[var.nocache]"		rel="stylesheet"	type="text/css"/>
			<link href="css/auditoria.css?[var.nocache]" 		rel="stylesheet"	type="text/css"/>
			<link href="css/referencial.css?[var.nocache]" 	    rel="stylesheet"	type="text/css"/>
        <!-- -------------------------------------------------------------------------------------- -->

        <!-- -------------------------------- INCLUSIÓN DE SCRIPTS -------------------------------- -->
            <script src="libreria/bootstrap/js/bootstrap.js" 	                type="text/javascript"></script>
			<script src="libreria/hg/js/datetimepicker.js"	                    type="text/javascript"></script>
            <script src="libreria/fileuploader/js/jquery.fileuploader.min.js"   type="text/javascript"></script>
			<script src="libreria/hg/js/hg_funciones.js"	 	                type="text/javascript"></script>
            <script src="js/menu.js?[var.nocache]" 						        type="text/javascript"></script> 
			<script src="js/funciones.js?[var.nocache]" 					    type="text/javascript"></script> 
			<script src="js/infractor.js?[var.nocache]" 					    type="text/javascript"></script> 
			<script src="js/infraccion.js?[var.nocache]" 					    type="text/javascript"></script>
			<script src="js/auditoria.js?[var.nocache]"   				        type="text/javascript"></script>
        <!-- -------------------------------------------------------------------------------------- -->
    </head>
    <body>
        <div class = "menu">     
            <div class = 'div_inf'>
                <div id='usu_ico'><i class="fa fa-user"></i></div>
                <input type="text" id='inp_inf_usu' value='Usuario:' disabled>
                <input type="text" id='inp_inf_usu_val' value='[var.usuario;noerr;]' disabled><br>
                <div id='perf_ico'><i class="fa fa-male"></i></div>
                <input type="text" id='inp_inf_perfil' value='Perfil:' disabled>
                <input type="text" id='inp_inf_perfil_val' value='[var.perfil;noerr;]' disabled>
            </div>
            <div class = "div_conex [var.conexVisible;if [val]='visible';then '';else 'oculto';noerr;]">
                <div id='conex_ico'><i class="fa fa-users" style="cursor:pointer;"></i></div>
                <input type="text" id='inp_inf_conex'       value='Usuarios Conectados:'        style="cursor:pointer;" disabled>
                <input type="text" id='inp_inf_conex_val'   value='[var.nroConexiones;noerr;]'  style="cursor:pointer;" disabled>
            </div>
            <div class = "div_conex_accion [var.conexVisible;if [val]='visible';then '';else 'oculto';noerr;]"></div>

            <!--<div class='menu_nombre'>Menú</div>-->
            <!-- MENÚ DEL SISTEMA -->
            <div class="panel-group">
                <div class="panel panel-default" id='[menu.id;sub1=(items);block=div;magnet=div]'>
                    <div id = 'opcion_[menu.titulo;noerr]' class="panel-heading" name='[menu.url;noerr]' data-toggle="collapse" data-parent="#[menu.padre]" href="#[menu.hijo]">
                        <div style="width: 40px;height: 100%;text-align: left;">
                            <img src='[menu.imagen;magnet=img]' class='glyphicon icon-menu'/>
                        </div>
                        <div style="width: calc(100% - 35px);height: 100%;">
                            <span class = 'item'>[menu.titulo]</span>
                        </div>
                    </div>
                    <div id="[menu.hijo]" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td class='opcion' name='[menu_sub1.url;noerr;]' style="display: flex;align-items: center;justify-content: center;">
                                        <div style="width: calc(100% - 25px);height: 100%;">
                                            <span class = 'item' >[menu_sub1.titulo;block=tr]</span>
                                        </div>
                                        <div style="width: 25px;height: 100%;text-align: right;">
                                            <i class="fa fa-chevron-right"></i>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>   
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" name='Cerrar Sesión' data-toggle="collapse">
                        <div style="width: 40px;height: 100%;text-align: left;">
                            <img src='multimedia/imagen/menu/salir.png' class='glyphicon icon-menu'/>
                        </div>
                        <div style="width: calc(100% - 35px);height: 100%;">
                            <span class = 'item'>Cerrar Sesión</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------------------------------- -->
        </div>
    </body>
</html>