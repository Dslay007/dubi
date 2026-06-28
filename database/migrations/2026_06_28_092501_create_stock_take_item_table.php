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
        Schema::create('stock_take_item', function (Blueprint $table) {
            $table->integer('stock_take_id');
            $table->integer('item_id');
            $table->string('item_code', 20);
            $table->string('title');
            $table->string('gmd_name', 30)->nullable();
            $table->string('classification', 30)->nullable();
            $table->string('coll_type_name', 30)->nullable();
            $table->string('call_number', 50)->nullable();
            $table->string('location', 100)->nullable();
            $table->enum('status', ['e', 'm', 'u', 'l'])->default('m');
            $table->string('checked_by', 50)->nullable();
            $table->dateTime('last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_take_item');
    }
};
