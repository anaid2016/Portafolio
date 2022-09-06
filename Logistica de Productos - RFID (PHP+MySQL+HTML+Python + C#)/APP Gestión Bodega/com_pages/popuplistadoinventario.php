<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/comx_dbconn.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	
	$vec_indices="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Productos</title>
<script type="text/javascript" src="http://underscorejs.org/underscore-min.js"></script>  
<script src="http://code.jquery.com/jquery-1.9.1.js"></script> 
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>

<script language="javascript" type="text/javascript">

function pasar(){
		var escoger= String();
		var checks = document.getElementsByName('datos1'),i;
		//var fila=1;
		var fila=document.getElementById('filat').value;
		for (i=0;i<checks.length;i++) if (checks[i].checked) escoger=escoger+(checks[i].value)+'::';
		window.opener.datos(escoger,fila);
		window.close();
}

function Cerrar(){
	opener.location.href = "agpedido.php";
    window.close();
}

function sumas(cantidad,selecto){
	if (selecto.checked){
		var cantsumar=Number(cantidad);	
		var actual=Number(document.getElementById('totalsumita').value);
		var actual=actual+cantsumar;
		document.getElementById('totalsumita').value=actual.toFixed(2);
	}else{
		var cantsumar=Number(cantidad);	
		var actual=Number(document.getElementById('totalsumita').value);
		var actual=actual-cantsumar;
		document.getElementById('totalsumita').value=actual.toFixed(2);
	}

}


</script>

</head>
<body>

<!--Asignaciòn de filtros a la consulta -->
<?php
	$filtro='';
	if(!empty($_GET['filter_def']) && $_GET['filter_def']!=''){
		$p_buscar=$_GET['filter_def'];
		$filtro=" and com_productos.nombre LIKE '%".$p_buscar."%' ";	
	}
	
	if(!empty($_GET['filter_def2']) && $_GET['filter_def2']!=''){
		$p_buscar2=$_GET['filter_def2'];
		$filtro=" and com_inventario.RFID LIKE '%".$p_buscar2."%' ";	
	}
	
	if(!empty($_GET['filter_def3']) && $_GET['filter_def3']!=''){
		$p_buscar3=$_GET['filter_def3'];
		$filtro=" and com_productos.codbarras LIKE '%".$p_buscar3."%' ";	
	}


	//CONSULTA TODOS LOS PRODUCTOS DISPONIBLES EN INVENTARIO PARA VENDER =======================================================//
				
	$enlace = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$enlace->set_charset("utf8");
	$error_mysql=0;
	$data_array=array();
				
    //Consulta de todos los producto Existentes habilitados para venta en la BD
    $sentencia_sql2="SELECT com_inventario.*,com_productos.nombre,com_productos.codbarras,
		com_preciosclientes.preciosantesiva,com_preciosclientes.porcentajeiva,com_arraybodega.nombre as bodega,
		com_preciosclientes.precioconiva,com_unidades.nombre as unidad FROM com_inventario
		LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
		LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
		LEFT JOIN com_preciosclientes ON com_preciosclientes.producto_id=com_productos.Id
		LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
		WHERE com_inventario.existencia='0' and com_inventario.estado in ('2','4')  $filtro  ORDER BY com_productos.codbarras,com_inventario.RFID 	
		DESC";

		if ($matriz = $enlace->query($sentencia_sql2)) {
			while ($registro = $matriz->fetch_assoc()) {
				$antesiva=($registro['preciosantesiva']*$registro['cantidad']);
				$despuesiva=($registro['precioconiva']*$registro['cantidad']);
		
				$indice=$registro['Id'];
				
				$data_array[$indice]['codbarras']=$registro['codbarras']; 
				$data_array[$indice]['nombre']=$registro['nombre']; 
				$data_array[$indice]['RFID']=$registro['RFID']; 
				$data_array[$indice]['cantidad']=$registro['cantidad']; 
				$data_array[$indice]['unidad']=$registro['unidad'];
				$data_array[$indice]['bodega']=$registro['bodega'];
				$data_array[$indice]['antesiva']=$antesiva;
				$data_array[$indice]['porcentajeiva']=$registro['porcentajeiva'];
				$data_array[$indice]['precioconiva']=$despuesiva;
				$vec_indices.=$registro['Id'].",";
				
			}
			$matriz->free();
			$vec_indices=substr($vec_indices,0,-1);	
	}
	
	$enlace->close();

?>

<div id="contenidof4">
    	<h2> >> Inventario Actual: </h2>
        <form method="get" action="">
        	Producto: <input type="text" id="filter_def" name="filter_def" /> 
			Codigo de Barras: <input type="text" id="filter_def3" name="filter_def3" /> 
			RFID: <input type="text" id="filter_def2" name="filter_def2" /> 
            <!--Boton para activar el inventario --->
            <input type="submit" value="Filtrar" />
            <input type="hidden" id="fila"  value="<?php echo $_GET['fila']; ?>" name="fila"/>
            &nbsp;
            Total Seleccionado: <input type="text" readonly="readonly" id="totalsumita" value="0" />
        <br/><br/>
        <div class="datagrid">
        	<table cellpadding="10" cellspacing="0">
        		<thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Producto</th>
                      <th>No. Rollo</th>
                      <th>Cantidad</th>
                      <th>Und</th>
					  <th>Cajonera</th>
                      <th>Valor Base</th>
                      <th>IVA %</th>
                      <th>Valor Gravado</th>
                      <th>Select.</th>
                    </tr>
        		</thead>
        		<tbody>
                <?php
					$indi_for=explode(",",$vec_indices);
					for($a=0;$a<count($indi_for);$a++){
						$secuen=$indi_for[$a];
						
				?>
                <tr>
                      <td><?php echo $data_array[$secuen]['codbarras']; ?></td>
                      <td><?php echo $data_array[$secuen]['nombre']; ?></td>
                      <td><?php echo $data_array[$secuen]['RFID']; ?></td>
                      <td><?php echo $data_array[$secuen]['cantidad']; ?></td>
                      <td><?php echo $data_array[$secuen]['unidad']; ?></td>
					  <td><?php echo $data_array[$secuen]['bodega']; ?></td>
                      <td><?php echo $data_array[$secuen]['antesiva']; ?></td>
                      <td><?php echo $data_array[$secuen]['porcentajeiva']; ?></td>
                      <td><?php echo $data_array[$secuen]['precioconiva']; ?></td>
                      <td><input type="checkbox" name="datos1" value="<?php echo $secuen; ?>-<?php echo $data_array[$secuen]['codbarras']; ?>-<?php echo $data_array[$secuen]['nombre']; ?>-<?php echo $data_array[$secuen]['cantidad']; ?>-<?php echo $data_array[$secuen]['unidad']; ?>-<?php echo $data_array[$secuen]['RFID']; ?>-<?php echo $data_array[$secuen]['antesiva']; ?>-<?php echo $data_array[$secuen]['porcentajeiva']; ?>-<?php echo  $data_array[$secuen]['precioconiva']; ?>" id="datos1" onclick="sumas(<?php echo $data_array[$secuen]['cantidad']; ?>,this)"/></td>
                </tr>
                <?php
					}
				?>
                </tbody>
                <tfoot>
        			<tr>
        				<td><input type="hidden" value="<?php echo $_GET['fila']; ?>" name="fila" id="filat" /></td>
                        <td colspan="8" align="right"><input type="button" onClick="javascript: pasar();" value="Continuar" /></td>
            			<td><input type="button" onClick="javascript: cerrar();" value="Cancelar" /></td>
        			</tr>
			    </tfoot>
        	</table>
		</div>        
</form> 
</div>

</body>
</html>