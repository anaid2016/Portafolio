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
<title>Suavizado Exponencial</title>
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
	  $vinformacion=array();
	  $year=gmdate("Y");
	  $yearmenor=$year-2;
	  $mesactual=gmdate("m");
	  $alfa=0.1;
	  
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

	  //Consulta en metros por fechas para realizar estimacion de demanda; visualización a 700 dias//
	  
	  $buscar2=mysql_query("SELECT com_direccionproveedor.Id,CONCAT_WS('::',com_inventario.producto_id,YEAR(com_inventario.fechasalida),month(com_inventario.fechasalida)) as productofecha, sum(cantidad) as vendida FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_proveedorproductos ON com_productos.Id=com_proveedorproductos.producto_id 
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id WHERE com_inventario.fechasalida>=DATE_SUB(CURRENT_DATE(),INTERVAL 700 DAY)
and com_inventario.producto_id in (".$idproductos.") GROUP BY productofecha",$conexion);

		while($resultado=mysql_fetch_assoc($buscar2)){
			$vinterno=explode("::",$resultado["productofecha"]);
			$inf_prod=$vinterno[0];
			$inf_year=$vinterno[1];
			$inf_mes=$vinterno[2];
			$vinformacion[$inf_prod][$inf_year][$inf_mes]=$resultado["vendida"];  //esta valor de vendida es en metros
		}

	
	
	 for($a=0;$a<count($vproductos);$a++){
		  $start=1;			//Para diferenciar el primer mes.
		  $startyear=1;		//Para diferenciar el primer año.  
	 	  $vendanterior=0;
	 	  $resultandoanterior=0;
		  $errormedio=0;
		  $intro0=$vproductos[$a];
		 
		 echo "<h3>$vproductos[$a]</h3>";
		 echo "<table><tr><td>Año</td><td>Mes</td><td>Yt</td><td>Yt' SE</td><td>Error SE</td></tr>";
		 for($b=$yearmenor;$b<=$year;$b++){
			
			//Seleccina el mes desde el cual inicia el año, al igual que en cual termina.....
			$ini=($startyear==1)? $mesactual:1;
			$fin=($startyear==3)? $mesactual:12;
			
			for($c=$ini;$c<=$fin;$c++){
				  
				   //Este es el espacio para que aparezcan los ceros, se deben tener en cuenta en todo el periodo o solo desde que aparezcan datos?.....	
				   $vinformacion[$intro0][$b][$c]=(!isset($vinformacion[$intro0][$b][$c]))? 0:$vinformacion[$intro0][$b][$c];
				  
				   if(isset($vinformacion[$intro0][$b][$c])){
						$ytanterior=($start==1)? $vinformacion[$intro0][$b][$c]:$resultadoanterior;	//Para Suavisado Exponencial Simple
						
					?>	
				
					<tr>
                    	<td><?php echo $b; ?></td>
                        <td><?php echo $c; ?></td>
                        <td><?php echo (!isset($vinformacion[$intro0][$b][$c]))? '':$vinformacion[$intro0][$b][$c]; ?></td>
                        <td><?php echo $ytanterior; ?></td> <!--Para Suavisado Exponencial Simple-->
                        <td><?php $errorac=($vinformacion[$intro0][$b][$c]-$ytanterior); echo $errorac; ?><!--Para Suavisado Exponencial Simple-->
                    </tr>
                    
				<?php
						$start=$start+1;
						
						//Para Suavisado Exponencial Simple
						$vendanterior=$vinformacion[$intro0][$b][$c];		//Vendido en el mes anterior de datos
						$resultadoanterior=($alfa*$vendanterior)+((1-$alfa)*($ytanterior));
						$errormedio=$errorac+$errormedio;
				   }
			}
			
			$startyear=$startyear+1;
			 
		 }
		
		 
		 $ytfinal[$intro0]=$resultadoanterior;
		 $errorprom[$intro0]=$errormedio/($start-1);
		 echo "<tr style='background:blue'>";
		 echo "<td colspan='4' align='right'>".+$ytfinal[$intro0]."</td>";
		 echo "<td>error promedio:  ".+ $errorprom[$intro0]."</td>";
		 
		  echo "</table>";
		 
	 }
	 

  }

?>

</body>
</html>