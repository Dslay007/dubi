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
        Schema::create('biblio_log', function (Blueprint $table) {
            $table->integer('biblio_log_id');
            $table->integer('biblio_id');
            $table->integer('user_id');
            $table->string('realname', 100);
            $table->text('title');
            $table->string('ip', 200);
            $table->string('action', 50);
            $table->string('affectedrow', 50);
            $table->text('rawdata');
            $table->text('additional_information');
            $table->dateTime('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biblio_log');
    }
};
