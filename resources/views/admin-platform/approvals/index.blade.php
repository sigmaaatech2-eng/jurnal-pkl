<x-layouts.app :title="'Persetujuan Langganan - Admin Platform'">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Persetujuan Langganan</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Persetujuan Langganan
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Verifikasi dan setujui atau tolak pengajuan langganan dari instansi sekolah.
            </p>
        </div>

        <div class="flex items-center gap-3">
            @if (($approvalCounts['pending'] ?? 0) > 0)
                <span class="inline-flex items-center gap-2 rounded-xl bg-amber-100 px-4 py-2 text-xs font-bold text-amber-800 dark:bg-amber-500/10 dark:text-amber-300">
                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $approvalCounts['pending'] }} Menunggu Persetujuan
                </span>
            @endif
        </div>
    </div>

    {{-- FLASH ALERT --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- SUMMARY CARDS --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
        {{-- Menunggu --}}
        <div class="rounded-2xl border border-amber-200 bg-amber-50/60 p-5 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/5">
            <div class="text-xs font-semibold text-amber-600 dark:text-amber-400">Menunggu Persetujuan</div>
            <div class="mt-2 text-3xl font-extrabold text-slate-800 dark:text-white">{{ $approvalCounts['pending'] ?? 0 }}</div>
            <div class="mt-1 text-xs text-slate-400">pengajuan perlu ditinjau</div>
        </div>

        {{-- Disetujui --}}
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/60 p-5 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/5">
            <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Total Disetujui</div>
            <div class="mt-2 text-3xl font-extrabold text-slate-800 dark:text-white">{{ $approvalCounts['approved'] ?? 0 }}</div>
            <div class="mt-1 text-xs text-slate-400">sekolah aktif berlangganan</div>
        </div>

        {{-- Ditolak --}}
        <div class="rounded-2xl border border-rose-200 bg-rose-50/60 p-5 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/5">
            <div class="text-xs font-semibold text-rose-600 dark:text-rose-400">Total Ditolak</div>
            <div class="mt-2 text-3xl font-extrabold text-slate-800 dark:text-white">{{ $approvalCounts['rejected'] ?? 0 }}</div>
            <div class="mt-1 text-xs text-slate-400">pengajuan ditolak</div>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <form method="GET" action="{{ route('admin-platform.approvals.index') }}" class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="relative w-full lg:max-w-md">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari berdasarkan nama sekolah yang mengajukan..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500"
            >
        </div>

        <div class="flex items-center gap-2">
            @if (request('search'))
                <a
                    href="{{ route('admin-platform.approvals.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-600 shadow-sm hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    <span>Reset</span>
                </a>
            @endif
            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 active:scale-95 transition">
                Cari Pengajuan
            </button>
        </div>
    </form>

    {{-- LIST PENGAJUAN --}}
    <div class="space-y-4">
        @forelse ($pendingSubscriptions as $sub)
            <div class="rounded-2xl border border-amber-200/80 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-amber-500/20 dark:bg-slate-900">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-100 font-extrabold text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">
                            {{ strtoupper(substr($sub->school_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base font-bold text-slate-800 dark:text-white">{{ $sub->school_name }}</h3>
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                    Menunggu Persetujuan
                                </span>
                            </div>

                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                {{ $sub->school_email ?? 'Tidak ada email' }}
                                @if ($sub->school_phone) &bull; {{ $sub->school_phone }} @endif
                            </p>

                            <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-slate-400">
                                <span>Paket Diajukan: <strong class="text-indigo-600 dark:text-indigo-400">{{ $sub->package->name ?? 'Belum Dipilih' }}</strong></span>
                                <span>&bull;</span>
                                <span>Admin Pendaftar: <strong class="text-slate-600 dark:text-slate-300">{{ $sub->adminUser->name ?? '—' }}</strong></span>
                                <span>&bull;</span>
                                <span>Waktu Pengajuan: {{ $sub->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <a
                            href="{{ route('admin-platform.approvals.show', $sub->id) }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-blue-500/20 transition hover:bg-blue-700 active:scale-95"
                        >
                            <span>Tinjau &amp; Proses</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-16 text-center shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Semua Pengajuan Telah Diproses</h3>
                <p class="mt-1 text-sm text-slate-400">Tidak ada pengajuan langganan sekolah yang menunggu persetujuan saat ini.</p>
            </div>
        @endforelse
    </div>

    @if ($pendingSubscriptions->hasPages())
        <div class="mt-6">
            {{ $pendingSubscriptions->links() }}
        </div>
    @endif

</x-layouts.app>
