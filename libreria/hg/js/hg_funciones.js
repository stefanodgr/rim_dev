/*- ----------------------------------------------------------------------------------------- -*/
function validarCadena(e,tipo){
    var valor = String.fromCharCode(e.which);
    var validar = null;
    
    switch (tipo) {
        case 'alphanum':
            validar = /[^\wÑñ ]/;	
        break;
        case 'alpha':
            validar = /[^A-Za-zÑñ ]/;		
        break;
        case 'num':
            validar = /[^0-9]/;	
        break;
    }

    resultado = valor.match(validar); 

    if(resultado == null) control = true;
    else control = false;	
    
    return control;
}
/*- ----------------------------------------------------------------------------------------- -*/
function verifExisElement(arreglo,valBusq){	 	//VERIFICA LA EXISTENCIA DE UN VALOR ESPECIFICO EN EL ARREGLO A CONSULTAR
		
    var i = 0;
    var control = false;

    for (i; i<arreglo.length;i++){
        //alert(valBusq +" = " + arreglo[i]+ " ?");
        if (valBusq == arreglo[i]){					
            control = true;
        }
    }
    return control;
}
/*- ----------------------------------------------------------------------------------------- -*/
function verifPosElement(arreglo, valBusq){  	//DEVUELVE LA POSICION DEL ARREGLO EN LA QUE SE ENCUENTRA EL VALOR BUSCADO
		
    var i = 0;
    var posElement = 0;
        
    for (i; i<arreglo.length;i++){
        if(arreglo[i] == valBusq){	
            posElement  = i;
        }
    }
    return posElement;
}
/*- ----------------------------------------------------------------------------------------- -*/
function delPosArr(arreglo, posDel){			//ELIMINA LA POSICION DEL ARREGLO QUE CONTENGA EL VALOR BUSCADO
		
    var i = 0;
    var j = 0;

    var arregloN = new Array();	
    
    for ( i;i<arreglo.length;i++){
        if (i != posDel){
            arregloN[j] = arreglo[i];
            j++;
        }
    }
    return arregloN;
}
/*- ----------------------------------------------------------------------------------------- -*/

function enaInpTxt(identificador,tipoAtrib){
    switch(tipoAtrib){
        case 'clase':
            $('.'+identificador).removeClass('inp-dis') .prop('disabled',false);
            $('.'+identificador).addClass('inp-ena');
        break;
        case 'id':
            $('#'+identificador).removeClass('inp-dis') .prop('disabled',false);
            $('#'+identificador).addClass('inp-ena');
        break;
    }
}
function disInpTxt(identificador,tipoAtrib){
    switch(tipoAtrib){
        case 'clase':
            $('.'+identificador).removeClass('inp-ena').prop('disabled',true);
            $('.'+identificador).addClass('inp-dis');
        break;
        case 'id':
            $('#'+identificador).removeClass('inp-ena').prop('disabled',true);
            $('#'+identificador).addClass('inp-dis');
        break;
    }
}
function enaInpChk(identificador,tipoAtrib){
    switch(tipoAtrib){
        case 'clase':
            $('.'+identificador).removeClass('chk-dis') .prop('disabled',false);
            $('.'+identificador).addClass('chk-ena');
        break;
        case 'id':
            $('#'+identificador).removeClass('chk-dis') .prop('disabled',false);
            $('#'+identificador).addClass('chk-ena');
        break;
    }
}
function disInpChk(identificador,tipoAtrib){
    switch(tipoAtrib){
        case 'clase':
            $('.'+identificador).removeClass('chk-ena').prop('disabled',true);
            $('.'+identificador).addClass('chk-dis');
        break;
        case 'id':
            $('#'+identificador).removeClass('chk-ena').prop('disabled',true);
            $('#'+identificador).addClass('chk-dis');
        break;
    }
}
/*- ----------------------------------------------------------------------------------------- -*/