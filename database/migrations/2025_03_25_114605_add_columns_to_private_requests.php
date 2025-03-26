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
        Schema::table('private_requests', function (Blueprint $table) {
            //, 
            $table->foreignId('car_id')->nullable()->constrained('cars')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('car_categories')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('car_brands')->onDelete('set null');
            $table->foreignId('model_id')->nullable()->constrained('car_models')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('private_requests', function (Blueprint $table) {
            //
        });
    }
};
