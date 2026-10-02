<x-layouts.app title="Tambah Subscriber & Admin Sekolah">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
                <span>/</span>
                <a href="{{ route('admin-platform.schools.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Subscriber Sekolah</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Tambah Sekolah & Admin</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Pendaftaran Klien Sekolah Baru
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Daftarkan institusi sekolah baru, pilih paket langganan, dan aktifkan akun Admin Sekolah.
            </p>
        </div>

        <div>
            <a
                href="{{ route('admin-platform.schools.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- FORM --}}
    <form action="{{ route('admin-platform.schools.store') }}" method="POST" class="space-y-8">
        @csrf

        {{-- BAGIAN 1: INFORMASI SEKOLAH --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4 dark:border-slate-800">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                    1
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white">Informasi Institusi Sekolah</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Data profil sekolah yang berlangganan platform.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                {{-- Nama Sekolah --}}
                <div class="sm:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Nama Resmi Sekolah <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="school_name"
                        value="{{ old('school_name') }}"
                        required
                        placeholder="Contoh: SMK Negeri 1 Jakarta"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                    >
                    @error('school_name')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Sekolah --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Email Kontak Sekolah <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="school_email"
                        value="{{ old('school_email') }}"
                        required
                        placeholder="info@smkn1jakarta.sch.id"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                    >
                    @error('school_email')
                        <p class="mt-1 text-rose-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Telepon Sekolah --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        No. Telepon / WhatsApp Sekolah
                    </label>
                    <input
                        type="text"
                        name="school_phone"
                        value="{{ old('school_phone') }}"
                        placeholder="081234567890"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                    >
                    @error('school_phone')
                        <p class="mt-1 text-rose-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat Sekolah --}}
                <div class="sm:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Alamat Lengkap Sekolah
                    </label>
                    <textarea
                        name="school_address"
                        rows="2"
                        placeholder="Jl. Budi Utomo No. 7, Jakarta Pusat"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                    >{{ old('school_address') }}</textarea>
                </div>
            </div>
        </div>

        {{-- BAGIAN 2: PILIH PAKET LANGGANAN --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4 dark:border-slate-800">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 font-bold text-purple-600 dark:bg-purple-500/20 dark:text-purple-400">
                    2
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white">Pilihan Paket Langganan</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Pilih paket komersial yang dipesan oleh sekolah klien.</p>
                </div>
            </div>

            @error('package_id')
                <p class="mb-4 text-xs font-semibold text-rose-500">{{ $message }}</p>
            @enderror

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                @foreach ($packages as $pkg)
                    <label class="relative flex cursor-pointer flex-col justify-between rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition hover:border-purple-400 dark:border-slate-800 dark:bg-slate-950/50 dark:hover:border-purple-500 [&:has(input:checked)]:border-purple-600 [&:has(input:checked)]:bg-purple-50/40 dark:[&:has(input:checked)]:border-purple-500 dark:[&:has(input:checked)]:bg-purple-500/10">
                        <input
                            type="radio"
                            name="package_id"
                            value="{{ $pkg->id }}"
                            class="sr-only"
                            {{ old('package_id') == $pkg->id || $loop->first ? 'checked' : '' }}
                        >
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-extrabold uppercase tracking-wider text-purple-600 dark:text-purple-400">
                                    {{ $pkg->name }}
                                </span>
                                <span class="rounded-full bg-slate-200/60 px-2.5 py-0.5 text-[10px] font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $pkg->duration_months }} Bulan
                                </span>
                            </div>

                            <div class="mt-3 text-2xl font-black text-slate-800 dark:text-white">
                                {{ $pkg->price_formatted }}
                            </div>

                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                {{ $pkg->description }}
                            </p>

                            <div class="mt-4 space-y-2 border-t border-slate-200/60 pt-4 text-xs dark:border-slate-800">
                                <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                                    <span>Kuota Siswa PKL:</span>
                                    <span class="font-bold text-slate-800 dark:text-white">{{ $pkg->max_students }} Siswa</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                                    <span>Kuota Guru Pembimbing:</span>
                                    <span class="font-bold text-slate-800 dark:text-white">{{ $pkg->max_teachers }} Guru</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                                    <span>Kuota Mentor Industri:</span>
                                    <span class="font-bold text-slate-800 dark:text-white">{{ $pkg->max_mentors }} Mentor</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2 text-xs font-bold text-purple-600 dark:text-purple-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Pilih Paket Ini</span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- BAGIAN 3: AKUN ADMIN SEKOLAH --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4 dark:border-slate-800">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 font-bold text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400">
                    3
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white">Akun Admin Sekolah (Login Utama)</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Akun pengelola utama sekolah untuk memulai konfigurasi.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                {{-- Nama Admin --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Nama Lengkap Admin Sekolah <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="admin_name"
                        value="{{ old('admin_name') }}"
                        required
                        placeholder="Contoh: Pak Budi Admin"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                    >
                    @error('admin_name')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Login Admin --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Email Login Admin <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="admin_email"
                        value="{{ old('admin_email') }}"
                        required
                        placeholder="admin@smkn1jakarta.sch.id"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                    >
                    @error('admin_email')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Admin --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Password Login Admin <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        name="admin_password"
                        required
                        placeholder="Minimal 6 karakter"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                    >
                    @error('admin_password')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- SUBMIT BUTTON --}}
        <div class="flex items-center justify-end gap-3 pt-4">
            <a
                href="{{ route('admin-platform.schools.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300"
            >
                Batal
            </a>
            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/25 transition hover:bg-emerald-700 active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Aktifkan Langganan & Buat Akun Admin Sekolah</span>
            </button>
        </div>
    </form>

</x-layouts.app>
