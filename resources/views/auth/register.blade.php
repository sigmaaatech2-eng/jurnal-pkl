<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <title>Daftar Akun Siswa - Jurnal PKL Online</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const savedDarkMode = localStorage.getItem('darkMode');

            const isDark = savedTheme
                ? savedTheme === 'dark'
                : (savedDarkMode !== null
                    ? savedDarkMode === 'true'
                    : window.matchMedia('(prefers-color-scheme: dark)').matches);

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

<body
    x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        showPassword: false,
        showConfirmPassword: false,

        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            document.documentElement.classList.toggle('dark', this.darkMode);
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            localStorage.setItem('darkMode', this.darkMode ? 'true' : 'false');
        }
    }"
    class="flex min-h-screen flex-col justify-between bg-slate-50 text-slate-800 antialiased transition-colors duration-200 selection:bg-blue-600 selection:text-white dark:bg-[#070b18] dark:text-slate-100"
>
    {{-- Top Bar --}}
    <header class="w-full px-4 py-4 sm:px-8">
        <div class="mx-auto flex max-w-6xl items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 transition hover:opacity-90">
                <div class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-blue-50 p-1 shadow-sm dark:bg-blue-500/10">
                    <img
                        src="{{ asset('images/logo-jurnal-pkl.png') }}"
                        alt="Jurnal PKL Online"
                        class="h-full w-full object-contain"
                    >
                </div>
                <span class="text-base font-semibold tracking-tight text-slate-900 dark:text-white">
                    Jurnal <span class="text-blue-600">PKL</span> Online
                </span>
            </a>

            <div class="flex items-center gap-2">
                {{-- Dark Mode Toggle --}}
                <button
                    type="button"
                    @click="toggleDarkMode()"
                    aria-label="Ubah Tema"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-100 dark:border-slate-800 dark:text-slate-300 dark:hover:bg-slate-800/60"
                >
                    <svg x-show="!darkMode" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </button>

                {{-- Kembali ke Beranda --}}
                <a
                    href="{{ url('/') }}"
                    class="hidden items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:bg-slate-100 dark:border-slate-800 dark:text-slate-300 dark:hover:bg-slate-800/60 sm:inline-flex"
                >
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Beranda</span>
                </a>
            </div>
        </div>
    </header>

    {{-- Main Container --}}
    <main class="my-auto flex w-full items-center justify-center px-4 py-8 sm:px-6">
        <div class="w-full max-w-[440px]">
            {{-- Card --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/50 dark:border-slate-800 dark:bg-slate-900/70 dark:shadow-black/40 sm:p-8">
                {{-- Header Card --}}
                <div class="mb-6 text-center">
                    <span class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </span>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                        Daftar Akun Siswa
                    </h1>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Pendaftaran akun mandiri untuk peserta didik Praktik Kerja Lapangan
                    </p>
                </div>

                {{-- Alert Error Global --}}
                @if (isset($errors) && $errors->any())
                    <div class="mb-5 flex items-start gap-2.5 rounded-xl border border-rose-200 bg-rose-50/80 p-3.5 text-xs text-rose-800 dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-300">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <div class="flex-1">
                            <p class="font-medium">Periksa Kembali Data Anda</p>
                            <p class="mt-0.5">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                {{-- Form Register --}}
                @php
                    $classesData = ($classes ?? collect())->map(function ($c) {
                        return [
                            'id' => $c->id,
                            'name' => $c->name,
                            'grade' => $c->grade,
                            'major_id' => $c->school_major_id,
                        ];
                    })->values();
                @endphp
                <script>
                    function registerForm() {
                        return {
                            showPassword: false,
                            showConfirmPassword: false,
                            selectedMajorId: '{{ old('jurusan', '') }}',
                            selectedClass: '{{ old('kelas', '') }}',
                            allClasses: @json($classesData),
                            get filteredClasses() {
                                if (!this.selectedMajorId) return this.allClasses;
                                return this.allClasses.filter(c => String(c.major_id) === String(this.selectedMajorId));
                            },
                            onMajorChange() {
                                const match = this.allClasses.find(c => c.name === this.selectedClass && (!this.selectedMajorId || String(c.major_id) === String(this.selectedMajorId)));
                                if (!match) this.selectedClass = '';
                            }
                        };
                    }
                </script>
                <form
                    method="POST"
                    action="{{ route('register.store') }}"
                    class="space-y-4"
                    x-data="registerForm()"
                >
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">
                            Nama Lengkap Siswa <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </span>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                placeholder="Contoh: Budi Santoso"
                                class="w-full rounded-xl border {{ ($errors?->has('name') ?? false) ? 'border-rose-400 dark:border-rose-600' : 'border-slate-200 dark:border-slate-800' }} bg-white py-2.5 pl-9 pr-3 text-xs text-slate-900 placeholder-slate-400 transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-blue-500"
                            >
                        </div>
                        @error('name')
                            <p class="mt-1 text-[11px] text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">
                            Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </span>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="siswa@sekolah.sch.id"
                                class="w-full rounded-xl border {{ ($errors?->has('email') ?? false) ? 'border-rose-400 dark:border-rose-600' : 'border-slate-200 dark:border-slate-800' }} bg-white py-2.5 pl-9 pr-3 text-xs text-slate-900 placeholder-slate-400 transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-blue-500"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-[11px] text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Data Sekolah: Jurusan & Kelas --}}
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        {{-- Jurusan --}}
                        <div>
                            <label for="jurusan" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">
                                Jurusan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
                                    </svg>
                                </span>
                                <select
                                    id="jurusan"
                                    name="jurusan"
                                    required
                                    x-model="selectedMajorId"
                                    @change="onMajorChange()"
                                    class="w-full rounded-xl border {{ ($errors?->has('jurusan') ?? false) ? 'border-rose-400 dark:border-rose-600' : 'border-slate-200 dark:border-slate-800' }} bg-white py-2.5 pl-9 pr-3 text-xs text-slate-900 transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-500"
                                >
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($majors ?? [] as $major)
                                        <option value="{{ $major->id }}" @selected(old('jurusan') == $major->id)>
                                            {{ $major->name }}{{ $major->code ? " ({$major->code})" : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('jurusan')
                                <p class="mt-1 text-[11px] text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kelas --}}
                        <div>
                            <label for="kelas" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">
                                Kelas <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </span>
                                <select
                                    id="kelas"
                                    name="kelas"
                                    x-model="selectedClass"
                                    required
                                    class="w-full rounded-xl border {{ ($errors?->has('kelas') ?? false) ? 'border-rose-400 dark:border-rose-600' : 'border-slate-200 dark:border-slate-800' }} bg-white py-2.5 pl-9 pr-3 text-xs text-slate-900 transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-500"
                                >
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($classes ?? [] as $cls)
                                        <option
                                            value="{{ $cls->name }}"
                                            x-show="!selectedMajorId || String(selectedMajorId) === '{{ $cls->school_major_id }}'"
                                            @selected(old('kelas') == $cls->name)
                                        >
                                            {{ $cls->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kelas')
                                <p class="mt-1 text-[11px] text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">
                            Password (Minimal 8 Karakter)
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </span>
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                placeholder="Minimal 8 karakter"
                                class="w-full rounded-xl border {{ ($errors?->has('password') ?? false) ? 'border-rose-400 dark:border-rose-600' : 'border-slate-200 dark:border-slate-800' }} bg-white py-2.5 pl-9 pr-10 text-xs text-slate-900 placeholder-slate-400 transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-blue-500"
                            >
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                aria-label="Lihat Password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition hover:text-slate-600 dark:hover:text-slate-200"
                            >
                                <svg x-show="!showPassword" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="showPassword" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-[11px] text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </span>
                            <input
                                id="password_confirmation"
                                :type="showConfirmPassword ? 'text' : 'password'"
                                name="password_confirmation"
                                required
                                placeholder="Ulangi password di atas"
                                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-10 text-xs text-slate-900 placeholder-slate-400 transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-blue-500"
                            >
                            <button
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                aria-label="Lihat Konfirmasi Password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition hover:text-slate-600 dark:hover:text-slate-200"
                            >
                                <svg x-show="!showConfirmPassword" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="showConfirmPassword" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Tombol Submit Daftar --}}
                    <button
                        type="submit"
                        class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 py-2.5 text-xs font-medium text-white shadow-sm shadow-blue-500/25 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                    >
                        <span>Daftar Sekarang</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </form>

                {{-- Footer Card / Link ke Login --}}
                <div class="mt-6 border-t border-slate-100 pt-5 text-center text-xs text-slate-500 dark:border-slate-800/80 dark:text-slate-400">
                    <span>Sudah memiliki akun?</span>
                    <a
                        href="{{ route('login') }}"
                        class="ml-1 font-semibold text-blue-600 transition hover:text-blue-700 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                    >
                        Masuk
                    </a>
                </div>
            </div>

            {{-- Helper Note --}}
            <p class="mt-4 text-center text-[11px] text-slate-400 dark:text-slate-500">
                Pendaftaran umum dikhususkan untuk siswa peserta PKL.
            </p>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-4 text-center text-[11px] text-slate-400 dark:text-slate-500">
        &copy; {{ date('Y') }} Jurnal PKL Online. Seluruh hak cipta dilindungi.
    </footer>
</body>
</html>