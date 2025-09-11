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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->string('sex');
            $table->string('age');
            $table->string('sector');
            $table->string('reason');
            $table->string('satisfaction');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->date('survey_shown_date')->nullable(); // Track when survey was shown to this IP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
