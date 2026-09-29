<x-layouts.app title="Detail Jurnal – {{ $journal->title }}">

    {{-- BREADCRUMB & BACK BUTTON --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('mentor.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Mentor</a>
                <span>/</span>
                <a href="{{ route('mentor.students.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Daftar Siswa</a>
                <span>/</span>
                <a href="{{ route('mentor.students.show', $journal->internship) }}" class="hover:text-blue-600 dark:hover:text-blue-400">Jurnal Siswa</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Detail</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Detail Jurnal Harian
            </h1>
        </div>

        <div>
            <a
                href="{{ route('mentor.students.show', $journal->internship) }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Jurnal Siswa</span>
            </a>
        </div>
    </div>

    {{-- NOTIFIKASI SUCCESS & ERROR --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300">
            <div class="flex items-center gap-2 font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>Terdapat kendala pada input:</span>
            </div>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3" x-data="{ revisionModalOpen: false }">

        {{-- KOLOM KIRI & TENGAH: DETAIL JURNAL & DOKUMENTASI --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- CARD KONTEN UTAMA JURNAL --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                {{-- Header Jurnal --}}
                <div class="border-b border-slate-100 p-6 dark:border-slate-800">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('l, d F Y') }}
                            </span>
                            <h2 class="mt-1 text-xl font-bold text-slate-800 dark:text-white">
                                {{ $journal->title }}
                            </h2>
                        </div>
                        <div>
                            @if ($journal->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Validasi
                                </span>
                            @elseif ($journal->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Valid (Disetujui)
                                </span>
                            @elseif ($journal->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3.5 py-1 text-xs font-semibold text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                    Perlu Revisi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Deskripsi Kegiatan --}}
                <div class="p-6">
                    <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                        Deskripsi Kegiatan yang Dilakukan
                    </h3>
                    <div class="prose prose-slate max-w-none text-sm leading-relaxed text-slate-700 dark:prose-invert dark:text-slate-300">
                        {!! nl2br(e($journal->description)) !!}
                    </div>

                    {{-- Link Proyek / Tugas --}}
                    @if ($journal->link)
                        <div class="mt-6 border-t border-slate-100 pt-5 dark:border-slate-800">
                            <h3 class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Link Proyek / Tugas Siswa
                            </h3>
                            <div class="flex items-center justify-between gap-3 rounded-xl border border-blue-200 bg-blue-50/60 p-4 dark:border-blue-500/20 dark:bg-blue-500/10">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                        </svg>
                                    </div>
                                    <div class="truncate">
                                        <p class="truncate text-sm font-semibold text-slate-800 dark:text-white">
                                            {{ $journal->link }}
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            Tautan eksternal proyek/tugas dari siswa.
                                        </p>
                                    </div>
                                </div>
                                <a
                                    href="{{ $journal->link }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700"
                                >
                                    <span>Buka Tautan</span>
                                    <span>↗</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Dokumentasi & Lampiran File --}}
                <div class="border-t border-slate-100 p-6 dark:border-slate-800">
                    <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                        Dokumentasi & Lampiran File Siswa
                    </h3>
                    @if ($journal->attachment)
                        @php
                            $extension = strtolower(pathinfo($journal->attachment, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                            $isZip = $extension === 'zip';
                        @endphp

                        @if ($isImage)
                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-800/40">
                                <a
                                    href="{{ asset('storage/' . $journal->attachment) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="group block relative"
                                >
                                    <img
                                        src="{{ asset('storage/' . $journal->attachment) }}"
                                        alt="Dokumentasi Jurnal {{ $journal->title }}"
                                        class="max-h-96 w-full object-contain transition group-hover:opacity-95"
                                        onerror="this.parentElement.innerHTML='<div class=\'p-8 text-center text-sm text-slate-400\'>Lampiran foto tidak dapat dimuat atau path belum tersedia.</div>'"
                                    >
                                    <div class="absolute bottom-3 right-3 flex items-center gap-1.5 rounded-lg bg-slate-900/80 px-3 py-1.5 text-xs font-medium text-white backdrop-blur transition group-hover:bg-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        <span>Buka Ukuran Penuh</span>
                                    </div>
                                </a>
                            </div>
                        @else
                            <a
                                href="{{ asset('storage/' . $journal->attachment) }}"
                                target="_blank"
                                download
                                class="flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800"
                            >
                                @if ($isZip)
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-100 font-extrabold text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                                        ZIP
                                    </div>
                                @else
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v2.625a3.375 3.375 0 01-3.375 3.375h-8.25A3.375 3.375 0 014.5 16.875V14.25" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 8.25L12 3.75 7.5 8.25M12 3.75v12" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex-1 truncate">
                                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                        Unduh Lampiran File ({{ strtoupper($extension) }})
                                    </p>
                                    <p class="mt-0.5 text-xs text-slate-400">
                                        Klik untuk mengunduh arsip file pendukung jurnal ini.
                                    </p>
                                </div>

                                <span class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                    <span>Download</span>
                                    <span>↗</span>
                                </span>
                            </a>
                        @endif
                    @else
                        <div class="rounded-xl border border-dashed border-slate-200 p-8 text-center text-sm text-slate-400 dark:border-slate-800">
                            Tidak ada dokumentasi atau lampiran file yang disertakan oleh siswa.
                        </div>
                    @endif
                </div>
            </div>

            {{-- FEEDBACK / REVISI SEBELUMNYA JIKA PERNAH DITOLAK --}}
            @if ($journal->status === 'rejected' && $journal->mentor_feedback)
                <div class="rounded-2xl border border-red-200 bg-red-50 p-6 shadow-sm dark:border-red-500/20 dark:bg-red-500/10">
                    <div class="flex items-center gap-2 font-bold text-red-800 dark:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Catatan Revisi untuk Siswa</span>
                    </div>
                    <p class="mt-2 text-sm leading-relaxed text-red-700 dark:text-red-300">
                        {{ $journal->mentor_feedback }}
                    </p>
                </div>
            @endif

        </div>

        {{-- KOLOM KANAN: INFO SISWA & PANEL VALIDASI MENTOR --}}
        <div class="space-y-6">

            {{-- KARTU SISWA --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400">
                    Informasi Siswa
                </h3>
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-lg font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                        {{ strtoupper(substr($journal->student->name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="truncate font-bold text-slate-800 dark:text-white">
                            {{ $journal->student->name }}
                        </p>
                        <p class="truncate text-xs text-slate-400">
                            {{ $journal->student->email }}
                        </p>
                    </div>
                </div>

                <div class="mt-4 border-t border-slate-100 pt-4 text-xs dark:border-slate-800">
                    <div class="flex justify-between py-1">
                        <span class="text-slate-400">Tempat PKL:</span>
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $journal->internship->company_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-400">Tanggal Jurnal:</span>
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- FORM VALIDASI & PENILAIAN MENTOR --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Validasi & Penilaian Mentor
                    </h3>
                    @if ($journal->status === 'approved')
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                            Telah Divalidasi
                        </span>
                    @endif
                </div>

                <form action="{{ route('mentor.journals.validate', $journal) }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Nilai (0 - 100) --}}
                    <div>
                        <label for="mentor_score" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                            Nilai (0 - 100)
                        </label>
                        <input
                            type="number"
                            id="mentor_score"
                            name="mentor_score"
                            min="0"
                            max="100"
                            value="{{ old('mentor_score', $journal->mentor_score) }}"
                            placeholder="Contoh: 85"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                        >
                        <span class="mt-1 block text-[11px] text-slate-400">Nilai opsional namun disarankan untuk evaluasi berkala siswa.</span>
                    </div>

                    {{-- Rating Kinerja --}}
                    <div>
                        <label for="mentor_rating" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                            Rating Kinerja
                        </label>
                        <select
                            id="mentor_rating"
                            name="mentor_rating"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                        >
                            <option value="">-- Pilih Rating --</option>
                            <option value="sangat_baik" {{ old('mentor_rating', $journal->mentor_rating) === 'sangat_baik' ? 'selected' : '' }}>
                                ⭐⭐⭐⭐ Sangat Baik (90–100)
                            </option>
                            <option value="baik" {{ old('mentor_rating', $journal->mentor_rating) === 'baik' ? 'selected' : '' }}>
                                ⭐⭐⭐ Baik (75–89)
                            </option>
                            <option value="cukup" {{ old('mentor_rating', $journal->mentor_rating) === 'cukup' ? 'selected' : '' }}>
                                ⭐⭐ Cukup (60–74)
                            </option>
                            <option value="perlu_perbaikan" {{ old('mentor_rating', $journal->mentor_rating) === 'perlu_perbaikan' ? 'selected' : '' }}>
                                ⭐ Perlu Perbaikan (&lt;60)
                            </option>
                        </select>
                    </div>

                    {{-- Catatan / Feedback Validasi --}}
                    <div>
                        <label for="mentor_feedback" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                            Catatan / Feedback (Opsional)
                        </label>
                        <textarea
                            id="mentor_feedback"
                            name="mentor_feedback"
                            rows="3"
                            placeholder="Tuliskan apresiasi atau catatan penguatan bagi siswa..."
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                        >{{ old('mentor_feedback', $journal->status === 'approved' ? $journal->mentor_feedback : '') }}</textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="pt-2 space-y-2">
                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-700 active:scale-[0.99]"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>{{ $journal->status === 'approved' ? 'Perbarui Validasi' : 'Validasi Jurnal' }}</span>
                        </button>

                        <button
                            type="button"
                            @click="revisionModalOpen = true"
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50/50 px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100 hover:text-red-700 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            <span>Minta Revisi Jurnal</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

        {{-- MODAL MINTA REVISI DENGAN ALPINE.JS --}}
        <div
            x-show="revisionModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm transition-opacity"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div
                @click.outside="revisionModalOpen = false"
                class="w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-800 dark:bg-slate-900"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="scale-95 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
            >
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-white">Minta Revisi Jurnal</h3>
                            <p class="text-xs text-slate-400">Siswa akan diminta memperbaiki isi jurnal ini.</p>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="revisionModalOpen = false"
                        class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800"
                    >
                        ✕
                    </button>
                </div>

                <form action="{{ route('mentor.journals.revision', $journal) }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="modal_feedback" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Instruksi / Catatan Revisi <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="modal_feedback"
                            name="mentor_feedback"
                            rows="4"
                            required
                            placeholder="Jelaskan apa yang perlu diperbaiki oleh siswa (misal: lengkapi rincian tugas atau sertakan foto kegiatan)..."
                            class="w-full rounded-xl border border-slate-200 bg-white p-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-red-400 focus:ring-4 focus:ring-red-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
                        >{{ old('mentor_feedback', $journal->status === 'rejected' ? $journal->mentor_feedback : '') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button
                            type="button"
                            @click="revisionModalOpen = false"
                            class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="rounded-xl bg-red-600 px-5 py-2.5 text-xs font-bold text-white shadow-lg shadow-red-500/20 transition hover:bg-red-700"
                        >
                            Kirim Permintaan Revisi
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-layouts.app>
