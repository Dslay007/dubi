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
        Schema::create('index_documents', function (Blueprint $table) {
            $table->integer('document_id');
            $table->bigInteger('word_id');
            $table->string('location', 50);
            $table->integer('hit_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_documents');
    }
};
