/* ------------------------------- FUNCIONES JS UTILIZADAS EN EL MÓDULO AUDITORÍA ------------------------------- */
	$(document).ready(function(){
		$('#panel_right').on('click','#btn_auditoria_bus',function(){
			consultarAuditoria();
		});
	});

	function bisiesto(ano) {
	if ((ano<1900)||(ano>2100)) return false;
	return (((ano % 4 == 0) && (ano % 100 != 0)) || (ano % 400 == 0))
	}
	function restarDias(fecha, diasRestar){
			var fecha2=fecha;
			//alert('fechaaaRestar'+fecha);
			var milisecRestar= parseInt(diasRestar *24*60*60*1000); 
			fecha2.setTime(fecha2.getTime()-milisecRestar);
			//alert('fechaaaRestar'+fecha);
			return fecha2; 
	}
	function sumarDias(fecha, diasSumar){ 
			var fecha2=fecha;
			//alert('fechaaaSumar'+fecha);
			var milisecSumar= parseInt(diasSumar *24*60*60*1000); 
			fecha2.setTime(fecha2.getTime()+milisecSumar);
			//alert('fechaaaSumar'+fecha);
			return fecha2; 
	}	
	function cambiaFecha(valor){
		//alert(valor);
		miFechaActual = new Date();
		dia = miFechaActual.getDate();
		mes = parseInt(miFechaActual.getMonth()) + 1 ;
		ano = miFechaActual.getFullYear();
		anobisiesto=bisiesto(ano);
		
		if(valor=='HOY'){
			if(dia<10) dia='0'+dia;
			if(mes<10) mes='0'+mes;
			fecha = dia + '-' + mes + '-' + ano;
			document.getElementById('f_desde').value=fecha;
			document.getElementById('f_hasta').value=fecha;
		}
		if(valor=='AYER'){
			if(dia==1 && mes==1) dia=31;
			else if(dia==1 && mes==2) dia=31;
			else if(dia==1 && mes==3) if(anobisiesto) dia=29;else dia=28;
			else if(dia==1 && mes==4) dia=31;
			else if(dia==1 && mes==5) dia=30;
			else if(dia==1 && mes==6) dia=31;
			else if(dia==1 && mes==7) dia=30;
			else if(dia==1 && mes==8) dia=31;
			else if(dia==1 && mes==9) dia=31;
			else if(dia==1 && mes==10) dia=30;
			else if(dia==1 && mes==11) dia=31;
			else if(dia==1 && mes==12) dia=30;
			else dia=dia-1;
			if(dia<10) dia='0'+dia;
			
			if(mes<10) mes='0'+mes;
			fecha = dia + '-' + mes + '-' + ano;
			document.getElementById('f_desde').value=fecha;
			document.getElementById('f_hasta').value=fecha;
		}
		var numdiasemana= miFechaActual.getDay();
		var diasadescontar= numdiasemana - 1;
		
		//OPCIONES PARA SEMANA ACTUAL
		//alert('miFechaActual: ' + miFechaActual);
		var fechainiciosemana = restarDias(miFechaActual, diasadescontar);
		//alert('miFechaActual: ' + miFechaActual);
		var fechainiciosemana2=fechainiciosemana;
		var fechainiciosemana3=fechainiciosemana;
		//alert('fechainiciosemana3: ' + fechainiciosemana3);
		var diainiciosemana=fechainiciosemana.getDate();
		//alert('diainiciosemana: ' + diainiciosemana);
		//if(diainiciosemana<10) diainiciosemana='0'+diainiciosemana;
		var mesiniciosemana = parseInt(fechainiciosemana.getMonth()) + 1 ;
		if(mesiniciosemana<10) mesiniciosemana='0'+mesiniciosemana;
		var annoiniciosemana = fechainiciosemana.getFullYear();
		
		
		var fechafinsemana= sumarDias(fechainiciosemana2, 4);
		
		var diafinsemana=fechafinsemana.getDate();
		//if(diafinsemana<10) diafinsemana='0'+diafinsemana;
		var mesfinsemana = parseInt(fechafinsemana.getMonth()) + 1 ;
		//if(mesfinsemana<10) mesfinsemana='0'+mesfinsemana;
		var annofinsemana = fechafinsemana.getFullYear();
		
		
		//OPCIONES PARA SEMANA ANTERIOR
		//alert('fechainiciosemana3: ' + fechainiciosemana3);
		var fechainiciosemanaAnterior = restarDias(fechainiciosemana3, 8);//se restan 8 dias
		var fechainiciosemanaAnterior2 = fechainiciosemanaAnterior;
		//alert('fechainiciosemanaAnterior: ' + fechainiciosemanaAnterior);
		//alert('fechainiciosemanaAnterior: ' + fechainiciosemanaAnterior);
		var diainiciosemanaAnterior=fechainiciosemanaAnterior.getDate();
		//if(diainiciosemanaAnterior<10) diainiciosemanaAnterior='0'+diainiciosemanaAnterior;
		//alert('fechainiciosemanaAnterior: '+ fechainiciosemanaAnterior);
		
		var mesiniciosemanaAnterior = parseInt(fechainiciosemanaAnterior.getMonth()) + 1 ;
		//alert('mesiniciosemana: '+ mesiniciosemana);
		var annoiniciosemanaAnterior = fechainiciosemanaAnterior.getFullYear();	
		//alert('annoiniciosemana: '+ annoiniciosemana);
		
		var fechafinsemanaAnterior= sumarDias(fechainiciosemanaAnterior2, 4);
		var diafinsemanaAnterior=fechafinsemanaAnterior.getDate();
		if(diafinsemanaAnterior<10) diafinsemanaAnterior='0'+diafinsemanaAnterior;
		var mesfinsemanaAnterior = parseInt(fechafinsemanaAnterior.getMonth()) + 1 ;
		if(mesfinsemanaAnterior<10) mesfinsemanaAnterior='0'+mesfinsemanaAnterior;
		var annofinsemanaAnterior = fechafinsemanaAnterior.getFullYear();
		
		
		if(valor=='HOY'){
			miFechaActual = new Date();
			dia = miFechaActual.getDate();
			if(dia<10) dia='0'+dia;
			mes = parseInt(miFechaActual.getMonth()) + 1 ;
			if(mes<10) mes='0'+mes;
			ano = miFechaActual.getFullYear();
			fecha = dia + '-' + mes + '-' + ano;
			document.getElementById('f_desde').value=fecha;
			document.getElementById('f_hasta').value=fecha;
		}
		if(valor=='SEMANA ACTUAL'){
		
			if(diainiciosemana<10) diainiciosemana='0'+diainiciosemana;
			if(mesiniciosemanaAnterior<10) mesiniciosemanaAnterior='0'+mesiniciosemanaAnterior;
			
			fechainiciosemana = diainiciosemana + '-' + mesiniciosemana + '-' + annoiniciosemana;
			
			if(diafinsemana<10) diafinsemana='0'+diafinsemana;
			if(mesfinsemana<10) mesfinsemana='0'+mesfinsemana;
		
			fechafinsemana = diafinsemana + '-' + mesfinsemana + '-' + annofinsemana;
			
			document.getElementById('f_desde').value=fechainiciosemana;
			document.getElementById('f_hasta').value=fechafinsemana;
		}
		if(valor=='SEMANA ANTERIOR'){
		
			if(diainiciosemanaAnterior<10) diainiciosemanaAnterior='0'+diainiciosemanaAnterior;
			if(mesiniciosemanaAnterior<10) mesiniciosemanaAnterior='0'+mesiniciosemanaAnterior;
			
			fechainiciosemanaAnterior = diainiciosemanaAnterior + '-' + mesiniciosemanaAnterior + '-' + annoiniciosemanaAnterior;
			
			if(diafinsemana<10) diafinsemana='0'+diafinsemana;
			if(mesfinsemana<10) mesfinsemana='0'+mesfinsemana;
		
			fechafinsemanaAnterior = diafinsemanaAnterior + '-' + mesfinsemanaAnterior + '-' + annofinsemanaAnterior;
			
			document.getElementById('f_desde').value=fechainiciosemanaAnterior;
			document.getElementById('f_hasta').value=fechafinsemanaAnterior;
		}	
		// buscaAuditorias();
	}

	function diaActual(){
		miFechaActual = new Date();
		dia = miFechaActual.getDate();
		if(dia<10) dia='0'+dia;
		mes = parseInt(miFechaActual.getMonth()) + 1 ;
		if(mes<10) mes='0'+mes;
		ano = miFechaActual.getFullYear();
		fecha = dia + '-' + mes + '-' + ano;

		return fecha;
	}
	function consultarAuditoria(inicio){
		var iframe 	   = document.getElementById('ifr_aud');
		var tipoAudit  = null;
		var fechaDesde = null;
		var fechaHasta = null;
		
		if(inicio){
			fechaDesde = fechaHasta = diaActual();
			$('#f_desde').val(fechaDesde);
			$('#f_hasta').val(fechaHasta);
			iframe.src = "controlador/auditoria/auditoria.php?case=1&fechaDesde="+fechaDesde+"&fechaHasta="+fechaHasta;
		}
		else{
			var tipoAudit  = $('#selTipoAud').val();
			var fechaDesde = $('#f_desde').val();
			var fechaHasta = $('#f_hasta').val();

			if(tipoAudit == 0) tipoAudit = '';

			iframe.src = 'controlador/auditoria/auditoria.php?case=1&tipoAudit='+tipoAudit+"&fechaDesde="+fechaDesde+"&fechaHasta="+fechaHasta;
		}
	}
/* -------------------------------------------------------------------------------------------------------------------- */