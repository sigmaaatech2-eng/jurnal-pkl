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
    Schema::create('journals', function (Blueprint $table) {
        $table->id();

        // Siswa yang membuat jurnal
        $table->foreignId('student_id')
            ->constrained('users')
            ->cascadeOnDelete();

        // Data PKL siswa
        $table->foreignId('internship_id')
            ->constrained('internships')
            ->cascadeOnDelete();

        // Tanggal kegiatan
        $table->date('date');

        // Judul kegiatan
        $table->string('title');

        // Deskripsi kegiatan
        $table->text('description');

        // Status verifikasi jurnal
        $table->string('status')->default('pending');

        // Catatan dari pembimbing/mentor
        $table->text('feedback')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
