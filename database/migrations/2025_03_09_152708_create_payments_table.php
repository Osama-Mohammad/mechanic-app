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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->decimal('amount', 10, 2); // Payment amount
            $table->enum('method', ['creditCard', 'wishmoney', 'OMT', 'Cash']);
            $table->enum('status', ['success', 'failed', 'pending']);
            $table->timestamp('transaction_date')->useCurrent(); // Defaults to now

            // Foreign keys
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_request_id')->constrained()->onDelete('cascade');

            $table->string('reference_id')->unique();


            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};


/* $table->id();
$table->decimal('amount', 10, 2);
$table->enum('method', ['creditCard', 'wishmoney', 'OMT', 'Cash']);
$table->enum('status', ['success', 'failed', 'pending']);
$table->timestamp('transaction_date');
$table->foreignId('customer_id')->constrained()->onDelete('cascade');
$table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
$table->timestamps(); */
