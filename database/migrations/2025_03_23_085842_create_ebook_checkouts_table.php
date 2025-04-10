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
        Schema::create('ebook_checkouts', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('ebook_id'); // Foreign key to the ebooks table
            $table->string('payment_method'); // Payment method (e.g., bKash, Nagad)
            $table->string('transaction_id'); // Transaction ID from the payment gateway
            $table->string('name'); // Customer's name
            $table->string('email'); // Customer's email
            $table->string('phone'); // Customer's phone number
            $table->decimal(column: 'amount');
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_checkouts');
    }
};
