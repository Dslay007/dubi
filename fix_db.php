<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('reserve', 'status')) {
    Schema::table('reserve', function (Blueprint $table) {
        $table->string('status')->default('pending');
    });
    echo "Added status column.\n";
}

if (!Schema::hasColumn('reserve', 'notes')) {
    Schema::table('reserve', function (Blueprint $table) {
        $table->text('notes')->nullable();
    });
    echo "Added notes column.\n";
}

echo "Done.\n";
