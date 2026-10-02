<x-layouts.app title="Atur Penempatan PKL">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-sekolah.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Admin Sekolah</a>
                <span>/</span>
                <a href="{{ route('admin-sekolah.internships.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Penempatan PKL</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Tambah Penempatan</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Atur Penempatan PKL Siswa
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Tetapkan siswa ke mitra instansi/perusahaan PKL, tunjuk guru pembimbing sekolah, dan tentukan mentor lapangan.
            </p>
        </div>

        <div>
            <a
                href="{{ route('admin-sekolah.internships.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <span>← Kembali ke Daftar PKL</span>
            </a>
        </div>
    </div>

    {{-- VALIDATION ERROR ALERT --}}
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-5 text-sm text-rose-800 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300 shadow-sm">
            <div class="flex items-center gap-2.5 font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-rose-600 dark:text-rose-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>Terdapat kesalahan pada formulir penempatan:</span>
            </div>
            <ul class="mt-2.5 list-inside list-disc space-y-1 text-xs sm:text-sm pl-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM PENEMPATAN PKL --}}
    <div class="max-w-4xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="border-b border-slate-100 p-6 dark:border-slate-800">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">
                Formulir Penugasan & Pelaksanaan PKL
            </h2>
            <p class="mt-0.5 text-xs text-slate-400">
                Pastikan data siswa, pembimbing, dan mitra perusahaan sudah sesuai dengan surat keputusan penempatan PKL.
            </p>
        </div>

        <form action="{{ route('admin-sekolah.internships.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{-- 1. PILIH SISWA --}}
            <div>
                <label for="student_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Pilih Siswa <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select
                        id="student_id"
                        name="student_id"
                        required
                        class="w-full rounded-xl border {{ $errors->has('student_id') ? 'border-rose-300 ring-2 ring-rose-500/10' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                    >
                        <option value="">-- Pilih Siswa PKL --</option>
                        @foreach ($students as $student)
                            <option
                                value="{{ $student->id }}"
                                {{ (old('student_id', $selectedStudentId) == $student->id) ? 'selected' : '' }}
                            >
                                {{ $student->name }} — ({{ $student->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-1 text-xs text-slate-400">
                    Siswa tidak boleh memiliki lebih dari satu penempatan PKL berstatus Aktif secara bersamaan.
                </p>
            </div>

            {{-- 2. PILIH PEMBIMBING & MENTOR (2 KOLOM) --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                {{-- Guru Pembimbing --}}
                <div>
                    <label for="teacher_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Guru Pembimbing Sekolah <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="teacher_id"
                        name="teacher_id"
                        required
                        class="w-full rounded-xl border {{ $errors->has('teacher_id') ? 'border-rose-300 ring-2 ring-rose-500/10' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                    >
                        <option value="">-- Pilih Guru Pembimbing --</option>
                        @foreach ($teachers as $teacher)
                            <option
                                value="{{ $teacher->id }}"
                                {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}
                            >
                                {{ $teacher->name }} — ({{ $teacher->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-400">
                        Hanya menampilkan akun dengan role Guru Pembimbing.
                    </p>
                </div>

                {{-- Mentor Lapangan --}}
                <div>
                    <label for="mentor_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Mentor DUDI / Tempat PKL <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="mentor_id"
                        name="mentor_id"
                        required
                        class="w-full rounded-xl border {{ $errors->has('mentor_id') ? 'border-rose-300 ring-2 ring-rose-500/10' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                    >
                        <option value="">-- Pilih Mentor Perusahaan --</option>
                        @foreach ($mentors as $mentor)
                            <option
                                value="{{ $mentor->id }}"
                                {{ old('mentor_id') == $mentor->id ? 'selected' : '' }}
                            >
                                {{ $mentor->name }} — ({{ $mentor->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-400">
                        Mentor yang bertugas memvalidasi dan menilai jurnal harian siswa di tempat PKL.
                    </p>
                </div>
            </div>

            {{-- 3. TEMPAT PKL & ALAMAT --}}
            <div class="space-y-4">
                <div>
                    <label for="company_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Nama Perusahaan / Tempat PKL <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="company_name"
                        name="company_name"
                        value="{{ old('company_name') }}"
                        required
                        placeholder="Contoh: PT Telkom Indonesia Tbk / CV Digital Kreatif"
                        class="w-full rounded-xl border {{ $errors->has('company_name') ? 'border-rose-300 ring-2 ring-rose-500/10' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                    >
                </div>

                <div>
                    <label for="company_address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Alamat Lengkap Tempat PKL <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        id="company_address"
                        name="company_address"
                        rows="3"
                        required
                        placeholder="Masukkan alamat lengkap instansi, kota, dan patokan lokasi..."
                        class="w-full rounded-xl border {{ $errors->has('company_address') ? 'border-rose-300 ring-2 ring-rose-500/10' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                    >{{ old('company_address') }}</textarea>
                </div>
            </div>

            {{-- 4. PERIODE PKL & STATUS (3 KOLOM) --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                {{-- Tanggal Mulai --}}
                <div>
                    <label for="start_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Tanggal Mulai <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                        required
                        class="w-full rounded-xl border {{ $errors->has('start_date') ? 'border-rose-300 ring-2 ring-rose-500/10' : 'border-slate-200' }} bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                    >
                </div>

                {{-- Tanggal Selesai --}}
                <div>
                    <label for="end_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Tanggal Selesai <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        required
                        class="w-full rounded-xl border {{ $errors->has('end_date') ? 'border-rose-300 ring-2 ring-rose-500/10' : 'border-slate-200' }} bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                    >
                </div>

                {{-- Status Penempatan --}}
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Status Penempatan <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                    >
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                            Aktif (Sedang Berjalan)
                        </option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>
            </div>

            {{-- TOMBOL SIMPAN & BATAL --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <a
                    href="{{ route('admin-sekolah.internships.index') }}"
                    class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700 active:scale-95"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    <span>Simpan Penempatan PKL</span>
                </button>
            </div>

        </form>
    </div>

</x-layouts.app>
