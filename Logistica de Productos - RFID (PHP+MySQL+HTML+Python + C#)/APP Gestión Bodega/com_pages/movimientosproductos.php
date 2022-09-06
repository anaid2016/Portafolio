<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	$com_pag=$_GET['com_pg'];
	$fecha=gmdate('Y-m-d');
	$np=0;
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	
?>

<!--Listado de Productos en el sistema !-->
		
<h3> >> Movimientos Productos </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>Cod. Barras:</td>
                <td><input type="text" name="filtro" size="20" /></td>
                <td>&nbsp;</td>
                <td>Documento:</td>
                <td><input type="text" name="filtro2" size="30" /></td>
                <td>Fecha:</td>
                <td><input type="date" name="filtro3" size="30" /> 
                <td>Tipo de Movimiento:</td>
                <td><select name="filtro4">	
                		<option></option>
                		<option value="1">Entradas</option>
                    	<option value="2">Salidas</option>
                    </select>
                </td>
				<td>RFID::</td>
				<td><input type="text" name="filtro5" size="10" /></td>
                <!--Boton de Filtrado --><td><input type="submit" value="Filtrar" /></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="2" /> 
</form>

<!--Separador en CSS -->
<div style="clear:both">&nbsp;</div>

<form action="com_pages/detalles.php" target="popup" onsubmit="window.open('', 'popup', 'width=1300, height=700')" name="form1">



       
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		
		if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando==''){
			 	$filtrando.=" where com_productos.codbarras LIKE '%".$_GET['filtro']."%'";
				$tp_filtros="&filtro=".$_GET['filtro'];
        }else if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando!=''){
				$filtrando.=" and com_productos.codbarras LIKE '%".$_GET['filtro']."%'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando==''){
			
			if(substr($_GET['filtro2'],0,2)=="OC"){
			 	$filtrando.=" where com_ordencompra.noorden LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros="&filtro2=".$_GET['filtro2'];
			}else if(substr($_GET['filtro2'],0,3)=="PED"){
				$filtrando.=" where com_pedidos.nopedido LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros="&filtro2=".$_GET['filtro2'];
			}
        }else if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando!=''){
			if(substr($_GET['filtro2'],0,2)=="OC"){
				$filtrando.=" and com_ordencompra.noorden LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
			}else if(substr($_GET['filtro2'],0,3)=="PED"){
				$filtrando.=" and com_pedidos.nopedido LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
			}
		}
		
		
		if(!empty($_GET['filtro3']) && $_GET['filtro3']!='' && $filtrando==''){
			 	$filtrando.=" where com_movimientosproductos.fechamovimiento='".$_GET['filtro3']."'";
				$tp_filtros.="&filtro3=".$_GET['filtro3'];
        }else if(!empty($_GET['filtro3']) && $_GET['filtro3']!='' && $filtrando!=''){
				$filtrando.=" and  com_movimientosproductos.fechamovimiento='".$_GET['filtro3']."'";
				$tp_filtros.="&filtro3=".$_GET['filtro3'];
		}
		
		if(!empty($_GET['filtro4']) && $_GET['filtro4']!='' && $filtrando==''){
				if($_GET['filtro4']=='1'){
					$filtrando.=" where com_movimientosproductos.cantsalida is NULL";
				}else{
					$filtrando.=" where com_movimientosproductos.cantentrada is NULL";
				}
				$tp_filtros.="&filtro4=".$_GET['filtro4'];
        }else if(!empty($_GET['filtro4']) && $_GET['filtro4']!='' && $filtrando!=''){
				if($_GET['filtro4']=='1'){
					$filtrando.=" and com_movimientosproductos.cantsalida is NULL";
				}else{
					$filtrando.=" and com_movimientosproductos.cantentrada is NULL";
				}			
				$tp_filtros.="&filtro4=".$_GET['filtro4'];
		}
	
		if(!empty($_GET['filtro5']) && $_GET['filtro5']!='' && $filtrando==''){
			 	$filtrando.=" where com_inventario.RFID='".$_GET['filtro5']."'";
				$tp_filtros.="&filtro5=".$_GET['filtro5'];
        }else if(!empty($_GET['filtro5']) && $_GET['filtro5']!='' && $filtrando!=''){
				$filtrando.=" and  com_inventario.RFID='".$_GET['filtro5']."'";
				$tp_filtros.="&filtro5=".$_GET['filtro5'];
		}
		
		if($filtrando==''){
				$tp_filtros.="";
		}
?>
                
        
<!--Listado de todos los Productos !-->	
	<div class="datagrid">	
		<table cellspacing="0" width="1100px">
			<thead>
				<th>Codigo de Barras</th>
				<th>Producto</th>
                <th>RFID</th>
				<th>Cajonera</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Und</th>
                <th>Fecha</th>
                <th>Documento Asociado</th>
                <th>Ingreso</th>
				<!--<th>Sel.</th>-->
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
					$n=(($p_actual*40)-40);
				}
				
				
				$sentencia_sql=mysql_query("SELECT com_productos.codbarras,com_inventario.RFID,com_movimientosproductos.*,com_productos.nombre,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as usuario,com_unidades.nombre as unidad,
com_ordencompra.noorden as orden,com_pedidos.nopedido,com_arraybodega.nombre as ubicacion
FROM com_movimientosproductos
LEFT JOIN com_inventario ON com_inventario.Id=com_movimientosproductos.inventario_id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
LEFT JOIN com_productosorden ON com_productosorden.Id=com_movimientosproductos.lineaorden_id
LEFT JOIN com_productospedido ON com_productospedido.Id=com_movimientosproductos.lineapedido_id
LEFT JOIN com_ordencompra ON com_productosorden.orden_id=com_ordencompra.Id
LEFT JOIN com_pedidos ON com_pedidos.Id=com_productospedido.pedido_id
LEFT JOIN com_usconect ON com_usconect.Id=com_movimientosproductos.usuario_id $filtrando",$conexion);

				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/40);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=40;									//Numero de resultados por Página
				
				$sentencia_sql2=mysql_query("SELECT com_productos.codbarras,com_inventario.RFID,com_movimientosproductos.*,com_productos.nombre,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as usuario,com_unidades.nombre as unidad,
com_ordencompra.noorden as orden,com_pedidos.nopedido as pedido,com_arraybodega.nombre as ubicacion
FROM com_movimientosproductos
LEFT JOIN com_inventario ON com_inventario.Id=com_movimientosproductos.inventario_id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
LEFT JOIN com_productosorden ON com_productosorden.Id=com_movimientosproductos.lineaorden_id
LEFT JOIN com_productospedido ON com_productospedido.Id=com_movimientosproductos.lineapedido_id
LEFT JOIN com_ordencompra ON com_productosorden.orden_id=com_ordencompra.Id
LEFT JOIN com_pedidos ON com_pedidos.Id=com_productospedido.pedido_id
LEFT JOIN com_usconect ON com_usconect.Id=com_movimientosproductos.usuario_id $filtrando LIMIT $n,$m",$conexion);

				$class="alt";
					while($registro=mysql_fetch_assoc($sentencia_sql2)){
						if($class==""){
							$class="alt";	
						}else{
							$class="";	
						}
						
						
						//Revisando que documento esta asociado al Movimiento de Producto
						if($registro['orden']!=''){
							$documento=$registro['orden'];
						}else{
							$documento=$registro['pedido'];
						}
						
			?>
					<tr class="<?php echo $class; ?>" >
					    <td><?php echo $registro['codbarras']; ?></td>
                        <td><?php echo $registro['nombre']; ?></td>
                        <td><?php echo $registro['RFID']; ?></td>
						 <td><?php echo $registro['ubicacion']; ?></td>
                        <td><?php echo $registro['cantentrada']; ?></td>
                        <td><?php echo $registro['cantsalida']; ?></td>
                        <td><?php echo $registro['unidad']; ?></td>
                        <td><?php echo $registro['fechamovimiento']; ?></td>
                        <td><?php echo $documento; ?></td>
                        <td><?php echo $registro['usuario']; ?></td>
						<!--<td><input type="radio" name="Id" value="<?php echo $registro['Id']; ?>" id="codproyecto"/></td>	-->
					</tr>
					<?php
					}
					?>
                    
         </tbody>           
		  <tfoot>
			<tr>
             	<td colspan="10" align="right">
				<?php
					for($u=1;$u<=($tpag);$u++)
					{
						echo "<a href='?com_pg=2&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td> 
			</tr>
		</tfoot>
       </table>
      </div>  
</form>
