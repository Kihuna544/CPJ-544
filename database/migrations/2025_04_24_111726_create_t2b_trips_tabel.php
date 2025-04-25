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
        Schema::create('t2b_trips_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('set null');
            $table->foreignId('client_id')->constrained('temporary_clients')->onDelete('cascade');
            $table->date('trip_date');
            $table->timestamps();
        });

        Schema::create('t2b_trips_clients', function(Blueprint $table){
            $table->id();
            $table->foreigId('t2b_trip_id')->constrained('t2b_trips_table')->onDelete('cascade');
            $tabel->foreignId('client_id')->constrained('temporary_clients')->onDelete('cascade');
            $table->decimal('amount_to_pay_for_t2b', 8, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('t2b_trips_items', function(Blueprint $table){
            $table->id();
            $table->foreignId('t2b_trip_client_id')->constrained('t2b_trips_clients')->onDelete('cascade');
            $table->string('item_name');
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t2b_trips_clients');
        Schema::dropIfExists('t2b_trips_items');
        Schema::dropIfExists('t2b_trips_table');
    }
};
