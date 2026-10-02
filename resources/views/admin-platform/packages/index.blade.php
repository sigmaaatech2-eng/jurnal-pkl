<x-layouts.app :title="'Kelola Paket Langganan - Admin Platform'">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Kelola Paket</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Kelola Paket Langganan
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Atur paket langganan sekolah, batasan kuota pengguna, harga, dan fitur platform.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin-platform.packages.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Paket Baru</span>
            </a>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="text-xs font-semibold text-slate-400 dark:text-slate-500">Total Paket</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $packageCounts['total'] ?? 0 }}</div>
        </div>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/60 p-4 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/5">
            <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Paket Aktif</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $packageCounts['active'] ?? 0 }}</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">Nonaktif</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $packageCounts['inactive'] ?? 0 }}</div>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50/60 p-4 shadow-sm dark:border-blue-500/20 dark:bg-blue-500/5">
            <div class="text-xs font-semibold text-blue-600 dark:text-blue-400">Total Pelanggan</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $packageCounts['total_subscribers'] ?? 0 }}</div>
        </div>
    </div>

    {{-- FLASH ALERT --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- GRID PAKET --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($packages as $package)
            <div class="relative flex flex-col justify-between rounded-2xl border {{ $package->is_active ? 'border-slate-200 bg-white shadow-sm hover:shadow-md dark:border-slate-800 dark:bg-slate-900' : 'border-slate-200/60 bg-slate-50/60 opacity-70 dark:border-slate-800/60 dark:bg-slate-900/50' }} p-6 transition">

                {{-- TOP HEADER & BADGE --}}
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $package->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-slate-200 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $package->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            {{ $package->is_active ? 'Paket Aktif' : 'Nonaktif' }}
                        </span>

                        <span class="text-xs font-medium text-slate-400">
                            {{ $package->subscriptions_count }} sekolah pelanggan
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">
                        {{ $package->name }}
                    </h3>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 min-h-[32px]">
                        {{ $package->description ?? 'Paket langganan platform PKL online untuk sekolah.' }}
                    </p>

                    {{-- HARGA --}}
                    <div class="my-4 rounded-xl border border-slate-100 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-blue-600 dark:text-blue-400">
                                {{ $package->price_formatted }}
                            </span>
                            <span class="text-xs text-slate-400">
                                / {{ $package->duration_months }} bulan
                            </span>
                        </div>
                    </div>

                    {{-- KUOTA LIMITS --}}
                    <div class="space-y-2 text-xs border-b border-slate-100 pb-4 dark:border-slate-800">
                        <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                            <span class="text-slate-400">Kapasitas Siswa PKL</span>
                            <strong class="font-bold text-slate-800 dark:text-white">{{ $package->max_students }} Siswa</strong>
                        </div>
                        <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                            <span class="text-slate-400">Kapasitas Guru Pembimbing</span>
                            <strong class="font-bold text-slate-800 dark:text-white">{{ $package->max_teachers }} Guru</strong>
                        </div>
                        <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                            <span class="text-slate-400">Kapasitas Mentor Industri</span>
                            <strong class="font-bold text-slate-800 dark:text-white">{{ $package->max_mentors }} Mentor</strong>
                        </div>
                    </div>

                    {{-- LIST FITUR --}}
                    @if (!empty($package->features))
                        <div class="mt-4 space-y-2">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Fitur yang Termasuk:</p>
                            <ul class="space-y-1.5 text-xs text-slate-600 dark:text-slate-300">
                                @foreach ($package->features as $feature)
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="mt-6 flex items-center gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <a
                        href="{{ route('admin-platform.packages.edit', $package->id) }}"
                        class="flex-1 text-center rounded-xl border border-slate-200 bg-white py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
                    >
                        Edit Paket
                    </a>

                    <form method="POST" action="{{ route('admin-platform.packages.toggle', $package->id) }}" class="flex-1">
                        @csrf
                        <button
                            type="submit"
                            class="w-full rounded-xl py-2 text-xs font-bold transition shadow-sm {{ $package->is_active ? 'border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 dark:border-amber-900/40 dark:bg-amber-950/40 dark:text-amber-300' : 'border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-300' }}"
                        >
                            {{ $package->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Belum Ada Paket Langganan</h3>
                <p class="mt-1 text-sm text-slate-400">Klik tombol "Tambah Paket Baru" untuk membuat paket pertama.</p>
            </div>
        @endforelse
    </div>

</x-layouts.app>
