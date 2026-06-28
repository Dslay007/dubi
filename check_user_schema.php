<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $cols = Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM user');
    foreach ($cols as $col) {
        echo $col->Field . " | " . $col->Type . PHP_EOL;
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
