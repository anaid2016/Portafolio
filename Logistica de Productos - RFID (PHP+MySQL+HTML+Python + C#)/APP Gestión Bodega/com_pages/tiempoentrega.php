<?php
$rpta="";

$archivo="../funciones/datos.txt";
include("../funciones/conexbd.php");
include("../funciones/librerias.php");
include("../funciones/seguridad.php");


$selecto=$_POST['elegido'];
$resultado=mysql_query("SELECT com_proveedores.tiempoentrega FROM com_proveedores
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.proveedor_id=com_proveedores.Id
WHERE com_direccionproveedor.Id='$selecto'",$conexion);
$rpta=" ";

while($combo5=mysql_fetch_assoc($resultado)){
  $rpta.=$combo5['tiempoentrega'];
}
echo $rpta;	
?>