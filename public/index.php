<?php

echo "STEP 1<br>";

require __DIR__.'/../vendor/autoload.php';

echo "STEP 2<br>";

$app = require_once __DIR__.'/../bootstrap/app.php';

echo "STEP 3<br>";
exit;