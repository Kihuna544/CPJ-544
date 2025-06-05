<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t2b_trips_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('normal_trip_id')->nullable()->constrained('normal_itenka_trips')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('t2b_trip_clients', function(Blueprint $table){
            $table->id();
            $table->foreignId('t2b_trip_id')->constrained('t2b_trips_table')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('temporary_clients')->onDelete('cascade');
            $table->string('client_name');// filled in here directly from the client table.
            $table->decimal('amount_to_pay_for_t2b', 8, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps(); 
        });

        Schema::create('t2b_trips_items', function(Blueprint $table){
            $table->id();
            $table->foreignId('t2b_client_id')->constrained('t2b_trip_clients')->onDelete('cascade');
            $table->foreignId('t2b_trip_id')->constrained('t2b_trips_table')->onDelete('cascade');
            $table->string('item_name');
            $table->unsignedInteger('quantity');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');         
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t2b_trips_items');
        Schema::dropIfExists('t2b_trip_clients');
        Schema::dropIfExists('t2b_trips_table');
    }
};
