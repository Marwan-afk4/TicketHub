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
        Schema::create('train_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_country_id')->nullable()->constrained('countries')->onDelete('cascade'); 
            $table->foreignId('from_city_id')->nullable()->constrained('cities')->onDelete('cascade'); 
            $table->foreignId('to_country_id')->nullable()->constrained('countries')->onDelete('cascade'); 
            $table->foreignId('to_city_id')->nullable()->constrained('cities')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_routes');
    }
};
