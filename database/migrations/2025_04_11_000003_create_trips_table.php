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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->date('trip_date');
            $table->enum('trip_type', ['normal', 'special'])->default('normal');
            $table->unsignedBigInteger('parent_trip_id')->nullable();
            $table->enum('direction', ['t2b', 'b2t'])->nullable();
            $table->text('trip_details')->nullable();
            $table->timestamps();

            $table->foreign('parent_trip_id')->references('id')->on('trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
