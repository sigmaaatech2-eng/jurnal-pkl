<x-layouts.app title="Siswa Bimbingan">

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
                        Siswa Bimbingan
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Daftar seluruh siswa yang berada dalam bimbingan PKL Anda.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('guru-pembimbing.students.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Siswa</span>
            </a>
        </div>
    </div>

    {{-- SUCCESS ALERT --}}
    @if (session('success'))
        <div class="mb-6 flex items-center justify-between gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- FILTER BAR --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" action="{{ route('guru-pembimbing.students.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-6">
            {{-- Search --}}
            <div class="lg:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Cari Siswa / Tempat PKL
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Nama siswa, NISN, atau tempat..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2 pl-9 pr-3 text-sm text-slate-700 placeholder-slate-400 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:placeholder-slate-500 dark:focus:bg-slate-800"
                    />
                </div>
            </div>

            {{-- Filter Kelas --}}
            <div>
                <label for="kelas" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Kelas
                </label>
                <select
                    name="kelas"
                    id="kelas"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-700 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-800"
                >
                    <option value="">Semua Kelas</option>
                    @foreach ($kelasList as $kelasItem)
                        <option value="{{ $kelasItem }}" {{ request('kelas') == $kelasItem ? 'selected' : '' }}>
                            {{ $kelasItem }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Jurusan --}}
            <div>
                <label for="jurusan" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Jurusan
                </label>
                <select
                    name="jurusan"
                    id="jurusan"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-700 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-800"
                >
                    <option value="">Semua Jurusan</option>
                    @foreach ($jurusanList as $jurusanItem)
                        <option value="{{ $jurusanItem }}" {{ request('jurusan') == $jurusanItem ? 'selected' : '' }}>
                            {{ $jurusanItem }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tempat PKL --}}
            <div>
                <label for="company_name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Tempat PKL
                </label>
                <select
                    name="company_name"
                    id="company_name"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-700 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-800"
                >
                    <option value="">Semua Tempat PKL</option>
                    @foreach ($companyList as $cItem)
                        <option value="{{ $cItem }}" {{ request('company_name') == $cItem ? 'selected' : '' }}>
                            {{ $cItem }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sortir / Urutkan --}}
            <div>
                <label for="sort" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Urutkan
                </label>
                <select
                    name="sort"
                    id="sort"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-700 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-800"
                >
                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="kelas_asc" {{ request('sort') == 'kelas_asc' ? 'selected' : '' }}>Kelas (A - Z)</option>
                    <option value="kelas_desc" {{ request('sort') == 'kelas_desc' ? 'selected' : '' }}>Kelas (Z - A)</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama Siswa (A - Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Siswa (Z - A)</option>
                </select>
            </div>

            {{-- Submit and Reset buttons --}}
            <div class="flex flex-wrap items-center gap-2 pt-1 lg:col-span-6">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Terapkan Filter</span>
                </button>
                @if (request()->hasAny(['search', 'kelas', 'jurusan', 'company_name', 'sort']))
                    <a
                        href="{{ route('guru-pembimbing.students.index') }}"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                    >
                        <span>Reset Filter</span>
                    </a>
                @endif
                <div class="ml-auto text-xs text-slate-500 dark:text-slate-400 self-center">
                    Total Siswa Aktif: <span class="font-bold text-slate-800 dark:text-white">{{ $internships->count() }}</span>
                </div>
            </div>
        </form>
    </div>

    {{-- CARD TABEL SISWA --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($internships->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                @if (request()->hasAny(['search', 'kelas', 'jurusan', 'company_name']))
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200">Tidak Ada Siswa Yang Cocok</h3>
                    <p class="mt-1 text-sm text-slate-400">Tidak ada siswa bimbingan yang sesuai dengan kriteria filter yang Anda pilih.</p>
                    <div class="mt-5">
                        <a
                            href="{{ route('guru-pembimbing.students.index') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
                        >
                            <span>Reset Filter Pencarian</span>
                        </a>
                    </div>
                @else
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200">Belum Ada Siswa Bimbingan Aktif</h3>
                    <p class="mt-1 text-sm text-slate-400">Tambahkan siswa yang sudah terdaftar untuk memulai bimbingan PKL, atau siswa sebelumnya telah selesai PKL.</p>
                    <div class="mt-5">
                        <a
                            href="{{ route('guru-pembimbing.students.create') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                        >
                            <span>+ Tambah Siswa Sekarang</span>
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Nama Siswa</th>
                            <th class="px-6 py-4">
                                <a
                                    href="{{ route('guru-pembimbing.students.index', array_merge(request()->query(), ['sort' => request('sort') === 'kelas_asc' ? 'kelas_desc' : 'kelas_asc'])) }}"
                                    class="group inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400 transition"
                                    title="Klik untuk menyortir per kelas"
                                >
                                    <span>Kelas & Jurusan</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 {{ in_array(request('sort'), ['kelas_asc', 'kelas_desc']) ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if(request('sort') === 'kelas_desc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @elseif(request('sort') === 'kelas_asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        @endif
                                    </svg>
                                </a>
                            </th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Mentor Lapangan</th>
                            <th class="px-6 py-4">Periode</th>
                            <th class="px-6 py-4">Status PKL</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($internships as $internship)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                            {{ strtoupper(substr($internship->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">
                                                {{ $internship->student->name ?? '-' }}
                                            </div>
                                            <div class="text-xs text-slate-400">
                                                {{ $internship->student->email ?? '-' }}
                                            </div>
                                            @if(!empty($internship->student->nisn))
                                                <div class="mt-0.5 text-[11px] text-slate-400">
                                                    NISN: {{ $internship->student->nisn }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $displayKelas = $internship->student->schoolClass->name ?? $internship->student->kelas;
                                    @endphp
                                    @if(!empty($displayKelas))
                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                                            <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                            {{ $displayKelas }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                                            Belum Diatur
                                        </span>
                                    @endif
                                    @if(!empty($internship->student->jurusan))
                                        <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                            {{ $internship->student->jurusan }}
                                        </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-semibold text-slate-700 dark:text-slate-200">
                                        {{ $internship->company_name }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $internship->company_address ? Str::limit($internship->company_address, 35) : '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600 dark:text-slate-300">
                                    @if ($internship->mentor)
                                        <div class="font-medium text-slate-800 dark:text-slate-100">
                                            {{ $internship->mentor->name }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            {{ $internship->mentor->email }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-500 dark:text-slate-400">
                                    <div>{{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}</div>
                                    <div>s/d {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
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
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('guru-pembimbing.students.show', $internship) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-700"
                                    >
                                        <span>Monitoring</span>
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