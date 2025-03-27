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
            $table->dropColumn('from');
            $table->dropColumn('to');
            $table->foreignId('from_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->string('from_address')->nullable();
            $table->string('from_map')->nullable();
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
