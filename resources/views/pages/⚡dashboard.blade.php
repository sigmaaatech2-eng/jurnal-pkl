<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public function logout(): void
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/login');
    }
};

?>

<div class="min-h-screen bg-gray-100 p-8">
    <div class="mx-auto max-w-4xl">

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">
                    Dashboard Jurnal PKL Digital
                </h1>

                <p class="mt-2 text-gray-600">
                    Selamat datang, {{ auth()->user()->name }}
                </p>
            </div>

            <button
                wire:click="logout"
                class="rounded-lg bg-red-600 px-4 py-2 text-white"
            >
                Logout
            </button>
        </div>

        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold">
                Informasi Akun
            </h2>

            <div class="mt-4 space-y-2">
                <p>
                    <strong>Nama:</strong>
                    {{ auth()->user()->name }}
                </p>

                <p>
                    <strong>Email:</strong>
                    {{ auth()->user()->email }}
                </p>

                <p>
                    <strong>Role:</strong>
                    {{ auth()->user()->getRoleNames()->first() ?? 'Belum memiliki role' }}
                </p>
            </div>
        </div>

    </div>
</div>