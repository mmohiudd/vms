<?php
error_reporting(E_ALL);
date_default_timezone_set("America/Toronto"); 
set_time_limit(0); // do not timeout

$hostname = "master1.localhost";
$address = gethostbyname($hostname);
$port = 5000;

echo "started slave daemon $hostname \n";

_log("started slave daemon " . $hostname);

do{

	$connected = True;
	if(!($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))) {
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
		_log("connected to " . $hostname);
		$message = "Hello from " . gethostname();

		if(!socket_write($sock, $message, strlen($message))){
			$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			_log("[error] Couldn't send to socket: [$errorcode] $errormsg.");
		} else {
			_log(sprintf("sent '%s' to %s(%s)", $message, $hostname, $address));
		}
	}

	socket_close($sock);

	sleep(5); // sleep for 5 seconds
}while(True);






/**
* write whatever is in the $log. 
*/
function _log($log){
	$message = sprintf("[%s]%s\n", date("Y-m-d H:i:s"), $log);

	file_put_contents("log", $message, FILE_APPEND);
}
?>