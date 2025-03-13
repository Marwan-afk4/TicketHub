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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->foreignId('pickup_station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('station_1')->nullable()->constrained('stations')->onDelete('cascade');
            $table->foreignId('station_2')->nullable()->constrained('stations')->onDelete('cascade');
            $table->foreignId('station_3')->nullable()->constrained('stations')->onDelete('cascade');
            $table->foreignId('station_4')->nullable()->constrained('stations')->onDelete('cascade');
            $table->foreignId('dropoff_station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('cascade');
            $table->foreignId('zone_id')->nullable()->constrained()->onDelete('cascade');
            $table->time('deputre_time');
            $table->time('arrival_time');
            $table->integer('avalible_seats');
            $table->integer('price');
            $table->enum('status',['active','inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
