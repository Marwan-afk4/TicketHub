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
        Schema::table('trips', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->after('dropoff_station_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('to_city_id')->nullable()->after('country_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('to_zone_id')->nullable()->after('to_city_id')->constrained('zones')->onDelete('cascade');
            $table->date('date')->nullable()->after('arrival_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            //
        });
    }
};
