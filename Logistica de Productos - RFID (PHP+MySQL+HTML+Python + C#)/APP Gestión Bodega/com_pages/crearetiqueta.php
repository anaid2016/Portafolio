
<?php
	ini_set('max_execution_time', 270000); //300 seconds = 5 minutes
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cerrar Revision</title>
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>
<script language="javascript" src="../funciones/jquery-1.2.6.min.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="js/varias.js" type="text/javascript"></script>
<script> 
 function Cerrar(){
	opener.location.href = "../acceso.php?com_pg=5";
    window.close();
}
</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenidof4">
<!--Ultimo RFID obtenido// Generación de palabra RFID ---------------------------------------------------------------->
		<?php
			$cultRFID=mysql_query("SELECT max(RFID) FROM com_inventario",$conexion);
			$max_number=mysql_fetch_row($cultRFID);
		
		
		?>
<!----------------------------------------------------------------------------------------------------------------->

    	<h2> >> Cerrar Revisi&oacute;n</h2>
			<?php
			//Buscar Datos Relacionados con la Orden de Compra a Cerrar Revision ---------------------------------------------------------------------------------------------//
			if(!empty($_GET['orden']) && empty($_POST['Guardar']) && empty($_POST['finalizar'])){
				
				$id=$_GET['orden'];		//ID DE LA ORDEN A BUSCAR-----------------------------------------------------------------//
				
				//Buscando si ya estan incluidos para proceso de inventario ------------------------------------------------------//
				$bproductos=mysql_query("SELECT com_nombres.nombre as producto,com_productos.codbarras as barras,
com_productos.Id as idprod,com_unidades.nombre,com_inventario.RFID, 
com_inventario.lineaoc_id as Id,com_inventario.estado as est,
com_inventario.cantidad_entrada,com_inventario.Id as lineainventario,'1' as rollos  FROM com_inventario
LEFT JOIN com_productosorden ON com_inventario.lineaoc_id=com_productosorden.Id
LEFT JOIN com_productos ON com_inventario.producto_id=com_productos.Id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
LEFT JOIN com_nombres ON com_nombres.Id=com_productos.nombre
WHERE com_productosorden.orden_id='$id' ORDER BY codbarras",$conexion); 
				$totalguardado=mysql_num_rows($bproductos);
				
				
				//Si aun no hay productos guardados para proceso ---------------------------------------------------------------------------------------------------------------------//
				if($totalguardado==0){
					$bproductos=mysql_query("SELECT com_nombres.nombre as producto,com_productos.codbarras as barras,com_productos.Id as idprod,com_unidades.nombre,com_inventario.RFID, com_productosorden.*,com_inventario.estado as est,com_inventario.cantidad_entrada,com_inventario.Id as lineainventario FROM com_productosorden 
LEFT JOIN com_proveedorproductos ON com_productosorden.proveedorproducto_id=com_proveedorproductos.Id
LEFT JOIN com_productos ON com_productos.Id=com_proveedorproductos.producto_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
LEFT JOIN com_inventario ON com_inventario.lineaoc_id=com_productosorden.Id
LEFT JOIN com_nombres ON com_nombres.Id=com_productos.nombre
WHERE orden_id='$id' and revisado!='0' ORDER BY codbarras",$conexion);
				}
				

			}else if(empty($_POST['Guardar']) && empty($_POST['finalizar'])){
				die("Seleccione una Orden de Compra a Cerrar");	
			}
			
			
			
			//Guardando Producto Creado, sin cambios en Estado ----------------------------------------------------------------------------------------------------------------//
            if(!empty($_POST['Guardar']) && empty($_POST['finalizar'])){
			
				$vector1=array();
				$vector2=array();
				$vector3=array();
				$vector4=array();
				$vector5=array();
				$vector6=array();
				
				$cantidad=$_POST['cantidad'];
				$orden=$_POST['orden'];
				
				for($b=1;$b<=$cantidad;$b++){
					$est1='rd'.$b;
					$est2='re'.$b;
					$est3='rf'.$b;
					$est4='rg'.$b;
					$est5='rh'.$b;
					$est6='ri'.$b;
					
					$vector1[$b]=$_POST[$est1];	
					$vector2[$b]=$_POST[$est2];
					$vector3[$b]=$_POST[$est3];
					$vector4[$b]=$_POST[$est4];
					$vector5[$b]=$_POST[$est5];
					$vector6[$b]=$_POST[$est6];
				}
				
				
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				for($b=1;$b<=$cantidad;$b++){ 
					if($vector6[$b]==''){
						$insertar=mysql_query("INSERT INTO com_inventario SET producto_id='$vector5[$b]',RFID='$vector1[$b]',cantidad='$vector2[$b]',estado='$vector4[$b]',lineaoc_id='$vector3[$b]',cantidad_entrada='$vector2[$b]' ");
					}else{
						$insertar=mysql_query("UPDATE com_inventario SET producto_id='$vector5[$b]',RFID='$vector1[$b]',cantidad='$vector2[$b]',estado='$vector4[$b]',lineaoc_id='$vector3[$b]',cantidad_entrada='$vector2[$b]' WHERE Id='$vector6[$b]'");
					}
					
					if(!$insertar){
						$error=1;
					}
				}
				
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Cambios Guardados con Exito";
				}
							
			   echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>"; 
			}else if(empty($_POST['Guardar']) && !empty($_POST['finalizar'])){ //////////////////////FINALIZANDO REVISION PASANDO OC A ESTADO REVISADO PARA SEGUIR PROCESO---------//
				
				
				$vector1=array();
				$vector2=array();
				$vector3=array();
				$vector4=array();
				$vector5=array();
				$vector6=array();
				
				$cantidad=$_POST['cantidad'];
				$orden=$_POST['orden'];
				
				for($b=1;$b<=$cantidad;$b++){
					$est1='rd'.$b;
					$est2='re'.$b;
					$est3='rf'.$b;
					$est4='rg'.$b;
					$est5='rh'.$b;
					$est6='ri'.$b;
					
					$vector1[$b]=$_POST[$est1];	
					$vector2[$b]=$_POST[$est2];
					$vector3[$b]=$_POST[$est3];
					$vector4[$b]='1';
					$vector5[$b]=$_POST[$est5];
					$vector6[$b]=$_POST[$est6];
				}
				
				$lineaspas='';
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				for($b=1;$b<=$cantidad;$b++){ 
			
					if($vector6[$b]==''){
						$insertar=mysql_query("INSERT INTO com_inventario SET producto_id='$vector5[$b]',RFID='$vector1[$b]',cantidad='$vector2[$b]',lineaoc_id='$vector3[$b]',cantidad_entrada='$vector2[$b]' ");
						
						if(!$insertar){
							$error=1;
						}
					}else{
						$insertar=mysql_query("UPDATE com_inventario SET producto_id='$vector5[$b]',RFID='$vector1[$b]',cantidad='$vector2[$b]',lineaoc_id='$vector3[$b]',cantidad_entrada='$vector2[$b]' WHERE Id='$vector6[$b]'");
						
						if(!$insertar){
							$error=1;
						}
					}
					
					//CAMBIANDO ESTAO DE LINEAS EN ORDEN DE COMPRA ---------------------------------------------------------------------------------------------------//
					$lineaspas.=$vector3[$b].",";
					$insertar=mysql_query("UPDATE com_productosorden SET estado_id='5' WHERE Id='$vector3[$b]'");
					if(!$insertar){
						$error=1;
					}
					
				}
				
				
				//CAMBIANDO ESTADO DE LA ORDEN DE COMPRA --------------------------------------------------------------------------------------------------------------//
				$insertar=mysql_query("UPDATE com_ordencompra SET estado_id='5' WHERE Id='$orden'");
					if(!$insertar){
						$error=1;
					}
			
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				}else{
					mysql_query("COMMIT");
					echo "Cambios Guardados con Exito";
					
					//GENERANDO ARCHIVO PARA ETIQUETAS ------------------------------------------------------------------------------------------------------------------//
					$lineaspas=substr($lineaspas,0,-1);
					/*generaretiquetaImp($lineaspas,$conexion,$user);*/
					//Pasando productos a estado de inventario 1 --- Producto Etiquetado
					et_exito($lineaspas,$conexion);
					
										
				}			
			   		echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>"; 
			}else{
               
           
            ?>
            <div class="datagrid">
            	<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST">
                
                <table class="othertype">
                	<thead>
                    	<tr>
                    		<th>Codigo</th>
                        	<th>Producto</th>
                        	<th>Und</th>
							<th>RFID</th>
                        	<th>Cantidad</th>
                        	<th>Etiquetado</th>
                    	</tr>
                   </thead>
                   <tbody>
                    	<?php
						$act=0;
						while($rproducto=mysql_fetch_assoc($bproductos)){
							$n_rol=$rproducto['rollos'];
							for($r=0;$r<$n_rol;$r++){
								$act=$act+1;	
								
								//Tipos de estado de la etiqueta en proceso
								if($rproducto['est']=='0' || $rproducto['est']==''){
									$nomest="Esperando Etiquetado";	
								}else if($rproducto['est']=='1'){
									$nomest="Etiquetado";	
								}else{
									$nomest="Inventariado";	
								}
								
								if(empty($rproducto['RFID'])){
									/*$rproducto['RFID_N']=$max_number[0]+1;
									$max_number[0]=$max_number[0]+1;*/
									$rproducto['RFID_N']="";
								}else{
									$rproducto['RFID_N']=$rproducto['RFID'];
								}
					
								//Para pares====================================
								if($rproducto['nombre']=="par" and $rproducto['cantidad_entrada']==""){
									$rproducto['cantidad_entrada']=1;
								}
					
						?>
                        	
                        	<tr>
                            	<td width="100px"><input type="text" class="small_3" name="ra<?php echo $act; ?>" value="<?php echo $rproducto['barras']; ?>" readonly="readonly" size="10" /></td>
                                <td width="200px"><input type="text" class="small_3" name="rb<?php echo $act; ?>" value="<?php echo $rproducto['producto']; ?>" readonly="readonly" size="10"/></td>
                        		<td width="40px"><input type="text" class="small_3" name="rc<?php echo $act; ?>" value="<?php echo $rproducto['nombre']; ?>" readonly="readonly" size="10"/></td>
                                <td width="60px"><input type="text"  name="rd<?php echo $act; ?>" value="<?php echo $rproducto['RFID_N']; ?>" size="20"/></td>
                                <td width="40px"><input type="text" name="re<?php echo $act; ?>" value="<?php echo $rproducto['cantidad_entrada']; ?>" size="10" /></td>
                                <td width="40px">
									<?php echo $nomest; ?>
                                	<input type="hidden" name="rf<?php echo $act; ?>" value="<?php echo $rproducto['Id']; ?>" />
                                    <input type="hidden" name="rg<?php echo $act; ?>" value="<?php echo ($rproducto['est']!='')?  $rproducto['est']:'0'; ?>" />
                                	<input type="hidden" name="rh<?php echo $act; ?>" value="<?php echo $rproducto['idprod']; ?>" />
                                    <input type="hidden" name="ri<?php echo $act; ?>" value="<?php echo $rproducto['lineainventario']; ?>" />
                                </td>
                            </tr>
                        <?php
							}
						}
						?>
                  </tbody> 	
                  <tfoot>
                  	<tr>
                    	<td colspan="6" align="right">
                        <input type="hidden" name="cantidad" value="<?php echo $act; ?>" />
                        <input type="hidden" name="orden" value="<?php echo $id; ?>" />
                        <input type="submit" value="Finalizar Revision" name="finalizar" />&nbsp;
                        <input type="submit" value="Guardar" name="Guardar" /></td>
                    </tr>
                  </tfoot>   
              	</table>          
                
                
                
  				</form>
            </div>    
  			<?php
			}
			
			?>
</div>
</body>
</html>