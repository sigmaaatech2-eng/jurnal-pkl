<x-layouts.app title="Data Penempatan PKL">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Penempatan PKL Siswa
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Kelola data penempatan siswa, instansi mitra, guru pembimbing, dan mentor lapangan.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin-sekolah.internships.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700 active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Penempatan PKL</span>
            </a>
        </div>
    </div>

    {{-- SUCCESS ALERT --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- FILTER & SEARCH --}}
    <form method="GET" action="{{ route('admin-sekolah.internships.index') }}" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
            </svg>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama siswa atau nama perusahaan PKL..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
            >
        </div>

        <div class="flex flex-wrap gap-2">
            @php
                $statusTabs = [
                    'all'       => ['label' => 'Semua', 'count' => $totalCount],
                    'active'    => ['label' => 'Aktif', 'count' => $activeCount],
                    'completed' => ['label' => 'Selesai', 'count' => $completedCount],
                    'cancelled' => ['label' => 'Dibatalkan', 'count' => $cancelledCount],
                ];
            @endphp

            @foreach ($statusTabs as $k => $tab)
                <a
                    href="{{ route('admin-sekolah.internships.index', array_merge(request()->query(), ['status' => $k])) }}"
                    class="rounded-xl px-3.5 py-2 text-xs font-semibold transition
                    {{ (request('status', 'all') === $k)
                        ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20'
                        : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    {{ $tab['label'] }} ({{ $tab['count'] }})
                </a>
            @endforeach
        </div>
    </form>

    {{-- TABEL DATA PKL --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($internships->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Belum Ada Data Penempatan PKL</h3>
                <p class="mt-1 text-sm text-slate-400">Silakan tambahkan data penempatan siswa menggunakan tombol di atas.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Guru Pembimbing</th>
                            <th class="px-6 py-4">Mentor DUDI</th>
                            <th class="px-6 py-4">Periode</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($internships as $item)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Siswa --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                            {{ strtoupper(substr($item->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">
                                                {{ $item->student->name ?? '-' }}
                                            </div>
                                            <div class="text-xs text-slate-400">
                                                {{ $item->student->email ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Tempat PKL --}}
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $item->company_name }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ Str::limit($item->company_address, 32) }}
                                    </div>
                                </td>

                                {{-- Guru Pembimbing --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($item->teacher)
                                        <div class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ $item->teacher->name }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>

                                {{-- Mentor DUDI --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($item->mentor)
                                        <div class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ $item->mentor->name }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>

                                {{-- Periode PKL --}}
                                <td class="whitespace-nowrap px-6 py-4 text-xs">
                                    <div class="font-medium text-slate-700 dark:text-slate-300">
                                        {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}
                                    </div>
                                    <div class="text-slate-400">
                                        s/d {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($item->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @elseif ($item->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    @if ($item->student)
                                        <a
                                            href="{{ route('admin-sekolah.students.show', $item->student) }}"
                                            class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                                        >
                                            <span>Detail Siswa</span>
                                            <span>→</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($internships->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $internships->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>