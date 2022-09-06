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
<script> 
 function Cerrar(Id){
	opener.location.href = "../acceso.php?com_pg=1";
    window.close();
}
</script>
</head>
<body>
<!--Guardando Proveedor -->
	


	
<div id="contenidof">
    <br/>
    <?php
	
			if(!empty($_GET['Id'])){
				// Busqueda del producto
				$id=$_GET['Id'];
				$buscar=mysql_query("SELECT * FROM com_productos WHERE Id='$id'",$conexion);
				while($resultado=mysql_fetch_assoc($buscar)){
					$nombre=$resultado['nombre'];	
					$codigobarras=$resultado['codbarras'];
				}
			}
			
			//Eliminando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar']) && empty($_GET['Id'])){
			
				$v9=$_SESSION['user'];
				$id=$_POST['Id'];
				
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				$delete=mysql_query("UPDATE com_productos SET estado_id='2' WHERE Id='$id' ");
				if(!$delete)
				$error=1;
				
				/*$delete=mysql_query("DELETE FROM com_preciosclientes WHERE producto_id='$id' ");
				if(!$delete)
				$error=1;
					
				$delete=mysql_query("DELETE FROM com_productos WHERE Id='$id' ");
				if(!$delete)
				$error=1;*/
				
				if($error) {
					mysql_query("ROLLBACK");
					echo "No se puede borrar el Producto, se encuentra asociado a otros procesos";
				} else {
					mysql_query("COMMIT");
					echo "Producto Borrado con éxito";
				}

				
                
				
				 echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',3000);</script>"; 
			}else{
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            
               <h3>Producto a Eliminar:</h3>
                <?php
				 	if(!empty($_GET['Id'])){
				
					echo "Se eliminará El producto ".$nombre." con Codigo de Barras ".$codigobarras;
				?>
                	
                   	 <input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>">
                <?php	
					}else{
						echo "Debe seleccionar un producto a eliminar....";
						echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar(".$id.")',3000);</script>"; 	
					}
						  ?>
                  <p align="center">
                          <input type="submit" name="Guardar" id="Eliminar Producto" value="Eliminar Producto">
                  </p>
             </form>
    <?php
			}
	?>
</div>
</body>
</html>