#!/usr/bin/php
<?php 
set_time_limit(0); // do not timeout
$sock = socket_create(AF_INET, SOCK_STREAM, 0);

$hostname = gethostname(); 
$address = gethostname();
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

while($con == 1){

	$client = socket_accept($sock);
	$input = socket_read($client, 1024);

	if ($input == 'exit') {
		$close = socket_close($sock);
		$con = 0;
	}

	if($con == 1) {
		_log($input);
	}

}






socket_close($socket); // close this socket

/**
* write whatever is in the $log. 
*/
function _log($log){
	$message = sprintf("[%s] %s\n", date("H:i:s Y-m-d"), $log);

	file_put_contents("master.log", $message, FILE_APPEND);
}
?>