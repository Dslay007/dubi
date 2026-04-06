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
        Schema::create('member_types', function (Blueprint $table) {
            $table->id('member_type_id');
            $table->string('member_type_name');
            $table->integer('loan_limit')->default(0);
            $table->integer('loan_periode')->default(0);
            $table->integer('fine_each_day')->default(0);
            $table->integer('grace_period')->default(0);
            
            // SLiMS timestamps
            $table->datetime('input_date')->useCurrent();
            $table->datetime('last_update')->useCurrent()->useCurrentOnUpdate();
            
            $table->timestamps(); // Keeps standard too if needed, or remove
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_types');
    }
};
