<x-layouts.app title="Absensi PKL">

    <div
        x-data="attendancePage()"
        class="space-y-8"
    >

        {{-- =========================
            HEADER
        ========================= --}}
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-12 w-12 items-center justify-center
                        rounded-2xl bg-blue-50 text-blue-600
                        dark:bg-blue-500/10 dark:text-blue-400"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6l4 2"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />

                        </svg>

                    </div>


                    <div>

                        <h1
                            class="text-2xl font-bold tracking-tight
                            text-slate-800 dark:text-white"
                        >
                            Absensi PKL
                        </h1>

                        <p
                            class="mt-1 text-sm text-slate-500
                            dark:text-slate-400"
                        >
                            Catat kehadiran selama kegiatan praktik kerja lapangan.
                        </p>

                    </div>

                </div>

            </div>


            <div
                class="inline-flex items-center gap-2 self-start
                rounded-xl border border-slate-200 bg-white
                px-4 py-2 text-sm text-slate-500 shadow-sm
                dark:border-slate-800 dark:bg-slate-900
                dark:text-slate-400 sm:self-auto"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.25 3v3m7.5-3v3M3.75 9.75h16.5M4.5 5.25h15A2.25 2.25 0 0121.75 7.5v11.25A2.25 2.25 0 0119.5 21h-15a2.25 2.25 0 01-2.25-2.25V7.5A2.25 2.25 0 014.5 5.25z"
                    />
                </svg>

                {{ now()->translatedFormat('l, d F Y') }}

            </div>

        </div>


        {{-- =========================
            ALERT
        ========================= --}}
        @if (session('success'))

            <div
                class="flex items-center gap-3 rounded-2xl
                border border-green-200 bg-green-50 p-4
                text-sm text-green-700
                dark:border-green-500/20 dark:bg-green-500/10
                dark:text-green-400"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.5 12.75l6 6 9-13.5"
                    />
                </svg>

                {{ session('success') }}

            </div>

        @endif


        @if (session('error'))

            <div
                class="flex items-center gap-3 rounded-2xl
                border border-red-200 bg-red-50 p-4
                text-sm text-red-700
                dark:border-red-500/20 dark:bg-red-500/10
                dark:text-red-400"
            >

                {{ session('error') }}

            </div>

        @endif


        {{-- =========================
            ABSENSI HARI INI
        ========================= --}}
        <div
            class="overflow-hidden rounded-2xl border
            border-slate-200 bg-white shadow-sm
            dark:border-slate-800 dark:bg-slate-900"
        >

            <div
                class="border-b border-slate-100 px-6 py-5
                dark:border-slate-800"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <h2
                            class="font-semibold text-slate-800
                            dark:text-white"
                        >
                            Kehadiran Hari Ini
                        </h2>

                        <p
                            class="mt-1 text-sm text-slate-500
                            dark:text-slate-400"
                        >
                            Lakukan check-in saat memulai PKL dan check-out
                            setelah kegiatan selesai.
                        </p>

                    </div>


                    @if (!$todayAttendance)

                        <span
                            class="rounded-full bg-slate-100 px-3 py-1
                            text-xs font-medium text-slate-600
                            dark:bg-slate-800 dark:text-slate-400"
                        >
                            Belum Absen
                        </span>

                    @elseif ($todayAttendance->check_in && !$todayAttendance->check_out)

                        <span
                            class="rounded-full bg-blue-50 px-3 py-1
                            text-xs font-medium text-blue-600
                            dark:bg-blue-500/10 dark:text-blue-400"
                        >
                            Sedang PKL
                        </span>

                    @else

                        <span
                            class="rounded-full bg-green-50 px-3 py-1
                            text-xs font-medium text-green-600
                            dark:bg-green-500/10 dark:text-green-400"
                        >
                            Selesai
                        </span>

                    @endif

                </div>

            </div>


            <div class="p-6">

                {{-- INFORMASI BATAS WAKTU ABSEN OLEH MENTOR --}}
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-xs text-amber-900 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold">Batas Waktu Absen Masuk:</span>
                            <span class="font-extrabold text-amber-700 dark:text-amber-200">{{ substr($internship->max_check_in_time ?? '08:00:00', 0, 5) }} WIB</span>
                            @if ($internship->mentor)
                                <span class="text-amber-700/80 dark:text-amber-400">· Diatur oleh mentor: <strong>{{ $internship->mentor->name }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <span class="rounded-full bg-amber-200/70 px-2.5 py-1 font-semibold text-amber-900 dark:bg-amber-500/20 dark:text-amber-300">
                        Check-in setelah jam ini dicatat Terlambat
                    </span>
                </div>

                {{-- STATUS --}}
                <div class="grid gap-4 sm:grid-cols-2">

                    {{-- CHECK IN --}}
                    <div
                        class="rounded-2xl border border-slate-200
                        bg-slate-50 p-5
                        dark:border-slate-800 dark:bg-slate-950/40"
                    >

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0
                                items-center justify-center rounded-xl
                                bg-blue-100 text-blue-600
                                dark:bg-blue-500/10 dark:text-blue-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 6v6l4 2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />

                                </svg>

                            </div>


                            <div class="flex-1">

                                <p
                                    class="text-xs font-medium uppercase
                                    tracking-wider text-slate-400"
                                >
                                    Check In
                                </p>

                                <div class="mt-1 flex flex-wrap items-baseline gap-2">
                                    <p
                                        class="text-xl font-bold
                                        text-slate-800 dark:text-white"
                                    >
                                        @if ($todayAttendance?->check_in)
                                            {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }} WIB
                                        @else
                                            --
                                        @endif
                                    </p>

                                    @if ($todayAttendance?->check_in)
                                        @if ($todayAttendance->late_status === 'tepat_waktu')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Tepat Waktu
                                            </span>
                                        @elseif ($todayAttendance->late_status === 'terlambat')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                                Terlambat
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                @if ($todayAttendance?->check_in_lat && $todayAttendance?->check_in_lng)
                                    <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        <a
                                            href="https://www.google.com/maps?q={{ $todayAttendance->check_in_lat }},{{ $todayAttendance->check_in_lng }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="truncate font-medium text-blue-600 hover:underline dark:text-blue-400"
                                            title="Buka lokasi di Google Maps"
                                        >
                                            Lokasi Check In (Maps)
                                        </a>
                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- CHECK OUT --}}
                    <div
                        class="rounded-2xl border border-slate-200
                        bg-slate-50 p-5
                        dark:border-slate-800 dark:bg-slate-950/40"
                    >

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0
                                items-center justify-center rounded-xl
                                bg-violet-100 text-violet-600
                                dark:bg-violet-500/10
                                dark:text-violet-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 6v6l4 2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />

                                </svg>

                            </div>


                            <div class="flex-1">

                                <p
                                    class="text-xs font-medium uppercase
                                    tracking-wider text-slate-400"
                                >
                                    Check Out
                                </p>

                                <p
                                    class="mt-1 text-xl font-bold
                                    text-slate-800 dark:text-white"
                                >
                                    @if ($todayAttendance?->check_out)

                                        {{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') }} WIB

                                    @else

                                        --

                                    @endif
                                </p>

                                @if ($todayAttendance?->check_out_lat && $todayAttendance?->check_out_lng)
                                    <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        <a
                                            href="https://www.google.com/maps?q={{ $todayAttendance->check_out_lat }},{{ $todayAttendance->check_out_lng }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="truncate font-medium text-blue-600 hover:underline dark:text-blue-400"
                                            title="Buka lokasi di Google Maps"
                                        >
                                            Lokasi Check Out (Maps) 
                                        </a>
                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ACTION --}}
                <div class="mt-6">

                    @if (!$todayAttendance)

                        <button
                            type="button"
                            @click="openCamera('check-in')"
                            class="inline-flex w-full items-center
                            justify-center gap-2 rounded-xl
                            bg-blue-600 px-5 py-3.5
                            text-sm font-semibold text-white
                            transition hover:bg-blue-700
                            sm:w-auto"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4.5 12.75l6 6 9-13.5"
                                />
                            </svg>

                            Check In Sekarang

                        </button>

                    @elseif ($todayAttendance->check_in && !$todayAttendance->check_out)

                        <button
                            type="button"
                            @click="openCamera('check-out')"
                            class="inline-flex w-full items-center
                            justify-center gap-2 rounded-xl
                            bg-violet-600 px-5 py-3.5
                            text-sm font-semibold text-white
                            transition hover:bg-violet-700
                            sm:w-auto"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4.5 12.75l6 6 9-13.5"
                                />
                            </svg>

                            Check Out Sekarang

                        </button>

                    @else

                        <div
                            class="flex items-center gap-3 rounded-xl
                            bg-green-50 p-4 text-sm text-green-700
                            dark:bg-green-500/10 dark:text-green-400"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 shrink-0"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4.5 12.75l6 6 9-13.5"
                                />
                            </svg>

                            Absensi hari ini telah selesai.

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- =========================
            RIWAYAT ABSENSI
        ========================= --}}
        <div
            class="overflow-hidden rounded-2xl border
            border-slate-200 bg-white shadow-sm
            dark:border-slate-800 dark:bg-slate-900"
        >

            <div
                class="flex items-center justify-between
                border-b border-slate-100 px-6 py-5
                dark:border-slate-800"
            >

                <div>

                    <h2
                        class="font-semibold text-slate-800
                        dark:text-white"
                    >
                        Riwayat Absensi
                    </h2>

                    <p
                        class="mt-1 text-sm text-slate-500
                        dark:text-slate-400"
                    >
                        Riwayat kehadiran selama menjalankan PKL.
                    </p>

                </div>

            </div>


            @if ($attendances->isEmpty())

                <div class="px-6 py-16 text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center
                        justify-center rounded-2xl bg-slate-100
                        text-slate-400 dark:bg-slate-800"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-7 w-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 3v3m7.5-3v3M3.75 9.75h16.5"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 5.25h15A2.25 2.25 0 01121.75 7.5v11.25A2.25 2.25 0 0119.5 21h-15a2.25 2.25 0 01-2.25-2.25V7.5A2.25 2.25 0 014.5 5.25z"
                            />

                        </svg>

                    </div>

                    <h3
                        class="mt-4 font-semibold text-slate-700
                        dark:text-slate-200"
                    >
                        Belum ada riwayat absensi
                    </h3>

                    <p
                        class="mt-2 text-sm text-slate-500
                        dark:text-slate-400"
                    >
                        Riwayat absensi kamu akan muncul di sini.
                    </p>

                </div>

            @else

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead
                            class="border-b border-slate-100
                            bg-slate-50 text-xs uppercase
                            tracking-wider text-slate-400
                            dark:border-slate-800
                            dark:bg-slate-950/40"
                        >

                            <tr>

                                <th class="whitespace-nowrap px-6 py-4">
                                    Tanggal
                                </th>

                                <th class="whitespace-nowrap px-6 py-4">
                                    Check In
                                </th>

                                <th class="whitespace-nowrap px-6 py-4">
                                    Check Out
                                </th>

                                <th class="whitespace-nowrap px-6 py-4">
                                    Status
                                </th>

                                <th class="whitespace-nowrap px-6 py-4">
                                    Lokasi
                                </th>

                                <th class="whitespace-nowrap px-6 py-4">
                                    Bukti
                                </th>

                            </tr>

                        </thead>


                        <tbody
                            class="divide-y divide-slate-100
                            dark:divide-slate-800"
                        >

                            @foreach ($attendances as $attendance)

                                <tr
                                    class="transition
                                    hover:bg-slate-50/80
                                    dark:hover:bg-slate-800/50"
                                >

                                    {{-- TANGGAL --}}
                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                        text-sm font-medium
                                        text-slate-700 dark:text-slate-200"
                                    >
                                        {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                    </td>


                                    {{-- CHECK IN --}}
                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                        text-sm font-semibold text-slate-800
                                        dark:text-slate-200"
                                    >

                                        @if ($attendance->check_in)

                                            {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }} WIB

                                        @else

                                            --

                                        @endif

                                    </td>


                                    {{-- CHECK OUT --}}
                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                        text-sm text-slate-600
                                        dark:text-slate-300"
                                    >

                                        @if ($attendance->check_out)

                                            {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }} WIB

                                        @else

                                            <span
                                                class="rounded-full
                                                bg-amber-50 px-2.5 py-1
                                                text-xs font-medium
                                                text-amber-600
                                                dark:bg-amber-500/10
                                                dark:text-amber-400"
                                            >
                                                Belum Check Out
                                            </span>

                                        @endif

                                    </td>


                                    {{-- STATUS KEHADIRAN (TEPAT WAKTU / TERLAMBAT) --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if ($attendance->late_status === 'tepat_waktu')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Tepat Waktu
                                            </span>
                                        @elseif ($attendance->late_status === 'terlambat')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-400">-</span>
                                        @endif

                                    </td>


                                    {{-- LOKASI ABSEN --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-xs">

                                        <div class="flex flex-col gap-1.5">

                                            @if ($attendance->check_in_lat && $attendance->check_in_lng)
                                                <a
                                                    href="https://www.google.com/maps?q={{ $attendance->check_in_lat }},{{ $attendance->check_in_lng }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex items-center gap-1 font-medium text-blue-600 hover:underline dark:text-blue-400"
                                                    title="Koordinat: {{ $attendance->check_in_lat }}, {{ $attendance->check_in_lng }}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                    </svg>
                                                    <span>Masuk (Maps)</span>
                                                </a>
                                            @endif

                                            @if ($attendance->check_out_lat && $attendance->check_out_lng)
                                                <a
                                                    href="https://www.google.com/maps?q={{ $attendance->check_out_lat }},{{ $attendance->check_out_lng }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex items-center gap-1 font-medium text-violet-600 hover:underline dark:text-violet-400"
                                                    title="Koordinat: {{ $attendance->check_out_lat }}, {{ $attendance->check_out_lng }}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                    </svg>
                                                    <span>Pulang (Maps) ↗</span>
                                                </a>
                                            @endif

                                            @if (!$attendance->check_in_lat && !$attendance->check_out_lat)
                                                <span class="text-slate-400">-</span>
                                            @endif

                                        </div>

                                    </td>


                                    {{-- BUKTI --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            @if ($attendance->check_in_photo)

                                                <button
                                                    type="button"
                                                    @click="openImage(
                                                        '{{ asset('storage/' . $attendance->check_in_photo) }}'
                                                    )"
                                                    class="flex h-10 w-10
                                                    items-center justify-center
                                                    overflow-hidden rounded-lg
                                                    border border-slate-200
                                                    transition hover:opacity-80
                                                    dark:border-slate-700"
                                                    title="Lihat foto check-in"
                                                >

                                                    <img
                                                        src="{{ asset('storage/' . $attendance->check_in_photo) }}"
                                                        class="h-full w-full object-cover"
                                                        alt="Check In"
                                                    >

                                                </button>

                                            @endif


                                            @if ($attendance->check_out_photo)

                                                <button
                                                    type="button"
                                                    @click="openImage(
                                                        '{{ asset('storage/' . $attendance->check_out_photo) }}'
                                                    )"
                                                    class="flex h-10 w-10
                                                    items-center justify-center
                                                    overflow-hidden rounded-lg
                                                    border border-slate-200
                                                    transition hover:opacity-80
                                                    dark:border-slate-700"
                                                    title="Lihat foto check-out"
                                                >

                                                    <img
                                                        src="{{ asset('storage/' . $attendance->check_out_photo) }}"
                                                        class="h-full w-full object-cover"
                                                        alt="Check Out"
                                                    >

                                                </button>

                                            @endif


                                            @if (
                                                !$attendance->check_in_photo
                                                && !$attendance->check_out_photo
                                            )

                                                <span
                                                    class="text-sm
                                                    text-slate-400"
                                                >
                                                    Tidak ada foto
                                                </span>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>


        <!-- Modal Kamera -->
<div
    x-show="cameraModal"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/75 p-4 backdrop-blur-sm"
>
    <div
        class="w-full max-w-lg overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900"
    >

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-700">

            <div>
                <h3 class="text-base font-semibold text-slate-800 dark:text-white">
                    Ambil Foto Absensi
                </h3>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Pastikan wajah terlihat jelas di dalam area kamera.
                </p>
            </div>

            <button
                type="button"
                @click="closeCamera()"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 dark:hover:bg-slate-800"
            >
                ×
            </button>

        </div>


        <!-- Preview Kamera -->
        <div class="bg-slate-950 p-4">

            <div
                class="relative mx-auto w-full max-w-sm overflow-hidden rounded-xl bg-black"
            >

                <!-- PAKAI VIDEO LAMA -->
                <video
                    x-ref="video"
                    autoplay
                    playsinline
                    class="block h-auto w-full"
                    style="transform: scaleX(-1);"
                ></video>


                <!-- Frame wajah -->
                <div class="pointer-events-none absolute inset-0 flex items-center justify-center">

                    <div
                        class="h-[70%] w-[68%] rounded-[2rem] border-2 border-white/80 shadow-lg"
                    ></div>

                </div>

            </div>

            <!-- Canvas lama -->
            <canvas
                x-ref="canvas"
                class="hidden"
            ></canvas>

            <!-- Indikator Lokasi GPS -->
            <div class="mt-3 flex items-center justify-between rounded-xl bg-slate-900/90 px-3.5 py-2.5 text-xs">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span class="text-slate-300 font-medium" x-text="locationStatus || 'Mendeteksi lokasi GPS...'"></span>
                </div>
                <template x-if="lat && lng">
                    <span class="rounded bg-emerald-500/20 px-2 py-0.5 font-mono text-[10px] text-emerald-300">
                        GPS Terkunci
                    </span>
                </template>
            </div>

        </div>


        <!-- Action -->
        <div class="flex gap-3 border-t border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">

            <button
                type="button"
                @click="closeCamera()"
                class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800"
            >
                Batal
            </button>

            <button
                type="button"
                @click="capturePhoto()"
                class="flex-1 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                Ambil Foto
            </button>

        </div>

    </div>
</div>


        {{-- =========================
            PHOTO PREVIEW MODAL
        ========================= --}}
        <div
            x-show="imageModal"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[110]
            flex items-center justify-center
            bg-slate-950/90 p-4"
            @keydown.escape.window="imageModal = false"
        >

            <div
                class="absolute inset-0"
                @click="imageModal = false"
            ></div>


            <div
                class="relative z-10 max-h-full
                max-w-5xl"
            >

                <img
                    :src="imageUrl"
                    class="max-h-[90vh] max-w-full
                    rounded-2xl object-contain
                    shadow-2xl"
                >


                <button
                    type="button"
                    @click="imageModal = false"
                    class="absolute -right-2 -top-12
                    flex h-10 w-10 items-center
                    justify-center rounded-full
                    bg-white/10 text-white
                    transition hover:bg-white/20"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>

                </button>

            </div>

        </div>


        {{-- =========================
            FORM SUBMIT HIDDEN
        ========================= --}}
        <form
            x-ref="attendanceForm"
            method="POST"
            enctype="multipart/form-data"
            class="hidden"
        >

            @csrf

            <input
                type="file"
                name="photo"
                x-ref="photoInput"
            >

            <input
                type="hidden"
                name="lat"
                x-ref="latInput"
            >

            <input
                type="hidden"
                name="lng"
                x-ref="lngInput"
            >

            <input
                type="hidden"
                name="address"
                x-ref="addressInput"
            >

        </form>

    </div>


    {{-- =========================
        ALPINE LOGIC
    ========================= --}}
    <script>

        function attendancePage()
        {
            return {

                cameraModal: false,
                imageModal: false,

                imageUrl: '',

                attendanceType: '',

                stream: null,

                cameraError: '',

                lat: '',
                lng: '',
                address: '',
                locationStatus: '',


                openCamera(type)
                {
                    this.attendanceType = type;

                    this.cameraModal = true;

                    this.cameraError = '';

                    this.detectLocation();

                    this.$nextTick(() => {

                        this.startCamera();

                    });
                },


                detectLocation()
                {
                    this.lat = '';
                    this.lng = '';
                    this.address = '';
                    this.locationStatus = 'Mendeteksi lokasi GPS...';

                    if (!navigator.geolocation) {
                        this.locationStatus = 'Browser tidak mendukung GPS';
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.lat = position.coords.latitude.toFixed(7);
                            this.lng = position.coords.longitude.toFixed(7);
                            this.locationStatus = `Lokasi terdeteksi (${this.lat}, ${this.lng})`;
                        },
                        (error) => {
                            console.warn('Geolocation error:', error);
                            this.locationStatus = 'Izin lokasi tidak diberikan (tetap dapat absen)';
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                },


                async startCamera()
                {
                    try {

                        this.stream =
                            await navigator.mediaDevices.getUserMedia({

                                video: {
                                    facingMode: 'user'
                                },

                                audio: false

                            });


                        this.$refs.video.srcObject =
                            this.stream;

                    }
                    catch (error)
                    {

                        this.cameraError =
                            'Kamera tidak dapat diakses. Pastikan izin kamera telah diberikan.';

                        console.error(error);

                    }
                },


                closeCamera()
                {
                    this.stopCamera();

                    this.cameraModal = false;

                    this.cameraError = '';
                },


                stopCamera()
                {
                    if (this.stream)
                    {

                        this.stream
                            .getTracks()
                            .forEach(track => track.stop());

                        this.stream = null;

                    }
                },


                capturePhoto()
                {
                    const video =
                        this.$refs.video;

                    const canvas =
                        this.$refs.canvas;


                    canvas.width =
                        video.videoWidth;

                    canvas.height =
                        video.videoHeight;


                    const context =
                        canvas.getContext('2d');


                    context.drawImage(
                        video,
                        0,
                        0,
                        canvas.width,
                        canvas.height
                    );


                    canvas.toBlob(

                        blob => {

                            const file =
                                new File(

                                    [blob],

                                    'attendance-photo.jpg',

                                    {
                                        type: 'image/jpeg'
                                    }

                                );


                            const dataTransfer =
                                new DataTransfer();


                            dataTransfer.items.add(file);


                            this.$refs.photoInput.files =
                                dataTransfer.files;

                            this.$refs.latInput.value = this.lat || '';
                            this.$refs.lngInput.value = this.lng || '';
                            this.$refs.addressInput.value = this.locationStatus || '';


                            /*
                            |--------------------------------------------------------------------------
                            | ROUTE FORM
                            |--------------------------------------------------------------------------
                            */

                            if (
                                this.attendanceType ===
                                'check-in'
                            )
                            {

                                this.$refs.attendanceForm.action =
                                    "{{ route('siswa.attendances.check-in') }}";

                            }
                            else
                            {

                                this.$refs.attendanceForm.action =
                                    "{{ route('siswa.attendances.check-out') }}";

                            }


                            this.stopCamera();

                            this.$refs.attendanceForm.submit();

                        },

                        'image/jpeg',

                        0.9

                    );

                },


                openImage(url)
                {
                    this.imageUrl = url;

                    this.imageModal = true;
                }

            }
        }

    </script>

</x-layouts.app>