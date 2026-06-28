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
        Schema::create('mst_media_type', function (Blueprint $table) {
            $table->integer('id');
            $table->string('media_type', 100);
            $table->string('code', 5);
            $table->char('code2', 1);
            $table->dateTime('input_date');
            $table->dateTime('last_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_media_type');
    }
};
