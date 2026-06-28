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
        Schema::create('mst_supplier', function (Blueprint $table) {
            $table->integer('supplier_id');
            $table->string('supplier_name', 100);
            $table->string('address', 100)->nullable();
            $table->char('postal_code', 10)->nullable();
            $table->char('phone', 14)->nullable();
            $table->char('contact', 30)->nullable();
            $table->char('fax', 14)->nullable();
            $table->char('account', 12)->nullable();
            $table->char('e_mail', 80)->nullable();
            $table->date('input_date')->nullable();
            $table->date('last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_supplier');
    }
};
