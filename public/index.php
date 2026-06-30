<?php

use Illuminate\Http\Request;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

try {

    $app->handleRequest(Request::capture());

} catch (Throwable $e) {

    echo "<pre>";

    echo get_class($e).PHP_EOL.PHP_EOL;

    echo $e->getMessage().PHP_EOL.PHP_EOL;

    echo $e->getFile().":".$e->getLine().PHP_EOL.PHP_EOL;

    echo $e->getTraceAsString();

}