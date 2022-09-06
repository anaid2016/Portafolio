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
<title>Agregar Cajonera</title>
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>
<script language="javascript" src="../funciones/jquery-1.2.6.min.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script> 
 function Cerrar(){
	opener.location.href = "../acceso.php?com_pg=12";
    window.close();
}
</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenidof5">
    	<h2> >> Agregar Estante Bodega: </h2>
			<?php
			
			//Producto a Modificar ----------------------------------------------------------------//
			if(!empty($_GET['Id'])){
				$id=$_GET['Id'];
				$bproducto=mysql_query("SELECT com_arraybodega.* FROM com_arraybodega WHERE com_arraybodega.Id='$id'",$conexion);
				$dataprod=mysql_fetch_row($bproducto);
			
				
			}
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
			
				$v2=$_POST['pasillo'];
				$v3=$_POST['bodega'];
				$v4=$_POST['categoria'];
				$v5=$_POST['capacidad'];
				$v6=$_POST['nivel'];
				$v7=$_POST['talla'];
				$id=$_POST['Id'];
					
				//Consultando si ya existe una a esta cajonera pendiente -----//
				//$bpendiente=mysql_query("SELECT * FROM com_arraybodega	WHERE cajonera_id='$v2' and estado='1'",$conexion);
				//$existe=mysql_num_rows($bpendiente);

				
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				
				
				
				if($id==''){
					$insertar=mysql_query("INSERT INTO com_arraybodega SET areas_almacenamiento_id='$v3',estante='$v2',categoria_id='$v4',capacidad='$v5',nivel='$v6',talla_id='$v7' ");
				}else{
					$insertar=mysql_query("UPDATE com_arraybodega SET areas_almacenamiento_id='$v3',estante='$v2',categoria_id='$v4',capacidad='$v5',nivel='$v6',talla_id='$v7' WHERE Id='$id' ");
				}
				if(!$insertar)
				$error=1;
				//echo "1:".$error;
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios, Compruebe que la Cajonera no exista";
				} else {
					mysql_query("COMMIT");
					echo "Cajonera Agregada con Exito";
				}
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
				 
			}else{
               
           
            ?>
            <p>Diligencie el formulario en su totalidad y de clic en Crear una Cajonera:</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="other">
				<table class="formularioprod">
				<tr>
                    	<td width="30%">Nombre (Ej: E1-1)</td>
                        <td colspan="3"><?php echo (!empty($dataprod[1]))? $dataprod[1]:''; ?>                  
                        </td>
               </tr>
               <tr>
                        <td>Estante: </td>
                        <td colspan="3"> <span id="spryselect2">
                          <label for="pasillo"></label>
                          <select name="pasillo" id="pasillo">
                          	<?php
                     			  for($a=1;$a<=20;$a++){
							?>
                            		<option value="<?php echo $a; ?>" <?php if(!empty($dataprod[3])){ echo ($dataprod[3]==$a)? "SELECTED":""; } ?> ><?php echo $a; ?></option>
                            <?php
								  }
							?>
                          </select>
                        <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
              	</tr>
                  <tr>
                        <td>Nivel: </td>
                        <td colspan="3"> <span id="spryselect2">
                          <label for="nivel"></label>
                          <select name="nivel" id="nivel">
                          	<?php
                     			  for($a=1;$a<=6;$a++){
							?>
                            		<option value="<?php echo $a; ?>" <?php if(!empty($dataprod[2])){ echo ($dataprod[2]==$a)? "SELECTED":""; } ?> ><?php echo $a; ?></option>
                            <?php
								  }
							?>
                          </select>
                        <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
              	</tr>
                <tr>
                   		<td>Area de Almacenamiento:</td>
                        <td colspan="3"><span id="spryselect1">
                          <label for="bodega"></label>
                              <select name="bodega" id="bodega">
                              <?php
                              	if(empty($dataprod[4])){
									opciones($conexion,"com_areas_almacenamiento","Id","nombre","");
								}else{
									opcionesseleccionador($conexion,"com_areas_almacenamiento","Id","nombre",$dataprod[4]," ORDER BY Id ASC");
								}
							  ?>
                              </select>
                          <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                           
                  </td>
                </tr>
                 <tr>
                   		<td>Linea Producto:</td>
                        <td colspan="3"><span id="spryselect1">
                          <label for="categoria"></label>
                              <select name="categoria" id="categoria">
                              <option value=""></option>
                              <?php
                              	if(empty($dataprod[5])){
									opciones($conexion,"com_lineaproducto","Id","nombre","");
								}else{
									opcionesseleccionador($conexion,"com_lineaproducto","Id","nombre",$dataprod[5]," ORDER BY Id ASC");
								}
							  ?>
                              </select>
                          <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                           
                  </td>
                </tr>
                 <tr>
                        <td>Capacidad (Pares): </td>
                        <td colspan="3"> <span id="spryselect2">
                          <label for="capacidad"></label>
                          <select name="capacidad" id="capacidad">
                          	<?php
                     			  for($a=1;$a<=20;$a++){
							?>
                            		<option value="<?php echo $a; ?>" <?php if(!empty($dataprod[6])){ echo ($dataprod[6]==$a)? "SELECTED":""; } ?> ><?php echo $a; ?></option>
                            <?php
								  }
							?>
                          </select>
                        <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
              	</tr>
                 <tr>
                   		<td>Talla Producto:</td>
                        <td colspan="3"><span id="spryselect1">
                          <label for="talla"></label>
                              <select name="talla" id="talla">
                              <option value=""></option>
                              <?php
                              	if(empty($dataprod[7])){
									opciones($conexion,"com_tallas","Id","talla","");
								}else{
									opcionesseleccionador($conexion,"com_tallas","Id","talla",$dataprod[7]," ORDER BY Id ASC");
								}
							  ?>
                              </select>
                          <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                           
                  </td>
                </tr>
            </table>
				<table class="formularioprod" border="0">
				<tr>				  </tr>
				</table>
				<table class="formularioprod">
                  <tr>
                   		<td width="335" align="right">
                        	<input type="submit" value="Crear Cajonera" name="Guardar" />
                        	<input type="hidden" name="Id" value="<?php echo (!empty($_GET['id']) || $id!='')? $id:''; ?>" />
                        </td>
                        <td width="353"><input type="button" value="Cerrar" onclick="Cerrar()" /></td>
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
</script>
</body>
</html>