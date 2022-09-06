<?php
/*
 *  Example of HOWTO: PHP TCP Server/Client with SSL Encryption using Streams
 *  Client side Script
 *
 *  Website : http://blog.leenix.co.uk/2011/05/howto-php-tcp-serverclient-with-ssl.html
 */

$ip="192.168.43.225";     //Set the TCP IP Address to connect too
$port="5084";        //Set the TCP PORT to connect too
$command="GET_READER_CONFIG";       //Command to run

$socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

if(socket_connect($socket,$ip,$port)){
	echo "Conexion con exito";
}else{
	echo "Error";	
}

socket_write($socket,$command,strlen($command));
echo "Ok";

while($out=socket_read($socket,5084)){
	echo $out;	
}
?>