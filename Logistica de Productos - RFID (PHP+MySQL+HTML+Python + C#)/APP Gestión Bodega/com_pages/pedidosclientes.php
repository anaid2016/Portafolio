<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	$com_pag=$_GET['com_pg'];
	$fecha=gmdate('Y-m-d');
	$np=0;
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	$link="7";
	$usuario=$_SESSION['iduser'];
	$sil_this="?com_pg=".$link;
	
	
	//Captura de Cambio de Estados -----------------------------//
	if(!empty($_GET['estado']) && !empty($_GET['id_ch'])){
		$nwestado=$_GET['estado'];
		$id_ch=$_GET['id_ch'];
		
		//Revisar estado actual de la Orden - Construir esto para validacion mas adelante
		$estadoactual=mysql_query("SELECT estado_id FROM com_pedidos WHERE Id='$id_ch'",$conexion);
		$actualest=mysql_fetch_row($estadoactual);
		$deverificar=$actualest[0];
		
		if($deverificar=='1' && $nwestado!='2'){
			echo "<script lenguaje=\"JavaScript\">alert('El pedido actual se encuentra en estado Solicitud - debe pasar a Generada antes de realizar otra accion');</script>";	
			$np=1;
		}
		
		
		//Cambiando al nuevo estado
		if($np==0){
			
			
			/*if($nwestado=='5'){
			//POPUP PARA LA CREACION DE LOTES Y LA IMPRESION DE LAS ETIQUETAS
				echo "<script lenguaje=\"JavaScript\">setTimeout('Etiquetar(".$id_ch.")',500);</script>"; 
			
			
			}else if($nwestado=='6'){
			//AQUI VOY FALTA CREAR POPUP PARA VERIFICAR SEGUN REGISTROS	
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Verificar(".$id_ch.")',500);</script>"; 
				
			}else{*/
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
			
				$insertar=mysql_query("UPDATE com_pedidos SET estado_id='$nwestado' WHERE Id='$id_ch'");
			
				if(!$insertar)
				$error=1;
			
				$insertar=mysql_query("UPDATE com_productospedido SET estado_id='$nwestado' WHERE pedido_id='$id_ch'");
				if(!$insertar)
				$error=1;
			
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "<script lenguaje=\"JavaScript\">setTimeout('recargarpedido(1)',1000);</script>";
				}else {
					mysql_query("COMMIT");
					echo "<script lenguaje=\"JavaScript\">setTimeout('recargarpedido(2)',1000);</script>";
				}
				
			//}
			
		}
		
		
		
		
	}
	
?>

<!--Listado de Productos en el sistema !-->
		
<h3> >> Listado Pedidos Clientes </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>No Pedido:</td>
                <td><input type="text" name="filtro" size="30" /></td>
                <td>&nbsp;</td>
                <td>Cliente:</td>
                <td><input type="text" name="filtro2" size="30" /></td>
                <td>Fecha Pedido:</td>
                <td><input type="date" name="filtro3" size="30" /> <!--Boton de Filtrado --><input type="submit" value="Filtrar" /></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="1" /> 
</form>


<!--Separador en CSS -->
<div style="clear:both">&nbsp;</div>

<div class="filtro">
	<?php include("funciones/menuordenpedido.php"); ?>
</div>

<form method="POST" id="formulario" name="formulario">
 	
   <div id="barra">	
		 <?php 
		  GRAPH002($link,$usuario,$sil_this,"search_form",'com_pages/agpedido.php','com_pages/agpedido.php','com_pages/depedidos.php','','','all','all','2::1::1::1::2::2::2'); 
		 ?>	
	</div>	
    
    <div style="clear:both">&nbsp;</div>  
        
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
		
		
?>
                
        
<!--Listado de todos los Productos !-->	
	<div class="datagrid">	
		<table cellspacing="0" width="1100px">
			<thead>
				<th>No. Pedido</th>
				<th>Cliente</th>
                <th>Dirección</th>
                <th>Fecha Pedido</th>
                <th>Salida</th>
                <th>Entrega</th>
                <th>Cancelado</th>
                <th>Total Costo</th>
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
					$n=(($p_actual*40)-40);
				}
				
				
				$sentencia_sql=mysql_query("SELECT com_pedidos.*,CONCAT_WS(',',com_direccionclientes.direccion,com_ciudad.ciudad) as direccion,com_estadopedido.nombre,com_clientes.nombres AS cliente
 FROM com_pedidos
LEFT JOIN com_direccionclientes ON com_direccionclientes.Id=com_pedidos.direccioncliente_id
LEFT JOIN com_clientes ON com_direccionclientes.cliente_id=com_clientes.Id
LEFT JOIN com_estadopedido ON com_estadopedido.Id=com_pedidos.estado_id
LEFT JOIN com_ciudad ON com_direccionclientes.ciudad_id=com_ciudad.Id $filtrando",$conexion);
				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/40);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=40;									//Numero de resultados por Página
				
				$sentencia_sql2=mysql_query("SELECT com_pedidos.*,CONCAT_WS(',',com_direccionclientes.direccion,com_ciudad.ciudad) as direccion,com_estadopedido.nombre,com_clientes.nombres AS cliente
 FROM com_pedidos
LEFT JOIN com_direccionclientes ON com_direccionclientes.Id=com_pedidos.direccioncliente_id
LEFT JOIN com_clientes ON com_direccionclientes.cliente_id=com_clientes.Id
LEFT JOIN com_estadopedido ON com_estadopedido.Id=com_pedidos.estado_id
LEFT JOIN com_ciudad ON com_direccionclientes.ciudad_id=com_ciudad.Id $filtrando ORDER BY com_pedidos.Id DESC LIMIT $n,$m",$conexion);

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
                        <td><?php echo $registro['fechaentrega']; ?></td>
                         <td><?php echo $registro['fechacancelado']; ?></td>
                         <td><?php echo $registro['totalconiva']; ?></td>
                        <td><?php echo $registro['nombre']; ?></td>
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
						echo "<a href='?com_pg=7&p_actual=".$u."".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td> 
			</tr>
		</tfoot>
       </table>
      </div>  
</form>
