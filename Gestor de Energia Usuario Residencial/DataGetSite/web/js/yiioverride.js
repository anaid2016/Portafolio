/*------------------------------------------------------------------------------------------------*/
/*--------------------------Reemplazo Ventana de Confirmación--------------------------------------*/
/*Variables a recibir:  @message => Mensaje que se debe mostrar en la ventana de confirmacion, esta variable es un string concatenado, 
 * 
 *debe contener dos datos separados por "::" (dato1::dato2) el dato 1 es el mensaje a mostrar en pantalla y el dato2 es la url completa de redireccionamiento
 * ver ejemplo en /view/clientesprueba/index.php funcion deletep
 * dato 0 -> mensaje
 * dato 1 -> url si aplica, sino enviar una A
 * dato 2 -> buscar vacios en cda
/*------------------------------------------------------------------------------------------------*/
//
//yii.allowAction = function ($e) {
//    console.log("Ejecucion 1");
//    var message = $e.data('confirm');
//    var id=$e.data('id');
//    return message === undefined || yii.confirm(message,$e,id);
//};

yii.confirm = function (message, okCallback, cancelCallback) {
    swal({
        title: message,
        type: 'warning',
        showCancelButton: true,
        closeOnConfirm: true,
        allowOutsideClick: true
    }, okCallback);
};



/*------------------------------------------------------------------------------------------------*/
/*--------------------------Funcion Ventana Emergente GridView------------------------------------*/
/*------------------------------------------------------------------------------------------------*/
$(function () {
    $(document).on('click','.showModalButton', function(){

            if ($('#modal').data('bs.modal').isShown){
                     $('#modal').find('#modalContent').load(''+$(this).attr('value')+'');
           }else{
               console.log("ejecuta aqui");
                    $('#modal').modal('show').find('#modalContent').load(''+$(this).attr('value')+'');
                    //document.getElementById('modalHeader').style.display = "none";

                    var headerHTML = '<h4>' + $(this).attr('title') + '</h4>';
                    
                    //\n\ <div class="butonclosemodal">\n\   <button type="button" class="closebutton" data-dismiss="modal">x</button>\n\ </div>
                    document.getElementById('modalHeader').innerHTML = headerHTML;

            }
    });


    $('#modal').on('hidden.bs.modal', function (e) {
        $("#modalContent").html("");  
        location.reload();
    });
    
    
  
  
});


