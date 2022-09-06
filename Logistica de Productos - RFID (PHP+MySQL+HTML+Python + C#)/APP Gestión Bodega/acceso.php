<?php 
include("funciones/seguridad.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" charset="utf-8"/>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>APLICACION COMERCIAL</title>
<link rel="stylesheet" type="text/css" href="css/styles1.css"/>
<link rel="stylesheet" type="text/css" href="css/menucss.css"/>


<!--Funciones Javascript -->
<script src="com_pages/js/varias.js" type="text/javascript"></script>
<script src="funciones/jquery-1.7.1.min.js" type="text/javascript"></script>
</head>
<body>
<?php
	$archivo="funciones/datos.txt";
	include("funciones/conexbd.php");
	include("funciones/librerias.php"); 
?>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
        	<img src="images/head.png" alt="" width="1200" height="90" />
        </div>
    </div>
    <div id="page">
   		<div id='menu'>
                <?php include("funciones/menulib.php"); ?>
                 <div style="clear:both">&nbsp;</div>
		</div>
       
        <div id="content">
        		<?php
					if(empty($_GET['com_pg']) || $_GET['com_pg']==0){
						include("com_pages/inicio.php");	
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==1){
						include("com_pages/productos.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==4){
						include("com_pages/proveedores.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==5){
						include("com_pages/ordencompra.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==6){
						include("com_pages/clientes.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==7){
						include("com_pages/pedidosclientes.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==8){
						include("com_pages/despachos.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==9){
						include("com_pages/recepciones.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==2){
						include("com_pages/movimientosproductos.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==3){
						include("com_pages/existenciasok.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==10){
						include("com_pages/tareainventario.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==11){
						include("com_pages/revizarinventario.php");
					}else if(!empty($_GET['com_pg']) && $_GET['com_pg']==12){
						include("com_pages/cajoneras.php");
					}
				
				?>
        </div>
	</div>
</div>	
</body>
</html>
    
    
	
