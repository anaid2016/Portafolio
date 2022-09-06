<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	$filtrando='';
	
	//Captura de Filtros --------------------------------------//
	$tp_filtros="";
	$link="6";
	$usuario=$_SESSION['iduser'];
	$sil_this="?com_pg=".$link;
	
?>

<!--Listado de Productos en el sistema !-->
		
<h3> >> Listado de Clientes </h3>
<!--Filtro para Listado -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
        <table align="left" class="filtros">
        	<tr>
            	<td>Razón Social:</td>
                <td><input type="text" name="filtro" size="30" /></td>
                <td>&nbsp;</td>
                <td>Nit:</td>
                <td><input type="text" name="filtro2" size="30" />  <!--Boton de Filtrado --><input type="submit" value="Filtrar" /></td>
            </tr>
        </table>
        <!--Envia Estado de Pagina Actual -->
        <input type="hidden" name="com_pg" value="6" /> 
</form>

<form method="POST" id="formulario" name="formulario">
 	
   <div id="barra">	
		 <?php 
		  GRAPH002($link,$usuario,$sil_this,"search_form",'com_pages/agclientes.php','com_pages/agclientes.php','com_pages/delclientes.php','','','400','1000','2::1::1::1::2::2::2'); 
		 ?>	
	</div>	
    
    <div style="clear:both">&nbsp;</div>      

      
<!--Filtro Existente o No, Aplicacion de Filtros -->
<?php

		
		
		if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando==''){
			 	$filtrando.=" where com_clientes.nombres LIKE '%".$_GET['filtro']."%'";
				$tp_filtros="&filtro=".$_GET['filtro'];
        }else if(!empty($_GET['filtro']) && $_GET['filtro']!='' && $filtrando!=''){
				$filtrando.=" and com_clientes.nombres LIKE '%".$_GET['filtro']."%'";
				$tp_filtros.="&filtro=".$_GET['filtro'];
		}
		
		
		if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando==''){
			 	$filtrando.=" where com_clientes.nit LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
        }else if(!empty($_GET['filtro2']) && $_GET['filtro2']!='' && $filtrando!=''){
				$filtrando.=" and com_clientes.nit LIKE '%".$_GET['filtro2']."%'";
				$tp_filtros.="&filtro2=".$_GET['filtro2'];
		}
		
		
?>
                
        
<!--Listado de todos los Productos !-->		
<div class="datagrid">	
		<table cellspacing="0" width="1100px">
			<thead>
				<th>Razon Social</th>
				<th>Nit</th>
                <th>Representante Legal</th>
                <th>Correo</th>
                <th>Celular</th>
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
				
				
				$sentencia_sql=mysql_query("SELECT com_clientes.* FROM com_clientes $filtrando",$conexion);
				$total=mysql_num_rows($sentencia_sql);
				$tpag=($total/10);						//Numero de Páginas a obtener
				$tpag=ceil($tpag);						//Redonde de Numero de Páginas a obtener
				$m=10;									//Numero de resultados por Página
				$class="alt";
				
				$sentencia_sql2=mysql_query("SELECT com_clientes.* FROM com_clientes $filtrando LIMIT $n,$m",$conexion);
					while($registro=mysql_fetch_assoc($sentencia_sql2)){
						if($class==""){
							$class="alt";	
						}else{
							$class="";	
						}
			?>
					<tr class="<?php echo $class; ?>">
					    <td height='30px'><?php echo $registro['nombres']; ?></td>
                        <td height='30px'><?php echo $registro['nit']; ?></td>
                        <td height='30px'><?php echo $registro['representantelegal']; ?></td>
                        <td height='30px'><?php echo $registro['correo']; ?></td>
                        <td height='30px'><?php echo $registro['celular']; ?></td>
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
						echo "<a href='?com_pg=6".$tp_filtros."'>".$u."</a>";			
					}
				?>
               </td>
			</tr>
		</tfoot>
      </table>  
 </div>
</form>

