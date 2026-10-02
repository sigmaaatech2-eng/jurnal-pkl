<x-layouts.app title="Tambah Kelas">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-sekolah.dashboard') }}" class="hover:text-blue-600">Admin Sekolah</a>
                <span>/</span>
                <a href="{{ route('admin-sekolah.school-data.classes.index') }}" class="hover:text-blue-600">Kelas</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Tambah</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Tambah Kelas Baru</h1>
        </div>
        <a href="{{ route('admin-sekolah.school-data.classes.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
            ← Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-5 text-sm text-rose-800 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300">
            <div class="font-bold mb-2">Terdapat kesalahan:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="border-b border-slate-100 p-6 dark:border-slate-800">
                <h2 class="text-base font-bold text-slate-800 dark:text-white">Formulir Kelas</h2>
                <p class="mt-0.5 text-xs text-slate-400">Tambahkan kelas dan hubungkan dengan jurusan yang sesuai.</p>
            </div>
            <form method="POST" action="{{ route('admin-sekolah.school-data.classes.store') }}" class="space-y-5 p-6">
                @csrf

                {{-- Nama Kelas --}}
                <div>
                    <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Nama Kelas <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="Contoh: XII TKJ 1"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 @error('name') border-rose-500 @enderror"
                        required>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                {{-- Grid: Tingkat + Jurusan --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    {{-- Tingkat --}}
                    <div>
                        <label for="grade" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Tingkat Kelas (Khusus PKL)
                        </label>
                        <select name="grade" id="grade"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                            <option value="XII" selected>Kelas XII (Tingkat PKL / Kelas 12)</option>
                        </select>
                        <p class="mt-1 text-[11px] text-slate-400">Hanya kelas 12 yang melaksanakan program PKL.</p>
                    </div>

                    {{-- Jurusan --}}
                    <div>
                        <label for="school_major_id" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Jurusan
                        </label>
                        <select name="school_major_id" id="school_major_id"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                            <option value="">— Tanpa Jurusan —</option>
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}" @selected(old('school_major_id') == $major->id)>
                                    {{ $major->name }}{{ $major->code ? " ({$major->code})" : '' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($majors->isEmpty())
                            <p class="mt-1 text-xs text-amber-500">Belum ada jurusan.
                                <a href="{{ route('admin-sekolah.school-data.majors.create') }}" class="font-bold underline">Tambah jurusan dulu</a>.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Status --}}
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                        @checked(old('is_active', '1') == '1')>
                    <label for="is_active" class="text-sm font-medium text-slate-700 dark:text-slate-300">
                        Kelas aktif (ditampilkan sebagai pilihan di form pendaftaran)
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                    <a href="{{ route('admin-sekolah.school-data.classes.index') }}"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
