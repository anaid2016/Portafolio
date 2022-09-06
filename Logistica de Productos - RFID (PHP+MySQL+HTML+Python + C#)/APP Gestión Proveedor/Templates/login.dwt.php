<?php require_once('puntoventa.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_puntoventa, $puntoventa);
$query_accesor = "SELECT * FROM prov_users";
$accesor = mysql_query($query_accesor, $puntoventa) or die(mysql_error());
$row_accesor = mysql_fetch_assoc($accesor);
$totalRows_accesor = mysql_num_rows($accesor);

?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['pass'];
  
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "Templates/index.php";
  $MM_redirectLoginFailed = "Templates/denied.html";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_puntoventa, $puntoventa);
  
  $LoginRS__query=sprintf("SELECT userp, password FROM prov_users WHERE userp=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $puntoventa) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Documento sin título</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<link href="Templates/CSS/css_login.css" rel="stylesheet" type="text/css">
<script src="Templates/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="Templates/SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="Templates/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="Templates/SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="container">
  <div class="content">
  		 <form action="<?php echo $loginFormAction; ?>" method="POST" id="form1" name="form1">
				<table>
   				  <tr>
                    	<td>Usuario:</td>
                        <td><span id="sprytextfield1">
                        <input type="text" name="user" id="user" autocomplete="on">
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                        </td>
				  </tr>
                    <tr>
                    	<td>Password:</td>
                        <td><span id="sprypassword1">
                        <input type="password" name="pass" id="pass">
                            <span class="passwordRequiredMsg">Se necesita un valor.</span></span>
                      </td>
                  </tr>   
                  <tr>
                  	<td colspan="2">
                    	<input type="submit" value="Acceder">
                    </td> 
            	</table>            
        </form>
  </div>
</div>
  
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
</script>
</body>
<?php
mysql_free_result($accesor);
?>

</html>
