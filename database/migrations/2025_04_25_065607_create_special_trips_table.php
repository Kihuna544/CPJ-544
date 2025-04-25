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
        Schema::create('special_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('set null');
            $table->foreignId('client_id')->constrained('temporary_clients')->onDelete('set null');
            $table->date('trip_date');
            $table->text('trip_details');
            $table->string('trip_destination');
            $table->decimal('trip_cost', 8, 2);
            $table->string('trip_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_trips');
    }
};
