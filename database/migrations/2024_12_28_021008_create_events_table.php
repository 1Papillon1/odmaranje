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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Naziv događaja
            $table->text('description')->nullable(); // Opis događaja
            $table->datetime('start_time'); // Početak događaja
            $table->datetime('end_time'); // Kraj događaja
            $table->integer('reward')->default(0); // Nagrada
            $table->timestamps(); // created_at i updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
