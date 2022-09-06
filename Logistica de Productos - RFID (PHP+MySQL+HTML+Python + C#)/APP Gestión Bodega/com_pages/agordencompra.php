<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/comx_dbconn.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	
	
	//Iniciando Conexion a Mysql
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	$error_mysql=0;
	
	//Creación de Arrays 
	$arrid=array();
	$arra=array();
	$arrb=array();
	$arrc=array();
	$arrd=array();
	$arre=array();
	$arrf=array();
	$arrg=array();
	$arrh=array();
	$arri=array();
	$arrj=array();
	$arrk=array();
	$arrl=array();
	$arrm=array();
	$arrn=array();
	
	//Creacion de variables fijas
	$noorden="";
	$fechasolicitud=gmdate("Y-m-d");
	$fechacierre="";
	$provdireccion="";
	$totalsiniva=0;
	$totaliva=0;
	$totalconiva=0;
	$usercreo="";
	$userid="";
	$estado="";
	$estadoid="";
	
	$d=0;
	$id='';
	if(!empty($_GET['Id'])){
		
				// Busqueda del proveedor
				$id=$_GET['Id'];
				$buscar="SELECT com_ordencompra.*,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as creado,com_estadooc.nombre FROM com_ordencompra 
LEFT JOIN com_usconect ON com_usconect.Id=com_ordencompra.usuario_id
LEFT JOIN com_estadooc ON com_estadooc.Id=com_ordencompra.estado_id WHERE com_ordencompra.Id='$id'";

				if ($matriz = $enlace->query($buscar)) {
					while ($resultado = $matriz->fetch_assoc()) {
						$noorden=$resultado['noorden'];
						$fechasolicitud=$resultado['fechasolicitud'];
						$fechacierre=$resultado['fecharecibido'];
						$provdireccion=$resultado['direccionproveedor_id'];
						$totalsiniva=$resultado['totalantesiva'];
						$totaliva=$resultado['totaliva'];
						$totalconiva=$resultado['totalconiva'];
						$userid=$resultado['usuario_id'];
						$estadoid=$resultado['estado_id'];
						$usercreo=$resultado['creado'];
						$estado=$resultado['nombre'];
					}
					$matriz->free();
				}

							
				//Busqueda de los producto asociados a una orden de compra existente
				
				$bproductos="SELECT com_productosorden.*,com_productos.codbarras,com_productos.nombre as producto,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as usuario,com_unidades.nombre
FROM com_productosorden 
LEFT JOIN com_ordencompra ON com_productosorden.orden_id=com_ordencompra.Id
LEFT JOIN com_proveedorproductos ON com_proveedorproductos.Id=com_productosorden.proveedorproducto_id
LEFT JOIN com_productos ON com_proveedorproductos.producto_id=com_productos.Id
LEFT JOIN com_usconect ON com_usconect.Id=com_productosorden.usuario_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id WHERE com_ordencompra.Id='$id'";

				if ($matriz = $enlace->query($bproductos)) {
					while ($resultado = $matriz->fetch_assoc()) {
						array_push($arrid,$resultado['Id']);				//Id de la linea de OC
						array_push($arra,$resultado['codbarras']);			//Codigo de Barras del produco
						array_push($arrb,$resultado['producto']);			//Nombre del Producto
						array_push($arrc,$resultado['cantidadpedida']);		//Cantidad Pedida
						array_push($arrd,$resultado['nombre']);				//Unidad
						array_push($arre,$resultado['valoractualsiniva']);
						array_push($arrf,$resultado['porcentajeiva']);
						array_push($arrg,$resultado['valorconiva']);
						array_push($arrh,$resultado['cantidarecibida']);
						array_push($arri,$resultado['fecharecibido']);
						array_push($arrj,$resultado['usuario']);
						array_push($arrk,$resultado['proveedorproducto_id']);
						array_push($arrm,$resultado['cantidadminima']);
						array_push($arrn,$resultado['preciominimo']);
					}
					$matriz->free();
				}
				

	}
	
	//Asignado el Nombre a la Ventana ===========================================================================//
		
	if(!empty($_POST['Id']) || !empty($_GET['Id'])){
	 $tpwindow="Modificar ";	
		
	}else{
	  $tpwindow="Nueva ";	
	}
	
	mysqli_close($enlace);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Orden de Compra</title>
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>
<script src="js/jquery1-9.js"></script>
<script src="js/jquery10-2.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script> 
 function Cerrar(){
	opener.location.href = "../acceso.php?com_pg=5";
    window.close();
}

 function ventana(filita){
	 	proveedor=document.getElementById('direccion').value;
		myWindow=window.open("popuplistadoproductos.php?prov="+proveedor+"&fila="+filita+"",'','width=1200,height=600');
		myWindow.focus();
 }
 
 function estimacion(tipo){
	  proveedor=document.getElementById('direccion').value;
	 if(tipo=='1'){
		myWindow=window.open("estimaciondedemanda/suavisadoexponencial.php?prov="+proveedor+"",'','width=1200,height=600');
		myWindow.focus();
	 }else if(tipo=='2'){
		myWindow=window.open("estimaciondedemanda/suavisadoholt.php?prov="+proveedor+"",'','width=1200,height=600');
		myWindow.focus();
	 }
 }
 
 function datos(val1,val4){
	var longitud=val1.length; 
	var newlongitud=longitud-1;
	val1=val1.substring(0,newlongitud);
	if(val4=='' && val1==''){
		
	}else{
		var vector=val1.split("-");
		document.getElementById('ca'+val4).value=vector[0];
		document.getElementById('cb'+val4).value=vector[1];
		document.getElementById('cc'+val4).value=vector[2];
		document.getElementById('cd'+val4).value=vector[3];
		document.getElementById('ce'+val4).value=vector[4];
		document.getElementById('cf'+val4).value=vector[5];
		document.getElementById('cg'+val4).value=vector[6];
		document.getElementById('ch'+val4).value=vector[7];
		document.getElementById('cm'+val4).value=vector[3];
		document.getElementById('cn'+val4).value=vector[5];
		
		var v1=document.getElementById('ttbase').value;
		var v2=document.getElementById('ttiva').value;
		var v3=document.getElementById('ttgravado').value;
		
		var tt1=Number(v1)+Number(vector[5]);
		var tt2=Number(v2)+((vector[5]*vector[6])/100);
		var tt3=Number(v3)+Number(vector[7]);
		
		
		document.getElementById('ttbase').value=tt1.toFixed(2);
		document.getElementById('ttiva').value=tt2.toFixed(2);
		document.getElementById('ttgravado').value=tt3.toFixed(2);
		document.getElementById('btnap'+val4).disabled=true;
		
	}
 }
 
 function OnBlurInput(tipo,vinput){
	 var dfila=vinput;
	 var pedido=tipo.value;
	 var preciomin=document.getElementById('cn'+dfila).value;
	 var cantmin=document.getElementById('cm'+dfila).value;
	 
	 /*Datos anteriores*/
	 var valorant=document.getElementById('cf'+dfila).value;
	 var poriva=document.getElementById('cg'+dfila).value;
	 var ivaant=(valorant*poriva)/100;
	 var gravant=valorant+ivaant;
	 
	 
	 /*Asignaciones */
	 var siniva=(preciomin*pedido)/cantmin;
	 var totalineaiva=(siniva*poriva)/100;
	 var totalgrava=siniva+totalineaiva;
	 document.getElementById('cf'+dfila).value=siniva.toFixed(2);	 
	 document.getElementById('ch'+dfila).value=totalgrava.toFixed(2);
	 
	 /*Totales finales*/
	 var ttd1=document.getElementById('ttbase').value-valorant+siniva;;
	 var ttd2=document.getElementById('ttiva').value-ivaant+totalineaiva;
	 var ttd3=document.getElementById('ttgravado').value-gravant+totalgrava;
	 
	 document.getElementById('ttbase').value=ttd1.toFixed(2);
	 document.getElementById('ttiva').value=ttd2.toFixed(2);
	 document.getElementById('ttgravado').value=ttd3.toFixed(2);
 }
 
 
 function proveedor(idproveedor){
	proveedor=document.getElementById('direccion').value;
	mostrar="tiempoentrega.php";
	$.post(mostrar, { elegido: proveedor }, function(data){
		fechasolicitud=document.getElementById('fsolicitud').value;
		var sumarDias=parseInt(data);
		
		fechanew=fechasolicitud.replace("-", "/").replace("-", "/");
		fechanew= new Date(fechanew);
		fechanew.setDate(fechanew.getDate() + sumarDias);

		var anio=fechanew.getFullYear(); //Año de 4 digitos
		var mes= fechanew.getMonth()+1;  // Mes
		var dia= fechanew.getDate();     //Día del mes
		
		//Si la longitud de digitos es menor a 2 
		//entonces le agregamos el cero a la izquierda.
		if(mes.toString().length<2){
		  mes="0".concat(mes);       
		}   
		 
		//Si la longitud de digitos es menor a 2 
		//entonces le agregamos el cero a la izquierda.
		if(dia.toString().length<2){
		  dia="0".concat(dia);       
		}
		
		
		newfecha=(anio+"-"+mes+"-"+dia);
		
		document.getElementById('direccion').disabled=true;
		document.getElementById('frecibido').value=newfecha;
		document.getElementById('dir_pasar').value=proveedor;
		
	});
 }


/*Trae datos de la politica de inventarioval1,val4*/
 function politica(val1,val4){
	
	var conteoline=1; 
	var longitud=val1.length; 
	var newlongitud=longitud-2;
	val1=val1.substring(0,newlongitud);
	
	if(val4=='' && val1==''){
		
	}else{
	  var vectorini=val1.split("::");
	  var longini=vectorini.length;
	  for(j=0;j<vectorini.length;j++){
		var vector=vectorini[j].split("-");
		if(conteoline==1){
			document.getElementById('ca'+val4).value=vector[0];
			document.getElementById('cb'+val4).value=vector[1];
			document.getElementById('cc'+val4).value=vector[2];
			document.getElementById('cd'+val4).value=vector[8];
			document.getElementById('ce'+val4).value=vector[4];
			document.getElementById('cf'+val4).value=vector[5];
			document.getElementById('cg'+val4).value=vector[6];
			document.getElementById('ch'+val4).value=vector[7];
			document.getElementById('cm'+val4).value=vector[3];
			document.getElementById('cn'+val4).value=vector[5];
			

			
			/*Asignaciones */
			var preciomin=vector[5];
	 		var cantmin=vector[3];
			var poriva=vector[6];
			var pedido=vector[8];
			 
			 
			var siniva=(preciomin*pedido)/cantmin;
			var totalineaiva=(siniva*poriva)/100;
			var totalgrava=siniva+totalineaiva;
			document.getElementById('cf'+val4).value=siniva.toFixed(2);	 
			document.getElementById('ch'+val4).value=totalgrava.toFixed(2);
			 
			 /*Totales finales*/
			 var ttd1=siniva;;
			 var ttd2=totalineaiva;
			 var ttd3=totalgrava;
			
			
			document.getElementById('btnap'+val4).disabled=true;
		}else{
			crearnuevafila("agregar");
			val4=j+1;
			document.getElementById('ca'+val4).value=vector[0];
			document.getElementById('cb'+val4).value=vector[1];
			document.getElementById('cc'+val4).value=vector[2];
			document.getElementById('cd'+val4).value=vector[8];
			document.getElementById('ce'+val4).value=vector[4];
			document.getElementById('cf'+val4).value=vector[5];
			document.getElementById('cg'+val4).value=vector[6];
			document.getElementById('ch'+val4).value=vector[7];
			document.getElementById('cm'+val4).value=vector[3];
			document.getElementById('cn'+val4).value=vector[5];
			
			/*Asignaciones */
			var preciomin=vector[5];
	 		var cantmin=vector[3];
			var poriva=vector[6];
			var pedido=vector[8];
			 
			 
			var siniva=(preciomin*pedido)/cantmin;
			var totalineaiva=(siniva*poriva)/100;
			var totalgrava=siniva+totalineaiva;
			document.getElementById('cf'+val4).value=siniva.toFixed(2);	 
			document.getElementById('ch'+val4).value=totalgrava.toFixed(2);
			 
			 /*Totales finales*/
			 ttd1=ttd1+siniva;;
			 ttd2=ttd2+totalineaiva;
			 ttd3=ttd3+totalgrava;
			
			document.getElementById('btnap'+val4).disabled=true;
			
			
		
		}
		  //alert("soy :"+vectorini[$j]);
		  conteoline=conteoline+1;
	  }
	  
	  		document.getElementById('ttbase').value=ttd1.toFixed(2);
			document.getElementById('ttiva').value=ttd2.toFixed(2);
			document.getElementById('ttgravado').value=ttd3.toFixed(2);
			
		
	}	
	
}


</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>
   
<body>
<div id="contenidof4">
    	<h2> >> <?php echo $tpwindow; ?> Orden de Compra</h2>
			<?php
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
				
				
				$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
				$enlace->set_charset("utf8");
				$error_mysql=0;
				$enlace->autocommit(FALSE);
				
				
				$totalgravado=0;
				$totalbase=0;
				$id='';
				/*Datos Basicos de la Orden de Compra*/
				$v1=$_POST['fsolicitud'];
				$v2=$_POST['frecibido'];
				$v3=$_POST['dir_pasar'];
				$v4=$iduser;
				$idelim=$_POST['eliminadas'];
				$veliminar=explode(",",$idelim);
			
				if(!empty($_POST['cantidad2']) && $_POST['cantidad2']>0){
					$cantidad=$_POST['cantidad2'];
				}else{
					$cantidad=$_POST['cantidad'];
				}
				
				if(!empty($_POST['Id'])){
					$id=$_POST['Id'];
				}
				$vector1=array();
				$vector2=array();
				$vector3=array();
				$vector4=array();
				$vector5=array();
				$vector6=array();
				$vector7=array();
				$vector8=array();
				$vector9=array();
				$vector10=array();
				$vector11=array();
				$vector12=array();
				
				for($b=1;$b<=$cantidad;$b++){
					$est1='b'.$b;
					$est2='d'.$b;
					$est3='e'.$b;
					$est4='f'.$b;
					$est5='g'.$b;
					$est6='h'.$b;
					$est7='i'.$b;
					$est8='j'.$b;
					$est9='k'.$b;
					$est10='l'.$b;
					$est11='m'.$b;
					$est12='n'.$b;
				
					$vector1[$b]=(!empty($_POST[$est1]))? $_POST[$est1]:'';	
					$vector2[$b]=(!empty($_POST[$est2]))? $_POST[$est2]:'';
					$vector3[$b]=(!empty($_POST[$est3]))? $_POST[$est3]:'';
					$vector4[$b]=(!empty($_POST[$est4]))? $_POST[$est4]:'';
					$totalbase+=(!empty($_POST[$est4]))? $_POST[$est4]:0;	/*Total base*/
					$vector5[$b]=(!empty($_POST[$est5]))? $_POST[$est5]:'';
					$vector6[$b]=(!empty($_POST[$est6]))? $_POST[$est6]:'';
					$totalgravado+=(!empty($_POST[$est6]))? $_POST[$est6]:0;	/*Total Gravado*/
					$vector7[$b]=(!empty($_POST[$est7]))? $_POST[$est7]:'';
					$vector8[$b]=(!empty($_POST[$est8]))? $_POST[$est8]:'';
					$vector9[$b]=(!empty($_POST[$est9]))? $_POST[$est9]:"NULL";
					if($vector9[$b]==''){
						$vector9[$b]="NULL";
					}
					
					$vector10[$b]=(!empty($_POST[$est10]))? $_POST[$est10]:'';
					$vector11[$b]=(!empty($_POST[$est11]))? $_POST[$est11]:'';
					$vector12[$b]=(!empty($_POST[$est12]))? $_POST[$est12]:'';
					
				}
				/*TOTAL IVA EN ORDEN DE COMPRA */
				$totaliva=$totalgravado-$totalbase;
				
				
				
				//Busqueda de estado en Solicitud
				$bsolicitud="SELECT * FROM com_estadooc WHERE nombre='Solicitud'";
				if ($matriz = $enlace->query($bsolicitud)) {
					/* obtener array asociativo */
					while ($row = $matriz->fetch_row()) {
						$estado=$row[0];
					}
					/* liberar el resultset */
					$matriz->free();
				}
				
				
				
				
						
				
/*INSERTA O ACTUALIZA DATOS EN LA TABLA ORDEN COMPRA ---------------------------------------------------------------------------------------------------------------------*/
				if($id==''){
					
					if(!$enlace->query("INSERT INTO com_ordencompra (fechasolicitud,fecharecibido,direccionproveedor_id,totalantesiva,totaliva,totalconiva,usuario_id,estado_id) VALUES ('$v1','$v2','$v3','$totalbase','$totaliva','$totalgravado','$v4','$estado')")){
							$error_mysql=1;	
							$error_print="Error 001: Error al guardar demandas estimadas.";
					}
					
				}else{
					
					if(!$enlace->query("UPDATE com_ordencompra SET fechasolicitud='$v1',fecharecibido='$v2',direccionproveedor_id='$v3',totalantesiva='$totalbase',totaliva='$totaliva',totalconiva='$totalgravado',usuario_id='$v4',estado_id='$estado' WHERE Id=$id)")){
							$error_mysql=1;	
							$error_print="Error 002: Error al guardar demandas estimadas.";
					}
				
				}
				
			
			
				
				if(empty($_POST['Id'])){
					$lastinsert=$enlace->insert_id;
/*					
					$selesql=mysql_query("SELECT max(Id) FROM com_ordencompra");
					$lastinsert=mysql_result($selesql,0);*/
				}else{
					$lastinsert=$id;
				}
				 
				
				for($b=1;$b<=$cantidad;$b++){ 
					if($vector10[$b]=='' && $vector2[$b]!=''){
						
						
						if(!$enlace->query("INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('$vector1[$b]','$vector2[$b]','$vector4[$b]','$vector5[$b]','$lastinsert','$vector7[$b]','$vector8[$b]','$vector6[$b]',$vector9[$b],'$vector11[$b]','$vector12[$b]')")){
							$error_mysql=1;	
							$error_print="Error 003: Error al guardar demandas estimadas.";
						}
						
					}else if($vector10[$b]!='' && $vector2[$b]!=''){
						
						if(!$enlace->query("UPDATE com_productosorden SET proveedorproducto_id='$vector1[$b]',cantidadpedida='$vector2[$b]',valoractualsiniva='$vector4[$b]',porcentajeiva='$vector5[$b]',orden_id='$id',cantidarecibida='$vector7[$b]',fecharecibido='$vector8[$b]',valorconiva='$vector6[$b]',usuario_id=$vector9[$b],cantidadminima='$vector11[$b]',preciominimo='$vector12[$b]' WHERE Id='$vector10[$b]'")){
							$error_mysql=1;	
							$error_print="Error 003: Error al guardar demandas estimadas.";
						}
					}
					
				}
				
/*ELIMINAR LINEAS DE LA ORDEN DE COMPRA -------------------------------------------------------------------------------------------------------------------------*/

				for($k=0;$k<count($veliminar);$k++){
					if($veliminar[$k]!=''){
						
						if(!$enlace->query("DELETE FROM com_productosorden WHERE Id='$veliminar[$k]'")){
							$error_mysql=1;	
							$error_print="Error 004: Error al guardar demandas estimadas.";
						}
						
					}
					
				}


/*REVISANDO ERRORES EN MYSQL --------------------------------------------------------------------------------------------------------------------------------------*/
				
				if($error_mysql==1){
					$enlace->rollback();
				}else{
					$enlace->commit();	
					$error_print="Orden de Compra Realizada con Exito";
				}
				$enlace->close();
		
				echo $error_print;
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
				 
			}else{
               

            ?>
            <p>Diligencie el formulario en su totalidad y de clic en Guardar:</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="other">
				<table width="95%" class="formulario">
					<tr>
                    	<td width="90">No de Orden:</td>
                        <td width="149"><span id="sprytextfield1">
                          		<input type="text" name="noorden" id="noorden" readonly="readonly" value="<?php echo $noorden; ?>" />
                          		<span class="textfieldRequiredMsg">*</span></span>
                        </td>
                        <td width="6">&nbsp;</td>
                        <td width="90">Fecha Solicitud</td>
                        <td width="261"><span id="sprytextfield2">
                          	<input type="date" name="fsolicitud" id="fsolicitud" value="<?php echo $fechasolicitud; ?>" />
                          	<span class="textfieldRequiredMsg">*</span></span>
                        </td>
                  </tr>
                  <tr>
                   		<td>Fecha Recibido</td>
                        <td><input type="date" name="frecibido" id="frecibido"  value="<?php echo $fechacierre; ?>"/></td>
                         <td>&nbsp;</td>
                         <td colspan="2">Proveedor / Direccion:
                       	   <span id="spryselect2">
                         	<label for="direccion"></label>
                            <select name="direccion" id="direccion" onchange="proveedor(this)">
                            	<?php
									if($id==''){
										opdireccionproveedor();
									}else{
										opdireccionproveedorsel($provdireccion);	
									}
								?>
                       	  	</select>
                       	 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                   </tr>
                    <tr>
                   		<td colspan="5" align="right"><input type="hidden" value="<?php echo (!empty($provdireccion))? $provdireccion:''; ?>" id="dir_pasar" name="dir_pasar" /></td>
                   </tr> 
                  
              </table>	
              
              <table>
              	<tr>
                	<td><input type="button" value="SE" onclick="estimacion('1')"/>
                    	<!--<input type="button" value="SH" onclick="estimacion('2')"/>-->
                    </td>
              	</tr>
              </table>
         <div class="datagrid">
              <table class="ventanapop" cellspacing="0" cellpadding="0" >
                <thead>
                <tr>
                  <th>Cod.</th>
                  <th>Producto</th>
                  <th>C. Minima</th>
                  <th>$$ Minima</th>
                  <th>Pedido</th>
                  <th>Und.</th>
                  <th>Valor Base</th>
                  <th>% IVA</th>
                  <th>Valor Gravado</th>
                  <th style="display:none">Cant. Recibida</th>
                  <th style="display:none">Fecha Recibido</th>
                  <th style="display:none">Recibió</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(count($arrid)==0){
                ?>
				<tr id="linea1">
                      <td width="200">
                      <input type="hidden" class="clsAnchoTotal"  name="l1" id="cl1" size="5" />
                      <input type="hidden" class="clsAnchoTotal"  name="b1" id="ca1" size="5"/>
                      <input type="text" readonly="readonly" name="a1" id="cb1" size="20"/>
                      <input type="button" value="+" onclick="ventana('1')"  style="display:inline" id="btnap1" /></td>
                      <td><input type="text" class="clsAnchoTotal"  readonly="readonly" name="c1"  id="cc1" size="40"/></td>
                      <td><input type="text" class="clsAnchoTotal"  name="m1"  id="cm1" /></td><!--cantidad minima-->
                      <td><input type="text" class="clsAnchoTotal"   name="n1"  id="cn1" /></td><!--precio minimo-->
                      <td><input type="text" class="clsAnchoTotal"   name="d1"  id="cd1" onblur="OnBlurInput(this,1)"/></td>
                      <td><input type="text" class="clsAnchoTotal"   name="e1"  id="ce1" size="3"/></td>
                      <td><input type="text" class="clsAnchoTotal"   name="f1"  id="cf1"/></td>
                      <td><input type="text" class="clsAnchoTotal"   name="g1"  id="cg1"/></td>
                      <td><input type="text" class="clsAnchoTotal"   name="h1"  id="ch1"/></td>
                      <td style="display:none"><input type="hidden" class="clsAnchoTotal"   name="i1"  id="ci1"/></td>
                      <td style="display:none"><input type="hidden" class="clsAnchoTotal"   name="j1"  id="cj1"/></td>
                      <td style="display:none"><input type="hidden" class="clsAnchoTotal"   name="k1"  id="ck1"/></td>
                      <td align="right" width="50"><input type="button" value="-" class="clsEliminarFila"></td>
               </tr>
               <?php
				}else{
			 			for($c=0;$c<count($arrid);$c++){
							$d=$c+1;
				?>
                	<tr id="linea<?php echo $d; ?>">
                      <td width="200">
                        <input type="hidden" class="clsAnchoTotal"  name="l<?php echo $d; ?>" id="cl<?php echo $d; ?>" size="5" value="<?php echo $arrid[$c]; ?>" /><!--Id de la linea OC-->
                      	<input type="hidden" class="clsAnchoTotal"  name="b<?php echo $d; ?>" id="ca<?php echo $d; ?>" size="5" value="<?php echo $arrk[$c]; ?>" /><!--Id proveedorproducto-->
                      	<input type="text" readonly="readonly" name="a1" id="cb<?php echo $d; ?>" size="20" value="<?php echo $arra[$c]; ?>"/><!--codigo de barras-->
                        <input type="button" value="AP" onclick="ventana('<?php echo $d; ?>')"  style="display:inline" disabled="disabled" id="btnap<?php echo $d; ?>"  />
                      </td>
                      <td><input type="text" class="clsAnchoTotal"  readonly="readonly" name="c<?php echo $d; ?>"  id="cc<?php echo $d; ?>" value="<?php echo $arrb[$c]; ?>"/></td>
                      <td><input type="text" class="clsAnchoTotal"   name="m<?php echo $d; ?>"  id="cm<?php echo $d; ?>" value="<?php echo $arrm[$c]; ?>"/></td><!--cantidad minima-->
                      <td><input type="text" class="clsAnchoTotal"   name="n<?php echo $d; ?>"  id="cn<?php echo $d; ?>" value="<?php echo $arrn[$c]; ?>"/></td><!--precio minimo-->
                      <td><input type="text" class="clsAnchoTotal"   name="d<?php echo $d; ?>"  id="cd<?php echo $d; ?>" value="<?php echo $arrc[$c]; ?>" onblur="OnBlurInput(this,<?php echo $d; ?>)"/></td><!--cantidad pedida-->
                      <td><input type="text" class="clsAnchoTotal"   name="e<?php echo $d; ?>"  id="ce<?php echo $d; ?>" value="<?php echo $arrd[$c]; ?>"/></td><!--Unidad del Producto-->
                      <td><input type="text" class="clsAnchoTotal"   name="f<?php echo $d; ?>"  id="cf<?php echo $d; ?>" value="<?php echo $arre[$c]; ?>"/></td><!--Valor Base-->
                      <td><input type="text" class="clsAnchoTotal"   name="g<?php echo $d; ?>"  id="cg<?php echo $d; ?>" value="<?php echo $arrf[$c]; ?>"/></td><!--Porcentaje IVA-->
                      <td><input type="text" class="clsAnchoTotal"   name="h<?php echo $d; ?>"  id="ch<?php echo $d; ?>" value="<?php echo $arrg[$c]; ?>"/></td><!--Valor Gravado-->
                      <td style="display:none"><input type="text" class="clsAnchoTotal"   name="i<?php echo $d; ?>"  id="ci<?php echo $d; ?>" value="<?php echo $arrh[$c]; ?>"/></td><!--Cant Recibida-->
                      <td style="display:none"><input type="text" class="clsAnchoTotal"   name="j<?php echo $d; ?>"  id="cj<?php echo $d; ?>" value="<?php echo $arri[$c]; ?>"/></td><!--Fecha Recibido-->
                      <td style="display:none"><input type="text" class="clsAnchoTotal"   name="k<?php echo $d; ?>"  id="ck<?php echo $d; ?>" value="<?php echo $arrj[$c]; ?>"/></td><!--Recibio-->
                      <td align="right"><input type="button" value="-" class="clsEliminarFila"></td>
               		</tr>
                
                
                <?php
						}
					}
				?>	
                
                </tbody>
               <tfoot>
           		<tr>
						<td colspan="13" align="right">
							<?php
						    if(empty($_GET['view'])){
							?>
							<input type="button" value="Agregar una fila" class="clsAgregarFila" id="agregar">
                            <input type="hidden" name="valorded" id="valorded" value="<?php echo ($d>0)? $d:'1'; ?>"/>
                            <input type="hidden" name="cantidad2" id="cantidad2" value="<?php echo ($d>0)? $d:'1'; ?>"/>
							<input type="hidden" name="cantidad" id="cantidad" />
                            <input type="hidden" name="eliminadas" id="eliminadas" />
                            <input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>"/>
                            <input type="submit" value="Enviar" name="Guardar" />
                            <?php
							}
							?>
							
                            <!--<input type="button" value="Clonar la tabla" class="clsClonarTabla">
							<input type="button" value="Eliminar la tabla" class="clsEliminarTabla">-->
						</td>
					</tr>
				</tfoot>
                </table>
            
           
           
       </div>  
       <br/>
       		<!--Totales de OC -->
           <table class="sinbordes" align="right" >
                            	<tr>
                                    <td>Total Base</td>
                                    <td><input type="text" value="<?php echo $totalsiniva; ?>" id="ttbase" /></td>
                                    <td>&nbsp;</td>
                                    <td>Total IVA</td>
                                    <td><input type="text" value="<?php echo $totaliva; ?>" id="ttiva" /></td>
                                    <td>&nbsp;</td>
                                    <td>Total Gravado</td>
                                    <td><input type="text" value="<?php echo $totalconiva; ?>" id="ttgravado"/></td>
                                </tr>
           </table>
       <br/>    
  </form>

  <?php
			}
			
			?>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<script type="text/javascript" src="js/manipulacion2.js"></script>
</body>
</html>