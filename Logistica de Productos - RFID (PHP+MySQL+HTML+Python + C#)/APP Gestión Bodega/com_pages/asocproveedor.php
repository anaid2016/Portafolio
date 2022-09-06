<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	
	
	//Creación de Arrays 
	$arrid=array();
	$arra=array();
	$arrb=array();
	$arrc=array();
	$arrd=array();
	$arre=array();

	$d=0;
	if(!empty($_GET['Id'])){
				// Busqueda del proveedor
				$id=$_GET['Id'];
				
				//Buscando Iva asociado al producto ---------------------------------------------------//
				$biva=mysql_query("SELECT * FROM com_preciosclientes WHERE producto_id='$id'",$conexion);
				while($r_iva=mysql_fetch_assoc($biva)){
					$iva_now=$r_iva['porcentajeiva'];	
				}
				
				$buscar=mysql_query("SELECT * FROM com_proveedorproductos WHERE producto_id='$id'",$conexion);
				while($resultado=mysql_fetch_assoc($buscar)){
					array_push($arrid,$resultado['Id']);	
					array_push($arra,$resultado['direccion_id']);
					array_push($arrb,$resultado['cantidadcompra']);
					array_push($arrc,$resultado['valorantesiva']);
					array_push($arrd,$resultado['porcentajeiva_id']);
					array_push($arre,$resultado['valordespuesiva']);
				
				}
	}
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Proveedores</title>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../css/menuinterno.css">
<link rel="stylesheet" type="text/css" href="../css/popupcss.css">
<script> 
 function Cerrar(Id){
	location.href = '?Id='+Id;
 }

 function Cerrar2(){
	opener.location.href = "../acceso.php?com_pg=4";
    window.close();
  }
  
  function PrecioFinal(valor,fila){
	var precio=valor.value;
	var findice=fila;
	
	if(precio!=''){
		
		var ivaapl=document.getElementById('ivaactual').value;
		var preciofinal=(precio*ivaapl)/100;
		var totalgrava=Number(precio)+Number(preciofinal);
		document.getElementById('valorfinal'+fila).value=totalgrava.toFixed(2);	 
	}
	  
  }
</script>

</head>

<body>

	<!--Menu de Solapas -->
	<div id="tabsI">
    	 <ul>
           <li><a href="<?php echo (!empty($_GET['Id']))? '?Id='.$_GET['Id']:'' ?>" title="Direcciones"><span>Proveedores</span></a></li>
         </ul>
    </div>
<div id="contenidof">
	<?php
	//Guardando Direcciones de Proveedores
			
			
			//Guardando Direccion de Proveedor -----------------------------------------------------------//
            if(!empty($_POST['Guardar']) && !empty($_POST['Id'])){
			
				if(!empty($_POST['cantidad2']) && $_POST['cantidad2']>0){
					$cantidad=$_POST['cantidad2'];
				}else{
					$cantidad=$_POST['cantidad'];
				}
				$id=$_POST['Id'];
				
				$vector1=array();
				$vector2=array();
				$vector3=array();
				$vector4=array();
				$vector5=array();
				
				for($b=1;$b<=$cantidad;$b++){
					$est1='a'.$b;
					$est2='b'.$b;
					$est3='c'.$b;
					$est4='d';
					$est5='e'.$b;
				
				
					$vector1[$b]=$_POST[$est1];
					$vector2[$b]=$_POST[$est2];
					$vector3[$b]=$_POST[$est3];
					$vector4[$b]=$_POST[$est4];
					$vector5[$b]=$_POST[$est5];
				}
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				$insertar=mysql_query("DELETE FROM com_proveedorproductos WHERE producto_id=$id");
				
				
				if(!$insertar)
				$error=1;
				
				for($b=1;$b<=$cantidad;$b++){ 
					
					$insertar=mysql_query("INSERT INTO com_proveedorproductos (direccion_id,cantidadcompra,valorantesiva,porcentajeiva_id,valordespuesiva,producto_id) VALUES ('$vector1[$b]','$vector2[$b]','$vector3[$b]','$vector4[$b]','$vector5[$b]','$id') ");


					if(!$insertar){
						$error=1;
					}
					
				}
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Proveedores Agregados con éxito";
				}
	
				
				 echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',3000);</script>"; 
			}else{
	
	
	?>
    
    
    
    <div id="divContenedorTabla">
		
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        	<table align="right">
             	<tr>
                <td>Iva Aplicar:</td>
                <td><input type="text" id="ivaactual" name="d" value="<?php echo (isset($iva_now))? $iva_now:'' ?>" readonly size="3"/></td>    
               </tr>
            </table>
			<table align="center" width="890">
				<thead>
					<tr>
						<th>Proveedor/Direccion</th>
						<th>Cantidad de Venta</th>
                        <th>Valor Base</th>
						<!--<th>% IVA</th>-->
                        <th>Valor Gravado</th>
                        <th width="22">&nbsp;</th>
					</tr>
				</thead>
                
				<tbody>
               
                <?php
                	if(count($arrid)==0){

					//Consulta ciudades, departamento
					$consulta1=mysql_query("SELECT Id,CONCAT_WS('-',depto,ciudad) as nombre FROM com_ciudad",$conexion);
					
					//Consulta proveedores
					$proveedores=mysql_query("SELECT com_direccionproveedor.Id as id,CONCAT_WS(', ',com_proveedores.nombre,com_direccionproveedor.direccion,com_ciudad.ciudad) as nombre
FROM com_direccionproveedor
LEFT JOIN com_proveedores ON com_proveedores.Id=com_direccionproveedor.proveedor_id
LEFT JOIN com_ciudad ON com_ciudad.Id=com_direccionproveedor.ciudad_id 
GROUP BY com_direccionproveedor.Id",$conexion);
				?>
                	
                	<tr>
						<td><select name="a1">
                        <?php
                        	while($prov_rs=mysql_fetch_assoc($proveedores)){
						?>
                        		<option value="<?php echo $prov_rs['id']; ?>"><?php echo $prov_rs['nombre']; ?></option>
                        <?php		
							}
                        ?>
                        </select></td>
						<td><input type="text" class="clsAnchoTotal" name="b1"></td>
						<td><input type="text" class="clsAnchoTotal" name="c1" id="preciosiniva1" onBlur="PrecioFinal(this,1)"></td>
                        <!--<td><input name="d1" type="text" value="<?php echo (isset($iva_now))? $iva_now:'' ?>" id="ivaactual1" size="3"/>                        </td>-->
                        <td><input type="text" class="clsAnchoTotal" name="e1" id="valorfinal1"></td>
                  		<td align="right"><input type="button" value="-" class="clsEliminarFila"></td>
					</tr>
                <?php
					}else{
			 			for($c=0;$c<count($arrid);$c++){
							$d=$c+1;
							
						//Consulta a proveedores ----------------------------//
						$proveedores=mysql_query("SELECT com_direccionproveedor.Id as id,CONCAT_WS(', ',com_proveedores.nombre,com_direccionproveedor.direccion,com_ciudad.ciudad) as nombre
FROM com_direccionproveedor
LEFT JOIN com_proveedores ON com_proveedores.Id=com_direccionproveedor.proveedor_id
LEFT JOIN com_ciudad ON com_ciudad.Id=com_direccionproveedor.ciudad_id 
GROUP BY com_direccionproveedor.Id",$conexion);
				?>
                		<tr>
							<td><select name="a<?php echo $d; ?>">
                        <?php
                        	while($prov_rs=mysql_fetch_assoc($proveedores)){
						?>
                        		<option value="<?php echo $prov_rs['id']; ?>" <?php echo ($prov_rs['id']==$arra[$c])? 'SELECTED':'';  ?> ><?php echo $prov_rs['nombre']; ?></option>
                        <?php		
							}
                        ?>
                        </select></td>
							<td><input type="text" class="clsAnchoTotal" name="b<?php echo $d; ?>" value="<?php echo (isset($arrb[$c]))? $arrb[$c]:'' ?>"></td>
							<td><input type="text" class="clsAnchoTotal" name="c<?php echo $d; ?>" value="<?php echo (isset($arrc[$c]))? $arrc[$c]:'' ?>" id="preciosiniva<?php echo $d; ?>" onBlur="PrecioFinal(this,<?php echo $d; ?>)" ></td>
                      		<!--<td><input name="d<?php echo $d; ?>" type="text" value="<?php echo (isset($arrd[$c]))? $arrd[$c]:'' ?>" id="ivaactual<?php echo $d;?>" size="3"/></td>-->
                            <td><input type="text" class="clsAnchoTotal" name="e<?php echo $d; ?>" value="<?php echo (isset($arre[$c]))? $arre[$c]:'' ?>" id="valorfinal<?php echo $d;?>"></td>
							<td align="right"><input type="button" value="-" class="clsEliminarFila"></td>
						</tr>	
				<?php
						}
					}
				?>		
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" align="right">
							<?php
						    if(empty($_GET['view'])){
							?>
							<input type="button" value="Agregar una fila" class="clsAgregarFila">
                            <input type="hidden" name="cantidad2" id="cantidad2" value="<?php echo ($d>0)? $d:'1'; ?>"/>
							 <input type="hidden" name="cantidad" id="cantidad" />
                            <input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>"/>
                            <input type="submit" value="Enviar" name="Guardar" />
							<?php
							}
							?>
							
                            <!--<input type="button" value="Clonar la tabla" class="clsClonarTabla">
							<input type="button" value="Eliminar la tabla" class="clsEliminarTabla">-->
						</td>
					</tr>
				</tfoot>
			</table>
			
			
		</form>
        
	</div>
    	<?php
			}
		?>
    <div style="clear:both">&nbsp;</div>
</div>
<script type="text/javascript" src="js/manipulacion1.js"></script>
</body>
</html>