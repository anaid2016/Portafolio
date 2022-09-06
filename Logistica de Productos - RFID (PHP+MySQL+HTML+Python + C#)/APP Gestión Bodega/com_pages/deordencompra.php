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
	opener.location.href = "../acceso.php?com_pg=5";
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
				$buscar=mysql_query("SELECT com_ordencompra.*,
CONCAT_WS(',',com_direccionproveedor.direccion,com_ciudad.ciudad) as direccion,
com_proveedores.nombre as proveedor,com_estadooc.nombre as estado FROM com_ordencompra
LEFT JOIN com_direccionproveedor ON com_ordencompra.direccionproveedor_id=com_direccionproveedor.Id
LEFT JOIN com_proveedores ON com_direccionproveedor.proveedor_id=com_proveedores.Id
LEFT JOIN com_ciudad ON com_direccionproveedor.ciudad_id=com_ciudad.Id 
LEFT JOIN com_estadooc ON com_ordencompra.estado_id=com_estadooc.Id WHERE com_ordencompra.Id='$id'",$conexion);
				while($resultado=mysql_fetch_assoc($buscar)){
					$n1=$resultado['noorden'];
                    $n3=$resultado['proveedor'];
                    $n4=$resultado['direccion'];
                    $n5=$resultado['fechasolicitud'];
                    $n6=$resultado['fecharecibido'];
                    $n7=$resultado['totalconiva'];
                    $n8=$resultado['estado'];
				}
			}
			
			if(!empty($n8) && $n8!="Solicitud" && !empty($_GET['Id']) ){
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',800);</script>"; 
			}
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar']) && empty($_GET['Id'])){
			
				$v9=$_SESSION['user'];
				$id=$_POST['Id'];
				$fecha=gmdate('Y-m-d');
				
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				$delete=mysql_query("UPDATE com_ordencompra SET fechacancelado='$fecha',usercancelo_id='$v9',estado_id='2' WHERE Id='$id' ");
				//echo "UPDATE com_ordencompra SET fechacancelado='$fecha',usercancelo_id='$v9',estado_id='2' WHERE Id='$id' ";
				
				if(!$delete)
				$error=1;
					
				$delete=mysql_query("UPDATE com_productosorden SET estado_id='2' WHERE orden_id='$id' ");
				
				if(!$delete)
				$error=1;
				
				if($error) {
					mysql_query("ROLLBACK");
					echo "No se pudo borrar el Proveedor";
				} else {
					mysql_query("COMMIT");
					echo "Orden de compra CANCELADA con éxito";
				}

				
                
				
				 echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',3000);</script>"; 
			}else{
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            
              <h3>Cancelar Orden de Compra</h3>
              
              <p>Recuerde que el sistema solo permite eliminar Ordenes de Compra en estado Solicitud, si la Orden de Compra no se puede visualizar es por que se encuentra en otro estado:</p>
		 		
         		<table>
                	<tr>
                    	<td>No Orden:</td>
                        <td><?php echo $n1;?></td>
                        <td width="100px">&nbsp;</td>
                        <td>Estado:</td>
         				<td><?php echo $n8;?></td>
                    </tr>
                    <tr>
                    	<td>Fecha de Solicitud:</td>
                        <td><?php echo $n5; ?></td>
                        <td>&nbsp;</td>
                         <td>Proveedor/Direccion:</td>
         				<td><?php echo $n3." / ".$n4;?></td>
                    </tr>
         		</table>
         
         		<?php
				$bproductos=mysql_query("SELECT com_productosorden.*,com_productos.codbarras,com_productos.nombre as producto,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as usuario,com_unidades.nombre
FROM com_productosorden 
LEFT JOIN com_ordencompra ON com_productosorden.orden_id=com_ordencompra.Id
LEFT JOIN com_proveedorproductos ON com_proveedorproductos.Id=com_productosorden.proveedorproducto_id
LEFT JOIN com_productos ON com_proveedorproductos.producto_id=com_productos.Id
LEFT JOIN com_usconect ON com_usconect.Id=com_productosorden.usuario_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id WHERE com_ordencompra.Id='$id'",$conexion);
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
				?>
                <tr id="linea1">
                      <td width="200"><?php echo $resultado['codbarras']; ?></td>
                      <td><?php echo $resultado['producto']; ?></td>
                      <td><?php echo $resultado['cantidadpedida']; ?></td><!--cantidad minima-->
                      <td><?php echo $resultado['nombre']; ?></td><!--precio minimo-->
                      <td><?php echo $resultado['valoractualsiniva']; ?></td>
                      <td><?php echo $resultado['porcentajeiva']; ?></td>
                      <td><?php echo $resultado['valorconiva']; ?></td>
               </tr>
               
               <?php
					}
					
				?>
                </tbody>
                </table>	
                </div>
         
          <?php
		  
            if(!empty($_GET['Id'])){
          ?>
             <input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>">
          <?php	
            }
          ?>
        <p align="center">
          <input type="submit" name="Guardar" id="Cancelar" value="Cancelar Orden de Compra">
        </p>
        </form>
    <?php
			}
	?>
</div>
</body>
</html>