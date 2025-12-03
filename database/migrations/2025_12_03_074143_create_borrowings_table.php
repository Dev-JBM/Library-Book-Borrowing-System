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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            // Link to the User model
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Link to the Book model
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            
            $table->timestamp('borrowed_at');
            $table->timestamp('due_date')->nullable();
            $table->timestamp('returned_at')->nullable(); // If null, the book is currently borrowed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
