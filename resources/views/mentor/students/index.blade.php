<x-layouts.app title="Daftar Siswa">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Daftar Siswa</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Kelola dan pantau perkembangan jurnal seluruh siswa bimbingan Anda.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <form method="GET" action="{{ route('mentor.students.index') }}" class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
            </svg>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama siswa..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
            >
        </div>

        <div class="flex gap-2">
            @foreach(['all' => 'Semua', 'active' => 'Aktif', 'completed' => 'Selesai'] as $value => $label)
                <a
                    href="{{ route('mentor.students.index', array_merge(request()->query(), ['status' => $value])) }}"
                    class="rounded-xl px-4 py-2.5 text-sm font-semibold transition
                    {{ (request('status', 'all') === $value)
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20'
                        : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </form>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($internships->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200">Tidak Ada Data Siswa</h3>
                <p class="mt-1 text-sm text-slate-400">Coba ubah filter atau kata kunci pencarian.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Nama Siswa</th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Total Jurnal</th>
                            <th class="px-6 py-4">Menunggu Validasi</th>
                            <th class="px-6 py-4">Progress</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($internships as $internship)
                            @php
                                $total    = $internship->journals->count();
                                $approved = $internship->journals->where('status', 'approved')->count();
                                $pending  = $internship->journals->where('status', 'pending')->count();
                                $progress = $total > 0 ? min(100, round(($approved / $total) * 100)) : 0;
                            @endphp
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                            {{ strtoupper(substr($internship->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">{{ $internship->student->name ?? '-' }}</div>
                                            <div class="text-xs text-slate-400">{{ $internship->student->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-700 dark:text-slate-200">{{ $internship->company_name }}</div>
                                    <div class="text-xs text-slate-400">{{ Str::limit($internship->company_address, 35) }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-800 dark:text-slate-100">
                                    {{ $total }} Jurnal
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($pending > 0)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            {{ $pending }} Menunggu
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-28 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                            <div class="h-full rounded-full bg-blue-500" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $approved }}/{{ $total }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($internship->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                            {{ ucfirst($internship->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('mentor.students.show', $internship) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                                    >
                                        Lihat Jurnal →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</x-layouts.app>
