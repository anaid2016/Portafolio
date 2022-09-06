<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	
?>

<!--Listado de Productos en el sistema !-->
		
<h3> >> Proveedores </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>Fecha Realizado:</td>
                <td><input type="date" name="filtro" size="30" />
                <input type="submit" value="Ver Inventario" /></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="11" /> 
</form>

<!--Separador en CSS -->
<div style="clear:both">&nbsp;</div>
<table>
	<tr>
    	<td bgcolor="#FFFF00">&nbsp;</td>
        <td>No Encontrado</td>
    </tr>
    <tr>
        <td bgcolor="#DC3886">&nbsp;</td>
        <td>No Pertenece a la Cajonera</td>
    </tr>
</table>

<!--Barrande Botones ------------------------->

<form action="redirinventario.php" target="popup" onsubmit="window.open('', 'popup', 'width=800, height=360')">
<!--Botones -------->
		<!--<table align="right">
			<tr>
				<td><input type="submit" value="Modificar" name="forma"/></td>
         		<td><input type="submit" value="Eliminar" name="forma"/></td>
			</tr>
		</table>-->
<div style="clear:both">&nbsp;</div>

        
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		
		
		if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando==''){
			 	$filtrando.=" where fecha2='".$_GET['filtro']."'";
				$tp_filtros="&filtro=".$_GET['filtro'];
				
		if(empty($_GET["p_actual"]))
		{
			$n=0;
		}
		else
		{
			$p_actual=$_GET["p_actual"];
			$n=(($p_actual*3)-3);
		}
				
		//Consultando por tarea ----------------------------------------
	
		$consulta=mysql_query("SELECT com_lineatarea.*,tareainventario.cajonera_id FROM com_lineatarea
LEFT JOIN tareainventario ON tareainventario.Id=com_lineatarea.tareainventario_id $filtrando",$conexion);		

				
		$total=mysql_num_rows($consulta);
		$tpag=($total/3);						//Numero de Páginas a obtener
		$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
		$m=3;									//Numero de resultados por Página
		$class="alt";				
		
		$consulta2=mysql_query("SELECT com_lineatarea.*,tareainventario.cajonera_id,com_arraybodega.nombre FROM com_lineatarea
LEFT JOIN tareainventario ON tareainventario.Id=com_lineatarea.tareainventario_id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=tareainventario.cajonera_id $filtrando LIMIT $n,$m",$conexion);	

	?>	
		
        <div class="datagrid">
        <table cellspacing="0" width="1100px">
    <?php    	
		while($r_tarea=mysql_fetch_assoc($consulta2)){
			$estados=$r_tarea["estado"];
			$idiventario=$r_tarea["inventario_id"];
			$cajonera=$r_tarea["nombre"];
			$idcajonera=$r_tarea["cajonera_id"];
	?>
    		<thead>
            	<th colspan="4"><?php echo $r_tarea["nombre"]; ?></td>
            </thead>
            <tr>
            	<td class="other">RFID</td>
                <td class="other">Cantidad</td>
                <td class="other">Cajonera BD</td>
                <td class="other">Cajonera Leida</td>
            </tr>
           
	<?php		
		//Segunda Busqueda ..--- Verificacion de que los productos encontrados estan -----
		$consulta3=mysql_query("SELECT GROUP_CONCAT(com_inventario.RFID) as RFID,GROUP_CONCAT(com_inventario.cantidad) as cantidad,
GROUP_CONCAT(com_arraybodega.nombre) as bodega,'".$estados."' as estados FROM com_inventario
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
WHERE com_inventario.Id in  (".$idiventario.") and com_inventario.estado in ('2','4')" ,$conexion);
		
		$r_encontrados=mysql_fetch_row($consulta3);
		
		//Vectores para nuevas filas //
		$v_rfid=explode(",",$r_encontrados[0]);
		$v_cantidad=explode(",",$r_encontrados[1]);
		$v_bodega=explode(",",$r_encontrados[2]);
		$v_estados=explode(",",$r_encontrados[3]);
		
		for($i=0;$i<count($v_rfid);$i++){
			if($class==""){
				$class="alt";	
			}else{
				$class="";	
			}
		?>	
			<tr class="<?php echo ($v_estados[$i]=='1')? $class:'alt2'; ?>">
			 	<td><?php echo $v_rfid[$i]; ?></td>
                <td><?php echo $v_cantidad[$i]; ?></td>
                <td><?php echo $v_bodega[$i]; ?></td>
                <td><?php echo $cajonera; ?></td>
			</tr>	
		<?php	
		}
		
		//Tercera Consulta --- No encontrados en la Cajonera
		
		$consulta4=mysql_query("SELECT GROUP_CONCAT(com_inventario.RFID) as RFID,GROUP_CONCAT(com_inventario.cantidad) as cantidad,
GROUP_CONCAT(com_arraybodega.nombre) as bodega FROM com_inventario
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
WHERE com_inventario.Id not in  (".$idiventario.") and com_inventario.arraybodega_id='$idcajonera' and com_inventario.estado in ('2','4') ",$conexion);


		$r_encontrados2=mysql_fetch_row($consulta4);
		
		//Vectores para nuevas filas //
		$v_rfid2=explode(",",$r_encontrados2[0]);
		$v_cantidad2=explode(",",$r_encontrados2[1]);
		$v_bodega2=explode(",",$r_encontrados2[2]);
		
		if($r_encontrados2[0]!=''){
			for($i=0;$i<count($v_rfid2);$i++){
			?>	
				<tr class="alt3">
					<td><?php echo $v_rfid2[$i]; ?></td>
					<td><?php echo $v_cantidad2[$i]; ?></td>
					<td><?php echo $v_bodega2[$i]; ?></td>
					<td><?php echo $cajonera; ?></td>
				</tr>	
			<?php	
			}
		
		
			?>	
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
		        
     <?php
		}
	}
		
	
		
	?>
 		<tfoot>
			<tr>
              <td colspan="6" align="right">
				<?php
					for($u=1;$u<=($tpag);$u++)
					{
						echo "<a href='?com_pg=11&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td>
			</tr>
		</tfoot>
      </table>  
 </div>
 
</form>

<?php
		}
?>