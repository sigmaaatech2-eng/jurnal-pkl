<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <title>Jurnal PKL Online - Platform Dokumentasi & Pemantauan PKL</title>

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
        mobileMenuOpen: false,

        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            document.documentElement.classList.toggle('dark', this.darkMode);
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            localStorage.setItem('darkMode', this.darkMode ? 'true' : 'false');
        }
    }"
    class="bg-slate-50 text-slate-800 antialiased transition-colors duration-200 selection:bg-blue-600 selection:text-white dark:bg-[#070b18] dark:text-slate-100"
>
    {{-- 1. NAVBAR --}}
    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md transition-colors dark:border-slate-800/80 dark:bg-[#070b18]/90">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3.5 sm:px-6 lg:px-8">
            {{-- Logo / Nama --}}
            <a href="#beranda" class="flex items-center gap-2.5 transition hover:opacity-90">
                <div class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-blue-50 p-1 shadow-sm dark:bg-blue-500/10">
                    <img
                        src="{{ asset('images/logo-jurnal-pkl.png') }}"
                        alt="Jurnal PKL Online"
                        class="h-full w-full object-contain"
                    >
                </div>
                <span class="text-base font-semibold tracking-tight text-slate-900 dark:text-white sm:text-lg">
                    Jurnal <span class="text-blue-600">PKL</span> Online
                </span>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden items-center gap-8 md:flex">
                <a href="#beranda" class="text-sm font-medium text-slate-600 transition hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400">
                    Beranda
                </a>
                <a href="#tentang" class="text-sm font-medium text-slate-600 transition hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400">
                    Tentang
                </a>
                <a href="#pengguna" class="text-sm font-medium text-slate-600 transition hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400">
                    Pengguna
                </a>
            </nav>

            {{-- Right Actions --}}
            <div class="flex items-center gap-2.5 sm:gap-3">
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

                {{-- Tombol Masuk --}}
                @auth
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm shadow-blue-500/20 transition hover:bg-blue-700"
                    >
                        <span>Masuk</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm shadow-blue-500/20 transition hover:bg-blue-700"
                    >
                        <span>Masuk</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @endauth

                {{-- Mobile Menu Trigger --}}
                <button
                    type="button"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-100 dark:border-slate-800 dark:text-slate-300 dark:hover:bg-slate-800/60 md:hidden"
                    aria-label="Menu"
                >
                    <svg x-show="!mobileMenuOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div
            x-show="mobileMenuOpen"
            x-cloak
            @click.outside="mobileMenuOpen = false"
            class="border-t border-slate-200 bg-white px-4 py-3 dark:border-slate-800 dark:bg-[#070b18] md:hidden"
        >
            <div class="flex flex-col gap-2">
                <a
                    href="#beranda"
                    @click="mobileMenuOpen = false"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800"
                >
                    Beranda
                </a>
                <a
                    href="#tentang"
                    @click="mobileMenuOpen = false"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800"
                >
                    Tentang
                </a>
                <a
                    href="#pengguna"
                    @click="mobileMenuOpen = false"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800"
                >
                    Pengguna
                </a>
            </div>
        </div>
    </header>

    <main id="beranda">
        {{-- 2. HERO --}}
        <section class="relative overflow-hidden py-16 sm:py-20 lg:py-28">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-8">
                    {{-- Text Content --}}
                    <div class="lg:col-span-7">
                        <div class="inline-flex items-center gap-2 rounded-full border border-blue-200/80 bg-blue-50/70 px-3 py-1 text-xs font-medium text-blue-700 dark:border-blue-900/50 dark:bg-blue-950/40 dark:text-blue-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                            Sistem Administrasi PKL Terpadu
                        </div>

                        <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                            Jurnal PKL Online
                        </h1>

                        <p class="mt-4 text-base font-medium leading-relaxed text-slate-700 dark:text-slate-200 sm:text-lg">
                            Platform digital untuk membantu sekolah dan peserta didik dalam mengelola serta mendokumentasikan kegiatan Praktik Kerja Lapangan (PKL) secara lebih terstruktur.
                        </p>

                        <p class="mt-3 text-sm leading-relaxed text-slate-500 dark:text-slate-400 sm:text-base">
                            Dirancang untuk menyederhanakan alur pencatatan harian siswa, memudahkan pemantauan pembimbing dan mentor, serta menyajikan rekapitulasi data yang akurat bagi pihak sekolah.
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-sm shadow-blue-500/30 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-[#070b18]"
                            >
                                <span>Masuk ke Aplikasi</span>
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                            <a
                                href="#tentang"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-300 dark:hover:bg-slate-800/50"
                            >
                                Pelajari Selengkapnya
                            </a>
                        </div>
                    </div>

                    {{-- Visual Mockup Sederhana & Profesional --}}
                    <div class="lg:col-span-5">
                        <div class="relative mx-auto max-w-md rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-200/50 dark:border-slate-800 dark:bg-slate-900/60 dark:shadow-black/40">
                            {{-- Header Card --}}
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800/80">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-slate-400 dark:text-slate-500">Jurnal PKL Harian</p>
                                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Dokumentasi Aktivitas</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">
                                    Terverifikasi
                                </span>
                            </div>

                            {{-- Sample Activity Item --}}
                            <div class="mt-4 space-y-3">
                                <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-3.5 dark:border-slate-800/60 dark:bg-slate-800/30">
                                    <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                                        <span>Hari ini • 08.00 - 16.00</span>
                                        <span class="font-medium text-blue-600 dark:text-blue-400">Hadir</span>
                                    </div>
                                    <p class="mt-1.5 text-xs font-medium text-slate-700 dark:text-slate-200">
                                        Pemeliharaan Jaringan & Dokumentasi Server
                                    </p>
                                    <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">
                                        Melakukan pengecekan switch, konfigurasi IP address, dan pencatatan log router.
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <div class="rounded-lg border border-slate-100 bg-slate-50/50 p-2.5 dark:border-slate-800/60 dark:bg-slate-800/20">
                                        <p class="text-[10px] text-slate-400">Guru Pembimbing</p>
                                        <p class="mt-0.5 font-medium text-slate-700 dark:text-slate-300">Telah Ditinjau</p>
                                    </div>
                                    <div class="rounded-lg border border-slate-100 bg-slate-50/50 p-2.5 dark:border-slate-800/60 dark:bg-slate-800/20">
                                        <p class="text-[10px] text-slate-400">Mentor Industri</p>
                                        <p class="mt-0.5 font-medium text-slate-700 dark:text-slate-300">Disetujui</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Subtle Bottom Note --}}
                            <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 text-[11px] text-slate-400 dark:border-slate-800/80 dark:text-slate-500">
                                <span>Status Sinkronisasi Real-time</span>
                                <span class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. TENTANG APLIKASI --}}
        <section id="tentang" class="border-t border-slate-200/80 bg-white py-16 dark:border-slate-800/80 dark:bg-slate-900/30 sm:py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                        Tentang
                    </p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                        Apa Itu Jurnal PKL Online?
                    </h2>
                </div>

                <div class="mt-8 space-y-4 text-center text-sm leading-relaxed text-slate-600 dark:text-slate-300 sm:text-base">
                    <p>
                        Jurnal PKL Online merupakan aplikasi yang digunakan untuk mendukung proses administrasi, pencatatan, pemantauan, dan dokumentasi kegiatan Praktik Kerja Lapangan dalam satu lingkungan digital yang terpadu.
                    </p>
                    <p>
                        Dengan menggantikan format jurnal konvensional berbasis kertas, aplikasi ini menghadirkan efisiensi bagi peserta didik dan pihak sekolah agar seluruh riwayat kegiatan tercatat rapi, transparan, dan mudah diakses kapan saja.
                    </p>
                </div>
            </div>
        </section>

        {{-- 4. TUJUAN APLIKASI --}}
        <section class="border-t border-slate-200/80 py-16 dark:border-slate-800/80 sm:py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                        Tujuan
                    </p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                        Untuk Apa Aplikasi Ini Dibuat?
                    </h2>
                </div>

                <div class="mt-8 text-center text-sm leading-relaxed text-slate-600 dark:text-slate-300 sm:text-base">
                    <p>
                        Aplikasi ini dibuat untuk membantu proses pelaksanaan PKL menjadi lebih terorganisir, memudahkan peserta didik dalam mencatat kegiatan harian, serta membantu pihak sekolah dan pembimbing dalam memantau keaktifan maupun perkembangan kompetensi siswa secara berkala.
                    </p>
                </div>

                {{-- Clean 3 Pilar Ringkas (Bukan fitur detail, melainkan gambaran esensi) --}}
                <div class="mt-12 grid gap-6 sm:grid-cols-3">
                    <div class="rounded-xl border border-slate-200/80 bg-white p-6 text-center transition dark:border-slate-800 dark:bg-slate-900/40">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                            </svg>
                        </div>
                        <h3 class="mt-3 text-sm font-semibold text-slate-900 dark:text-white">Pencatatan Teratur</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Mempermudah pengisian jurnal dan presensi harian siswa.</p>
                    </div>

                    <div class="rounded-xl border border-slate-200/80 bg-white p-6 text-center transition dark:border-slate-800 dark:bg-slate-900/40">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-3 text-sm font-semibold text-slate-900 dark:text-white">Pemantauan Berkala</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Membantu pembimbing dan mentor memvalidasi kegiatan siswa.</p>
                    </div>

                    <div class="rounded-xl border border-slate-200/80 bg-white p-6 text-center transition dark:border-slate-800 dark:bg-slate-900/40">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-950/50 dark:text-indigo-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.143 2.143L15.75 6" />
                            </svg>
                        </div>
                        <h3 class="mt-3 text-sm font-semibold text-slate-900 dark:text-white">Dokumentasi Terpusat</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Menyimpan arsip kegiatan secara aman dan terorganisir.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. PENGGUNA APLIKASI --}}
        <section id="pengguna" class="border-t border-slate-200/80 bg-white py-16 dark:border-slate-800/80 dark:bg-slate-900/30 sm:py-20">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                        Peran
                    </p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                        Digunakan Oleh
                    </h2>
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                        Setiap pihak memiliki akses dan fungsi sesuai dengan perannya dalam pelaksanaan PKL.
                    </p>
                </div>

                <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    {{-- Siswa --}}
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/50 p-5 transition hover:border-slate-300 dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-slate-700">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                                </svg>
                            </span>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">Siswa</h3>
                        </div>
                        <p class="mt-3 text-xs leading-relaxed text-slate-600 dark:text-slate-300">
                            Mencatat kehadiran, mengisi jurnal kegiatan harian, dan mengunggah dokumentasi PKL.
                        </p>
                    </div>

                    {{-- Guru Pembimbing --}}
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/50 p-5 transition hover:border-slate-300 dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-slate-700">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </span>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">Guru Pembimbing</h3>
                        </div>
                        <p class="mt-3 text-xs leading-relaxed text-slate-600 dark:text-slate-300">
                            Memantau kehadiran, meninjau jurnal harian, dan memberikan bimbingan kepada siswa.
                        </p>
                    </div>

                    {{-- Mentor Industri --}}
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/50 p-5 transition hover:border-slate-300 dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-slate-700">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                </svg>
                            </span>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">Mentor Industri</h3>
                        </div>
                        <p class="mt-3 text-xs leading-relaxed text-slate-600 dark:text-slate-300">
                            Memvalidasi aktivitas di tempat PKL serta memberikan arahan teknis lapangan.
                        </p>
                    </div>

                    {{-- Admin Sekolah --}}
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/50 p-5 transition hover:border-slate-300 dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-slate-700">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-100 text-purple-600 dark:bg-purple-950/60 dark:text-purple-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">Admin Sekolah</h3>
                        </div>
                        <p class="mt-3 text-xs leading-relaxed text-slate-600 dark:text-slate-300">
                            Mengelola data penempatan, pembagian pembimbing, dan administrasi program PKL.
                        </p>
                    </div>

                    {{-- Kepala Sekolah --}}
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/50 p-5 transition hover:border-slate-300 dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-slate-700 sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-950/60 dark:text-sky-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                                </svg>
                            </span>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">Kepala Sekolah</h3>
                        </div>
                        <p class="mt-3 text-xs leading-relaxed text-slate-600 dark:text-slate-300">
                            Memantau laporan menyeluruh dan evaluasi pelaksanaan PKL tingkat sekolah.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. PENUTUP --}}
        <section class="border-t border-slate-200/80 py-16 text-center dark:border-slate-800/80 sm:py-20">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    Kelola kegiatan PKL secara lebih terstruktur dalam satu platform.
                </h2>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                    Akses mudah untuk seluruh peserta didik, pembimbing, mentor, dan manajemen sekolah.
                </p>
                <div class="mt-8 flex justify-center">
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-sm shadow-blue-500/30 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-[#070b18]"
                    >
                        <span>Masuk ke Aplikasi</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </main>

    {{-- 7. FOOTER --}}
    <footer class="border-t border-slate-200/80 bg-white transition-colors dark:border-slate-800/80 dark:bg-[#070b18]">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                {{-- Brand & About --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5">
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
                    </div>
                    <p class="text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                        Platform pencatatan, pemantauan, dan administrasi Praktik Kerja Lapangan (PKL) terpadu untuk sekolah kejuruan dan perguruan tinggi.
                    </p>
                    <div class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50/80 px-2.5 py-1 text-[11px] font-medium text-emerald-700 dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Platform Aktif & Siap Digunakan
                    </div>
                </div>

                {{-- Navigasi Cepat --}}
                <div class="space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-white">
                        Navigasi
                    </p>
                    <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-300">
                        <li>
                            <a href="#beranda" class="transition hover:text-blue-600 dark:hover:text-blue-400">
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="#tentang" class="transition hover:text-blue-600 dark:hover:text-blue-400">
                                Tentang Aplikasi
                            </a>
                        </li>
                        <li>
                            <a href="#pengguna" class="transition hover:text-blue-600 dark:hover:text-blue-400">
                                Peran Pengguna
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="transition hover:text-blue-600 dark:hover:text-blue-400">
                                Masuk ke Aplikasi
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Kontak Info Tim --}}
                <div class="space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-white">
                        Kontak Tim
                    </p>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-300">
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <a href="mailto:sigmaaatech2@gmail.com" class="transition hover:text-blue-600 hover:underline dark:hover:text-blue-400">
                                sigmaaatech2@gmail.com
                            </a>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            <a href="https://wa.me/6283180146264" target="_blank" rel="noopener noreferrer" class="transition hover:text-emerald-600 hover:underline dark:hover:text-emerald-400">
                                +62 83180146264
                            </a>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span>Indonesia (Daring / Remote)</span>
                        </li>
                    </ul>
                </div>

                {{-- Sosial Media Tim --}}
                <div class="space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-white">
                        Sosial Media Tim
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Ikuti perkembangan pembaruan sistem dan informasi terkini dari tim pengembang kami:
                    </p>
                    <div class="flex items-center gap-2 pt-1">
                        {{-- Instagram --}}
                        <a
                            href="https://www.instagram.com/sigma_techid"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram Tim"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-pink-500 hover:bg-pink-50 hover:text-pink-600 dark:border-slate-800 dark:text-slate-300 dark:hover:border-pink-500/50 dark:hover:bg-pink-950/40 dark:hover:text-pink-400"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>

                        {{-- GitHub --}}
                        <a
                            href="https://github.com/sigmaaatech2-eng"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="GitHub Tim"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-slate-400 hover:bg-slate-100 hover:text-slate-900 dark:border-slate-800 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:bg-slate-800 dark:hover:text-white"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                            </svg>
                        </a>

                        {{--TikTok --}}
                        <a
                            href="https://www.tiktok.com/@sigmatech.id"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="TikTok Tim"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-black hover:bg-black hover:text-white dark:border-slate-800 dark:text-slate-300 dark:hover:border-black dark:hover:bg-black dark:hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
                            </svg>
                        </a>

                        {{-- WhatsApp Langsung --}}
                        <a
                            href="https://wa.me/6283180146264"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Chat WhatsApp Tim"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-600 dark:border-slate-800 dark:text-slate-300 dark:hover:border-emerald-500/50 dark:hover:bg-emerald-950/40 dark:hover:text-emerald-400"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bottom Divider & Copyright --}}
            <div class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-slate-100 pt-6 text-xs text-slate-400 dark:border-slate-800/80 dark:text-slate-500 sm:flex-row">
                <p>
                    &copy; {{ date('Y') }} Jurnal PKL Online. Seluruh hak cipta dilindungi.
                </p>
                <p>
                    Dikembangkan oleh Tim Sigma Tech ID.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
