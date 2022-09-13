<?php
require_once "vendor/Ratchet/Http/HttpServer.php";
require_once "vendor/Ratchet/Server/IoServer.php";
require_once "vendor/Ratchet/WebSocket/WsServer.php";
require_once "vendor/react/event-loop/src/Loop.php";
require_once "vendor/react/socket/src/SocketServer.php";
require_once "class/Chat.php";

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Loop;

// HTTPS
try {
	/*
		// HTTP
		$server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new Chat()
				)
			),
			8080
		);

		$server->run();
	*/
	// HTTPS
	$app = new HttpServer(
		new WsServer(
			new Chat()
		)
	);

	$loop = Loop::get();
	/*$secure_websockets = new React\Socket\SocketServer('127.0.0.1:8090', array(
		'local_cert' => 'C:/xampp/apache/crt/mutillidae.site/server.crt', // path to your cert
		'local_pk' => 'C:/xampp/apache/crt/mutillidae.site/server.key', // path to your server private key
		'verify_peer' => false,
		'allow_self_signed' => true
	), $loop);*/
	$secure_websockets = new React\Socket\SocketServer('127.0.0.1:8090', array('tls' => array(
		'local_cert' => 'C:/xampp/apache/crt/mutillidae.site/server.crt', // path to your cert
		'local_pk' => 'C:/xampp/apache/crt/mutillidae.site/server.key', // path to your server private key
		'verify_peer' => false,
	    'allow_self_signed' => true,
		'passphrase' => 'pippo123',
	)), $loop);

	$secure_websockets_server = new IoServer($app, $secure_websockets, $loop);
	$secure_websockets_server->run();
} catch (Exception $e) {
	echo $e->getMessage();
	//echo $e->getTraceAsString();
	exit(0);
} // fine try - catch
?>
