<?php 
require 'funciones.php';


    $ip_tarjeta = $_GET['vector'][0];
    $modbus = $_GET['vector'][1];
    $name_home = $_GET['vector'][2];

    $_dataclient = datacliente($ip_tarjeta,$modbus,$name_home);
    echo json_encode(estadistica($_dataclient[10] , $_dataclient[14] , '2', '7', $_dataclient[15],$name_home));

    