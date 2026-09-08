<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('internship_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('date');

            $table->time('check_in')->nullable();

            $table->time('check_out')->nullable();

            $table->string('status')
                ->default('present');

            $table->timestamps();

            $table->unique(
                ['student_id', 'internship_id', 'date']
            );

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};