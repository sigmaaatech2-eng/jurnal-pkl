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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->string('phone')->nullable()->after('kelas');
            $table->string('nisn')->nullable()->after('phone');
            $table->string('nip')->nullable()->after('nisn');
            $table->string('school_name')->nullable()->after('nip');
            $table->string('bidang')->nullable()->after('school_name');
            $table->string('company_name')->nullable()->after('bidang');
            $table->string('position')->nullable()->after('company_name');
            $table->text('address')->nullable()->after('position');
            $table->text('bio')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'phone',
                'nisn',
                'nip',
                'school_name',
                'bidang',
                'company_name',
                'position',
                'address',
                'bio',
            ]);
        });
    }
};
