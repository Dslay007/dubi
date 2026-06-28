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
        Schema::create('mst_servers', function (Blueprint $table) {
            $table->integer('server_id');
            $table->string('name');
            $table->text('uri');
            $table->boolean('server_type')->default(true)->comment('1 - p2p server; 2 - z3950; 3 - z3950  SRU');
            $table->dateTime('input_date');
            $table->dateTime('last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_servers');
    }
};
