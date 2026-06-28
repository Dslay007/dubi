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
        Schema::create('serial', function (Blueprint $table) {
            $table->integer('serial_id');
            $table->date('date_start');
            $table->date('date_end')->nullable();
            $table->string('period', 100)->nullable();
            $table->text('notes')->nullable();
            $table->integer('biblio_id')->nullable();
            $table->integer('gmd_id')->nullable();
            $table->date('input_date');
            $table->date('last_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial');
    }
};
