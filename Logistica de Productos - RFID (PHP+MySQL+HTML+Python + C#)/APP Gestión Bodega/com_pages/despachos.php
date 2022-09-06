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
		$estadoactual=mysql_query("SELECT estado_id FROM com_pedidos WHERE Id='$id_ch'",$conexion);
		$actualest=mysql_fetch_row($estadoactual);
		$deverificar=$actualest[0];
		
		
		if($nwestado=='1000'){
			
		}else if($deverificar=='2' && $nwestado<=2){
			echo "<script lenguaje=\"JavaScript\">alert('El pedido debe pasar de Generado a Asignado en Bodega');</script>";	
			$np=1;
		}else if($deverificar=='3' && $nwestado!=7){		//Lo correcto es que aqui sea 4 se hace la correccion para evitar la TPL
			echo "<script lenguaje=\"JavaScript\">alert('El pedido debe pasar de Asignado en Bodega a Verifaciòn y Alistamiento');</script>";	
			$np=1;
		}else if($deverificar=='4' && $nwestado!='5'){
			echo "<script lenguaje=\"JavaScript\">alert('Finalice la verificacion antes de despachar el producto');</script>";	
			$np=1;
		}else if($deverificar=='7' && $nwestado!='4'){
			echo "<script lenguaje=\"JavaScript\">alert('El pedido debe ser verificado antes de despacharse.');</script>";	
			$np=1;
		}else if($deverificar=='6' && $nwestado!='6'){
			echo "<script lenguaje=\"JavaScript\">alert('El pedido ya ha sido despachado.');</script>";	
			$np=1;
		}
		
		
		//Cambiando al nuevo estado
		if($np==0){
			
			
			if($nwestado=='3'){
				echo "<script lenguaje=\"JavaScript\">setTimeout('AsignarenBodega(".$id_ch.")',500);</script>"; 
				
			}else if($nwestado=='4'){
				echo "<script lenguaje=\"JavaScript\">setTimeout('Verificacion(".$id_ch.")',500);</script>"; 
			}else if($nwestado=='1000'){
				$envio_new="allscreensoft('com_pages/agpedido.php','nuevaVentana')";
				echo "<script lenguaje=\"JavaScript\">setTimeout('".$envio_new."',500);</script>"; 
			}else{
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
			
				$insertar=mysql_query("UPDATE com_pedidos SET estado_id='$nwestado',fechasalida='$fecha' WHERE Id='$id_ch'");
			
				if(!$insertar)
				$error=1;
			
				$insertar=mysql_query("UPDATE com_productospedido SET estado_id='$nwestado' WHERE pedido_id='$id_ch'");
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
		
<h3> >> Listado Despachos - Pedidos </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>No Pedido:</td>
                <td><input type="text" name="filtro" size="30" /></td>
                <td>&nbsp;</td>
                <td>Cliente:</td>
                <td><input type="text" name="filtro2" size="30" /></td>
                <td>Fecha Recibido:</td>
                <td><input type="date" name="filtro3" size="30" /> <!--Boton de Filtrado --><input type="submit" value="Filtrar" /></td>
            </tr>
            <tr>
            	<td colspan="7">&nbsp;</td>
            </tr>
            <tr>
            	<td>Responsable:</td>
                <td colspan="2">
                	<select name="filtro4">
                    	<option value=""></option>
					<?php
						opciones($conexion,"com_usconect","Id","CONCAT_WS(' ',nombre,apellidos)","WHERE perfil_id='4' ")
					?>
                    </select>
                </td>
                <td>Estado:</td>
                <td>
                	<select name="filtro5">
                    	<option value=""></option>
					<?php
						opciones($conexion,"com_estadopedido","Id","nombre","WHERE Id>=2 ")
					?>
                    </select>
                </td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="8" /> 
</form>


<!--Separador en CSS -->
<div style="clear:both">
	<?php include("funciones/menubodega2.php"); ?>
</div>

<form action="com_pages/verdetallepedido.php" target="popup" onsubmit="window.open('', 'popup', 'width=1300, height=700')" name="form1">



<!--Barrande Botones ------------------------->


<!--Botones -------->
		<table align="right">
			<tr>
                <td><input type="submit" value="Ver Detalles" name="forma" onclick="bodegafunction2('1000')" /></td>
			</tr>
		</table>

		<br/>		
        <br/>
        <br/>


        
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		
		if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando==''){
			 	$filtrando.=" where com_pedidos.nopedido LIKE '%".$_GET['filtro']."%'";
				$tp_filtros="&filtro=".$_GET['filtro'];
        }else if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando!=''){
				$filtrando.=" and com_pedidos.nopedido LIKE '%".$_GET['filtro']."%'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando==''){
			 	$filtrando.=" where com_clientes.nombres LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros="&filtro2=".$_GET['filtro2'];
        }else if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando!=''){
				$filtrando.=" and com_clientes.nombres LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
		}
		
		
		if(!empty($_GET['filtro3']) && $_GET['filtro3']!='' && $filtrando==''){
			 	$filtrando.=" where com_pedidos.fechapedidos=".$_GET['filtro3']."";
				$tp_filtros.="&filtro3=".$_GET['filtro3'];
        }else if(!empty($_GET['filtro3']) && $_GET['filtro3']!='' && $filtrando!=''){
				$filtrando.=" and  com_pedidos.fechapedidos=".$_GET['filtro3']."";
				$tp_filtros.="&filtro3=".$_GET['filtro3'];
		}
		
		if(!empty($_GET['filtro4']) && $_GET['filtro4']!='' && $filtrando==''){
			 	$filtrando.=" where com_pedidos.userbodega_id=".$_GET['filtro4']."";
				$tp_filtros.="&filtro4=".$_GET['filtro4'];
        }else if(!empty($_GET['filtro4']) && $_GET['filtro4']!='' && $filtrando!=''){
				$filtrando.=" and  com_pedidos.userbodega_id=".$_GET['filtro4']."";
				$tp_filtros.="&filtro4=".$_GET['filtro4'];
		}
		
		if(!empty($_GET['filtro5']) && $_GET['filtro5']!='' && $filtrando==''){
			 	$filtrando.=" where com_estadopedido.Id=".$_GET['filtro5']."";
				$tp_filtros.="&filtro5=".$_GET['filtro5'];
        }else if(!empty($_GET['filtro5']) && $_GET['filtro5']!='' && $filtrando!=''){
				$filtrando.=" and  com_estadopedido.Id=".$_GET['filtro5']."";
				$tp_filtros.="&filtro5=".$_GET['filtro5'];
		}
		
		
		if($filtrando==''){
				$filtrando.=" where com_pedidos.estado_id>='2'";
				$tp_filtros.="";
		}
		//echo $filtrando;
?>
                
        
<!--Listado de todos los Productos !-->	
	<div class="datagrid">	
		<table cellspacing="0" width="1100px">
			<thead>
				<th>No. Pedido</th>
				<th>Cliente</th>
                <th>Dirección</th>
                <th>Pedido</th>
                <th>Salida</th>
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
					$n=(($p_actual*30)-30);
				}
				
				
				$sentencia_sql=mysql_query("SELECT com_pedidos.*,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as responsable,
CONCAT_WS('',com_clientes.nombres) as cliente,
CONCAT_WS(' ',com_direccionclientes.direccion,com_ciudad.ciudad) as direccion,
com_estadopedido.nombre as estado
FROM com_pedidos
LEFT JOIN com_direccionclientes ON com_pedidos.direccioncliente_id=com_direccionclientes.Id
LEFT JOIN com_usconect ON com_usconect.Id=com_pedidos.userbodega_id
LEFT JOIN com_clientes ON com_direccionclientes.cliente_id=com_clientes.Id
LEFT JOIN com_ciudad ON com_direccionclientes.ciudad_id=com_ciudad.Id
LEFT JOIN com_estadopedido ON com_estadopedido.Id=com_pedidos.estado_id $filtrando ",$conexion);


				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/30);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=30;									//Numero de resultados por Página
				
				$sentencia_sql2=mysql_query("SELECT com_pedidos.*,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as responsable,
CONCAT_WS('',com_clientes.nombres) as cliente,
CONCAT_WS(' ',com_direccionclientes.direccion,com_ciudad.ciudad) as direccion,
com_estadopedido.nombre as estado
FROM com_pedidos
LEFT JOIN com_direccionclientes ON com_pedidos.direccioncliente_id=com_direccionclientes.Id
LEFT JOIN com_usconect ON com_usconect.Id=com_pedidos.userbodega_id
LEFT JOIN com_clientes ON com_direccionclientes.cliente_id=com_clientes.Id
LEFT JOIN com_ciudad ON com_direccionclientes.ciudad_id=com_ciudad.Id
LEFT JOIN com_estadopedido ON com_estadopedido.Id=com_pedidos.estado_id $filtrando ORDER BY com_pedidos.Id DESC LIMIT $n,$m",$conexion);


				$class="alt";
					while($registro=mysql_fetch_assoc($sentencia_sql2)){
						if($class==""){
							$class="alt";	
						}else{
							$class="";	
						}
			?>
					<tr class="<?php echo $class; ?>" >
					    <td><?php echo $registro['nopedido']; ?></td>
                        <td><?php echo $registro['cliente']; ?></td>
                        <td><?php echo $registro['direccion']; ?></td>
                        <td><?php echo $registro['fechapedido']; ?></td>
                        <td><?php echo $registro['fechasalida']; ?></td>
                        <td><?php echo $registro['responsable']; ?></td>
				        <td><?php echo $registro['estado']; ?></td>
                       <td><input type="radio" name="Id" value="<?php echo $registro['Id']; ?>" id="codproyecto"/></td>	
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
						echo "<a href='?com_pg=8&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td> 
			</tr>
		</tfoot>
       </table>
      </div>  
</form>
