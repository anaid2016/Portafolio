<?php include("../funciones/seguridad.php"); ?>
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


function ubicaciones(ttotales){
	
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
	$arrid=array();
	$arra=array();
	$arrb=array();
	$arrc=array();
	$arrd=array();
	$arre=array();
	$arrf=array();
	$arrg=array();
	$arrh=array();
	$arri=array();
	$arrj=array();
	$arrk=array();
	$arrl=array();
	$arrp=array();
	$arro=array();
	$arrz=array();
	$arrw=array();
	$arrin=array();
	$RFIDS='';
	
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
				$bproductos=mysql_query("SELECT com_inventario.*,com_productos.nombre as producto, com_productos.codbarras,com_productosorden.fecharecibido,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as verificador,com_unidades.nombre as unidad,com_movimientosproductos.Id as existe,
CONCAT_WS('',com_arraybodega.columna,com_arraybodega.fila) as ubicacion,com_arraybodega.Id as idubicacion,com_tipoproducto.Id as tipoproducto,
GROUP_CONCAT(DISTINCT com_areas_almacenamiento.Id) as areas,com_tipoproducto.capacidad as capunidad,GROUP_CONCAT(com_compatible.tipo_incompatibles) as incompatibles,
GROUP_CONCAT(DISTINCT com_tipoproducto.iteracion_id) as organizar
FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_productosorden ON com_productosorden.Id=com_inventario.lineaoc_id
LEFT JOIN com_usconect ON com_usconect.Id=com_inventario.verificado_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
LEFT JOIN com_movimientosproductos ON com_movimientosproductos.inventario_id=com_inventario.Id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
LEFT JOIN com_tipoproducto ON com_tipoproducto.Id=com_productos.tipoproducto_id
LEFT JOIN com_tipo_areas ON com_tipo_areas.tipo_id=com_tipoproducto.Id
LEFT JOIN com_areas_almacenamiento ON com_areas_almacenamiento.Id=com_tipo_areas.area_id
LEFT JOIN com_compatible ON com_tipoproducto.Id=com_compatible.tipo_id
LEFT JOIN com_organizacion ON com_tipoproducto.iteracion_id=com_organizacion.Id
WHERE com_productosorden.orden_id='$id' and com_inventario.estado!='0' GROUP BY RFID",$conexion);

			while($resultado=mysql_fetch_assoc($bproductos)){
				
					$indicep=$resultado['codbarras'];
					
					$v_producto[$indicep]["tipo"]=$resultado['tipoproducto'];
					$v_producto[$indicep]["capunidad"]=$resultado['capunidad'];
					$v_producto[$indicep]["area"]=$resultado['areas'];
					
					
				
					array_push($arrid,$resultado['Id']);				//Id de la linea de inventario
					array_push($arra,$resultado['fechaverificado']);		//Id del producto
					array_push($arrb,$resultado['RFID']);				//Codigo RFID
					array_push($arrc,$resultado['cantidad']);			//Cantidad Actual del Rollo
					array_push($arrd,$resultado['estado']);				//Estado Actual
					array_push($arre,$resultado['lineaoc_id']);			//Linea de la Orden Compra
					array_push($arrf,$resultado['cantidad_entrada']);	//Cantidad de Entrada
					array_push($arrg,$resultado['verificado_id']);		//Id del usuario que realiza la verificacion en proceso
					array_push($arrh,$resultado['producto']);			//producto 
					array_push($arri,$resultado['codbarras']);			//codigo de barras
					array_push($arrj,$resultado['unidad']);				//Fecha enl a que se recibio la Orden de Compra
					array_push($arrp,$resultado['ubicacion']);			//ubicacion en bodega
					array_push($arrk,$resultado['idubicacion']);		//ubicacion en bodega
					array_push($arro,$resultado['areas']);				//Area de ubicacion "Autoapilable u otra"
					array_push($arrz,$resultado['capunidad']);			//Capacidad de ubicación unitaria
					if (isset($resultado['incompatibles'])){
						 array_push($arrin,$resultado['incompatibles']);			//Tipos de Productos Incompatibles
					}else{
						 array_push($arrin,"ne");
					}

					array_push($arrw,"");
					$RFIDS.=$resultado['RFID'].",";
			}
			$RFIDS=substr($RFIDS,0,-1);		//Retira la ultima coma de rfids
			
			
			//1: Cajoneras existentes
			
			
			$b_bodegas=mysql_query("SELECT com_arraybodega.Id,com_arraybodega.nombre,com_areas_almacenamiento.Id as area FROM com_arraybodega
LEFT JOIN com_areas_almacenamiento ON com_areas_almacenamiento.Id=com_arraybodega.areas_almacenamiento_id",$conexion);
			
			$c_cajoneras=array();
			$are_cajonera=array();
						
			while($resultado=mysql_fetch_assoc($b_bodegas)){
				
				$indice=$resultado["Id"];
				$indice2=$resultado["area"];
				
				$c_cajoneras[$indice]["nombre"]=$resultado["nombre"];
				$c_cajoneras[$indice]["area"]=$resultado["area"];
				$c_cajoneras[$indice]["ocupada"]=0;
				$c_cajoneras[$indice]["rollos"]=0;
				
				
				$are_cajonera[$indice2]=(!isset($are_cajonera[$indice2]))?  $indice : $are_cajonera[$indice2].",".$indice;	//Cajoneras asociadas a un area en especifico Ej: Cajones del area autoapilable
				
			}
			

			//2: Ocupacion de las cajoneras productos por cajonera
			
			$b_bodegas=mysql_query("SELECT com_productos.codbarras as producto,count(RFID) as rollos,
com_arraybodega.Id as nombre,com_areas_almacenamiento.Id as tipo_cajonera,com_tipoproducto.capacidad as capunidad,
(com_tipoproducto.capacidad*count(RFID)) as ocupado,com_tipoproducto.Id as tiposprod,com_arraybodega.fila as nivel FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id
LEFT JOIN com_bodega ON com_bodega.Id=com_arraybodega.bodega_id
LEFT JOIN com_areas_almacenamiento ON com_areas_almacenamiento.Id=com_arraybodega.areas_almacenamiento_id
LEFT JOIN com_tipoproducto ON com_tipoproducto.Id=com_productos.tipoproducto_id
WHERE existencia='0' and fechasalida is null and arraybodega_id is not null GROUP BY com_arraybodega.Id,com_productos.Id ORDER BY com_arraybodega.pasillo,com_arraybodega.columna",$conexion);

			while($resultado=mysql_fetch_assoc($b_bodegas)){
				
				$indice=$resultado["nombre"];
				
				
				$c_cajoneras[$indice]["producto"]=(!isset($c_cajoneras[$indice]["producto"]))?  $resultado["producto"] : $c_cajoneras[$indice]["producto"].",".$resultado["producto"];		//Productos actualmente en la cajonera
				
				$c_cajoneras[$indice]["rollos"]=(!isset($c_cajoneras[$indice]["rollos"]))? $resultado["rollos"] : $c_cajoneras[$indice]["producto"]+$resultado["rollos"];	//Cantidad de rollos en la cajonera
				
				$c_cajoneras[$indice]["ocupada"]=$c_cajoneras[$indice]["ocupada"]+$resultado["ocupado"];	//Cantidad de rollos en la cajonera
				$c_cajoneras[$indice]["tiposprod"]=(!isset($c_cajoneras[$indice]["tiposprod"]))?  $resultado["tiposprod"] : $c_cajoneras[$indice]["tiposprod"].",".$resultado["tiposprod"];	
			}
			
			//Buscando en donde meter el producto asociado
			
			
			for($a=0;$a<count($arri);$a++){
				
				$indi_producto=$arri[$a];		//Codigo de barras del producto
				$indi_espacio=$arrz[$a];		//Espacio en porcentaje que ocupa en la cajonera
				$indi_areas=explode(",",$arro[$a]);		//Area a la que esta asignada el producto
				$indi_incompatible=$arrin[$a];
				
				$cajoneras_del_area="";
				$bandera=0;
				
				 
				for($c=0;$c<count($indi_areas);$c++){
					$ad_areas=$indi_areas[$c];			//Area a la que pertenece el producto
					
					//Busqueda de cajoneras que pertenezcan a esa Area		
					if(isset($are_cajonera[$ad_areas])){		
						
						$vacias=explode(",",$are_cajonera[$ad_areas]);		//Vector que separa las cajoneras del area
						
						
						//Se busca si existe una cajonera con el producto actual y con espacio ----------------------------//
						for($d=0;$d<count($vacias);$d++){
							
							$indi_cajonera=$vacias[$d];						//Cajonera de 1 - infi
							$producto_existe=(isset($c_cajoneras[$indi_cajonera]["producto"]))? $c_cajoneras[$indi_cajonera]["producto"]:'';
							$string_caj_prod=strstr($producto_existe, $indi_producto, true);	//String que contiene los productos en la cajonera

							//Se verifica si el rollo cabe en la cajonera
							if((100-$c_cajoneras[$indi_cajonera]["ocupada"])>=$indi_espacio and $string_caj_prod!=""){		
								
								$arrw[$a]=$indi_cajonera;
								$c_cajoneras[$indi_cajonera]["ocupada"]=$c_cajoneras[$indi_cajonera]["ocupada"]+$indi_espacio;
								$bandera=1;
								
								//echo  "1--".$indi_producto."--".$c_cajoneras[$indi_cajonera]["ocupada"]."--".$indi_espacio."<br/>";
								break;
							}
						}
						
						
						//Si la bandera no ha cambiado entonces se debe buscar otra cajonera para ubicar  ----------------------------//
						if($bandera==0){
						
							for($d=0;$d<count($vacias);$d++){
							
							$indi_cajonera=$vacias[$d];						//Cajonera de 1 - infi
							
							//Verificando si tiene productos incompatibles ----------------------------------------------------//
							$cajon_tipo=(isset($c_cajoneras[$indi_cajonera]["tiposprod"]))? $c_cajoneras[$indi_cajonera]["tiposprod"]:"PRUEBA";	
							$string_tipos=strstr($cajon_tipo, $indi_incompatible, true);
							
						
								//Se verifica si el rollo cabe en la cajonera
								if((100-$c_cajoneras[$indi_cajonera]["ocupada"])>=$indi_espacio && $string_tipos==""){		
									
									$arrw[$a]=$indi_cajonera;
									$c_cajoneras[$indi_cajonera]["ocupada"]=$c_cajoneras[$indi_cajonera]["ocupada"]+$indi_espacio;
									$bandera=1;
									
									//echo  "2--".$indi_producto."--"."---".$indi_incompatible."--".$cajon_tipo."---".$c_cajoneras[$indi_cajonera]["ocupada"]."--".$indi_espacio."<br/>";
									break;
								}
							}
							
						}
					}
					
					
					//Si ya se tiene cajonera para ubicarla nos salimos del for -----------------------------------//
					if($arrw[$a]!=""){
						break;
					}
				}
				
				$valor=$arrw[$a];
				//echo $valor."<br/>";
			}

			
	}
	
	
	$tpwindow="Asignar en Bodega ";	
	$productostt=count($arrid);
	
?>

<div id="contenidof2">
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
					
					$est1='k'.$b;		//ubicacion del producto
					$est3='l'.$b;		//numero linea de Inventario	---------------SI
					$est4='p'.$b;		//id de ubicacion en bodega
					
					$vector1[$b]=$_POST[$est3];		//numero linea de Inventario
					$vector2[$b]=$_POST[$est1];		//Ubicacion del producto	
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
                        <td>
                        <!--<input type="button" onclick="ubicaciones('<?php echo $productostt; ?>')" name="btn1" id="btn1" value="Escanear" />-->
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
										opdireccionproveedor($conexion);
									}else{
										opdireccionproveedorsel($conexion,$provdireccion);	
									}
								?>
                       	  	</select>
                       	 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                   </tr>
                    <tr>
                   		<td colspan="5" align="right">&nbsp;</td>
                   </tr> 
                  
              </table>	
              
              <br/>
              <br/>
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
			 			for($c=0;$c<count($arrid);$c++){
							$d=$c+1;
				?>
                	<tr id="linea<?php echo $d; ?>">
                      <td width="140">
                        <input type="hidden" class="clsAnchoTotal"  name="l<?php echo $d; ?>" id="cl<?php echo $d; ?>" size="5" value="<?php echo $arrid[$c]; ?>" /><!--Id de la linea en inventario-->           <input type="hidden" class="clsAnchoTotal"  name="q<?php echo $d; ?>" id="cq<?php echo $d; ?>" size="5" value="<?php echo $arre[$c]; ?>" /><!--Id de la linea en productosorden-->         
                               
                        <input type="text" readonly="readonly" name="a<?php echo $d; ?>" id="cb<?php echo $d; ?>" size="10" value="<?php echo $arri[$c]; ?>" class="small"/><!--codigo de barras-->
                        <!--<input type="button" value="AP" onclick="ventana('<?php echo $d; ?>')"  style="display:inline" disabled="disabled" id="btnap<?php echo $d; ?>"  />-->
                      </td>
                      <td><input type="text" class="clsAnchoTotal"  readonly="readonly" name="c<?php echo $d; ?>"  id="cc<?php echo $d; ?>" value="<?php echo $arrh[$c]; ?>"/></td>
                      <td><input type="text" class="clsAnchoTotal"   name="m<?php echo $d; ?>"  id="cm<?php echo $d; ?>" value="<?php echo $arrb[$c]; ?>" readonly="readonly"/></td><!--RFID-->
                      <td><input type="text" class="clsAnchoTotal"   name="n<?php echo $d; ?>"  id="cn<?php echo $d; ?>" value="<?php echo $arrc[$c]." ".$arrj[$c]; ?>" readonly="readonly"/></td><!--cantidad-->
                      <td>
                      	<!--<input type="text" class="clsAnchoTotal"   name="k<?php echo $d; ?>"  id="ck<?php echo $d; ?>" value="<?php echo $arrk[$c]; ?>" />
                        <input type="hidden" class="clsAnchoTotal"   name="p<?php echo $d; ?>"  id="cp<?php echo $d; ?>" value="<?php echo $arrp[$c]; ?>" />-->
						<select  name="p<?php echo $d; ?>"  id="cp<?php echo $d; ?>">
							<?php
							    
                                opcionesseleccionador($conexion,"com_arraybodega","Id","nombre",$arrw[$c],"")
                            ?>
						</select>
						</td><!--Ubicacion-->
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