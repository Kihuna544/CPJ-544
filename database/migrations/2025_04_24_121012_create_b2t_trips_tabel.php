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

        Schema::create('b2t_trips_tabel', function (Blueprint $table) {

            $table->id();
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('set null');
            $table->date('trip_date');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

        });


        Schema::create('b2t_trip_client', function(Blueprint $table){
            $table->id();
            $table->foreignId('b2t_trips_id')->constrained('b2t_trips_table')->onDelete('cascade');
            $table->foreignId('b2t_trip_client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->unsignedInteger('no_of_sacks_per_client');
            $table->unsignedInteger('no_of_packages_per_client');
            $table->decimal('amount_to_pay_for_b2t', 8, 2)->default(0.00);
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
        Schema::dropIfExists('b2t_trips_tabel');
        Schema::dropIfExists('b2t_trip_client');
    }
};
