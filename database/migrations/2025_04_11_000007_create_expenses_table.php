<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('trip_expenses', function (Blueprint $table) {
            $table->id();          
            $table->date('expense_date')->index(); 
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('set null');
            $table->string('category'); // e.g. fuel, maintenance, food, parking
            $table->decimal('amount', 8, 2);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('special_trip_expenses', function (Blueprint $table) {
            $table->id();          
            $table->date('expense_date')->index(); 
            $table->foreignId('special_trip_id')->nullable()->constrained('special_trips')->onDelete('set null');
            $table->string('category'); // e.g. fuel, maintenance, food, parking
            $table->decimal('amount', 8, 2);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('off_duty_expenses', function (Blueprint $table)
        {
            $table->id();
            $table->date('expense_date')->index();
            $table->string('category');
            $table->decimal('amount', 8, 2);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        }); 

    
    }

    public function down(): void
    {
        Schema::dropIfExists('special_trip_expenses');
        Schema::dropIfExists('expenses');
    }
};
