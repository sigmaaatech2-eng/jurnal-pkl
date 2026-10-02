<x-layouts.app title="Dashboard Mentor">

    {{-- HEADER SELAMAT DATANG --}}
    <div class="mb-8">
        <div class="rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-600 to-indigo-700 p-6 text-white shadow-lg dark:border-blue-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-200">Selamat datang</p>
                    <h1 class="mt-1 text-2xl font-bold">{{ $mentor->name }}</h1>
                    <p class="mt-1 text-sm text-blue-200">Pantau aktivitas dan perkembangan jurnal siswa PKL Anda.</p>
                </div>
                <div class="hidden sm:flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 text-3xl font-bold">
                    {{ strtoupper(substr($mentor->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK 4 CARD --}}
    <div class="mb-8 grid grid-cols-2 gap-4 md:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Siswa</p>
            <p class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">{{ $totalStudents }}</p>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">Menunggu Validasi</p>
            <p class="mt-2 text-3xl font-bold text-amber-700 dark:text-amber-300">{{ $waitingValidation }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Sudah Divalidasi</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $validated }}</p>
        </div>
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm dark:border-red-500/20 dark:bg-red-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-red-600 dark:text-red-400">Perlu Revisi</p>
            <p class="mt-2 text-3xl font-bold text-red-700 dark:text-red-300">{{ $needRevision }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- JURNAL TERBARU --}}
        <div class="xl:col-span-2">
            <div class="mb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-800 dark:text-white">Jurnal Terbaru</h2>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                @if ($recentJournals->isEmpty())
                    <div class="py-14 text-center">
                        <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <p class="font-semibold text-slate-700 dark:text-slate-200">Belum Ada Jurnal</p>
                        <p class="mt-1 text-sm text-slate-400">Belum ada jurnal yang dikirimkan siswa.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                            <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                                <tr>
                                    <th class="px-5 py-4">Siswa</th>
                                    <th class="px-5 py-4">Tanggal</th>
                                    <th class="px-5 py-4">Kegiatan</th>
                                    <th class="px-5 py-4">Status</th>
                                    <th class="px-5 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($recentJournals as $journal)
                                    <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                        <td class="whitespace-nowrap px-5 py-3.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                                    {{ strtoupper(substr($journal->student->name ?? 'S', 0, 1)) }}
                                                </div>
                                                <span class="font-medium text-slate-800 dark:text-white">{{ $journal->student->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-3.5 text-xs text-slate-500 dark:text-slate-400">
                                            {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-5 py-3.5 max-w-[200px]">
                                            <p class="truncate">{{ $journal->title }}</p>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-3.5">
                                            @if ($journal->status === 'pending')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                    Menunggu Validasi
                                                </span>
                                            @elseif ($journal->status === 'approved')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Valid
                                                </span>
                                            @elseif ($journal->status === 'rejected')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                    Perlu Revisi
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-3.5 text-right">
                                            <a
                                                href="{{ route('mentor.journals.show', $journal) }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                                            >
                                                Lihat Detail →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- SISWA BIMBINGAN --}}
        <div>
            <div class="mb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-800 dark:text-white">Siswa Bimbingan</h2>
                </div>
                <a href="{{ route('mentor.students.index') }}" class="text-xs font-semibold text-blue-600 hover:underline dark:text-blue-400">Lihat Semua →</a>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                @if ($recentStudents->isEmpty())
                    <div class="py-12 text-center">
                        <p class="text-sm text-slate-400">Belum ada siswa bimbingan.</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($recentStudents as $item)
                            <a href="{{ route('mentor.students.show', $item->internship) }}" class="block px-5 py-4 transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                        {{ strtoupper(substr($item->student->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="truncate font-semibold text-slate-800 dark:text-white">{{ $item->student->name ?? '-' }}</div>
                                        <div class="truncate text-xs text-slate-400">{{ $item->company_name }}</div>
                                        <div class="mt-1.5">
                                            <div class="mb-1 flex items-center justify-between text-xs">
                                                <span class="text-slate-500 dark:text-slate-400">Progress Jurnal</span>
                                                <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $item->progress }}%</span>
                                            </div>
                                            <div class="h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                                <div class="h-full rounded-full bg-blue-500 transition-all" style="width: {{ $item->progress }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>

</x-layouts.app>