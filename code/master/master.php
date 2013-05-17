#!/usr/bin/php
<?php 
error_reporting(E_ALL);
date_default_timezone_set("America/Toronto"); 

set_time_limit(0); // do not timeout

$hostname = gethostname(); 
$address = "192.168.100.22";
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

// Bind the source address
if( !socket_listen($sock, 5) ){	
	$errorcode = socket_last_error();
	$errormsg = socket_strerror($errorcode);
	_log("[error] Couldn't listen to socket: [$errorcode] $errormsg.");
	exit(1);
}

//clients array
$clients = array();

do {
    $read = array();
    $read[] = $sock;
    
    $read = array_merge($read,$clients);
    
    // Set up a blocking call to socket_select
    if(socket_select($read, $write, $except,5) < 1)
    {
        //    SocketServer::debug("Problem blocking socket_select?");
        echo ".";
        continue;
    }
    
    // Handle new Connections
    if (in_array($sock, $read)) {        
        
        if (($msgsock = socket_accept($sock)) === false) {
        	$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			_log("[error] Couldn't accept socket: [$errorcode] $errormsg.");
            break;
        }
        $clients[] = $msgsock;
        $key = array_keys($clients, $msgsock);
        
        $msg = "\nWelcome to the PHP Test Server. \n" .
        "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
        socket_write($msgsock, $msg, strlen($msg));
        
    }
    
    // Handle Input
    foreach ($clients as $key => $client) { // for each client        
        if (in_array($client, $read)) {
        	
            if (false === ($buf = socket_read($client, 2048, PHP_NORMAL_READ))) {
            	$errorcode = socket_last_error();
				$errormsg = socket_strerror($errorcode);
                _log("[error] Couldn't read from socket: [$errorcode] $errormsg.");
                break 2;
            }
            if (!$buf = trim($buf)) {
                continue;
            }
            if ($buf == 'quit') {
                unset($clients[$key]);
                socket_close($client);
                break;
            }
            if ($buf == 'shutdown') {
                socket_close($client);
                break 2;
            }
            
            $talkback = "Cliente {$key}: '$buf'.\n";
            socket_write($client, $talkback, strlen($talkback));
            _log($buf);
        }
        
    }        
} while (true);

socket_close($sock); // close this socket

/**
* write whatever is in the $log. 
*/
function _log($log){
	$message = sprintf("[%s]%s\n", date("Y-m-d H:i:s"), $log);

	file_put_contents("master.log", $message, FILE_APPEND);
}
?>