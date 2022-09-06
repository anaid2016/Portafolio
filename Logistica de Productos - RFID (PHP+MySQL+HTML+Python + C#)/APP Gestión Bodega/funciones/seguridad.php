<?php
//Inicio la sesión
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
$user=$_SESSION["user"];
$iduser=$_SESSION["iduser"];
$reg='';
if(empty($_SESSION["user"])){
 	header("Location: index.php");
}
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
foreach($_SESSION["autentificado"] as $clave)
	{
	$reg.=$clave;
	}
	if ($reg!='10000') 
	{
		 //si no existe, envio a la página de autentificacion
			header("Location: index.php");
			//ademas salgo de este script
			exit();
	}
?> 
