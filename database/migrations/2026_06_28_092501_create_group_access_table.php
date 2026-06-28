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
        Schema::create('group_access', function (Blueprint $table) {
            $table->integer('group_id');
            $table->integer('module_id');
            $table->longText('menus')->nullable();
            $table->integer('r')->default(0);
            $table->integer('w')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_access');
    }
};
