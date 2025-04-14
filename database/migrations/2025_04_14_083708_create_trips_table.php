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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained()->onDelete('cascade'); // Foreign key to drivers table
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Foreign key to clients table
            $table->date('trip_date');
            $table->string('destination');
            $table->integer('sacks_delivered');
            $table->decimal('amount_paid', 8, 2);
            $table->decimal('remaining_balance', 8, 2)->default(0);
            $table->enum('status', ['completed', 'pending'])->default('pending'); // Trip status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
