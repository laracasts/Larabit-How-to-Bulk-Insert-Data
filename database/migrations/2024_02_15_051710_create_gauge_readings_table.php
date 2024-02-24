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
        Schema::create('gauge_readings', function (Blueprint $table) {
            //DATE,TIME,Lower Pressure,Lower Temperature,Upper Pressure,Upper Temperature
            $table->id();
            $table->date('log_date');
            $table->time('log_time');
            $table->decimal('gauge_one_pressure');
            $table->decimal('gauge_one_temp', 7, 3);
            $table->decimal('gauge_two_pressure');
            $table->decimal('gauge_two_temp', 7, 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gauge_readings');
    }
};
