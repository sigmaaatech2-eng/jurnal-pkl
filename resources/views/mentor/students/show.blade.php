<x-layouts.app title="Jurnal Siswa – {{ $internship->student->name }}">

    {{-- HEADER & BREADCRUMB --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('mentor.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Mentor</a>
                <span>/</span>
                <a href="{{ route('mentor.students.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Daftar Siswa</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Jurnal Siswa</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Jurnal Siswa: {{ $internship->student->name }}
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Pantau dan validasi seluruh aktivitas jurnal harian siswa PKL Anda.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('mentor.students.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Daftar Siswa</span>
            </a>
        </div>
    </div>

    {{-- INFORMASI SISWA & PKL --}}
    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
        {{-- Card Profil Siswa --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-2xl font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                    {{ strtoupper(substr($internship->student->name ?? 'S', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <span class="inline-block rounded-md bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">Siswa Bimbingan</span>
                    <h2 class="mt-1 truncate text-lg font-bold text-slate-800 dark:text-white">
                        {{ $internship->student->name }}
                    </h2>
                    <p class="truncate text-sm text-slate-500 dark:text-slate-400">
                        {{ $internship->student->email }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Card Informasi Penempatan PKL --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-start justify-between">
                <div>
                    <span class="inline-block rounded-md bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">Tempat PKL</span>
                    <h3 class="mt-1 text-lg font-bold text-slate-800 dark:text-white">
                        {{ $internship->company_name }}
                    </h3>
                    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                        {{ $internship->company_address ?? 'Alamat belum diatur' }}
                    </p>
                </div>
                <div>
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
                </div>
            </div>
            @if ($internship->start_date && $internship->end_date)
                <div class="mt-3 flex items-center gap-2 border-t border-slate-100 pt-3 text-xs text-slate-400 dark:border-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Periode: {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</span>
                </div>
            @endif
        </div>
    </div>

    {{-- 4 STAT CARD --}}
    <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Jurnal</p>
            <p class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">{{ $totalJournals }}</p>
        </div>

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">Menunggu Validasi</p>
            <p class="mt-2 text-3xl font-bold text-amber-700 dark:text-amber-300">{{ $pendingJournals }}</p>
        </div>

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Valid</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $approvedJournals }}</p>
        </div>

        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm dark:border-red-500/20 dark:bg-red-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-red-600 dark:text-red-400">Perlu Revisi</p>
            <p class="mt-2 text-3xl font-bold text-red-700 dark:text-red-300">{{ $rejectedJournals }}</p>
        </div>
    </div>

    {{-- FILTER & SEARCH JURNAL --}}
    <form method="GET" action="{{ route('mentor.students.show', $internship) }}" class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
            </svg>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari kegiatan atau judul jurnal..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
            >
        </div>

        <div class="flex flex-wrap gap-2">
            @php
                $statusTabs = [
                    'all'      => 'Semua',
                    'pending'  => 'Menunggu Validasi',
                    'approved' => 'Valid',
                    'rejected' => 'Perlu Revisi',
                ];
            @endphp
            @foreach($statusTabs as $value => $label)
                <a
                    href="{{ route('mentor.students.show', [$internship, 'status' => $value, 'search' => request('search')]) }}"
                    class="rounded-xl px-3.5 py-2 text-xs font-semibold transition
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

    {{-- TABEL RIWAYAT JURNAL --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($journals->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200">Tidak Ada Jurnal Ditemukan</h3>
                <p class="mt-1 text-sm text-slate-400">Belum ada jurnal yang sesuai dengan filter atau kata kunci saat ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Kegiatan</th>
                            <th class="px-6 py-4">Dokumentasi</th>
                            <th class="px-6 py-4">Nilai / Rating</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($journals as $journal)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-white">
                                        {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('l') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="max-w-[280px]">
                                        <p class="font-bold text-slate-800 dark:text-white line-clamp-1">
                                            {{ $journal->title }}
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-0.5">
                                            {{ Str::limit($journal->description, 90) }}
                                        </p>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($journal->attachment)
                                        <div class="flex items-center gap-2">
                                            <div class="h-10 w-10 overflow-hidden rounded-lg border border-slate-200 bg-slate-100 dark:border-slate-700">
                                                <img
                                                    src="{{ asset('storage/' . $journal->attachment) }}"
                                                    alt="Lampiran"
                                                    class="h-full w-full object-cover"
                                                    onerror="this.parentElement.innerHTML='<span class=\'flex h-full w-full items-center justify-center text-xs text-slate-400\'>Foto</span>'"
                                                >
                                            </div>
                                            <span class="text-xs font-medium text-blue-600 dark:text-blue-400">Ada Foto</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    @if (!is_null($journal->mentor_score))
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 font-bold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                                                {{ $journal->mentor_score }}
                                            </span>
                                            @if ($journal->mentor_rating)
                                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                                    ({{ str_replace('_', ' ', ucfirst($journal->mentor_rating)) }})
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400">Belum Dinilai</span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($journal->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu Validasi
                                        </span>
                                    @elseif ($journal->status === 'approved')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Valid
                                        </span>
                                    @elseif ($journal->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                            Perlu Revisi
                                        </span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('mentor.journals.show', $journal) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                                    >
                                        Periksa Jurnal →
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
