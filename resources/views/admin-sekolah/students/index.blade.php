<x-layouts.app title="Data Siswa PKL">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Data Siswa PKL
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Kelola data seluruh siswa beserta status penempatan dan pelaksanaan PKL.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin-sekolah.students.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700 active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Siswa Baru</span>
            </a>
        </div>
    </div>

    {{-- SUCCESS ALERT --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- FILTER & SEARCH --}}
    <form method="GET" action="{{ route('admin-sekolah.students.index') }}" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
            </svg>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari berdasarkan nama atau email siswa..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
            >
        </div>

        <div class="flex flex-wrap gap-2">
            @php
                $statusOptions = [
                    'all'        => ['label' => 'Semua', 'count' => $totalCount],
                    'active'     => ['label' => 'Sedang PKL', 'count' => $activeCount],
                    'completed'  => ['label' => 'Selesai PKL', 'count' => $completedCount],
                    'unassigned' => ['label' => 'Belum Penempatan', 'count' => $unassignedCount],
                ];
            @endphp

            @foreach ($statusOptions as $val => $data)
                <a
                    href="{{ route('admin-sekolah.students.index', array_merge(request()->query(), ['status' => $val])) }}"
                    class="rounded-xl px-3.5 py-2 text-xs font-semibold transition
                    {{ (request('status', 'all') === $val)
                        ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20'
                        : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    {{ $data['label'] }} ({{ $data['count'] }})
                </a>
            @endforeach
        </div>
    </form>

    {{-- TABEL DATA SISWA --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($students->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Tidak Ada Data Siswa</h3>
                <p class="mt-1 text-sm text-slate-400">Tidak ada siswa yang sesuai dengan filter atau kata kunci pencarian Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Guru Pembimbing</th>
                            <th class="px-6 py-4">Mentor DUDI</th>
                            <th class="px-6 py-4">Periode PKL</th>
                            <th class="px-6 py-4">Status PKL</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($students as $student)
                            @php
                                $activeInternship  = $student->studentInternships->where('status', 'active')->first();
                                $latestInternship  = $activeInternship ?? $student->studentInternships->first();
                            @endphp
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Siswa --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">{{ $student->name }}</div>
                                            <div class="text-xs text-slate-400">{{ $student->email }}</div>
                                            @if ($student->jurusan)
                                                <div class="mt-0.5 text-[11px] font-semibold text-blue-600 dark:text-blue-400">{{ $student->jurusan }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Tempat PKL --}}
                                <td class="px-6 py-4">
                                    @if ($latestInternship)
                                        <div class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $latestInternship->company_name }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            {{ Str::limit($latestInternship->company_address, 30) }}
                                        </div>
                                    @else
                                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            Belum ditentukan
                                        </span>
                                    @endif
                                </td>

                                {{-- Guru Pembimbing --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($latestInternship && $latestInternship->teacher)
                                        <div class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ $latestInternship->teacher->name }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>

                                {{-- Mentor DUDI --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($latestInternship && $latestInternship->mentor)
                                        <div class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ $latestInternship->mentor->name }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>

                                {{-- Periode PKL --}}
                                <td class="whitespace-nowrap px-6 py-4 text-xs">
                                    @if ($latestInternship && $latestInternship->start_date && $latestInternship->end_date)
                                        <div class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ \Carbon\Carbon::parse($latestInternship->start_date)->format('d M Y') }}
                                        </div>
                                        <div class="text-slate-400">
                                            s/d {{ \Carbon\Carbon::parse($latestInternship->end_date)->format('d M Y') }}
                                        </div>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>

                                {{-- Status PKL --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($activeInternship)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif PKL
                                        </span>
                                    @elseif ($latestInternship && $latestInternship->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                            Selesai
                                        </span>
                                    @elseif ($latestInternship && $latestInternship->status === 'cancelled')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Belum Penempatan
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if (!$activeInternship)
                                            <a
                                                href="{{ route('admin-sekolah.internships.create', ['student_id' => $student->id]) }}"
                                                class="inline-flex items-center rounded-xl bg-blue-50 px-2.5 py-1.5 text-xs font-bold text-blue-600 transition hover:bg-blue-600 hover:text-white dark:bg-blue-500/10 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white"
                                                title="Tempatkan Siswa PKL"
                                            >
                                                + Penempatan
                                            </a>
                                        @endif

                                        <a
                                            href="{{ route('admin-sekolah.students.show', $student) }}"
                                            class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                                        >
                                            <span>Detail</span>
                                            <span>→</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($students->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $students->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>