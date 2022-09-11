<?php

/*
 * Funcion para conectar por socket
 * @ip -> ip a conectar el socket
 * @puerto -> puerto del socket
 * @timeout -> timeout del socket
 * @prta -> pregunta
 */

function socket($ip,$puerto,$timeout,$prta){
    
    $var_data="";
    
    $fp = fsockopen($ip, $puerto);
    if (!$fp) {
        $var_data= "";
    }else{

        fwrite($fp, $prta);
        stream_set_timeout($fp, $timeout);
        $res = fread($fp, 2048);
        $info = stream_get_meta_data($fp);
        fclose($fp);

        if ($info['timed_out']) {
            $var_data="";
        }else{
           $var_data.=$res;
        }
    }
   
    return $var_data;
    
}

/*Funcion que entrega los datos del cliente
 *Posiciones:
 * 0->/id de la tarjeta
 * 1->ip de la tarjeta
 * 2-> nombre de la torre
 * 3->nombre del conjunto
 * 4-> id del usuario en bd
 * 5-> username del usuario
 * 6->email del usuario
 * 7->status usuario
 * 8->nombre del usuario
 * 9->fecha de lectura
 * 10->preciokwmensual
 * 11->limite diario
 * 12->limite mensual
 * 13->nombre del barrio
 * 14->id de la vivienda
 * 15->id del medidor
 * 16->fecha de lectura new
 */

function datacliente($id_tarjeta,$modbusposition,$name_home){
    
    require 'config.php';
 
    $_namefile= $name_home;
    $enlace2 = new mysqli($wm_host[$_namefile], $wm_user[$_namefile], $wm_password[$_namefile], $wm_dbname[$_namefile]);
    
    if ($enlace2->connect_error) {
        return "Connection failed: " . $enlace2->connect_error;
    }
    
    $query="SELECT tarjeta.id,tarjeta.ip,torre.nombre as sttorre, conjunto.nombre as stconjunto, 
`user`.id,`user`.username,`user`.email,`user`.status,`user`.nombre,`user`.fechadelectura,`user`.preciokwhmensual,
`user`.limalertdiaria,`user`.limalertmensual,barrio.nombre,vivienda.Id as vivienda,medidores.Id as medidor,`user`.fechadelectura_new FROM `user`
LEFT JOIN vivienda on `user`.id = vivienda.cliente_id
LEFT JOIN torre on torre.Id = vivienda.torre_id
LEFT JOIN conjunto on conjunto.Id = torre.conjunto_id
LEFT JOIN medidores on medidores.Id = vivienda.medidor_id
LEFT JOIN tarjeta on tarjeta.Id= medidores.tarjeta
LEFT JOIN barrio on barrio.Id=vivienda.barrio_id
WHERE tarjeta.estado_id='1' and tarjeta.Id='".$id_tarjeta."' and medidores.modbus='".$modbusposition."' and medidores.estado_id='1' ";

    $_resultado = $enlace2->query($query);
    $row = $_resultado->fetch_array(MYSQLI_NUM);

    $enlace2->close();

    return $row;    
    
}


/*Funcion para guardar los datos entregados por el cliente*
 * 
 * 
 */

function savedataclient($_usuarioid,$_lectura,$_precio,$_diario,$_mensual,$_fechaanterior,$_correo,$_habalerta,$_namefile){
    
   require 'config.php';
 
    $enlace2 = new mysqli($wm_host[$_namefile], $wm_user[$_namefile], $wm_password[$_namefile], $wm_dbname[$_namefile]);
    
    if ($enlace2->connect_error) {
        return "Connection failed: " . $enlace2->connect_error;
    }
    
    //Revisando si la linea de hoy=========================================
    $_hoy=date('d');
    $lectura = $_lectura;
    
    
    $stmt = $enlace2->prepare("UPDATE `user` SET fechadelectura = ?, "
            . " preciokwhmensual =  ? ,"
            . " limalertdiaria = ? , "
            . " limalertmensual = ? ,"
            . " email = ?,"
            . " hab_alertas = ? "
            . " WHERE id = ? ");

    $stmt->bind_param('ssssssi',$lectura,$_precio,$_diario,$_mensual,$_correo,$_habalerta,$_usuarioid);
    
   if ($stmt->execute()) {
      $_error= "ok";
   }else{
      $_error = $stmt->error; 
   }
    
    $stmt->close();
    $enlace2->close();
    
    return $_error;
    
   
}

/*
 * Funcion para obtener la estadistica mensual o diaria 
 * @tipo => 1 mensual, 2 diaria
 * @cantidad => No. de dias o meses
 * @preciokwmensual => 
 */

function estadistica($preciokwmensual,$vivienda_id,$tipo,$cantidad,$medidor,$_namefile){
    
    require 'config.php';
 
    $enlace2 = new mysqli($wm_host[$_namefile], $wm_user[$_namefile], $wm_password[$_namefile], $wm_dbname[$_namefile]);
    
    if ($enlace2->connect_error) {
        return "Connection failed: " . $enlace2->connect_error;
    }
    
    $periodo=array();
    $activa=array();
    $reactiva=array();
    $valor=array();
    $_error=0;

    if($tipo == '1'){
        
        $_sql=" SELECT periodo,activa,reactiva FROM lecturaxmes
WHERE vivienda_id = ? ORDER BY fecha_final DESC LIMIT ".$cantidad;
        $_campovalor = $vivienda_id;
        
        $file = fopen("test_mes.txt","w");
        fwrite($file,'en vivienda '.$_sql.":".$_campovalor.PHP_EOL);
        fclose($file);
          
    }else if($tipo == '2'){
        
        $_sql = "SELECT CONCAT(month(fecha_hora),'-',day(fecha_hora)) as periodo,max(activa),max(reactiva) FROM lecturas
WHERE medidor_id= ? GROUP BY CONCAT(year(fecha_hora),'-',month(fecha_hora),'-',day(fecha_hora)) ORDER BY fecha_hora DESC LIMIT ".$cantidad;
        $_campovalor = $medidor;
        
        $file = fopen("test_mes.txt","a+");
        fwrite($file,'en medidores '.$_sql.":".$_campovalor.PHP_EOL);
        fclose($file);
       
          
    }else{
        $_error = "El tipo seleccionado no es permitido";
    }
    
   
  
    
    if(!empty($_sql)){
       
        $stmt = $enlace2->stmt_init();
        if(!$stmt->prepare($_sql))
        {
            
            $_error = "Error en la preparacion de la consulta";
            
        }else{
            
             $file = fopen("test_mes.txt","a+");
            fwrite($file,'aqui que llega'.$_sql.":".$_campovalor.PHP_EOL);
            
            $stmt->bind_param('s',$_campovalor);
            if ($stmt->execute()) {
            
                $stmt->bind_result($_periodo, $_activa,$_reactiva);
                while ($stmt->fetch()) {
                    
                     
                    fwrite($file,'vector '.$_periodo."::".$_activa.PHP_EOL);
                    $periodo[] = $_periodo; 
                    $activa[] = $_activa;
                    $reactiva[] = $_reactiva; 
                    
                    if($tipo == 1){
                        $valor[] = ( $_activa * $preciokwmensual);
                    }
                }
             
            }else{
               $_error = $stmt->error; 
            }
            
         
        
        }

    }
    
    $stmt->close();
    $enlace2->close();
    
    $_periodo=array_reverse($periodo);
    $_activa=array_reverse($activa);
    $_reactiva=array_reverse($reactiva);
    
    if($tipo==2){
        
        $_activatmp = $_activa;
        $_reactivatmp = $_reactiva;
        
        $_activa=array();
        $_reactiva=array();
        
        for($t=0;$t<count($_activatmp);$t++){
            $t_last=$t-1;
            
            if($t>0){
                $_valor[] = ($_activatmp[$t]-$_activatmp[$t_last]) * $preciokwmensual;
                $_activa[] = ($_activatmp[$t]-$_activatmp[$t_last]);
                $_reactiva[] = ($_reactivatmp[$t]-$_reactivatmp[$t_last]);
            }
        }
        
        unset($_periodo[0]);
        $_periodo = array_values($_periodo);

        
    }else{
        
        $_valor=array_reverse($valor);
    }
    
     fwrite($file,'....'.PHP_EOL);
    fclose($file);
    return [$_periodo,$_activa,$_valor,$reactiva,$_error];
    
}


function lastperiodo($vivienda_id,$preciokwmensual,$name_home){
    
   require 'config.php';
 
    $_namefile= $name_home;
     $enlace2 = new mysqli($wm_host[$_namefile], $wm_user[$_namefile], $wm_password[$_namefile], $wm_dbname[$_namefile]);
    $_error = 0;
    
    if ($enlace2->connect_error) {
        return "Connection failed: " . $enlace2->connect_error;
    }
    
    $_sql="SELECT periodo,activainicial,reactivainicial FROM lecturaxmes WHERE vivienda_id= ? ORDER BY Id DESC LIMIT 1";
    
   
    
    $stmt = $enlace2->stmt_init();
    if(!$stmt->prepare($_sql))
    {

        $_error = "Error en la preparacion de la consulta";

    }else{

        $stmt->bind_param('s',$vivienda_id);
        if ($stmt->execute()) {

            $stmt->bind_result($_periodo, $_activa,$_reactiva);
            while ($stmt->fetch()) {
                
                $periodo = $_periodo; 
                $activa = $_activa;
                $reactiva = $_reactiva; 
            }

        }else{
           $_error = $stmt->error; 
        }
    }
    
    
    return [$periodo,$activa,$reactiva,$_error];
}





/*Funcion que entrega el periodo en el cual se encuentra
 * una vivieda
 */
function periodoactual($dialectura){
    
    $_year = date('y');
    $_mes  = date('m');
    $_dia = date('d');
    $ultimoDia = getultimodia($_year,$_mes); 
    
    if($_dia<=$dialectura and $dialectura<=$ultimoDia){
         $_periodoactual =   $_year."-".$_mes; 
         $_nextperiodo = $_periodoactual;
    }else{
        
       //Obteniendo dias del mes siguiente ===================================================== 
       $expire = strtotime('first day of +1 month');
       $_nextperiodo=date('y-m', $expire);
    }
    
    
    return $_nextperiodo;
}

/*Funcion que entrega
 * los valores en la tabla lecturas del utlimo dia recolectado
 */

function lastdia($medidor_id,$preciokwmensual,$name_home){
 
    require 'config.php';
 
    $_namefile= $name_home;
     $enlace2 = new mysqli($wm_host[$_namefile], $wm_user[$_namefile], $wm_password[$_namefile], $wm_dbname[$_namefile]);
    $_error=0;
    
    if ($enlace2->connect_error) {
        return "Connection failed: " . $enlace2->connect_error;
    }
    
    $_sql="SELECT date(fecha_hora),activa,reactiva FROM lecturas WHERE medidor_id= ? ORDER BY fecha_hora DESC LIMIT 1";
    
    /*$file = fopen("test.txt","w");
    fwrite($file,'aqui que llega'.$_sql.'-'.$medidor_id);
    fclose($file);*/
    
    $stmt = $enlace2->stmt_init();
    if(!$stmt->prepare($_sql))
    {

        $_error = "Error en la preparacion de la consulta";

    }else{

        $stmt->bind_param('s',$medidor_id);
        if ($stmt->execute()) {

            $stmt->bind_result($_periodo, $_activa,$_reactiva);
            
            while ($stmt->fetch()) {
                
                $periodo = $_periodo; 
                $activa = $_activa;
                $reactiva = $_reactiva; 
            }

        }else{
           $_error = $stmt->error; 
        }

    }
    
    return [$periodo,$activa,$reactiva,$_error];
    
}


/*Funcion que valida el login
 * @username
 * @password
 */
function login($_user,$_password){
    
    require 'config.php';
    
    $enlace2 = new mysqli($wm_host["redirect"], $wm_user["redirect"], $wm_password["redirect"], $wm_dbname["redirect"]);
    $_error=0;
    $cantidad=0;
    
    if ($enlace2->connect_error) {
        $_error = "No hay conexion con la base de datos";
    }
    
    
    
    
    //Averiguando BD=======================================================================
    $_sql="SELECT name FROM namedatauser WHERE username= ? ";
    
    $stmt = $enlace2->stmt_init();
    if(!$stmt->prepare($_sql))
    {

        $_error = "Error en la preparacion de la consulta";

    }else{
        
        $stmt->bind_param('s',$_user);
        
        if ($stmt->execute()) {

            $stmt->bind_result($_namefile);
            
            while ($stmt->fetch()) {
                $_namefile = $_namefile; 
            }
            
            if($cantidad == 0){
                $_error = "Usuario incorrecto";
            }

        }else{
           $_error = $stmt->error; 
        }
    }
    
    mysqli_close($enlace2);
    
    // ========================================================================================================
    // Cargando loguin de usuario==============================================================================
    // ========================================================================================================
    if($stmt->num_rows==0){
        echo 'User No valido';
        die();
    }
    $enlace2 = new mysqli($wm_host[$_namefile], $wm_user[$_namefile], $wm_password[$_namefile], $wm_dbname[$_namefile]);
    $_error=0;
    $cantidad=0;
    
    if ($enlace2->connect_error) {
        $_error = "No hay conexion con la base de datos";
    }
    
    
    $_sql="SELECT tarjeta.Id,tarjeta.ip,modbus,`user`.id,count(`user`.Id),CONCAT(torre.abreviatura,vivienda.apto) as vivienda FROM `user`
LEFT JOIN vivienda ON vivienda.cliente_id = `user`.Id
LEFT JOIN medidores ON medidores.Id = vivienda.medidor_id
LEFT JOIN tarjeta ON tarjeta.Id = medidores.tarjeta
LEFT JOIN torre ON vivienda.torre_id = torre.Id
WHERE username= ? and `password`= ?";
    
    $stmt = $enlace2->stmt_init();
    if(!$stmt->prepare($_sql))
    {

        $_error = "Error en la preparacion de la consulta";

    }else{
        
        $stmt->bind_param('ss',$_user,$_password);
        
        if ($stmt->execute()) {

            $stmt->bind_result($_idtarjeta,$_iptarjeta,$_modbus,$_usuarioid,$_cantidad,$_vivienda);
            
            while ($stmt->fetch()) {
                $cantidad = $_cantidad; 
                $idtarjeta = $_idtarjeta;
                $iptarjeta = $_iptarjeta;
                $modbus = $_modbus;
                $usuarioid = $_usuarioid;
                $vivienda = $_vivienda;
            }
            
            if($cantidad == 0){
                $_error = "Usuario o Contraseña incorrectos";
            }

        }else{
           $_error = $stmt->error; 
        }
        
    }
    mysqli_close($enlace2);
    
    if(empty($_namefile)){
        return ["-1"];
    }else{
        return [$cantidad,$idtarjeta,$iptarjeta,$modbus,$usuarioid,$_error,$_namefile,$vivienda];
    }
    
}

function getultimodia($elAnio,$elMes) {
    return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
}

