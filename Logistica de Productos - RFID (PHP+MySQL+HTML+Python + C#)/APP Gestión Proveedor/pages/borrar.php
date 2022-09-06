<?php
  $campos=$_POST["codigo"];

	include('Resources/config.php');
	$enlace2 = new mysqli($dbhost, $dbuser,$dbpass, $dbname);	
	
	// Check connection
	if ($enlace2->connect_error) {
		die("Connection failed: " . $enlace2->connect_error);
	} 
	
	$sql="DELETE FROM prov_productosorden WHERE Id=$campos and estado_id='1'";
	
	if ($enlace2->query($sql) === TRUE) {
		echo "Producto eliminado de la Orden con Exito";
	} else {
		echo "Error: " . $sql . "<br>" . $enlace2->error;
	}
	
	$enlace2->close();				
					

?>