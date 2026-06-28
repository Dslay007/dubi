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
        Schema::create('content', function (Blueprint $table) {
            $table->integer('content_id');
            $table->string('content_title');
            $table->text('content_desc');
            $table->string('content_path', 20);
            $table->smallInteger('is_news')->nullable();
            $table->dateTime('input_date');
            $table->dateTime('last_update');
            $table->enum('content_ownpage', ['1', '2'])->default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content');
    }
};
