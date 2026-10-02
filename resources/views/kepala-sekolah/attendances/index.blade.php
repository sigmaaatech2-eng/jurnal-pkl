<x-layouts.app title="Monitoring Absensi Siswa">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Monitoring Kehadiran Siswa PKL
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Rekapitulasi kehadiran dan catatan presensi siswa PKL harian secara terpusat (Read-Only).
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" action="{{ route('kepala-sekolah.attendances.index') }}" class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama siswa..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500"
                >
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Filter Tanggal --}}
                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                >

                {{-- Filter Status --}}
                <select
                    name="status"
                    class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                >
                    <option value="">Semua Status Kehadiran</option>
                    <option value="present" {{ request('status') === 'present' ? 'selected' : '' }}>Hadir</option>
                    <option value="sick" {{ request('status') === 'sick' ? 'selected' : '' }}>Sakit</option>
                    <option value="permission" {{ request('status') === 'permission' ? 'selected' : '' }}>Izin</option>
                    <option value="absent" {{ request('status') === 'absent' ? 'selected' : '' }}>Alpa</option>
                </select>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-violet-700 active:scale-95"
                >
                    Filter
                </button>

                @if (request()->hasAny(['search', 'date', 'status']))
                    <a
                        href="{{ route('kepala-sekolah.attendances.index') }}"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABEL PRESENSI SISWA --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($attendances->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200">Tidak Ada Rekam Kehadiran</h3>
                <p class="mt-1 text-sm text-slate-400">Belum ada data presensi yang sesuai dengan kriteria filter.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Nama Siswa</th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Check-In</th>
                            <th class="px-6 py-4">Check-Out</th>
                            <th class="px-6 py-4">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($attendances as $attendance)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Nama Siswa --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-violet-100 font-bold text-violet-600 dark:bg-violet-500/20 dark:text-violet-400">
                                            {{ strtoupper(substr($attendance->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">
                                                {{ $attendance->student->name ?? '-' }}
                                            </div>
                                            <div class="text-xs text-slate-400">
                                                {{ $attendance->student->email ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Tempat PKL --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">
                                        {{ $attendance->internship->company_name ?? '-' }}
                                    </span>
                                </td>

                                {{-- Tanggal --}}
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-700 dark:text-slate-200">
                                    {{ $attendance->date ? $attendance->date->format('d M Y') : '-' }}
                                </td>

                                {{-- Check-In --}}
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-xs text-slate-600 dark:text-slate-300">
                                    @if ($attendance->check_in)
                                        <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            {{ $attendance->check_in }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>

                                {{-- Check-Out --}}
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-xs text-slate-600 dark:text-slate-300">
                                    @if ($attendance->check_out)
                                        <span class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                            {{ $attendance->check_out }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>

                                {{-- Status Kehadiran --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $attColor = match($attendance->status) {
                                            'present', 'hadir' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                            'sick', 'sakit'    => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                                            'permission', 'izin'=> 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                            default             => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300',
                                        };
                                        $attLabel = match($attendance->status) {
                                            'present', 'hadir' => 'Hadir',
                                            'sick', 'sakit'    => 'Sakit',
                                            'permission', 'izin'=> 'Izin',
                                            default             => ucfirst($attendance->status ?? 'Alpa'),
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $attColor }}">
                                        {{ $attLabel }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($attendances->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $attendances->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>
