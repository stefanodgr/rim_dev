$(document).ready(function() {

    $('.hg-tab').on('click',function(){	
        
        var tabActual 		= $(this).parent().find('.hg-tab-activo');		// TAB QUE SE ENCUENTRA ACTIVO ACTUALMENTE	  		
        var divTabActual 	= tabActual.attr('id').split('-');
        var idTabActual 	= divTabActual[1];
        var tabActivo 		= $(this);										// TAB QUE SE DESEA ACTIVAR
        var divTabActivo	= tabActivo.attr('id').split('-');
        var idTabActivo 	= divTabActivo[1];
        var tabHabilitado	= $(this).hasClass('hg-tab-disabled');
        
        if(idTabActual != idTabActivo){
            switch(tabHabilitado){
                case true: alert("Opción no disponible temporalmente.");
                break;
                case false: 
                    tabActual.removeClass('hg-tab-activo').addClass('hg-tab-inactivo');
                    $('#div-'+idTabActual).addClass('div-oculto');
                    tabActivo.removeClass('hg-tab-inactivo').addClass('hg-tab-activo visited');
                    $('#div-'+idTabActivo).removeClass('div-oculto');
                    // abrirPestana(divTabActivo, idObjeto, ctrlRecarga);
                break;
            }
        }
    });
});