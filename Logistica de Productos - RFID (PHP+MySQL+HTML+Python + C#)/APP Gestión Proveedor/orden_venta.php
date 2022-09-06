<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "denied.html";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
	include("funciones/pv_varias.php");
	include('pages/Resources/config.php');
	$db_con = mysql_connect($dbhost,$dbuser,$dbpass);
	mysql_select_db($dbname);
	$_SESSION['idrfid']='';
	$_SESSION['ordenventa']="";
	
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Proveedor - CALZACUERO</title>
    <link rel="stylesheet" type="text/css" href="CSS/comx_style.css">
   <script src="pages/js/jquery.js" type="text/javascript"></script>
    <script src="pages/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
	</script>
    <script src="pages/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="pages/js/jquery-ui-custom.min.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
	<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>
<body>
	<header>
    <img src="images/head.png" alt="" width="1300" />
    </header>
    <div style="clear:both">&nbsp;</div>
	<section>
    	<div style="clear:both">
          <ul id="MenuBar1" class="MenuBarHorizontal">
                <li><a class="MenuBarItemSubmenu" href="#">Generales</a>
                  <ul>
                    <li><a href="usuarios_index.php">Usuarios</a></li>
                    <li><a href="tallas_index.php">Tallas</a></li>
                    <li><a href="color_index.php">Color</a></li>
                    <li><a href="nombres_index.php">Nombre Zap.</a></li>
                    <li><a href="categoria_index.php">Genero</a></li>
                    <li><a href="tipo_index.php">Tipo</a></li>
                    <li><a href="productos_index.php">Productos</a></li>
                    <li><a href="clientes_index.php">Clientes</a></li>
                  </ul>
                </li>
                <li><a class="MenuBarItemSubmenu" href="#">Movimientos Productos</a>
                  <ul>
                    <li><a class="MenuBarItemSubmenu" href="#">Ordenes</a>
                      <ul>
                        <li><a href="orden_venta.php">Ingreso Productos</a></li>
                        <li><a href="pedidos_index.php">Ventas Productos</a></li>
                      </ul>
                    </li>
                    <li><a href="movimientos_index.php">Movimientos Productos</a></li>
                    <li><a href="inventario_index.php">Inventario</a></li>
                  </ul>
                </li>
                <li><a class="MenuBarItemSubmenu" href="cierre.php">Cerras Sesion</a>
            </ul>
        </div>
        <div style="clear:both;margin:30px 20px 30px 40px">
	 	     <?php require_once("pages/orden_compra.php"); ?> 
        </div>  
</section>
    <footer>
     	Software Educativo - Universidad Industrial de Santader - Proveedor
</footer>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
    </script>
</body>
</html>