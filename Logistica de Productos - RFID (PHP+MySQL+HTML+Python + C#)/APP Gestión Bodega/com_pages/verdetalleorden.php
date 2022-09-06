<?php include("../funciones/seguridad.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asignación de Tareas en Bodega - Pedidos</title>
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
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
	if(empty($_GET['Id'])){
		die("Seleccione una Orden de Compra a Detallar, cierre esta ventana");
	
	}


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
	
	
	
	
	$d=0;
	$id='';
	if(!empty($_GET['Id'])){
		
				// Busqueda del proveedor
				$id=$_GET['Id'];
				$buscar=mysql_query("SELECT com_ordencompra.*,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) 
as creado,com_estadooc.nombre,com_proveedores.nombre as proveedor FROM com_ordencompra 
LEFT JOIN com_usconect ON com_usconect.Id=com_ordencompra.usuario_id
LEFT JOIN com_estadooc ON com_estadooc.Id=com_ordencompra.estado_id
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_ordencompra.direccionproveedor_id
LEFT JOIN com_proveedores ON com_proveedores.Id=com_direccionproveedor.proveedor_id WHERE com_ordencompra.Id='$id'",$conexion);

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
					$proveedor=$resultado['proveedor'];
				}
				
				
				
				//Busqueda de los productos en la OC
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
					array_push($arro,$resultado['revisado']);
					array_push($arrp,$resultado['usuario_id']);
					array_push($arrq,$resultado['rollos']);
			}
				
				
								
	}
	
	
	$tpwindow="Ver Orden de Compra";	
	
?>

<div id="contenidof4">
    	<h2> >> <?php echo $tpwindow; ?> </h2>

            <p>Diligencie el formulario en su totalidad y de clic en Guardar:</p>
            
        		<table width="1000" class="formulario">
					<tr>
                    	<td width="90">No de Orden:</td>
                        <td width="149"><?php echo $noorden; ?></td>
                        <td width="6">&nbsp;</td>
                        <td width="90">Fecha Solicitud</td>
                        <td width="261"><?php echo $fechasolicitud; ?></td>
                  </tr>
                  <tr>
                   		<td>Proveedor:</td>
                        <td><?php echo $proveedor; ?></td>
                        <td>&nbsp;</td>
                        <td>Fecha Llegada:</td>
                        <td colspan="2" align="left"><?php echo $fechacierre; ?></td>
                   </tr>
                   <tr>
                   		<td colspan="5" align="right">&nbsp;</td>
                   </tr> 
                  
              </table>	
              
              <br/>
              <br/>
         <div class="datagrid">
              <table class="ventanapop" cellspacing="0" cellpadding="0" width="95%">
                <thead>
                <tr>
                  <th>Cod.</th>
                  <th>Producto</th>
                  <th>Cantidad </th>
                  <th>Und. </th>
                  <th>Rollos</th>
                  <th>Valor</th>
                </tr>
                </thead>
                <tbody>
              	 <?php
			 			for($c=0;$c<count($arra);$c++){
				?>
                	<tr>
                      <td width="140"><?php echo $arra[$c]; ?></td>
                      <td><?php echo $arrb[$c]; ?></td>
                      <td><?php echo $arrc[$c]; ?></td>
                      <td><?php echo $arrd[$c]; ?></td>
                      <td><?php echo $arrq[$c]; ?></td>
                      <td><?php echo $arrg[$c]; ?></td>
               		</tr>
                
                
                <?php
						}
				?>	
                
                </tbody>
               	<tfoot>
				</tfoot>
                </table>
            
           
           
       </div>  
    
</div>
</body>
</html>