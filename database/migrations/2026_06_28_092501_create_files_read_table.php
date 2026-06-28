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
        Schema::create('files_read', function (Blueprint $table) {
            $table->integer('filelog_id');
            $table->integer('file_id');
            $table->timestamp('date_read')->useCurrentOnUpdate()->useCurrent();
            $table->string('member_id', 20)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('client_ip', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files_read');
    }
};
