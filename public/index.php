<?php
declare(strict_types=1);

use App\App;
use App\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

$app = new App();
$request = Request::fromGlobals();
$response = $app->handle($request);

$response->send();
