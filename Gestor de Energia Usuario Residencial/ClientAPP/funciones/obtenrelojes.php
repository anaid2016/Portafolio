<?php
include("restconsume.php");
require_once 'funciones.php';

$tarjeta=$_GET['id_tarjeta'];
$modbus=$_GET['modbusposition'];
$iptarjeta=$_GET['ip_tarjeta'];
$name_home=$_GET['name_home'];


if( !empty($tarjeta) and !empty($modbus) ){

    $params=['_ploginuser',$iptarjeta,$modbus,$_SERVER['HTTP_HOST']];
    $_socket=adb_rest("3",$params);
    
    //2) Se recogen los datos del archivo====================================
    if(!empty($_socket)){
        $_venergias = explode(",",$_socket);
        
        if(is_numeric($_venergias[0]) == FALSE){
            echo "0::0::0::0::0::0::0::0";
            die();
        }
        
    }else{
        echo "0::0::0::0::0::0::0::0";
        die();
    }
    
    $file = fopen("test.txt","w");
    fwrite($file,'aqui que llega'.$_venergias[0]);
    fclose($file);
    
    sleep(5);
    $_activaactual = $_venergias[0];
    $_datosdelcliente = datacliente($tarjeta,$modbus,$name_home);
    $_periodoactual = periodoactual($_datosdelcliente[9]);
    $_datosmes = lastperiodo($_datosdelcliente[14],$_datosdelcliente[10],$name_home); 
    $_datosdia = lastdia($_datosdelcliente[15],$_datosdelcliente[10],$name_home);
    $_fechactual = date('Y-m-d');
    $_valordia = 0;
    $_consumodia = 0;
    $_valormes = 0;
    $_consumomes = 0;
    
        
    //Obteniendo dia anterior=======================================================================//
    
    $_fechasub = date_create($_fechactual);
    date_sub($_fechasub, date_interval_create_from_date_string('1 days'));
    $yesterday = date_format($_fechasub, 'Y-m-d');
    
    
    //Calculando valor del reloj para el dia========================================================//                            
    if($_datosdia[0] == $yesterday){
        $_reloj1 = round( (220*($_activaactual-$_datosdia[1])) / $_datosdelcliente[11]) ;
        $_valordia = round( ($_activaactual-$_datosdia[1])* $_datosdelcliente[10] );
        $_consumodia = round($_activaactual-$_datosdia[1]);
        
        if($_reloj1>240){
            $_reloj1 = 240;
        }
        
    }else{
        
        $_reloj1 = 0;
        
    }
    
    //Calculando valor del reloj para el mes===========================================================//
    if($_periodoactual == $_datosmes[0]){
        
        $_reloj2 = round( (220*($_activaactual-$_datosmes[1])) /  $_datosdelcliente[12]) ;
        $_valormes = round( ($_activaactual-$_datosmes[1])* $_datosdelcliente[10] );
        $_consumomes = round($_activaactual-$_datosmes[1]);
        
        if($_reloj2>240){
            $_reloj2 = 240;
        }
        
    }else{
        
         if($_datosdia[0] == $yesterday){       //Aplica para el primer dia del mes
             
              $_reloj2 = round( (220*($_activaactual-$_datosdia[1])) / $_datosdelcliente[12]) ;
              
              $_valormes = round( ($_activaactual-$_datosdia[1])* $_datosdelcliente[10] );
              
              $_consumomes = round($_activaactual-$_datosdia[1]);
             
         }else{
             
              $_reloj2 = 0;
         }
    }

    echo $_reloj1."::".$_reloj2."::".$_valordia."::".$_valormes."::".$_consumodia."::".$_consumomes."::".$_fechactual."::".$_periodoactual."::".$_venergias[0]."::".$_datosdia[1]."::".$_datosmes[1]."::".$_activaactual."::".$_datosmes[1];
}else{
    
    echo "No se tienen datos del sitio";
}


	
?>