<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journey_id')->constrained()->onDelete('cascade'); // Each expense belongs to a journey
            $table->string('category'); // e.g. fuel, maintenance, food, parking
            $table->decimal('amount', 8, 2);
            $table->date('expense_date')->nullable(); // When the expense happened

            $table->text('notes')->nullable(); // Optional: more description
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
// This migration creates an 'expenses' table with a foreign key to the 'journeys' table.