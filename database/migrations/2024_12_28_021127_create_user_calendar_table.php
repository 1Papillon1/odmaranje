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
        Schema::create('user_calendar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Korisnik
            $table->string('activity'); // Naziv aktivnosti (npr. "Running", "Meditation")
            $table->datetime('start_time'); // Početak aktivnosti
            $table->datetime('end_time'); // Završetak aktivnosti
            $table->boolean('completed')->default(false); // Status - je li aktivnost završena
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_calendar');
    }
};
