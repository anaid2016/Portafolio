/* ESTE SCRIPT CONTIENE
 * FUNCIONALIDAD DE JAVASCRIPT QUE SE APLICAN TRANSVERSALMENTE A TODO EL SISTEMA YII2
 * 
 */

//$(function () {
//    
//    /*------------------------------------------------------------------------------------------------*/
//    /*--------------------------Funcion Ventana Emergente Modal------------------------------------*/
//    /*------------------------------------------------------------------------------------------------*/
//
//    $(document).on('click','.showModalButton', function(){
//        
//          if (($("#modal").data('bs.modal') || {})._isShown){
//                $('#modal').find('#modalContent').load(''+$(this).attr('value')+'');
//          }else{
//               $('#modal').modal('show').find('#modalContent').load(''+$(this).attr('value')+'');
//               var headerHTML = '<h4>' + $(this).attr('title') + '</h4>\n\
//                                      <div class="butonclosemodal">\n\
//                                            <button type="button" class="closebutton" data-dismiss="modal">x</button>\n\
//                                      </div>'
//               document.getElementById('modalHeader').innerHTML = headerHTML;
//          }
//    });
//
//
//    $('#modal').on('hidden.bs.modal', function () {
//        console.log("cierro ventana");
//        $("#modalContent").html("");  
//        location.reload();
//    });
//    
//   
//});



function funcion1(seleccion){
    
    var itembuscadorsel = seleccion;
    var urlsend= "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname+"?r=indicadores/cantones/canton&dpa_canton="+itembuscadorsel.toString();
    urlsend = urlsend.replace(/[#\s]/g, ''); 
    urlsend = urlsend.replace(/goBack/g, '');
    urlsend = urlsend.replace(/[#\()]/g, '');
    window.location.href = urlsend;
}

function funcion2(seleccion){
    
    var itembuscadorsel = seleccion;
    
    var urlsend= "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname+"?r=site/index&dpa_canton="+itembuscadorsel.toString();
    urlsend = urlsend.replace(/[#\s]/g, ''); 
    urlsend = urlsend.replace(/goBack/g, '');
    urlsend = urlsend.replace(/[#\()]/g, '');
    window.location.href = urlsend;
} 


function goBack(){
	var Homeurl= "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname;

        Homeurl = Homeurl.replace(/[#\s]/g, ''); 
	Homeurl = Homeurl.replace(/goBack/g, '');
	Homeurl = Homeurl.replace(/[#\()]/g, '');

        
        window.location.href = Homeurl;
}