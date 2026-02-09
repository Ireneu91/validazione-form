<?php
declare(strict_types=1);

use App\App; // App = src (è scritto in composer.json)
use App\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

$app = new App();
$request = Request::fromGlobals(); // metodo statico per raccogliere la richiesta del browser che immagazzino nella variabile $request
print_r($request);
$response = $app->handle($request); // elaborazione risposta

$response->send(); // invio la risposta al browser

echo "Get: \n";
var_dump($_GET);
echo "Post: \n";
var_dump($_POST);
echo "Server: \n";
var_dump($_SERVER);