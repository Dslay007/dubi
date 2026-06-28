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
        Schema::table('event_registrant_answers', function (Blueprint $table) {
            $table->foreign(['field_id'])->references(['id'])->on('event_form_fields')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['registrant_id'])->references(['id'])->on('event_registrants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_registrant_answers', function (Blueprint $table) {
            $table->dropForeign('event_registrant_answers_field_id_foreign');
            $table->dropForeign('event_registrant_answers_registrant_id_foreign');
        });
    }
};
