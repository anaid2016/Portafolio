<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Proveedores</title>
<link rel="stylesheet" type="text/css" href="../css/menuinterno.css">
<link rel="stylesheet" type="text/css" href="../css/popupcss.css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script> 
 function Cerrar(Id){
	opener.location.href = "../acceso.php?com_pg=6";
    window.close();
}
</script>
</head>
<body>
<!--Guardando Proveedor -->
	


<!--Menu de Solapas -->
	<div id="tabsI">
    	 <ul>
            <li><a href="<?php echo (!empty($_GET['Id']))? '?Id='.$_GET['Id']:'' ?>" title="Datos"><span>Datos Generales</span></a></li>
            <li><a href="<?php echo (!empty($_GET['Id']))? 'dirclientes.php?Id='.$_GET['Id'].'&view=true':'' ?>" title="Direcciones"><span>Direcciones</span></a></li>
         </ul>
    </div>
	
<div id="contenidof">
    <br/>
    <?php
	
			if(!empty($_GET['Id'])){
				// Busqueda del proveedor
				$id=$_GET['Id'];
				$buscar=mysql_query("SELECT * FROM com_clientes WHERE Id='$id'",$conexion);
				while($resultado=mysql_fetch_assoc($buscar)){
					$rpsocial=$resultado['nombres'];	
					$nit=$resultado['nit'];
					$regimen=$resultado['regimen'];
					$rplegal=$resultado['representantelegal'];
					$documento=$resultado['documento'];
					$celular=$resultado['celular'];
					$correo=$resultado['correo'];
				}
			}
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar']) && empty($_GET['Id'])){
			
/*				$v1=$_POST['rsocial'];
				$v2=$_POST['nit'];
				$v3=$_POST['regimen'];
				$v4=$_POST['replegal'];
				$v5=$_POST['iddoc'];
				$v6=$_POST['cel'];
				$v7=$_POST['mail'];*/
				$v9=$_SESSION['user'];
				$id=$_POST['Id'];
				
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				$delete=mysql_query("DELETE FROM com_direccionclientes WHERE cliente_id='$id' ");
				if(!$delete)
				$error=1;
					
				$delete=mysql_query("DELETE FROM com_clientes WHERE Id='$id' ");
				if(!$delete)
				$error=1;
				
				if($error) {
					mysql_query("ROLLBACK");
					echo "No se pudo borrar el Cliente";
				} else {
					mysql_query("COMMIT");
					echo "Cliente Borrado con éxito";
				}

				
                
				
				 echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',3000);</script>"; 
			}else{
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            
               <h3>Datos Generales del Cliente</h3>
                   <!--Formulario 1-->
                      <table>
                         <tr>
                                <td>Razón Social:</td>
                                <td>&nbsp;</td>
                                <td><span id="sprytextfield1">
                                  <label for="rsocial"></label>
                                  <input name="rsocial" type="text" id="rsocial" size="40" value="<?php echo (!empty($rpsocial))?  $rpsocial:''; ?>" >
                                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                              <td>Nit:</td>
                              <td>&nbsp;</td>
                              <td><span id="sprytextfield2">
                                <label for="nit"></label>
                                <input name="nit" type="text" id="nit" size="40" value="<?php echo (!empty($nit))? $nit:''; ?>">
                              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                          </tr>
                            <tr>
                              <td>Regimen:</td>
                              <td>&nbsp;</td>
                              <td><span id="spryselect1">
                                <label for="regimen"></label>
                                <select name="regimen" id="regimen"  value="<?php echo (!empty($regimen))? $regimen:''; ?>" >
                                    <option value="simplificado">Simplificado</option>
                                    <option value="comun">Comun</option>
                                 </select>
                              <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                              <td colspan="3">&nbsp;</td>
                          </tr>
                        </table>    
                        
                        
                      <h3>Datos del Representante Legal</h3>
                        <table width="707">
                            <tr>
                                <td width="134">Nombre Completo:</td>
                                <td width="10">&nbsp;</td>
                                <td width="240"><span id="sprytextfield3">
                                  <label for="replegal"></label>
                                  <input name="replegal" type="text" id="replegal" size="40" value="<?php echo (!empty($rplegal))? $rplegal:''; ?>">
                                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                                <td width="151">Doc. de Identificación</td>
                                <td width="10">&nbsp;</td>
                                <td width="136"><span id="sprytextfield4">
                                <label for="text1"></label>
                                <input name="iddoc" type="text" id="iddoc" size="20" value="<?php echo (!empty($documento))? $documento:''; ?>">
                                <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
                          </tr>
                            <tr>
                              <td>Celular:</td>
                              <td>&nbsp;</td>
                              <td><span id="sprytextfield5">
                              <label for="cel"></label>
                              <input name="cel" type="text" id="cel" size="40" value="<?php  echo (!empty($celular))? $celular:''; ?>">
                              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                              <td>Correo:</td>
                              <td>&nbsp;</td>
                              <td><span id="sprytextfield6">
                              <label for="mail"></label>
                              <input type="text" name="mail" id="mail" value="<?php echo (!empty($correo))? $correo:''; ?>">
                              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
                          </tr>
                          <?php
						  	if(!empty($_GET['Id'])){
						  ?>
                          	 <input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>">
                          <?php	
							}
						  ?>
                       </table>
                        <p align="center">
                          <input type="submit" name="Guardar" id="Eliminar Proveedor" value="Eliminar Proveedor">
                        </p>
                        </form>
    <?php
			}
	?>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "email");
</script>
</body>
</html>