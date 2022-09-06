<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/seguridad_bodega.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" 
  content="width=device-width, initial-scale=1.0, user-scalable=no">
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../css/styles2.css"/>
<script> 
 function Cerrar(){
	location.href = '../acceso_bodega?com_pgb=1';
 }
</script>
</head>
<body>
	<?php
		 //Vector para verificacion
		 $vecRFID=array();
	
		//Busqueda del nopedido 
		if(!empty($_GET['idp'])){
			$id_pb=$_GET['idp'];
			
			//No de pedido -----------------------------------------------------------------
			$nopedidob=mysql_query("SELECT * FROM com_pedidos WHERE Id='$id_pb' ",$conexion);
			$resnopedidob=mysql_fetch_row($nopedidob);
			
			//Data pedido -------------------------------------------------------------------
			$datapedidob=mysql_query("SELECT com_inventario.RFID,com_inventario.arraybodega_id,
CONCAT_WS(' ',com_arraybodega.columna,com_arraybodega.fila) as ubicacion,
com_productos.codbarras,com_productos.nombre as producto,com_inventario.cantidad,
com_unidades.nombre FROM com_productospedido
LEFT JOIN com_inventario ON com_productospedido.inventario_id=com_inventario.Id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
LEFT JOIN com_productos ON com_inventario.producto_id=com_productos.Id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
WHERE com_productospedido.pedido_id='$id_pb'",$conexion);	
		
		}else{
			echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>"; 
		}
			
	?>

	<h3>Detalle de Pedido - <?php echo $resnopedidob[11]; ?></h3>
	
    <table cellpadding="3" cellspacing="0" class="data_table" align="center">
    	<tr>
        	<th>Cod. Barras - Nombre</th>
            <th>RFID</th>
            <th>Cnt</th>
            <th>Ubicación</th>
            <th>Estado</th>
        </tr>
        <?php
			while($data_p=mysql_fetch_assoc($datapedidob)){
			array_push($vecRFID,$data_p["RFID"]);
		?>
        	<tr>
            	<td><?php echo $data_p["codbarras"]; ?><br/>
                <?php echo $data_p["producto"]; ?></td>
                <td><?php echo $data_p["RFID"]; ?></td>
                <td><?php echo $data_p["cantidad"]; ?> <?php echo $data_p["nombre"]; ?></td>
                <td><?php echo $data_p["ubicacion"]; ?></td>
                <td><input type="checkbox" name="producto" value="<?php echo $data_p["RFID"]; ?>" /></td>
            </tr>
        <?php		
			}
		?>
    </table>
    
    
</body>
</html>