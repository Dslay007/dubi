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
        Schema::create('kardex', function (Blueprint $table) {
            $table->integer('kardex_id');
            $table->date('date_expected');
            $table->date('date_received')->nullable();
            $table->string('seq_number', 25)->nullable();
            $table->text('notes')->nullable();
            $table->integer('serial_id')->nullable();
            $table->date('input_date');
            $table->date('last_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardex');
    }
};
