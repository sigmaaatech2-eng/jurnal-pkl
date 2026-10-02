<x-layouts.app title="Edit Jurusan">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-sekolah.dashboard') }}" class="hover:text-blue-600">Admin Sekolah</a>
                <span>/</span>
                <a href="{{ route('admin-sekolah.school-data.majors.index') }}" class="hover:text-blue-600">Jurusan</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Edit</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Edit Jurusan</h1>
        </div>
        <a href="{{ route('admin-sekolah.school-data.majors.index') }}"
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
                <h2 class="text-base font-bold text-slate-800 dark:text-white">Edit: {{ $major->name }}</h2>
            </div>
            <form method="POST" action="{{ route('admin-sekolah.school-data.majors.update', $major) }}" class="space-y-5 p-6">
                @csrf @method('PUT')

                <div>
                    <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Nama Jurusan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $major->name) }}"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 @error('name') border-rose-500 @enderror"
                        required>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="code" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Kode / Singkatan
                    </label>
                    <input type="text" name="code" id="code" value="{{ old('code', $major->code) }}"
                        placeholder="Contoh: TKJ, RPL"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                </div>

                <div>
                    <label for="description" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">{{ old('description', $major->description) }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                        @checked(old('is_active', $major->is_active))>
                    <label for="is_active" class="text-sm font-medium text-slate-700 dark:text-slate-300">
                        Jurusan aktif
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                    <a href="{{ route('admin-sekolah.school-data.majors.index') }}"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
