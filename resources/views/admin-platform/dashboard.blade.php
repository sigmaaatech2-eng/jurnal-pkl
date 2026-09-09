<x-layouts.app title="Dashboard Admin Platform">

    {{-- WELCOME BANNER --}}
    <div class="mb-8">
        <div class="rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-600 to-indigo-700 p-6 text-white shadow-lg dark:border-blue-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-blue-100 backdrop-blur">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Portal Administrator Platform
                    </span>
                    <h1 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl">
                        Selamat datang, {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="mt-1 text-sm text-blue-100">
                        Pantau seluruh data sekolah pelanggan, pengajuan paket, pengguna sistem, dan audit log secara real-time.
                    </p>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <a
                        href="{{ route('admin-platform.approvals.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-blue-700 shadow-md transition hover:bg-blue-50 active:scale-95"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Persetujuan Langganan</span>
                        @if ($pendingSchools > 0)
                            <span class="ml-1 rounded-full bg-blue-600 px-2 py-0.5 text-xs font-bold text-white">{{ $pendingSchools }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK DATA REAL --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">

        {{-- 1. TOTAL SEKOLAH --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Total Sekolah
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">
                {{ $totalSchools }}
            </p>
            <p class="mt-1 text-xs text-blue-600 dark:text-blue-400 font-medium">
                {{ $activeSchools }} sekolah aktif
            </p>
        </div>

        {{-- 2. MENUNGGU PERSETUJUAN --}}
        <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-amber-500/20 dark:bg-amber-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">
                    Menunggu
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-amber-700 dark:text-amber-300">
                {{ $pendingSchools }}
            </p>
            <p class="mt-1 text-xs text-amber-600/80 dark:text-amber-400/80">
                Perlu verifikasi
            </p>
        </div>

        {{-- 3. TOTAL USER --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Total User
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">
                {{ $totalUsers }}
            </p>
            <p class="mt-1 text-xs text-slate-400">
                Semua role sistem
            </p>
        </div>

        {{-- 4. TOTAL SISWA --}}
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                    Total Siswa
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-emerald-700 dark:text-emerald-300">
                {{ $totalStudents }}
            </p>
            <p class="mt-1 text-xs text-emerald-600/80 dark:text-emerald-400/80">
                Siswa terdaftar
            </p>
        </div>

        {{-- 5. GURU PEMBIMBING --}}
        <div class="rounded-2xl border border-blue-200 bg-blue-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-blue-500/20 dark:bg-blue-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-400">
                    Guru Pembimbing
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-blue-700 dark:text-blue-300">
                {{ $totalTeachers }}
            </p>
            <p class="mt-1 text-xs text-blue-600/80 dark:text-blue-400/80">
                Pembimbing aktif
            </p>
        </div>

        {{-- 6. MENTOR INDUSTRI --}}
        <div class="rounded-2xl border border-purple-200 bg-purple-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-purple-500/20 dark:bg-purple-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-purple-700 dark:text-purple-400">
                    Mentor DUDI
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.999-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-purple-700 dark:text-purple-300">
                {{ $totalMentors }}
            </p>
            <p class="mt-1 text-xs text-purple-600/80 dark:text-purple-400/80">
                Mitra industri
            </p>
        </div>

    </div>

    {{-- MAIN SECTION: LANGGANAN TERBARU & AKSES CEPAT --}}
    <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- LANGGANAN TERBARU --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-100 p-5 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-800 dark:text-white">Subscriber Sekolah Terbaru</h2>
                        <p class="text-xs text-slate-400">Pendaftaran dan langganan terkini dari sekolah mitra</p>
                    </div>
                </div>

                <a
                    href="{{ route('admin-platform.schools.index') }}"
                    class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400"
                >
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

            @if ($recentSubscriptions->isEmpty())
                <div class="p-8 text-center">
                    <p class="text-sm text-slate-400">Belum ada data sekolah terdaftar.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3">Sekolah</th>
                                <th class="px-5 py-3">Paket</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($recentSubscriptions as $sub)
                                <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                    <td class="px-5 py-3.5">
                                        <div class="font-bold text-slate-800 dark:text-white">{{ $sub->school_name }}</div>
                                        <div class="text-xs text-slate-400">{{ $sub->school_email ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="font-medium text-slate-700 dark:text-slate-200">{{ $sub->package->name ?? '-' }}</span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if ($sub->status === 'active')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @elseif ($sub->status === 'pending')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                Menunggu
                                            </span>
                                        @elseif ($sub->status === 'rejected')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-400">
                                                {{ ucfirst($sub->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a
                                            href="{{ route('admin-platform.schools.show', $sub->id) }}"
                                            class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
                                        >
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

        {{-- MENU CEPAT --}}
        <div class="space-y-4">
            <h3 class="font-bold text-slate-800 dark:text-white">Akses Cepat Pengelolaan</h3>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1">

                <a
                    href="{{ route('admin-platform.packages.index') }}"
                    class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-500 hover:shadow-md dark:border-slate-800 dark:bg-slate-900"
                >
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/10 dark:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 transition group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400">Kelola Paket</div>
                            <div class="text-xs text-slate-400">Atur paket langganan dan harga</div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>

                <a
                    href="{{ route('admin-platform.payments.index') }}"
                    class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-emerald-500 hover:shadow-md dark:border-slate-800 dark:bg-slate-900"
                >
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white dark:bg-emerald-500/10 dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 2.25 19.5Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 transition group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">Riwayat Pembayaran</div>
                            <div class="text-xs text-slate-400">Verifikasi bukti bayar sekolah</div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>

                <a
                    href="{{ route('admin-platform.users.index') }}"
                    class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-indigo-500 hover:shadow-md dark:border-slate-800 dark:bg-slate-900"
                >
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white dark:bg-indigo-500/10 dark:text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 transition group-hover:text-indigo-600 dark:text-white dark:group-hover:text-indigo-400">Kelola Pengguna</div>
                            <div class="text-xs text-slate-400">Daftar user dan manajemen role</div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>

                <a
                    href="{{ route('admin-platform.reports.index') }}"
                    class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-purple-500 hover:shadow-md dark:border-slate-800 dark:bg-slate-900"
                >
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600 transition group-hover:bg-purple-600 group-hover:text-white dark:bg-purple-500/10 dark:text-purple-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 transition group-hover:text-purple-600 dark:text-white dark:group-hover:text-purple-400">Laporan Platform</div>
                            <div class="text-xs text-slate-400">Statistik dan analisis performa</div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>

            </div>
        </div>

    </div>

    {{-- LOG AKTIVITAS TERBARU --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex items-center justify-between border-b border-slate-100 p-5 dark:border-slate-800">
            <div class="flex items-center gap-2.5">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-slate-800 dark:text-white">Audit Log Aktivitas Terkini</h2>
                    <p class="text-xs text-slate-400">Catatan aktivitas penting dan perubahan sistem</p>
                </div>
            </div>

            <a
                href="{{ route('admin-platform.logs.index') }}"
                class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400"
            >
                Lihat Seluruh Log
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>

        @if ($recentLogs->isEmpty())
            <div class="p-8 text-center">
                <p class="text-sm text-slate-400">Belum ada aktivitas yang dicatat.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach ($recentLogs as $log)
                    <div class="flex items-start justify-between gap-4 p-4 hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                @if (str_contains($log->action, 'subscription') || str_contains($log->action, 'approve'))
                                    <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                @elseif (str_contains($log->action, 'login'))
                                    <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                @else
                                    <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $log->description }}</p>
                                <div class="mt-0.5 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                                    <span>Oleh: <strong class="text-slate-600 dark:text-slate-300">{{ $log->user->name ?? 'Sistem' }}</strong></span>
                                    @if ($log->ip_address)
                                        <span>&bull;</span>
                                        <span>IP: {{ $log->ip_address }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="shrink-0 text-xs font-medium text-slate-400">
                            {{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-layouts.app>