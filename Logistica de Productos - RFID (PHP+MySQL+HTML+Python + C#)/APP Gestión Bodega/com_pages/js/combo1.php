<?php
$archivo="../../funciones/datos.txt";
include("../../funciones/conexbd.php");
include("../../funciones/librerias.php");
include("../../funciones/seguridad.php");
	
	
$resultado=mysql_query("SELECT com_direccionproveedor.Id as id,CONCAT_WS(', ',com_proveedores.nombre,com_direccionproveedor.direccion,com_ciudad.ciudad) as nombre
FROM com_direccionproveedor
LEFT JOIN com_proveedores ON com_proveedores.Id=com_direccionproveedor.proveedor_id
LEFT JOIN com_ciudad ON com_ciudad.Id=com_direccionproveedor.ciudad_id 
GROUP BY com_direccionproveedor.Id",$conexion);
$rpta=" ";
while($combo5=mysql_fetch_assoc($resultado)){
  $rpta.="<option value='".$combo5['id']."'>".$combo5['nombre']."</option>";
}
echo $rpta;	
?>