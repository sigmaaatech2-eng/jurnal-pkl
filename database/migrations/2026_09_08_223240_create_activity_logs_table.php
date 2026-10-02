<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');                   // e.g. "login", "create_user", "update_package"
            $table->string('description');
            $table->string('subject_type')->nullable(); // e.g. "App\Models\User"
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->json('properties')->nullable();     // Additional data
            $table->timestamps();

            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
        });

        // Tambah kolom school_subscription_id ke payments jika tabel payments ada
        // (dikomen karena tidak ada tabel payments di migration existing)
        // Buat tabel payment_histories
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('school_subscriptions')->cascadeOnDelete();
            $table->integer('amount');                   // Nominal dalam rupiah
            $table->enum('payment_method', ['transfer', 'cash', 'virtual_account', 'other'])->default('transfer');
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_proof')->nullable(); // Path bukti pembayaran
            $table->text('notes')->nullable();
            $table->date('payment_date')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
        Schema::dropIfExists('activity_logs');
    }
};
