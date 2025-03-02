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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->integer('batch_number');
            $table->integer('live_classes')->default(0);
            $table->integer('projects')->default(0);
            $table->string('videos')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('slug')->nullable();
            $table->string('category')->nullable();
            $table->date('start_date')->nullable();
            $table->string('class_schedule')->nullable();
            $table->integer('total_classes')->default(0);
            $table->string('status')->default('upcoming');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
