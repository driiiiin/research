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
        Schema::create('health_researches', function (Blueprint $table) {
            $table->id();

            // Title Section
            $table->string('accession_no')->unique();
            $table->string('research_title');
            $table->json('subtitle')->nullable(); // Array of subtitles

            // Source Section
            $table->integer('date_issued_from_month')->nullable();
            $table->integer('date_issued_from_year')->nullable();
            $table->integer('date_issued_to_month')->nullable();
            $table->integer('date_issued_to_year')->nullable();

            // Publication Details
            $table->string('volume_no');
            $table->string('issue_no')->nullable();
            $table->string('pages')->nullable();
            $table->string('article_no')->nullable();
            $table->string('doi')->nullable();
            $table->text('notes')->nullable();

            // Research Classification
            $table->enum('research_category', ['Institutional', 'Collaborative', 'Commissioned']);
            $table->enum('research_type', ['Basic', 'Applied', 'Experimental']);

            // Abstract Section
            $table->string('abstract_type')->default('Full Abstract');
            $table->longText('research_abstract')->nullable();

            // Reference Section
            $table->longText('reference')->nullable();

            // Subject Section
            $table->text('mesh_keywords')->nullable(); // Semicolon-separated
            $table->text('non_mesh_keywords')->nullable(); // Semicolon-separated

            // Additional Fields
            $table->string('sdg_addressed')->nullable();
            $table->string('policy_brief')->nullable();
            $table->string('final_report')->nullable();
            $table->string('implementing_agency')->nullable();
            $table->string('cooperating_agency')->nullable();
            $table->string('general_note')->nullable();
            $table->string('budget')->nullable();
            $table->string('fund_information')->nullable();
            $table->string('duration')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('year_end_date')->nullable();
            $table->string('keywords')->nullable();
            $table->string('status')->nullable();
            $table->string('citation')->nullable();
            $table->enum('upload_status', ['Uploaded', 'Not Uploaded'])->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_researches');
    }
};
