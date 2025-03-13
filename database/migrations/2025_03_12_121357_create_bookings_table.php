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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bus_id')->nullable()->constrained('buses')->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('cascade');
            $table->string('destenation_from');
            $table->string('destenation_to');
            $table->date('date');
            $table->integer('seats_count');
            $table->enum('status',['confirmed','canceled','pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
