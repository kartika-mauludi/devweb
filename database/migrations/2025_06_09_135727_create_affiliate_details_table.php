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
        Schema::create('affiliate_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_comission_id')->references('id')->on('affiliate_comissions')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_details');
    }
};
