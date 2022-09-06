<?php 
include("../funciones/seguridad.php"); 
include("../funciones/comx_dbconn.php"); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Orden de Compra</title>
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>
<script type="text/javascript" src="js/jquery1-9new.js"></script>
<script type="text/javascript" src="js/jquery10-2.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script> 
 function Cerrar(){
	opener.location.href = "../acceso.php?com_pg=5";
    window.close();
}

 function ventana(filita){
	 	proveedor=document.getElementById('direccion').value;
		myWindow=window.open("popuplistadoproductos.php?prov="+proveedor+"&fila="+filita+"",'','width=1024,height=600');
		myWindow.focus();
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
 
 function OnBlurRecep(tipo,vinput,usuario,idusuario){
	var dfila=vinput;
 	var recibido=tipo.value;
	
	//Obteniendo Fecha -----------------------------------------//
	var myDate = new Date();
	var myDate_string = myDate.toISOString();
	var myDate_string = myDate_string.replace("T"," ");
	var myDate_string = myDate_string.substring(0, myDate_string.length - 5);
	
	
	if(Number(recibido)>0){
		document.getElementById('co'+dfila).checked=true;
		document.getElementById('ck'+dfila).value=usuario;
		document.getElementById('cp'+dfila).value=idusuario;
		document.getElementById('cj'+dfila).value=myDate_string;
	}
 }

</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	
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
	$arro=array();
	$arrp=array();
	$arrq=array();
	
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
				$buscar=mysql_query("SELECT com_ordencompra.*,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as creado,com_estadooc.nombre FROM com_ordencompra 
LEFT JOIN com_usconect ON com_usconect.Id=com_ordencompra.usuario_id
LEFT JOIN com_estadooc ON com_estadooc.Id=com_ordencompra.estado_id WHERE com_ordencompra.Id='$id'",$conexion);

				while($resultado=mysql_fetch_assoc($buscar)){
					$noorden=$resultado['noorden'];
					$fechasolicitud=$resultado['fechasolicitud'];
					$fechacierre=($resultado['fecharecibido']!='0000-00-00')? $resultado['fecharecibido']:gmdate('Y-m-d');
					$provdireccion=$resultado['direccionproveedor_id'];
					$totalsiniva=$resultado['totalantesiva'];
					$totaliva=$resultado['totaliva'];
					$totalconiva=$resultado['totalconiva'];
					$userid=$resultado['usuario_id'];
					$estadoid=$resultado['estado_id'];
					$usercreo=$resultado['creado'];
					$estado=$resultado['nombre'];
				}
			
				//Orden de Compra e Estado de Revision o con productos pendientes ----------------------
				if($estadoid!=4){
					echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
					die('Asigne estado de Revisi&oacute;n a la OC antes de Revizar los productos');						
				}
				
				//Busqueda de los producto asociados a una orden de compra existente
				
				$bproductos=mysql_query("SELECT com_productosorden.*,com_productos.codbarras,com_productos.nombre as producto,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as usuario,com_unidades.nombre
FROM com_productosorden 
LEFT JOIN com_ordencompra ON com_productosorden.orden_id=com_ordencompra.Id
LEFT JOIN com_proveedorproductos ON com_proveedorproductos.Id=com_productosorden.proveedorproducto_id
LEFT JOIN com_productos ON com_proveedorproductos.producto_id=com_productos.Id
LEFT JOIN com_usconect ON com_usconect.Id=com_productosorden.usuario_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id WHERE com_ordencompra.Id='$id'",$conexion);


			while($resultado=mysql_fetch_assoc($bproductos)){
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
					array_push($arro,$resultado['revisado']);
					array_push($arrp,$resultado['usuario_id']);
					array_push($arrq,$resultado['rollos']);
			}
			

	}
	
	
	$tpwindow="Revizar ";	
	
?>

<div id="contenidof2">
    	<h2> >> <?php echo $tpwindow; ?> Orden de Compra</h2>
			<?php
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
				$sinrevizar=0;
				$id='';
				$hoy=gmdate('Y-m-d');
				
				/*Datos Basicos de la Orden de Compra*/
				$v2=$_POST['frecibido'];
				
				
				if(!empty($_POST['cantidad2']) && $_POST['cantidad2']>0){
					$cantidad=$_POST['cantidad2'];
				}else{
					$cantidad=$_POST['cantidad'];
				}
				
				if(!empty($_POST['Id'])){
					$id=$_POST['Id'];
				}
				
				$vector2=array();
				$vector7=array();
				$vector8=array();
				$vector10=array();
				$vector13=array();
				$vector14=array();
				$vector15=array();
				
				for($b=1;$b<=$cantidad;$b++){
					
					$est2='d'.$b;		//cantidad que se habia pedido
					$est7='i'.$b;		//cantidad recibida
					$est8='j'.$b;		//fecha de recibido
					$est10='l'.$b;		//id de la linea a modificar
					$est13='p'.$b;		//id del que recibio
					$est14='o'.$b;		//checkeo de revizado
					$est15='q'.$b;	
					//echo $_POST['o1'];
					
					$vector2[$b]=$_POST[$est2];
					$vector7[$b]=$_POST[$est7];
					//echo $_POST[$est2]."----".$_POST[$est7];
			
					if(($_POST[$est2]-$_POST[$est7])==0){
						$vector14[$b]=1;
					}else if(($_POST[$est2]-$_POST[$est7])>0 and $_POST[$est7]>0){
						$vector14[$b]=2;
						$sinrevizar+=1;
					}else if($_POST[$est7]==0 and $_POST[$est14]!='1'){
						$vector14[$b]=0;
						$sinrevizar+=1;
					}
				
					$vector8[$b]=$_POST[$est8];
					$vector10[$b]=$_POST[$est10];
					$vector13[$b]=($_POST[$est13]>0)? $_POST[$est13]:'';
					$vector15[$b]=$_POST[$est15];
					
				}
				
				/*$erroresOC=mysql_query("SELECT GROUP_CONCAT(Id) FROM com_ordenpendiente WHERE orden_id='$id'",$conexion);
				$todas_corregidas=mysql_fetch_row($erroresOC);
				$borradas=$todas_corregidas[0];*/
				
				
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				
/*INSERTA O ACTUALIZA DATOS EN LA TABLA ORDEN COMPRA ---------------------------------------------------------------------------------------------------------------------*/
				$insertar=mysql_query("UPDATE com_ordencompra SET fecharecibido='$v2',estado_id='4' WHERE Id=$id");
				if(!$insertar)
				$error=1;
				
				 
				for($b=1;$b<=$cantidad;$b++){ 
						$insertar=mysql_query("UPDATE com_productosorden SET cantidarecibida='$vector7[$b]',fecharecibido='$vector8[$b]',usuario_id='$vector13[$b]',estado_id='4',revisado='$vector14[$b]',rollos='$vector15[$b]' WHERE Id='$vector10[$b]'");
				
					if(!$insertar){
						$error=1;
					}
					
				}
				
/*ASIGNAR FALTANTES PENDIENTE SI EXISTEN -----------------------------------------------------------------------------------------------------------------------------*/
			
				if($sinrevizar>0){
					$insertar=mysql_query("DELETE FROM com_ordenpendiente WHERE orden_id='$id'");
					if(!$insertar){
							$error=1;
					}
					
					$insertar=mysql_query("INSERT INTO com_ordenpendiente SET orden_id='$id',fechaingreso='$hoy',estado='Abierta',cantidadpendiente='$sinrevizar'");
					if(!$insertar){
						$error=1;
					}
				}
				
				
				//Consultando por busqueda de errores o arreglos antes de cambio
				if($sinrevizar==0){
					$insertar=mysql_query("DELETE FROM com_ordenpendiente WHERE orden_id='$id'");
					if(!$insertar){
						$error=1;
					}
				}

/*REVISANDO ERRORES EN MYSQL --------------------------------------------------------------------------------------------------------------------------------------*/
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Orden de Compra Revisada con éxito";
				}
				
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',2000);</script>"; 
			}else{
               

            ?>
            <p>Diligencie el formulario en su totalidad y de clic en Guardar:</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="other">
				<table width="1200" class="formulario">
					<tr>
                    	<td width="90">No de Orden:</td>
                        <td width="149"><span id="sprytextfield1">
                          		<input type="text" name="noorden" id="noorden" readonly="readonly" value="<?php echo $noorden; ?>" />
                          		<span class="textfieldRequiredMsg">*</span></span>
                        </td>
                        <td width="6">&nbsp;</td>
                        <td width="90">Fecha Solicitud</td>
                        <td width="261"><span id="sprytextfield2">
                          	<input type="date" name="fsolicitud" id="fsolicitud" value="<?php echo $fechasolicitud; ?>" readonly="readonly"/>
                          	<span class="textfieldRequiredMsg">*</span></span>
                        </td>
                  </tr>
                  <tr>
                   		<td>Fecha Recibido (<?php echo $fechacierre; ?>)</td>
                        <td><input type="date" name="frecibido" id="frecibido" readonly="readonly" value="<?php echo gmdate('Y-m-d'); ?>"/></td>
                         <td>&nbsp;</td>
                         <td colspan="2">Proveedor / Direccion:
                       	   <span id="spryselect2">
                         	<label for="direccion"></label>
                         	<select name="direccion" id="direccion" disabled="disabled">
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
                   		<td colspan="5" align="right">&nbsp;</td>
                   </tr> 
                  
              </table>	
              
              <br/>
              <br/>
         <div class="datagrid">
              <table class="ventanapop" cellspacing="0" cellpadding="0" width="1450">
                <thead>
                <tr>
                  <th>Cod.</th>
                  <th>Producto</th>
                  <th>Cant Min</th>
                  <th>$Minima</th>
                  <th>Pedido</th>
                  <th>Und.</th>
                  <th>$ Base</th>
                  <th>IVA</th>
                  <th>$ Gravado</th>
                  <th>No. Rollos</th>
                  <th>Cant. Rec.</th>
                  <th>Fecha Rec.</th>
                  <th>Recibió</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
              	 <?php
			 			for($c=0;$c<count($arrid);$c++){
							$d=$c+1;
				?>
                	<tr id="linea<?php echo $d; ?>">
                      <td width="80">
                        <input type="hidden" class="clsAnchoTotal"  name="l<?php echo $d; ?>" id="cl<?php echo $d; ?>" size="5" value="<?php echo $arrid[$c]; ?>" /><!--Id de la linea OC-->
                      	<input type="hidden" class="clsAnchoTotal"  name="b<?php echo $d; ?>" id="ca<?php echo $d; ?>" size="5" value="<?php echo $arrk[$c]; ?>" /><!--Id proveedorproducto-->
                      	<input type="text" readonly="readonly" name="a1" id="cb<?php echo $d; ?>" size="15" value="<?php echo $arra[$c]; ?>" class="small_2"/><!--codigo de barras-->
                        <!--<input type="button" value="AP" onclick="ventana('<?php echo $d; ?>')"  style="display:inline" disabled="disabled" id="btnap<?php echo $d; ?>"  />-->
                      </td>
                      <td><input type="text" class="small_2" class="clsAnchoTotal"  readonly="readonly" name="c<?php echo $d; ?>"  id="cc<?php echo $d; ?>" value="<?php echo $arrb[$c]; ?>" size="40"  /></td>
                      <td><input type="text" class="small_2"   name="m<?php echo $d; ?>"  id="cm<?php echo $d; ?>" value="<?php echo $arrm[$c]; ?>" readonly="readonly" size="10" /></td><!--cantidad minima-->
                      <td><input type="text" class="small_2"   name="n<?php echo $d; ?>"  id="cn<?php echo $d; ?>" value="<?php echo $arrn[$c]; ?>" readonly="readonly" size="10" /></td><!--precio minimo-->
                      <td><input type="text" class="small_2"   name="d<?php echo $d; ?>"  id="cd<?php echo $d; ?>" value="<?php echo $arrc[$c]; ?>" readonly="readonly" size="10"/></td><!--cantidad pedida-->
                      <td><input type="text" class="small_2"   name="e<?php echo $d; ?>"  id="ce<?php echo $d; ?>" value="<?php echo $arrd[$c]; ?>" readonly="readonly" size="3"/></td><!--Unidad del Producto-->
                      <td><input type="text" class="small_2"   name="f<?php echo $d; ?>"  id="cf<?php echo $d; ?>" value="<?php echo $arre[$c]; ?>" readonly="readonly" size="10"/></td><!--Valor Base-->
                      <td><input type="text" class="small_2"   name="g<?php echo $d; ?>"  id="cg<?php echo $d; ?>" value="<?php echo $arrf[$c]; ?>" readonly="readonly" size="5"/></td><!--Porcentaje IVA-->
                      <td><input type="text" class="small_2"   name="h<?php echo $d; ?>"  id="ch<?php echo $d; ?>" value="<?php echo $arrg[$c]; ?>" readonly="readonly" size="10"/></td><!--Valor Gravado-->
                       <td><input type="text" class="clsAnchoTotal"   name="q<?php echo $d; ?>"  id="cq<?php echo $d; ?>" value="<?php echo $arrq[$c]; ?>" size="10"/></td><!--cantidad en rollos-->
                       
                      <td><input type="text" class="clsAnchoTotal"   name="i<?php echo $d; ?>"  id="ci<?php echo $d; ?>" value="<?php echo $arrh[$c]; ?>" onblur="OnBlurRecep(this,<?php echo $d; ?>,'<?php echo $user;?>',<?php echo $iduser; ?>)" size="10"/></td><!--Cant Recibida-->
                      <td><input type="text" class="small_2"   name="j<?php echo $d; ?>"  id="cj<?php echo $d; ?>" value="<?php echo $arri[$c]; ?>" readonly="readonly"/></td><!--Fecha Recibido-->
                      <td>
                      	<input type="text" class="small_2"   name="k<?php echo $d; ?>"  id="ck<?php echo $d; ?>" value="<?php echo $arrj[$c]; ?>" readonly="readonly"/><!--Recibio Nombre-->
                      	<input type="hidden" class="clsAnchoTotal"   name="p<?php echo $d; ?>"  id="cp<?php echo $d; ?>" value="<?php echo $arrp[$c]; ?>" readonly="readonly"/><!--Recibio Id ---->
                      </td>
                      <td align="right"><input type="checkbox" name="o<?php echo $d; ?>" id="co<?php echo $d; ?>" <?php echo ($arro[$c]!='0')? "checked":""; ?> value="1" />  </td>
               		</tr>
                
                
                <?php
						}

				?>	
                
                </tbody>
               <tfoot>
           		<tr>
						<td colspan="14" align="right">
							<?php
						    if(empty($_GET['view'])){
							?>
							<!--<input type="button" value="Agregar una fila" class="clsAgregarFila">-->
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
                                    <td><input type="text" value="<?php echo $totalsiniva; ?>" id="ttbase" readonly="readonly"/></td>
                                    <td>&nbsp;</td>
                                    <td>Total IVA</td>
                                    <td><input type="text" value="<?php echo $totaliva; ?>" id="ttiva" readonly="readonly"/></td>
                                    <td>&nbsp;</td>
                                    <td>Total Gravado</td>
                                    <td><input type="text" value="<?php echo $totalconiva; ?>" id="ttgravado" readonly="readonly"/></td>
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