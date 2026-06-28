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
        Schema::create('mst_visitor_room', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name', 50);
            $table->string('unique_code', 5)->comment('Code for identification each room');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_visitor_room');
    }
};
