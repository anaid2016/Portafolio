<?php
session_start();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" charset="utf-8"/>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Bodega - DISTRISAN</title>
<link href="css/styles1.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
       <div class="login">
                <form action="funciones/control.php" method="post">
                    <table class="intro">
                        <tr>
                            <td><b>Usuario:</b></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="login" size="25"/></td>
                        </tr>
                        <tr>
                            <td><b>Contraseña:</b></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="passwd" size="25"/></td>
                        </tr>
                        <tr>
                            <td align="right"><input type="submit" value="Acceder" /></td>
                        </tr>
                    </table>
                </form>
        </div>
</body>
</html>
