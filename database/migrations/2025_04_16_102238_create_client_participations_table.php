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
        Schema::create('client_participations', function (Blueprint $table) {
            $table->id();

            // Relate to a client (foreign key)
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
        
            // Relate to a trip (optional)
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('set null');
        
            // Relate to client participation if needed (optional)
            $table->foreignId('client_participation_id')->nullable()->constrained('client_participations')->onDelete('set null');
        
            // These are just values copied or calculated from another table at the time of payment
            $table->date('trip_date'); // manually copy from trip at the time of creation
            $table->integer('sacks_carried');
            $table->integer('packages_carried')->nullable();
            $table->decimal('amount_to_pay', 8, 2); // already present
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_participations');
    }
};
