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
        Schema::create('visitor_count', function (Blueprint $table) {
            $table->integer('visitor_id', true);
            $table->string('member_id', 20)->nullable()->index('member_id');
            $table->string('member_name');
            $table->string('institution', 100)->nullable();
            $table->dateTime('checkin_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_count');
    }
};
