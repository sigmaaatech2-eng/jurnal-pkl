<x-layouts.app title="Detail Siswa – {{ $student->name }}">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-sekolah.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Admin Sekolah</a>
                <span>/</span>
                <a href="{{ route('admin-sekolah.students.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Data Siswa</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Detail</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Detail Siswa: {{ $student->name }}
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Informasi profil siswa, penempatan PKL, pembimbing, mentor, serta ringkasan aktivitas jurnal dan presensi.
            </p>
        </div>

        <div class="flex items-center gap-3">
            @if (!$activeInternship)
                <a
                    href="{{ route('admin-sekolah.internships.create', ['student_id' => $student->id]) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white shadow-md shadow-blue-500/20 transition hover:bg-blue-700 active:scale-95"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Atur Penempatan PKL</span>
                </a>
            @endif

            <a
                href="{{ route('admin-sekolah.students.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <span>← Kembali</span>
            </a>
        </div>
    </div>

    {{-- 1. IDENTITAS SISWA & PENEMPATAN PKL --}}
    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- CARD IDENTITAS SISWA --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Identitas Siswa
            </h2>

            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-2xl font-extrabold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="truncate text-lg font-bold text-slate-800 dark:text-white">
                        {{ $student->name }}
                    </h3>
                    <p class="truncate text-sm text-slate-500 dark:text-slate-400">
                        {{ $student->email }}
                    </p>
                    <span class="mt-1.5 inline-block rounded-md bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        Role: Siswa PKL
                    </span>
                </div>
            </div>

            <div class="mt-5 divide-y divide-slate-100 border-t border-slate-100 pt-1 text-xs dark:divide-slate-800 dark:border-slate-800">
                <div class="flex items-center justify-between py-2.5">
                    <span class="text-slate-400">User ID</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-200">#{{ $student->id }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5">
                    <span class="text-slate-400">Terdaftar Sejak</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-200">
                        {{ $student->created_at ? $student->created_at->translatedFormat('d F Y') : '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- CARD DATA PENEMPATAN PKL --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Data Penempatan PKL
                </h2>

                @if ($activeInternship)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Aktif PKL
                    </span>
                @elseif ($currentInternship && $currentInternship->status === 'completed')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                        Selesai
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        Belum Ada PKL Aktif
                    </span>
                @endif
            </div>

            @if ($currentInternship)
                <div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">
                        {{ $currentInternship->company_name }}
                    </h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ $currentInternship->company_address }}
                    </p>
                </div>

                <div class="mt-5 divide-y divide-slate-100 border-t border-slate-100 pt-1 text-xs dark:divide-slate-800 dark:border-slate-800">
                    <div class="flex items-center justify-between py-2.5">
                        <span class="text-slate-400">Periode Pelaksanaan</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200">
                            {{ \Carbon\Carbon::parse($currentInternship->start_date)->format('d M Y') }}
                            s/d
                            {{ \Carbon\Carbon::parse($currentInternship->end_date)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2.5">
                        <span class="text-slate-400">Durasi Terjadwal</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200">
                            {{ \Carbon\Carbon::parse($currentInternship->start_date)->diffInDays(\Carbon\Carbon::parse($currentInternship->end_date)) }} Hari
                        </span>
                    </div>
                </div>
            @else
                <div class="py-6 text-center text-xs text-slate-400">
                    Siswa belum memiliki penempatan PKL aktif. Silakan klik tombol "Atur Penempatan PKL" untuk menugaskan tempat PKL, guru pembimbing, dan mentor.
                </div>
            @endif
        </div>

    </div>

    {{-- 2. GURU PEMBIMBING & MENTOR DUDI --}}
    <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2">

        {{-- GURU PEMBIMBING --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Guru Pembimbing Sekolah
            </h3>

            @if ($currentInternship && $currentInternship->teacher)
                <div class="flex items-center gap-3.5">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-100 font-bold text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                        {{ strtoupper(substr($currentInternship->teacher->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white">
                            {{ $currentInternship->teacher->name }}
                        </h4>
                        <p class="text-xs text-slate-400">
                            {{ $currentInternship->teacher->email }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Belum ditugaskan guru pembimbing.</p>
            @endif
        </div>

        {{-- MENTOR DUDI --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Mentor Lapangan / DUDI
            </h3>

            @if ($currentInternship && $currentInternship->mentor)
                <div class="flex items-center gap-3.5">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-100 font-bold text-purple-700 dark:bg-purple-500/20 dark:text-purple-300">
                        {{ strtoupper(substr($currentInternship->mentor->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white">
                            {{ $currentInternship->mentor->name }}
                        </h4>
                        <p class="text-xs text-slate-400">
                            {{ $currentInternship->mentor->email }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Belum ditugaskan mentor lapangan.</p>
            @endif
        </div>

    </div>

    {{-- 3. RINGKASAN JURNAL SISWA --}}
    <div class="mb-6">
        <div class="mb-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">
                    Ringkasan Jurnal Harian
                </h2>
            </div>
        </div>

        {{-- 4 Stat Card Jurnal --}}
        <div class="mb-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Total Jurnal</p>
                <p class="mt-1 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalJournals }}</p>
            </div>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50/50 p-4 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Divalidasi</p>
                <p class="mt-1 text-2xl font-extrabold text-emerald-700 dark:text-emerald-300">{{ $approvedJournals }}</p>
            </div>
            <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-4 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">Menunggu</p>
                <p class="mt-1 text-2xl font-extrabold text-amber-700 dark:text-amber-300">{{ $pendingJournals }}</p>
            </div>
            <div class="rounded-xl border border-rose-200 bg-rose-50/50 p-4 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-rose-700 dark:text-rose-400">Perlu Revisi</p>
                <p class="mt-1 text-2xl font-extrabold text-rose-700 dark:text-rose-300">{{ $rejectedJournals }}</p>
            </div>
        </div>

        {{-- Tabel Jurnal Terbaru --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @if ($journals->isEmpty())
                <div class="p-8 text-center text-xs text-slate-400">
                    Siswa belum memiliki catatan jurnal kegiatan.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3">Tanggal</th>
                                <th class="px-5 py-3">Kegiatan</th>
                                <th class="px-5 py-3">Nilai Mentor</th>
                                <th class="px-5 py-3">Status Validasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                            @foreach ($journals as $journal)
                                <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                    <td class="whitespace-nowrap px-5 py-3 font-semibold text-slate-800 dark:text-slate-200">
                                        {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3">
                                        <p class="font-medium text-slate-800 dark:text-white">{{ $journal->title }}</p>
                                        <p class="text-slate-400 text-[11px] line-clamp-1">{{ Str::limit($journal->description, 60) }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-3">
                                        @if (!is_null($journal->mentor_score))
                                            <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $journal->mentor_score }}</span>
                                            @if ($journal->mentor_rating)
                                                <span class="text-slate-400">({{ str_replace('_', ' ', ucfirst($journal->mentor_rating)) }})</span>
                                            @endif
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-3">
                                        @if ($journal->status === 'approved')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                ✓ Divalidasi
                                            </span>
                                        @elseif ($journal->status === 'rejected')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-2 py-0.5 font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                                ✕ Perlu Revisi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                                ⏳ Menunggu
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- 4. RINGKASAN ABSENSI SISWA --}}
    <div>
        <div class="mb-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-white">
                    Ringkasan Presensi / Absensi
                </h2>
            </div>
        </div>

        {{-- 3 Stat Card Absensi --}}
        <div class="mb-4 grid grid-cols-3 gap-3">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Total Absensi</p>
                <p class="mt-1 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalAttendances }}</p>
            </div>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50/50 p-4 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Hadir Tepat Waktu</p>
                <p class="mt-1 text-2xl font-extrabold text-emerald-700 dark:text-emerald-300">{{ $presentCount }}</p>
            </div>
            <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-4 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">Terlambat</p>
                <p class="mt-1 text-2xl font-extrabold text-amber-700 dark:text-amber-300">{{ $lateCount }}</p>
            </div>
        </div>

        {{-- Tabel Absensi Terbaru --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @if ($attendances->isEmpty())
                <div class="p-8 text-center text-xs text-slate-400">
                    Siswa belum memiliki data absensi kegiatan PKL.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3">Tanggal</th>
                                <th class="px-5 py-3">Check In</th>
                                <th class="px-5 py-3">Check Out</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                            @foreach ($attendances as $att)
                                <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                    <td class="whitespace-nowrap px-5 py-3 font-semibold text-slate-800 dark:text-slate-200">
                                        {{ \Carbon\Carbon::parse($att->date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $att->check_in ?? '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $att->check_out ?? '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-3">
                                        @if ($att->status === 'present')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                Hadir
                                            </span>
                                        @elseif ($att->status === 'late')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                                {{ ucfirst($att->status ?? '-') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</x-layouts.app>
