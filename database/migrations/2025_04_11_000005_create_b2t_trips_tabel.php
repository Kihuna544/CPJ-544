<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('b2t_trips_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->date('trip_date');
            $table->unsignedBigInteger('total_number_of_sacks');
            $table->unsignedBigInteger('total_number_of_packages');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('b2t_trip_clients', function(Blueprint $table){
            $table->id();
            $table->foreignId('b2t_trip_id')->constrained('b2t_trips_table')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('client_name'); // filled in here directly from the client table.
            $table->unsignedInteger('no_of_sacks_per_client');
            $table->unsignedInteger('no_of_packages_per_client');
            $table->decimal('amount_to_pay_for_b2t', 8, 2)->default(0.00);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('b2t_trip_clients');
        Schema::dropIfExists('b2t_trips_table');
    }
};
