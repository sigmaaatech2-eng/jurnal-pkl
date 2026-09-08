<x-layouts.app title="Detail Siswa – {{ $internship->student->name }}">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Monitoring Siswa
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Detail informasi dan riwayat jurnal siswa bimbingan PKL.
                    </p>
                </div>
            </div>
        </div>

        <a
            href="{{ route('guru-pembimbing.students.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
        >
            <span>← Kembali ke Siswa Bimbingan</span>
        </a>
    </div>


    {{-- INFORMASI SISWA & PKL --}}
    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Informasi Siswa --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Informasi Siswa
                </h2>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-xl font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                        {{ strtoupper(substr($internship->student->name ?? 'S', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-lg font-bold text-slate-800 dark:text-white">
                            {{ $internship->student->name }}
                        </div>
                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            {{ $internship->student->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informasi PKL --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Informasi PKL
                </h2>
            </div>
            <div class="divide-y divide-slate-100 px-6 dark:divide-slate-800">
                <div class="flex items-center justify-between py-3.5">
                    <span class="text-sm text-slate-500 dark:text-slate-400">Tempat PKL</span>
                    <span class="text-sm font-semibold text-slate-800 dark:text-white">{{ $internship->company_name }}</span>
                </div>
                <div class="flex items-center justify-between py-3.5">
                    <span class="text-sm text-slate-500 dark:text-slate-400">Status PKL</span>
                    <span>
                        @if ($internship->status === 'active')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Aktif
                            </span>
                        @elseif ($internship->status === 'completed')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                {{ ucfirst($internship->status) }}
                            </span>
                        @endif
                    </span>
                </div>
                @if ($internship->start_date && $internship->end_date)
                    <div class="flex items-center justify-between py-3.5">
                        <span class="text-sm text-slate-500 dark:text-slate-400">Periode</span>
                        <span class="text-sm font-semibold text-slate-800 dark:text-white">
                            {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}
                            –
                            {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- STATISTIK JURNAL --}}
    <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Jurnal</p>
            <p class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">{{ $totalJournals }}</p>
        </div>

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">Pending</p>
            <p class="mt-2 text-3xl font-bold text-amber-700 dark:text-amber-300">{{ $pendingJournals }}</p>
        </div>

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Disetujui</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $approvedJournals }}</p>
        </div>

        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">Perlu Revisi</p>
            <p class="mt-2 text-3xl font-bold text-rose-700 dark:text-rose-300">{{ $rejectedJournals }}</p>
        </div>

    </div>


    {{-- RIWAYAT JURNAL --}}
    <div class="mb-2 flex items-center gap-2">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
        </div>
        <h2 class="text-base font-bold text-slate-800 dark:text-white">Riwayat Jurnal</h2>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($journals->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200">Belum Ada Jurnal</h3>
                <p class="mt-1 text-sm text-slate-400">Siswa belum memiliki riwayat jurnal kegiatan PKL.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Judul Kegiatan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($journals as $journal)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-800 dark:text-slate-100">
                                    {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-slate-700 dark:text-slate-200">
                                    {{ $journal->title }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($journal->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @elseif ($journal->status === 'approved')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Disetujui
                                        </span>
                                    @elseif ($journal->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Perlu Revisi
                                        </span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('guru-pembimbing.journals.show', $journal) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-700"
                                    >
                                        <span>Lihat Jurnal</span>
                                        <span class="text-slate-400">→</span>
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