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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'inprogress', 'completed', 'canceled', 'paid'])->default('pending');
            // $table->dateTime('appointment_time');

            $table->date('date');
            $table->time('time');



            // $table->boolean('mechanic_accepted')->nullable();  Nullable for initial state



            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('mechanic_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
