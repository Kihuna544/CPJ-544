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

            $table->foreignId('client_name')->constrained()->onDelete('cascade'); // from clients profile
            $table->foreignId('trip_date')->nullable()->constrained()->onDelete('set null'); // Optional in case of global payments
            $table->foreignId('client_sacks_carried')->constrained()->onDelete('cascade');           
            $table->foreignId('client_packages_carried');
            $table->foreignId('amount_to_pay')->constrained()->onDelete('cascade'); //from client_participation table
            $table->integer('amount_paid');
            $table->integer('amount_unpaid');
            $table->enum('status', ['un_paid', 'partially_paid', 'paid'])->default('un_paid');
            $table->decimal('amount', 8, 2);

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
