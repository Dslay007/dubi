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
        Schema::create('mst_module', function (Blueprint $table) {
            $table->integer('module_id');
            $table->string('module_name', 50);
            $table->string('module_path', 200)->nullable();
            $table->string('module_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_module');
    }
};
