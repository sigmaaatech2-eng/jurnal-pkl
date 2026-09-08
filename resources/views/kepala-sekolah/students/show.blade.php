<x-layouts.app title="Detail Siswa PKL - {{ $internship->student->name ?? 'Siswa' }}">

    {{-- TOP NAVIGATION / BREADCRUMB --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <a
                href="{{ route('kepala-sekolah.students.index') }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    <a href="{{ route('kepala-sekolah.students.index') }}" class="hover:text-violet-600">Monitoring Siswa</a>
                    <span>/</span>
                    <span class="text-violet-600">Detail Aktivitas Siswa</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                    {{ $internship->student->name ?? 'Detail Siswa' }}
                </h1>
            </div>
        </div>

    </div>

    {{-- KARTU INFORMASI UTAMA PKL --}}
    <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- PROFIL SISWA & TEMPAT PKL --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:col-span-2">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-violet-100 text-2xl font-bold text-violet-600 dark:bg-violet-500/20 dark:text-violet-400">
                    {{ strtoupper(substr($internship->student->name ?? 'S', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                            {{ $internship->student->name ?? '-' }}
                        </h2>
                        @php
                            $badgeStyles = match($internship->status) {
                                'active'    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                'completed' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                'inactive'  => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                default     => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                            };
                            $badgeLabel = match($internship->status) {
                                'active'    => 'PKL Aktif',
                                'completed' => 'PKL Selesai',
                                'inactive'  => 'Tidak Aktif',
                                default     => ucfirst($internship->status),
                            };
                        @endphp
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeStyles }}">
                            {{ $badgeLabel }}
                        </span>
                    </div>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $internship->student->email ?? '-' }}
                    </p>

                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700 dark:bg-violet-500/10 dark:text-violet-300">
                            Jurusan: {{ $internship->student->jurusan ?? 'Umum' }}
                        </span>
                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                            Kelas: {{ $internship->student->kelas ?? 'XII' }}
                        </span>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-4 border-t border-slate-100 pt-5 dark:border-slate-800 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Tempat PKL</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">
                                {{ $internship->company_name ?? '-' }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $internship->company_address ?? 'Alamat belum diatur' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Periode PKL</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">
                                {{ $internship->start_date ? $internship->start_date->format('d M Y') : '-' }} s/d {{ $internship->end_date ? $internship->end_date->format('d M Y') : '-' }}
                            </p>
                            <p class="text-xs text-slate-400">
                                @if ($internship->start_date && $internship->end_date)
                                    Durasi: {{ $internship->start_date->diffInMonths($internship->end_date) }} Bulan
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- INFORMASI PEMBIMBING & MENTOR --}}
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Pihak Pembimbing
                </h3>

                <div class="mt-4 space-y-4">
                    {{-- Guru Pembimbing --}}
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Guru Pembimbing Sekolah</p>
                            <p class="text-sm font-semibold text-slate-800 dark:text-white">
                                {{ $internship->teacher->name ?? 'Belum Ditentukan' }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $internship->teacher->email ?? '-' }}
                            </p>
                        </div>
                    </div>

                    {{-- Mentor DUDI --}}
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Mentor Lapangan (DUDI)</p>
                            <p class="text-sm font-semibold text-slate-800 dark:text-white">
                                {{ $internship->mentor->name ?? 'Belum Ditentukan' }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $internship->mentor->email ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-xl bg-slate-50 p-3 text-center text-xs text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                Data bimbingan tersinkronisasi otomatis dengan sistem penempatan.
            </div>
        </div>

    </div>

    {{-- 5 KARTU STATISTIK AKTIVITAS SISWA --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
        {{-- Total Jurnal --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Jurnal</p>
            <p class="mt-2 text-2xl font-bold text-slate-800 dark:text-white">{{ $totalJournals }}</p>
            <p class="mt-1 text-xs text-slate-400">Kegiatan diunggah</p>
        </div>

        {{-- Jurnal Pending --}}
        <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-5 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">Menunggu Review</p>
            <p class="mt-2 text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $pendingJournals }}</p>
            <p class="mt-1 text-xs text-amber-600/80 dark:text-amber-400/80">Belum divalidasi</p>
        </div>

        {{-- Jurnal Disetujui --}}
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Disetujui</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ $approvedJournals }}</p>
            <p class="mt-1 text-xs text-emerald-600/80 dark:text-emerald-400/80">Valid oleh mentor</p>
        </div>

        {{-- Jurnal Ditolak --}}
        <div class="rounded-2xl border border-red-200 bg-red-50/50 p-5 shadow-sm dark:border-red-500/20 dark:bg-red-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-red-700 dark:text-red-400">Perlu Revisi</p>
            <p class="mt-2 text-2xl font-bold text-red-700 dark:text-red-300">{{ $rejectedJournals }}</p>
            <p class="mt-1 text-xs text-red-600/80 dark:text-red-400/80">Catatan perbaikan</p>
        </div>

        {{-- Kehadiran --}}
        <div class="rounded-2xl border border-blue-200 bg-blue-50/50 p-5 shadow-sm dark:border-blue-500/20 dark:bg-blue-500/10">
            <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-400">Total Hadir</p>
            <p class="mt-2 text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $presentDays }} Hari</p>
            <p class="mt-1 text-xs text-blue-600/80 dark:text-blue-400/80">Dari {{ $totalAttendance }} sesi tercatat</p>
        </div>
    </div>

    {{-- TAB TAMPILAN AKTIVITAS: JURNAL & ABSENSI --}}
    <div x-data="{ activeTab: 'journals' }" class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- TAB HEADER --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 pt-4 dark:border-slate-800">
            <div class="flex gap-4">
                <button
                    @click="activeTab = 'journals'"
                    :class="activeTab === 'journals'
                        ? 'border-violet-600 text-violet-600 dark:border-violet-400 dark:text-violet-400'
                        : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200'"
                    class="flex items-center gap-2 border-b-2 pb-4 text-sm font-semibold transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span>Jurnal Aktivitas ({{ $totalJournals }})</span>
                </button>

                <button
                    @click="activeTab = 'attendances'"
                    :class="activeTab === 'attendances'
                        ? 'border-violet-600 text-violet-600 dark:border-violet-400 dark:text-violet-400'
                        : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200'"
                    class="flex items-center gap-2 border-b-2 pb-4 text-sm font-semibold transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>
                    <span>Rekap Absensi ({{ $totalAttendance }})</span>
                </button>
            </div>

            <div class="pb-3 text-xs text-slate-400">
                Hanya Tinjauan Pengawasan
            </div>
        </div>

        {{-- CONTENT TAB 1: JURNAL --}}
        <div x-show="activeTab === 'journals'" class="p-6">
            @if ($journals->isEmpty())
                <div class="py-12 text-center text-sm text-slate-400">
                    Belum ada jurnal yang diunggah oleh siswa ini.
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($journals as $journal)
                        <div class="rounded-xl border border-slate-100 p-4 transition hover:bg-slate-50/60 dark:border-slate-800 dark:hover:bg-slate-800/40">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <span class="text-xs font-semibold text-violet-600 dark:text-violet-400">
                                        {{ $journal->date ? $journal->date->format('l, d F Y') : '-' }}
                                    </span>
                                    <h4 class="text-base font-bold text-slate-800 dark:text-white">
                                        {{ $journal->title }}
                                    </h4>
                                </div>
                                <div>
                                    @php
                                        $jColor = match($journal->status) {
                                            'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                            'rejected' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300',
                                            default    => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                                        };
                                        $jLabel = match($journal->status) {
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Perlu Revisi',
                                            default    => 'Menunggu Review',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $jColor }}">
                                        {{ $jLabel }}
                                    </span>
                                </div>
                            </div>

                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                                {{ $journal->description }}
                            </p>

                            @if ($journal->mentor_feedback || $journal->feedback)
                                <div class="mt-3 rounded-lg border-l-4 border-violet-500 bg-violet-50/50 p-3 text-xs text-violet-900 dark:bg-violet-500/10 dark:text-violet-300">
                                    <span class="font-bold">Catatan Mentor/Guru:</span> {{ $journal->mentor_feedback ?? $journal->feedback }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- CONTENT TAB 2: ABSENSI --}}
        <div x-show="activeTab === 'attendances'" class="p-6">
            @if ($attendances->isEmpty())
                <div class="py-12 text-center text-sm text-slate-400">
                    Belum ada rekaman absensi untuk siswa ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Check-In</th>
                                <th class="px-4 py-3">Check-Out</th>
                                <th class="px-4 py-3">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($attendances as $att)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-800 dark:text-white">
                                        {{ $att->date ? $att->date->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $att->check_in ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $att->check_out ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $attColor = match($att->status) {
                                                'present', 'hadir' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                                'sick', 'sakit'    => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                                                'permission', 'izin'=> 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                                default             => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300',
                                            };
                                            $attLabel = match($att->status) {
                                                'present', 'hadir' => 'Hadir',
                                                'sick', 'sakit'    => 'Sakit',
                                                'permission', 'izin'=> 'Izin',
                                                default             => ucfirst($att->status ?? 'Alpa'),
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $attColor }}">
                                            {{ $attLabel }}
                                        </span>
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
