<x-layouts.app title="Data Sekolah — Manajemen & Form Kelas">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-sekolah.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Admin Sekolah</a>
                <span>/</span>
                <span class="text-slate-400">Data Sekolah</span>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300 font-semibold">Data Kelas</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Data Sekolah — Manajemen & Formulir Kelas PKL (Kelas 12)
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Kelola daftar kelas dan formulir input kelas khusus tingkat 12 (XII) yang melaksanakan program PKL.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a
                href="{{ route('admin-sekolah.school-data.majors.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
                Kelola Jurusan
            </a>
        </div>
    </div>

    {{-- TAB NAVIGASI DATA SEKOLAH --}}
    <div class="mb-8 flex flex-wrap items-center gap-2 border-b border-slate-200 pb-4 dark:border-slate-800">
        <a
            href="{{ route('admin-sekolah.school-data.majors.index') }}"
            class="inline-flex items-center gap-2.5 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
            </svg>
            <span>Data Jurusan</span>
            <span class="rounded-full bg-slate-200/80 px-2 py-0.5 text-xs font-bold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                {{ $totalMajors ?? 0 }}
            </span>
        </a>

        <a
            href="{{ route('admin-sekolah.school-data.classes.index') }}"
            class="inline-flex items-center gap-2.5 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 transition hover:bg-blue-700"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span>Data Kelas PKL (Kelas 12)</span>
            <span class="rounded-full bg-white/20 px-2 py-0.5 text-xs font-bold text-white">
                {{ $totalClasses ?? 0 }}
            </span>
        </a>
    </div>

    {{-- ALERT MESSAGES --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-600 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300">
            <div class="flex items-center gap-2 font-bold mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>Gagal menyimpan data kelas. Silakan periksa formulir berikut:</span>
            </div>
            <ul class="list-inside list-disc space-y-1 text-xs pl-1">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- MAIN 2-COLUMN GRID: FORM MENGISI KELAS (LEFT) & DAFTAR KELAS (RIGHT) --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- FORM MENGISI / TAMBAH KELAS BARU (1 COLUMN) --}}
        <div class="lg:col-span-1">
            <div class="sticky top-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-800/40">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800 dark:text-white">Formulir Tambah Kelas</h2>
                            <p class="text-xs text-slate-400">Isi data untuk menambahkan kelas baru</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin-sekolah.school-data.classes.store') }}" class="p-5 space-y-4">
                    @csrf

                    {{-- Nama Kelas --}}
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Nama Kelas <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: XII RPL 1, X TKJ 2"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 @error('name') border-rose-500 @enderror"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tingkat / Grade --}}
                    <div>
                        <label for="grade" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Tingkat Kelas (Khusus PKL)
                        </label>
                        <select
                            name="grade"
                            id="grade"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                        >
                            <option value="XII" selected>Kelas XII (Tingkat PKL / Kelas 12)</option>
                        </select>
                        <p class="mt-1 text-[11px] text-slate-400">Khusus siswa tingkat akhir / Kelas 12 yang melaksanakan program PKL.</p>
                        @error('grade')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jurusan --}}
                    <div>
                        <label for="school_major_id" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Pilih Jurusan <span class="text-rose-500">*</span>
                        </label>
                        <select
                            name="school_major_id"
                            id="school_major_id"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 @error('school_major_id') border-rose-500 @enderror"
                        >
                            <option value="">— Pilih Jurusan Terkait —</option>
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}" @selected(old('school_major_id') == $major->id)>
                                    {{ $major->name }}{{ $major->code ? " ({$major->code})" : '' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($majors->isEmpty())
                            <p class="mt-1 text-[11px] text-amber-500">
                                Belum ada jurusan. <a href="{{ route('admin-sekolah.school-data.majors.create') }}" class="font-bold underline">Tambah jurusan</a> dulu.
                            </p>
                        @endif
                        @error('school_major_id')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input
                                type="checkbox"
                                name="is_active"
                                id="is_active"
                                value="1"
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800"
                                @checked(old('is_active', '1') == '1')
                            >
                            <span class="text-xs font-medium text-slate-700 dark:text-slate-300">
                                Aktifkan kelas (dapat dipilih siswa saat mendaftar)
                            </span>
                        </label>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 transition hover:bg-blue-700 active:scale-[0.98]"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Simpan Kelas Baru</span>
                        </button>
                    </div>
                </form>

                {{-- TIPS CARD --}}
                <div class="border-t border-slate-100 bg-slate-50/60 p-4 dark:border-slate-800 dark:bg-slate-800/30">
                    <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">💡 Tips Format Nama Kelas:</p>
                    <p class="mt-1 text-[11px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        Gunakan pola <span class="font-bold text-slate-600 dark:text-slate-300">[Tingkat] [Kode Jurusan] [Nomor]</span>, contoh: <code class="rounded bg-slate-200/80 px-1 py-0.5 text-[10px] text-slate-700 dark:bg-slate-800 dark:text-slate-300">XII RPL 1</code> atau <code class="rounded bg-slate-200/80 px-1 py-0.5 text-[10px] text-slate-700 dark:bg-slate-800 dark:text-slate-300">XII TKJ 2</code>.
                    </p>
                </div>
            </div>
        </div>

        {{-- TABEL DAFTAR KELAS (2 COLUMNS) --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- FILTER & SEARCH CARD --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form method="GET" action="{{ route('admin-sekolah.school-data.classes.index') }}" class="flex flex-wrap items-center gap-3">
                    {{-- Search Input --}}
                    <div class="relative flex-1 min-w-[200px]">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama kelas..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2 pl-9 pr-3 text-xs text-slate-800 transition focus:border-blue-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-800"
                        >
                    </div>


                    {{-- Filter Jurusan --}}
                    <select
                        name="major_id"
                        class="rounded-xl border border-slate-200 bg-slate-50/50 py-2 px-3 text-xs text-slate-800 transition focus:border-blue-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-800"
                    >
                        <option value="">Semua Jurusan</option>
                        @foreach ($majors as $m)
                            <option value="{{ $m->id }}" @selected(request('major_id') == $m->id)>
                                {{ $m->code ? "{$m->code} — " : '' }}{{ $m->name }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="rounded-xl bg-slate-800 px-4 py-2 text-xs font-semibold text-white transition hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600"
                    >
                        Filter
                    </button>

                    @if (request()->hasAny(['search', 'grade', 'major_id']))
                        <a
                            href="{{ route('admin-sekolah.school-data.classes.index') }}"
                            class="text-xs font-medium text-slate-400 hover:text-rose-500"
                        >
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- TABEL LIST --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-between dark:border-slate-800 dark:bg-slate-800/30">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">
                        Daftar Seluruh Kelas
                    </h3>
                    <span class="text-xs text-slate-400">
                        Total: <strong class="text-slate-700 dark:text-slate-200">{{ $classes->total() }}</strong> kelas
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50 dark:border-slate-800 dark:bg-slate-800/50">
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">No</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Nama Kelas</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tingkat</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Jurusan</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                                <th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($classes as $class)
                                <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/30">
                                    <td class="px-5 py-3.5 text-xs text-slate-400">
                                        {{ $classes->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="font-bold text-slate-800 dark:text-white">{{ $class->name }}</div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if ($class->grade)
                                            <span class="rounded-lg bg-purple-50 px-2 py-0.5 text-xs font-bold text-purple-600 dark:bg-purple-500/10 dark:text-purple-400">
                                                Kelas {{ $class->grade }}
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if ($class->major)
                                            <div class="flex items-center gap-1.5">
                                                @if ($class->major->code)
                                                    <span class="rounded bg-blue-50 px-1.5 py-0.5 text-[11px] font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                                        {{ $class->major->code }}
                                                    </span>
                                                @endif
                                                <span class="text-xs text-slate-700 dark:text-slate-300 font-medium">
                                                    {{ $class->major->name }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">Tanpa Jurusan</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if ($class->is_active)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a
                                                href="{{ route('admin-sekolah.school-data.classes.edit', $class) }}"
                                                class="rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white"
                                            >
                                                Edit
                                            </a>
                                            <form
                                                method="POST"
                                                action="{{ route('admin-sekolah.school-data.classes.destroy', $class) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas \'{{ $class->name }}\'?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="rounded-lg border border-rose-200 bg-white px-2.5 py-1 text-xs font-semibold text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/30 dark:bg-transparent dark:text-rose-400 dark:hover:bg-rose-500/10"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <p class="text-xs font-medium">Belum ada kelas yang sesuai dengan filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($classes->hasPages())
                    <div class="border-t border-slate-100 px-5 py-3 dark:border-slate-800">
                        {{ $classes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.app>
