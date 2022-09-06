<?php
$rpta="";
$archivo="datos.txt";
include("conexbd.php");
include("librerias.php");
$selecto=$_POST['elegido'];
$resultado=mysql_query("SELECT * FROM com_arraybodega WHERE bodega_id='$selecto'",$conexion);
$rpta="<option value=''></option> ";
while($combo5=mysql_fetch_assoc($resultado)){
  $rpta.="<option value='".$combo5['Id']."'>".$combo5['nombre']."</option>";
}
echo $rpta;	
?>