<?php


//Barra de Herramientas

/*Función GRAPH002
Habilita botonera según permisos del usuario*/

function GRAPH002($idform,$usuario,$sil_this,$sil_buscar,$sil_new,$sil_editar,$sil_errase,$sil_carrito,$sil_check,$alto,$ancho,$vector){
	
	$v_hab=explode("::",$vector);
	$ver=$v_hab[0];
	$nuevo=$v_hab[1];
	$editar=$v_hab[2];
	$borrar=$v_hab[3];
	$carrito=$v_hab[4];
	$check=(!isset($v_hab[5]))? 2:$v_hab[5];
	
	echo "<ul>";
		
		/*echo ($ver==1)? '<li>
			<input type="image" title="ver" src="images/inicio.png" onclick="sil_openpopmodal(\''.$sil_this.'\',\'1\',\''.$ancho.'\',\''.$alto.'\',\'\')"/>
		</li>':'';*/
			
		echo ($ver==1)? '<li>
			<input type="image" title="ver" src="images/buscar.png" onclick="sil_openpopmodal(\''.$sil_buscar.'\',\'2\',\''.$ancho.'\',\''.$alto.'\',\'\')"/>
		</li>':'';	
			
		echo ($nuevo==1)? '<li>
			<input type="image" title="nuevo" src="images/nuevo.png" onclick="sil_openpopmodal(\''.$sil_new.'\',\'1\',\''.$ancho.'\',\''.$alto.'\',\'this\')"/>				
		</li>':'';
		
		echo ($editar==1)? '<li>
			<input type="image" src="images/editar.png" onclick="sil_openpopmodal(\''.$sil_editar.'\',\'2\',\''.$ancho.'\',\''.$alto.'\',\'this\')"/>						
			</li>':'';		
		
		echo ($borrar==1)? '<li>
			<input type="image" src="images/borrar.png" onclick="sil_openpopmodal(\''.$sil_errase.'\',\'2\',\''.$ancho.'\',\''.$alto.'\',\'this\')"/>				
		</li>':'';	
		
		echo ($carrito==1)? '<li>
			<input type="image" src="images/proveedor.png" onclick="sil_openpopmodal(\''.$sil_carrito.'\',\'2\',\''.$ancho.'\',\''.$alto.'\',\'this\')"/>				
		</li>':'';	
		
		echo ($check==1)? '<li>
			<input type="image" title="revisar" src="images/check.png" onclick="sil_openpopmodal(\''.$sil_check.'\',\'2\',\''.$ancho.'\',\''.$alto.'\',\'this\')"/>				
		</li>':'';	
	

	echo "<ul>";

}



//Libreria para Llenar Select en formularios 

function opciones($conexion,$tabla,$campo1,$campo2,$op_extras){
	$op_consulta=mysql_query("SELECT $campo1,$campo2 FROM $tabla $op_extras",$conexion);
	while($op_respuesta=mysql_fetch_row($op_consulta)){
		?>
        	<option value="<?php echo $op_respuesta[0]; ?>"><?php echo $op_respuesta[1]; ?></option>
        <?php
	}
}

//Seleccionador con opciones ----
function opcionesseleccionador($conexion,$tabla,$campo1,$campo2,$op_extras,$extras){
	$op_consulta=mysql_query("SELECT $campo1,$campo2 FROM $tabla $extras",$conexion);
	while($op_respuesta=mysql_fetch_row($op_consulta)){
		?>
        	<option value="<?php echo $op_respuesta[0]; ?>" <?php echo ($op_extras==$op_respuesta[0])? 'SELECTED':''; ?>><?php echo $op_respuesta[1]; ?></option>
        <?php
	}
}



//-------------------------------------------Generador de Etiquetas para Orden de Compra---------------------------------------------

function generaretiquetaImp($lineas_oc,$conexion,$zpluser){
	
	//Primero se realiza la busqueda de las lineas grabadas en la base de datos
	$mysqletiqueta1=mysql_query("SELECT com_inventario.*,com_productos.codbarras,com_productos.nombre,com_unidades.nombre as unidad FROM com_inventario 
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
WHERE lineaoc_id in ($lineas_oc)",$conexion);

	//Sobreescribir archivo imprimiendo.txt --ubicacion en com_pages
	while($rmysqletiqueta1=mysql_fetch_assoc($mysqletiqueta1)){

		//Restringiendo Nombre a 30 caracteres -----------------------------
		$et_nombre=substr($rmysqletiqueta1['nombre'],0,19);
		$et_nombre2=substr($rmysqletiqueta1['nombre'],20,44);
		$et_barras=$rmysqletiqueta1['codbarras'];
		$et_fecha=gmdate('Y-m-d');
		$et_cant=$rmysqletiqueta1['cantidad_entrada']." ".$rmysqletiqueta1['unidad'];
		$et_RFID=$rmysqletiqueta1['RFID'];
		$et_cant1=$rmysqletiqueta1['cantidad_entrada'];
		
		
		//Generando String a Cargar
		//$vfecha=explode("-",$et_fecha);
		//$et_barrasf=$et_barras."".$vfecha[2]."".$vfecha[1]."".$vfecha[0]."".$et_cant."".$et_RFID;
		//Generando String a Cargar
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
		
		
		$file_et = "..\\com_pages\\imprimiendo.txt";
  $fp_et = fopen($file_et, "w");
		fwrite($fp_et,$zpl);   
		fclose($fp_et);
		
		/*sE COMENTAN PARA TRABAJAR EN LA CASA*/
		sleep(5);
		pclose(popen("start /B impresora.bat", "r")); 
 		
		sleep(5);		//eSTE SLEEP ES DE 5
   		
	}
	
	
}


//Pregunto de etiquetas impresas exitosamente ----------------------------

function et_exito($lineas_oc,$conexion){

	$up_etiquetas=mysql_query("UPDATE com_inventario SET estado='1',etiquetado='2' WHERE lineaoc_id in ($lineas_oc)",$conexion);
	if(mysql_errno($conexion)!='0'){
		echo "Error no se pudo actualizar el estado de las lineas en OC - Etiquetado";
	}
	
}


//Direcciones . Proveedores
function opdireccionproveedor(){
	
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	
	$op_consulta="SELECT com_direccionproveedor.Id as id,CONCAT_WS(', ',com_proveedores.nombre,com_direccionproveedor.direccion,com_ciudad.ciudad) as nombre
FROM com_direccionproveedor
LEFT JOIN com_proveedores ON com_proveedores.Id=com_direccionproveedor.proveedor_id
LEFT JOIN com_ciudad ON com_ciudad.Id=com_direccionproveedor.ciudad_id 
GROUP BY com_direccionproveedor.Id";
	?>
    	<option value=""></option>		
    <?php
	if ($matriz = $enlace->query($op_consulta)) {
		while ($op_respuesta = $matriz->fetch_row()) {
			echo $op_respuesta[0]; 
	?>
        	
        <option value="<?php echo $op_respuesta[0]; ?>"><?php echo $op_respuesta[1]; ?></option>
    <?php
		}
		$matriz->free();
	}
	
	$enlace->close();


}


//Direccion de Proveedores Seleccionada

function opdireccionproveedorsel($seleccion){
	
	
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	
	$op_consulta="SELECT com_direccionproveedor.Id as id,CONCAT_WS(', ',com_proveedores.nombre,com_direccionproveedor.direccion,com_ciudad.ciudad) as nombre
FROM com_direccionproveedor
LEFT JOIN com_proveedores ON com_proveedores.Id=com_direccionproveedor.proveedor_id
LEFT JOIN com_ciudad ON com_ciudad.Id=com_direccionproveedor.ciudad_id 
GROUP BY com_direccionproveedor.Id";

	if ($matriz = $enlace->query($op_consulta)) {
		while ($op_respuesta = $matriz->fetch_row()) {
	?>
        	
        	<option value="<?php echo $op_respuesta[0]; ?>" <?php echo ($op_respuesta[0]==$seleccion)? 'SELECTED':''; ?> ><?php echo $op_respuesta[1]; ?></option>
    <?php
		}
		$matriz->free();
	}
	
	$enlace->close();
}


//Funcion para eliminar acentos --------------//

function stripAccents($String)
{
	$String=utf8_encode($String);
	
	$vector_repa=array('ä','á','à','â','ã','ª');
    $String = str_replace($vector_repa,"a",$String);
	
	$vector_repa=array('Á','À','Â','Ã','Ä');
    $String = str_replace($vector_repa,"A",$String);
 
 	$vector_repi=array('Í','Ì','Î','Ï');
    $String = str_replace($vector_repi,"I",$String);
	
	$vector_repi=array('í','ì','î','ï');
    $String = str_replace($vector_repi,"i",$String);
	
	$vector_repe=array('é','è','ê','ë');
    $String = str_replace($vector_repe,"e",$String);
	
	$vector_repe=array('É','È','Ê','Ë');
    $String = str_replace($vector_repe,"E",$String);
	
	$vector_repo=array('ó','ò','ô','õ','ö','º');
    $String = str_replace($vector_repo,"o",$String);
	
	$vector_repo=array('Ó','Ò','Ô','Õ','Ö');
    $String = str_replace($vector_repo,"O",$String);
    /*$String = str_replace("[úùûü]","u",$String);
    $String = str_replace("[ÚÙÛÜ]","U",$String);
    $String = str_replace("[^´`¨~]","",$String);
    $String = str_replace("ç","c",$String);
    $String = str_replace("Ç","C",$String);
    $String = str_replace("ñ","n",$String);
    $String = str_replace("Ñ","N",$String);
    $String = str_replace("Ý","Y",$String);
    $String = str_replace("ý","y",$String);*/
    return $String;
}


/*Para la funcion inventario los tipos son:
1. Entrada por OC
2. Salida por Venta

se debe pasar la linea de inventario $line
se debe pasar la fecha en la variable $date
se debe pasar la cantidad de entrada $intro
se debe pasar la cantidad de salida en $out
se debe enviar la linea de la OC o la del pedido $line2*/

function inventario($type,$line,$date,$intro,$out,$isussr,$line2){
	if($type==1){
		$insertar=mysql_query("INSERT INTO com_movimientosproductos SET inventario_id='$line',fechamovimiento='$date',cantentrada='$intro',usuario_id='$isussr',lineaorden_id='$line2' ");
		if(!$insertar){
			$error=1;
		}
	}else if($type==2){
		$insertar=mysql_query("INSERT INTO com_movimientosproductos SET inventario_id='$line',fechamovimiento='$date',cantsalida='$intro',usuario_id='$isussr',lineapedido_id='$line2' ");
		if(!$insertar){
			$error=1;
		}
	}else{
		$error=1;
	}
}


/* Direccion Clientes -----------------------*/

//Direcciones . Proveedores

function opdireccioncliente(){
	
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	
	$op_consulta="SELECT com_direccionclientes.Id as id,CONCAT_WS(', ',com_clientes.nombres,com_direccionclientes.direccion,com_ciudad.ciudad) as nombre
FROM com_direccionclientes
LEFT JOIN com_clientes ON com_clientes.Id=com_direccionclientes.cliente_id
LEFT JOIN com_ciudad ON com_ciudad.Id=com_direccionclientes.ciudad_id
GROUP BY com_direccionclientes.Id";

	if ($matriz = $enlace->query($op_consulta)) {
		while ($op_respuesta = $matriz->fetch_row()) {
		?>
        	
        	<option value="<?php echo $op_respuesta[0]; ?>"><?php echo $op_respuesta[1]; ?></option>
         <?php
		}
		$matriz->free();
	}
	
	$enlace->close();
}



//Direccion Cliente seleccionado
function opdireccionclientesel($seleccion){
	
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	
	$op_consulta="SELECT com_direccionclientes.Id as id,CONCAT_WS(', ',com_clientes.nombres,com_direccionclientes.direccion,com_ciudad.ciudad) as nombre
FROM com_direccionclientes
LEFT JOIN com_clientes ON com_clientes.Id=com_direccionclientes.cliente_id
LEFT JOIN com_ciudad ON com_ciudad.Id=com_direccionclientes.ciudad_id
GROUP BY com_direccionclientes.Id";

	if ($matriz = $enlace->query($op_consulta)) {
		while ($op_respuesta = $matriz->fetch_row()) {
	?>		
			<option value="<?php echo $op_respuesta[0]; ?>" <?php echo ($seleccion==$op_respuesta[0])? 'SELECTED':'DISABLED'; ?>><?php echo $op_respuesta[1]; ?></option>
            
    <?php
		}
		$matriz->free();
	}
	
	$enlace->close();
}


/*Combos segun tipo de producto para ubicacion en estanteria*/
function estantes_espacio($linea,$talla,$producto,$extras){
	
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	$lineas="";
	
	//Revisando en que cajoneras ya hay el producto para sacarlas de la consulta para ubicación ====================================================
	$op_consulta="SELECT com_inventario.producto_id,GROUP_CONCAT(DISTINCT arraybodega_id) FROM com_inventario 
WHERE producto_id='$producto' GROUP BY producto_id";

	if ($matriz = $enlace->query($op_consulta)) {
		while ($op_respuesta = $matriz->fetch_row()) {
			$no_incluir=$op_respuesta[1];
		}
		$matriz->free();
	}
	
	if($extras!=""){
		$no_incluir=$no_incluir.",".$extras;
	}
	
	$op_consulta="SELECT com_arraybodega.Id,com_arraybodega.nombre,com_arraybodega.capacidad,ocupado FROM com_arraybodega
LEFT JOIN(
	SELECT count(Id) as ocupado,arraybodega_id FROM com_inventario WHERE com_inventario.fechasalida is null GROUP BY arraybodega_id
) AS invt ON invt.arraybodega_id=com_arraybodega.Id
WHERE talla_id='$talla' and categoria_id='$linea' and com_arraybodega.Id not in ($no_incluir) GROUP BY com_arraybodega.Id ORDER BY estante,nivel";

 	$opfileb=fopen("porque2.txt","a");
	fwrite($opfileb, $op_consulta."\n");
	fclose($opfileb);
   
	if ($matriz = $enlace->query($op_consulta)) {
		while ($op_respuesta = $matriz->fetch_row()) {
			
			if($op_respuesta[3]<$op_respuesta[2]){
				$lineas.=$op_respuesta[0]."::".$op_respuesta[1]."::".($op_respuesta[2]-$op_respuesta[3]).";;";
			}
            
    	}
		$matriz->free();
	}
	
	$lineas=substr($lineas,0,-2);
	$enlace->close();
	
	return $lineas;
	
}

/*Combos segun tipo de producto para ubicacion en estanteria*/
function estante_select($rfid,$prod){
	
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	$capacidad=CAPACIDAD;
	$lineas="";
	$flag=0;
	$v_rfid=explode(",",$rfid);			//Vector RFID
	$v_prod=explode(",",$prod);			//Vector de Productos
	$count_rep=array_count_values($v_prod);	//Cuenta repetidos y asigna la llave
	
	$b_rfid="";
	$v_capacidad=array();
	
	//Buscando si existe espacio en algun estante que ya contenga el producto =================================================
	
	
	foreach($count_rep as $clave){
		
		$data2=key($count_rep);	//Id del producto a buscar
		$cantidad=$clave;
		
		$op_consulta="SELECT count(*) as totalids,com_inventario.arraybodega_id,prodbus.ocupado,prodbus.producto_id,com_arraybodega.nombre FROM com_inventario
LEFT JOIN(
 SELECT count(*) as ocupado,inv2.arraybodega_id,inv2.producto_id FROM com_inventario as inv2
	WHERE inv2.fechasalida is NULL AND inv2.producto_id in ($data2) 
	and inv2.arraybodega_id is not null GROUP BY inv2.arraybodega_id
) AS prodbus ON prodbus.arraybodega_id=com_inventario.arraybodega_id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
WHERE com_inventario.fechasalida is NULL and com_inventario.arraybodega_id is not null 
GROUP BY com_inventario.arraybodega_id";


		if ($matriz = $enlace->query($op_consulta)) {
			while ($op_respuesta = $matriz->fetch_row()) {
				if($op_respuesta[0]<$capacidad){	//Solo hace el proceso si queda espacio en la cajonera
					
					$espacio=$capacidad-$op_respuesta[0];		//Espacios que quedan en la cajonera
					
					
					if($espacio>=$cantidad){
						$lineas.=$op_respuesta[3]."::".$cantidad."::".$op_respuesta[1]."::".$op_respuesta[4].";;";
						break;
					}else if($espacio<$cantidad){
						$lineas.=$op_respuesta[3]."::".$espacio."::".$op_respuesta[1]."::".$op_respuesta[4].";;";
						$cantidad=$cantidad-$espacio;
					}
				}
			}
		}
		$matriz->free();
	}
	

	$lineas=substr($lineas,0,-2);
	$enlace->close();
	
	return $lineas;
} 


/*Combo para estantes de recepción vacios */

function estante_entrada(){
	
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	$capacidad=CAPACIDAD;
	$lineas="";
	
	//Buscando si existe espacio en algun estante que ya contenga el producto =================================================
	$op_consulta="SELECT Id,nombre,ocupado FROM com_arraybodega 
LEFT JOIN (
 SELECT count(*) as ocupado,arraybodega_id FROM com_inventario GROUP BY arraybodega_id
) AS conteo ON conteo.arraybodega_id=com_arraybodega.Id
WHERE areas_almacenamiento_id='2' ";

	if ($matriz = $enlace->query($op_consulta)) {
		while ($op_respuesta = $matriz->fetch_row()) {
			
			if($op_respuesta[2]<$capacidad){
				$lineas.=$op_respuesta[0]."::".$op_respuesta[1]."::".($capacidad-$op_respuesta[2]).";;";
			}
            
    	}
		$matriz->free();
	}
	
	$lineas=substr($lineas,0,-2);
	$enlace->close();
	
	return $lineas;
}

?>