<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mst_item_status', function (Blueprint $table) {
            $table->char('item_status_id', 3);
            $table->string('item_status_name', 30);
            $table->string('rules')->nullable();
            $table->smallInteger('no_loan')->default(0);
            $table->smallInteger('skip_stock_take')->default(0);
            $table->date('input_date')->nullable();
            $table->date('last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_item_status');
    }
};
