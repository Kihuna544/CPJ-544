<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// used to store the payment details for each of the client per each trip
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('t2b_trips_client_id')->nullable()->constrained('t2b_trips_clients')->onDelete('set null');
            $table->foreignId('b2t_trips_client_id')->nullable()->constrained('b2t_trips_tabel')->onDelete('set null');
                      

            $table->date('trip_date'); 
            $table->unsignedInteger('no_of_sacks_per_client')->default(0);           
            $table->unsignedInteger('no_of_packages_per_client')->default(0);
            $table->decimal('amount_to_pay_for_b2t', 8, 2)->default(0);
            
            
            $table->string('item_name');
            $table->unsignedInteger('quantity');
            $table->decimal('amount_to_pay_for_t2b', 8, 2)->default(0);

                  
            $table->integer('amount_paid')->default(0);
            $table->integer('amount_unpaid')->default(0);
        

            $table->enum('status', ['un_paid', 'partially_paid', 'paid'])->default('un_paid');
            $table->decimal('amount', 8, 2)->nullable(); // If needed
        
            
            $table->date('payment_date');
            $table->enum('method', ['cash', 'mobile_money', 'bank', 'other'])->default('cash');
            $table->text('notes')->nullable();
        
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
