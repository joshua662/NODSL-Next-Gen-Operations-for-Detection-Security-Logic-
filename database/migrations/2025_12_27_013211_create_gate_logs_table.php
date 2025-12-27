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
        Schema::create('gate_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->nullable()->constrained()->onDelete('set null');
            $table->string('plate_number');
            $table->string('owner_name')->nullable();
            $table->string('car_model')->nullable();
            $table->string('car_color')->nullable();
            $table->enum('status', ['authorized', 'unauthorized']);
            $table->string('image_path')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();

            $table->index('plate_number');
            $table->index('timestamp');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gate_logs');
    }
};
