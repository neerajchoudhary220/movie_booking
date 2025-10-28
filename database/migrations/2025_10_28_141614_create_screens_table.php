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
        Schema::create('screens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theatre_id')->constrained()->cascadeOnDelete();
            $table->string('name');                 // e.g., "Screen 1", "IMAX"
            $table->unsignedInteger('capacity');    // total seats
            $table->unsignedSmallInteger('rows')->default(10);
            $table->unsignedSmallInteger('cols')->default(10);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            // Unique screen name per theatre
            $table->unique(['theatre_id', 'name']);
            $table->index(['theatre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screens');
    }
};
