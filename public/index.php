<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

$request = Illuminate\Http\Request::capture();

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle($request);

echo "HANDLE OK";
exit;