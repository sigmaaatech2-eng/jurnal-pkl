<x-layouts.app title="Dashboard Kepala Sekolah">

    {{-- SCRIPTDATA & CHART.JS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    {{-- WELCOME BANNER --}}
    <div class="mb-8">
        <div class="rounded-2xl border border-violet-100 bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-700 p-6 text-white shadow-lg dark:border-violet-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-violet-100 backdrop-blur">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Portal Kepala Sekolah
                    </span>
                    <h1 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl">
                        Selamat datang, {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="mt-1 text-sm text-violet-100">
                        Pantau statistik siswa per jurusan, grafik perkembangan, dan aktivitas PKL secara terpusat.
                    </p>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    <a href="{{ route('kepala-sekolah.recap.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-violet-700 shadow-md transition hover:bg-violet-50 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                        <span>Lihat Rekap PKL</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 6 KARTU STATISTIK UTAMA --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">

        {{-- Total Siswa PKL --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Siswa PKL
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">{{ $totalStudentsPkl }}</p>
            <p class="mt-1 text-xs text-slate-400">Siswa aktif PKL</p>
        </div>

        {{-- Hadir Hari Ini --}}
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                    Hadir Hari Ini
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-emerald-700 dark:text-emerald-300">{{ $presentToday }}</p>
            <p class="mt-1 text-xs text-emerald-600/80 dark:text-emerald-400/80">Sudah check-in</p>
        </div>

        {{-- Total Jurnal --}}
        <div class="rounded-2xl border border-blue-200 bg-blue-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-blue-500/20 dark:bg-blue-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-400">
                    Total Jurnal
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-blue-700 dark:text-blue-300">{{ $totalJournals }}</p>
            <p class="mt-1 text-xs text-blue-600/80 dark:text-blue-400/80">Semua jurnal masuk</p>
        </div>

        {{-- Menunggu Review --}}
        <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-amber-500/20 dark:bg-amber-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">
                    Menunggu Review
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-amber-700 dark:text-amber-300">{{ $pendingJournals }}</p>
            <p class="mt-1 text-xs text-amber-600/80 dark:text-amber-400/80">Jurnal belum divalidasi</p>
        </div>

        {{-- Disetujui --}}
        <div class="rounded-2xl border border-teal-200 bg-teal-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-teal-500/20 dark:bg-teal-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">
                    Disetujui
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-100 text-teal-700 dark:bg-teal-500/20 dark:text-teal-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-teal-700 dark:text-teal-300">{{ $approvedJournals }}</p>
            <p class="mt-1 text-xs text-teal-600/80 dark:text-teal-400/80">Jurnal valid</p>
        </div>

        {{-- Ditolak --}}
        <div class="rounded-2xl border border-red-200 bg-red-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-red-500/20 dark:bg-red-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-red-700 dark:text-red-400">
                    Ditolak
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-red-700 dark:text-red-300">{{ $rejectedJournals }}</p>
            <p class="mt-1 text-xs text-red-600/80 dark:text-red-400/80">Perlu revisi</p>
        </div>

    </div>

    {{-- SECTION: GRAFIK PERKEMBANGAN SISWA --}}
    <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- GRAFIK 1: TREN AKTIVITAS JURNAL & KEHADIRAN (7 HARI TERAKHIR) --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:col-span-2">
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">
                        Grafik Tren Aktivitas Siswa PKL
                    </h3>
                    <p class="text-xs text-slate-400">
                        Perkembangan jumlah jurnal terkirim dan presensi kehadiran harian (7 Hari Terakhir)
                    </p>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <span class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300">
                        <span class="h-3 w-3 rounded-full bg-violet-600"></span>
                        Jurnal Kegiatan
                    </span>
                    <span class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300">
                        <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                        Siswa Hadir
                    </span>
                </div>
            </div>

            <div class="relative h-72 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- GRAFIK 2: DISTRIBUSI SISWA BERDASARKAN JURUSAN --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-800 dark:text-white">
                    Distribusi Siswa PKL
                </h3>
                <p class="text-xs text-slate-400">
                    Proporsi siswa aktif magang per jurusan
                </p>
            </div>

            <div class="relative flex items-center justify-center h-64 w-full">
                <canvas id="majorDonutChart"></canvas>
            </div>

            <div class="mt-3 border-t border-slate-100 pt-3 text-center text-xs text-slate-400 dark:border-slate-800">
                Total terdaftar: <span class="font-bold text-slate-700 dark:text-slate-200">{{ array_sum($chartMajorTotals) }} siswa</span>
            </div>
        </div>

    </div>

    {{-- SECTION: STATISTIK SISWA PER JURUSAN --}}
    <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800 dark:text-white">
                    Statistik Siswa Berdasarkan Jurusan
                </h2>
                <p class="text-xs text-slate-400">
                    Rekapitulasi kuota, jumlah siswa magang aktif, dan persentase penempatan PKL per kompetensi keahlian
                </p>
            </div>
            <a
                href="{{ route('kepala-sekolah.students.index') }}"
                class="inline-flex items-center gap-1 text-xs font-semibold text-violet-600 hover:text-violet-700 dark:text-violet-400"
            >
                <span>Lihat Semua Siswa</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        @if ($majorStats->isEmpty())
            <div class="py-12 text-center text-sm text-slate-400">
                Belum ada data kategori jurusan siswa.
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($majorStats as $stat)
                    @php
                        // Memberikan tema warna unik per jurusan
                        $colors = [
                            'Rekayasa Perangkat Lunak (RPL)' => ['bg' => 'bg-indigo-50 dark:bg-indigo-500/10', 'border' => 'border-indigo-100 dark:border-indigo-500/20', 'text' => 'text-indigo-600 dark:text-indigo-400', 'bar' => 'bg-indigo-600'],
                            'Teknik Komputer dan Jaringan (TKJ)' => ['bg' => 'bg-blue-50 dark:bg-blue-500/10', 'border' => 'border-blue-100 dark:border-blue-500/20', 'text' => 'text-blue-600 dark:text-blue-400', 'bar' => 'bg-blue-600'],
                            'Desain Komunikasi Visual (DKV)' => ['bg' => 'bg-purple-50 dark:bg-purple-500/10', 'border' => 'border-purple-100 dark:border-purple-500/20', 'text' => 'text-purple-600 dark:text-purple-400', 'bar' => 'bg-purple-600'],
                            'Akuntansi dan Keuangan Lembaga (AKL)' => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'border' => 'border-emerald-100 dark:border-emerald-500/20', 'text' => 'text-emerald-600 dark:text-emerald-400', 'bar' => 'bg-emerald-600'],
                            'Otomatisasi dan Tata Kelola Perkantoran (OTKP)' => ['bg' => 'bg-amber-50 dark:bg-amber-500/10', 'border' => 'border-amber-100 dark:border-amber-500/20', 'text' => 'text-amber-600 dark:text-amber-400', 'bar' => 'bg-amber-600'],
                            'Teknik Kendaraan Ringan (TKR)' => ['bg' => 'bg-rose-50 dark:bg-rose-500/10', 'border' => 'border-rose-100 dark:border-rose-500/20', 'text' => 'text-rose-600 dark:text-rose-400', 'bar' => 'bg-rose-600'],
                        ];
                        $c = $colors[$stat['major']] ?? ['bg' => 'bg-slate-50 dark:bg-slate-800', 'border' => 'border-slate-200 dark:border-slate-700', 'text' => 'text-slate-600 dark:text-slate-300', 'bar' => 'bg-violet-600'];
                    @endphp
                    <div class="rounded-2xl border {{ $c['border'] }} {{ $c['bg'] }} p-5 transition hover:shadow-sm">
                        <div class="flex items-start justify-between">
                            <span class="rounded-lg bg-white px-2.5 py-1 text-xs font-bold uppercase tracking-wider {{ $c['text'] }} shadow-xs dark:bg-slate-900">
                                {{ Str::limit($stat['major'], 26) }}
                            </span>
                            <span class="text-xs font-extrabold text-slate-700 dark:text-slate-200">
                                {{ $stat['percentage'] }}% Aktif
                            </span>
                        </div>

                        <div class="mt-4 flex items-baseline justify-between">
                            <div>
                                <span class="text-3xl font-extrabold text-slate-800 dark:text-white">{{ $stat['active'] }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">/ {{ $stat['total'] }} Siswa PKL</span>
                            </div>
                            <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                {{ $stat['active'] }} di DUDI
                            </span>
                        </div>

                        {{-- Progress Bar Penempatan --}}
                        <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-slate-200/70 dark:bg-slate-700">
                            <div class="h-full rounded-full {{ $c['bar'] }}" style="width: {{ $stat['percentage'] }}%"></div>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                            <span>Belum Ditempatkan: <strong class="text-slate-700 dark:text-slate-300">{{ $stat['unassigned'] }}</strong></span>
                            <a
                                href="{{ route('kepala-sekolah.students.index', ['jurusan' => $stat['major']]) }}"
                                class="font-medium text-violet-600 hover:underline dark:text-violet-400"
                            >
                                Filter &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- RINGKASAN KONDISI PKL TERKINI --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 dark:border-slate-800">
            <div>
                <h2 class="text-base font-bold text-slate-800 dark:text-white">Penempatan PKL Aktif Terkini</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500">Ringkasan siswa yang sedang aktif magang di instansi mitra</p>
            </div>
            <a href="{{ route('kepala-sekolah.students.index') }}"
               class="inline-flex items-center gap-1.5 rounded-xl bg-violet-50 px-3 py-1.5 text-xs font-semibold text-violet-600 transition hover:bg-violet-100 dark:bg-violet-500/10 dark:text-violet-400 dark:hover:bg-violet-500/20">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        @if ($recentInternships->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-4 h-12 w-12 text-slate-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175" />
                </svg>
                <p class="text-sm font-semibold text-slate-400 dark:text-slate-600">Belum ada penempatan PKL aktif</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Tempat PKL</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Guru Pembimbing</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($recentInternships as $internship)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-600 dark:bg-violet-500/20 dark:text-violet-400">
                                            {{ strtoupper(substr($internship->student->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="font-medium text-slate-800 dark:text-white">{{ $internship->student->name ?? '–' }}</span>
                                            <div class="text-[11px] text-slate-400">{{ $internship->student->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                        {{ $internship->student->jurusan ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $internship->company_name ?? '–' }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $internship->teacher->name ?? '–' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('kepala-sekolah.students.show', $internship) }}"
                                       class="inline-flex items-center gap-1 rounded-lg bg-violet-50 px-3 py-1.5 text-xs font-semibold text-violet-600 transition hover:bg-violet-100 dark:bg-violet-500/10 dark:text-violet-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- CHART.JS INITIALIZATION --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isDarkMode = document.documentElement.classList.contains('dark');
            const textColor = isDarkMode ? '#94a3b8' : '#64748b';
            const gridColor = isDarkMode ? '#1e293b' : '#f1f5f9';

            // 1. Line Chart: Tren Aktivitas Jurnal & Kehadiran
            const ctxTrend = document.getElementById('trendChart');
            if (ctxTrend) {
                new Chart(ctxTrend, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [
                            {
                                label: 'Jurnal Masuk',
                                data: {!! json_encode($chartJournals) !!},
                                borderColor: '#7c3aed',
                                backgroundColor: 'rgba(124, 58, 237, 0.12)',
                                fill: true,
                                tension: 0.35,
                                pointBackgroundColor: '#7c3aed',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                borderWidth: 2.5
                            },
                            {
                                label: 'Siswa Hadir',
                                data: {!! json_encode($chartAttendances) !!},
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.08)',
                                fill: true,
                                tension: 0.35,
                                pointBackgroundColor: '#10b981',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                borderWidth: 2.5
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                padding: 12,
                                cornerRadius: 10,
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 12 }
                            }
                        },
                        scales: {
                            x: {
                                grid: { color: gridColor },
                                ticks: { color: textColor, font: { size: 11 } }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: {
                                    precision: 0,
                                    color: textColor,
                                    font: { size: 11 }
                                }
                            }
                        }
                    }
                });
            }

            // 2. Donut Chart: Distribusi Siswa PKL Berdasarkan Jurusan
            const ctxMajor = document.getElementById('majorDonutChart');
            if (ctxMajor) {
                new Chart(ctxMajor, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($chartMajorLabels) !!},
                        datasets: [{
                            data: {!! json_encode($chartMajorActives) !!},
                            backgroundColor: [
                                '#6366f1',
                                '#0ea5e9',
                                '#a855f7',
                                '#10b981',
                                '#f59e0b',
                                '#f43f5e',
                                '#64748b'
                            ],
                            borderWidth: 2,
                            borderColor: isDarkMode ? '#0f172a' : '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 10,
                                    padding: 12,
                                    color: textColor,
                                    font: { size: 11 }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush

</x-layouts.app>