<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	$id='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Productos</title>
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>
<script language="javascript" src="../funciones/jquery-1.2.6.min.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script> 
 function Cerrar(){
	opener.location.href = "../acceso.php?com_pg=1";
    window.close();
}
</script>
<script language="javascript">
$(document).ready(function(){
	// Parametros para e combo1
   $("#bodega").change(function () {
	    mostrar="../funciones/arr_bodega.php";
	    document.getElementById('bodarray').style.display = "inline";
		document.getElementById('bodarray2').style.display = "none";
		$("#bodega option:selected").each(function () {
			alert($(this).val());
				elegido=$(this).val();
				$.post(mostrar, { elegido: elegido }, function(data){
				$("#bodarray").html(data);
			});			
        });
   })

});
</script>


<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenidof">
    	<h2> >> Agregar Producto</h2>
			<?php
			
			//Producto a Modificar ----------------------------------------------------------------//
			if(!empty($_GET['Id'])){
				$id=$_GET['Id'];
				$bproducto=mysql_query("SELECT com_productos.Id,com_productos.lineaproducto_id,com_productos.nombre,com_productos.codbarras,com_productos.fechacreacion,com_productos.fechaeliminacion,com_productos.usuario_mod,com_productos.unidadproducto_id,com_preciosclientes.porcentajeiva,com_preciosclientes.preciosantesiva,com_productos.tipoproducto_id,precio_compra,color_id,talla_id,com_productos.fechamodificado
FROM com_productos 
LEFT JOIN com_preciosclientes ON com_preciosclientes.producto_id=com_productos.Id
WHERE com_productos.Id='$id'",$conexion);
				$dataprod=mysql_fetch_row($bproducto);
			
				
			}
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
			
				$v1=$_POST['nm_producto'];
				//$v2=$_POST['codbarras'];
				$v3=$_POST['linea'];
				$v4=$_POST['unidad'];
				//$v5=$_POST['bodega2'];
				//$v6=(!empty($_POST['bdarray1']) and $_POST['bdarray1']!='')? $_POST['bdarray1']:$_POST['bdarray2'];
				$v7=$_POST['date1'];
				$v8=$_POST['date2'];
				$v9=$_SESSION['user'];
				$v10=$_POST['precio'];
				$v11=gmdate('Y-m-d');
				//$v12=$_POST['iva'];
				//$v13=$v10+(($v10*$v12)/100);
				$v14=$_POST['tipo_id'];
				$v15=$_POST['color'];
				$v16=$_POST['talla'];
				$id=$_POST['Id'];
					
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
		
				if($id==''){
					$insertar=mysql_query("INSERT INTO com_productos SET lineaproducto_id='$v3',nombre='$v1',fechacreacion='$v7',usuario_mod='$iduser',unidadproducto_id='$v4',tipoproducto_id='$v14',color_id='$v15',talla_id='$v16' ");
					
				}else{
					$insertar=mysql_query("UPDATE com_productos SET lineaproducto_id='$v3',nombre='$v1',fechacreacion='$v7',usuario_mod='$iduser',unidadproducto_id='$v4',tipoproducto_id='$v14',color_id='$v15',talla_id='$v16',codbarras=NULL WHERE Id='$id' ");
				}
				if(!$insertar)
				$error=1;
				//echo "1:".$error;
				
								
			
				//Agregando precio al listado de precios --------------------------------------------
				//1. Busca la linea creada anteriormente asociada al producto para el precio
				
				$busprecio=mysql_query("SELECT max(Id) FROM com_productos");		
				$dataid=mysql_fetch_row($busprecio);
				if(!$busprecio)
				$error=1;
				//echo "Error 2:".$error;
				
				if($id==''){
					$insertar=mysql_query("UPDATE com_preciosclientes SET preciosantesiva='$v10',porcentajeiva='0',precioconiva='$v10',fechamodificado='$v11',usuario_id='$iduser' WHERE producto_id='$dataid[0]'");
				}else{
					$insertar=mysql_query("UPDATE com_preciosclientes SET preciosantesiva='$v10',porcentajeiva='0',precioconiva='$v10',fechamodificado='$v11',usuario_id='$iduser' WHERE producto_id='$id'");
				
				}
				
				if(!$insertar)
				$error=1;
				//echo "Error 3:".$error;
				
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Producto Agregado con Exito";
				}
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
				 
			}else{
               
           
            ?>
            <p>Diligencie el formulario en su totalidad y de clic en Guardar:</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="other">
				<table class="formularioprod" border="0">
				<tr>
                    	<td width="40%" class="titulos2" >Nombre del Producto</td>
                        <td>
               			  <span id="spryselect3">
                        			<select name="nm_producto" id="nm_producto">
                      			  		<?php
											if(empty($dataprod[2])){
												opciones($conexion,"com_nombres","Id","nombre","");
											}else{
												opcionesseleccionador($conexion,"com_nombres","Id","nombre",$dataprod[2],"");
											}
											?>
                                    
                                    </select>
                        			<span class="selectRequiredMsg">Seleccione un elemento.</span></span> 
                        </td>
                        <td class="titulos2">Genero:</td>
                        <td ><span id="spryselect1">
                          	<select name="linea" id="linea">
                          		<?php
								if(empty($dataprod[1])){
									opciones($conexion,"com_lineaproducto","Id","nombre","");
								}else{
									opcionesseleccionador($conexion,"com_lineaproducto","Id","nombre",$dataprod[1],"");
								}
								?>
                            </select>
                          	<span class="selectRequiredMsg">Seleccione un elemento.</span></span> 
                  </td>
                         <td class="titulos2">Tipo Producto:</td>
                         <td>
                       	   <select name="tipo_id" id="tipo_id">
                         		<?php
								if(empty($dataprod[10])){
									opciones($conexion,"com_tipoproducto","Id","nombre","");
								}else{
									opcionesseleccionador($conexion,"com_tipoproducto","Id","nombre",$dataprod[10],"");
								}
								?>	
                         	</select>
                         </td>                      
                        
               </tr>
               <tr>
               			<td class="titulos2">Color:</td>
                         <td><span id="spryselect4">
                           <select name="color" id="color">
                           	<?php
								if(empty($dataprod[12])){
									opciones($conexion,"com_color","Id","nombre","");
								}else{
									opcionesseleccionador($conexion,"com_color","Id","nombre",$dataprod[12],"");
								}
								?>	
                           </select>
                           <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                         </td> 
               
               			<td class="titulos2">Talla:</td>
                        <td>
                          <span id="spryselect5">
                          <select name="talla" id="talla">
         
                           	<?php
								if(empty($dataprod[13])){
									opciones($conexion,"com_tallas","Id","talla","");
								}else{
									opcionesseleccionador($conexion,"com_tallas","Id","talla",$dataprod[13],"");
								}
								?>	
                          </select>
                        <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td> 
                 <td class="titulos2">Codigo de Barras</td>
                        <td colspan="5">
                          	<?php echo (!empty($dataprod[2]))?  $dataprod[3]:''; ?>
                        </td>
              	</tr>
                <tr>
                   		 
                         
                  <td class="titulos2">Precio Compra:</td>
                         <td><?php echo (!empty($dataprod[11]))?  $dataprod[11]:'NA'; ?></td>
                </tr>
            </table>      


            
            	<table class="formularioprod" border="0">
            		<tr>      
                       <td class="titulos2">Unidad:</td>
                       <td width="40px"><span id="spryselect2">
                         	<label for="unidad"></label>
                         	<select name="unidad" id="unidad">
                            	<?php
									if(empty($dataprod[7])){
										opciones($conexion,"com_unidades","Id","nombre","");
									}else{
										opcionesseleccionador($conexion,"com_unidades","Id","nombre",$dataprod[7],"");
									}
								?>
                       	  	</select>
                       	 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                        <!--<td align="right" class="titulos2">IVA (%):</td>-->
                        <!--/*<td width="90px">
                        	<select name="iva">
                        		<option value=""></option>
				 				<option value="8" <?php echo (!empty($dataprod[8]) && $dataprod[8]==8)? 'SELECTED':'' ?> >8%</option>
				 				<option value="10" <?php echo (!empty($dataprod[8]) && $dataprod[8]==10)? 'SELECTED':'' ?>>10%</option>
				 				<option value="16" <?php echo (!empty($dataprod[8]) && $dataprod[8]==16)? 'SELECTED':'' ?>>16%</option>
				 				<option value="20" <?php echo (!empty($dataprod[8]) && $dataprod[8]==20)? 'SELECTED':'' ?>>20%</option>
							</select>
                         </td>*/-->
                         <td width="120px" class="titulos2">Precio(m,pares):</td>
                         <td width="240px"><input type="number" name="precio" class="lineas" value="<?php echo (!empty($dataprod[9]))?  $dataprod[9]:''; ?>"/></td>
                   </tr>
                   
                   
                   
                  </table>
                  
                  <table class="formularioprod">
                  <tr>
                   		<td class="titulos2">Creado:</td>
                        <td width="120px"><input type="date" value="<?php echo (!empty($dataprod[4]))?  $dataprod[4]:gmdate('Y-m-d'); ?>"  name="date1" readonly="readonly"/></td>
                        <td class="titulos2">Eliminado:</td>
                        <td width="120px"><input type="date" value="<?php echo (!empty($dataprod[5]))?  $dataprod[5]:''; ?>" name="date2"  readonly="readonly"/> </td>
                        <td class="titulos2">Modificado:</td>
                        <td width="120px"><input type="date" value="<?php echo (!empty($dataprod[14]))?  $dataprod[14]:''; ?>" name="date3" readonly="readonly" /> </td>
                  </tr>
                  <tr>
                   		<td colspan="3" align="right">
                        	<input type="submit" value="Guardar Producto" name="Guardar" />
                        	<input type="hidden" name="Id" value="<?php echo (!empty($_GET['id']) || $id!='')? $id:''; ?>" />
                        </td>
                        <td colspan="3"><input type="button" value="Cerrar" onclick="Cerrar()" /></td>
                   </tr>
                   
                
              </table>	
  </form>

  <?php
			}
			
			?>
</div>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");
</script>
</body>
</html>