#!/usr/bin/php
<?php 
error_reporting(E_ALL);
date_default_timezone_set("America/Toronto"); 

set_time_limit(0); // do not timeout
$sock = socket_create(AF_INET, SOCK_STREAM, 0);

$hostname = gethostname(); 
$address = gethostbyname($hostname);
$port = 5000;

_log("started master daemon " . $hostname);

if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
	$errorcode = socket_last_error();
	$errormsg = socket_strerror($errorcode);
	_log("[error] Couldn't create socket: [$errorcode] $errormsg.");
	exit(1);
}

// Bind the source address
if( !socket_bind($sock, $address , $port) ){	
	$errorcode = socket_last_error();
	$errormsg = socket_strerror($errorcode);
	_log("[error] Couldn't bind socket: [$errorcode] $errormsg.");
	exit(1);
}

socket_listen($sock);

$loop = 1;

while($loop == 1){

	$client = socket_accept($sock);
	$input = socket_read($client, 1024);
	echo $input . "\n\n";

	if ($input == 'exit') {
		$close = socket_close($sock);
		$loop = 0;
	}

	if($loop == 1) {
		_log($input);
	}

}






socket_close($sock); // close this socket

/**
* write whatever is in the $log. 
*/
function _log($log){
	$message = sprintf("[%s]%s\n", date("Y-m-d H:i:s"), $log);

	file_put_contents("master.log", $message, FILE_APPEND);
}
?>