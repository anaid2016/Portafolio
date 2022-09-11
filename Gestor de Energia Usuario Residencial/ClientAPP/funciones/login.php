<?php 
require 'funciones.php';

$user = $_GET['nombre'];
$psw = $_GET['psw'];

echo json_encode(login($user,$psw));

