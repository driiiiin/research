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
        Schema::create('health_research_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_research_id')->constrained()->onDelete('cascade');
            $table->enum('format', ['Print', 'Non-Print']);
            $table->string('physical_location')->nullable();
            $table->string('location_number')->nullable();
            $table->enum('text_availability', ['Abstract Only', 'Full-text'])->nullable();
            $table->enum('mode_of_access', [
                'Request to Institution',
                'Room use Only',
                'Not available to the public',
                'Online Request',
                'Publicly accessible'
            ])->nullable();
            $table->string('institutional_email')->nullable();
            $table->boolean('enter_url')->default(false);
            $table->string('url')->nullable();
            $table->boolean('upload_file')->default(false);
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_research_locations');
    }
};
