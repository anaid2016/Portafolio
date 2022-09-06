<?php include("../funciones/seguridad.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asignación de Tareas en Bodega - Pedidos</title>
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


</script>
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
	
	
	
	
	$d=0;
	$id='';
	if(!empty($_GET['pedido'])){
		
				// Busqueda del proveedor
				$id=$_GET['pedido'];
				$buscar=mysql_query("SELECT com_pedidos.nopedido,com_pedidos.fechapedido,com_inventario.RFID,com_arraybodega.nombre as ubicacion,
com_productos.nombre as producto,com_productos.codbarras,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as responsable,
com_productospedido.Id as idlinea,com_productospedido.cantidadpedida,com_unidades.nombre,com_pedidos.Id,
CONCAT_WS(',',com_direccionclientes.direccion,com_ciudad.ciudad) as direccion,com_clientes.nombres
FROM com_productospedido 
LEFT JOIN com_inventario ON com_inventario.Id=com_productospedido.inventario_id
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
LEFT JOIN com_pedidos ON com_pedidos.Id=com_productospedido.pedido_id
LEFT JOIN com_usconect ON com_usconect.Id=com_pedidos.userbodega_id 
LEFT JOIN com_direccionclientes ON com_direccionclientes.Id=com_pedidos.direccioncliente_id
LEFT JOIN com_clientes ON com_clientes.Id=com_direccionclientes.cliente_id
LEFT JOIN com_ciudad ON com_ciudad.Id=com_direccionclientes.ciudad_id 
WHERE com_pedidos.Id='$id'",$conexion);
				$d=mysql_num_rows($buscar);
				while($resultado=mysql_fetch_assoc($buscar)){
					$nopedido=$resultado['nopedido'];
					$fechapedido=$resultado['fechapedido'];
					$idpedido=$resultado['Id'];
					$responsable=$resultado['responsable'];
					$cliente=$resultado['nombres'];
					$direccion=$resultado['direccion'];
					
					
					//Arrays de productos ----------------------------------------------
					array_push($arrid,$resultado['idlinea']);			//Id de la linea de inventario
					array_push($arra,$resultado['cantidadpedida']);		//Cantidad pedida
					array_push($arrb,$resultado['RFID']);				//Codigo RFID
					array_push($arrc,$resultado['ubicacion']);			//Ubicación 
					array_push($arrd,$resultado['producto']);			//Producto
					array_push($arre,$resultado['codbarras']);			//Codigo de barras
					array_push($arrf,$resultado['nombre']);				//Nombre de la Unidad del producto
				}
				
								
	}
	
	
	$tpwindow="Asignar a Bodega ";	
	
?>

<div id="contenidof3">
    	<h2> >> <?php echo $tpwindow; ?> Despacho de Pedido</h2>
			<?php
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
				$id=$_POST['idpedido'];
				$resp=$_POST['auxiliar'];
								
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				
					$insertar=mysql_query("UPDATE com_pedidos SET estado_id='3',userbodega_id='$resp' WHERE Id=$id");
					if(!$insertar)
					$error=1;
					

					$insertar=mysql_query("UPDATE com_productospedido SET estado_id='3' WHERE pedido_id='$id'");
					if(!$insertar){
						$error=1;
					}
					
					
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
				<table width="1000" class="formulario">
					<tr>
                    	<td width="90">No de Pedido:</td>
                        <td width="149"><?php echo $nopedido; ?></td>
                        <td width="6">&nbsp;</td>
                        <td width="90">Fecha Pedido</td>
                        <td width="261"><?php echo $fechapedido; ?></td>
                        <td>Asignar en Bodega:
                        <select name="auxiliar">
							<?php
                                opciones($conexion,"com_usconect","Id","CONCAT_WS(' ',nombre,apellidos)","WHERE perfil_id='4' ")
                            ?>
                        </select>
                        </td>
                        <td><input type="submit" value="Asignar" name="Guardar" /></td>
                  </tr>
                  <tr>
                   		<td>Cliente:</td>
                        <td><?php echo $cliente; ?></td>
                        <td>&nbsp;</td>
                        <td>Direcciòn:</td>
                        <td colspan="2" align="left"><?php echo $direccion; ?></td>
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
                  <th>Ubicacion</th>
                </tr>
                </thead>
                <tbody>
              	 <?php
			 			for($c=0;$c<$d;$c++){
				?>
                	<tr>
                      <td width="140"><?php echo $arre[$c]; ?></td>
                      <td><?php echo $arrd[$c]; ?></td>
                      <td><?php echo $arrb[$c]; ?></td>
                      <td><?php echo $arra[$c]; ?></td>
                      <td><?php echo $arrf[$c]; ?></td>
                      <td><?php echo $arrc[$c]; ?></td>
               		</tr>
                
                
                <?php
						}
				?>	
                
                </tbody>
               	<tfoot>
           			<tr>
                    	<input type="hidden" name="idpedido" value="<?php echo $id; ?>" />
					</tr>
				</tfoot>
                </table>
            
           
           
       </div>  
	</form>	    
  <?php
			}
			
			?>
</div>
</body>
</html>