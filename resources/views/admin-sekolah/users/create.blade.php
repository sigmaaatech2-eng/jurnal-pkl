<x-layouts.app title="Tambah Pengguna Baru">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-sekolah.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Admin Sekolah</a>
                <span>/</span>
                <a href="{{ route('admin-sekolah.users.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Manajemen Pengguna</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Tambah Akun</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Tambah Akun Pengguna
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Buat akun pengguna baru untuk siswa, guru pembimbing, mentor industri, atau kepala sekolah.
            </p>
        </div>

        <div>
            <a
                href="{{ route('admin-sekolah.users.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <span>← Kembali ke Daftar</span>
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
                <span>Terdapat kesalahan pada input:</span>
            </div>
            <ul class="mt-2.5 list-inside list-disc space-y-1 pl-1 text-xs sm:text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- MAIN GRID: FORM & GUIDANCE --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- FORM COLUMN (2 SPANS) --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 p-6 dark:border-slate-800">
                    <h2 class="text-base font-bold text-slate-800 dark:text-white">
                        Formulir Registrasi Pengguna
                    </h2>
                    <p class="mt-0.5 text-xs text-slate-400">
                        Isi identitas akun pengguna dan tentukan hak akses peran yang sesuai.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin-sekolah.users.store') }}" class="p-6 space-y-6">
                    @csrf

                    {{-- 1. IDENTITAS AKUN --}}
                    <div class="space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            1. Identitas Akun
                        </h3>

                        {{-- Nama Lengkap --}}
                        <div>
                            <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                Nama Lengkap <span class="text-rose-500">*</span>
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
                                    placeholder="Contoh: Muhammad Farhan / Bpk. Rudi Hartono"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 @error('name') border-rose-500 @enderror"
                                    required
                                >
                            </div>
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                Alamat Email <span class="text-rose-500">*</span>
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
                                    placeholder="Contoh: user@sekolah.sch.id / guru@gmail.com"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 @error('email') border-rose-500 @enderror"
                                    required
                                >
                            </div>
                            <p class="mt-1 text-[11px] text-slate-400">Digunakan untuk autentikasi login ke dalam sistem jurnal PKL.</p>
                            @error('email')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5 dark:border-slate-800"></div>

                    {{-- 2. PILIHAN PERAN (ROLE) --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                2. Peran & Hak Akses Pengguna <span class="text-rose-500">*</span>
                            </h3>
                        </div>

                        {{-- RADIO CARDS FOR ROLES --}}
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            {{-- Siswa --}}
                            <label class="relative flex cursor-pointer rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50 has-[:checked]:ring-2 has-[:checked]:ring-blue-500/20 dark:has-[:checked]:border-blue-500 dark:has-[:checked]:bg-blue-500/10">
                                <input type="radio" name="role" value="siswa" class="sr-only" @checked(old('role', 'siswa') === 'siswa')>
                                <div class="flex items-start gap-3 w-full">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-slate-800 dark:text-white text-sm">Siswa PKL</span>
                                            <span class="inline-block h-2 w-2 rounded-full bg-blue-500"></span>
                                        </div>
                                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                            Mengisi jurnal kegiatan harian dan log presensi PKL.
                                        </p>
                                    </div>
                                </div>
                            </label>

                            {{-- Guru Pembimbing --}}
                            <label class="relative flex cursor-pointer rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-emerald-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/50 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20 dark:has-[:checked]:border-emerald-500 dark:has-[:checked]:bg-emerald-500/10">
                                <input type="radio" name="role" value="guru_pembimbing" class="sr-only" @checked(old('role') === 'guru_pembimbing')>
                                <div class="flex items-start gap-3 w-full">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-slate-800 dark:text-white text-sm">Guru Pembimbing</span>
                                            <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                                        </div>
                                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                            Memonitor kegiatan PKL, presensi, dan perkembangan siswa bimbingan.
                                        </p>
                                    </div>
                                </div>
                            </label>

                            {{-- Mentor Industri --}}
                            <label class="relative flex cursor-pointer rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-purple-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/50 has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50/50 has-[:checked]:ring-2 has-[:checked]:ring-purple-500/20 dark:has-[:checked]:border-purple-500 dark:has-[:checked]:bg-purple-500/10">
                                <input type="radio" name="role" value="mentor" class="sr-only" @checked(old('role') === 'mentor')>
                                <div class="flex items-start gap-3 w-full">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-slate-800 dark:text-white text-sm">Mentor DUDI</span>
                                            <span class="inline-block h-2 w-2 rounded-full bg-purple-500"></span>
                                        </div>
                                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                            Validasi jurnal harian, catatan revisi, dan penilaian kerja industri.
                                        </p>
                                    </div>
                                </div>
                            </label>

                            {{-- Kepala Sekolah --}}
                            <label class="relative flex cursor-pointer rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-amber-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/50 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/50 has-[:checked]:ring-2 has-[:checked]:ring-amber-500/20 dark:has-[:checked]:border-amber-500 dark:has-[:checked]:bg-amber-500/10">
                                <input type="radio" name="role" value="kepala_sekolah" class="sr-only" @checked(old('role') === 'kepala_sekolah')>
                                <div class="flex items-start gap-3 w-full">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-slate-800 dark:text-white text-sm">Kepala Sekolah</span>
                                            <span class="inline-block h-2 w-2 rounded-full bg-amber-500"></span>
                                        </div>
                                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                            Melihat laporan eksekutif, rekapitulasi nilai, dan statistik PKL.
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('role')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100 pt-5 dark:border-slate-800"></div>

                    {{-- 3. KEAMANAN & KATA SANDI --}}
                    <div class="space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            3. Keamanan Akun
                        </h3>

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
                                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 @error('password') border-rose-500 @enderror"
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
                                    Ulangi Kata Sandi <span class="text-rose-500">*</span>
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
                                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
                        <a
                            href="{{ route('admin-sekolah.users.index') }}"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                        >
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 active:scale-95"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Simpan Akun Pengguna</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- SIDEBAR GUIDANCE COLUMN (1 SPAN) --}}
        <div class="space-y-6">

            {{-- PANDUAN PERAN --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Panduan Hak Akses</h3>
                        <p class="text-xs text-slate-400">Tanggung jawab tiap peran</p>
                    </div>
                </div>

                <div class="mt-5 space-y-3.5 text-xs text-slate-600 dark:text-slate-300">
                    <div class="flex items-start gap-2.5">
                        <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                        <div>
                            <span class="font-bold text-slate-800 dark:text-white">Siswa PKL:</span>
                            Hanya dapat mengakses portal jurnal siswa, riwayat presensi, dan status validasi.
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-emerald-500"></span>
                        <div>
                            <span class="font-bold text-slate-800 dark:text-white">Guru Pembimbing:</span>
                            Dapat memantau jurnal, absensi siswa bimbingannya, dan mencetak rekap.
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-purple-500"></span>
                        <div>
                            <span class="font-bold text-slate-800 dark:text-white">Mentor DUDI:</span>
                            Mempunyai wewenang menyetujui atau meminta revisi jurnal siswa magang di industrinya.
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-amber-500"></span>
                        <div>
                            <span class="font-bold text-slate-800 dark:text-white">Kepala Sekolah:</span>
                            Akses dashboard laporan rekapitulasi, monitoring, dan analisis keseluruhan.
                        </div>
                    </div>
                </div>
            </div>

            {{-- PETUNJUK KEAMANAN KATA SANDI --}}
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900/40">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Standar Kata Sandi
                </h4>
                <ul class="mt-2.5 space-y-1.5 text-xs text-slate-500 dark:text-slate-400 list-disc list-inside">
                    <li>Minimal terdiri dari 8 karakter</li>
                    <li>Disarankan kombinasi huruf besar, huruf kecil, dan angka</li>
                    <li>Pengguna dapat mengubah kata sandi setelah login pertama kali</li>
                </ul>
            </div>

        </div>

    </div>

</x-layouts.app>