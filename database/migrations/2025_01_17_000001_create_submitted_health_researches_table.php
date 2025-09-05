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
        Schema::create('submitted_health_researches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_research_id')->constrained('health_researches')->onDelete('cascade');
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('isbn')->nullable();
            $table->datetime('submitted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitted_health_researches');
    }
};
