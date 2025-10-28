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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screen_id')->constrained()->cascadeOnDelete();
            $table->string('row_label');          // A, B, ..., AA
            $table->unsignedSmallInteger('row_index'); // 1,2,3...
            $table->unsignedSmallInteger('col_number'); // 1..N
            $table->string('seat_number');        // e.g., A01 (unique per screen)
            $table->enum('type', ['regular', 'premium', 'vip'])->default('regular');
            $table->enum('status', ['available', 'pending', 'booked', 'blocked'])->default('available');
            $table->decimal('price_override', 10, 2)->nullable();
            // Fast lookups in UI grids
            $table->index(['screen_id', 'row_index', 'col_number']);

            // Unique constraints
            $table->unique(['screen_id', 'seat_number']);
            $table->unique(['screen_id', 'row_index', 'col_number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
