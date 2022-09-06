<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	$com_pag=$_GET['com_pg'];
	$fecha=gmdate('Y-m-d');
	$np=0;
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	
	
	//Captura de Cambio de Estados -----------------------------//
	if(!empty($_GET['estado']) && !empty($_GET['id_ch'])){
		$nwestado=$_GET['estado'];
		$id_ch=$_GET['id_ch'];
		
		//Revisar estado actual de la Orden - Construir esto para validacion mas adelante
		$estadoactual=mysql_query("SELECT estado_id FROM com_ordencompra WHERE Id='$id_ch'",$conexion);
		$actualest=mysql_fetch_row($estadoactual);
		$deverificar=$actualest[0];
		
		if($deverificar=='5' && $nwestado<5){
			echo "<script lenguaje=\"JavaScript\">alert('La Orden actual se encuentra en estado Revisada debe pasar a Verificar antes de realizar otra accion');</script>";	
			$np=1;
		}else if($deverificar=='6' && $nwestado!=6){
			echo "<script lenguaje=\"JavaScript\">alert('La Orden actual se encuentra en estado Verificando finalice la Verificacion antes de realizar otra accion');</script>";	
			$np=1;
		}else if($deverificar=='7' && $nwestado!='8'){
			echo "<script lenguaje=\"JavaScript\">alert('La Orden actual se encuentra en estado Verificada debe pasar a Asignada en Bodega antes de realizar otra accion');</script>";	
			$np=1;
		}else if($deverificar=='8' && $nwestado!='9'){
			echo "<script lenguaje=\"JavaScript\">alert('La Orden actual se encuentra en estado Asignada en Bodega Finalice el proceso antes de realizar otra accion');</script>";	
			$np=1;
		}
		
		
		//Cambiando al nuevo estado
		if($np==0){
			
			
			if($nwestado=='6'){
			//AQUI VOY FALTA CREAR POPUP PARA VERIFICAR SEGUN REGISTROS	
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Verificar(".$id_ch.")',500);</script>"; 
				
			}else if($nwestado=='8'){
				echo "<script lenguaje=\"JavaScript\">setTimeout('AsignarBodega(".$id_ch.")',500);</script>";
				
			}else{
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
			
				$insertar=mysql_query("UPDATE com_ordencompra SET estado_id='$nwestado',fechagenerada='$fecha' WHERE Id='$id_ch'");
			
				if(!$insertar)
				$error=1;
			
				$insertar=mysql_query("UPDATE com_productosorden SET estado_id='$nwestado' WHERE orden_id='$id_ch'");
				if(!$insertar)
				$error=1;
			
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "<script lenguaje=\"JavaScript\">setTimeout('recargar(1)',1000);</script>";
				}else {
					mysql_query("COMMIT");
					echo "<script lenguaje=\"JavaScript\">setTimeout('recargar(2)',1000);</script>";
				}
				
			}
			
		}
		
		
		
		
	}
	
?>

<!--Listado de Productos en el sistema !-->
		
<h3> >> Listado Recepeciones - Orden de Compra </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>No Orden:</td>
                <td><input type="text" name="filtro" size="30" /></td>
                <td>&nbsp;</td>
                <td>Proveedor:</td>
                <td><input type="text" name="filtro2" size="30" /></td>
                <td>Fecha Recibido:</td>
                <td><input type="date" name="filtro3" size="30" /> <!--Boton de Filtrado --><input type="submit" value="Filtrar" /></td>
            </tr>
            <tr>
            	<td colspan="7">&nbsp;</td>
            </tr>
            <tr>
            	<td>Responsable:</td>
                <td>
                	 <select name="auxiliar">
							<?php
                                opciones($conexion,"com_usconect","Id","CONCAT_WS(' ',nombre,apellidos)","WHERE perfil_id='4' ")
                            ?>
                        </select>
                </td>
                <td>Estado:</td>
                <td> 
                <select name="auxiliar">
							<?php
                                opciones($conexion,"com_estadooc","Id","nombre"," WHERE Id>=5 ")
                            ?>
                </select></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="9" /> 
</form>


<!--Separador en CSS -->
<div style="clear:both">
	<?php include("funciones/menubodega.php"); ?>
</div>

<form action="com_pages/detalles.php" target="popup" onsubmit="window.open('', 'popup', 'width=1300, height=700')" name="form1">



<!--Barrande Botones ------------------------->


<!--Botones -------->
		<table align="right">
			<tr>
                <td><input type="submit" value="Ver Detalles" name="forma"/></td>
			</tr>
		</table>

		<br/>		
        <br/>
        <br/>


        
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		
		if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando==''){
			 	$filtrando.=" where com_ordencompra.noorden LIKE '%".$_GET['filtro']."%'";
				$tp_filtros="&filtro=".$_GET['filtro'];
        }else if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando!=''){
				$filtrando.=" and com_ordencompra.noorden LIKE '%".$_GET['filtro']."%'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando==''){
			 	$filtrando.=" where com_proveedores.nombre LIKE '%".$_GET['filtro']."%'";
				$tp_filtros="&filtro=".$_GET['filtro'];
        }else if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando!=''){
				$filtrando.=" and com_proveedores.nombre LIKE '%".$_GET['filtro']."%'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		
		if(!empty($_GET['filtro3']) && $_GET['filtro3']!='' && $filtrando==''){
			 	$filtrando.=" where com_ordencompra.fechasolicitud=".$_GET['filtro3']."";
				$tp_filtros.="&filtro3=".$_GET['filtro3'];
        }else if(!empty($_GET['filtro3']) && $_GET['filtro3']!='' && $filtrando!=''){
				$filtrando.=" and  com_ordencompra.fechasolicitud=".$_GET['filtro3']."";
				$tp_filtros.="&filtro3=".$_GET['filtro3'];
		}
		
		
		if($filtrando==''){
				$filtrando.=" where com_ordencompra.estado_id>='5'";
				$tp_filtros.="";
		}
?>
                
        
<!--Listado de todos los Productos !-->	
	<div class="datagrid">	
		<table cellspacing="0" width="1100px">
			<thead>
				<th>No. Orden</th>
				<th>Proveedor</th>
                <th>Dirección</th>
                <th>Fecha de Solicitud</th>
                <th>Fecha de Recibido</th>
                <th>Costo Total</th>
                <th>Estado</th>
                <th>Responsable</th>
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
				
				
				$sentencia_sql=mysql_query("SELECT com_ordencompra.*,
CONCAT_WS(' /',com_direccionproveedor.direccion,com_ciudad.ciudad) as direccion,
com_proveedores.nombre as proveedor, CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as responsable FROM com_ordencompra
LEFT JOIN com_direccionproveedor ON com_ordencompra.direccionproveedor_id=com_direccionproveedor.Id
LEFT JOIN com_proveedores ON com_direccionproveedor.proveedor_id=com_proveedores.Id
LEFT JOIN com_ciudad ON com_direccionproveedor.ciudad_id=com_ciudad.ciudad 
LEFT JOIN com_responsablebodega ON com_ordencompra.Id=com_responsablebodega.orden_id
LEFT JOIN com_usconect ON com_usconect.Id=com_responsablebodega.user_id  $filtrando",$conexion);
				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/10);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=10;									//Numero de resultados por Página
				
				$sentencia_sql2=mysql_query("SELECT com_ordencompra.*,
CONCAT_WS(' /',com_direccionproveedor.direccion,com_ciudad.ciudad) as direccion,
com_proveedores.nombre as proveedor,com_estadooc.nombre as estado, CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as responsable FROM com_ordencompra
LEFT JOIN com_direccionproveedor ON com_ordencompra.direccionproveedor_id=com_direccionproveedor.Id
LEFT JOIN com_proveedores ON com_direccionproveedor.proveedor_id=com_proveedores.Id
LEFT JOIN com_ciudad ON com_direccionproveedor.ciudad_id=com_ciudad.ciudad 
LEFT JOIN com_estadooc ON com_ordencompra.estado_id=com_estadooc.Id
LEFT JOIN com_responsablebodega ON com_ordencompra.Id=com_responsablebodega.orden_id
LEFT JOIN com_usconect ON com_usconect.Id=com_responsablebodega.user_id $filtrando LIMIT $n,$m",$conexion);


				$class="alt";
					while($registro=mysql_fetch_assoc($sentencia_sql2)){
						if($class==""){
							$class="alt";	
						}else{
							$class="";	
						}
			?>
					<tr class="<?php echo $class; ?>" >
					    <td><?php echo $registro['noorden']; ?></td>
                        <td><?php echo $registro['proveedor']; ?></td>
                        <td><?php echo $registro['direccion']; ?></td>
                        <td><?php echo $registro['fechasolicitud']; ?></td>
                        <td><?php echo $registro['fecharecibido']; ?></td>
                        <td><?php echo $registro['totalconiva']; ?></td>
                        <td><?php echo $registro['estado']; ?></td>
                        <td><?php echo $registro['responsable']; ?></td>
						<td><input type="radio" name="Id" value="<?php echo $registro['Id']; ?>" id="Id"/></td>	
					</tr>
					<?php
					}
					?>
                    
         </tbody>           
		  <tfoot>
			<tr>
             	<td colspan="9" align="right">
				<?php
					for($u=1;$u<=($tpag);$u++)
					{
						echo "<a href='?com_pg=9&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td> 
			</tr>
		</tfoot>
       </table>
      </div>  
</form>
