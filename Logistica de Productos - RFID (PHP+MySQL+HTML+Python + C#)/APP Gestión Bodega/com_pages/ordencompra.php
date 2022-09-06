<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	$com_pag=$_GET['com_pg'];
	$fecha=gmdate('Y-m-d');
	$np=0;
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	$link="5";
	$usuario=$_SESSION['iduser'];
	$sil_this="?com_pg=".$link;
	
	
	//Captura de Cambio de Estados -----------------------------//
	if(!empty($_GET['estado']) && !empty($_GET['id_ch'])){
		$nwestado=$_GET['estado'];
		$id_ch=$_GET['id_ch'];
		
		//Revisar estado actual de la Orden - Construir esto para validacion mas adelante
		$estadoactual=mysql_query("SELECT estado_id FROM com_ordencompra WHERE Id='$id_ch'",$conexion);
		$actualest=mysql_fetch_row($estadoactual);
		$deverificar=$actualest[0];
		
		if($deverificar=='1' && $nwestado!='3'){
			echo "<script lenguaje=\"JavaScript\">alert('La Orden actual se encuentra en estado Solicitud - debe pasar a Generada antes de realizar otra accion');</script>";	
			$np=1;
		}else if($deverificar=='2' && $nwestado!='4'){
			echo "<script lenguaje=\"JavaScript\">alert('La Orden actual se encuentra en estado Generada - debe pasar a Revision antes de realizar otra accion');</script>";	
			$np=1;
		}else if($deverificar=='4' && $nwestado!='5'){
			echo "<script lenguaje=\"JavaScript\">alert('La Orden actual se encuentra en estado Revision Finalice la Revision antes de realizar otra accion');</script>";	
			$np=1;
		}else if($deverificar=='5' && $nwestado!='6'){
			echo "<script lenguaje=\"JavaScript\">alert('La Orden actual se encuentra en estado Revisada debe pasar a Verificando antes de realizar otra accion');</script>";	
			$np=1;
		}else if($deverificar=='6' && $nwestado!='7'){
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
			
			
			if($nwestado=='5'){
			//POPUP PARA LA CREACION DE LOTES Y LA IMPRESION DE LAS ETIQUETAS
				echo "<script lenguaje=\"JavaScript\">setTimeout('Etiquetar(".$id_ch.")',500);</script>"; 
			
			
			}else if($nwestado=='6'){
			//AQUI VOY FALTA CREAR POPUP PARA VERIFICAR SEGUN REGISTROS	
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Verificar(".$id_ch.")',500);</script>"; 
				
			}else{
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
			
				$insertar=mysql_query("UPDATE com_ordencompra SET estado_id='$nwestado' WHERE Id='$id_ch'");
			
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
		
<h3> >> Listado Orden de Compra </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>No Orden:</td>
                <td><input type="text" name="filtro" size="30" /></td>
                <td>&nbsp;</td>
                <td>Proveedor:</td>
                <td><input type="text" name="filtro2" size="30" /></td>
            </tr>
            <tr>
                <td>Fecha Solicitud:</td>
                <td colspan="4"><input type="date" name="filtro3" size="30" /> <!--Boton de Filtrado --><input type="submit" value="Filtrar" /></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="5" /> 
</form>


<div style="clear:both">&nbsp;</div>

<!--Separador en CSS -->
<div class="filtro">
<?php include("funciones/menuorden.php"); ?>
</div>

<!--Anexo Filtros ---->
<form method="POST" id="formulario" name="formulario">
 	
   <div id="barra">	
	  <!--//GRAPH002($link,$usuario,$sil_this,"com_pages/revizarordencompra.php",'com_pages/agordencompra.php','com_pages/agordencompra.php','com_pages/deordencompra.php','all','all','2::1::1::1::2'); -->

         <?php 
		  GRAPH002($link,$usuario,$sil_this,"com_pages/verdetalleorden.php",'com_pages/agordencompra.php','com_pages/agordencompra.php','com_pages/deordencompra.php',"",'com_pages/revizarordencompra.php','all','all','1::1::1::1::2::1'); 
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
				<th>No. Orden</th>
				<th>Proveedor</th>
                <th>Dirección</th>
                <th>Fecha de Solicitud</th>
                <th>Fecha de Recibido</th>
                <th>Costo Total</th>
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
					$n=(($p_actual*20)-20);
				}
				
				
				$sentencia_sql=mysql_query("SELECT com_ordencompra.*,
CONCAT_WS(' /',com_direccionproveedor.direccion,com_ciudad.ciudad) as direccion,
com_proveedores.nombre as proveedor FROM com_ordencompra
LEFT JOIN com_direccionproveedor ON com_ordencompra.direccionproveedor_id=com_direccionproveedor.Id
LEFT JOIN com_proveedores ON com_direccionproveedor.proveedor_id=com_proveedores.Id
LEFT JOIN com_ciudad ON com_direccionproveedor.ciudad_id=com_ciudad.ciudad $filtrando ORDER BY com_ordencompra.Id DESC",$conexion);
				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/20);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=20;									//Numero de resultados por Página
				
				$sentencia_sql2=mysql_query("SELECT com_ordencompra.*,
CONCAT_WS(' /',com_direccionproveedor.direccion,com_ciudad.ciudad) as direccion,
com_proveedores.nombre as proveedor,com_estadooc.nombre as estado FROM com_ordencompra
LEFT JOIN com_direccionproveedor ON com_ordencompra.direccionproveedor_id=com_direccionproveedor.Id
LEFT JOIN com_proveedores ON com_direccionproveedor.proveedor_id=com_proveedores.Id
LEFT JOIN com_ciudad ON com_direccionproveedor.ciudad_id=com_ciudad.ciudad 
LEFT JOIN com_estadooc ON com_ordencompra.estado_id=com_estadooc.Id $filtrando ORDER BY com_ordencompra.Id DESC LIMIT $n,$m ",$conexion);
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
						<td><input type="radio" name="Id" value="<?php echo $registro['Id']; ?>" id="codproyecto"/></td>	
					</tr>
					<?php
					}
					?>
                    
         </tbody>           
		  <tfoot>
			<tr>
             	<td colspan="8" align="right">
				<?php
					for($u=1;$u<=($tpag);$u++)
					{
						echo "<a href='?com_pg=5".$tp_filtros."&p_actual=".$u."'>".$u."</a>";			
					}
				?>
               </td> 
			</tr>
		</tfoot>
       </table>
      </div>  
</form>
