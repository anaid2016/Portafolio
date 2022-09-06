<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	$proveedor=$_GET['prov'];
	
	$filtro='';
	if(!empty($_GET['filter_def']) && $_GET['filter_def']!=''){
		$p_buscar=$_GET['filter_def'];
		$filtro=" and com_nombres.nombre LIKE '%".$p_buscar."%' ";	
	}
	
	if(!empty($_GET['filter_def3']) && $_GET['filter_def3']!=''){
		$p_buscar2=$_GET['filter_def3'];
		$filtro=" and com_productos.codbarras LIKE '%".$p_buscar2."%' ";	
	}
	

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
		for (i=0;i<checks.length;i++) if (checks[i].checked) escoger=escoger+(checks[i].value)+',';
		window.opener.datos(escoger,fila);
		window.close();
}

function Cerrar(){
	opener.location.href = "agordencompra.php";
    window.close();
}
</script>

</head>
<body>
<div id="contenidof3">
    	<h2> >> Productos</h2>
        <div class="datagrid">
        <form>
        	 <form method="get" action="">
        	Producto: <input type="text" id="filter_def" name="filter_def" /> 
			Codigo de Barras: <input type="text" id="filter_def3" name="filter_def3" /> 
            <!--Boton para activar el inventario --->
            <input type="submit" value="Filtrar" />
            
		
        	<table cellpadding="10" cellspacing="0">
        		<thead>
                    <tr>
                      <th>Codigo de Barras</th>
                      <th>Producto</th>
                      <th>Cantidad Minima</th>
                      <th>Und.</th>
                      <th>Valor Base</th>
                      <th>% IVA</th>
                      <th>Valor Gravado</th>
                      <th>Select.</th>
                    </tr>
        		</thead>
        		<tbody>
				<?php
                //Consulta de todos los producto actualmente activo
                $sentencia_sql2=mysql_query("SELECT com_proveedorproductos.*,com_nombres.nombre,com_productos.codbarras,com_unidades.nombre as unidad 
FROM com_proveedorproductos
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id
LEFT JOIN com_proveedores ON com_direccionproveedor.proveedor_id=com_proveedores.Id
LEFT JOIN com_productos ON com_productos.Id=com_proveedorproductos.producto_id
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
LEFT JOIN com_tallas ON com_tallas.Id=com_productos.talla_id
LEFT JOIN com_tipoproducto ON com_tipoproducto.Id=com_productos.tipoproducto_id
LEFT JOIN com_nombres ON com_nombres.Id=com_productos.nombre
        WHERE com_direccionproveedor.Id='$proveedor' and com_productos.estado_id='1' $filtro",$conexion);
		

                while($registro=mysql_fetch_assoc($sentencia_sql2)){
                
                ?>
                <tr>
                      <td><?php echo $registro['codbarras']; ?></td>
                      <td><?php echo $registro['nombre']; ?></td>
                      <td><?php echo $registro['cantidadcompra']; ?></td>
                      <td><?php echo $registro['unidad']; ?></td>
                      <td><?php echo $registro['valorantesiva']; ?></td>
                      <td><?php echo $registro['porcentajeiva_id']; ?></td>
                      <td><?php echo $registro['valordespuesiva']; ?></td>
                      <td><input type="radio" name="datos1" value="<?php echo $registro['Id']; ?>-<?php echo $registro['codbarras']; ?>-<?php echo $registro['nombre']; ?>-<?php echo $registro['cantidadcompra']; ?>-<?php echo $registro['unidad']; ?>-<?php echo $registro['valorantesiva']; ?>-<?php echo $registro['porcentajeiva_id']; ?>-<?php echo $registro['valordespuesiva']; ?>" id="datos1" /></td>
                </tr>
                <?php
                }
                
                ?>
                </tbody>
                <tfoot>
        			<tr>
        				<td><input type="hidden" value="<?php echo $_GET['fila']; ?>" name="fila" id="filat" />
						<input type="hidden" value="<?php echo $_GET['prov']; ?>" name="prov" id="prov" /></td>
                        <td colspan="6" align="right"><input type="button" onClick="javascript: pasar();" value="Continuar" /></td>
            			<td><input type="button" onClick="javascript: cerrar();" value="Cancelar" /></td>
        			</tr>
			    </tfoot>
        	</table>
        </div>
        <!--Botones de envio -->
        <br/>
        <table align="right">
    	
      </table>
       </form> 
</div>        


</body>
</html>