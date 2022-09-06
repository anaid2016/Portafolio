<?php

/*Combo para tablas de Id, nombre*/

function PV_001($campos,$tabla){	
	
	include("pages/Resources/config.php");
	$enlace2 = new mysqli($dbhost, $dbuser,$dbpass, $dbname);	
	mysqli_set_charset($enlace2, "utf8");
	
	$alldata="";
	$query="SELECT $campos from $tabla";
	
	/*$opfileb=fopen("porque.txt","w");
	fwrite($opfileb, $query);
	fclose($opfileb);*/
	
	if ($result = $enlace2->query($query)) {
		 
		 while ($row = $result->fetch_row()) {
			 
			 
			 $alldata.=$row[0]."::".$row[1].";;";
			 
		 }
	}
	
	mysqli_close($enlace2);
	
	$alldata=substr($alldata,0,-2);
	
	return $alldata;
}

//Funcion para agregar un producto a una Orden de Venta, la inserción se hace en pv_movimientoproducto, y el trigger se encarga de ingresarlo a producto_venta
//$ordenventa=Id de la orden de venta
//productomv= Id de la linea de movimientoproducto a modificar

function PV_002($ordenventa,$productomv){	
	
	include("pages/Resources/config.php");
	// Create connection
	$enlace2 = new mysqli($dbhost, $dbuser,$dbpass, $dbname);	
	
	// Check connection
	if ($enlace2->connect_error) {
		die("Connection failed: " . $enlace2->connect_error);
	} 
	
	$sql="UPDATE prov_movimientoproducto SET estado_id='4',ordenv_id=".$ordenventa." WHERE Id in (".$productomv.")";
	
	/*$opfileb=fopen("porque.txt","w");
	fwrite($opfileb, $sql);
	fclose($opfileb);*/
	
	
	if ($enlace2->query($sql) === TRUE) {
		//echo "New record created successfully".$sql;
	} else {
		echo "Error: " . $sql . "<br>" . $enlace2->error;
	}
	
	$enlace2->close();
}


/*Select trae el campo nombre de la orden de venta*/

function PV_003($campos){	
	
	include("pages/Resources/config.php");
	$enlace2 = new mysqli($dbhost, $dbuser,$dbpass, $dbname);	
	
	$alldata="";
	$query="SELECT numeroorden from prov_ordenventa WHERE Id=$campos";
	
	
	if ($result = $enlace2->query($query)) {
		 
		 while ($row = $result->fetch_row()) {
			 
			 
			 $alldata.=$row[0];
			 
		 }
	}
	
	mysqli_close($enlace2);
	
	
	return $alldata;
}


/*Envia correo a la Bodega con la información de la Orden de Venta*/

function PV_004($campos){	
	
	include("Resources/config.php");
	$enlace2 = new mysqli($dbhost, $dbuser,$dbpass, $dbname);	
	
	$alldata="";
	$query="SELECT prov_ordenventa.Id,prov_ordenventa.numeroorden,prov_ordenventa.fechacreada,prov_ordenventa.fechasalida,GROUP_CONCAT(prov_producto.Id) as Id2,
GROUP_CONCAT(prov_productosorden.Id) as id1, GROUP_CONCAT(prov_nombres.nombre) as nombre,GROUP_CONCAT(prov_producto.codbarras) as codbarras,
GROUP_CONCAT(prov_productosorden.cantidad) as cantidad,GROUP_CONCAT(prov_productosorden.precio_venta) as precioventa,GROUP_CONCAT(RFID) as RFID
FROM prov_ordenventa
LEFT JOIN prov_productosorden ON prov_productosorden.ordenventa_id=prov_ordenventa.Id
LEFT JOIN prov_movimientoproducto ON prov_movimientoproducto.Id=prov_productosorden.movimiento_id
LEFT JOIN prov_producto ON prov_producto.Id=prov_movimientoproducto.producto_id
LEFT JOIN prov_nombres ON prov_nombres.Id=prov_producto.nombre
WHERE prov_ordenventa.Id='$campos' GROUP BY prov_ordenventa.Id ORDER BY codbarras";
	
	if ($result = $enlace2->query($query)) {
		 
		 while ($row = $result->fetch_assoc()) {
			 
			 $idorden=$row["Id"];						//Id de la Orden de Venta
			 $numeroorden=$row["numeroorden"];			//Numero de la Orden de Venta
			 $fechacreada=$row["fechacreada"];			//Fecha en que empieza proceso de Despacho
			 $fechasalida=$row["fechasalida"];			//Fecha de salida del producto
			 
			 $vector1=explode(",",$row["Id2"]);			//Id de los productos enviados
			 $vector2=explode(",",$row["id1"]);			//Lineas de los productos en la Orden
			 $vector3=explode(",",$row["nombre"]);		//Nombre de los productos en la Orden
			 $vector4=explode(",",$row["codbarras"]);	//Codbarras de los productos en la Orden
			 $vector5=explode(",",$row["cantidad"]);	//Cantidad por RFID
			 $vector6=explode(",",$row["precioventa"]);	//Precio producto
			 $vector7=explode(",",$row["RFID"]);		//RFID
			 
		 }
	}
	
	
	
	
	//Encabezado de la Orden ===================================================================================
	$mensaje="<table class='CSSTableGenerator2'>";
	$mensaje.="<tr>";
	$mensaje.="<td>Orden de Venta:</td>";
	$mensaje.="<td>".$numeroorden."</td>";
	$mensaje.="<td>Fecha Creada:</td>";
	$mensaje.="<td>".$fechacreada."</td>";
	$mensaje.="<td>Fecha Despacho:</td>";
	$mensaje.="<td>".$fechasalida."</td>";
	$mensaje.="</tr>";
	$mensaje.="</table>";
	
	$mensaje.="<hr/>";
	
	
	//Organizando Productos Enviados ===================================================================================
	$query4="select * from view_ordensalida WHERE Id='$campos' ";
	
	$mensaje.="<h1>Productos Totalizados</h1>";
	$mensaje.="<table class='CSSTableGenerator'>";
	$mensaje.="<tr>";
	$mensaje.="<td>Id</td>";
	$mensaje.="<td>Producto</td>";
	$mensaje.="<td>Cod. Barras</td>";
	$mensaje.="<td>Cantidad</td>";
	$mensaje.="<td>Valor Unit.</td>";
	$mensaje.="<td>Valor Total</td>";
	$mensaje.="</tr>";
	
	if ($result = $enlace2->query($query4)) {
		 
		 while ($row = $result->fetch_assoc()) {
			$mensaje.="<tr>";
			$mensaje.="<td>".$row["producto_id"]."</td>";
			$mensaje.="<td>".$row["nombre"]."</td>";
			$mensaje.="<td>".$row["codbarras"]."</td>";
			$mensaje.="<td>".$row["cantidad2"]."</td>";
			$mensaje.="<td>".$row["precio_venta"]."</td>";
			$mensaje.="<td>".$row["precio_venta"]*$row["cantidad2"]."</td>";
			$mensaje.="</tr>";
			 
			 
		 }
		 
	}
	$mensaje.="</table>";
	$mensaje.="<hr/>";
	
	//Organizando Productos Enviados por RFID ===================================================================================
	$mensaje.="<h1>Productos Especificos - RFID </h1>";
	$mensaje.="<table class='CSSTableGenerator'>";
	$mensaje.="<tr>";
	$mensaje.="<td>Item</td>";
	$mensaje.="<td>Producto</td>";
	$mensaje.="<td>Codbarras</td>";
	$mensaje.="<td>Cantidad</td>";
	$mensaje.="<td>RFID</td>";
	$mensaje.="</tr>";
	
	for($a=0;$a<count($vector1);$a++){
		$mensaje.="<tr>";
		$mensaje.="<td>".($a+1)."</td>";
		$mensaje.="<td>".$vector3[$a]."</td>";
		$mensaje.="<td>".$vector4[$a]."</td>";
		$mensaje.="<td>".$vector5[$a]."</td>";
		$mensaje.="<td>".$vector7[$a]."</td>";
		$mensaje.="</tr>";
	}
	$mensaje.="</table>";
	$mensaje.="<hr/>";
	
	//Lineas por Orden de Compra de Bodega Enviadas==============================================================================
	
	$mensaje.="<h1>Productos Solicitados por Cliente: </h1>";
	$query3="SELECT com_ordencompra.noorden,com_ordencompra.fechagenerada,prov_nombres.nombre,com_productosorden.cantidadpedida,prov_producto.codbarras FROM proveedor.prov_productosorden2
LEFT JOIN bodega.com_productosorden ON bodega.com_productosorden.Id=prov_productosorden2.linea_bodega
LEFT JOIN bodega.com_ordencompra ON bodega.com_ordencompra.Id=bodega.com_productosorden.orden_id
LEFT JOIN proveedor.prov_producto ON prov_producto.Id=prov_productosorden2.producto_id
LEFT JOIN proveedor.prov_nombres ON prov_nombres.Id=prov_producto.nombre
WHERE ordenventa_id='$campos' ORDER BY codbarras";
	
	$mensaje.="<table class='CSSTableGenerator'>";
	$mensaje.="<tr>";
	$mensaje.="<td>No. Orden</td>";
	$mensaje.="<td>Fecha Enviada</td>";
	$mensaje.="<td>Nombre Producto</td>";
	$mensaje.="<td>Codbarras</td>";
	$mensaje.="<td>Cantidad</td>";
	$mensaje.="</tr>";
	
	if ($result = $enlace2->query($query3)) {
		 
		 while ($row = $result->fetch_assoc()) {
			 
			$mensaje.="<tr>";
			$mensaje.="<td>".$row["noorden"]."</td>";
			$mensaje.="<td>".$row["fechagenerada"]."</td>";
			$mensaje.="<td>".$row["nombre"]."</td>";
			$mensaje.="<td>".$row["codbarras"]."</td>";
			$mensaje.="<td>".$row["cantidadpedida"]."</td>";
			$mensaje.="</tr>";
		 }
		 
	}
	
	mysqli_close($enlace2);	
	return $mensaje;
}


/*Select trae el estado de la orden de venta*/

function PV_005($campos){	
	
	include("pages/Resources/config.php");
	$enlace2 = new mysqli($dbhost, $dbuser,$dbpass, $dbname);	
	
	$alldata="";
	$query="SELECT estado_id from prov_ordenventa WHERE Id=$campos";
	
	
	if ($result = $enlace2->query($query)) {
		 
		 while ($row = $result->fetch_row()) {
			 
			 
			 $alldata.=$row[0];
			 
		 }
	}
	
	mysqli_close($enlace2);
	
	
	return $alldata;
}


//---Generador de Etiquetas para Ingreso de Productos
//


function PV_006(){

	//Primero se realiza la busqueda de las lineas grabadas en la base de datos
	include("Resources/config.php");
	$enlace2 = new mysqli($dbhost, $dbuser,$dbpass, $dbname);	
	
	$query="SELECT CONCAT(prov_nombres.nombre,prov_color.nombre,prov_tallas.talla) as nombre,prov_producto.codbarras,prov_movimientoproducto.RFID FROM prov_movimientoproducto
LEFT JOIN prov_producto ON prov_producto.Id=prov_movimientoproducto.producto_id
LEFT JOIN prov_nombres ON prov_nombres.Id=prov_producto.nombre
LEFT JOIN prov_tallas ON prov_tallas.Id=prov_producto.talla_id
LEFT JOIN prov_color ON prov_color.Id=prov_producto.color_id 
WHERE etiquetado='1'";

	$opfileb=fopen("porque.txt","w");
	fwrite($opfileb, $query);
	fclose($opfileb);
	
	//Sobreescribir archivo imprimiendo.txt --ubicacion en com_pages

	if ($result = $enlace2->query($query)) {
		 
		 while ($row = $result->fetch_row()) {
			
			$et_nombre=$row[0];
			$et_barras=$row[1];
			$et_fecha=gmdate('Y-m-d');
			$et_RFID=$row[2];
			
			$zpl="^XA \n";
			$zpl.="^FO250, 70^ADN, 15, 15^FD COMERTEX^FS \n";
			$zpl.="^FO50, 120^ADN, 12, 12^FD ".$et_nombre."^FS \n";
			$zpl.="^FO50, 150^ADN, 12, 12^FD FECHA ENTRADA:".$et_fecha."^FS \n";
			$zpl.="^FO50, 180^ADN, 12, 12^FD SERIAL:".$et_RFID."^FS \n";
			$zpl.="^FO50, 210^ADN, 12, 12^FD CANT:1 PAR ^FS \n";
			$zpl.="^FO20,296^BY2 \n";
			$zpl.="^BCN,60,Y,N,N \n";
			$zpl.="^FD".$et_barras."^FS \n";
			$zpl.="^RS,350,,1,N^FS \n";
			$zpl.="^RB96,96^FS \n";
			$zpl.="^RFW,E^FD".$et_RFID."^FS \n";
			$zpl.="^XZ\n"; 
		 }
	}

	
	$file_et = "..\\pages\\imprimiendo.txt";
	//$file_et = "pages\\imprimiendo.txt";
    $fp_et = fopen($file_et, "w");
	fwrite($fp_et,$zpl);   
	fclose($fp_et);
	
	/*sE COMENTAN PARA TRABAJAR EN LA CASA*/
	sleep(15);
	pclose(popen("start /B impresora.bat", "r")); 
	sleep(5);		//eSTE SLEEP ES DE 5*/
	 
	 
	 //Cambiando estado a etiquetado
	$sql="UPDATE prov_movimientoproducto SET etiquetado='2' WHERE etiquetado='1' ";
	
		
	if ($enlace2->query($sql) === TRUE) {
		//echo "New record created successfully".$sql;
	} else {
		//echo "Error: " . $sql . "<br>" . $enlace2->error;
	}
	
	 mysqli_close($enlace2);
	 return "Etiqueta Impresa";

}
?>