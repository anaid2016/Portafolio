<?php 
	include("../funciones/seguridad.php"); 
	include("../funciones/comx_dbconn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Orden de Compra</title>
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script> 
 function Cerrar(){
	opener.location.href = "../acceso.php?com_pg=9";
    window.close();
}


/*function ubicaciones(ttotales){
	
 	var codigorecibido=new Array("A1");
	var codigorecibidoID=new Array("1");
	var q=0;
	for(var i=0;i<ttotales;i++){
		q=q+1;
		//document.getElementById('ck'+q).value="A1";
		//document.getElementById('cp'+q).value="1";
	}
	
	var boton=document.getElementById('Guardar')
	if(q==ttotales){
		boton.disabled=false;
	}
	
 }
*/
</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	
	//Creación de Arrays 
	$arr1=array();
	$arr2=array();
	$arr3=array();
	$arr4=array();
	$arr5=array();
	$arr6=array();
	$arr7=array();
	$arr8=array();
	$arr9=array();
	$arr11=array();
	$arr13=array();
	$RFIDS='';
	$PROD="";
	
	//Creacion de variables fijas
	$noorden="";
	$fechasolicitud=gmdate("Y-m-d");
	$fechacierre="";
	$provdireccion="";
	$totalsiniva=0;
	$totaliva=0;
	$totalconiva=0;
	$usercreo="";
	$userid="";
	$estado="";
	$estadoid="";
	
	$d=0;
	$id='';
	if(!empty($_GET['orden'])){
		
				// Busqueda del proveedor
				$id=$_GET['orden'];
				$buscar=mysql_query("SELECT com_ordencompra.*,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as creado,com_estadooc.nombre FROM com_ordencompra 
LEFT JOIN com_usconect ON com_usconect.Id=com_ordencompra.usuario_id
LEFT JOIN com_estadooc ON com_estadooc.Id=com_ordencompra.estado_id WHERE com_ordencompra.Id='$id'",$conexion);

				while($resultado=mysql_fetch_assoc($buscar)){
					$noorden=$resultado['noorden'];
					$fechasolicitud=$resultado['fechasolicitud'];
					$fechacierre=($resultado['fecharecibido']!='0000-00-00')? $resultado['fecharecibido']:gmdate('Y-m-d');
					$provdireccion=$resultado['direccionproveedor_id'];
					$totalsiniva=$resultado['totalantesiva'];
					$totaliva=$resultado['totaliva'];
					$totalconiva=$resultado['totalconiva'];
					$userid=$resultado['usuario_id'];
					$estadoid=$resultado['estado_id'];
					$usercreo=$resultado['creado'];
					$estado=$resultado['nombre'];
				}
				
				
							
				//Orden de Compra e Estado de Revision o con productos pendientes ----------------------
				if($estadoid<5){
					echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
					die('La orden de Compra no ha sido Revisada, hasta que el procedimiento de revision no se realice no es posible Verificar Productos');						
				}
				
				//Busqueda de los producto asociados a una orden de compra existente
			$query="SELECT com_inventario.Id,
	com_productos.codbarras,
	CONCAT(
		com_nombres.nombre,
		' ',
		com_tipoproducto.nombre,
		' ',
		com_tallas.talla,
		' ',
		com_color.nombre
	) AS nombrep,
	com_inventario.RFID,
	com_inventario.cantidad_entrada,
	com_lineaproducto.Id as linea,
	com_tallas.Id as talla,
	com_productos.Id as producto
FROM
	com_inventario
LEFT JOIN com_productos ON com_productos.Id = com_inventario.producto_id
LEFT JOIN com_productosorden ON com_productosorden.Id = com_inventario.lineaoc_id
LEFT JOIN com_lineaproducto ON com_lineaproducto.Id = com_productos.lineaproducto_id
LEFT JOIN com_nombres ON com_nombres.Id = com_productos.nombre
LEFT JOIN com_tipoproducto ON com_tipoproducto.Id = com_productos.tipoproducto_id
LEFT JOIN com_tallas ON com_tallas.Id = com_productos.talla_id
LEFT JOIN com_color ON com_color.Id = com_productos.color_id
WHERE
	com_productosorden.orden_id = '$id'
AND com_productosorden.estado_id = '7'
GROUP BY
	RFID ORDER BY producto_id ASC";
		$bproductos=mysql_query($query,$conexion);
		
		
			while($resultado=mysql_fetch_assoc($bproductos)){
				
					$indice=$resultado['RFID'];
					$arr1[$indice]=$resultado['Id'];
					$arr11[$indice]=$resultado['codbarras'];
					$arr2[$indice]=$resultado['nombrep'];
					$arr3[$indice]=$resultado['RFID'];
					$arr4[$indice]=$resultado['cantidad_entrada'];
					$arr5[$indice]=$resultado['linea'];
					$arr6[$indice]=$resultado['talla'];
					$arr10[$indice]=$resultado["producto"];
					$RFIDS.=$resultado['RFID'].",";
					$PROD.="'".$resultado['producto']."',";
					
			}
			$RFIDS=substr($RFIDS,0,-1);							//Retira la ultima coma de rfids
			$PROD=substr($PROD,0,-1);						//Retira la ultima coma de rfids
			
		
			//Estante que contienen el producto (producto::espacios::Id cajonera::nombre cajonera) ======================================
			$estante_select=estante_select($RFIDS,$PROD);
			$llave="";			
			if(!empty($estante_select)){							
				$arr8=explode(";;",$estante_select);				//Estantes que contienen los productos
						
				
				for($r=0;$r<count($arr8);$r++){						//Recorriendo resultados enviados por la bd, de cajoneras con productos
					$linear=explode("::",$arr8[$r]);
					
					for($e=0;$e<count($arr10);$e++){
						$llave=key($arr10);								//Llave trae el RFID del producto para nuevo vector============================
						if($arr10[$llave]==$linear[0] && $linear[1]>0){		//Si encuentra el producto en el vector de la consulta a la bd
							$linear[1]=$linear[1]-1;					//Descuenta 1 unidad del conteo de cantidad que se admiten en la cajonera
							$arr9[$llave]=$linear[2];					//Guarda ubicación en la cajonera
							$arr13[$llave]=$linear[3];
							unset($arr10[$llave]);						//Eliminando el producto del vector para evitar repeticiones
						}
					}
				}
			}
			
			//Buscando espacio para productos restantes =============================================================
			$extras="";
			$total=count($arr10);
			for($e=0;$e<$total;$e++){
				
				$llave=key($arr10);			
				$halladas=estantes_espacio($arr5[$llave],$arr6[$llave],$arr10[$llave],$extras);
						
				if(!empty($halladas)){
					$v_halladas=explode(";;",$halladas);		//Llega Id cajonera, nombre cajonera, espacio
					
					for($t=0;$t<count($v_halladas);$t++){
						$linea2=explode("::",$v_halladas[$t]);
						$estante=$linea2[0];
						$v_estante[$estante]=(!empty($v_estante[$estante]))? $v_estante[$estante]:0;
						
						if($linea2[2]>0 and $v_estante[$estante]<$linea2[2]){
							$linea2[2]=$linea2[2]-1;
							$arr9[$llave]=$linea2[0];
							$arr13[$llave]=$linea2[1];
							unset($arr10[$llave]);
							
							if($linea2[2]==0){					//Quitando de la consulta si ya el conteo llega a 0
								$extras=$linea2[0].",";
								$extras=substr($extras,0,-1);
							}
							$v_estante[$estante]=(!empty($v_estante[$estante]))? $v_estante[$estante]+1:1;	//Se empiezan a descontar de esta cajonera por si vuelve a aparecer
							break;
						}
					}
				}
			}
			
			//Para el resto si no hay mas en donde ubicar, si no hay espacio en la bodega
			$recepcion=estante_entrada();
			$v_halladas=explode(";;",$recepcion);		//Llega Id cajonera, nombre cajonera, espacio
				
			if(!empty($recepcion)){
				for($t=0;$t<count($v_halladas);$t++){
				  $linea2=explode("::",$v_halladas[$t]);
				  for($u=0;$u<$linea2[2];$u++){
					
					for($e=0;$e<count($arr10);$e++){
						$llave=key($arr10);	
					
						$linea2[2]=$linea2[2]-1;
						$arr9[$llave]=$linea2[0];
						$arr13[$llave]=$linea2[1];
						unset($arr10[$llave]);
						
					}
				  }
				}
			}
			
									
	}
	
	
	$tpwindow="Asignar en Bodega ";	
	
?>

<div id="contenidof4">
    	<h2> >> <?php echo $tpwindow; ?> Orden de Compra</h2>
			<?php
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
				$noverificadas=0;
				$id=$_POST['Id'];
				$hoy=gmdate('Y-m-d');
				
				/*Datos Basicos de la Orden de Compra*/
				$v2=$_POST['frecibido'];
				$cuantos=$_POST['cuantos'];
				
				if(!empty($_POST['Id'])){
					$id=$_POST['Id'];
				}
				
				$vector1=array();
				$vector2=array();
				$vector3=array();
				
				for($b=1;$b<=$cuantos;$b++){
					
					$est3='l'.$b;		//numero linea de Inventario	---------------SI
					$est4='p'.$b;		//id de ubicacion en bodega
					
					$vector1[$b]=$_POST[$est3];		//numero linea de Inventario
					$vector3[$b]=$_POST[$est4];
				}
				
									
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				
/*ACTUALIZA ORDEN DE COMPRA ---------------- ---------------------------------------------------------------------------------------------------------------------*/
				
				$insertar=mysql_query("UPDATE com_ordencompra SET estado_id='8' WHERE Id=$id");
				//echo "UPDATE com_ordencompra SET estado_id='8' WHERE Id=$id <br/>";
				
				if(!$insertar)
					$error=1;
				
				//echo "erro 1:".$error."<br/>";
					
				$insertar=mysql_query("UPDATE com_productosorden SET estado_id='8' WHERE orden_id='$id' ");
				//echo "UPDATE com_productosorden SET estado_id='8' WHERE orden_id='$id' <br/>";
					if(!$insertar)
					$error=1;
				
				//echo "erro 2:".$error."<br/>";
					
				
				

//ACTUALIZA DATOS EN COM_INVENTARIO Y CAMBIA ESTADO DE LA LINEA DE ORDEN DE COMPRA----------------------------------------------------------------------------//				 
				for($b=1;$b<=$cuantos;$b++){ 

						$insertar=mysql_query("UPDATE com_inventario SET arraybodega_id='$vector3[$b]' WHERE Id='$vector1[$b]'");
						//echo "UPDATE com_inventario SET arraybodega_id='$vector3[$b]' WHERE Id='$vector1[$b]' <br/>";
						if(!$insertar){
							$error=1;
						}
						//echo "erro 3:".$error."<br/>";
				}
					
				
/*ASGINA EL RESPONSABLE EN BODEGA -----------------------------------------------------------------------------------------------------------------------------*/

				if(!empty($_POST['responsable']) and $_POST['responsable']!=''){
					
					$responsable=$_POST['responsable'];
					$insertar=mysql_query("INSERT INTO com_responsablebodega SET orden_id='$id',user_id='$responsable',fechaasignada='$hoy' ");
					//echo "INSERT INTO com_responsablebodega SET orden_id='$id',user_id='$responsable',fechaasginada='$hoy' <br/> ";
					
						if(!$insertar)
						$error=1;
						//echo "erro 4:".$error."<br/>";
				}
					
				
				

/*REVISANDO ERRORES EN MYSQL --------------------------------------------------------------------------------------------------------------------------------------*/
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Asignada con éxito";
				}
				
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',2000);</script>"; 
			}else{
               

            ?>
            <p>Diligencie el formulario en su totalidad y de clic en Guardar:</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="other">
				<table width="900" class="formulario">
					<tr>
                    	<td width="90">No de Orden:</td>
                        <td width="149"><span id="sprytextfield1">
                          		<input type="text" name="noorden" id="noorden" readonly="readonly" value="<?php echo $noorden; ?>" />
                          		<span class="textfieldRequiredMsg">*</span></span>
                        </td>
                        <td width="6">&nbsp;</td>
                        <td width="140">Fecha Solicitud</td>
                        <td width="261"><span id="sprytextfield2">
                          	<input type="date" name="fsolicitud" id="fsolicitud" value="<?php echo $fechasolicitud; ?>" readonly="readonly"/>
                          	<span class="textfieldRequiredMsg">*</span></span>
                        </td>
                        <td>Responsable: 
                        
                        <select name="responsable">
							<?php
                                opciones($conexion,"com_usconect","Id","CONCAT_WS(' ',nombre,apellidos)","WHERE perfil_id='4' ")
                            ?>
                        </select>
                        
                        </td>
                      
                  </tr>
                  <tr>
                   		<td>Fecha Recibido</td>
                        <td><input type="date" name="frecibido" id="frecibido" readonly="readonly" value="<?php echo $fechacierre; ?>"/></td>
                         <td>&nbsp;</td>
                         <td colspan="3">Proveedor / Direccion:
                       	   <span id="spryselect2">
                         	<label for="direccion"></label>
                         	<select name="direccion" id="direccion" disabled="disabled">
                            	<?php
									if($id==''){
										opdireccionproveedor();
									}else{
										opdireccionproveedorsel($provdireccion);	
									}
								?>
                       	  	</select>
                       	 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                   </tr>
                    <tr>
                   		<td colspan="5" align="right">&nbsp;</td>
                   </tr> 
                  
              </table>	
              
         <div class="datagrid">
              <table class="ventanapop" cellspacing="0" cellpadding="0" width="1450">
                <thead>
                <tr>
                  <th>Cod.</th>
                  <th>Producto</th>
                  <th>RFID</th>
                  <th>Cnt/Und </th>
                  <th>Ubicación</th>
                </tr>
                </thead>
                <tbody>
              	 <?php
				 		$v_rfidsp=explode(",",$RFIDS);
			 			for($c=0;$c<count($v_rfidsp);$c++){
							$indice=$v_rfidsp[$c];
							$d=$c+1;
				?>
                	<tr id="linea<?php echo $d; ?>">
                      <td width="140">
                        <input type="hidden" class="small_2"  name="l<?php echo $d; ?>" id="cl<?php echo $d; ?>" size="5" value="<?php echo $arr1[$indice]; ?>" /><!--Id de la linea en inventario-->        	<input type="text" class="small_2"  name="d<?php echo $d; ?>" id="cd<?php echo $d; ?>" size="5" value="<?php echo $arr11[$indice]; ?>" /><!--codbarras producto--> 	
                      </td>
                      <td><input type="text" class="small_2"  readonly="readonly" name="c<?php echo $d; ?>"  id="cc<?php echo $d; ?>" value="<?php echo $arr2[$indice]; ?>"/></td>
                      <td><input type="text" class="small_2"   name="m<?php echo $d; ?>"  id="cm<?php echo $d; ?>" value="<?php echo $arr3[$indice]; ?>" readonly="readonly"/></td><!--RFID-->
                      <td><input type="text" class="small_2"   name="n<?php echo $d; ?>"  id="cn<?php echo $d; ?>" value="<?php echo $arr4[$indice]." Par" ?>" readonly="readonly"/></td><!--cantidad-->
                      <td>
					  
					  	<input type="hidden" class="small_2" name="p<?php echo $d; ?>"  id="cp<?php echo $d; ?>" value=" <?php echo (!empty($arr9[$indice]))? $arr9[$indice]:''; ?>" />
						<?php echo (!empty($arr13[$indice]))? $arr13[$indice]:''; ?>
  					  </td>
               		</tr>
                
                
                <?php
						}
						$nose=$d;
				?>	
                
                </tbody>
               <tfoot>
           		<tr>
						<td colspan="13" align="right">
							<?php
						    if(empty($_GET['view'])){
							?>
							<!--<input type="button" value="Agregar una fila" class="clsAgregarFila">-->
                            <input type="hidden" value="<?php echo $nose; ?>" name="cuantos" id="cuantos" />
							<input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>"/>
                            <input type="submit" value="Enviar" name="Guardar"  id="Guardar" />
							<?php
							}
							?>
						</td>
					</tr>
				</tfoot>
                </table>
            
           
           
       </div>  
       <br/>
       		<!--Totales de OC -->
           <table class="sinbordes" align="right" >
                            	<tr>
                                    <td>Total Base</td>
                                    <td><input type="text" value="<?php echo $totalsiniva; ?>" id="ttbase" readonly="readonly"/></td>
                                    <td>&nbsp;</td>
                                    <td>Total IVA</td>
                                    <td><input type="text" value="<?php echo $totaliva; ?>" id="ttiva" readonly="readonly"/></td>
                                    <td>&nbsp;</td>
                                    <td>Total Gravado</td>
                                    <td><input type="text" value="<?php echo $totalconiva; ?>" id="ttgravado" readonly="readonly"/></td>
                                </tr>
           </table>
       <br/>    
  </form>

  <?php
			}
			
			?>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<script type="text/javascript" src="js/manipulacion2.js"></script>
</body>
</html>