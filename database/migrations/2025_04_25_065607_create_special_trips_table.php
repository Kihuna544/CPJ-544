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
            $table->string('trip_destination');       
            $table->string('trip_status')->default('pending');

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });

        Schema::create('special_trips_client', function (Blueprint $table){
            $table->id();
            $table->foreignId('special_trip_id')->constrained('special_trips')->onDelete('set null');
            $table->foreignId('client_id')->constrained('temporary_clients')->onDelete('set null');
            $table->decimal('trip_cost', 8, 2);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('special_trips_items', function (Blueprint $table){
            $table->id();
            $table->foreignId('special_trip_client_id')->constrained('special_trips_client')->onDelete('set null');
            $table->string('item_name');
            $table->unsignedInteger('quantity');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_trips');
        Schema::dropIfExists('special_trips_items');
        Schema::dropIfExists('special_trips_client');   
    }
};
