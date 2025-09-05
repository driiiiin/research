<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('health_researches', function (Blueprint $table) {
            $table->string('accession_no')->unique()->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('health_researches', function (Blueprint $table) {
            $table->dropColumn('accession_no');
        });
    }
};


