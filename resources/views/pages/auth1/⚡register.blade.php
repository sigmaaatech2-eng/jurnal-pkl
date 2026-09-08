<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('siswa');

        Auth::login($user);

        $this->redirect('/dashboard');
    }
};

?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg">

        <h1 class="mb-6 text-center text-2xl font-bold">
            Daftar Jurnal PKL Digital
        </h1>

        <form wire:submit="register">

            <div class="mb-4">
                <label class="mb-2 block">
                    Nama
                </label>

                <input
                    type="text"
                    wire:model="name"
                    class="w-full rounded-lg border px-4 py-2"
                >

                @error('name')
                    <span class="text-sm text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="mb-2 block">
                    Email
                </label>

                <input
                    type="email"
                    wire:model="email"
                    class="w-full rounded-lg border px-4 py-2"
                >

                @error('email')
                    <span class="text-sm text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="mb-2 block">
                    Password
                </label>

                <input
                    type="password"
                    wire:model="password"
                    class="w-full rounded-lg border px-4 py-2"
                >

                @error('password')
                    <span class="text-sm text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-6">
                <label class="mb-2 block">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    wire:model="password_confirmation"
                    class="w-full rounded-lg border px-4 py-2"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-blue-600 py-2 text-white"
            >
                Daftar
            </button>

        </form>

    </div>
</div>