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
            $table->foreignId('agent_id')->nullable()->after('trip_name')->constrained('users')->onDelete('cascade');
            $table->date('max_book_date')->nullable()->after('date');
            $table->enum('type',['unlimited','limited'])->nullable()->after('max_book_date');
            $table->date('fixed_date')->nullable()->after('type');
            $table->text('cancellation_policy')->nullable()->after('fixed_date');
            $table->enum('cancelation_pay_amount',['fixed','percentage'])->nullable()->after('cancellation_policy');
            $table->integer('cancelation_pay_value')->nullable()->after('cancelation_pay_amount');
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
