<x-layouts.app title="Tambah Akun Siswa">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-sekolah.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Admin Sekolah</a>
                <span>/</span>
                <a href="{{ route('admin-sekolah.students.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Data Siswa</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Tambah Akun Siswa</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Tambah Akun Siswa Baru
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Daftarkan akun siswa baru ke dalam sistem untuk persiapan penempatan kegiatan PKL.
            </p>
        </div>

        <div>
            <a
                href="{{ route('admin-sekolah.students.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <span>← Kembali ke Data Siswa</span>
            </a>
        </div>
    </div>

    {{-- VALIDATION ERROR ALERT --}}
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-5 text-sm text-rose-800 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300">
            <div class="flex items-center gap-2.5 font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-rose-600 dark:text-rose-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>Terdapat kesalahan pada formulir pendaftaran siswa:</span>
            </div>
            <ul class="mt-2.5 list-inside list-disc space-y-1 pl-1 text-xs sm:text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- MAIN GRID: FORM & INFORMATION SIDEBAR --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- FORM COLUMN (2 SPANS) --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 p-6 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-800 dark:text-white">
                                Formulir Akun Siswa Baru
                            </h2>
                            <p class="mt-0.5 text-xs text-slate-400">
                                Akun ini akan otomatis diberikan hak akses sebagai Siswa PKL.
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin-sekolah.students.store') }}" class="p-6 space-y-6">
                    @csrf

                    {{-- Nama Siswa --}}
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Nama Lengkap Siswa <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                placeholder="Contoh: Muhammad Farhan Maulana"
                                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 @error('name') border-rose-500 @enderror"
                                required
                            >
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email Siswa --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Alamat Email Siswa <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="Contoh: siswa.farhan@sekolah.sch.id / siswa@gmail.com"
                                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 @error('email') border-rose-500 @enderror"
                                required
                            >
                        </div>
                        <p class="mt-1 text-[11px] text-slate-400 dark:text-slate-500">
                            Email aktif ini akan dipakai oleh siswa untuk masuk ke portal jurnal PKL.
                        </p>
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jurusan & Kelas --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Jurusan --}}
                        <div>
                            <label for="jurusan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                Jurusan Siswa <span class="text-rose-500">*</span>
                            </label>
                            <select
                                name="jurusan"
                                id="jurusan"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                required
                            >
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="Rekayasa Perangkat Lunak (RPL)" {{ old('jurusan') === 'Rekayasa Perangkat Lunak (RPL)' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                                <option value="Teknik Komputer dan Jaringan (TKJ)" {{ old('jurusan') === 'Teknik Komputer dan Jaringan (TKJ)' ? 'selected' : '' }}>Teknik Komputer dan Jaringan (TKJ)</option>
                                <option value="Desain Komunikasi Visual (DKV)" {{ old('jurusan') === 'Desain Komunikasi Visual (DKV)' ? 'selected' : '' }}>Desain Komunikasi Visual (DKV)</option>
                                <option value="Akuntansi dan Keuangan Lembaga (AKL)" {{ old('jurusan') === 'Akuntansi dan Keuangan Lembaga (AKL)' ? 'selected' : '' }}>Akuntansi dan Keuangan Lembaga (AKL)</option>
                                <option value="Otomatisasi dan Tata Kelola Perkantoran (OTKP)" {{ old('jurusan') === 'Otomatisasi dan Tata Kelola Perkantoran (OTKP)' ? 'selected' : '' }}>Otomatisasi & Tata Kelola Perkantoran (OTKP)</option>
                                <option value="Teknik Kendaraan Ringan (TKR)" {{ old('jurusan') === 'Teknik Kendaraan Ringan (TKR)' ? 'selected' : '' }}>Teknik Kendaraan Ringan (TKR)</option>
                            </select>
                            @error('jurusan')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kelas --}}
                        <div>
                            <label for="kelas" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                Kelas
                            </label>
                            <input
                                type="text"
                                name="kelas"
                                id="kelas"
                                value="{{ old('kelas', 'XII') }}"
                                placeholder="Contoh: XII RPL 1"
                                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500"
                            >
                            @error('kelas')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Kata Sandi & Konfirmasi --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Password --}}
                        <div>
                            <label for="password" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Minimal 8 karakter"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 @error('password') border-rose-500 @enderror"
                                    required
                                >
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    placeholder="Ketik ulang kata sandi"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    {{-- INFORMASI ROLE OTOMATIS --}}
                    <div class="rounded-xl border border-blue-100 bg-blue-50/60 p-4 dark:border-blue-500/20 dark:bg-blue-500/10">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div class="text-xs text-blue-900 dark:text-blue-300">
                                Akun ini akan otomatis ditetapkan dengan peran <strong>Siswa</strong>. Setelah akun dibuat, Anda dapat langsung mengatur penempatan PKL untuk siswa ini.
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
                        <a
                            href="{{ route('admin-sekolah.students.index') }}"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                        >
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 active:scale-95"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Simpan Akun Siswa</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- SIDEBAR GUIDANCE COLUMN (1 SPAN) --}}
        <div class="space-y-6">

            {{-- ALUR SELANJUTNYA --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Alur Pasca Registrasi</h3>
                        <p class="text-xs text-slate-400">Langkah penempatan siswa</p>
                    </div>
                </div>

                <div class="mt-5 space-y-4 text-xs text-slate-600 dark:text-slate-300">
                    <div class="flex items-start gap-3">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[11px] font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">1</span>
                        <div>
                            <span class="font-bold text-slate-800 dark:text-white">Buat Akun Siswa:</span>
                            Akun berhasil terdaftar dan siap untuk diberikan penempatan PKL.
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[11px] font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">2</span>
                        <div>
                            <span class="font-bold text-slate-800 dark:text-white">Atur Penempatan PKL:</span>
                            Buka menu Penempatan PKL untuk menugaskan tempat PKL, Guru Pembimbing, dan Mentor.
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[11px] font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">3</span>
                        <div>
                            <span class="font-bold text-slate-800 dark:text-white">Mulai Kegiatan PKL:</span>
                            Siswa dapat masuk ke sistem untuk mengisi jurnal dan mencatat absensi harian.
                        </div>
                    </div>
                </div>
            </div>

            {{-- STANDAR KEAMANAN --}}
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900/40">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Standar Kata Sandi Siswa
                </h4>
                <ul class="mt-2.5 space-y-1.5 text-xs text-slate-500 dark:text-slate-400 list-disc list-inside">
                    <li>Minimal terdiri dari 8 karakter</li>
                    <li>Siswa dapat mengubah kata sandi secara mandiri setelah login</li>
                    <li>Pastikan siswa mencatat email dan kata sandi yang telah dibuat</li>
                </ul>
            </div>

        </div>

    </div>

</x-layouts.app>
