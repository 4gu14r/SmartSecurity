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
        Schema::create('occurrences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('type', 100);
            $table->string('title');
            $table->text('description');
            $table->datetime('occurred_at');
            $table->string('location');
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('images')->nullable();
            $table->integer('views_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);
            $table->timestamps();
            
            $table->index('type');
            $table->index('location');
            $table->index('occurred_at');
            $table->index('status');
            $table->index('user_id');
            $table->index(['latitude', 'longitude']);
            // Note: SQLite doesn't support fulltext indexes, would need to use FTS extension
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occurrences');
    }
};
