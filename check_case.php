<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$loans = \App\Models\Loan::whereIn('item_code', ['Db00429', 'db00444', 'DB00429', 'DB00444'])->get(['loan_id', 'item_code']);
foreach($loans as $l) {
    echo $l->loan_id . ' -> Loan: ' . $l->item_code;
    $item = \App\Models\Item::where('item_code', $l->item_code)->first();
    echo ' | Item in DB: ' . ($item ? $item->item_code : 'NOT FOUND') . PHP_EOL;
}
