<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_puntoventa = "localhost";
$database_puntoventa = "proveedor";
$username_puntoventa = "root";
$password_puntoventa = "";
$puntoventa = mysql_pconnect($hostname_puntoventa, $username_puntoventa, $password_puntoventa) or trigger_error(mysql_error(),E_USER_ERROR); 
?>