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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->nullable()->constrained('buses')->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('cascade');
            $table->string('opeartion_type');
            $table->date('date');
            $table->string('performed_by');
            $table->enum('status',['completed','canceled','pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
