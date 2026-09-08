<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masuk - Jurnal PKL Online</title>

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
        forgotPasswordModal: false,

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
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm shadow-blue-500/30">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>
                <span class="text-base font-semibold tracking-tight text-slate-900 dark:text-white">
                    Jurnal PKL Online
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
        <div class="w-full max-w-[420px]">
            {{-- Card --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/50 dark:border-slate-800 dark:bg-slate-900/70 dark:shadow-black/40 sm:p-8">
                {{-- Header Card --}}
                <div class="mb-6 text-center">
                    <span class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </span>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                        Masuk ke Akun
                    </h1>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Gunakan kredensial akun Anda untuk mengakses sistem PKL
                    </p>
                </div>

                {{-- Alert Error --}}
                @if (isset($errors) && $errors->any())
                    <div class="mb-5 flex items-start gap-2.5 rounded-xl border border-rose-200 bg-rose-50/80 p-3.5 text-xs text-rose-800 dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-300">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <div class="flex-1">
                            <p class="font-medium">Autentikasi Gagal</p>
                            <p class="mt-0.5">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                {{-- Flash Success (e.g. from logout or password update) --}}
                @if (session('success'))
                    <div class="mb-5 flex items-start gap-2.5 rounded-xl border border-emerald-200 bg-emerald-50/80 p-3.5 text-xs text-emerald-800 dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-300">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="flex-1 font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                {{-- Form Login --}}
                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-medium text-slate-700 dark:text-slate-300">
                            Alamat Email
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
                                autofocus
                                placeholder="nama@sekolah.sch.id"
                                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-xs text-slate-900 placeholder-slate-400 transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-blue-500"
                            >
                        </div>
                    </div>

                    {{-- Password Input with Show/Hide --}}
                    <div>
                        <div class="mb-1.5 flex items-center justify-between">
                            <label for="password" class="text-xs font-medium text-slate-700 dark:text-slate-300">
                                Password
                            </label>
                            <button
                                type="button"
                                @click="forgotPasswordModal = true"
                                class="text-[11px] font-medium text-blue-600 transition hover:text-blue-700 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                            >
                                Lupa Password?
                            </button>
                        </div>
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
                                placeholder="Masukkan password Anda"
                                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-10 text-xs text-slate-900 placeholder-slate-400 transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-blue-500"
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
                    </div>

                    {{-- Ingat Saya --}}
                    <div class="flex items-center">
                        <label class="flex cursor-pointer items-center gap-2">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 transition focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900"
                            >
                            <span class="text-xs text-slate-600 dark:text-slate-400">
                                Ingat saya di perangkat ini
                            </span>
                        </label>
                    </div>

                    {{-- Tombol Submit Masuk --}}
                    <button
                        type="submit"
                        class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 py-2.5 text-xs font-medium text-white shadow-sm shadow-blue-500/25 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                    >
                        <span>Masuk ke Aplikasi</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </form>

                {{-- Footer Card / Link ke Register --}}
                <div class="mt-6 border-t border-slate-100 pt-5 text-center text-xs text-slate-500 dark:border-slate-800/80 dark:text-slate-400">
                    <span>Belum memiliki akun siswa?</span>
                    <a
                        href="{{ route('register') }}"
                        class="ml-1 font-semibold text-blue-600 transition hover:text-blue-700 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                    >
                        Daftar Siswa
                    </a>
                </div>
            </div>

            {{-- Small Helper Note --}}
            <p class="mt-4 text-center text-[11px] text-slate-400 dark:text-slate-500">
                Akun Guru, Mentor, dan Admin dikelola langsung oleh Admin Sekolah.
            </p>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-4 text-center text-[11px] text-slate-400 dark:text-slate-500">
        &copy; {{ date('Y') }} Jurnal PKL Online. Seluruh hak cipta dilindungi.
    </footer>

    {{-- Modal Lupa Password --}}
    <div
        x-show="forgotPasswordModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        {{-- Backdrop --}}
        <div
            x-show="forgotPasswordModal"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="forgotPasswordModal = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
        ></div>

        {{-- Dialog --}}
        <div
            x-show="forgotPasswordModal"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-800 dark:bg-slate-900"
        >
            <div class="flex items-start justify-between pb-3">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </span>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">
                        Bantuan Reset Password
                    </h3>
                </div>
                <button
                    type="button"
                    @click="forgotPasswordModal = false"
                    class="rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800 dark:hover:text-slate-200"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-2 space-y-3 text-xs leading-relaxed text-slate-600 dark:text-slate-300">
                <p>
                    Untuk menjaga integritas dan keamanan data akademik PKL, pemulihan atau reset password akun dilakukan secara terpusat:
                </p>
                <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-3 dark:border-slate-800/60 dark:bg-slate-800/40">
                    <p class="font-medium text-slate-800 dark:text-slate-200">Langkah Pemulihan:</p>
                    <ul class="mt-1.5 list-inside list-disc space-y-1 text-slate-500 dark:text-slate-400">
                        <li><strong>Siswa</strong>: Hubungi Guru Pembimbing atau Admin Sekolah Anda.</li>
                        <li><strong>Guru / Mentor</strong>: Hubungi Admin Sekolah terkait.</li>
                        <li>Admin Sekolah dapat mengatur ulang kata sandi melalui menu Kelola Pengguna.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-5 flex justify-end">
                <button
                    type="button"
                    @click="forgotPasswordModal = false"
                    class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-medium text-white transition hover:bg-blue-700"
                >
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</body>
</html>