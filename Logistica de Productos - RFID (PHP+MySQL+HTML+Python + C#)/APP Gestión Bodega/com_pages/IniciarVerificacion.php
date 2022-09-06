<?php include("../funciones/seguridad.php"); ?>
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
	opener.location.href = "../acceso.php?com_pg=8";
    window.close();
}

$(document).ready(function(){
	$(':checkbox[readonly=readonly]').click(function(){
		return false;         
	}); 
}); 

//Funciones de trim---
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
	$RFIDS='';
	$XRFIDS='';
	$id_rfid='';
	
	//Creacion de variables fijas
	$nopedido="";
	$fechapedido="";
	$direccion="";
	$totalsiniva="";
	$totaliva="";
	$totalconiva="";
	$responsable="";
	$estadoid="";
	$cliente="";
	
	$d=0;
	$id='';
	if(!empty($_GET['pedido'])){
		
				// Buscando los datos generales del Pedido ===============================================================
				$id=$_GET['pedido'];
				$buscar="SELECT com_pedidos.*,com_direccionclientes.direccion,com_ciudad.ciudad,
com_clientes.nombres,com_usconect.nombre as bodega,com_direccionclientes.Id as direccionc FROM com_pedidos
LEFT JOIN com_direccionclientes ON com_direccionclientes.Id=com_pedidos.direccioncliente_id
LEFT JOIN com_clientes ON com_clientes.Id=com_direccionclientes.cliente_id
LEFT JOIN com_ciudad ON com_direccionclientes.ciudad_id=com_ciudad.Id
LEFT JOIN com_usconect on com_usconect.Id=com_pedidos.userbodega_id
 WHERE com_pedidos.Id='$id'";


				if ($matriz = $enlace->query($buscar)) {
					while ($resultado = $matriz->fetch_assoc()) {
						$nopedido=$resultado['nopedido'];
						$fechapedido=$resultado['fechapedido'];
						$direccion=$resultado['direccionc'];
						$totalsiniva=$resultado['totalantesiva'];
						$totaliva=$resultado['totaliva'];
						$totalconiva=$resultado['totalconiva'];
						$responsable=$resultado['bodega'];
						$estadoid=$resultado['estado_id'];
					}
					$matriz->free();
				}
			
				
				
				
							
				//Evita verificaciones si aun no está alistado  =======================================================
				if($estadoid<7){
					echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
					die('El pedido no se encuentra Alistado, hasta que el procedimiento de Alistamiento no se realice no es posible Verificar Productos');						
				}
				
				//Busqueda de los producto asociados a un pedido existente ==============================================
				$bproductos="SELECT com_inventario.Id as idinventario,com_productospedido.cantidadpedida,com_productos.nombre as producto, com_productos.codbarras,com_inventario.estado,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as verificador,com_productospedido.Id as lineapedido,
com_unidades.nombre as unidad,com_inventario.RFID,com_inventario.fechasalida,com_usconect.Id as verificador_id,com_inventario.verificadosal_id FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_productospedido ON com_productospedido.inventario_id=com_inventario.Id
LEFT JOIN com_usconect ON com_usconect.Id=com_inventario.verificadosal_id
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
WHERE com_productospedido.pedido_id='$id'";


			if ($matriz = $enlace->query($bproductos)) {
				while ($resultado = $matriz->fetch_assoc()) {
					$indice=$resultado['RFID'];
					$arrid[$indice]=$resultado['idinventario'];			//Id de la linea de inventario
					$arra[$indice]=$resultado['fechasalida'];			//Fecha de Salida del Producto
					$arrb[$indice]=$resultado['RFID'];					//Codigo RFID
					$arrc[$indice]=$resultado['cantidadpedida'];		//Cantidad Actual del Rollo
					$arrd[$indice]=$resultado['estado'];				// 2 - Verificada para venta, 3 - Vendida
					$arre[$indice]=$resultado['lineapedido'];			//Linea de Pedido
					$arrg[$indice]=($resultado['verificadosal_id']=='')? $iduser:$resultado['verificadosal_id'];		//Id del usuario que realiza la verificación en proceso
					$arrh[$indice]=$resultado['producto'];				//Producto	
					$arri[$indice]=$resultado['codbarras'];				//codigo de barras	
					$arrj[$indice]=$resultado['unidad'];				//Unidad del producto
					$arrk[$indice]=($resultado['verificador']=='')? $user:$resultado['verificador'];			//Nombre del usuario que realiza la verificacion
					$arrm[$indice]=($arrd[$indice]==2)? 1:2;
					$RFIDS.=$resultado['RFID'].",";						//RFID en Hexadecimal
					$XRFIDS.="'".dechex($resultado['RFID'])."',";
				}
				$matriz->free();
			}

			$RFIDS=substr($RFIDS,0,-1);		//Retira la ultima coma de rfids
			$XRFIDS=substr($XRFIDS,0,-1);		//Retira la ultima coma de rfids
			
			
			//Verificación de RFID's pasados por el portal para entrada ============================================================
			$ver_RFIDs="SELECT * FROM tags WHERE tag in ($XRFIDS) and antena2 in (5,6,7,8) and estado=2";
			
			if ($matriz = $enlace->query($ver_RFIDs)) {
				while ($resultado = $matriz->fetch_assoc()) {
						$indice=hexdec($resultado['tag']);
						$arrm[$indice]=2;
						$id_rfid.=$resultado['Id'].",";
					
					if($arra[$indice]==''){
						$arra[$indice]=$resultado['fecha2'];
					}
				}
				$matriz->free();
			}
			$id_rfid=substr($id_rfid,0,-1);
	}
	

	mysqli_close($enlace);

	//ASIGNACIONES DE VENTANA ===========================================================================================================	
	$tpwindow="Verificar ";	
	$productostt=count($arrid);
	
?>

<div id="contenidof2">
    	<h2> >> <?php echo $tpwindow; ?> Pedido</h2>
			<?php
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
				
				
				$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
				$enlace->set_charset("utf8");
				$error_mysql=0;
				$enlace->autocommit(FALSE);
				
				$noverificadas=0;
				$id=$_POST['Id'];
				$hoy=gmdate('Y-m-d');
				$pedido=$_POST['nopedido'];
				
				//=========================================Variables y Vectores Asignados ========================================//
				$v2=$_POST['frecibido'];
				$cuantos=$_POST['cuantos'];
				$rfids_ok=$_POST['idrfid'];
				
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
					
					$est1='l'.$b;		//Id de la linea de inventario	-------------------SI
					$est2='q'.$b;		//I de la Linea de Productos Pedido	-------------------SI
					$est3='r'.$b;		//Id movimientos Producto		-------------------SI
					$est4='p'.$b;		//Id del verificador -------------------SI
					$est5='j'.$b;		//fecha de salid ------------------SI
					$est6='n'.$b;		//fecha de salid ------------------SI
					
					$vector1[$b]=$_POST[$est1];		
					$vector2[$b]=$_POST[$est2];			
					$vector3[$b]=$_POST[$est3];		
					$vector4[$b]=$_POST[$est4];			
					$vector5[$b]=$_POST[$est5];
					$vector6[$b]=$_POST[$est6];		
					
				}
				
									
				//ACTUALIZA EL ESTADO DEL PEDIDO==========================================================================================
				 
				 if(!$enlace->query("UPDATE com_pedidos SET estado_id='5' WHERE Id=$id")){
						$error_mysql=1;	
						$error_print="Error 001: Error al guardar Parámetros.";
			
				}				
				
				if(!$enlace->query(" UPDATE com_productospedido SET estado_id='5' WHERE pedido_id='$id' ")){
						$error_mysql=1;	
						$error_print="Error 002: Error al guardar Parámetros.";
			
				}
				
				//ACTUALIZA DATOS EN COM_INVENTARIO Y CAMBIA ESTADO DE LA LINEA DE ORDEN DE COMPRA =====================================	

				for($b=1;$b<=$cuantos;$b++){ 
					
						if(!$enlace->query("UPDATE com_inventario SET estado='3',verificadosal_id='$vector4[$b]',fechasalida='$vector5[$b]' WHERE Id='$vector1[$b]' ")){
							
							$error_mysql=1;	
							$error_print="Error 003: Error al guardar Parámetros.";
						}
						
						if(!$enlace->query("UPDATE com_productospedido SET estado_id='5' WHERE Id='$vector2[$b]' ")){
							$error_mysql=1;	
							$error_print="Error 004: Error al guardar Parámetros.";
						}
						
				
				
/*INGRESA EL MOVIMIENTO A PRODUCTOS SI NO EXISTE -----------------------------------------------------------------------------------------------------------------------------*/
			
						//inventario(2,$vector1[$b],$hoy,$vector6[$b],0,$iduser,$vector2[$b]);
						//echo "error 4:".$error;
				}
				
				if(!$enlace->query(" UPDATE tags SET estado='1',documento='$pedido' WHERE Id in ($rfids_ok) ")){
					$error_mysql=1;	
					$error_print="Error 005: Error al guardar Parámetros.";
				}
						
				
				

/*REVISANDO ERRORES EN MYSQL --------------------------------------------------------------------------------------------------------------------------------------*/
				
				if($error_mysql==1){
				$enlace->rollback();
					
				}else{
					$enlace->commit();	
					$error_print="Pedido Verificado con Exito";
				}
				$enlace->close();
		
				echo $error_print;
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',2000);</script>"; 
			
			}else{
               
			
            ?>
            <p>Diligencie el formulario en su totalidad y de clic en Guardar:</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="other">
				<table width="1200" class="formulario">
					<tr>
                    	<td class="titulos" >No de Pedido:</td>
               
                        <td width="149"><?php echo $nopedido; ?></td>
                      
                        <td class="titulos" >Fecha Solicitud</td>
               
                        <td width="261"><?php echo $fechapedido; ?></td>
               
                  </tr>
                  <tr>
                   		<td class="titulos">Fecha Recibido</td>
                        <td><input type="date" name="frecibido" id="frecibido" readonly="readonly" value="<?php echo $fechacierre; ?>"/></td>
                        
                        <td class="titulos">Cliente / Direccion:</td>
                        <td>
                       	   <span id="spryselect2">
                         	<label for="direccion"></label>
                         	<select name="direccion" id="direccion" disabled="disabled">
                            	<?php
									opdireccionclientesel($direccion);	
								?>
                       	  	</select>
                       	 <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                        </td>
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
				 
				 	$vc_indices=explode(",",$RFIDS);
					$e_ver=0;	
				 
			 			for($c=0;$c<count($arrid);$c++){
							$pos_indi=$vc_indices[$c];		//Posición del vector para recorrido
							$d=$c+1;						//Asignación de Nombre a la linea
							
							if($arrd[$pos_indi]==2){
								$e_ver+=1;						
							}
				?>
                	<tr id="linea<?php echo $d; ?>">
                      <td width="140">
                      
                      	<!--Id de la linea en inventario--> 
                        <input type="hidden" class="clsAnchoTotal"  name="l<?php echo $d; ?>" id="cl<?php echo $d; ?>" size="5" value="<?php echo $arrid[$pos_indi]; ?>" />          
                        
                        <!--Id de la linea en productospedido--> 
                        <input type="hidden" class="clsAnchoTotal"  name="q<?php echo $d; ?>" id="cq<?php echo $d; ?>" size="5" value="<?php echo $arre[$pos_indi]; ?>" />    
                        
                         <!--Id de la linea en movimientos productos-->    
                         <input type="hidden" class="clsAnchoTotal"  name="r<?php echo $d; ?>" id="cr<?php echo $d; ?>" size="5" value="<?php echo $arrl[$pos_indi]; ?>" />  
                         
                        <!--codigo de barras-->      
                        <input type="text" readonly="readonly" name="a<?php echo $d; ?>" id="cb<?php echo $d; ?>" size="10" value="<?php echo $arri[$pos_indi]; ?>" class="small"/>
                      
                      </td>
                      
                      <td>
                      <input type="text" class="clsAnchoTotal"  readonly="readonly" name="c<?php echo $d; ?>"  id="cc<?php echo $d; ?>" value="<?php echo $arrh[$pos_indi]; ?>"/></td>
                      
                      <!--RFID-->
                      <td>
                      <input type="text" class="clsAnchoTotal"   name="m<?php echo $d; ?>"  id="cm<?php echo $d; ?>" value="<?php echo $arrb[$pos_indi]; ?>" readonly="readonly"/>
                      </td>
                      
                      <!--cantidad-->
                      <td>
                      <input type="text" class="clsAnchoTotal"   name="n<?php echo $d; ?>"  id="cn<?php echo $d; ?>" value="<?php echo $arrc[$pos_indi]; ?>" readonly="readonly"/></td>
                      
                      <!--unidad-->
                      <td><input type="text" class="clsAnchoTotal"   name="d<?php echo $d; ?>"  id="cd<?php echo $d; ?>" value="<?php echo $arrj[$pos_indi]; ?>" readonly="readonly"/></td>
                      
                      
                      <!--Verifico Nombre-->
                      <td>
                      	<input type="text" class="clsAnchoTotal"   name="k<?php echo $d; ?>"  id="ck<?php echo $d; ?>" value="<?php echo $arrk[$pos_indi]; ?>" readonly="readonly"/>
                      	<input type="hidden" class="clsAnchoTotal"   name="p<?php echo $d; ?>"  id="cp<?php echo $d; ?>" value="<?php echo $arrg[$pos_indi]; ?>" readonly="readonly"/><!--Verifico Id ---->			 </td>
                     <td><input type="text" class="clsAnchoTotal"   name="j<?php echo $d; ?>"  id="cj<?php echo $d; ?>" value="<?php echo $arra[$pos_indi]; ?>" readonly="readonly"/></td><!--Fecha Recibido-->
                     <td align="right"><input type="checkbox" name="o<?php echo $d; ?>" id="co<?php echo $d; ?>" <?php echo ($arrd[$pos_indi]=='3' and empty($arrg[$c]))? "":"checked"; ?> value="2" readonly="readonly"/>  </td>
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
							<input type="text" value="<?php echo $id_rfid; ?>" name="idrfid" id="idrfid" />
                            <input type="hidden" value="<?php echo $nose; ?>" name="cuantos" id="cuantos" />
							<input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>"/>
                            <input type="hidden" name="nopedido" id="nopedido" value="<?php echo $nopedido; ?>" />
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
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<script type="text/javascript" src="js/manipulacion2.js"></script>
</body>
</html>