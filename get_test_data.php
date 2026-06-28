<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$m = App\Models\Member::first();
echo "member_id: " . $m->member_id . "\n";

$items = App\Models\Item::whereNotIn('item_code', App\Models\Loan::where('is_return', 0)->pluck('item_code'))->limit(3)->pluck('item_code');
echo "available_items: " . implode(',', $items->toArray()) . "\n";

$loan = App\Models\Loan::where('is_return', 0)->first();
echo "active_loan_id: " . ($loan ? $loan->loan_id : 'none') . "\n";
echo "active_loan_item: " . ($loan ? $loan->item_code : 'none') . "\n";
