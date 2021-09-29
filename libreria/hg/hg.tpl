<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
	<head>
		<meta charset="UTF-8">
		<title>[var.titulo;noerr]</title>
		
		<!------------------------------------------ INCLUSION DE HOJAS DE ESTILO --------------------------------------------- -->

		<!--<link href = "[var.rutaDir]estilos/estilo_general.css" rel="stylesheet" type="text/css"/>-->
		
		<style type="text/css">
            #contenedor{
                position: relative;
                width: 100%;
                height: 100%;	
                margin: auto;
                z-index: 0;
                /*background-color: #424242;*/
            }
			#divDtb{
				position: relative;
				/*border:1px solid red;*/
			}
			#frameDtb{
				position: relative;
	 			border: none;
				width: 100%;
				height: 100%;
				overflow-y: hidden;
			}
		</style>
		<script type="text/javascript">
			function reloadTbl(siglas){
				var iframe = document.getElementById('frameDtb');
				iframe.src='[var.rutaControlador]?estado=1';
			}
			function ajustarIframe(ancho,alto){
				var tu = document.getElementById('divDtb');
				tu.style.height = alto;
			}
			// function apertura(siglas,idReg,elementTr,elementTd){
			// 	alert(siglas+" -- "+idReg+" -- "+elementTr+" -- "+elementTd);
			// 	alert(elementTr.id);
			// }
		</script>
<!-- ------------------------------------------------------------------------------------------------------------------ -->	
	</head>
	<body onload="reloadTbl();">	
		<div id = 'contenedor' >
            <div id = 'divDtb'>
                <iframe id= 'frameDtb' scrolling="no"></iframe>
            </div>	
		</div>
	</body>
</html>