<!DOCTYPE html>
<html>
	<head>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Héctor González">
		
		<title>[var.descTabla;noerr;]</title>
		<!------------------------------------------ INCLUSION DE HOJAS DE ESTILO --------------------------------------------- -->
			<link href = "[var.rutaDir]libreria/hg/css/datetimepicker.css" 		rel="stylesheet" type="text/css"/>
			<link href = "[var.rutaDir]libreria/hg/css/timepicker.css" 			rel="stylesheet" type="text/css"/>
			<link href = "[var.rutaDir]libreria/hg/css/hg_dtb.css" 				rel="stylesheet" type="text/css"/>
			<link href = "[var.rutaDir]libreria/hg/css/hg_table_div.css"		rel="stylesheet" type="text/css"/>
			<style type="text/css"></style>
		<!-- ------------------------------------------------------------------------------------------------------------------ -->
		<!-------------------------------------- INCLUSION DE ARCHIVOS Y LIBRERIAS JS ----------------------------------------- -->
			<script 		src="[var.rutaDir]libreria/hg/js/jquery.js" 			type="text/javascript"></script>
			<script 		src="[var.rutaDir]libreria/hg/js/dataTables.js" 		type="text/javascript"></script>	
			<script 		src="[var.rutaDir]libreria/hg/js/datetimepicker.js" 	type="text/javascript"></script>
			<script 		src="[var.rutaDir]libreria/hg/js/timepicker.js" 		type="text/javascript"></script>
			<script defer 	src="[var.rutaDir]libreria/hg/js/hg_dtb.js" 			type="text/javascript"></script>
		<!-- ------------------------------------------------------------------------------------------------------------------ -->

		<script type="text/javascript">
			$(document).ready(function() {
			    var tabla = $('#tbl').DataTable({
					"bJQueryUI": 		true,
					"bProcessing": 		true,
					"bPaginate": 		'[var.opcDtbPag;noerr]',
					"sPaginationType": 	'[var.opcDtbPagTyp;noerr]',
					"bLengthChange": 	false,
					"bFilter": 			'[var.opcDtbFil;noerr]',
					"bSort": 			true,
					"bInfo": 			'[var.opcDtbInf;noerr]',
					"bAutoWidth": 		false,
					"iDisplayLength": 	parseInt('[var.opcDtbCanFil;noerr]'),
					"columnDefs":     	[{ targets: 'hidden', className: 'hCol'}],
		         	"sAjaxSource": 		"[var.rutaJson;htmlconv=no;noerr]",
					"rowId": 			'id',
					"sClass":			'clase',
					"fnDrawCallback": function(data,fila){
						verifModPend();
						$('#cantReg').val(''); 
						$('#idUltReg').val('');
						dimensiones();
					},
					"fnInitComplete": function(){
						pintarFilas		("tbl");
						if ('[var.ctrlBtnTipo;noerr]' == 'A') crearCoordenadas("tbl");
						else $('#ctrlReady').val('1');
						agregarTblTitulo('[var.descTabla;noerr;]','[var.sWTitulo;noerr;]','[var.opcDtbFil;noerr]','[var.sWSearch;noerr;]');
						agregarTblBtn	('[var.rutaDir]','[var.opcDtbPag;noerr]');
						loadFnDtb();
						dimensiones();
					}
				});
			});
		</script>
	</head>
	<body>
		<!-- -------------------------------------------------- DATATABLE ---------------------------------------------------- -->
		<table id="tbl">
			<thead>
				<tr>
					<th id='[dtsTbl.header;noerr;]' name='[dtsTbl.encabezado;noerr;]' abbr='[dtsTbl.columna;noerr;]' class='[dtsTbl.tipo;noerr;] [dtsTbl.formato;noerr;] [dtsTbl.relacion;noerr;] [dtsTbl.default;noerr;] [dtsTbl.visible;noerr;]' style='width:30px;'><strong>[dtsTbl.encabezado;noerr;block=th]</strong></th>
				</tr>
			</thead>
		</table>
		<!-- --------------------------------------- AREA DE CAMPOS DE CONTROL DEL TPL --------------------------------------- -->
		<div id = 'control'	style="display:none;">
			<table id = 'tblDatos' class="display" border="1" width="100%" bordercolor="#CCCCCC" style="font-size: 12px;font-family: sans-serif;">
				<tr>
					<th align="center" colspan="11"><strong>DATOS DE LA TABLA</strong></th>				
				</tr>
				<tr>
					<th align="center"><strong>Tabla</strong></th>
					<th align="center"><strong>Campo PK</strong></th>
					<th align="center"><strong>Tipo Campo PK</strong></th>
					<th align="center"><strong>Pantalla</strong></th>
					<th align="center"><strong>Cant. de Registros</strong></th>
					<th align="center"><strong>Valor Ult. ID</strong></th>
					<th align="center"><strong>Límite de Filas</strong></th>	
					<th align="center"><strong>Funciones DTB</strong></th>
					<th align="center"><strong>Tipo de Botón</strong></th>
					<th align="center"><strong>JSON</strong></th>		
					<th align="center"><strong>Ready</strong></th>
					<th align="center"><strong>Informacion</strong></th>	
				</tr>
				<tr>
					<td>
						<input type="text" id = 'nombreTabla' 	disabled="disabled"	value = '[var.nombreTabla;noerr]' 	style="width:100%;">
					</td>
					<td>
						<input type="text" id = 'idTabla'	 	disabled="disabled"	value = '[var.idTabla;noerr]' 		style="width:100%;">
					</td>
					<td>
						<input type="text" id = 'tipoCampPk'	disabled="disabled"	value = '[var.tipoCampoPk;noerr]' 	style="width:100%;">
					</td>
					<td>
						<input type="text" id = 'siglas' 		disabled="disabled"	value = '[var.siglas;noerr]'		style="width:100%;"> 
					</td>	
					<td>
						<input type="text" id = 'cantReg' 		disabled="disabled"	style = "width:100%;"> 
					</td>
					<td>
						<input type="text" id = 'idUltReg' 		disabled="disabled"	style = "width:100%;"> 
					</td>		
					<td>
						<input type="text" id = 'lmtFilas' 		disabled="disabled"	value = '[var.opcDtbCanFil;noerr]' 	style = "width:100%;"> 
					</td>	
					<td>
						<input type="text" id = 'ctrlFunDtb' 	disabled="disabled"	value = '[var.ctrlFuncion;noerr]' 	style = "width:100%;"> 
					</td>		
					<td>
						<input type="text" id = 'tipoBtnDtb' 	disabled="disabled"	value = '[var.ctrlBtnTipo;noerr]' 	style = "width:100%;"> 
					</td>
					<td>
						<input type="text" id = 'ctrlJson' 		disabled="disabled"	value = '[var.rutaJson;noerr]' 		style = "width:100%;"> 
					</td>
					<td>
						<input type="text" id = 'ctrlReady' 	disabled="disabled"	value = '0' 						style = "width:100%;"> 
					</td>
					<td>
						<input type="text" id = 'ctrlInf' 		disabled="disabled"	value = '[var.opcDtbInf;noerr]' 	style = "width:100%;"> 
					</td>
				</tr>	
			</table>
		</div>
		<div id = 'control2' style="display: none;">
			<table id="tbl2" class="display" border="1" width="100%" bordercolor="#CCCCCC" style="font-size: 12px;font-family: sans-serif;">
				<thead>
					<tr>
						<th align="center"></th>
						<th align="center"><strong>Arreglos</strong></th>
						<th align="center"><strong>Actual</strong></th>
						<th align="center"><strong>Inicial</strong></th>
						<th align="center"><strong>Anterior</strong></th>
						<th align="center"><strong>Nuevo</strong></th>					
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width: 3cm">
							Id de Celda:
						</td>
						<td>
							<input type="text" id = "arrId" style="width:100%" disabled="disabled"></input>
						</td>
						<td>
							<input type="text" id = 'idActual' style="width:100%" disabled="disabled"></input>
						</td>
						<td></td>
						<td></td>
						<td>
							<input type="text" id = 'idModificado' style="width:100%" disabled="disabled"></input>
						</td>						
					</tr>
					<tr>
						<td style="width: 3cm">
							Valores:
						</td>
						<td>
							<input type="text" id = "arrVal" style="width:100%" disabled="disabled"></input>
						</td>
						<td>
							<input type="text" id = 'valActual' style="width:100%" disabled="disabled"></input>
						</td>
						<td>
							<input type="text" id = 'arrInicial' style="width:100%" disabled="disabled"></input>
						</td>
						<td>
							<input type="text" id = 'valAnterior' style="width:100%" disabled="disabled"></input>
						</td>
						<td>
							<input type="text" id = 'valNuevo' style="width:100%" disabled="disabled"></input>
						</td>					
					</tr>
					<tr>
						<td style="width: 3cm">
							Campos de la BD:
						</td>
						<td>
							<input type="text" id = "arrCamp" style="width:100%" disabled="disabled"></input>
						</td>
						<td>
							<input type="text" id = 'campoActual' style="width:100%" disabled="disabled"></input>
						</td>
						<td></td>
						<td></td>
						<td>
							<input type="text" id = 'campoModificado' style="width:100%" disabled="disabled"></input>
						</td>
					</tr>
					<tr>
						<td style="width: 3cm">
							Id Registro:
						</td>
						<td>
							<input type="text" id = "arrIdReg" 	style="width:100%" disabled="disabled"></input>
						</td>
						<td>
							<input type="text" id = 'regActual' style="width:100%" disabled="disabled"></input>
						</td>
						<td></td>
						<td></td>
						<td>
							<input type="text" id = 'regModificado' style="width:100%" disabled="disabled"></input>
						</td>
					</tr>
					<tr>
						<td style="width: 3cm">
							Pos. Registro:
						</td>
						<td>
							<input type="text" id = "arrPos" style="width:100%" disabled="disabled"></input>
						</td>
						<td>
							<input type="text" id = 'posActual' style="width:100%" disabled="disabled"></input>
						</td>
						<td></td>
						<td></td>
						<td>
							<input type="text" id = 'posModificado' style="width:100%" disabled="disabled"></input>
						</td>
					</tr>
					<tr>
						<td style="width: 3cm">
							Reg. a Gestionar:
						</td>
						<td>
							<input type="text" id = "arrRegGest" style="width:100%" disabled="disabled"></input>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div> 
		 
		<div id = 'control3' 	style="display:none;">
			<table id="tbl3" class="display tabla" border="1" bordercolor="#CCCCCC">
				<tr>
					<th align="center" colspan="7"><strong>DATOS EXTERNOS Y DE TABLA RELACIÓN</strong></th>			
				</tr>
				<tr>	
					<td>Datos</td>
					<td>
						<input type="text" id = 'cmpExtTbl'     disabled="disabled" style = "width:100%;" value = '[var.cmpExtTbl;noerr]'></input>
					</td>
					<td>
						<input type="text" id = 'valExtTbl' 	disabled="disabled" style = "width:100%;" value = '[var.valExtTbl;noerr]'></input>
					</td>
					<td>
						<input type="text" id = 'nombTblRel' 	disabled="disabled" style = "width:100%;" value = '[var.nombTblRel;noerr]'></input>
					</td>
                    <td>
						<input type="text" id = 'cmpRefTbl' 	disabled="disabled" style = "width:100%;" value = '[var.cmpRefTbl;noerr]'></input>
					</td>
					<td>
						<input type="text" id = 'cmpTblRel' 	disabled="disabled" style = "width:100%;" value = '[var.cmpTblRel;noerr]'></input>
					</td>
                    <td>
						<input type="text" id = 'valTblRel' 	disabled="disabled" style = "width:100%;" value = '[var.valTblRel;noerr]'></input>
					</td>
					<td>
						<input type="text" id = 'cmpWrExtTbl' 	disabled="disabled" style = "width:100%;" value = '[var.cmpWrExtTbl;noerr]'></input>
					</td>
					<td>
						<input type="text" id = 'valWrExtTbl' 	disabled="disabled" style = "width:100%;" value = '[var.valWrExtTbl;noerr]'></input>
					</td>
				</tr>
			</table>
		</div>

		<div id = 'control4' 	style="display:none ">
			<table id = 'tbl4' class="display tabla" border="1" bordercolor="#CCCCCC">
				<tr>
					<th align="center" colspan="6"><strong>Utility</strong></th>			
				</tr>
				<tr>
					<td>Utility</td>
					<td>
						<input type="text" id = 'utility1' 	disabled = "disabled" style="width:100%;" value = '[var.util1;noerr;]'></input>
					</td>
					<td>
						<input type="text" id = 'utility2' 	disabled = "disabled" style="width:100%;" value = '[var.util2;noerr;]'></input>
					</td>
					<td>
						<input type="text" id = 'utility3' 	disabled = "disabled" style="width:100%;" value = '[var.util3;noerr;]'></input>
					</td>
					<td>
						<input type="text" id = 'utility4' 	disabled = "disabled" style="width:100%;" value = '[var.util4;noerr;]'></input>
					</td>
					<td>
						<input type="text" id = 'utility5' 	disabled = "disabled" style="width:100%;" value = '[var.util5;noerr;]'></input>
					</td>
				</tr>
				<tr>
					<td>Utility</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</div> 
		<div id = 'control5' style="display:none">
			<table id = 'tbl5' class="tabla" border="1" bordercolor="#CCCCCC">
				<tr>
					<th align="center" colspan="6"><strong>Listas (Select)</strong></th>			
				</tr>
				<tr>
					<td>Select</td>
					<td>
						<select style="width:100%;" id='sel_[select.columna; sub1=(opcion); block=td; noerr]' name='[select.editable; if [val]=1; then sel_editable; noerr]'>
                            <option id='[select_sub1.id; block=option; noerr]'>[select_sub1.valor; noerr]</option>
				    	</select>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>