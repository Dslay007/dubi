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
        Schema::create('mst_frequency', function (Blueprint $table) {
            $table->integer('frequency_id');
            $table->string('frequency', 25);
            $table->string('language_prefix', 5)->nullable();
            $table->smallInteger('time_increment')->nullable();
            $table->enum('time_unit', ['day', 'week', 'month', 'year'])->nullable()->default('day');
            $table->date('input_date');
            $table->date('last_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_frequency');
    }
};
