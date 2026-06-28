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
        Schema::table('event_form_fields', function (Blueprint $table) {
            $table->foreign(['event_form_id'])->references(['id'])->on('event_forms')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_form_fields', function (Blueprint $table) {
            $table->dropForeign('event_form_fields_event_form_id_foreign');
        });
    }
};
