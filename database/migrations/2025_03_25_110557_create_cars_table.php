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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('car_categories')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('car_brands')->onDelete('cascade');
            $table->foreignId('model_id')->nullable()->constrained('car_models')->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('car_number')->nullable();
            $table->string('car_color')->nullable();
            $table->string('car_year')->nullable();
            $table->enum('status', ['busy', 'available'])->default('available');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
