<?php
error_reporting(E_ALL);
date_default_timezone_set("America/Toronto"); 
/*
// Get the port for the WWW service.
$service_port = getservbyname('www', 'tcp');

// Get the IP address for the target host.
$address = gethostbyname('www.example.com');

// Create a TCP/IP socket. 
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "OK.\n";
}

echo "Attempting to connect to '$address' on port '$service_port'...";
$result = socket_connect($socket, $address, $service_port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK.\n";
}

$in = "HEAD / HTTP/1.1\r\n";
$in .= "Host: www.example.com\r\n";
$in .= "Connection: Close\r\n\r\n";
$out = '';

echo "Sending HTTP HEAD request...";
socket_write($socket, $in, strlen($in));
echo "OK.\n";

echo "Reading response:\n\n";
while ($out = socket_read($socket, 2048)) {
    echo $out;
}

echo "Closing socket...";
socket_close($socket);
echo "OK.\n\n";

*/
set_time_limit(0); // do not timeout
$sock = socket_create(AF_INET, SOCK_STREAM, 0);

$hostname = "master1.localhost";
$address = gethostbyname($hostname);
$port = 5000;

_log("started slave daemon " . $hostname);

if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
	$errorcode = socket_last_error();
	$errormsg = socket_strerror($errorcode);
	_log("[error] Couldn't create socket: [$errorcode] $errormsg.");
	exit(1);
}

_log(sprintf("connect to %s %s:%s", $hostname, $address, $port));

// Bind the source address
if( !socket_bind($sock, $address , $port) ){	
	$errorcode = socket_last_error();
	$errormsg = socket_strerror($errorcode);
	_log("[error] Couldn't bind socket: [$errorcode] $errormsg.");
	exit(1);
}

socket_listen($sock);

while($con == 1){
	socket_write($socket, $in, strlen($in));

	$client = socket_accept($sock);
	$input = socket_read($client, 1024);

	if($con == 1) {
		_log($input);
	}

	sleep(2); // sleep for 2 seconds
}






socket_close($socket); // close this socket

/**
* write whatever is in the $log. 
*/
function _log($log){
	$message = sprintf("[%s]%s\n", date("Y-m-d H:i:s"), $log);

	file_put_contents("slave.log", $message, FILE_APPEND);
}
?>