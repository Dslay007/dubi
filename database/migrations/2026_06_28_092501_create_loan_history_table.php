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
        Schema::create('loan_history', function (Blueprint $table) {
            $table->integer('loan_id');
            $table->string('item_code', 20)->nullable();
            $table->integer('biblio_id');
            $table->string('title', 300)->nullable();
            $table->string('call_number', 50)->nullable();
            $table->string('classification', 40)->nullable();
            $table->string('gmd_name', 30)->nullable();
            $table->string('language_name', 20)->nullable();
            $table->string('location_name', 100)->nullable();
            $table->string('collection_type_name', 100)->nullable();
            $table->string('member_id', 20)->nullable();
            $table->string('member_name', 100)->nullable();
            $table->string('member_type_name', 64)->nullable();
            $table->date('loan_date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('renewed')->default(0);
            $table->integer('is_lent')->default(0);
            $table->integer('is_return')->default(0);
            $table->date('return_date')->nullable();
            $table->dateTime('input_date')->nullable();
            $table->dateTime('last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_history');
    }
};
