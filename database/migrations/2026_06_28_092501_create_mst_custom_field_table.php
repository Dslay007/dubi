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
        Schema::create('mst_custom_field', function (Blueprint $table) {
            $table->integer('field_id');
            $table->string('primary_table', 100)->nullable();
            $table->string('dbfield', 50);
            $table->string('label', 80);
            $table->enum('type', ['text', 'checklist', 'numeric', 'dropdown', 'longtext', 'choice', 'date']);
            $table->string('default', 80)->nullable();
            $table->integer('max')->nullable();
            $table->text('data')->nullable();
            $table->boolean('indexed')->nullable();
            $table->string('class', 100)->nullable();
            $table->boolean('is_public')->nullable();
            $table->integer('width')->nullable()->default(100);
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_custom_field');
    }
};
