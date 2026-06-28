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
        Schema::create('search_biblio', function (Blueprint $table) {
            $table->comment('index table for advance searching technique for SLiMS');
            $table->integer('biblio_id');
            $table->text('title')->nullable();
            $table->string('edition', 50)->nullable();
            $table->string('isbn_issn', 32)->nullable();
            $table->text('author')->nullable();
            $table->text('topic')->nullable();
            $table->string('gmd', 30)->nullable();
            $table->string('publisher', 100)->nullable();
            $table->string('publish_place', 30)->nullable();
            $table->string('language', 20)->nullable();
            $table->string('classification', 40)->nullable();
            $table->text('spec_detail_info')->nullable();
            $table->string('carrier_type', 100);
            $table->string('content_type', 100);
            $table->string('media_type', 100);
            $table->text('location')->nullable();
            $table->string('publish_year', 20)->nullable();
            $table->text('notes')->nullable();
            $table->text('series_title')->nullable();
            $table->text('items')->nullable();
            $table->text('collection_types')->nullable();
            $table->string('call_number', 50)->nullable();
            $table->smallInteger('opac_hide')->default(0);
            $table->smallInteger('promoted')->default(0);
            $table->text('labels')->nullable();
            $table->string('collation', 100)->nullable();
            $table->string('image', 100)->nullable();
            $table->dateTime('input_date')->nullable();
            $table->dateTime('last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_biblio');
    }
};
