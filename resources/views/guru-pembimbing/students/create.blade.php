<x-layouts.app title="Tambah Siswa Bimbingan">

    {{-- HEADER --}}
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2">
                <a
                    href="{{ route('guru-pembimbing.students.index') }}"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                >
                    ← Siswa Bimbingan
                </a>
                <span class="text-xs text-slate-400">/</span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Tambah Siswa</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Tambah Siswa Bimbingan
            </h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Pilih siswa yang sudah terdaftar dan lengkapi data tempat PKL untuk memulai bimbingan.
            </p>
        </div>

        <a
            href="{{ route('guru-pembimbing.students.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
        >
            <span>Batal</span>
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">

        {{-- ALERT JIKA SEMUA SISWA SUDAH MEMILIKI PKL AKTIF --}}
        @if ($students->isEmpty())
            <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="font-semibold">Semua siswa sudah memiliki kegiatan PKL aktif</p>
                        <p class="mt-1 text-xs text-amber-700 dark:text-amber-400">
                            Tidak ada siswa tanpa PKL aktif yang tersedia untuk ditambahkan saat ini. Pastikan siswa telah membuat akun atau menyelesaikan PKL sebelumnya.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- GLOBAL ERROR ALERT --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300">
                <p class="font-semibold">Mohon periksa kembali form berikut:</p>
                <ul class="mt-1.5 list-inside list-disc text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru-pembimbing.students.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- 1. PILIH SISWA --}}
            <div>
                <label for="student_id" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Siswa Bimbingan <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select
                        name="student_id"
                        id="student_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:[color-scheme:dark] dark:focus:border-blue-400 dark:focus:ring-blue-400/20"
                    >
                        <option value="" class="bg-white text-slate-800 dark:bg-slate-800 dark:text-slate-100">-- Pilih Siswa (Role Siswa) --</option>
                        @foreach ($students as $student)
                            <option
                                value="{{ $student->id }}"
                                class="bg-white text-slate-800 dark:bg-slate-800 dark:text-slate-100"
                                {{ old('student_id') == $student->id ? 'selected' : '' }}
                            >
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                    Hanya menampilkan siswa terdaftar yang belum memiliki kegiatan PKL aktif.
                </p>
                @error('student_id')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 2. TEMPAT PKL --}}
            <div>
                <label for="company_name" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Nama Tempat PKL (Instansi / Perusahaan) <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    name="company_name"
                    id="company_name"
                    value="{{ old('company_name') }}"
                    required
                    placeholder="Contoh: PT Telekomunikasi Indonesia, Tbk"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-400/20"
                >
                @error('company_name')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3. ALAMAT PKL --}}
            <div>
                <label for="company_address" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Alamat Tempat PKL <span class="text-rose-500">*</span>
                </label>
                <textarea
                    name="company_address"
                    id="company_address"
                    rows="3"
                    required
                    placeholder="Alamat lengkap instansi/perusahaan tempat siswa bertugas..."
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-400/20"
                >{{ old('company_address') }}</textarea>
                @error('company_address')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 4. PILIH MENTOR (OPSIONAL) --}}
            <div>
                <label for="mentor_id" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                    Mentor (Pembimbing Lapangan / DUDI)
                </label>
                <select
                    name="mentor_id"
                    id="mentor_id"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:[color-scheme:dark] dark:focus:border-blue-400 dark:focus:ring-blue-400/20"
                >
                    <option value="" class="bg-white text-slate-800 dark:bg-slate-800 dark:text-slate-100">-- Pilih Mentor Lapangan (Opsional) --</option>
                    @foreach ($mentors as $mentor)
                        <option
                            value="{{ $mentor->id }}"
                            class="bg-white text-slate-800 dark:bg-slate-800 dark:text-slate-100"
                            {{ old('mentor_id') == $mentor->id ? 'selected' : '' }}
                        >
                            {{ $mentor->name }} ({{ $mentor->email }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                    Pilih user dengan role mentor jika pihak tempat PKL sudah mendaftarkan pembimbing lapangan.
                </p>
                @error('mentor_id')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 5 & 6. PERIODE PKL --}}
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="start_date" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                        Tanggal Mulai PKL <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ old('start_date', now()->toDateString()) }}"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:[color-scheme:dark] dark:focus:border-blue-400 dark:focus:ring-blue-400/20"
                    >
                    @error('start_date')
                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-200">
                        Tanggal Selesai PKL <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        value="{{ old('end_date', now()->addMonths(3)->toDateString()) }}"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:[color-scheme:dark] dark:focus:border-blue-400 dark:focus:ring-blue-400/20"
                    >
                    @error('end_date')
                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 7. STATUS PKL --}}
            <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-200">
                            Status Kegiatan PKL
                        </p>
                        <p class="text-xs text-slate-400">
                            Siswa akan langsung terdaftar dengan status PKL aktif.
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Active
                    </span>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex items-center justify-end gap-3 pt-4">
                <a
                    href="{{ route('guru-pembimbing.students.index') }}"
                    class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    @disabled($students->isEmpty())
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:translate-y-0"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Simpan Siswa Bimbingan</span>
                </button>
            </div>

        </form>

    </div>

</x-layouts.app>
