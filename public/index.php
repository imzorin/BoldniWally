<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

try {

    $request = Illuminate\Http\Request::capture();

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle($request);

    echo "<pre>";
    var_dump($response->getStatusCode());
    echo "\n\n";
    echo $response->getContent();

} catch (\Throwable $e) {

    echo "<h2>EXCEPTION CAUGHT</h2>";

    echo "<pre>";
    echo $e;
}