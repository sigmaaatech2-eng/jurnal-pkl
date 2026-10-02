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
        // Tabel Jurusan
        Schema::create('school_majors', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Nama jurusan, e.g. "Teknik Komputer Jaringan"
            $table->string('code')->nullable(); // Kode singkat, e.g. "TKJ"
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Kelas
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_major_id')
                  ->nullable()
                  ->constrained('school_majors')
                  ->nullOnDelete();
            $table->string('name');           // Nama kelas, e.g. "XII TKJ 1"
            $table->string('grade')->nullable(); // Tingkat, e.g. "X", "XI", "XII"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
        Schema::dropIfExists('school_majors');
    }
};
