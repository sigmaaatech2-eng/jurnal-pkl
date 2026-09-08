<x-layouts.app title="Dashboard Admin Sekolah">

    {{-- WELCOME BANNER --}}
    <div class="mb-8">
        <div class="rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-600 to-indigo-700 p-6 text-white shadow-lg dark:border-blue-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-blue-100 backdrop-blur">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Portal Administrator Sekolah
                    </span>
                    <h1 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl">
                        Selamat datang, {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="mt-1 text-sm text-blue-100">
                        Pantau seluruh data siswa, status penempatan PKL, guru pembimbing, dan mentor secara real-time.
                    </p>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <a
                        href="{{ route('admin-sekolah.internships.create') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-blue-700 shadow-md transition hover:bg-blue-50 active:scale-95"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Atur Penempatan PKL</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 5 KARTU STATISTIK DATA REAL --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">

        {{-- 1. TOTAL SISWA --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Total Siswa
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">
                {{ $totalStudents }}
            </p>
            <p class="mt-1 text-xs text-slate-400">
                Siswa terdaftar dalam sistem
            </p>
        </div>

        {{-- 2. SEDANG PKL --}}
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-emerald-500/20 dark:bg-emerald-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                    Sedang PKL
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-emerald-700 dark:text-emerald-300">
                {{ $totalActiveInterns }}
            </p>
            <p class="mt-1 text-xs text-emerald-600/80 dark:text-emerald-400/80">
                Penempatan status aktif
            </p>
        </div>

        {{-- 3. GURU PEMBIMBING --}}
        <div class="rounded-2xl border border-indigo-200 bg-indigo-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-indigo-500/20 dark:bg-indigo-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-400">
                    Guru Pembimbing
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-5.25 6.557c.22.477.447.948.683 1.412a47.88 47.88 0 0 0 4.567 2.128" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-indigo-700 dark:text-indigo-300">
                {{ $totalTeachers }}
            </p>
            <p class="mt-1 text-xs text-indigo-600/80 dark:text-indigo-400/80">
                Pembimbing sekolah terdaftar
            </p>
        </div>

        {{-- 4. TOTAL MENTOR --}}
        <div class="rounded-2xl border border-purple-200 bg-purple-50/50 p-5 shadow-sm transition hover:shadow-md dark:border-purple-500/20 dark:bg-purple-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-purple-700 dark:text-purple-400">
                    Total Mentor
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.999-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-purple-700 dark:text-purple-300">
                {{ $totalMentors }}
            </p>
            <p class="mt-1 text-xs text-purple-600/80 dark:text-purple-400/80">
                Mentor DUDI mitra PKL
            </p>
        </div>

        {{-- 5. BELUM PENEMPATAN PKL --}}
        <div class="col-span-2 sm:col-span-1 rounded-2xl border border-amber-200 bg-amber-50/60 p-5 shadow-sm transition hover:shadow-md dark:border-amber-500/20 dark:bg-amber-500/10">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">
                    Belum Penempatan
                </p>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-amber-700 dark:text-amber-300">
                {{ $totalUnassignedStudents }}
            </p>
            <p class="mt-1 text-xs text-amber-700/80 dark:text-amber-400/80">
                Siswa menunggu penempatan
            </p>
        </div>

    </div>

    {{-- KONTEN UTAMA DUA KOLOM --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- KOLOM KIRI (2 SPAN): TABEL PENEMPATAN PKL TERBARU --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25" />
                            </svg>
                        </div>
                        <h2 class="text-base font-bold text-slate-800 dark:text-white">
                            Penempatan PKL Terbaru
                        </h2>
                    </div>
                    <a
                        href="{{ route('admin-sekolah.internships.index') }}"
                        class="text-xs font-semibold text-blue-600 hover:underline dark:text-blue-400"
                    >
                        Lihat Semua PKL →
                    </a>
                </div>

                @if ($recentInternships->isEmpty())
                    <div class="py-14 text-center">
                        <p class="text-sm text-slate-400">Belum ada data penempatan PKL.</p>
                        <a
                            href="{{ route('admin-sekolah.internships.create') }}"
                            class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:underline"
                        >
                            + Buat Penempatan PKL Pertama
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                            <thead class="border-b border-slate-100 bg-slate-50/70 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                                <tr>
                                    <th class="px-5 py-3.5">Siswa</th>
                                    <th class="px-5 py-3.5">Tempat PKL</th>
                                    <th class="px-5 py-3.5">Pembimbing</th>
                                    <th class="px-5 py-3.5">Status</th>
                                    <th class="px-5 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($recentInternships as $item)
                                    <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                        <td class="whitespace-nowrap px-5 py-3.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                                    {{ strtoupper(substr($item->student->name ?? 'S', 0, 1)) }}
                                                </div>
                                                <span class="font-bold text-slate-800 dark:text-white">
                                                    {{ $item->student->name ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <div class="max-w-[180px]">
                                                <p class="truncate font-medium text-slate-800 dark:text-slate-200">{{ $item->company_name }}</p>
                                                <p class="truncate text-xs text-slate-400">{{ Str::limit($item->company_address, 28) }}</p>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-3.5 text-xs">
                                            <div class="font-medium text-slate-700 dark:text-slate-300">
                                                Guru: {{ $item->teacher->name ?? '-' }}
                                            </div>
                                            <div class="text-slate-400">
                                                Mentor: {{ $item->mentor->name ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-3.5">
                                            @if ($item->status === 'active')
                                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Aktif
                                                </span>
                                            @elseif ($item->status === 'completed')
                                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-3.5 text-right">
                                            @if ($item->student)
                                                <a
                                                    href="{{ route('admin-sekolah.students.show', $item->student) }}"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                                                >
                                                    Detail →
                                                </a>
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

        {{-- KOLOM KANAN (1 SPAN): SISWA BELUM PENEMPATAN & SHORTCUTS --}}
        <div class="space-y-6">

            {{-- PANEL SISWA BELUM MEMILIKI PENEMPATAN --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 dark:text-white">
                            Belum Ditempatkan
                        </h3>
                    </div>
                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                        {{ $totalUnassignedStudents }} Siswa
                    </span>
                </div>

                @if ($unassignedStudents->isEmpty())
                    <div class="p-6 text-center text-xs text-slate-400">
                        🎉 Seluruh siswa telah memiliki penempatan PKL.
                    </div>
                @else
                    <div class="divide-y divide-slate-100 p-2 dark:divide-slate-800">
                        @foreach ($unassignedStudents as $student)
                            <div class="flex items-center justify-between p-3 rounded-xl transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <div class="min-w-0 flex-1 pr-2">
                                    <p class="truncate font-semibold text-slate-800 dark:text-white text-xs">
                                        {{ $student->name }}
                                    </p>
                                    <p class="truncate text-[11px] text-slate-400">
                                        {{ $student->email }}
                                    </p>
                                </div>
                                <a
                                    href="{{ route('admin-sekolah.internships.create', ['student_id' => $student->id]) }}"
                                    class="shrink-0 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-600 transition hover:bg-blue-600 hover:text-white dark:bg-blue-500/10 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white"
                                >
                                    + Tempatkan
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- AKSI CEPAT NAVIGASI --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Aksi Cepat
                </h3>

                <div class="space-y-2">
                    <a
                        href="{{ route('admin-sekolah.students.create') }}"
                        class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50/60 p-3 transition hover:border-blue-200 hover:bg-blue-50/50 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:border-blue-900"
                    >
                        <div class="flex items-center gap-2.5">
                            <span class="text-blue-600 font-bold text-sm">+</span>
                            <span class="text-xs font-semibold text-slate-700 dark:text-slate-200">Tambah Akun Siswa</span>
                        </div>
                        <span class="text-xs text-slate-400">→</span>
                    </a>

                    <a
                        href="{{ route('admin-sekolah.users.create') }}"
                        class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50/60 p-3 transition hover:border-indigo-200 hover:bg-indigo-50/50 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:border-indigo-900"
                    >
                        <div class="flex items-center gap-2.5">
                            <span class="text-indigo-600 font-bold text-sm">+</span>
                            <span class="text-xs font-semibold text-slate-700 dark:text-slate-200">Tambah Pengguna Baru</span>
                        </div>
                        <span class="text-xs text-slate-400">→</span>
                    </a>

                    <a
                        href="{{ route('admin-sekolah.users.index') }}"
                        class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50/60 p-3 transition hover:border-purple-200 hover:bg-purple-50/50 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:border-purple-900"
                    >
                        <div class="flex items-center gap-2.5">
                            <span class="text-purple-600 font-bold text-sm">👥</span>
                            <span class="text-xs font-semibold text-slate-700 dark:text-slate-200">Kelola Semua Pengguna</span>
                        </div>
                        <span class="text-xs text-slate-400">→</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</x-layouts.app>