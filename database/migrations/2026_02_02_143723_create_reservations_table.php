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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservation_id');
            $table->string('member_id', 20);
            $table->string('item_code', 20);
            $table->date('reservation_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Foreign keys if tables use standard IDs, but SLiMS uses custom string IDs often
            // We'll index them for performance
            $table->index('member_id');
            $table->index('item_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
