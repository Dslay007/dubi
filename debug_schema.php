<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== USER TABLE ===\n";
$cols = Illuminate\Support\Facades\Schema::getColumnListing('user');
echo implode(', ', $cols) . "\n\n";

echo "=== USER_GROUP TABLE ===\n";
$cols2 = Illuminate\Support\Facades\Schema::getColumnListing('user_group');
echo implode(', ', $cols2) . "\n\n";

echo "=== GROUP_ACCESS TABLE ===\n";
$cols3 = Illuminate\Support\Facades\Schema::getColumnListing('group_access');
echo implode(', ', $cols3) . "\n\n";

echo "=== EXISTING USERS ===\n";
$users = Illuminate\Support\Facades\DB::table('user')->get(['user_id', 'username', 'realname', 'groups']);
foreach ($users as $u) {
    echo "ID: {$u->user_id}, username: {$u->username}, realname: {$u->realname}, groups: {$u->groups}\n";
}

echo "\n=== EXISTING ROLES ===\n";
$roles = Illuminate\Support\Facades\DB::table('user_group')->get();
foreach ($roles as $r) {
    echo json_encode($r) . "\n";
}

echo "\n=== EXISTING GROUP_ACCESS ===\n";
$access = Illuminate\Support\Facades\DB::table('group_access')->get();
foreach ($access as $a) {
    echo json_encode($a) . "\n";
}
