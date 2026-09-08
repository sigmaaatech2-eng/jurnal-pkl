<x-layouts.app :title="'Laporan & Statistik Platform - Admin Platform'">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Laporan & Statistik Platform
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Ringkasan eksekutif performa platform, pertumbuhan akun, dan pendapatan langganan sekolah.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button
                type="button"
                onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 active:scale-95 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                <span>Cetak Laporan</span>
            </button>
        </div>
    </div>

    {{-- METRIK UTAMA --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- TOTAL PENDAPATAN --}}
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                    Total Pendapatan
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-extrabold text-emerald-700 dark:text-emerald-300">
                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
            </p>
            <p class="mt-1 text-xs text-emerald-600/80 dark:text-emerald-400/80">
                Transaksi terkonfirmasi
            </p>
        </div>

        {{-- SEKOLAH PELANGGAN --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Sekolah Pelanggan
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">
                {{ $stats['total_schools'] }}
            </p>
            <p class="mt-1 text-xs text-blue-600 dark:text-blue-400 font-medium">
                {{ $stats['active_schools'] }} sekolah berstatus aktif
            </p>
        </div>

        {{-- TOTAL PENGGUNA --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Total Pengguna
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">
                {{ $stats['total_users'] }}
            </p>
            <p class="mt-1 text-xs text-slate-400">
                Semua aktor sistem terdaftar
            </p>
        </div>

        {{-- PENEMPATAN PKL --}}
        <div class="rounded-2xl border border-blue-200 bg-blue-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-blue-500/20 dark:bg-blue-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-400">
                    Penempatan PKL
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-blue-700 dark:text-blue-300">
                {{ $stats['total_internships'] }}
            </p>
            <p class="mt-1 text-xs text-blue-600/80 dark:text-blue-400/80 font-medium">
                {{ $stats['active_internships'] }} penempatan aktif
            </p>
        </div>

    </div>

    {{-- DETAIL ANALISIS (DISTRIBUSI ROLE & PERTUMBUHAN) --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- DISTRIBUSI ROLE --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-base font-bold text-slate-800 dark:text-white mb-1">Distribusi Pengguna Berdasarkan Peran</h3>
            <p class="text-xs text-slate-400 mb-6">Persentase komposisi akun yang aktif di seluruh ekosistem</p>

            <div class="space-y-4">
                @php
                    $roleStyles = [
                        'siswa' => ['label' => 'Siswa PKL', 'bar' => 'bg-blue-600', 'text' => 'text-blue-600 dark:text-blue-400'],
                        'guru_pembimbing' => ['label' => 'Guru Pembimbing', 'bar' => 'bg-emerald-500', 'text' => 'text-emerald-600 dark:text-emerald-400'],
                        'mentor' => ['label' => 'Mentor Industri', 'bar' => 'bg-amber-500', 'text' => 'text-amber-600 dark:text-amber-400'],
                        'admin_sekolah' => ['label' => 'Admin Sekolah', 'bar' => 'bg-purple-500', 'text' => 'text-purple-600 dark:text-purple-400'],
                        'kepala_sekolah' => ['label' => 'Kepala Sekolah', 'bar' => 'bg-rose-500', 'text' => 'text-rose-600 dark:text-rose-400'],
                        'admin_platform' => ['label' => 'Admin Platform', 'bar' => 'bg-indigo-600', 'text' => 'text-indigo-600 dark:text-indigo-400'],
                    ];
                @endphp

                @foreach ($roleDistribution as $r)
                    @php
                        $style = $roleStyles[$r->name] ?? [
                            'label' => ucwords(str_replace('_', ' ', $r->name)),
                            'bar' => 'bg-slate-500',
                            'text' => 'text-slate-600 dark:text-slate-400',
                        ];
                        $percent = $stats['total_users'] > 0 ? round(($r->users_count / $stats['total_users']) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold mb-1.5">
                            <span class="text-slate-700 dark:text-slate-300">{{ $style['label'] }}</span>
                            <span class="{{ $style['text'] }}">{{ $r->users_count }} user ({{ $percent }}%)</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full rounded-full {{ $style['bar'] }} transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- PERTUMBUHAN USER 12 BULAN --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-base font-bold text-slate-800 dark:text-white mb-1">Pertumbuhan Pengguna Baru (12 Bulan)</h3>
            <p class="text-xs text-slate-400 mb-6">Aktivitas registrasi dan penambahan user per bulan</p>

            <div class="space-y-3 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                @php
                    $maxCount = max(array_column($userGrowth, 'count') ?: [1]);
                @endphp
                @foreach ($userGrowth as $growth)
                    @php
                        $width = $maxCount > 0 ? round(($growth['count'] / $maxCount) * 100) : 0;
                    @endphp
                    <div class="flex items-center gap-3 text-xs">
                        <span class="w-20 shrink-0 font-medium text-slate-500 dark:text-slate-400">{{ $growth['label'] }}</span>
                        <div class="flex-1 h-5 rounded-lg bg-slate-100 dark:bg-slate-800 overflow-hidden flex items-center">
                            <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-end pr-2 text-[10px] font-bold text-white transition-all duration-500" style="width: {{ max($width, 6) }}%">
                                @if ($growth['count'] > 0)
                                    {{ $growth['count'] }}
                                @endif
                            </div>
                        </div>
                        <span class="w-8 text-right font-bold text-slate-700 dark:text-slate-300">{{ $growth['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</x-layouts.app>
