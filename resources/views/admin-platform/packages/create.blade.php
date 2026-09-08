<x-layouts.app :title="'Tambah Paket - Admin Platform'">
    <div class="max-w-3xl space-y-6">

        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('admin-platform.packages.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Kelola Paket</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <span class="font-semibold text-slate-800 dark:text-white">Tambah Paket Baru</span>
        </nav>

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Tambah Paket Langganan Baru</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tentukan kuota pengguna, masa aktif, harga, dan fitur paket untuk sekolah.</p>
        </div>

        <form action="{{ route('admin-platform.packages.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Nama Paket <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 {{ $errors->has('name') ? 'border-rose-400' : '' }}"
                        placeholder="Contoh: Paket Starter, Paket Profesional">
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Deskripsi Paket</label>
                    <textarea name="description" rows="3"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                        placeholder="Penjelasan ringkas peruntukan paket ini...">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Harga Paket (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price', 0) }}" min="0" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                        @error('price') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Durasi (Bulan) <span class="text-rose-500">*</span></label>
                        <input type="number" name="duration_months" value="{{ old('duration_months', 12) }}" min="1" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Maks. Siswa <span class="text-rose-500">*</span></label>
                        <input type="number" name="max_students" value="{{ old('max_students', 50) }}" min="1" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Maks. Guru <span class="text-rose-500">*</span></label>
                        <input type="number" name="max_teachers" value="{{ old('max_teachers', 10) }}" min="1" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Maks. Mentor <span class="text-rose-500">*</span></label>
                        <input type="number" name="max_mentors" value="{{ old('max_mentors', 20) }}" min="1" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                    </div>
                </div>

                {{-- FEATURES LIST --}}
                <div x-data="{ features: {{ json_encode(old('features', [''])) }} }">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Daftar Fitur Unggulan</label>
                    <div class="space-y-2">
                        <template x-for="(feat, idx) in features" :key="idx">
                            <div class="flex items-center gap-2">
                                <input type="text" :name="'features[' + idx + ']'" x-model="features[idx]"
                                    placeholder="Contoh: Jurnal Harian Online, Absensi Geotagging"
                                    class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                                <button type="button" @click="features.splice(idx, 1)" x-show="features.length > 1"
                                    class="rounded-xl p-2.5 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition dark:hover:bg-rose-500/10 dark:hover:text-rose-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="features.push('')"
                        class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tambah Fitur Lain
                    </button>
                </div>

            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 hover:bg-blue-700 active:scale-95 transition">
                    Simpan Paket
                </button>
                <a href="{{ route('admin-platform.packages.index') }}"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                    Batal
                </a>
            </div>
        </form>

    </div>
</x-layouts.app>
