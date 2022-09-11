<?php
require_once 'funciones.php';
include("restconsume.php");

$tarjeta=$_GET['id_tarjeta'];
$modbus=$_GET['modbusposition'];
$iptarjeta=$_GET['ip_tarjeta'];
$access=$_GET['access'];
$name_home=$_GET['name_home'];


if( !empty($tarjeta) and !empty($modbus) ){

    
    //1) Iniciar a correr demonio en python======================================
    if($access == '1'){
        $params=['_ploginuser',$iptarjeta,$modbus,$_SERVER['HTTP_HOST']];
        $_socket=adb_rest("1",$params);
    }else{
       $_socket = "OK";
    }
    
        $file = fopen("test_mes.txt","w");
        fwrite($file,"Llegada de socket 1: ".$_socket.PHP_EOL);
        fclose($file);
    
    
    //2) Se recogen los datos del archivo====================================
    if($_socket == "OK"){
        
        if($access=='1'){
            sleep(17);
        }else{
            sleep(3);
        }
        $params=['_ploginuser',$iptarjeta,$modbus,$_SERVER['HTTP_HOST'],$tarjeta,$name_home];
        $rpta=adb_rest("2",$params);
        
        $file = fopen("test_mes.txt","w");
        fwrite($file,"Llegada de rpat 2: ".$rpta.PHP_EOL);
        fclose($file);

        //3) Sacando respuesta del archivo
        if(!empty($rpta)){
              echo json_encode(explode(",", $rpta));
        }else{
            echo "Intentando Conectar...";
        }
        
    }else{

        echo "No hay datos de consumo.";

    }
   
}else{
    
    echo "No se tienen datos del sitio";
}


	
?>