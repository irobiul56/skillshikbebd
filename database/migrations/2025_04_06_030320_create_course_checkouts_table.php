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
        Schema::create('course_checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id'); // Foreign key to the ebooks table
            $table->unsignedBigInteger('user_id'); // Foreign key to the ebooks table
            $table->string('payment_method'); // Payment method (e.g., bKash, Nagad)
            $table->string('transaction_id'); // Transaction ID from the payment gateway
            $table->decimal( 'amount',10,2);
            $table->string('status')->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_checkouts');
    }
};
