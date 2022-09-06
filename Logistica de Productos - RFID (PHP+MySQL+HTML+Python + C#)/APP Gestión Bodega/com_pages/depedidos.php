<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Proveedores</title>
<link rel="stylesheet" type="text/css" href="../css/menuinterno.css">
<link rel="stylesheet" type="text/css" href="../css/popupcss.css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script> 
 function Cerrar(Id){
	opener.location.href = "../acceso.php?com_pg=7";
    window.close();
}
</script>
</head>
<body>
	
<div id="contenidof2">
    <br/>
    <?php
	
			if(!empty($_GET['Id'])){
				// Busqueda del proveedor
				$id=$_GET['Id'];
				$buscar=mysql_query("SELECT com_pedidos.*,CONCAT_WS(',',com_direccionclientes.direccion,com_ciudad.ciudad) as direccion,com_estadopedido.nombre,com_clientes.nombres AS cliente
 FROM com_pedidos
LEFT JOIN com_direccionclientes ON com_direccionclientes.Id=com_pedidos.direccioncliente_id
LEFT JOIN com_clientes ON com_direccionclientes.cliente_id=com_clientes.Id
LEFT JOIN com_estadopedido ON com_estadopedido.Id=com_pedidos.estado_id
LEFT JOIN com_ciudad ON com_direccionclientes.ciudad_id=com_ciudad.Id 
WHERE com_pedidos.Id='$id' and com_pedidos.estado_id='1' ",$conexion);
				while($resultado=mysql_fetch_assoc($buscar)){
					$n1=$resultado['nopedido'];
                    $n3=$resultado['cliente'];
                    $n4=$resultado['direccion'];
                    $n5=$resultado['fechapedido'];
                    $n6=$resultado['fechasalida'];
                    $n7=$resultado['totalconiva'];
                    $n8=$resultado['estado_id'];
				}
			}
			
			if($n8!='1'){
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',3000);</script>"; 
			}
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar']) && empty($_GET['Id'])){
			
				$v9=$_SESSION['user'];
				$id=$_POST['Id'];
				$rfid=$_POST['RFID'];
				$fecha=gmdate('Y-m-d');
				
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				$delete=mysql_query("UPDATE com_pedidos SET fechacancelado='$fecha',estado_id='8' WHERE Id='$id' ");
				//echo "UPDATE com_ordencompra SET fechacancelado='$fecha',usercancelo_id='$v9',estado_id='2' WHERE Id='$id' ";
				
				if(!$delete)
				$error=1;
					
				$delete=mysql_query("DELETE FROM com_productospedido WHERE pedido_id='$id' ");
				
				if(!$delete)
				$error=1;
				
				$delete=mysql_query("UPDATE com_inventario SET existencia='0' WHERE RFID IN (".$rfid.") ");
				
				if(!$delete)
				$error=1;
				
				if($error) {
					mysql_query("ROLLBACK");
					echo "No se pudo Cancelar el pedido";
				} else {
					mysql_query("COMMIT");
					echo "Pedido Cancelado con éxito";
				}

				
                
				
				 echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',3000);</script>"; 
			}else{
				$acambiar="";
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            
              <h3>Cancelar Pedido</h3>
              
              <p>Se procede a borrar el pedido:</p>
		 		
         		<table>
                	<tr>
                    	<td>No Pedido:</td>
                        <td><?php echo $n1;?></td>
                        <td width="100px">&nbsp;</td>
                        <td>Estado:</td>
         				<td><?php echo $n8;?></td>
                    </tr>
                    <tr>
                    	<td>Fecha de Pedido:</td>
                        <td><?php echo $n5; ?></td>
                        <td>&nbsp;</td>
                         <td>Cliente/Direccion:</td>
         				<td><?php echo $n3." / ".$n4;?></td>
                    </tr>
         		</table>
         
         		<?php
				$bproductos=mysql_query("SELECT com_productos.nombre as producto,com_productos.codbarras,com_unidades.nombre as unidad,
com_productospedido.*,com_inventario.RFID FROM com_productospedido 
LEFT JOIN com_inventario ON com_productospedido.inventario_id=com_inventario.Id
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
WHERE com_productospedido.pedido_id='$id'",$conexion);
				?>
               <br/>
               <br/>
               
                
              <div class="datagrid">
              <table class="ventanapop" cellspacing="0" cellpadding="0" width="1450">
                <thead>
                <tr>
                  <th>Cod.</th>
                  <th>Producto</th>
                  <th>Pedido</th>
                  <th>Und.</th>
                  <th>Valor Base</th>
                  <th>% IVA</th>
                  <th>Valor Gravado</th>
                </tr>
                </thead>
                <tbody>
         		
                <?php
					while($resultado=mysql_fetch_assoc($bproductos)){
						$acambiar.="'".$resultado['RFID']."',";
				?>
                <tr id="linea1">
                      <td width="200"><?php echo $resultado['codbarras']; ?></td>
                      <td><?php echo $resultado['producto']; ?></td>
                      <td><?php echo $resultado['cantidadpedida']; ?></td><!--cantidad minima-->
                      <td><?php echo $resultado['unidad']; ?></td><!--precio minimo-->
                      <!--<td><?php echo $resultado['valoractualsiniva']; ?></td>
                      <td><?php echo $resultado['porcentajeiva']; ?></td>
                      <td><?php echo $resultado['valorconiva']; ?></td>-->
               </tr>
               
               <?php
					}
					
				?>
                </tbody>
                </table>	
                </div>
         
          <?php
		  
            if(!empty($_GET['Id'])){
				$acambiar=substr($acambiar,0,-1);
				
          ?>
          	  
             <input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>">
             <input type="hidden" name="RFID" id="rfids" value="<?php echo $acambiar; ?>">
          <?php	
            }
          ?>
        <p align="center">
          <input type="submit" name="Guardar" id="Cancelar" value="Cancelar Pedido">
        </p>
        </form>
    <?php
			}
	?>
</div>
</body>
</html>