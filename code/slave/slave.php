<?php
error_reporting(E_ALL);
date_default_timezone_set("America/Toronto"); 
set_time_limit(0); // do not timeout

$sock = socket_create(AF_INET, SOCK_STREAM, 0);

$hostname = "master1.localhost";
$address = gethostbyname($hostname);
$port = 5000;

_log("started slave daemon " . $hostname);


do{
	$connected = True;
	if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		_log("[error] Couldn't create socket: [$errorcode] $errormsg.");
		$connected = False;
		
	}

	// Bind the source address
	if( !socket_connect($sock, $address , $port) ){	
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		_log("[error] Couldn't connect to socket: [$errorcode] $errormsg.");
		$connected = False;
	}
	
	if($connected){
		$message = "Hello from " . gethostname();
		socket_write($sock, $message, strlen($message));
		_log("connected to " . $hostname);
	}

	sleep(5); // sleep for 5 seconds
}while(True);






/**
* write whatever is in the $log. 
*/
function _log($log){
	$message = sprintf("[%s]%s\n", date("Y-m-d H:i:s"), $log);

	file_put_contents("slave.log", $message, FILE_APPEND);
}
?>