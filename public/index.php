<?php

use Illuminate\Http\Request;

echo "STEP 1<br>";

require __DIR__.'/../vendor/autoload.php';

echo "STEP 2<br>";

$app = require_once __DIR__.'/../bootstrap/app.php';

echo "STEP 3<br>";

$request = Request::capture();

echo "STEP 4<br>";

$app->handleRequest($request);

echo "STEP 5<br>";