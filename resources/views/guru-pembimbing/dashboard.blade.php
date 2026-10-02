<x-layouts.app title="Dashboard Guru Pembimbing">

    {{-- WELCOME BANNER --}}
    <section class="mb-7 flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                    Portal Guru Pembimbing
                </span>
            </div>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-800 dark:text-white">
                Selamat datang, {{ auth()->user()->name }} 👋
            </h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Pantau perkembangan aktivitas, status jurnal, dan presensi siswa bimbingan PKL Anda.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="17" rx="2" />
                    <path d="M8 2v4M16 2v4M3 10h18" />
                </svg>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </section>

    {{-- ALERT MENUNGGU VALIDASI MENTOR JIKA ADA --}}
    @if (($pendingJournals ?? 0) > 0)
        <div class="mb-6 flex flex-col items-start justify-between gap-4 rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50/90 via-amber-50/50 to-orange-50/70 p-5 dark:border-amber-500/20 dark:from-amber-500/10 dark:via-amber-500/5 dark:to-transparent sm:flex-row sm:items-center">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-md shadow-amber-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white">
                        Ada {{ $pendingJournals }} Jurnal Menunggu Validasi Mentor
                    </h3>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400">
                        Siswa bimbingan telah mengirimkan catatan kegiatan yang sedang menunggu validasi oleh mentor PKL.
                    </p>
                </div>
            </div>
            <a
                href="{{ route('guru-pembimbing.journals.index') }}"
                class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600"
            >
                <span>Pantau Jurnal</span>
                <span>→</span>
            </a>
        </div>
    @endif

    {{-- 1. STATISTIK UTAMA --}}
    <section class="mb-7 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- TOTAL SISWA BIMBINGAN --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Total Siswa Bimbingan
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
                        {{ $totalStudents ?? 0 }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400">
                        Siswa aktif dalam bimbingan PKL
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- HADIR HARI INI --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Hadir Hari Ini
                    </p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600 dark:text-emerald-400">
                        {{ $presentToday ?? 0 }}
                        <span class="text-base font-medium text-slate-400">/ {{ $totalStudents ?? 0 }}</span>
                    </p>
                    <p class="mt-2 text-xs text-slate-400">
                        @if(($totalStudents ?? 0) > 0)
                            {{ round((($presentToday ?? 0) / $totalStudents) * 100) }}% tingkat kehadiran hari ini
                        @else
                            Belum ada presensi
                        @endif
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- JURNAL MASUK --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Jurnal Masuk
                    </p>
                    <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">
                        {{ $totalJournals ?? 0 }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400">
                        Total akumulasi jurnal kegiatan
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-8.25A3.375 3.375 0 0 0 4.5 11.625v6.75a3.375 3.375 0 0 0 3.375 3.375H16.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3.75h7.5" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- JURNAL MENUNGGU VALIDASI MENTOR --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Menunggu Validasi
                    </p>
                    <p class="mt-2 text-3xl font-bold text-amber-500">
                        {{ $pendingJournals ?? 0 }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400">
                        {{ ($pendingJournals ?? 0) > 0 ? 'Menunggu validasi mentor' : 'Semua jurnal beres' }}
                    </p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-500 dark:bg-amber-500/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

    </section>

    {{-- QUICK ACTION (AKSI CEPAT) --}}
    <section class="mb-7">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">
                Aksi Cepat & Navigasi
            </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- 1. LIHAT SEMUA SISWA --}}
            <a
                href="{{ route('guru-pembimbing.students.index') }}"
                class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-blue-300 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-blue-500/40"
            >
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/10 dark:text-blue-400 dark:group-hover:bg-blue-600 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 transition group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400">
                            Lihat Semua Siswa
                        </h3>
                        <p class="text-xs text-slate-400">
                            Kelola data & tempat PKL
                        </p>
                    </div>
                </div>
                <span class="text-slate-300 transition group-hover:translate-x-1 group-hover:text-blue-600 dark:text-slate-600 dark:group-hover:text-blue-400">
                    →
                </span>
            </a>

            {{-- 2. MONITORING JURNAL --}}
            <a
                href="{{ route('guru-pembimbing.journals.index') }}"
                class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-amber-300 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-amber-500/40"
            >
                <div class="flex items-center gap-4">
                    <div class="relative flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-500 transition group-hover:bg-amber-500 group-hover:text-white dark:bg-amber-500/10 dark:group-hover:bg-amber-500 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-8.25A3.375 3.375 0 0 0 4.5 11.625v6.75a3.375 3.375 0 0 0 3.375 3.375H16.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3.75h7.5" />
                        </svg>
                        @if(($pendingJournals ?? 0) > 0)
                            <span class="absolute -right-1 -top-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">
                                {{ $pendingJournals }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 transition group-hover:text-amber-500 dark:text-white dark:group-hover:text-amber-400">
                            Monitoring Jurnal
                        </h3>
                        <p class="text-xs text-slate-400">
                            Pantau aktivitas jurnal
                        </p>
                    </div>
                </div>
                <span class="text-slate-300 transition group-hover:translate-x-1 group-hover:text-amber-500 dark:text-slate-600 dark:group-hover:text-amber-400">
                    →
                </span>
            </a>

            {{-- 3. MONITORING ABSENSI --}}
            <a
                href="{{ route('guru-pembimbing.attendances.index') }}"
                class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-emerald-300 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-emerald-500/40"
            >
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white dark:bg-emerald-500/10 dark:text-emerald-400 dark:group-hover:bg-emerald-600 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M8 2v4M16 2v4M3 10h18" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 transition group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                            Monitoring Absensi
                        </h3>
                        <p class="text-xs text-slate-400">
                            Pantau presensi harian
                        </p>
                    </div>
                </div>
                <span class="text-slate-300 transition group-hover:translate-x-1 group-hover:text-emerald-600 dark:text-slate-600 dark:group-hover:text-emerald-400">
                    →
                </span>
            </a>

            {{-- 4. LIHAT REKAP --}}
            <a
                href="{{ route('guru-pembimbing.recap.index') }}"
                class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-indigo-500/40"
            >
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white dark:bg-indigo-500/10 dark:text-indigo-400 dark:group-hover:bg-indigo-600 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 transition group-hover:text-indigo-600 dark:text-white dark:group-hover:text-indigo-400">
                            Lihat Rekap
                        </h3>
                        <p class="text-xs text-slate-400">
                            Rekapitulasi PKL lengkap
                        </p>
                    </div>
                </div>
                <span class="text-slate-300 transition group-hover:translate-x-1 group-hover:text-indigo-600 dark:text-slate-600 dark:group-hover:text-indigo-400">
                    →
                </span>
            </a>

        </div>
    </section>

    {{-- 2. BAGIAN MONITORING (DUA KOLOM: DAFTAR SISWA & AKTIVITAS TERBARU) --}}
    <div class="grid gap-6 xl:grid-cols-12">

        {{-- KOLOM KIRI (8 COLS): DAFTAR SISWA BIMBINGAN TERBARU --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 xl:col-span-8">
            <div class="mb-5 flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                        Daftar Siswa Bimbingan
                    </h2>
                    <p class="text-xs text-slate-400">
                        Progres penulisan jurnal dan tempat penugasan PKL siswa
                    </p>
                </div>

                <a
                    href="{{ route('guru-pembimbing.students.index') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                >
                    <span>Lihat Semua Siswa ({{ $totalStudents ?? 0 }})</span>
                    <span>→</span>
                </a>
            </div>

            @if (!isset($recentStudents) || $recentStudents->isEmpty())
                <div class="rounded-xl border border-dashed border-slate-200 p-10 text-center dark:border-slate-800">
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-slate-700 dark:text-slate-300">Belum Ada Siswa Bimbingan</p>
                    <p class="mt-1 text-xs text-slate-400">Admin sekolah belum menetapkan siswa untuk dibimbing oleh Anda.</p>
                </div>
            @else
                <div class="space-y-3.5">
                    @foreach ($recentStudents as $student)
                        <div class="flex flex-col gap-4 rounded-xl border border-slate-100 p-4.5 transition hover:border-blue-200 hover:bg-blue-50/30 dark:border-slate-800 dark:hover:border-slate-700 dark:hover:bg-slate-800/40 md:flex-row md:items-center md:justify-between">

                            {{-- SISWA & TEMPAT PKL --}}
                            <div class="flex items-center gap-3.5 min-w-0 flex-1">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="truncate text-sm font-bold text-slate-800 dark:text-white">
                                            {{ $student->name }}
                                        </h3>
                                        {{-- STATUS BADGE --}}
                                        @if ($student->status === 'active')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <span class="h-1 w-1 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                                {{ ucfirst($student->status) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-1 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>
                                        <span class="truncate">{{ $student->company_name }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- PROGRESS JURNAL --}}
                            <div class="w-full md:w-48 lg:w-56 shrink-0">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-medium text-slate-600 dark:text-slate-300">
                                        Progress Jurnal
                                    </span>
                                    <span class="font-bold text-slate-800 dark:text-white">
                                        {{ $student->approved_journals }} / {{ $student->total_journals }}
                                    </span>
                                </div>
                                <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                    <div
                                        class="h-full rounded-full transition-all duration-500 {{ $student->progress_percent >= 80 ? 'bg-emerald-500' : ($student->progress_percent >= 40 ? 'bg-blue-600' : 'bg-amber-500') }}"
                                        style="width: {{ max(6, $student->progress_percent) }}%"
                                    ></div>
                                </div>
                                <div class="mt-1 flex items-center justify-between text-[11px]">
                                    <span class="text-slate-400">
                                        {{ $student->progress_percent }}% terverifikasi
                                    </span>
                                    @if ($student->pending_journals > 0)
                                        <span class="font-semibold text-amber-500">
                                            {{ $student->pending_journals }} pending
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- TOMBOL LIHAT DETAIL --}}
                            <div class="shrink-0 pt-2 md:pt-0">
                                <a
                                    href="{{ $student->url }}"
                                    class="inline-flex w-full items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-700 md:w-auto"
                                >
                                    <span>Lihat Detail</span>
                                    <span class="text-slate-400">→</span>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- KOLOM KANAN (4 COLS): AKTIVITAS TERBARU --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 xl:col-span-4">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                        Aktivitas Terbaru
                    </h2>
                    <p class="text-xs text-slate-400">
                        Jurnal masuk, review, & absensi terkini
                    </p>
                </div>
                <span class="relative flex h-2.5 w-2.5">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                </span>
            </div>

            @if (!isset($recentActivities) || $recentActivities->isEmpty())
                <div class="py-12 text-center">
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Belum Ada Aktivitas</p>
                    <p class="mt-1 text-xs text-slate-400">Aktivitas jurnal dan absensi siswa akan muncul di sini.</p>
                </div>
            @else
                <div class="relative space-y-4 before:absolute before:bottom-3 before:left-5 before:top-3 before:w-0.5 before:bg-slate-100 dark:before:bg-slate-800">
                    @foreach ($recentActivities as $act)
                        <a
                            href="{{ $act->url }}"
                            class="group relative flex items-start gap-3.5 rounded-xl p-2 transition hover:bg-slate-50 dark:hover:bg-slate-800/60"
                        >
                            {{-- ICON BADGE --}}
                            <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl ring-4 ring-white dark:ring-slate-900
                                @if($act->type === 'journal_submitted')
                                    bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400
                                @elseif($act->type === 'journal_reviewed')
                                    @if(($act->status ?? '') === 'approved')
                                        bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400
                                    @else
                                        bg-rose-100 text-rose-600 dark:bg-rose-500/20 dark:text-rose-400
                                    @endif
                                @else
                                    bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400
                                @endif
                            ">
                                @if ($act->type === 'journal_submitted')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-8.25A3.375 3.375 0 0 0 4.5 11.625v6.75a3.375 3.375 0 0 0 3.375 3.375H16.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3.75h7.5" />
                                    </svg>
                                @elseif ($act->type === 'journal_reviewed')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="4" width="18" height="17" rx="2" />
                                        <path d="M8 2v4M16 2v4M3 10h18" />
                                    </svg>
                                @endif
                            </div>

                            {{-- CONTENT --}}
                            <div class="min-w-0 flex-1 pt-0.5">
                                <div class="flex items-center justify-between gap-1">
                                    <p class="truncate text-xs font-bold text-slate-800 group-hover:text-blue-600 dark:text-slate-100 dark:group-hover:text-blue-400">
                                        {{ $act->title }}
                                    </p>
                                    <span class="shrink-0 text-[10px] text-slate-400">
                                        {{ $act->time ? \Carbon\Carbon::parse($act->time)->diffForHumans() : '' }}
                                    </span>
                                </div>
                                <p class="mt-0.5 text-xs text-slate-600 line-clamp-2 dark:text-slate-300">
                                    {{ $act->description }}
                                </p>
                                @if (!empty($act->company))
                                    <span class="mt-1 inline-block text-[10px] font-medium text-slate-400">
                                        🏢 {{ $act->company }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

</x-layouts.app>
