<?php
	$doc="".$archivo."";
	$apertura=fopen($doc,"r");
	$datos=array();	
	while(!feof($apertura))
	{
	$lectura=fgets($apertura, 1024);
	$vector=explode(",",$lectura);
	for($i=0;$i<count($vector);$i++) 
	   {
		$vector[$i]=($vector[$i]);
		$tp_o=trim($vector[$i]);
		array_push($datos,$tp_o);
	   }
	}
	$base=$datos[1];
	
	if(!isset($datos[3])){$datos[3]='';}
	$conexion=mysql_connect($datos[0],$datos[2],$datos[3]);
	mysql_select_db($base,$conexion);
	fclose($apertura);
	
?>
