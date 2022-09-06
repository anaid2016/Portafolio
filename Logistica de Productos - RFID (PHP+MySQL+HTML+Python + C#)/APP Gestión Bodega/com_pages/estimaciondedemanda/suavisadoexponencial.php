<?php
	$archivo="../../funciones/datos.txt";
	include("../../funciones/conexbd.php");
	include("../../funciones/librerias.php");
	include("../../funciones/seguridad.php");
	include("funciones.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Suavizado Exponencial Simple</title>
<link rel="stylesheet" type="text/css" href="../../css/suavizado.css">
</head>
<script language="javascript" type="text/javascript">
function Cerrar(){
	opener.location.href = "../agordencompra.php";
    window.close();
}

function pasar(productos,conteo){
		
		var escoger= String();
	
		var checks = document.getElementsByName('dataline'),i;
		var fila=1;
		vproductos=productos.split("::");
		//var fila=document.getElementById('filat').value;
		for (i=0;i<checks.length;i++) {
			if (checks[i].checked){
				 var cantidad=document.getElementById('Prod'+vproductos[i]).value;
				 if(cantidad>0){
				 	escoger=escoger+(checks[i].value)+'-'+cantidad+'::';
				 }
			}
		}
		//alert("ventana"+window.opener);
		window.opener.politica(escoger,fila);
		window.close();
}

/*Cambia con el boton de radio */

function cantpoliticas(seleccionado){
	
	var name=seleccionado.name;
	var dimension=name.length;
	var newdata="Prod"+name.substr(4,dimension);			//nombre del text por filas
	
	//Capacidad en metros del contenedor --------------------------------------//
	var wtela=Number(document.getElementById("wtela").value);
	
	var olddata=Number(document.getElementById(newdata).value);		//anterior valor de la caja de texto x filas
	var oldsum=Number(document.getElementById("totalenm").value);		//anterior valor de la suma total
	
	var newdatasum=Number(seleccionado.value);				//nuevo valor seleccionado
	
	var newsum=oldsum-olddata+newdatasum;					//nueva suma entrega

	//Total en Metros------------------------------------------------------------//
	document.getElementById("totalenm").value=newsum.toFixed(2);	
	
	//Total de Linea Nuevo -----------------------------------------------------//
	document.getElementById(newdata).value=newdatasum.toFixed(2);
	
	//Cantidad contenedores ----------------------------------------------------//
	var cantcontenedor=newsum/wtela;
	document.getElementById("contenedores").value=Math.round(cantcontenedor);
	

	//faltante ----------------------------------------------------------------//
	var faltante=(Math.round(cantcontenedor)-cantcontenedor)*wtela;
	document.getElementById("faltanteenm").value=faltante.toFixed(2);
}

/*Cambia manualmente en input text*/

function politicamanual(seleccionado,indices){
	
	var newdata=seleccionado.name;							//nombre del text por filas
	var newdatasum=Number(seleccionado.value);				//nuevo valor seleccionado
	indicesarray=indices.split(",");;
	
	//Capacidad en metros del contenedor --------------------------------------//
	var wtela=Number(document.getElementById("wtela").value);
	var newsum=0;
	
	for(j=0;j<indicesarray.length;j++){	
		var linea="Prod"+indicesarray[j];
		newsum=newsum+Number(document.getElementById(linea).value);		
	}

	//Total en Metros------------------------------------------------------------//
	document.getElementById("totalenm").value=newsum.toFixed(2);	
	
	//Total de Linea Nuevo -----------------------------------------------------//
	document.getElementById(newdata).value=newdatasum.toFixed(2);
	
	//Cantidad contenedores ----------------------------------------------------//
	var cantcontenedor=newsum/wtela;
	document.getElementById("contenedores").value=Math.round(cantcontenedor);
	

	//faltante ----------------------------------------------------------------//
	var faltante=(Math.round(cantcontenedor)-cantcontenedor)*wtela;
	document.getElementById("faltanteenm").value=faltante.toFixed(2);
}


</script>

<body>
<?php

  if(empty($_GET['prov']) and empty($_POST['pasopolitica']) and empty($_GET['recalcular']) ){
	die("No ha seleccionado un proveedor para iniciar estimación");
	 
  }else if(!empty($_POST['pasopolitica']) and empty($_GET['recalcular'])){
	  include("politicas.php");
  }else{
	  $alfa=(!empty($_GET['alfa']))? $_GET['alfa']:0.3;
	  $beta=(!empty($_GET['beta']))? $_GET['beta']:0.1;
	  $gama=(!empty($_GET['gama']))? $_GET['gama']:0.3;
	  $meses=(!empty($_GET['meses']))? $_GET['meses']:1;
  ?>
  	<h3>Estimación de Demanda</h3>
  		<p>Seleccione un valor para alpha, beta, gama y periodo de predicción en meses:</p>
        
  		<form action='' method="GET">
            <table>
                <tr>
                    <td>Alpha</td>
                    <td><input type="text" value="<?php echo $alfa; ?>" name="alfa" /></td>
                    <td>Beta</td>
                    <td><input type="text" value="<?php echo $beta; ?>" name="beta" /></td>
                    <td>Gamma</td>
                    <td><input type="text" value="<?php echo $gama; ?>" name="gama" /></td>
                    <td>Periodos</td>
                    <td><input type="text" value="<?php echo $meses; ?>" name="meses" /></td>
                    <td><input type="hidden" value="<?php echo $_GET['prov']; ?>" name="prov" /></td>
                    <td><input type="submit" name="recalcular" value="Recalcular" />
                </tr>
           </table>
  		</form>
  <?php 	  
	  
	  $vdatosxgrupo=array();
	  $vinformacion=array();
	  $tiempoinfo=array();
	  $year=gmdate("Y");
	  $yearmenor=$year-2;
	  $mesactual=gmdate("m");
	  $fechasolicitud=$yearmenor."-".$mesactual."-01";
	  
	  
	  $idprov=$_GET['prov'];
	  //Busqueda de los productos vendidos por el proveedor en un rango de 60 dias --para pruebas se configura a 180 dias.
	  
	  /*$buscar=mysql_query("SELECT GROUP_CONCAT(DISTINCT com_inventario.producto_id) as productos,GROUP_CONCAT(DISTINCT com_productos.nombre),GROUP_CONCAT(com_proveedorproductos.cantidadcompra) as minimo  FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_proveedorproductos ON com_productos.Id=com_proveedorproductos.producto_id 
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id WHERE com_inventario.fechasalida>=DATE_SUB(CURRENT_DATE(),INTERVAL 180 DAY)
and com_direccionproveedor.Id='$idprov'",$conexion);*/

		
		$buscar=mysql_query("SELECT com_inventario.producto_id as productos,
com_productos.nombre,com_proveedorproductos.cantidadcompra as minimo  FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_proveedorproductos ON com_productos.Id=com_proveedorproductos.producto_id 
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id 
WHERE com_inventario.fechasalida>=DATE_SUB(CURRENT_DATE(),INTERVAL 180 DAY)
and com_direccionproveedor.Id='$idprov' GROUP BY productos",$conexion);

		$vproductos=array();
		$vproductos2=array();
		$vproductos3=array();
		$idproductos="";
		
	 	while($p_result=mysql_fetch_row($buscar)){
			array_push($vproductos,$p_result[0]);
			array_push($vproductos2,$p_result[1]);	
			array_push($vproductos3,$p_result[2]);
			$idproductos.=$p_result[0].",";
		}
	   
	   	$idproductos=substr($idproductos,0,-1);
		
	   //Buscar desde que mes se encuentran datos para comprar desde donde empezar sacar información.....
	   
	   $buscar3=mysql_query("SELECT com_inventario.producto_id,MIN(EXTRACT(YEAR_MONTH FROM com_inventario.fechasalida)) as tiempo
FROM com_inventario LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id 
LEFT JOIN com_proveedorproductos ON com_productos.Id=com_proveedorproductos.producto_id 
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id 
WHERE com_inventario.producto_id in (".$idproductos.") GROUP BY com_inventario.producto_id",$conexion);

	   
	   while($rtiempo=mysql_fetch_assoc($buscar3)){
		   $protiempo=$rtiempo["producto_id"];
		   $tiempoinfo["year"][$protiempo]=substr($rtiempo["tiempo"],0,-2);
		   $tiempoinfo["mes"][$protiempo]=substr($rtiempo["tiempo"],4,6);
		   $tiempoinfo["fecha"][$protiempo]=substr($rtiempo["tiempo"],0,-2)."-".substr($rtiempo["tiempo"],4,6)."-01";
	   }

	  //Consulta en metros por fechas para realizar estimacion de demanda; visualización a 700 dias//
	  
	  $buscar2=mysql_query("SELECT com_direccionproveedor.Id,CONCAT_WS('::',com_inventario.producto_id,YEAR(com_inventario.fechasalida),month(com_inventario.fechasalida)) as productofecha, 
sum(cantidad) as vendida FROM com_inventario LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id 
LEFT JOIN com_proveedorproductos ON com_productos.Id=com_proveedorproductos.producto_id 
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id 
WHERE com_inventario.fechasalida>=DATE_SUB(CURRENT_DATE(),INTERVAL 720 DAY) and com_inventario.producto_id in  (".$idproductos.") GROUP BY productofecha ORDER BY year(com_inventario.fechasalida),month(com_inventario.fechasalida)",$conexion);


		while($resultado=mysql_fetch_assoc($buscar2)){
			$vinterno=explode("::",$resultado["productofecha"]);
			$inf_prod=$vinterno[0];
			$inf_year=$vinterno[1];
			$inf_mes=$vinterno[2];
			$vinformacion[$inf_prod][$inf_year][$inf_mes]=$resultado["vendida"];  //esta valor de vendida es en metros
		}
		


	?>
    
    <!-- INICIA EL FORMULARIO DE ESTIMACION DE DEMANDA -------------------------------------------------------------------->
    <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST' >
    
    <div class="datagrid">
    <?php 
	
	 echo "<table border='1' cellpadding='2' cellspacing='0'><tr><td>Id</td><td>Producto</td><td>Cant. Min</td><td class='suavsimplesup'>SS</td><td class='suavsimplesup'>Error SS</td><td class='suavdoblesup'>SD</td><td class='suavdoblesup'>Error SD</td><td class='suavwintermsup'>HWM</td><td class='suavwintermsup'>Error HWM</td><td class='suavwinterasup'>HWA</td><td class='suavwinterasup'>Error HWA</td><td>Seleccionado</td></tr>";
	  
	 $conteoproductos=count($vproductos); 
	 $lineaIds="";
	 
	 for($a=0;$a<$conteoproductos;$a++){
		
		  $start=1;			//Para diferenciar el primer mes.
		  $vendanterior=0;
	 	  $resultandoanterior=0;
		  $intro0=$vproductos[$a];
		  $lineaIds.=$vproductos[$a].",";
		 
		 //Seleccina el mes desde el cual inicia el año, al igual que en cual termina.....
		 //Paso 1, verificar que existan datos para realizar la transaccion a dos años atras, si no existen datos
		 // el sistema calculará desde la fecha en la que encuentre datos; se reviza datos hacia atras asi sean antes de dos 		
		 //años....----.
		 $datetime1 = new DateTime($tiempoinfo["fecha"][$intro0]);	//fecha en base de datos que reporta la salida mas vieja
		 $datetime2 = new DateTime($fechasolicitud);				//fecha de recorrido hacia atras de dos años
		 
		 if($datetime1>$datetime2){
			 $yearmenor=$tiempoinfo["year"][$intro0];
			 $mesactual2=(int)$tiempoinfo["mes"][$intro0];
		 }else{
			 $mesactual2=$mesactual;
		 }
		 
		 
		
		 echo "<tr><td>".$vproductos[$a]."</td><td>".$vproductos2[$a]."</td><td>".$vproductos3[$a]."</td>";
		 
		 
		 
		 //PARA SUAVISADO EXPONENCIAL SIMPLE....
		 $RV1=suavexpsimple($yearmenor,$year,$mesactual2,$mesactual,$intro0,$vinformacion,$alfa,$meses);
		 $ytfinal[$intro0][0]=$RV1[0];
		 $errorprom[$intro0][0]=$RV1[1];
		 
		 if($RV1!="NHA"){
		 	echo "<td class='suavsimple'>".number_format($ytfinal[$intro0][0],'2','.','')."</td>";
		 	echo "<td class='suavsimpleerror'>".number_format($errorprom[$intro0][0],'2','.','')."</td>";
		 }else{
			 echo "<td class='suavsimple'>NHA</td>";	
			 echo "<td class='suavsimpleerror'>NHA</td>";	
		 }
		 
		 //SUAVIZADO EXPONENCIAL DOBLE
		 $RV2=suavhotltende($yearmenor,$year,$mesactual2,$mesactual,$intro0,$vinformacion,$alfa,$beta,$meses);
		 $ytfinal[$intro0][1]=$RV2[0];
		 $errorprom[$intro0][1]=$RV2[1];
		 
		 if($RV2!="NHA"){
			echo "<td class='suavdoble'>".number_format($ytfinal[$intro0][1],'2','.','')."</td>";
		 	echo "<td class='suavdobleerror'>".number_format($errorprom[$intro0][1],'2','.','')."</td>";
		 }else{
			 echo "<td class='suavdoble'>NHA</td>";	
			 echo "<td class='suavdobleerror'>NHA</td>";	
		 }
		 
		 
		 
		 
		 //POR EL METODO HOLT-WINTERS MULTIPLICATIVO
		 
		 $sum12periodos=0;
		 $daysprom=0; 
		
		 
		$RV3=suavhotlwintmultiplicativo($yearmenor,$year,$mesactual2,$mesactual,$intro0,$vinformacion,$alfa,$beta,$gama,$meses);
		 
		//Valor pronosticado -----------------------------------------------------------------//
		$ytfinal[$intro0][2]=$RV3[0];
		$errorprom[$intro0][2]=($RV3[1]=="H")? 10E5:$RV3[1];
		$mostar=($errorprom[$intro0][2]==10E5)? 'NHA':number_format($errorprom[$intro0][2],'2','.','');
		
		if($RV3!="NHA"){
			 echo "<td class='suavwinterm'>".number_format($ytfinal[$intro0][2],'2','.','')."</td>";
			 echo "<td class='suavwintermerror'>".$mostar."</td>";
		}else{
			echo "<td class='suavwinterm'>NHA</td>";	
			echo "<td class='suavwintermerror'>NHA</td>";		
		}
		
		 
		//POR EL METODO HOLT-WINTERS ADITIVO
		 
		 $sum12periodos=0;
		 $summeses=array();
		 $daysprom=0; 
		 $start=1;			//Para diferenciar el primer mes.
		
		 
		$RV4=suavhotlwintaditivo($yearmenor,$year,$mesactual2,$mesactual,$intro0,$vinformacion,$alfa,$beta,$gama,$meses);
		 
		//Valor pronosticado -----------------------------------------------------------------//
		$ytfinal[$intro0][3]=$RV4[0];
		$errorprom[$intro0][3]=($RV4[1]=="H")? 10E5:$RV4[1];
		$mostrar=($errorprom[$intro0][3]==10E5)? 'NHA':number_format($errorprom[$intro0][3],'2','.','');
		
		if($RV4!="NHA"){
			 echo "<td class='suavwintera'>".number_format($ytfinal[$intro0][3],'2','.','')."</td>";
			 echo "<td class='suavwinteraerror'>".$mostrar."</td>";
		}else{
			echo "<td class='suavwintera'>NHA</td>";	
			echo "<td class='suavwinteraerror'>NHA</td>";		
		}
		 
		
		//Buscando el menor de los calculados ----------------------------------------------//
		$menor=$errorprom[$intro0][0];
		$yindice=0;
		
		for($y=0;$y<4;$y++){
			if($menor>$errorprom[$intro0][$y]){
				$menor=$errorprom[$intro0][$y];
				$yindice=$y;
			}
		}
		
		
	?>	
		<td>
        	<select name='selector<?php echo $a;?>' id='selector<?php echo $a;?>' >
				<option value='<?php echo $vproductos[$a]."--".$ytfinal[$intro0][0]; ?>' <?php echo ($yindice==0)? 'SELECTED':''; ?> >Suav. Simple</option>
        		<option value='<?php echo $vproductos[$a]."--".$ytfinal[$intro0][1]; ?>' <?php echo ($yindice==1)? 'SELECTED':''; ?> >Suav. Doble</option>
        		<option value='<?php echo $vproductos[$a]."--".$ytfinal[$intro0][2]; ?>' <?php echo ($yindice==2)? 'SELECTED':''; ?> >HW. Multiplicativo</option>
        		<option value='<?php echo $vproductos[$a]."--".$ytfinal[$intro0][3]; ?>' <?php echo ($yindice==3)? 'SELECTED':''; ?> >HW. Aditivo</option>
        </select>
        
        	<input type="hidden" name="proveedor" value="<?php echo $idprov; ?>" />	
            <input type="hidden" name="conteoproductos" value="<?php echo $conteoproductos; ?>" />	
        </td>
      
        
        </tr>
        
	
    <?php	 
	 }
	 ?>
     	<tr>
        	<td colspan="12" align="right">	<input type="submit" value="Politica de Compra" name="pasopolitica" /></td>
        </tr>
   	</table>
    </div>
 	</form>
    
    <ul>
  	<li>SS -> Suavizado Simple.</li>
    <li>SD -> Suavizado Doble.</li>
    <li>HWA -> Holt Winter Aditivo.</li>
    <li>HWM -> Holt Winter Multiplicativo</li>
   </ul>

	<p> Nota:  Para los calculos de Holt Winter Aditivio y Multiplicativo, se debe contar con al menos un año de datos contados hasta la fecha de revisión</p>
 <?php
  }
  ?>
  
</body>
</html>