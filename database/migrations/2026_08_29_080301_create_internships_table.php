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
    Schema::create('internships', function (Blueprint $table) {
        $table->id();

        // Siswa yang menjalani PKL
        $table->foreignId('student_id')
            ->constrained('users')
            ->cascadeOnDelete();

        // Mentor dari tempat PKL
        $table->foreignId('mentor_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        // Guru pembimbing dari sekolah
        $table->foreignId('teacher_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        // Informasi tempat PKL
        $table->string('company_name');
        $table->text('company_address')->nullable();

        // Periode PKL
        $table->date('start_date');
        $table->date('end_date');

        // Status PKL
        $table->string('status')->default('active');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
