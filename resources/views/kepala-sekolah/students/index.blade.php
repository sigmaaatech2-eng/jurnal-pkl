<x-layouts.app title="Monitoring Siswa PKL">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Monitoring Siswa PKL
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Pantau seluruh siswa yang sedang atau pernah menjalani program Praktik Kerja Lapangan.
                    </p>
                </div>
            </div>
        </div>

        {{-- BREADCRUMB / BADGE --}}
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" action="{{ route('kepala-sekolah.students.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama siswa..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500"
                >
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Filter Jurusan --}}
                <select
                    name="jurusan"
                    class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                >
                    <option value="">Semua Jurusan</option>
                    @foreach ($jurusanList as $j)
                        <option value="{{ $j }}" {{ request('jurusan') === $j ? 'selected' : '' }}>
                            {{ $j }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Status --}}
                <select
                    name="status"
                    class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:placeholder:text-slate-500"
                >
                    <option value="">Semua Status PKL</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-violet-700 active:scale-95"
                >
                    Filter
                </button>

                @if (request()->hasAny(['search', 'jurusan', 'status']))
                    <a
                        href="{{ route('kepala-sekolah.students.index') }}"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABEL SISWA PKL --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($internships->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200">Tidak Ada Data Siswa PKL</h3>
                <p class="mt-1 text-sm text-slate-400">Tidak ditemukan siswa dengan filter yang dipilih.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Nama Siswa</th>
                            <th class="px-6 py-4">Jurusan & Kelas</th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Guru Pembimbing</th>
                            <th class="px-6 py-4">Mentor</th>
                            <th class="px-6 py-4">Status PKL</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($internships as $internship)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Nama Siswa --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-100 font-bold text-violet-600 dark:bg-violet-500/20 dark:text-violet-400">
                                            {{ strtoupper(substr($internship->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">
                                                {{ $internship->student->name ?? '-' }}
                                            </div>
                                            <div class="text-xs text-slate-400">
                                                {{ $internship->student->email ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Jurusan & Kelas --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $internship->student->jurusan ?? 'Umum' }}
                                    </div>
                                    <div class="mt-0.5 text-xs text-slate-400">
                                        {{ $internship->student->kelas ?? 'Kelas XII' }}
                                    </div>
                                </td>

                                {{-- Tempat PKL --}}
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $internship->company_name ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ Str::limit($internship->company_address ?? '', 30) }}
                                    </div>
                                </td>

                                {{-- Guru Pembimbing --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium text-slate-700 dark:text-slate-200">
                                        {{ $internship->teacher->name ?? 'Belum Ditentukan' }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $internship->teacher->email ?? '-' }}
                                    </div>
                                </td>

                                {{-- Mentor --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium text-slate-700 dark:text-slate-200">
                                        {{ $internship->mentor->name ?? 'Belum Ditentukan' }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $internship->mentor->email ?? '-' }}
                                    </div>
                                </td>

                                {{-- Status PKL --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $badgeStyles = match($internship->status) {
                                            'active'    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                            'completed' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                            'inactive'  => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                            default     => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                        };
                                        $badgeLabel = match($internship->status) {
                                            'active'    => 'Aktif',
                                            'completed' => 'Selesai',
                                            'inactive'  => 'Tidak Aktif',
                                            default     => ucfirst($internship->status),
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeStyles }}">
                                        {{ $badgeLabel }}
                                    </span>
                                </td>

                                {{-- Aksi: Lihat Detail --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('kepala-sekolah.students.show', $internship) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-violet-200 bg-violet-50 px-3.5 py-1.5 text-xs font-semibold text-violet-700 transition hover:bg-violet-100 dark:border-violet-500/30 dark:bg-violet-500/10 dark:text-violet-300 dark:hover:bg-violet-500/20"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <span>Lihat Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($internships->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $internships->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>
