<?php
	ini_set('max_execution_time', 270000); //300 seconds = 5 minutes
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");

	if(!empty($_GET["buscar"])){
		
		$codbarras=$_GET["v1"];
		$rfid=$_GET["v2"];
		
		$mysqletiqueta1=mysql_query("SELECT com_inventario.*,com_productos.codbarras,com_productos.nombre,com_unidades.nombre as unidad FROM com_inventario 
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
WHERE com_productos.codbarras='$codbarras' and RFID='$rfid'",$conexion);

	while($rmysqletiqueta1=mysql_fetch_assoc($mysqletiqueta1)){

		//Restringiendo Nombre a 30 caracteres -----------------------------
		$et_nombre=substr($rmysqletiqueta1['nombre'],0,19);
		$et_nombre2=substr($rmysqletiqueta1['nombre'],20,44);
		$et_barras=$rmysqletiqueta1['codbarras'];
		$et_fecha=gmdate('Y-m-d');
		$et_cant=$rmysqletiqueta1['cantidad_entrada']." ".$rmysqletiqueta1['unidad'];
		$et_RFID=$rmysqletiqueta1['RFID'];
		$et_cant1=$rmysqletiqueta1['cantidad_entrada'];
		
		

		$vfecha=explode("-",$et_fecha);
		$et_barrasf=$et_barras;
		$et_barrasf.=$vfecha[2];
		$et_barrasf.=$vfecha[1];
		$et_barrasf.=$vfecha[0];
		$et_barrasf.=$et_cant1;
		$et_barrasf.=$et_RFID;
		

		
		$zpl="^XA \n";
		$zpl.="^FO250, 70^ADN, 15, 15^FD COMERTEX^FS \n";
		$zpl.="^FO50, 120^ADN, 12, 12^FD ".$et_nombre."^FS \n";
		$zpl.="^FO50, 150^ADN, 12, 12^FD FECHA ENTRADA:".$et_fecha."^FS \n";
		$zpl.="^FO50, 180^ADN, 12, 12^FD SERIAL:".$et_RFID."^FS \n";
		$zpl.="^FO50, 210^ADN, 12, 12^FD CANT:".$et_cant."^FS \n";
		$zpl.="^FO20,296^BY2 \n";
		$zpl.="^BCN,60,Y,N,N \n";
		$zpl.="^FD".$et_barrasf."^FS \n";
		$zpl.="^RS,350,,1,N^FS \n";
		$zpl.="^RB96,96^FS \n";
		$zpl.="^RFW,E^FD".$et_RFID."^FS \n";
		$zpl.="^XZ\n"; 
		
		$file_et = "etiquetas_malas.txt";
  $fp_et = fopen($file_et, "w");
		fwrite($fp_et,$zpl);   
		fclose($fp_et);
		
		sleep(2);
		pclose(popen("start /B impresora_error.bat", "r")); 
 		
		sleep(5);
   		
	}

	
}
?>

<html>
<head>

</head>

<body>
	<form action="" method="GET">
		<table>
			<tr>
				<td>Codigo de Barras:</td>
				<td><input type="text" name="v1" /></td>
				<td>RFID</td>
				<td><input type="text" name="v2" /></td>
				<td><input type="submit" name="buscar" value="buscar" /></td>
			</tr>
			<tr>
		</table>		
	</form>
</body>
</html>