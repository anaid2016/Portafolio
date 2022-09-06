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
	include('pages/Resources/config.php');
	$db_con = mysql_connect($dbhost,$dbuser,$dbpass);

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Proveedor - CALZACUERO</title>
    <link rel="stylesheet" type="text/css" href="CSS/comx_style.css">
	<link rel="stylesheet" type="text/css" media="screen" href="themes/redmond/jquery-ui-custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.jqgrid.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.multiselect.css" />
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
    </style>
    <link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>
<body>
	<header>
	<ul id="MenuBar1" class="MenuBarHorizontal">
		    <li><a class="MenuBarItemSubmenu" href="#">Generales</a>
		      <ul>
		        <li><a href="usuarios_index.php">Usuarios</a></li>
		        <li><a href="productos_index.php">Productos</a></li>
		        <li><a href="clientes_index.php">Clientes</a></li>
	          </ul>
	        </li>
		    <li><a class="MenuBarItemSubmenu" href="#">Movimientos Productos</a>
		      <ul>
		        <li><a class="MenuBarItemSubmenu" href="#">Ordenes</a>
		          <ul>
		            <li><a href="orden_venta.php">Compra</a></li>
		            <li><a href="orden_compra.php">Venta</a></li>
	              </ul>
	            </li>
		        <li><a href="movimientos_index.php">Movimientos Productos</a></li>
		       
	          </ul>
	        </li>
      </ul>
	</header>
	<section>
	 	 y QU CARAJOS PASA
        
</section>
    <footer>
     	Software Educativo - Universidad Industrial de Santader - Punto de Venta
    </footer>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
    </script>
</body>
</html>