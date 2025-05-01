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
        //b2t clients mostly permanet ones.
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('phone')->index();
            $table->string('profile_photo')->nullable(); // Profile photo URL
            $table->timestamps();
        });

        //t2b clients mostly temporary ones.
        Schema::create('temporary_clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('phone')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_clients');
        Schema::dropIfExists('clients');
    }
};
