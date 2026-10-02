<x-layouts.app title="Subscriber Sekolah">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Subscriber Sekolah</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Subscriber Sekolah
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Kelola data seluruh institusi sekolah yang berlangganan platform PKL Online.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin-platform.schools.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-700 active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Sekolah & Admin</span>
            </a>
            <a
                href="{{ route('admin-platform.approvals.index') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Persetujuan Langganan</span>
                @if (($statusCounts['pending'] ?? 0) > 0)
                    <span class="ml-1 rounded-full bg-white px-2 py-0.5 text-xs font-bold text-blue-700">{{ $statusCounts['pending'] }}</span>
                @endif
            </a>
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

    {{-- STATS CARDS RINGKASAN STATUS --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
        {{-- Card Semua --}}
        <a
            href="{{ route('admin-platform.schools.index') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') == null || request('status') === '' ? 'ring-2 ring-blue-500/30 dark:border-blue-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-slate-400 dark:text-slate-500">Semua Sekolah</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $statusCounts['all'] ?? 0 }}
            </div>
        </a>

        {{-- Card Aktif --}}
        <a
            href="{{ route('admin-platform.schools.index', ['status' => 'active']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-emerald-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') === 'active' ? 'ring-2 ring-emerald-500/30 dark:border-emerald-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Langganan Aktif</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $statusCounts['active'] ?? 0 }}
            </div>
        </a>

        {{-- Card Menunggu --}}
        <a
            href="{{ route('admin-platform.schools.index', ['status' => 'pending']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-amber-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') === 'pending' ? 'ring-2 ring-amber-500/30 dark:border-amber-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-amber-600 dark:text-amber-400">Menunggu Verifikasi</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $statusCounts['pending'] ?? 0 }}
            </div>
        </a>

        {{-- Card Ditolak --}}
        <a
            href="{{ route('admin-platform.schools.index', ['status' => 'rejected']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-rose-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') === 'rejected' ? 'ring-2 ring-rose-500/30 dark:border-rose-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-rose-600 dark:text-rose-400">Pengajuan Ditolak</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $statusCounts['rejected'] ?? 0 }}
            </div>
        </a>

        {{-- Card Expired --}}
        <a
            href="{{ route('admin-platform.schools.index', ['status' => 'expired']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-slate-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') === 'expired' ? 'ring-2 ring-slate-500/30 dark:border-slate-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">Kedaluwarsa</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $statusCounts['expired'] ?? 0 }}
            </div>
        </a>
    </div>

    {{-- FILTER & SEARCH --}}
    <form method="GET" action="{{ route('admin-platform.schools.index') }}" class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        @if (request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif

        {{-- SEARCH INPUT --}}
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
                placeholder="Cari berdasarkan nama atau email sekolah..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500"
            >
        </div>

        <div class="flex items-center gap-2">
            @if (request()->hasAny(['search', 'status']))
                <a
                    href="{{ route('admin-platform.schools.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-600 shadow-sm hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    <span>Reset Filter</span>
                </a>
            @endif
            <button
                type="submit"
                class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 active:scale-95 transition"
            >
                Cari Sekolah
            </button>
        </div>
    </form>

    {{-- TABEL DATA SEKOLAH --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($schools->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Tidak Ada Data Sekolah</h3>
                <p class="mt-1 text-sm text-slate-400">Tidak ada sekolah yang sesuai dengan filter atau kata kunci pencarian Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Nama Sekolah</th>
                            <th class="px-6 py-4">Paket Langganan</th>
                            <th class="px-6 py-4">Tanggal Mulai</th>
                            <th class="px-6 py-4">Tanggal Berakhir</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($schools as $school)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Sekolah --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                            {{ strtoupper(substr($school->school_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">{{ $school->school_name }}</div>
                                            <div class="text-xs text-slate-400">{{ $school->school_email ?? '-' }}</div>
                                            @if ($school->school_phone)
                                                <div class="text-[11px] text-slate-400">{{ $school->school_phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Paket --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($school->package)
                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                            {{ $school->package->name }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>

                                {{-- Tanggal Mulai --}}
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $school->start_date ? $school->start_date->translatedFormat('d M Y') : '—' }}
                                </td>

                                {{-- Tanggal Berakhir --}}
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $school->end_date ? $school->end_date->translatedFormat('d M Y') : '—' }}
                                </td>

                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($school->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @elseif ($school->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu
                                        </span>
                                    @elseif ($school->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Ditolak
                                        </span>
                                    @elseif ($school->status === 'expired')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Kedaluwarsa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                            {{ ucfirst($school->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('admin-platform.schools.show', $school->id) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-400 hover:bg-blue-50/50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-blue-500/50 dark:hover:text-blue-400 active:scale-95"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($schools->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $schools->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>
