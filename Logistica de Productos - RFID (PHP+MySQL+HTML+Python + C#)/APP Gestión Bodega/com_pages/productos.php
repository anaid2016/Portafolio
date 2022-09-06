<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	$link="1";
	$usuario=$_SESSION['iduser'];
	$sil_this="?com_pg=".$link;
	
	
?>

<!--Listado de Productos en el sistema !-->
		
<h3> >> Productos </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>Nombre:</td>
                <td><input type="text" name="filtro" size="30" value="<?php echo (!empty($_GET['filtro']))? $_GET['filtro']:''; ?>" /></td>
                <td>&nbsp;</td>
                <td>Cod. Barras:</td>
                <td><input type="text" name="filtro2" size="30" value="<?php echo  (!empty($_GET['filtro2']))? $_GET['filtro2']:''; ?>" /></td> 
                <td colspan="2"><input type="submit" value="Filtrar" /></td>
            </tr>
            <tr>
            	<td>Proveedor:</td>
                <td><input type="text" name="filtro3" size="30" value="<?php echo (!empty($_GET['filtro3']))? $_GET['filtro3']:''; ?>"/></td>
                <td>&nbsp;</td>
                <td>Linea de Producto:</td>
                <td><input type="text" name="filtro4" size="20" value="<?php echo (!empty($_GET['filtro4']))? $_GET['filtro4']:''; ?>" /></td>
                <td>Estado:</td>
                <td>
                	<select name="filtro5">
                    	<option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="1" /> 
</form>


<!--Barrande Botones ------------------------->
 <form method="POST" id="formulario" name="formulario">
 	
   <div id="barra">	
		 <?php 
		  GRAPH002($link,$usuario,$sil_this,"search_form",'com_pages/agproductos.php','com_pages/agproductos.php','com_pages/delproducto.php','com_pages/asocproveedor.php','','400','1000','2::1::1::1::1::2'); 
		 ?>	
	 </div>	
     
 	<!--Separador en CSS -->
	<div style="clear:both">&nbsp;</div> 
        
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		if(!empty($_GET['filtro3']) && $_GET['filtro3']!='' && $filtrando==''){
			 	$filtrando="LEFT JOIN com_proveedorproductos ON producto_id=com_productos.Id 
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id
LEFT JOIN com_proveedores ON com_proveedores.Id=com_direccionproveedor.proveedor_id 
WHERE com_proveedores.nombre LIKE '%".$_GET['filtro3']."%'";
				$tp_filtros.="&filtro3=".$_GET['filtro3'];
        }
		
		
		if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando==''){
			 	$filtrando.=" where com_nombres.nombre LIKE '%".$_GET['filtro']."%'";
				$tp_filtros="&filtro=".$_GET['filtro'];
        }else if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando!=''){
				$filtrando.=" and com_nombres.nombre LIKE '%".$_GET['filtro']."%'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		//echo $filtrando.",".$_GET['filtro2'];
		if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando==''){
			 	$filtrando.=" where com_productos.codbarras LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
        }else if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando!=''){
				$filtrando.=" and com_productos.codbarras LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
		}
		
		
		//Filtro de Linea Producto
		if(!empty($_GET['filtro4']) && $_GET['filtro4']!='' && $filtrando==''){
			 	$filtrando.=" where com_lineaproducto.nombre LIKE '%".$_GET['filtro4']."%'";
				$tp_filtros.="&filtro4=".$_GET['filtro4'];
        }else if(!empty($_GET['filtro4']) && $_GET['filtro4']!='' && $filtrando!=''){
				$filtrando.=" and com_lineaproducto.nombre LIKE '%".$_GET['filtro4']."%'";
				$tp_filtros.="&filtro4=".$_GET['filtro4'];
		}
		
		
		//Filtro Estado
		if(!empty($_GET['filtro5']) && $_GET['filtro5']!='' && $filtrando==''){
			 	$filtrando.=" where com_productos.estado_id='".$_GET['filtro5']."'";
				$tp_filtros.="&filtro5=".$_GET['filtro5'];
        }else if(!empty($_GET['filtro5']) && $_GET['filtro5']!='' && $filtrando!=''){
				$filtrando.=" and com_productos.estado_id='".$_GET['filtro5']."'";
				$tp_filtros.="&filtro5=".$_GET['filtro5'];
		}
		
?>
                
        
<!--Listado de todos los Productos !-->		
  <div class="datagrid">	
		<table cellspacing="0" width="1100px">
			<thead>
            	<th>Linea de Productos</th>
				<th>Tipo</th>
                <th>Nombre</th>
				<th>Color</th>
                <th>Talla</th>
                <th>Cod. Barras</th>
                <th>Precio Venta</th>
                <th>Precio Compra</th>
                <th>Fecha Creación</th>
                <th>Fecha de Alta</th>
                <th>Estado</th>
				<th>Sel.</th>
			</thead>
			<tbody>
			<?php
				if(empty($_GET["p_actual"]))
				{
					$n=0;
				}
				else
				{
					$p_actual=$_GET["p_actual"];
					$n=(($p_actual*10)-10);
				}
				
				
				$sentencia_sql=mysql_query("SELECT com_productos.*,com_lineaproducto.nombre as linea,com_tipoproducto.nombre as 	
tipo,com_nombres.nombre as nomproducto,com_tallas.talla,com_color.nombre as color,
com_preciosclientes.preciosantesiva FROM com_productos LEFT JOIN com_lineaproducto ON com_lineaproducto.Id=com_productos.lineaproducto_id 
LEFT JOIN com_tipoproducto ON com_tipoproducto.Id=com_productos.tipoproducto_id
LEFT JOIN com_nombres ON com_nombres.Id=com_productos.nombre
LEFT JOIN com_tallas ON com_tallas.Id=com_productos.talla_id
LEFT JOIN com_color ON com_color.Id=com_productos.color_id
LEFT JOIN com_preciosclientes ON com_preciosclientes.producto_id=com_productos.Id $filtrando",$conexion);
				
				
				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/10);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=10;									//Numero de resultados por Página
			
				
				$sentencia_sql2=mysql_query("SELECT com_productos.*,com_lineaproducto.nombre as linea,com_tipoproducto.nombre as 	
tipo,com_nombres.nombre as nomproducto,com_tallas.talla,com_color.nombre as color,
com_preciosclientes.preciosantesiva,precio_compra FROM com_productos LEFT JOIN com_lineaproducto ON com_lineaproducto.Id=com_productos.lineaproducto_id 
LEFT JOIN com_tipoproducto ON com_tipoproducto.Id=com_productos.tipoproducto_id
LEFT JOIN com_nombres ON com_nombres.Id=com_productos.nombre
LEFT JOIN com_tallas ON com_tallas.Id=com_productos.talla_id
LEFT JOIN com_color ON com_color.Id=com_productos.color_id
LEFT JOIN com_preciosclientes ON com_preciosclientes.producto_id=com_productos.Id $filtrando LIMIT $n,$m",$conexion);
				
				$class="alt";
				while($registro=mysql_fetch_assoc($sentencia_sql2)){
					if($class==""){
						$class="alt";	
					}else{
						$class="";	
					}
			?>
					<tr class="<?php echo $class; ?>">
                    	<td height='30px'><?php echo $registro['linea']; ?></td>
                        <td height='30px'><?php echo $registro['tipo']; ?></td>
					    <td height='30px'><?php echo $registro['nomproducto']; ?></td>
                        <td height='30px'><?php echo $registro['color']; ?></td>
                        <td height='30px'><?php echo $registro['talla']; ?></td>
                        <td height='30px'><?php echo $registro['codbarras']; ?></td>
                        <td height='30px'><?php echo $registro['preciosantesiva']; ?></td>
                         <td height='30px'><?php echo $registro['precio_compra']; ?></td>
                          
                        <td height='30px'><?php echo $registro['fechacreacion']; ?></td>
                        <td height='30px'><?php echo $registro['fechaeliminacion']; ?></td>
                        
                        
                        <td height="30px">
                        		<?php
									if($registro['estado_id']==1){
										echo "<img src='images/check2.png' title='Activo' width='20px' align='center' border='0'/>";
									}else{
										echo "<img src='images/cross.png' title='Inactivo' width='20px' align='center' border='0'/>";
									}
								
								?>
                        </td>
						<td><input type="radio" name="Id" value="<?php echo $registro['Id']; ?>" id="Id"/></td>	
					</tr>
					<?php
					}
					?>
			 </tbody>	
			<tfoot>
                <tr>
                  <td colspan="12" align="right">
                    <?php
                        for($u=1;$u<=($tpag);$u++)
                        {
                            echo "<a href='?com_pg=1&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
                        }
                    ?>
                   </td> 
                </tr>
			</tfoot>
          </table>
     </div>
</form>
