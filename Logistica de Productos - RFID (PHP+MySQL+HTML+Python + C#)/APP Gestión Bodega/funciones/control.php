<?php
$archivo="datos.txt";
include("conexbd.php");
$usuario=$_POST['login'];
$contrasena=$_POST['passwd'];
$sentencia_sql1 = mysql_query("SELECT * FROM com_usconect us WHERE us.comlogin='$usuario' and us.comseguro=PASSWORD('$contrasena')",$conexion);
$data=mysql_fetch_row($sentencia_sql1);
//evaluando entrada solo para el administrador
if (!empty($data[7]) && $data[7]!='' && $data[7]=='1'){
    session_start();
	$_SESSION["autentificado"]=array(1,0,0,0,0);
	$_SESSION["user"]=$usuario;	
	$_SESSION["iduser"]=$data[0];	
	header ("Location: ../acceso.php");
}else if(!empty($data[7]) && $data[7]!='' && $data[7]=='4'){
	 session_start();
	$_SESSION["autentificado"]=array(1,0,0,0,1);
	$_SESSION["user"]=$usuario;	
	$_SESSION["iduser"]=$data[0];	
	header ("Location: ../acceso_bodega.php");
}else{
	header("Location: ../index.php");
}
mysql_free_result($resultado);
mysql_close($conexion);
?> 
