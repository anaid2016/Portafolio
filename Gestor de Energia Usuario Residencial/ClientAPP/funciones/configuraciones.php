<?php 
require 'funciones.php';

$ip_tarjeta = $_GET['vector'][0];
$modbus = $_GET['vector'][1];
$name_home = $_GET['vector'][2];

echo json_encode(datacliente($ip_tarjeta,$modbus,$name_home));