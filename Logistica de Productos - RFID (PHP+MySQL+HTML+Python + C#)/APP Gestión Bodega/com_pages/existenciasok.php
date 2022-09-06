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
		
<h3> >> Existencias </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>Cod Barras:</td>
                <td><input type="text" name="filtro" size="30" /></td>
                <td>&nbsp;</td>
                <td>Cant menor a (Rollos/Cajas):</td>
                <td><input type="text" name="filtro2" size="30" /><input type="submit" value="Filtrar" /></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="3" /> 
</form>


<form action="com_pages/detalles.php" target="popup" onsubmit="window.open('', 'popup', 'width=1300, height=700')" name="form1">



<!--Barrande Botones ------------------------->


<!--Botones -------->
		<table align="right">
			<tr>
               <!-- <td><input type="submit" value="Ver Detalles" name="forma"/></td>-->
			</tr>
		</table>

		<br/>		
        <br/>
        <br/>


        
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		
		if(!empty($_GET['filtro']) && $_GET['filtro']!=''){
				$filtrando.=" and com_productos.codbarras LIKE '%".$_GET['filtro']."%'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		if(!empty($_GET['filtro2']) && $_GET['filtro2']!=''){
				$filtroint=$_GET['filtro2'];
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
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
                <th>Cant. Rollos/Cajas</th>
                <th>Existencias</th>
                <th>Und.</th>
               
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
					$n=(($p_actual*10)-10);
				}
				
				
				$sentencia_sql=mysql_query("SELECT sum(cantidad) as total,com_nombres.nombre as producto,
com_productos.codbarras,COUNT(com_inventario.Id) as cantxmayor, 
com_unidades.nombre FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id 
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
LEFT JOIN com_nombres ON com_nombres.Id=com_productos.nombre
WHERE estado in ('2','4') $filtrando GROUP BY producto_id ",$conexion);

				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/10);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=10;									//Numero de resultados por Página
				
				$sentencia_sql2=mysql_query("SELECT sum(cantidad) as total,com_nombres.nombre as producto,
com_productos.codbarras,COUNT(com_inventario.Id) as cantxmayor, 
com_unidades.nombre FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id 
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
LEFT JOIN com_nombres ON com_nombres.Id=com_productos.nombre
WHERE estado in ('2','4') $filtrando GROUP BY producto_id  LIMIT $n,$m",$conexion);


				$class="alt";
			while($registro=mysql_fetch_assoc($sentencia_sql2)){
						if($class==""){
							$class="alt";	
						}else{
							$class="";	
						}
						
				if(!empty($filtroint) and $filtroint>=$registro['cantxmayor']){								
			?>
            	
					<tr class="<?php echo $class; ?>" >
					    <td><?php echo $registro['codbarras']; ?></td>
                        <td><?php echo $registro['producto']; ?></td>
                        <td><?php echo $registro['cantxmayor']; ?></td>
                        <td><?php echo $registro['total']; ?></td>
                        <td><?php echo $registro['nombre']; ?></td>
                    </tr>
					<?php
				}else if(empty($filtroint)){
			?>	
					<tr class="<?php echo $class; ?>" >
					    <td><?php echo $registro['codbarras']; ?></td>
                        <td><?php echo $registro['producto']; ?></td>
                        <td><?php echo $registro['cantxmayor']; ?></td>
                        <td><?php echo $registro['total']; ?></td>
                        <td><?php echo $registro['nombre']; ?></td>
                    </tr>
			<?php		
				}
			}
					?>
                    
         </tbody>           
		  <tfoot>
			<tr>
             	<td colspan="9" align="right">
				<?php
					for($u=1;$u<=($tpag);$u++)
					{
						echo "<a href='?com_pg=3&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td> 
			</tr>
		</tfoot>
       </table>
      </div>  
</form>
