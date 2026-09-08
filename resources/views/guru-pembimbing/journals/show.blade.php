<x-layouts.app title="Monitoring Jurnal – {{ $journal->title }}">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('guru-pembimbing.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Guru Pembimbing</a>
                <span>/</span>
                <a href="{{ route('guru-pembimbing.journals.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Monitoring Jurnal</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Detail Jurnal</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Detail Jurnal Siswa
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Pantau rincian aktivitas harian siswa bimbingan dan status validasi oleh mentor PKL.
            </p>
        </div>

        <div>
            <a
                href="{{ route('guru-pembimbing.journals.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Monitoring Jurnal</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- KOLOM KIRI (2 SPAN): KONTEN JURNAL & FOTO DOKUMENTASI --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- CARD KONTEN UTAMA JURNAL --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                
                {{-- Header Jurnal --}}
                <div class="border-b border-slate-100 p-6 dark:border-slate-800">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($journal->date)->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <h2 class="mt-2 text-xl font-bold text-slate-800 dark:text-white">
                                {{ $journal->title }}
                            </h2>
                        </div>

                        <div>
                            @if ($journal->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Validasi Mentor
                                </span>
                            @elseif ($journal->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Valid (Disetujui Mentor)
                                </span>
                            @elseif ($journal->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3.5 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                    <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                    Perlu Revisi (Catatan Mentor)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Deskripsi Kegiatan --}}
                <div class="p-6">
                    <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Deskripsi Kegiatan yang Dilakukan
                    </h3>
                    <div class="prose prose-slate max-w-none text-sm leading-relaxed text-slate-700 dark:prose-invert dark:text-slate-300">
                        {!! nl2br(e($journal->description)) !!}
                    </div>
                </div>

                {{-- Dokumentasi / Foto Lampiran --}}
                <div class="border-t border-slate-100 p-6 dark:border-slate-800">
                    <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Dokumentasi Kegiatan Siswa
                    </h3>

                    @if ($journal->attachment)
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-800/40">
                            <a
                                href="{{ asset('storage/' . $journal->attachment) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group relative block"
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
                                    <span>Buka Foto Penuh</span>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-3 rounded-xl border border-dashed border-slate-200 p-6 text-sm text-slate-400 dark:border-slate-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            <span>Tidak ada foto atau lampiran dokumen untuk jurnal ini.</span>
                        </div>
                    @endif
                </div>

            </div>

        </div>

        {{-- KOLOM KANAN (1 SPAN): INFO SISWA & STATUS VALIDASI MENTOR --}}
        <div class="space-y-6">

            {{-- KARTU PROFIL SISWA & TEMPAT PKL --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Informasi Siswa Bimbingan
                </h3>

                <div class="flex items-center gap-3.5">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-lg font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                        {{ strtoupper(substr($journal->student->name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="truncate font-bold text-slate-800 dark:text-white">
                            {{ $journal->student->name }}
                        </h4>
                        <p class="truncate text-xs text-slate-400">
                            {{ $journal->student->email }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 divide-y divide-slate-100 border-t border-slate-100 text-xs dark:divide-slate-800 dark:border-slate-800">
                    <div class="flex items-center justify-between py-2.5">
                        <span class="text-slate-400">Tempat PKL</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200">
                            {{ $journal->internship->company_name ?? '-' }}
                        </span>
                    </div>
                    @if ($journal->internship && $journal->internship->mentor)
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-slate-400">Mentor Perusahaan</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-200">
                                {{ $journal->internship->mentor->name }}
                            </span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between py-2.5">
                        <span class="text-slate-400">Status PKL</span>
                        <span>
                            @if (($journal->internship->status ?? '') === 'active')
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    Aktif PKL
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    {{ ucfirst($journal->internship->status ?? '-') }}
                                </span>
                            @endif
                        </span>
                    </div>
                </div>

                @if ($journal->internship)
                    <div class="mt-4 pt-2">
                        <a
                            href="{{ route('guru-pembimbing.students.show', $journal->internship) }}"
                            class="inline-flex w-full items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 py-2.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-750"
                        >
                            <span>Lihat Seluruh Riwayat Siswa</span>
                            <span>→</span>
                        </a>
                    </div>
                @endif
            </div>

            {{-- KARTU STATUS VALIDASI & EVALUASI OLEH MENTOR --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Status Validasi Mentor
                    </h3>
                    <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        Approval: Mentor DUDI
                    </span>
                </div>

                @if ($journal->status === 'pending')
                    <div class="rounded-xl border border-amber-200 bg-amber-50/70 p-4 dark:border-amber-500/20 dark:bg-amber-500/10">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-amber-500 text-xs font-bold text-white">
                                ⏳
                            </span>
                            <div>
                                <h4 class="text-xs font-bold text-amber-800 dark:text-amber-300">
                                    Menunggu Validasi Mentor
                                </h4>
                                <p class="text-[11px] text-amber-700 dark:text-amber-400">
                                    Jurnal belum divalidasi oleh pembimbing lapangan di tempat PKL.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif ($journal->status === 'approved')
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50/70 p-4 dark:border-emerald-500/20 dark:bg-emerald-500/10">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-600 text-xs font-bold text-white">
                                    ✓
                                </span>
                                <div>
                                    <h4 class="text-xs font-bold text-emerald-800 dark:text-emerald-300">
                                        Telah Divalidasi Mentor
                                    </h4>
                                    <p class="text-[11px] text-emerald-700 dark:text-emerald-400">
                                        Kegiatan disetujui dan dinilai oleh mentor.
                                    </p>
                                </div>
                            </div>

                            @if (!is_null($journal->mentor_score))
                                <div class="text-right">
                                    <span class="text-[10px] uppercase font-bold text-emerald-600 dark:text-emerald-400 block">Nilai</span>
                                    <span class="text-lg font-extrabold text-emerald-700 dark:text-emerald-300">{{ $journal->mentor_score }}</span>
                                </div>
                            @endif
                        </div>

                        @if ($journal->mentor_rating)
                            <div class="mt-3 flex items-center gap-2 border-t border-emerald-200/60 pt-2.5 text-xs text-emerald-800 dark:border-emerald-500/20 dark:text-emerald-300">
                                <span class="text-slate-500 dark:text-slate-400">Kategori Kinerja:</span>
                                <span class="font-bold">{{ str_replace('_', ' ', ucfirst($journal->mentor_rating)) }}</span>
                            </div>
                        @endif

                        @if ($journal->mentor_feedback || $journal->feedback)
                            <div class="mt-2.5 rounded-lg bg-white/80 p-3 text-xs leading-relaxed text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                                <span class="font-semibold text-slate-500 block mb-1">Catatan Mentor:</span>
                                {{ $journal->mentor_feedback ?? $journal->feedback }}
                            </div>
                        @endif
                    </div>
                @elseif ($journal->status === 'rejected')
                    <div class="rounded-xl border border-rose-200 bg-rose-50/70 p-4 dark:border-rose-500/20 dark:bg-rose-500/10">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-rose-600 text-xs font-bold text-white">
                                !
                            </span>
                            <div>
                                <h4 class="text-xs font-bold text-rose-800 dark:text-rose-300">
                                    Diminta Revisi oleh Mentor
                                </h4>
                                <p class="text-[11px] text-rose-700 dark:text-rose-400">
                                    Siswa perlu memperbaiki isi jurnal sesuai catatan mentor.
                                </p>
                            </div>
                        </div>

                        @if ($journal->mentor_feedback || $journal->feedback)
                            <div class="mt-3 rounded-lg bg-white/80 p-3 text-xs leading-relaxed text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                                <span class="font-semibold text-rose-600 block mb-1">Catatan Revisi Mentor:</span>
                                {{ $journal->mentor_feedback ?? $journal->feedback }}
                            </div>
                        @endif
                    </div>
                @endif

                {{-- INFORMASI TUGAS GURU --}}
                <div class="mt-5 rounded-xl border border-slate-100 bg-slate-50/80 p-3.5 text-xs text-slate-500 dark:border-slate-800 dark:bg-slate-850 dark:text-slate-400">
                    <div class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-blue-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>
                            Sebagai Guru Pembimbing, peran Anda adalah <strong>memantau</strong> konsistensi dan capaian PKL siswa. Validasi dan approval harian dilakukan oleh Mentor perusahaan/DUDI.
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</x-layouts.app>