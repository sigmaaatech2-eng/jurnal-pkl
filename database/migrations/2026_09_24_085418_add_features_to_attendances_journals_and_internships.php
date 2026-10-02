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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('check_in_lat')->nullable()->after('check_in_photo');
            $table->string('check_in_lng')->nullable()->after('check_in_lat');
            $table->text('check_in_address')->nullable()->after('check_in_lng');
            $table->string('check_out_lat')->nullable()->after('check_out_photo');
            $table->string('check_out_lng')->nullable()->after('check_out_lat');
            $table->text('check_out_address')->nullable()->after('check_out_lng');
            $table->string('late_status')->nullable()->after('status'); // 'tepat_waktu' | 'terlambat'
        });

        Schema::table('internships', function (Blueprint $table) {
            $table->time('max_check_in_time')->nullable()->default('08:00:00')->after('end_date');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->text('link')->nullable()->after('attachment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['link']);
        });

        Schema::table('internships', function (Blueprint $table) {
            $table->dropColumn(['max_check_in_time']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'check_in_lat',
                'check_in_lng',
                'check_in_address',
                'check_out_lat',
                'check_out_lng',
                'check_out_address',
                'late_status',
            ]);
        });
    }
};
