<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->unsignedTinyInteger('mentor_score')->nullable()->after('feedback');
            $table->string('mentor_rating')->nullable()->after('mentor_score'); // sangat_baik|baik|cukup|perlu_perbaikan
            $table->text('mentor_feedback')->nullable()->after('mentor_rating');
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['mentor_score', 'mentor_rating', 'mentor_feedback']);
        });
    }
};
