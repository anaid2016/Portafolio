<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Proveedores</title>
</head>

<body>
<?php
	$id=$_GET['Id'];
	$forma=$_GET['forma'];
	if($forma=='Cancelar OC'){
		header ("Location: deordencompra.php?Id=".$id);
	}else if($forma=='Modificar OC'){
		header ("Location: agordencompra.php?Id=".$id);
	}else{
		header ("Location: revizarordencompra.php?Id=".$id);
	}
?>
</body>
</html>