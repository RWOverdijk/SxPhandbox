<?php
require __DIR__ . '/../vendor/autoload.php';

define('SNIPPET_DIR', __DIR__ . '/../data/snippets/');

$app = function ($request, $response) {
    $action     = ucfirst(strstr(trim($request->getPath(), '/ ').'/', '/', true));
    
    if ($action === '') {
        $action = 'Index';
    }
    
    $actionFile = __DIR__ . "/../actions/{$action}Action.php";
    
    if (!file_exists($actionFile)) {
        $response->writeHead(404);
        $response->end('');
        return;
    }
    
    require_once $actionFile;
    
    $actionClass    = $action."Action";
    $actionInstance = new $actionClass($request);
    
    $response->writeHead(200, array('Content-Type' => $actionInstance->getContentType()));
    $response->end($actionInstance->execute());
};

$loop   = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$http   = new React\Http\Server($socket, $loop);

$http->on('request', $app);

echo "Server running at http://127.0.0.1:1337\n";

$socket->listen(1337);
$loop->run();
