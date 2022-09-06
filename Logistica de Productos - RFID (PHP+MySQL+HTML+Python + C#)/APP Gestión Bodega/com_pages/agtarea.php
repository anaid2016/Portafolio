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
	opener.location.href = "../acceso.php?com_pg=10";
    window.close();
}
</script>
<script language="javascript">
$(document).ready(function(){
	// Parametros para e combo1
   $("#pasillo").change(function () {
	    mostrar="../funciones/arr_cajoneras.php";
	    document.getElementById('cajonera').disabled=false;
		$("#pasillo option:selected").each(function () {
				elegido=$(this).val();
				$.post(mostrar, { elegido: elegido }, function(data){
				$("#cajonera").html(data);
			});			
        });
   })

});
</script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenidof">
    	<h2> >> Agregar Tarea de Inventario</h2>
			<?php
			
			//Producto a Modificar ----------------------------------------------------------------//
			if(!empty($_GET['Id'])){
				$id=$_GET['Id'];
				$bproducto=mysql_query("SELECT com_arraybodega.*,com_bodega.Id as idbodega,com_bodega.nombre as bodega
 FROM com_arraybodega
LEFT JOIN com_bodega ON com_bodega.Id=com_arraybodega.bodega_id WHERE com_arraybodega.Id='$id'",$conexion);
				$dataprod=mysql_fetch_row($bproducto);
			
				
			}
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
			
				$v1=$_POST['auxiliar'];
				$v2=$_POST['cajonera'];
				$v3=gmdate('Y-m-d');
				$id=$_POST['Id'];
					
				//Consultando si ya existe una a esta cajonera pendiente -----//
				$bpendiente=mysql_query("SELECT * FROM tareainventario	WHERE cajonera_id='$v2' and estado='1'",$conexion);
				$existe=mysql_num_rows($bpendiente);

				
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				
				
				
				if($id==''){
					if($existe==0){
						$insertar=mysql_query("INSERT INTO tareainventario SET auxiliar_id='$v1',cajonera_id='$v2',fecha1='$v3' ");
					}else{
						mysql_query("ROLLBACK");
						echo "Ya existe una tarea de inventario pendiente en esa cajonera";
						die();
					}
				}else{
					$insertar=mysql_query("UPDATE tareainventario SET  auxiliar_id='$v1',cajonera_id='$v2',fecha1='$v3' WHERE Id='$id' ");
				}
				if(!$insertar)
				$error=1;
				//echo "1:".$error;
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Tarea Agregada con Exito";
				}
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
				 
			}else{
               
           
            ?>
            <p>Diligencie el formulario en su totalidad y de clic en Generar Tarea:</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="other">
				<table class="formularioprod">
				<tr>
                    	<td width="30%">Auxiliar Responsable</td>
                        <td colspan="3"><span id="spryselect3">
                          <label for="auxiliar"></label>
                          <select name="auxiliar" id="auxiliar">
                          			<?php
										if(empty($dataprod[1])){
											opciones($conexion,"com_usconect","Id","CONCAT_WS(' ',nombre,apellidos) as nombre"," WHERE perfil_id='4' ");
										}else{
											opcionesseleccionador($conexion,"com_usconect","Id","CONCAT_WS(' ',nombre,apellidos) as nombre",$dataprod[1],"  WHERE perfil_id='4'");
										}
									?>
                          </select>
                          <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                        </td>
               </tr>
               <tr>
                        <td>Pasillo</td>
                        <td colspan="3"> <span id="spryselect2">
                          <label for="pasillo"></label>
                          <select name="pasillo" id="pasillo">
                          	<option value=""></option>
                          	<?php
                          		if(empty($dataprod[2])){
									opciones($conexion,"com_arraybodega","pasillo","pasillo"," GROUP BY pasillo");
								}else{
									opcionesseleccionador($conexion,"com_arraybodega","pasillo","pasillo",' '," ORDER BY pasillo ASC GROUP BY pasillo");
								}
							?>
                          </select>
                        <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
              	</tr>
                <tr>
                   		<td>Cajonera</td>
                        <td colspan="3"><span id="spryselect1">
                          <label for="cajonera"></label>
                              <select name="cajonera" id="cajonera" <?php echo (empty($dataprod[2]))? 'disabled="disabled"':''; ?> >
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
                        	<input type="submit" value="Generar Tarea" name="Guardar" />
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
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
</script>
</body>
</html>