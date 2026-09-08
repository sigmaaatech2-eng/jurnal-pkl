<x-layouts.app>

    @php

        $user = auth()->user();

        $totalJournals = $user->journals()->count();

        $pendingJournals = $user->journals()
            ->where('status', 'pending')
            ->count();

        $approvedJournals = $user->journals()
            ->where('status', 'approved')
            ->count();

        $revisionJournals = $user->journals()
            ->where('status', 'revision')
            ->count();

        $todayAttendance = $user->attendances()
            ->whereDate('date', today())
            ->first();

        $latestJournal = $user->journals()
            ->latest('date')
            ->first();

    @endphp


    {{-- WELCOME --}}
    <section class="mb-7 flex flex-col justify-between gap-5 lg:flex-row lg:items-start">

        <div>

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Selamat datang,
            </p>

            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-800 dark:text-white">
                {{ auth()->user()->name }}
            </h1>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Tetap semangat menjalani kegiatan PKL hari ini!
            </p>

        </div>


        <div class="text-left lg:text-right"> 

            <div class="flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-300 lg:justify-end">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-blue-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <rect
                        x="3"
                        y="4"
                        width="18"
                        height="17"
                        rx="2"
                    />

                    <path d="M8 2v4M16 2v4M3 10h18" />
                </svg>

                {{ now()->translatedFormat('l, d F Y') }}

            </div>

            

        </div>

    </section>



    {{-- INFORMASI PKL --}}
    @if($internship)

        <section
            class="relative mb-5 overflow-hidden rounded-2xl border border-slate-200
            bg-gradient-to-r from-white via-blue-50 to-blue-100
            p-6 shadow-sm
            dark:border-slate-800 dark:from-slate-900 dark:via-slate-900 dark:to-blue-950"
        >

            <div class="relative z-10 grid gap-6 lg:grid-cols-[1.3fr_1fr_1fr] lg:items-center">

                {{-- COMPANY --}}
                <div class="flex items-center gap-4">

                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-2xl
                        bg-blue-100 text-blue-600 dark:bg-blue-500/10"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.6"
                        >
                            <path d="M3 21h18" />
                            <path d="M5 21V7l8-4v18" />
                            <path d="M19 21V11l-6-4" />
                            <path d="M9 9h1M9 13h1M9 17h1M15 13h1M15 17h1" />
                        </svg>

                    </div>


                    <div>

                        <p class="text-sm font-semibold text-blue-600">
                            Informasi PKL
                        </p>

                        <h2 class="mt-1 text-xl font-bold text-slate-800 dark:text-white">
                            {{ $internship->company_name }}
                        </h2>

                        @if($internship->company_address)

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                {{ $internship->company_address }}
                            </p>

                        @endif

                    </div>

                </div>


                {{-- PERIODE --}}
                <div class="border-l-0 border-slate-200 pl-0 dark:border-slate-700 lg:border-l lg:pl-6">

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Periode PKL
                    </p>

                    <p class="mt-2 font-semibold text-slate-700 dark:text-white">
                        {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                    </p>

                </div>


                {{-- STATUS --}}
                <div class="border-l-0 border-slate-200 pl-0 dark:border-slate-700 lg:border-l lg:pl-6">

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Status
                    </p>

                    <div class="mt-3">

                        <span
                            class="inline-flex items-center gap-2 rounded-full
                            bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700
                            dark:bg-emerald-500/10 dark:text-emerald-400"
                        >

                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                            PKL Aktif

                        </span>

                    </div>

                </div>

            </div>

        </section>

    @endif



    {{-- STATISTICS --}}
    <section class="mb-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">


        {{-- TOTAL --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Total Jurnal
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
                        {{ $totalJournals }}
                    </p>

                    <p class="mt-2 text-xs text-slate-400">
                        Dari seluruh kegiatan PKL
                    </p>

                </div>


                <div class="rounded-xl bg-blue-50 p-3 text-blue-600 dark:bg-blue-500/10">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M6 2h8l4 4v16H6z" />
                        <path d="M14 2v5h5M9 13h6M9 17h6" />
                    </svg>

                </div>

            </div>

        </div>



        {{-- PENDING --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Menunggu Review
                    </p>

                    <p class="mt-2 text-3xl font-bold text-amber-500">
                        {{ $pendingJournals }}
                    </p>

                    <p class="mt-2 text-xs text-slate-400">
                        Dalam proses penilaian
                    </p>

                </div>


                <div class="rounded-xl bg-amber-50 p-3 text-amber-500 dark:bg-amber-500/10">
                    ◷
                </div>

            </div>

        </div>



        {{-- APPROVED --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Disetujui
                    </p>

                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ $approvedJournals }}
                    </p>

                    <p class="mt-2 text-xs text-slate-400">
                        Telah diverifikasi
                    </p>

                </div>


                <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600 dark:bg-emerald-500/10">
                    ✓
                </div>

            </div>

        </div>



        {{-- REVISION --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Perlu Revisi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-red-500">
                        {{ $revisionJournals }}
                    </p>

                    <p class="mt-2 text-xs text-slate-400">
                        Perlu perbaikan
                    </p>

                </div>


                <div class="rounded-xl bg-red-50 p-3 text-red-500 dark:bg-red-500/10">
                    !
                </div>

            </div>

        </div>

    </section>



    {{-- ABSENSI --}}
    <section
        class="mb-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm
        dark:border-slate-800 dark:bg-slate-900"
    >

        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">

            <div>

                <div class="flex items-center gap-3">

                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600 dark:bg-blue-500/10">
                        ▣
                    </div>

                    <div>

                        <h2 class="font-bold text-slate-800 dark:text-white">
                            Absensi Hari Ini
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </p>

                    </div>

                </div>

            </div>


            <a
                href="{{ route('siswa.attendances.index') }}"
                class="inline-flex items-center justify-center rounded-xl
                bg-blue-600 px-5 py-3 text-sm font-semibold text-white
                shadow-lg shadow-blue-500/20 transition
                hover:-translate-y-0.5 hover:bg-blue-700"
            >
                Lihat Detail
                <span class="ml-3">→</span>
            </a>

        </div>


        <div
            class="mt-5 rounded-xl
            @if($todayAttendance && $todayAttendance->check_in && $todayAttendance->check_out)
                bg-emerald-50 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-300
            @elseif($todayAttendance && $todayAttendance->check_in)
                bg-amber-50 text-amber-800 dark:bg-amber-500/10 dark:text-amber-300
            @else
                bg-slate-50 text-slate-600 dark:bg-slate-800 dark:text-slate-300
            @endif
            p-5"
        >

            @if($todayAttendance && $todayAttendance->check_in && $todayAttendance->check_out)

                <p class="font-semibold">
                    Absensi hari ini sudah lengkap.
                </p>

                <div class="mt-3 flex flex-wrap gap-5 text-sm">

                    <span>
                        Check In
                        <strong class="ml-1">
                            {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }}
                        </strong>
                    </span>

                    <span>•</span>

                    <span>
                        Check Out
                        <strong class="ml-1">
                            {{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') }}
                        </strong>
                    </span>

                </div>

            @elseif($todayAttendance && $todayAttendance->check_in)

                <p class="font-semibold">
                    Kamu sudah melakukan check-in.
                </p>

                <p class="mt-2 text-sm">
                    Jangan lupa melakukan check-out setelah kegiatan selesai.
                </p>

            @else

                <p class="font-semibold">
                    Kamu belum melakukan absensi hari ini.
                </p>

                <p class="mt-2 text-sm">
                    Silakan lakukan check-in sebelum memulai kegiatan.
                </p>

            @endif

        </div>

    </section>



    {{-- AKSI CEPAT --}}
    <section
        class="mb-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
        dark:border-slate-800 dark:bg-slate-900"
    >

        <h2 class="mb-5 font-bold text-slate-800 dark:text-white">
            Aksi Cepat
        </h2>


        <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">


            <a
                href="{{ route('siswa.journals.create') }}"
                class="flex items-center justify-between rounded-xl bg-blue-600
                px-5 py-4 text-sm font-semibold text-white transition hover:bg-blue-700"
            >

                <span>Buat Jurnal</span>
                <span class="text-lg">＋</span>

            </a>


            <a
                href="{{ route('siswa.journals.index') }}"
                class="flex items-center justify-between rounded-xl border border-slate-200
                px-5 py-4 text-sm font-semibold text-slate-700 transition
                hover:border-blue-300 hover:bg-blue-50
                dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
            >

                <span>Lihat Jurnal</span>
                <span>→</span>

            </a>


            <a
                href="{{ route('siswa.attendances.index') }}"
                class="flex items-center justify-between rounded-xl border border-slate-200
                px-5 py-4 text-sm font-semibold text-slate-700 transition
                hover:border-blue-300 hover:bg-blue-50
                dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
            >

                <span>Absensi</span>
                <span>→</span>

            </a>


            <button
                type="button"
                class="flex items-center justify-between rounded-xl border border-slate-200
                px-5 py-4 text-left text-sm font-semibold text-slate-700 transition
                hover:border-blue-300 hover:bg-blue-50
                dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
            >

                <span>Panduan</span>
                <span>→</span>

            </button>

        </div>

    </section>



    {{-- BOTTOM --}}
    <div class="grid gap-5 xl:grid-cols-3">


        {{-- JURNAL TERBARU --}}
        <section
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm
            dark:border-slate-800 dark:bg-slate-900 xl:col-span-2"
        >

            <div class="mb-5 flex items-center justify-between">

                <h2 class="font-bold text-slate-800 dark:text-white">
                    Jurnal Terbaru
                </h2>


                <a
                    href="{{ route('siswa.journals.index') }}"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-700"
                >
                    Lihat Semua
                </a>

            </div>


            @if($latestJournal)

                <a
                    href="{{ route('siswa.journals.show', $latestJournal) }}"
                    class="flex items-center justify-between rounded-xl border border-slate-100
                    p-4 transition hover:border-blue-200 hover:bg-blue-50
                    dark:border-slate-800 dark:hover:bg-slate-800"
                >

                    <div>

                        <h3 class="font-semibold text-slate-700 dark:text-white">
                            {{ $latestJournal->title ?? 'Kegiatan PKL' }}
                        </h3>

                        <p class="mt-1 text-sm text-slate-400">
                            {{ \Carbon\Carbon::parse($latestJournal->date)->translatedFormat('d F Y') }}
                        </p>

                    </div>


                    <span class="text-blue-600">
                        →
                    </span>

                </a>

            @else

                <div class="rounded-xl bg-slate-50 p-6 text-center dark:bg-slate-800">

                    <p class="text-sm text-slate-500">
                        Belum ada jurnal yang dibuat.
                    </p>

                </div>

            @endif

        </section>



        {{-- JADWAL PKL --}}
        <section
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm
            dark:border-slate-800 dark:bg-slate-900"
        >

            <h2 class="mb-6 font-bold text-slate-800 dark:text-white">
                Jadwal PKL
            </h2>


            @if($internship)

                <div class="space-y-6">

                    <div class="flex gap-4">

                        <div class="flex flex-col items-center">

                            <span class="h-3 w-3 rounded-full bg-emerald-500"></span>

                            <div class="h-10 w-px bg-slate-200 dark:bg-slate-700"></div>

                        </div>


                        <div>

                            <p class="font-semibold text-slate-700 dark:text-white">
                                {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Mulai PKL
                            </p>

                        </div>

                    </div>


                    <div class="flex gap-4">

                        <div>
                            <span class="block h-3 w-3 rounded-full bg-slate-300"></span>
                        </div>


                        <div>

                            <p class="font-semibold text-slate-700 dark:text-white">
                                {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Selesai PKL
                            </p>

                        </div>

                    </div>

                </div>

            @else

                <p class="text-sm text-slate-500">
                    Belum ada data PKL aktif.
                </p>

            @endif

        </section>

    </div>

</x-layouts.app>