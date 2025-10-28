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
        Schema::create('show_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seat_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['available', 'pending', 'booked', 'blocked'])->default('available');
            $table->decimal('price_override', 10, 2)->nullable();
            $table->dateTime('locked_until')->nullable();
            $table->timestamps();
            // a seat can appear only once per show
            $table->unique(['show_id', 'seat_id']);
            $table->index(['show_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('show_seats');
    }
};
