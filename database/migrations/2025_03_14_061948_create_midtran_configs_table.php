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
        Schema::create('midtran_configs', function (Blueprint $table) {
            $table->id();
            $table->enum('environment', ['production', 'sandbox']);
            $table->longtext('sandbox_client_key')->nullable();
            $table->longtext('sandbox_server_key')->nullable();
            $table->longtext('production_client_key')->nullable();
            $table->longtext('production_server_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midtran_configs');
    }
};
