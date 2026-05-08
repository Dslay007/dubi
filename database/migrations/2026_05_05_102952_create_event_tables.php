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
        // 1. Berita Acara (Manajemen Acara)
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Form Pendaftaran Kegiatan
        Schema::create('event_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('form_title');
            $table->text('description')->nullable();
            $table->string('google_sheet_url')->nullable(); // Untuk link spreadsheet
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Atur Pertanyaan (Form Builder)
        Schema::create('event_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_form_id')->constrained('event_forms')->onDelete('cascade');
            $table->string('field_label');
            $table->string('field_type'); // text, textarea, email, select, radio, checkbox
            $table->json('options')->nullable(); // JSON array of options for select/radio/checkbox
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. List Pendaftar
        Schema::create('event_registrants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_form_id')->constrained('event_forms')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('status')->default('pending'); // pending, confirmed
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
        });

        // 5. Jawaban Pendaftar
        Schema::create('event_registrant_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrant_id')->constrained('event_registrants')->onDelete('cascade');
            $table->foreignId('field_id')->constrained('event_form_fields')->onDelete('cascade');
            $table->text('answer_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrant_answers');
        Schema::dropIfExists('event_registrants');
        Schema::dropIfExists('event_form_fields');
        Schema::dropIfExists('event_forms');
        Schema::dropIfExists('events');
    }
};
