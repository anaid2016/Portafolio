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
	echo $id;
	if($forma=='Eliminar Producto'){
		header ("Location: delproducto.php?Id=".$id);
	}else if($forma=='Asociar Proveedores'){
		header ("Location: asocproveedor.php?Id=".$id);
	}else if($forma=='Modificar Producto'){
		header ("Location: agproductos.php?Id=".$id);
	}
?>
</body>
</html>