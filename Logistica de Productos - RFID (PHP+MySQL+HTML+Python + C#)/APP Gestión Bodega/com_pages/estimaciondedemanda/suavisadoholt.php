<?php
	$archivo="../../funciones/datos.txt";
	include("../../funciones/conexbd.php");
	include("../../funciones/librerias.php");
	include("../../funciones/seguridad.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Suavizado Holt</title>
</head>
<script language="javascript" type="text/javascript">
function Cerrar(){
	opener.location.href = "../agordencompra.php";
    window.close();
}
</script>

<body>
<?php

  if(empty($_GET['prov'])){
	die("No ha seleccionado un proveedor para iniciar estimación");
	 
  }else{
	  $vdatosxgrupo=array();
	  $vinformacion=array();
	  $tiempoinfo=array();
	  $year=gmdate("Y");
	  $yearmenor=$year-2;
	  $mesactual=gmdate("m");
	  $fechasolicitud=$yearmenor."-".$mesactual."-01";
	  
	  
	  //Estos son los datos necesarios para calculos...////
	  $alfa=0.3;
	  $beta=0.1;
	  $gama=0.3;
	  $s=12;
	  $cuenta=0;
	  $pronosticos=3;
	  


	  $idprov=$_GET['prov'];
	  //Busqueda de los productos vendidos por el proveedor en un rango de 60 dias --para pruebas se configura a 180 dias.
	  
	  $buscar=mysql_query("SELECT GROUP_CONCAT(DISTINCT com_inventario.producto_id) as productos FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_proveedorproductos ON com_productos.Id=com_proveedorproductos.producto_id 
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id WHERE com_inventario.fechasalida>=DATE_SUB(CURRENT_DATE(),INTERVAL 180 DAY)
and com_direccionproveedor.Id='$idprov'",$conexion);


	   $productos=mysql_fetch_row($buscar);
	   $idproductos=$productos[0];
	   $vproductos=explode(",",$idproductos);
	   
	   
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
WHERE com_inventario.fechasalida>=DATE_SUB(CURRENT_DATE(),INTERVAL 730 DAY) and com_inventario.producto_id in  (".$idproductos.") GROUP BY productofecha ORDER BY year(com_inventario.fechasalida),month(com_inventario.fechasalida)",$conexion);


		while($resultado=mysql_fetch_assoc($buscar2)){
			$vinterno=explode("::",$resultado["productofecha"]);
			$inf_prod=$vinterno[0];
			$inf_year=$vinterno[1];
			$inf_mes=$vinterno[2];
			$vinformacion[$inf_prod][$inf_year][$inf_mes]=$resultado["vendida"];  //esta valor de vendida es en metros
		}

	
	
	 for($a=0;$a<count($vproductos);$a++){
		  $start=1;			//Para diferenciar el primer mes.
		  $grupo=1;			//Lleva el grupo para obtener promedios
		  
	  $intro0=$vproductos[$a];
		 
		 $datetime1 = new DateTime($tiempoinfo["fecha"][$intro0]);	//fecha en base de datos que reporta la salida mas vieja
		 $datetime2 = new DateTime($fechasolicitud);				//fecha de recorrido hacia atras de dos años
		 
		 if($datetime1>$datetime2){
			 $yearmenor=$tiempoinfo["year"][$intro0];
			 $mesactual2=(int)$tiempoinfo["mes"][$intro0];
		 }else{
			 $mesactual2=$mesactual;
		 }
		 
		echo "<table cellpadding='0' cellspacing='0' border='1'><tr><td>Periodo</td><td>Yt</td><td>Lt</td><td>Tt</td><td>Prom</td></tr>";
		 $sum12periodos=0;
		 $summeses=array();
		 $daysprom=0; 
	 	
		for($b=$yearmenor;$b<=$year;$b++){
			
		$ini=($b==$yearmenor)? (int) $mesactual2:1;
		$fin=($b==$year)? (int)$mesactual:12;
		
		
		for($c=$ini;$c<=$fin;$c++){
			   
		   //$vinformacion[$intro0][$b][$c]=(!isset($vinformacion[$intro0][$b][$c]))? 0:$vinformacion[$intro0][$b][$c];
			  
			   if(isset($vinformacion[$intro0][$b][$c])){
					
					$vinformacion[$intro0][$daysprom]=$vinformacion[$intro0][$b][$c];
					if($daysprom==1){
						$xnew[$daysprom]=$vinformacion[$intro0][$daysprom];
						$m[$daysprom]=$vinformacion[$intro0][$daysprom]-$vinformacion[$intro0][0];
						
					}
					$daysprom+=1;
			   }
		}
	 }
	 
	 //CALCULOS ----------------------------------------------------------------------------------
	 for($r=2;$r<$daysprom;$r++){
			$ant=$r-1;
			
			$xnew[$r]=($alfa*$vinformacion[$intro0][$r])+(1-$alfa)*($xnew[$ant]+$m[$ant]);
			$m[$r]=$beta*($xnew[$r]-$xnew[$ant])+(1-$beta)*($m[$ant]);
		
			$ult_x=$xnew[$r];
			$ult_m=$m[$r];
	}
		

	for($p=0;$p<$pronosticos;$p++){
		$sig=$daysprom+$p;
		$xnew[$sig]=$ult_x+($ult_m*($p+1));
	}
		
				
		for($r=0;$r<($daysprom+$pronosticos);$r++){
			
			echo "<tr>
			<td>".$r."</td>";
			echo (!empty($vinformacion[$intro0][$r]))? "<td>".number_format($vinformacion[$intro0][$r],'2','.','')."</td>":"<td></td>";
			echo (!empty($xnew[$r]))? "<td>".number_format($xnew[$r],'2','.','')."</td>":"<td></td>";
			echo (!empty($m[$r]))? "<td>".number_format($m[$r],'2','.','')."</td>":"<td></td>";
			echo (!empty($festaciones[$r]))? "<td>".number_format($festaciones[$r],'2','.','')."</td>":"<td></td>";
	
		}
		
		 
	 }
	 

  }

?>

</body>
</html>