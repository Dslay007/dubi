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
        Schema::create('reserve', function (Blueprint $table) {
            $table->integer('reserve_id');
            $table->string('member_id', 20);
            $table->integer('biblio_id');
            $table->string('item_code', 20);
            $table->dateTime('reserve_date');
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserve');
    }
};
