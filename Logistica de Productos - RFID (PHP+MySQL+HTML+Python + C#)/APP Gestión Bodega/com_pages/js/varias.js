
// JavaScript Document


/*Funciones de Javascript para
utilizar en toda el software

pagenew:  Ruta del popup a abrir
tipo: 1-Nuevo, 2- Editar, Borrar
ancho: ancho del popup en pixeles
alto: alto del popup en pixeles

*/


function sil_openpopmodal(pagenew,tipo,acho,alto,form) {
	
		
		/*Ancho y Alto*/
		if(acho=='all'){
			acho=screen.availWidth;
		}
		
		if(alto=='all'){
			alto=screen.availHeight;
		}
					
							
		if (window.showModalDialog) {
		
		if(tipo==1){
			window.showModalDialog(pagenew,"silpopup","dialogWidth:"+acho+".px;dialogHeight:"+alto+".px");
		}else{
			
			
			var datos=new Array();
			longitud=document.formulario.Id.length;
			
			//alert(longitud)
			if(longitud==undefined){
				longitud=1;	
				datos[0]=document.formulario.Id.value;			
			}else{
				for(i=0;i<longitud;i++){
					if(document.formulario.Id[i].checked) {
						marcado=i;
						datos[0]=document.formulario.Id[marcado].value;  
					}
				}
			 }
			
			
			if(datos[0]==''){
				alert("Seleccione un elemento a editar o borrar antes de continuar");	
			}else{
				window.showModalDialog(pagenew+"?Id="+datos[0],"silpopup","dialogWidth:"+acho+".px;dialogHeight:"+alto+".px");
			}
		}	
	}	
}


function datafunction(tipo){
	if(String(document.formulario.Id.length)=="undefined"){
		var tam_for=0;
		valorSeleccionado = document.formulario.Id.value;
	}else{
		var tam_for=document.formulario.Id.length;	
	}
	
	 for(i=0; i <tam_for; i++){
		if(document.formulario.Id[i].checked){
			valorSeleccionado = document.formulario.Id[i].value;
		}
	}
	document.location.href="acceso.php?com_pg=5&estado="+tipo+"&id_ch="+valorSeleccionado;
}

function datafunction2(tipo){

	if(String(document.formulario.Id.length)=="undefined"){
		var tam_for=0;
		valorSeleccionado = document.formulario.Id.value;
	}else{
		var tam_for=document.formulario.Id.length;	
	}
	
	 for(i=0; i <tam_for; i++){
		if(document.formulario.Id[i].checked){
			valorSeleccionado = document.formulario.Id[i].value;
		}
	}
	document.location.href="acceso.php?com_pg=7&estado="+tipo+"&id_ch="+valorSeleccionado;

}

function bodegafunction(tipo){
	
	if(String(document.form1.Id.length)=="undefined"){
		var tam_for=0;
		valorSeleccionado = document.form1.Id.value;
	}else{
		var tam_for=document.form1.Id.length;	
	}

	for(i=0;i<tam_for;i++){
		if(document.form1.Id[i].checked){
			valorSeleccionado = document.form1.Id[i].value;
		}
	}
	
	document.location.href="acceso.php?com_pg=9&estado="+tipo+"&id_ch="+valorSeleccionado;
}

function recargar(obtuvo){
	if(obtuvo>1){
		alert('El sistema Actualizó exitosamente el estado del a OC');
		opener.location.href="acceso.php?com_pg=5";	
		window.close();
	}else{
		alert('El sistema no logró actualizar el estado de la OC, intente en unos minutos');
		opener.location.href="acceso.php?com_pg=5";	
		window.close();
	}
		
}

function Etiquetar(orden){
	var pag_etq="com_pages/crearetiqueta.php?orden="+orden;
	window.open(pag_etq, 'popup2', 'width=1000, height=700');
}

function GenEtiqueta(lineas){
	location.href=lineas;
}

function Verificar(orden){
	var pag_etq="com_pages/verificarordencompra.php?orden="+orden;
	window.open(pag_etq, 'popup2', 'width=1000, height=700');
}

function recargarpedido(obtuvo){
	if(obtuvo>1){
		alert('El sistema Actualizó exitosamente el estado del Pedido');
		opener.location.href="acceso.php?com_pg=7";	
		window.close();
	}else{
		alert('El sistema no logró actualizar el estado del Pedido, intente en unos minutos');
		opener.location.href="acceso.php?com_pg=7";	
		window.close();
	}
		
}

function bodegafunction2(tipo){

	if(String(document.form1.Id.length)=="undefined"){
		var tam_for=0;
		valorSeleccionado = document.form1.Id.value;
	}else{
		var tam_for=document.form1.Id.length;	
	}
	
	for(i=0;i<tam_for;i++){
		if(document.form1.Id[i].checked){
			valorSeleccionado = document.form1.Id[i].value;
		}
	}
	
	document.location.href="acceso.php?com_pg=8&estado="+tipo+"&id_ch="+valorSeleccionado;

	 
}

function AsignarenBodega(pedido){
	var pag_etq="com_pages/asignarenbodega.php?pedido="+pedido;
	window.open(pag_etq, 'popup2', 'width='+screen.availWidth+', height='+screen.availHeight+'');
}

function AsignarBodega(orden){
	var pag_etq="com_pages/asignaroden.php?orden="+orden;
	window.open(pag_etq, 'popup2', 'width='+screen.availWidth+', height='+screen.availHeight+'');
}

function Verificacion(pedido){
	var pag_etq="com_pages/IniciarVerificacion.php?pedido="+pedido;
	window.open(pag_etq, 'popup2', 'width='+screen.availWidth+', height='+screen.availHeight+'');
}

function allscreensoft(pagina,nombreventana){
	var params = [
    'height='+screen.height,
    'width='+screen.width,
    'fullscreen=yes' // only works in IE, but here for completeness
	].join(',');
	
	window.open(pagina,nombreventana,params);
}

