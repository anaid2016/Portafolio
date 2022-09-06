<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	
?>

<!--Listado de Productos en el sistema !-->
		
<h3> >> Tareas de Inventario </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>Auxiliar:</td>
                <td><input type="text" name="filtro" size="30" /></td>
                <td>&nbsp;</td>
                <td>Estado:</td>
                <td><select name="filtro2">
                		<option value="1">Pendientes</option>
                        <option value="2">Realizadas</option>
                    </select>
                  <!--Boton de Filtrado --><input type="submit" value="Filtrar" /></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="10" /> 
</form>

<!--Separador en CSS -->
<div style="clear:both">&nbsp;</div>


<!--Barrande Botones ------------------------->

<form action="com_pages/redirtarea.php" target="popup" onsubmit="window.open('', 'popup', 'width=900, height=360')">
<!--Botones -------->
		<table align="right">
			<tr>
				<td><input type="button" value="Nuevo" onclick="window.open('com_pages/agtarea.php','nuevaVentana','width=900, height=360')" /></td>
				<!--<td><input type="submit" value="Modificar" name="forma"/></td>-->
         		<td><input type="submit" value="Eliminar" name="forma"/></td>
			</tr>
		</table>

		<br/>		
        <br/>
        <br/>


        
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		
		
		if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando==''){
			 	$filtrando.=" where com_usconect.nombre LIKE '%".$_GET['filtro']."%'";
				$tp_filtros="&filtro=".$_GET['filtro'];
        }else if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando!=''){
				$filtrando.=" and com_usconect.nombre LIKE '%".$_GET['filtro']."%'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		
		if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando==''){
			 	$filtrando.=" where tareainventario.estado='".$_GET['filtro2']."'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
        }else if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando!=''){
				$filtrando.=" and tareainventario.estado LIKE '".$_GET['filtro2']."'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
		}
		
		
?>
                
        
<!--Listado de todos los Productos !-->		
<div class="datagrid">	
		<table cellspacing="0" width="1100px">
			<thead>
				<th>Id</th>
				<th>Responsable</th>
                <th>Cajonera</th>
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
				
				
				$sentencia_sql=mysql_query("SELECT tareainventario.*,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as responsable,
com_arraybodega.nombre FROM tareainventario
LEFT JOIN com_usconect ON com_usconect.Id=tareainventario.auxiliar_id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=tareainventario.cajonera_id $filtrando",$conexion);
				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/10);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=10;									//Numero de resultados por Página
				$class="alt";
				
				$sentencia_sql2=mysql_query("SELECT tareainventario.*,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as responsable,
com_arraybodega.nombre FROM tareainventario
LEFT JOIN com_usconect ON com_usconect.Id=tareainventario.auxiliar_id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=tareainventario.cajonera_id $filtrando LIMIT $n,$m",$conexion);
					while($registro=mysql_fetch_assoc($sentencia_sql2)){
						if($class==""){
							$class="alt";	
						}else{
							$class="";	
						}
			?>
					<tr class="<?php echo $class; ?>">
					    <td height='30px'><?php echo $registro['Id']; ?></td>
                        <td height='30px'><?php echo $registro['responsable']; ?></td>
                        <td height='30px'><?php echo $registro['nombre']; ?></td>
                        <td height='30px'><?php echo ($registro['estado']=='1')? 'Pendiente':'Realizada'; ?></td>
                     	<td><input type="radio" name="Id" value="<?php echo $registro['Id']; ?>" id="codproyecto"/></td>	
					</tr>
					<?php
					}
					?>
        </tbody>            
		<tfoot>
			<tr>
              <td colspan="6" align="right">
				<?php
					for($u=1;$u<=($tpag);$u++)
					{
						echo "<a href='?com_pg=10&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td>
			</tr>
		</tfoot>
      </table>  
 </div>
</form>

