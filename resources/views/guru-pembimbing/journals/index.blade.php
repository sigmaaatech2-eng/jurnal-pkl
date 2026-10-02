<x-layouts.app title="Monitoring Jurnal Siswa">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Monitoring Jurnal Siswa
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Pantau seluruh aktivitas harian siswa bimbingan PKL Anda beserta status validasi dari mentor lapangan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- STATS KARTU RINGKASAN --}}
    @php
        $totalJournals = $journals->count();
        $pendingCount  = $journals->where('status', 'pending')->count();
        $approvedCount = $journals->where('status', 'approved')->count();
        $rejectedCount = $journals->where('status', 'rejected')->count();
    @endphp

    <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Jurnal</p>
            <p class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">{{ $totalJournals }}</p>
        </div>

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">Menunggu Validasi</p>
            <p class="mt-2 text-3xl font-bold text-amber-700 dark:text-amber-300">{{ $pendingCount }}</p>
        </div>

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Divalidasi Mentor</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $approvedCount }}</p>
        </div>

        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-rose-600 dark:text-rose-400">Perlu Revisi</p>
            <p class="mt-2 text-3xl font-bold text-rose-700 dark:text-rose-300">{{ $rejectedCount }}</p>
        </div>
    </div>

    {{-- TABEL LIST JURNAL DENGAN FILTER CLIENT-SIDE MENGGUNAKAN ALPINE.JS --}}
    <div
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900"
        x-data="{
            filterStatus: 'all',
            searchQuery: '',
            matches(status, studentName, title) {
                const statusMatch = this.filterStatus === 'all' || status === this.filterStatus;
                const searchMatch = !this.searchQuery || 
                    studentName.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                    title.toLowerCase().includes(this.searchQuery.toLowerCase());
                return statusMatch && searchMatch;
            }
        }"
    >
        {{-- Toolbar Filter & Search --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 p-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative flex-1 sm:max-w-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                </svg>
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Cari siswa atau judul kegiatan..."
                    class="w-full rounded-xl border border-slate-200 bg-white py-2 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                >
            </div>

            <div class="flex flex-wrap gap-2">
                <button
                    type="button"
                    @click="filterStatus = 'all'"
                    class="rounded-xl px-3.5 py-1.5 text-xs font-semibold transition"
                    :class="filterStatus === 'all'
                        ? 'bg-blue-600 text-white shadow-sm'
                        : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'"
                >
                    Semua ({{ $totalJournals }})
                </button>
                <button
                    type="button"
                    @click="filterStatus = 'pending'"
                    class="rounded-xl px-3.5 py-1.5 text-xs font-semibold transition"
                    :class="filterStatus === 'pending'
                        ? 'bg-amber-600 text-white shadow-sm'
                        : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'"
                >
                    Menunggu Validasi ({{ $pendingCount }})
                </button>
                <button
                    type="button"
                    @click="filterStatus = 'approved'"
                    class="rounded-xl px-3.5 py-1.5 text-xs font-semibold transition"
                    :class="filterStatus === 'approved'
                        ? 'bg-emerald-600 text-white shadow-sm'
                        : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'"
                >
                    Divalidasi ({{ $approvedCount }})
                </button>
                <button
                    type="button"
                    @click="filterStatus = 'rejected'"
                    class="rounded-xl px-3.5 py-1.5 text-xs font-semibold transition"
                    :class="filterStatus === 'rejected'
                        ? 'bg-rose-600 text-white shadow-sm'
                        : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'"
                >
                    Perlu Revisi ({{ $rejectedCount }})
                </button>
            </div>
        </div>

        @if ($journals->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200">Belum Ada Jurnal</h3>
                <p class="mt-1 text-sm text-slate-400">Siswa bimbingan Anda belum mengirimkan catatan jurnal kegiatan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Judul Kegiatan</th>
                            <th class="px-6 py-4">Dokumentasi</th>
                            <th class="px-6 py-4">Validasi Mentor</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($journals as $journal)
                            <tr
                                class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40"
                                x-show="matches('{{ $journal->status }}', '{{ addslashes($journal->student->name ?? '') }}', '{{ addslashes($journal->title) }}')"
                            >
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-xs font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                            {{ strtoupper(substr($journal->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">{{ $journal->student->name ?? '-' }}</div>
                                            <div class="text-xs text-slate-400">{{ $journal->internship->company_name ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium text-slate-800 dark:text-slate-200">
                                        {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('l') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 max-w-[280px]">
                                    <p class="font-semibold text-slate-800 dark:text-white line-clamp-1">
                                        {{ $journal->title }}
                                    </p>
                                    <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">
                                        {{ Str::limit($journal->description, 70) }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($journal->attachment)
                                        <span class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 dark:text-blue-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Ada Foto</span>
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($journal->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu
                                        </span>
                                    @elseif ($journal->status === 'approved')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Divalidasi
                                        </span>
                                    @elseif ($journal->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Perlu Revisi
                                        </span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('guru-pembimbing.journals.show', $journal) }}"
                                        class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                                    >
                                        <span>Lihat Detail</span>
                                        <span>→</span>
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