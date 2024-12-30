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
        Schema::create('daily_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Korisnik
            $table->date('reward_date'); // Datum kada je nagrada zatražena
            $table->integer('streak')->default(1); // Trenutni niz dana zaredom
            $table->timestamps(); // Vrijeme kreiranja i ažuriranja
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_rewards');
    }
};
