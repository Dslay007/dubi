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
        Schema::create('read_counter', function (Blueprint $table) {
            $table->integer('id');
            $table->string('item_code', 20);
            $table->string('title');
            $table->dateTime('created_at');
            $table->integer('uid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('read_counter');
    }
};
