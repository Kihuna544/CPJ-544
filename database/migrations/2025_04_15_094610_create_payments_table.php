<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('journey_id')->nullable()->constrained()->onDelete('set null'); // Optional in case of global payments
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
