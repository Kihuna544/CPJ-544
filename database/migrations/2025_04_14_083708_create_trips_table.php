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
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->date('trip_date');
            $table->unsignedInteger('no_of_sacks_per_trip');  // Better than integer for counts
            $table->unsignedInteger('no_of_packages_per_trip');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled']) // Added cancelled status
                  ->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_trip');  // Drop pivot table first
        Schema::dropIfExists('trips');
    }
};