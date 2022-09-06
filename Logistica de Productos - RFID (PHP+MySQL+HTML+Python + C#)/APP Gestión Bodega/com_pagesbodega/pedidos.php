<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	include("funciones/seguridad_bodega.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pedidos</title>
<link rel="stylesheet" type="text/css" href="css/styles2.css"/>
</head>
<body>
	<h3>Tareas - Pedidos</h3>

	<?php
		$consulta=mysql_query("SELECT com_pedidos.*,com_clientes.nombres FROM com_pedidos 
LEFT JOIN com_direccionclientes ON com_direccionclientes.Id=com_pedidos.direccioncliente_id
LEFT JOIN com_clientes ON com_clientes.Id=com_direccionclientes.cliente_id
WHERE userbodega_id='$iduser' and estado_id='3'",$conexion);
	?>

	<table cellpadding="3" cellspacing="0" class="data_table" align="center">
    	<tr>
        	<th>No.</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
        <?php
			while($data_p=mysql_fetch_assoc($consulta)){
		?>
        	<tr>
            	<td><a href="com_pagesbodega/detallepedido.php?idp=<?php echo $data_p["Id"]; ?>"><?php echo $data_p["nopedido"]; ?></a></td>
                <td><?php echo $data_p["nombres"]; ?></td>
                <td><?php echo $data_p["fechapedido"]; ?></td>
                <td align="center"><?php echo $data_p["estado_id"]; ?></td>
            </tr>
        <?php		
			}
		?>
    </table>


</body>
</html>