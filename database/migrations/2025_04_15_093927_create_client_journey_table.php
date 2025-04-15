<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_journey', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('journey_id')->constrained()->onDelete('cascade');

            $table->string('crop_type')->nullable(); // Now using string instead of ID
            $table->integer('sacks')->default(0);
            $table->decimal('amount_to_pay', 8, 2)->default(0);
            $table->decimal('amount_paid', 8, 2)->default(0);
            $table->decimal('remaining_balance', 8, 2)->default(0);

            $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid');
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['client_id', 'journey_id']); // No duplicate for the same trip
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_journey');
    }
};
