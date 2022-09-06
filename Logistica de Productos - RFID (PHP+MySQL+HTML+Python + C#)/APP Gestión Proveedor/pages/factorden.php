<html>
	<head>
    	<link rel="stylesheet" type="text/css" href="../CSS/css_factura.css"/>
    </head>
	<body>
	<?php
    include("../funciones/pv_varias.php");
    if(!empty($_GET['orden'])){
        $orden=$_GET['orden'];
        echo PV_004($orden);
    
    }else{
        echo "Enlace enviado no valido";	
    }
    ?>
	
    </body>
</html>    