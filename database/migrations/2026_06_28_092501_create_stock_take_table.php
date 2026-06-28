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
        Schema::create('stock_take', function (Blueprint $table) {
            $table->integer('stock_take_id');
            $table->string('stock_take_name', 200);
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('init_user', 50);
            $table->integer('total_item_stock_taked')->nullable();
            $table->integer('total_item_lost')->nullable();
            $table->integer('total_item_exists')->nullable()->default(0);
            $table->integer('total_item_loan')->nullable();
            $table->mediumText('stock_take_users')->nullable();
            $table->integer('is_active')->default(0);
            $table->string('report_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_take');
    }
};
