<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	
?>

<!--Listado de Productos en el sistema !-->
		
<h3> >> Cajoneras </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>Nombre:</td>
                <td><input type="text" name="filtro" size="30" /></td>
                <td>&nbsp;</td>
                <td>Nivel:</td>
                <td><input type="text" name="filtro2" size="30" /></td>
                <td><!--Boton de Filtrado --><input type="submit" value="Filtrar" /></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="12" /> 
</form>

<!--Separador en CSS -->
<div style="clear:both">&nbsp;</div>


<!--Barrande Botones ------------------------->

<form action="com_pages/redircajonera.php" target="popup" onsubmit="window.open('', 'popup', 'width=600, height=400')">
<!--Botones -------->
		<table align="right">
			<tr>
				<td><input type="button" value="Nuevo" onclick="window.open('com_pages/agcajonera.php','nuevaVentana','width=600, height=400')" /></td>
				<td><input type="submit" value="Modificar" name="forma"/></td>
         		<td><input type="submit" value="Eliminar" name="forma"/></td>
			</tr>
		</table>

		<br/>		
        <br/>
        <br/>


        
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		
		
		if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando==''){
			 	$filtrando.=" where com_arraybodega.estante='".$_GET['filtro']."'";
				$tp_filtros="&filtro=".$_GET['filtro'];
        }else if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando!=''){
				$filtrando.=" and com_arraybodega.estante='".$_GET['filtro']."'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		
		if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando==''){
			 	$filtrando.=" where com_arraybodega.nombre='".$_GET['filtro2']."'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
        }else if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando!=''){
				$filtrando.=" and com_arraybodega.nombre LIKE '".$_GET['filtro2']."'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
		}
		
		
?>
                
        
<!--Listado de todos los Productos !-->		
<div class="datagrid">	
		<table cellspacing="0" width="1100px">
			<thead>
				<th>Id</th>
				<th>Area Almacenamiento</th>
                <th>Nombre</th>
                <th>Estante</th>
                <th>Nivel</th>
                <th>Linea Producto</th>
                <th>Talla</th>
                <th>Capacidad</th>
                <th>Contenido</th>
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
					$n=(($p_actual*30)-30);
				}
				
				
				$sentencia_sql=mysql_query("SELECT com_arraybodega.*,com_areas_almacenamiento.nombre as area,com_lineaproducto.nombre as linea,com_tallas.talla as talla,ocupado FROM com_arraybodega 
LEFT JOIN(
 select count(Id) as ocupado,arraybodega_id from com_inventario WHERE fechasalida is null GROUP BY arraybodega_id
) AS invt2 ON invt2.arraybodega_id=com_arraybodega.Id
LEFT JOIN com_areas_almacenamiento ON com_areas_almacenamiento.Id=com_arraybodega.areas_almacenamiento_id
LEFT JOIN com_lineaproducto ON com_lineaproducto.Id=com_arraybodega.categoria_id 
LEFT JOIN com_tallas ON com_tallas.Id=com_arraybodega.talla_id $filtrando",$conexion);
				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/30);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=30;									//Numero de resultados por Página
				$class="alt";
				
				$sentencia_sql2=mysql_query("SELECT com_arraybodega.*,com_areas_almacenamiento.nombre as area,com_lineaproducto.nombre as linea,com_tallas.talla as talla,ocupado FROM com_arraybodega 
LEFT JOIN(
 select count(Id) as ocupado,arraybodega_id from com_inventario WHERE fechasalida is null GROUP BY arraybodega_id
) AS invt2 ON invt2.arraybodega_id=com_arraybodega.Id
LEFT JOIN com_areas_almacenamiento ON com_areas_almacenamiento.Id=com_arraybodega.areas_almacenamiento_id
LEFT JOIN com_lineaproducto ON com_lineaproducto.Id=com_arraybodega.categoria_id 
LEFT JOIN com_tallas ON com_tallas.Id=com_arraybodega.talla_id $filtrando LIMIT $n,$m",$conexion);
					while($registro=mysql_fetch_assoc($sentencia_sql2)){
						if($class==""){
							$class="alt";	
						}else{
							$class="";	
						}
			?>
					<tr class="<?php echo $class; ?>">
					    <td height='30px'><?php echo $registro['Id']; ?></td>
                        <td height='30px'><?php echo $registro['area']; ?></td>
                        <td height='30px'><?php echo $registro['nombre']; ?></td>
                        <td height='30px'><?php echo $registro['estante']; ?></td>
                        <td height='30px'><?php echo $registro['nivel']; ?></td>
                        <td height='30px'><?php echo $registro['linea']; ?></td>
                        <td height='30px'><?php echo $registro['talla']; ?></td>
                        <td height='30px'><?php echo $registro['capacidad']; ?></td>
                        <td height='30px'><?php echo $registro['ocupado']; ?></td>
                     	<td><input type="radio" name="Id" value="<?php echo $registro['Id']; ?>" id="codproyecto"/></td>	
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
						echo "<a href='?com_pg=12&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td>
			</tr>
		</tfoot>
      </table>  
 </div>
</form>

