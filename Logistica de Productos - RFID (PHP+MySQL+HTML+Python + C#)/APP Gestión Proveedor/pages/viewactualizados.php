<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Historial de Archivos Descargado</title>
<link href="style/popup.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
include('../fun_others/sge_basicas.php');
$resultado=SGE_014();
$vdata=explode(";;",$resultado);
?>
<div class="CSSTableGenerator">
<table>
	<tr>
    	<td>Zona</td><td>Ultimo Archivo Descargado</td>
    </tr>
<?php
	for($a=0;$a<count($vdata);$a++){
		$vlinea=explode("::",$vdata[$a]);
?>
	<tr>
    	<td><?php echo $vlinea[3]; ?></td>
        <td><?php echo $vlinea[0]; ?></td>
    </tr>

<?php		
	}
?>
</table>
</div>

</body>
</html>