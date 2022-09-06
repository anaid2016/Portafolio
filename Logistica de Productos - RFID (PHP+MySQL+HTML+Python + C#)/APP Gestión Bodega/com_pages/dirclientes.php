<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	

	//Creación de Arrays 
	$arrid=array();
	$arrprov=array();
	$arrdir=array();
	$arrtel=array();
	$arrmail=array();
	$arrcd=array();
	$arrsede=array();
	$d=0;
	if(!empty($_GET['Id'])){
				// Busqueda del proveedor
				$id=$_GET['Id'];
				$buscar=mysql_query("SELECT * FROM com_direccionclientes WHERE cliente_id='$id'",$conexion);
				while($resultado=mysql_fetch_assoc($buscar)){
					array_push($arrid,$resultado['Id']);	
					array_push($arrprov,$resultado['cliente_id']);
					array_push($arrdir,$resultado['direccion']);
					array_push($arrtel,$resultado['telefono']);
					//array_push($arrmail,$resultado['email']);
					array_push($arrcd,$resultado['ciudad_id']);
					array_push($arrsede,$resultado['sede']);
				}
	}
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Clientes</title>
<link rel="stylesheet" type="text/css" href="../css/menuinterno.css">
<link rel="stylesheet" type="text/css" href="../css/popupcss.css">
<script> 
 function Cerrar(Id){
	location.href = '?Id='+Id;
 }

 function Cerrar2(){
	opener.location.href = "../acceso.php?com_pg=6";
    window.close();
  }
</script>
</head>

<body>
<?php
	if(empty($_GET['view'])){
		$enlace="agclientes.php";
	}else{
		$enlace="delclientes.php";
	}
?>
	<!--Menu de Solapas -->
	<div id="tabsI">
    	 <ul>
            <li><a href="<?php echo (!empty($_GET['Id']))? $enlace.'?Id='.$_GET['Id']:'' ?>" title="Datos"><span>Datos Generales</span></a></li>
            <li><a href="<?php echo (!empty($_GET['Id']))? 'delclientes.php?Id='.$_GET['Id']:'' ?>" title="Direcciones"><span>Direcciones</span></a></li>
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
					$est4='d'.$b;
					//$est5='e'.$b;
				
				
					$vector1[$b]=$_POST[$est1];
					$vector2[$b]=$_POST[$est2];
					$vector3[$b]=$_POST[$est3];
					$vector4[$b]=$_POST[$est4];
				}
				
				$insertar=mysql_query("DELETE FROM com_direccionclientes WHERE cliente_id=$id",$conexion);
				
				for($b=1;$b<=$cantidad;$b++){
					$insertar=mysql_query("INSERT INTO com_direccionclientes SET cliente_id='$id',direccion='$vector2[$b]',telefono='$vector3[$b]',ciudad_id='$vector4[$b]',sede='$vector1[$b]'",$conexion);
					
				}
	
				if(mysql_errno($conexion)==0){
                        echo "<p>Direcciones Agregadas con Exito</p>";
                }else{
                    if(mysql_errno($conexion)==1062){
                        echo "<p>La dirección ya esta asignada a otro cliente.</p>";
                        die();
                    }else{
                        $numerror=mysql_errno($conexion);
                        $descrerror=mysql_error($conexion);
                        echo "se ha producido un erro no. $numerror que corresponde a:$descrerror <br>";
                        die();
                    }
                }
				
				 echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',3000);</script>"; 
			}else{
	
	
	?>
    
    
    
    <div id="divContenedorTabla">

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table align="center" width="700">
				<thead>
					<tr>
						<th>Nombre de la Sede</th>
						<th>Dirección</th>
						<th>Teléfono</th>
                        <th>Ciudad</th>
                        <th width="22">&nbsp;</th>
					</tr>
				</thead>
                
				<tbody>
                <?php
                	if(count($arrid)==0){

					//Consulta ciudades, departamento
					$consulta1=mysql_query("SELECT Id,CONCAT_WS('-',depto,ciudad) as nombre FROM com_ciudad",$conexion);
				?>
                	<tr>
						<td><input type="text" class="clsAnchoTotal" name="a1"></td>
						<td><input type="text" class="clsAnchoTotal" name="b1"></td>
						<td><input type="text" class="clsAnchoTotal" name="c1"></td>
                        <td><select name="d1">
                        	<?php
							while($resultado1=mysql_fetch_assoc($consulta1)){
							?>
                            	<option value="<?php echo $resultado1['Id']; ?>"><?php echo $resultado1['nombre']; ?></option>
                            <?php
							}
							?>
                        </select></td>
						<td align="right"><input type="button" value="-" class="clsEliminarFila"></td>
					</tr>
                <?php
					}else{
			 			for($c=0;$c<count($arrid);$c++){
							$d=$c+1;
				?>
                		<tr>
							<td><input type="text" class="clsAnchoTotal" name="a<?php echo $d; ?>" value="<?php echo (isset($arrsede[$c]))? $arrsede[$c]:'' ?>"></td>
							<td><input type="text" class="clsAnchoTotal" name="b<?php echo $d; ?>" value="<?php echo (isset($arrdir[$c]))? $arrdir[$c]:'' ?>"></td>
							<td><input type="text" class="clsAnchoTotal" name="c<?php echo $d; ?>" value="<?php echo (isset($arrtel[$c]))? $arrtel[$c]:'' ?>"></td>
                      		<td><select name="d<?php echo $d; ?>">
                        	<?php
							//Consulta ciudades, departamento
							$consulta1=mysql_query("SELECT Id,CONCAT_WS('-',depto,ciudad) as nombre FROM com_ciudad",$conexion);
							while($resultado1=mysql_fetch_assoc($consulta1)){
							?>
                            	<option value="<?php echo $resultado1['Id']; ?>" <?php echo ($resultado1['Id']==$arrcd[$c])? 'SELECTED':'';  ?> ><?php echo $resultado1['nombre']; ?></option>
                            <?php
							}
							?>
                      		</select></td>
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/manipulacion.js"></script>
</body>
</html>