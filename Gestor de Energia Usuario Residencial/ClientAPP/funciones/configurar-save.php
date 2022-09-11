<?php 
require 'funciones.php';

$ip_tarjeta = $_GET['vector'][0];
$modbus = $_GET['vector'][1];
$name_home = $_GET['vector'][2];
$ustarjetid = $_GET['vector'][3];

$_datacliente = datacliente($ip_tarjeta,$modbus,$name_home);

    //Recogiendo datos del formulario
    if(!empty($_GET['checkp'])){
        $_lectura = $_GET["fecha"];
    }else{
        $_lectura = $_datacliente[9]; 
    }


    $_precio = $_GET["precio"];
    $_diario = $_GET["alertd"];
    $_mensual = $_GET["alertm"];

    if(!empty($_GET["checke"])){
        $_correo = $_GET["correo"];
        $_habalerta = $_GET["checke"];
    }else{
        $_habalerta = "2";
        $_correo = null;
    }

   echo savedataclient($ustarjetid,$_lectura,$_precio,$_diario,$_mensual,$_datacliente[9],$_correo,$_habalerta,$name_home);