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
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null');
            $table->date('trip_date');
            //the clients involved should be seen for each trip
            $table->integer('no_of_sacks_per_trip');
            $table->integer('no_of_packages_per_trip');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->text('notes')->nullable(); // Optional for any trip comments
            $table->timestamps();
        });

        //pivot table for the many to many realationship between trips and clients
        Schema::create('client_trip', function (Blueprint $table) {
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->primary(['trip_id', 'client_id']); // Prevents duplicate entries
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
