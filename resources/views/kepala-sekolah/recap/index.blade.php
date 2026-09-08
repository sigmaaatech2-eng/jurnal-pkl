<x-layouts.app title="Rekapitulasi PKL Sekolah">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Rekapitulasi PKL Sekolah
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Laporan agregat penempatan PKL, progres jurnal, dan absensi di seluruh instansi mitra dan guru pembimbing.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- 4 KARTU STATISTIK AKUMULASI --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Total Siswa --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Siswa Terdaftar</p>
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">{{ $totalStudents }}</p>
            <p class="mt-1 text-xs text-slate-400">Siswa berakun sistem</p>
        </div>

        {{-- Siswa Aktif PKL --}}
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Siswa Aktif PKL</p>
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-emerald-700 dark:text-emerald-300">{{ $totalActiveStudents }}</p>
            <p class="mt-1 text-xs text-emerald-600/80 dark:text-emerald-400/80">Sedang di tempat magang</p>
        </div>

        {{-- Total Jurnal Masuk --}}
        <div class="rounded-2xl border border-blue-200 bg-blue-50/50 p-5 shadow-sm dark:border-blue-500/20 dark:bg-blue-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-400">Total Jurnal Masuk</p>
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-blue-700 dark:text-blue-300">{{ $totalJournals }}</p>
            <p class="mt-1 text-xs text-blue-600/80 dark:text-blue-400/80">Seluruh laporan kegiatan</p>
        </div>

        {{-- Total Kehadiran --}}
        <div class="rounded-2xl border border-indigo-200 bg-indigo-50/50 p-5 shadow-sm dark:border-indigo-500/20 dark:bg-indigo-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-400">Total Kehadiran</p>
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-indigo-700 dark:text-indigo-300">{{ $totalAttendance }}</p>
            <p class="mt-1 text-xs text-indigo-600/80 dark:text-indigo-400/80">Sesi check-in siswa</p>
        </div>
    </div>

    {{-- BAGIAN 1: REKAP BERDASARKAN JURUSAN --}}
    <div class="mb-8 rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">
                Rekapitulasi Berdasarkan Jurusan (Kompetensi Keahlian)
            </h2>
            <p class="text-xs text-slate-400 dark:text-slate-500">
                Akumulasi jumlah siswa terdaftar, siswa aktif magang, jurnal kegiatan, dan kehadiran per jurusan
            </p>
        </div>

        @if ($byMajor->isEmpty())
            <div class="py-12 text-center text-sm text-slate-400">
                Belum ada data siswa per jurusan.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Kompetensi Keahlian / Jurusan</th>
                            <th class="px-6 py-4 text-center">Total Siswa</th>
                            <th class="px-6 py-4 text-center">Siswa Aktif PKL</th>
                            <th class="px-6 py-4 text-center">Total Jurnal Masuk</th>
                            <th class="px-6 py-4 text-center">Total Hadir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($byMajor as $item)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-violet-100 font-bold text-violet-600 dark:bg-violet-500/20 dark:text-violet-400">
                                            {{ strtoupper(substr($item['major'], 0, 1)) }}
                                        </div>
                                        <div class="font-semibold text-slate-800 dark:text-white">
                                            {{ $item['major'] }}
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-bold text-slate-700 dark:text-slate-200">
                                    {{ $item['count'] }} Siswa
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        {{ $item['active'] }} Aktif
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-blue-600 dark:text-blue-400">
                                    {{ $item['journals'] }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-emerald-600 dark:text-emerald-400">
                                    {{ $item['attendances'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- BAGIAN 2: REKAP BERDASARKAN TEMPAT PKL --}}
    <div class="mb-8 rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">
                Rekapitulasi Berdasarkan Tempat PKL (Instansi / DUDI)
            </h2>
            <p class="text-xs text-slate-400 dark:text-slate-500">
                Akumulasi jumlah penempatan, jurnal, dan absensi per perusahaan mitra
            </p>
        </div>

        @if ($byCompany->isEmpty())
            <div class="py-12 text-center text-sm text-slate-400">
                Belum ada data penempatan PKL per instansi.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Nama Perusahaan / Instansi</th>
                            <th class="px-6 py-4 text-center">Total Siswa</th>
                            <th class="px-6 py-4 text-center">Siswa Aktif</th>
                            <th class="px-6 py-4 text-center">Total Jurnal</th>
                            <th class="px-6 py-4 text-center">Total Hadir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($byCompany as $item)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-white">
                                        {{ $item['company'] }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-bold text-slate-700 dark:text-slate-200">
                                    {{ $item['count'] }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        {{ $item['active'] }} Aktif
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-blue-600 dark:text-blue-400">
                                    {{ $item['journals'] }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-emerald-600 dark:text-emerald-400">
                                    {{ $item['attendances'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- BAGIAN 2: REKAP BERDASARKAN GURU PEMBIMBING --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">
                Rekapitulasi Berdasarkan Guru Pembimbing
            </h2>
            <p class="text-xs text-slate-400 dark:text-slate-500">
                Akumulasi jumlah siswa bimbingan, aktivitas jurnal, dan kehadiran per guru pembimbing
            </p>
        </div>

        @if ($byTeacher->isEmpty())
            <div class="py-12 text-center text-sm text-slate-400">
                Belum ada data penempatan bimbingan per guru.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Nama Guru Pembimbing</th>
                            <th class="px-6 py-4">Kontak / Email</th>
                            <th class="px-6 py-4 text-center">Total Bimbingan</th>
                            <th class="px-6 py-4 text-center">Siswa Aktif</th>
                            <th class="px-6 py-4 text-center">Total Jurnal Siswa</th>
                            <th class="px-6 py-4 text-center">Total Hadir Siswa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($byTeacher as $t)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-violet-100 font-bold text-violet-600 dark:bg-violet-500/20 dark:text-violet-400">
                                            {{ strtoupper(substr($t['teacher_name'], 0, 1)) }}
                                        </div>
                                        <div class="font-semibold text-slate-800 dark:text-white">
                                            {{ $t['teacher_name'] }}
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-400">
                                    {{ $t['teacher_email'] }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-bold text-slate-700 dark:text-slate-200">
                                    {{ $t['count'] }} Siswa
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        {{ $t['active'] }} Aktif
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-blue-600 dark:text-blue-400">
                                    {{ $t['journals'] }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-emerald-600 dark:text-emerald-400">
                                    {{ $t['attendances'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</x-layouts.app>
