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
	opener.location.href = "../acceso.php?com_pg=9";
    window.close();
}

$(document).ready(function(){
	$(':checkbox[readonly=readonly]').click(function(){
		return false;         
	}); 
}); 

function array_unique(array){
  return array.filter(function(elm, i, array){
      return (array.indexOf(elm, i + 1) < 0);
    });
}

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };

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
	$RFIDS='';
	$XRFIDS='';
	$id_rfid='';
	
	//Creacion de variables fijas
	$noorden="";
	$fechasolicitud=date("Y-m-d");
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
	if(!empty($_GET['orden'])){
		
				// Datos Generales Orden de Compra
				$id=$_GET['orden'];
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
				if($estadoid<5){
					echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
					die('La orden de Compra no ha sido Revisada, hasta que el procedimiento de revision no se realice no es posible Verificar Productos');						
				}
				
				//Busqueda de los producto asociados a una orden de compra existente
				$bproductos=mysql_query("SELECT com_inventario.*,com_productos.nombre as producto, com_productos.codbarras,com_productosorden.fecharecibido,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as verificador,com_unidades.nombre as unidad,com_movimientosproductos.Id as existe FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_productosorden ON com_productosorden.Id=com_inventario.lineaoc_id
LEFT JOIN com_usconect ON com_usconect.Id=com_inventario.verificado_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
LEFT JOIN com_movimientosproductos ON com_movimientosproductos.inventario_id=com_inventario.Id
WHERE com_productosorden.orden_id='$id' and com_inventario.estado!='0'",$conexion);

			while($resultado=mysql_fetch_assoc($bproductos)){
					$indice=$resultado['RFID'];
					$arrid[$indice]=$resultado['Id'];					//Id de la linea de inventario
					$arra[$indice]=$resultado['fechaverificado'];		//fecha de verificado
					$arrb[$indice]=$resultado['RFID'];					//Codigo RFID
					$arrc[$indice]=$resultado['cantidad'];				//Cantidad Actual del Rollo
					$arrd[$indice]=($resultado['estado']==2)? $resultado['estado']:1;				//Estado Actual
					$arre[$indice]=$resultado['lineaoc_id'];			//Linea de la Orden Compra
					$arrf[$indice]=$resultado['cantidad_entrada'];		//Cantidad de Entrada
					$arrg[$indice]=$resultado['verificado_id'];			//Id del usuario que realiza la verificación en proceso
					$arrh[$indice]=$resultado['producto'];				//producto
					$arri[$indice]=$resultado['codbarras'];				//codigo de barras 
					$arrj[$indice]=$resultado['unidad'];				//Unidad en la que se mueve el producto ej: m
					$arrk[$indice]=$resultado['verificador'];			//Nombre del usuario que realiza la verificacion
					$arrl[$indice]=$resultado['existe'];				//Existencia del movimiento de producto apra no volver a ingresar
					$RFIDS.=$resultado['RFID'].",";
					$XRFIDS.="'".dechex($resultado['RFID'])."',";
			}
			$RFIDS=substr($RFIDS,0,-1);		//Retira la ultima coma de rfids
			$XRFIDS=substr($XRFIDS,0,-1);		//Retira la ultima coma de rfids
			
			
			//Verificación de RFID's pasados por el portal para entrada
			$ver_RFIDs=mysql_query("SELECT * FROM tags WHERE tag in ($XRFIDS) and antena in (1,2,3,4) and estado=2",$conexion);
			
			while($resultado=mysql_fetch_assoc($ver_RFIDs)){
					$indice=hexdec($resultado['tag']);
					if($arrd[$indice]!=2){
						$arrd[$indice]=2;
						$id_rfid.=$resultado['Id'].",";
					}
			}
			
			$id_rfid=substr($id_rfid,0,-1);
	}
	
	
	$tpwindow="Verificar ";	
	$productostt=count($arrid);
	
?>

<div id="contenidof4">
    	<h2> >> <?php echo $tpwindow; ?> Orden de Compra</h2>
			<?php
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
				$noverificadas=0;
				$id=$_POST['Id'];
				$rfids_ok=$_POST['idrfid'];
				$hoy=date('Y-m-d');
				
				/*Datos Basicos de la Orden de Compra*/
				$v2=$_POST['frecibido'];
				$cuantos=$_POST['cuantos'];
				
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
				
				for($b=1;$b<=$cuantos;$b++){
					
					$est1='c'.$b;		//nombre del producto
					$est2='d'.$b;		//unidad del producto
					$est3='l'.$b;		//numero linea de Inventario	---------------SI
					$est4='j'.$b;		//fechaverificado			-------------------SI
					$est5='m'.$b;		//RFID
					$est6='n'.$b;		//cantidad de entrada		-------------------SI
					$est7='o'.$b;		//estado actual				-------------------SI
					$est8='p'.$b;		//verificador_id			-------------------SI
					$est9='q'.$b;		//numero de la linea OC		-------------------SI
					$est10='r'.$b;		//numero linea en movimiento ------------------SI
					
					$vector1[$b]=$_POST[$est3];		//numero linea de Inventario
					$vector2[$b]=$_POST[$est4];		//fechaverificado	
					$vector3[$b]=$_POST[$est6];		//cantidad de entrada
					$vector4[$b]=(!empty($_POST[$est7]))? $_POST[$est7]:'';		//estado actual	
					$vector5[$b]=$_POST[$est8];		//verificador_id
					$vector6[$b]=$_POST[$est9];		//linea OC
					$vector7[$b]=$_POST[$est10];	//Movimiento Existente
						
					if(empty($_POST[$est7]) || $_POST[$est7]!='2'){
						$vector1[$b]="";		//numero linea de Inventario
						$vector2[$b]="";		//fechaverificado	
						$vector3[$b]="";		//cantidad de entrada
						$vector4[$b]="";		//estado actual	
						$vector5[$b]="";		//verificador_id
						$vector6[$b]="";		//linea OC
						$vector7[$b]="";	//Movimiento Existente
						$noverificadas+=1;
					}
					
					
				}
				
									
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				
/*ACTUALIZA ORDEN DE COMPRA ---------------- ---------------------------------------------------------------------------------------------------------------------*/
				
				if($noverificadas==0){
					$insertar=mysql_query("UPDATE com_ordencompra SET fecharecibido='$v2',estado_id='7' WHERE Id=$id");
					if(!$insertar)
					$error=1;
					
					$insertar=mysql_query("UPDATE com_productosorden SET estado_id='7' WHERE orden_id='$id' ");
					if(!$insertar)
					$error=1;
					
				}else{
					$insertar=mysql_query("UPDATE com_ordencompra SET fecharecibido='$v2',estado_id='6' WHERE Id=$id");
					if(!$insertar)
					$error=1;
				}
				

//ACTUALIZA DATOS EN COM_INVENTARIO Y CAMBIA ESTADO DE LA LINEA DE ORDEN DE COMPRA----------------------------------------------------------------------------//				 
				for($b=1;$b<=$cuantos;$b++){ 
					if($vector4[$b]=='2'){
						
						
						$insertar=mysql_query("UPDATE com_inventario SET estado='$vector4[$b]',verificado_id='$vector5[$b]',fechaverificado='$vector2[$b]' WHERE Id='$vector1[$b]'");
						if(!$insertar){
							$error=1;
						}
					
						$insertar=mysql_query("UPDATE com_productosorden SET estado_id='7' WHERE Id='$vector6[$b]' ");
						if(!$insertar)
						$error=1;
					
					
					}
				
/*INGRESA EL MOVIMIENTO A PRODUCTOS SI NO EXISTE AQUI TOCA CORREGIR DESPUES------------------------------------------------------------------*/
			
					/*if($vector7[$b]=='' && $vector4[$b]=='2'){
						inventario(1,$vector1[$b],$hoy,$vector3[$b],0,$iduser,$vector6[$b]);
					}*/
				
				}


//ACTUALIZAR ESTADO DE LOS RFID EN LA TABLA DE TAG'S -------------------------------//

					$insertar=mysql_query("UPDATE tags SET estado='1' WHERE Id in ($rfids_ok) ");
					if(!$insertar)
					$error=1;
				

/*REVISANDO ERRORES EN MYSQL --------------------------------------------------------------------------------------------------------------------------------------*/
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Verificación Guardada con éxito";
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
                        <td><!--<input type="button" onclick="revverificar('<?php echo $RFIDS; ?>','<?php echo $iduser; ?>','<?php echo $user; ?>',<?php echo $productostt; ?>)" name="btn1" id="btn1" value="Escanear" />--></td>
                  </tr>
                  <tr>
                   		<td>Fecha Recibido</td>
                        <td><input type="date" name="frecibido" id="frecibido" readonly="readonly" value="<?php echo $fechacierre; ?>"/></td>
                         <td>&nbsp;</td>
                         <td colspan="3">Proveedor / Direccion:
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
                  <th>RFID</th>
                  <th>Cantidad </th>
                  <th>Und.</th>
                  <th>Verificador</th>
                  <th>Fecha</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
              	 <?php
				 		//Obteniendo vector de indices
						$vc_indices=explode(",",$RFIDS);
						$e_ver=0;				 
			 			for($c=0;$c<count($vc_indices);$c++){
							$pos_indi=$vc_indices[$c];		//Posición del vector para recorrido
							$d=$c+1;						//Asignación de Nombre a la linea
							if($arrd[$pos_indi]==2){
								$e_ver+=1;						
							}
				?>
                			<tr id="linea<?php echo $d; ?>">
                      			
                                <td width="140">
                                	<!--Id de la linea en inventario-->
                               		<input type="hidden" class="small_2"  name="l<?php echo $d; ?>" id="cl<?php echo $d; ?>" size="5" value="<?php echo $arrid[$pos_indi]; ?>" />
                                    
                                    <!--Id de la linea en productosorden-->
                                    <input type="hidden" class="small_2"  name="q<?php echo $d; ?>" id="cq<?php echo $d; ?>" size="5" value="<?php echo $arre[$pos_indi]; ?>" />     
                            		
                                    <!--Id de la linea en movimientos productos-->            
                         			<input type="hidden" class="small_2"  name="r<?php echo $d; ?>" id="cr<?php echo $d; ?>" size="5" value="<?php echo $arrl[$pos_indi]; ?>" />        
                                    
                                    
                         			<!--codigo de barras-->           
                        			<input type="text" readonly="readonly" name="a<?php echo $d; ?>" id="cb<?php echo $d; ?>" size="10" value="<?php echo $arri[$pos_indi]; ?>" class="small_2"/>
                        
                            	</td>
                      
                      			<td>
                                	<!--Producto-->
                      				<input type="text" class="small_2"  readonly="readonly" name="c<?php echo $d; ?>"  id="cc<?php echo $d; ?>" value="<?php echo $arrh[$pos_indi]; ?>"/>
                      			</td>
                      
                      			<td  width="60px">
                                	<!--RFID-->
                                	<input type="text" class="small_2"  name="m<?php echo $d; ?>"  id="cm<?php echo $d; ?>" value="<?php echo $arrb[$pos_indi]; ?>" readonly="readonly"/>
                                </td>
                                
                      			<td width="60px">
                                	<!--cantidad-->
                                	<input type="text" class="small_2"   name="n<?php echo $d; ?>"  id="cn<?php echo $d; ?>" value="<?php echo $arrc[$pos_indi]; ?>" readonly="readonly"/>
                                </td>
                                
                      			<td width="60px">
                                	<!--unidad-->
                                	<input type="text" class="small_2"  name="d<?php echo $d; ?>"  id="cd<?php echo $d; ?>" value="<?php echo $arrj[$pos_indi]; ?>" readonly="readonly"/>
                                </td>
                      
                      			<td>
                      				<!--Verifico Nombre-->
                                    <input type="text" class="clsAnchoTotal"   name="k<?php echo $d; ?>"  id="ck<?php echo $d; ?>" value="<?php echo ($arrd[$pos_indi]==2)? $user:$arrk[$pos_indi]; ?>" readonly="readonly"/>
                                    
                                    <!--Verifico Id ---->
                      				<input type="hidden" class="clsAnchoTotal"   name="p<?php echo $d; ?>"  id="cp<?php echo $d; ?>" value="<?php echo ($arrd[$pos_indi]==2)? $iduser:$arrg[$pos_indi]; ?>" readonly="readonly"/>			 
                                </td>
                                
                     			<td>
                                	<!--Fecha Recibido-->
                                	<input type="text" class="clsAnchoTotal"   name="j<?php echo $d; ?>"  id="cj<?php echo $d; ?>" value="<?php echo $fechasolicitud; ?>" readonly="readonly"/>
                                </td>
                                
                     			<td align="right">
                     				<!--Check verificado -->
                             		<input type="checkbox" name="o<?php echo $d; ?>" id="co<?php echo $d; ?>" <?php echo ($arrd[$pos_indi]!='2')? "":"checked"; ?> value="2" readonly="readonly"/>  
                     			</td>
                                
                                
               		</tr>
                
                
                <?php
						}
						$nose=$d;
				?>	
                
                </tbody>
               <tfoot>
           		<tr>
						<td colspan="13" align="right">
							<?php
						    if(empty($_GET['view'])){
							?>
							<!--<input type="button" value="Agregar una fila" class="clsAgregarFila">-->
                            <input type="hidden" value="<?php echo $nose; ?>" name="cuantos" id="cuantos" />
							<input type="hidden" value="<?php echo $id_rfid; ?>" name="idrfid" id="idrfid" />
                            
                            <input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>"/>
                            <input type="submit" value="Enviar" name="Guardar" <?php echo ($e_ver==$nose)? '':'disabled="disabled"'; ?> id="Guardar" />
							<?php
							}
							?>
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