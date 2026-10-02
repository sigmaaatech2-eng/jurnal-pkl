<x-layouts.app title="Monitoring Absensi Siswa">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Monitoring Absensi Siswa
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Pantau riwayat dan status presensi harian seluruh siswa bimbingan PKL Anda.
                    </p>
                </div>
            </div>
        </div>

        <a
            href="{{ route('guru-pembimbing.dashboard') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
        >
            <span>← Kembali ke Dashboard</span>
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($attendances->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200">Belum Ada Rekam Presensi</h3>
                <p class="mt-1 text-sm text-slate-400">Siswa bimbingan belum melakukan absensi kehadiran.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Check In</th>
                            <th class="px-6 py-4">Check Out</th>
                            <th class="px-6 py-4">Ket. Waktu</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($attendances as $attendance)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-800 dark:text-slate-100">
                                    {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-white">
                                        {{ $attendance->student->name ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $attendance->student->email ?? '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $attendance->internship->company_name ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($attendance->check_in)
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ substr($attendance->check_in, 0, 5) }} WIB
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($attendance->check_out)
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ substr($attendance->check_out, 0, 5) }} WIB
                                        </span>
                                    @else
                                        <span class="text-xs text-amber-600 dark:text-amber-400">Belum check-out</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($attendance->late_status === 'tepat_waktu')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Tepat Waktu
                                        </span>
                                    @elseif ($attendance->late_status === 'terlambat')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-xs">
                                    <div class="flex flex-col gap-1">
                                        @if ($attendance->check_in_lat && $attendance->check_in_lng)
                                            <a
                                                href="https://www.google.com/maps?q={{ $attendance->check_in_lat }},{{ $attendance->check_in_lng }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center gap-1 text-blue-600 hover:underline dark:text-blue-400"
                                            >
                                                📍 Masuk (Maps)
                                            </a>
                                        @endif
                                        @if ($attendance->check_out_lat && $attendance->check_out_lng)
                                            <a
                                                href="https://www.google.com/maps?q={{ $attendance->check_out_lat }},{{ $attendance->check_out_lng }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center gap-1 text-violet-600 hover:underline dark:text-violet-400"
                                            >
                                                📍 Pulang (Maps)
                                            </a>
                                        @endif
                                        @if (!$attendance->check_in_lat && !$attendance->check_out_lat)
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Hadir
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($attendances->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $attendances->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>
