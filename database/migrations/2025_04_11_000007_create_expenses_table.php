<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t2b_expenses', function (Blueprint $table) {
            $table->id();          
            $table->date('expense_date')->index(); 
            $table->foreignId('t2b_trip_id')->nullable()->constrained('t2b_trips_table')->onDelete('set null');
            $table->string('category'); // e.g. fuel, maintenance, food, parking
            $table->decimal('amount', 8, 2);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('b2t_expenses', function (BLueprint $table) {
            $table->id();          
            $table->date('expense_date')->index(); 
            $table->foreignId('b2t_trip_id')->nullable()->constrained('t2b_trips_table')->onDelete('set null');
            $table->string('category'); // e.g. fuel, maintenance, food, parking
            $table->decimal('amount', 8, 2);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('special_trip_expenses', function (BLueprint $table) {
            $table->id();          
            $table->date('expense_date')->index(); 
            $table->foreignId('special_trip_id')->nullable()->constrained('special_trips_table')->onDelete('set null');
            $table->string('category'); // e.g. fuel, maintenance, food, parking
            $table->decimal('amount', 8, 2);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
