<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // e.g. "Paket Starter", "Paket Pro"
            $table->text('description')->nullable();
            $table->integer('price');                    // Harga dalam rupiah
            $table->integer('max_students')->default(50);
            $table->integer('max_teachers')->default(10);
            $table->integer('max_mentors')->default(20);
            $table->integer('duration_months')->default(12); // Durasi dalam bulan
            $table->json('features')->nullable();        // Fitur-fitur tambahan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_packages');
    }
};
