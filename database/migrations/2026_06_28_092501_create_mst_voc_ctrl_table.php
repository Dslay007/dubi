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
        Schema::create('mst_voc_ctrl', function (Blueprint $table) {
            $table->integer('vocabolary_id');
            $table->integer('topic_id');
            $table->string('rt_id', 11);
            $table->string('related_topic_id', 250);
            $table->text('scope')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_voc_ctrl');
    }
};
