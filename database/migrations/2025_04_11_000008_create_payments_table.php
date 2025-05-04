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
            $table->foreignId('temporary_client_id')->nullable()->constrained('temporary_clients')->onDelete('set null');
            $table->foreignId('t2b_trip_client_id')->nullable()->constrained('t2b_trip_clients')->onDelete('set null');
            $table->foreignId('b2t_trip_client_id')->nullable()->constrained('b2t_trip_clients')->onDelete('set null');
            $table->foreignId('special_trip_client_id')->nullable()->constrained('special_trip_clients')->onDelete('set null');
                    
            $table->string('client_name'); //filled in automatically from the clients table
            $table->decimal('amount_to_pay_for_the_special_trip', 8, 2)->default(0.00);
            $table->decimal('amount_to_pay_for_b2t', 8, 2)->default(0.00);
            $table->decimal('amount_to_pay_for_t2b', 8, 2)->default(0.00);

            $table->decimal('amount_paid', 8, 2)->default(0.00);
            $table->decimal('amount_unpaid', 8, 2)->default(0.00);


            $table->enum('status', ['un_paid', 'partially_paid', 'paid'])->default('un_paid');
            $table->text('notes')->nullable();
            
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });



        Schema::create('payment_transactions', function (Blueprint $table){
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
            $table->foreignId('client')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('temporary_client_id')->nullable()->constrained('temparary_clients')->onDelete('set null');
            $table->foreignId('t2b_client_payment_id')->nullable()->constrained('t2b_trip_clients')->onDelete('set null');
            $table->foreignId('b2t_client_payment_id')->nullable()->constrained('b2t_trip_clients')->onDelete('set null');
            $table->foreignId('special_trip_client_payment_id')->nullable()->constrained('special_trip_clients')->onDelete('set null');
            $table->decimal('amount_paid', 8, 2)->default(0);
            $table->date('payment_date');
            $table->enum('method', ['cash', 'mobile_money', 'bank', 'other'])->default('cash');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
        Schema::dropIfExists('payments');
    }
};
