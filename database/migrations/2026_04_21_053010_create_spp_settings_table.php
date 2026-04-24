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
        Schema::create('spp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('grade_level'); // e.g. Grade X, Grade XI, Grade XII
            $table->integer('monthly_fee');
            $table->integer('late_penalty')->default(5); // percentage
            $table->integer('payment_deadline')->default(10); // day of month
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_settings');
    }
};
