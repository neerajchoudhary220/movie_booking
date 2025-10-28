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
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('screen_id')->constrained()->cascadeOnDelete();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->decimal('base_price', 10, 2)->default(120.00);
            $table->json('price_map')->nullable(); // {"regular":120,"premium":180,"vip":240}
            $table->enum('status', ['scheduled', 'running', 'completed', 'cancelled'])->default('scheduled');
            $table->unsignedSmallInteger('lock_minutes')->default(5);
            $table->timestamps();
            $table->unique(['screen_id', 'starts_at']); // no overlapping start on same screen
            $table->index(['movie_id', 'starts_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
