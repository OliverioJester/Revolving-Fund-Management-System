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
        Schema::create('period_and_transmittals', function (Blueprint $table) {
            $table->id();
            $table->date('first_period');
            $table->date('second_period');
            $table->string('transmittal');
            $table->string('revolving_report');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('period_and_transmittals');
    }
};
