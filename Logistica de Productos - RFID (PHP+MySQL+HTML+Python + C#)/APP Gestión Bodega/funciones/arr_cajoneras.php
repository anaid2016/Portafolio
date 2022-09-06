<?php
$rpta="";
$archivo="datos.txt";
include("conexbd.php");
include("librerias.php");
$selecto=$_POST['elegido'];
if($selecto!=''){
	$resultado=mysql_query("SELECT * FROM com_arraybodega WHERE pasillo='$selecto' ORDER BY nombre ASC",$conexion);
	$rpta="<option value=''></option> ";
	while($combo6=mysql_fetch_assoc($resultado)){
	  $rpta.="<option value='".$combo6['Id']."'>".$combo6['nombre']."</option>";
	}
}
echo $rpta;	
?>