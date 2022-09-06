<?php 
include("funciones/seguridad_bodega.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" charset="utf-8"/>
<meta name="viewport" 
  content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>APLICACION COMERCIAL</title>
<link rel="stylesheet" type="text/css" href="css/styles2.css"/>
<link rel="stylesheet" type="text/css" href="css/menubodega.css"/>

<!--Funciones Javascript -->
<script src="com_pages/js/varias.js" type="text/javascript"></script>

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
        	<img src="images/headbodega.png" />
        </div>
    </div>
    <div id="page">
   		<div id='button'>
                <?php include("funciones/menulibbodega.php"); ?>
                 <div style="clear:both">&nbsp;</div>
		</div>
       
        <div id="content">
        		<?php
					if(empty($_GET['com_pgb']) || $_GET['com_pgb']==0){
						include("com_pagesbodega/iniciobodega.html");	
					}else if(!empty($_GET['com_pgb']) && $_GET['com_pgb']==1){
						include("com_pagesbodega/pedidos.php");
					}else if(!empty($_GET['com_pgb']) && $_GET['com_pgb']==2){
						include("com_pagesbodega/ordenes.php");
					}else if(!empty($_GET['com_pgb']) && $_GET['com_pgb']==3){
						include("com_pagesbodega/salir.php");
					}				
				?>
        </div>
    </div>
</div>
</body>
</html>
    
    
	
