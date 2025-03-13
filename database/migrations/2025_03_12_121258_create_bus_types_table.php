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
        Schema::create('bus_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bus_image')->nullable();
            $table->integer('seats_count')->nullable();
            $table->string('plan_image')->nullable();
            $table->string('seats_image')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_types');
    }
};
