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
         Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number')->unique();
            $table->foreignId('aircraft_id')->constrained('aircraft')->onDelete('cascade');
            $table->foreignId('departure_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('arrival_airport_id')->constrained('airports')->onDelete('cascade');
            $table->dateTime('departure_date');
            $table->time('departure_time');
            $table->dateTime('arrival_date');
            $table->time('arrival_time');
            $table->decimal('first_class_ticket_price', 8, 2);
            $table->decimal('business_class_ticket_price', 8, 2);
            $table->decimal('economy_class_ticket_price', 8, 2);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
