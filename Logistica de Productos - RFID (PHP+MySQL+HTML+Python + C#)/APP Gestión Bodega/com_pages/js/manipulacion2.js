$(document).ready(function(){

	document.getElementById('cantidad').value=1; 

	$(document).on('click','caption',function(){
		//obtener la tabla que contiene el caption clickeado
		var objTabla=$(this).parent();
			//el cuerpo de la tabla esta visible?
			//lo siguiente es unicamente para cambiar el icono del caption
			if(objTabla.find('tbody').is(':visible')){
				//eliminamos la clase clsContraer
				$(this).removeClass('clsContraer');
				//agregamos la clase clsExpandir
				$(this).addClass('clsExpandir');
			}else{
				//eliminamos la clase clsExpadir
				$(this).removeClass('clsExpandir');
				//agregamos la clase clsContraer
				$(this).addClass('clsContraer');
			}
			//mostramos u ocultamos el cuerpo de la tabla
			objTabla.find('tbody').toggle();
	});
		
	//evento que se dispara al hacer clic en el boton para agregar una nueva fila
	$(document).on('click','.clsAgregarFila',function(){
	
		/*obtener el cuerpo de la tabla; contamos cuantas filas (tr) tiene
		si queda solamente una fila le preguntamos al usuario si desea eliminarla*/
		var objCuerpo=$(this).parents().get(2);
		var conteo=$(objCuerpo).find('tr').length;
		var real=conteo+1;
		document.getElementById('cantidad').value=real; 
		
		
		//Cantidad existente cuando se da modificar despues de agregar y borrar --------------------//
		anterior=document.getElementById('cantidad2').value;
		document.getElementById('cantidad2').value=parseInt(anterior)+1;
		
		//Cantidad estatica para el inicio de lineas
		
		valorded=document.getElementById('valorded').value;
		newfila=(Number(valorded)+1);
		
		
		if((parseInt(anterior)+1)>real){
			real=parseInt(anterior)+1;	
		}

		if(newfila>real){
			real=newfila;
			document.getElementById('cantidad2').value=newfila;
		}
		
		var newinput='a'+real;
		
		//almacenamos en una variable todo el contenido de la nueva fila que deseamos
		//agregar. pueden incluirse id's, nombres y cualquier tag... sigue siendo html
		var strNueva_Fila='<tr id="linea'+real+'">'+
				
			'<td width="200"><input type="hidden" class="clsAnchoTotal"  name="l'+real+'" id="cl'+real+'" size="5" /><input type="hidden" class="clsAnchoTotal"  name="b'+real+'" id="ca'+real+'" size="5"/><input type="text" readonly="readonly" name="a'+real+'" id="cb'+real+'" size="20"/><input type="button" value="+" onclick="ventana('+real+')"  style="display:inline" id="btnap'+real+'" /></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="c'+real+'" id="cc'+real+'" size="40"></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="m'+real+'" id="cm'+real+'" ></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="n'+real+'" id="cn'+real+'" ></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="d'+real+'" id="cd'+real+'" onblur="OnBlurInput(this,'+real+')" ></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="e'+real+'" id="ce'+real+'" size="3"></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="f'+real+'" id="cf'+real+'" ></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="g'+real+'" id="cg'+real+'" ></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="h'+real+'" id="ch'+real+'" ></td>'+
			'<!--<td style="display:none"><input type="text" class="clsAnchoTotal" name="i'+real+'" id="ci'+real+'" ></td>'+
			'<td style="display:none"><input type="text" class="clsAnchoTotal" name="j'+real+'" id="cj'+real+'" ></td>'+
			'<td style="display:none"><input type="text" class="clsAnchoTotal" name="k'+real+'" id="ck'+real+'" ></td>-->'+
			'<td align="right"><input type="button" value="-" class="clsEliminarFila"></td>'+
		'</tr>';
				
		/*obtenemos el padre del boton presionado (en este caso queremos la tabla, por eso
		utilizamos get(3)
			table -> padre 3
				tfoot -> padre 2
					tr -> padre 1
						td -> padre 0
		nosotros queremos utilizar el padre 3 para agregarle en la etiqueta
		tbody una nueva fila*/
		var objTabla=$(this).parents().get(3);
				
		//agregamos la nueva fila a la tabla
		$(objTabla).find('tbody').append(strNueva_Fila);
		//proveedores(newinput);		
				
		//si el cuerpo la tabla esta oculto (al agregar una nueva fila) lo mostramos
		if(!$(objTabla).find('tbody').is(':visible')){
			//le hacemos clic al titulo de la tabla, para mostrar el contenido
			$(objTabla).find('caption').click();
		}
		
		
	});
	
	//cuando se haga clic en cualquier clase .clsEliminarFila se dispara el evento
	$(document).on('click','.clsEliminarFila',function(){
		/*obtener el cuerpo de la tabla; contamos cuantas filas (tr) tiene
		si queda solamente una fila le preguntamos al usuario si desea eliminarla*/
		var objCuerpo=$(this).parents().get(2);
		//alert(objCuerpo);
			if($(objCuerpo).find('tr').length==1){
				if(!confirm('Esta es el única fila de la lista ¿Desea eliminarla?')){
					return;
				}
			}
					
		/*obtenemos el padre (tr) del td que contiene a nuestro boton de eliminar
		que quede claro: estamos obteniendo dos padres
					
		el asunto de los padres e hijos funciona exactamente como en la vida real
		es una jergarquia. imagine un arbol genealogico y tendra todo claro ;)
				
			tr	--> padre del td que contiene el boton
				td	--> hijo de tr y padre del boton
					boton --> hijo directo de td (y nieto de tr? si!)
		*/
		


		var objFila=$(this).parents().get(1);
		var borrada=$(objFila).attr("id");
		var numlinea=borrada.substring(5);
		var vbaseelim=document.getElementById('cf'+numlinea).value;
		var vgravelim=document.getElementById('ch'+numlinea).value;
		var desaparecidas=document.getElementById('eliminadas').value;
		var newdesaparecida=document.getElementById('cl'+numlinea).value;
		
		if(newdesaparecida!='' && desaparecidas!=''){
			desaparecidas=desaparecidas+','+newdesaparecida;
		}else if(newdesaparecida!='' && desaparecidas==''){
			desaparecidas=newdesaparecida;
		}
		
		
		var vivaelim=Number(vgravelim)-Number(vbaseelim);
		var actbase=document.getElementById('ttbase').value;
		var activa=document.getElementById('ttiva').value;
		var actgravado=document.getElementById('ttgravado').value;
		
		document.getElementById('eliminadas').value=desaparecidas;
		document.getElementById('ttbase').value=actbase-vbaseelim;
		document.getElementById('ttiva').value=activa-vivaelim;
		document.getElementById('ttgravado').value=actgravado-vgravelim;
		
		anterior=document.getElementById('cantidad2').value;
		document.getElementById('cantidad2').value=anterior-1;
		
		anterior2=document.getElementById('cantidad').value;
		document.getElementById('cantidad').value=anterior2-1;
		
			/*eliminamos el tr que contiene los datos del contacto (se elimina todo el
			contenido (en este caso los td, los text y logicamente, el boton */
			$(objFila).remove();
	});
	
	//evento que se produce al hacer clic en el boton que elimina una tabla completamente
	$(document).on('click','.clsEliminarTabla',function(){
		var objTabla=$(this).parents().get(3);
			//bajamos la opacidad de la tabla hasta estar invisible
			$(objTabla).animate({'opacity':0},500,function(){
				//eliminar la tabla
				$(this).remove();
			});
			
			
	});
	
	//boton para clonar cualquiera de las tablas
	$(document).on('click','.clsClonarTabla',function(){
		var objTabla=$(this).parents().get(4);
			//agregamos un clon de la tabla a la capa contenedora
			$('#divContenedor').append($(objTabla).clone());
	});
	
			
});


	//Traer comobo de proveedores
	
	function proveedores(nombreinput){
	  mostrar="js/combo1.php";
	  $.post(mostrar, { elegido: '' }, function(data){
				$("#"+nombreinput).html(data);
	  });
	}
	
	//Crear nuevas filas 
	function crearnuevafila(boton){
			var nouEvent = document.createEvent("MouseEvents");
			nouEvent.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
			var objecte = document.getElementById(boton);
			var canceled = !objecte.dispatchEvent(nouEvent);	
	}
		
		