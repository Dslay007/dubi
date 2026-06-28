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
        Schema::create('event_registrants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_form_id')->index('event_registrants_event_form_id_foreign');
            $table->string('name');
            $table->string('email');
            $table->string('status')->default('pending');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrants');
    }
};
