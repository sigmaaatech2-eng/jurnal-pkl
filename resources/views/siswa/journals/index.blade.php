<x-layouts.app title="Jurnal Saya">

    <div
        x-data="{
            previewOpen: false,
            previewUrl: '',
            previewType: ''
        }"
    >

        {{-- HEADER --}}
        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="mb-2 flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl
                        bg-blue-50 text-blue-600
                        dark:bg-blue-500/10 dark:text-blue-400"
                    >
                        {{-- Icon Document --}}
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
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25h6.75"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12.75h.008v.008H15v-.008zM18 12.75h.008v.008H18v-.008zM15 15.75h.008v.008H15v-.008zM18 15.75h.008v.008H18v-.008z"
                            />
                        </svg>
                    </div>

                    <div>
                        <h1
                            class="text-2xl font-bold tracking-tight
                            text-slate-800 dark:text-white"
                        >
                            Jurnal Saya
                        </h1>

                        <p
                            class="mt-1 text-sm
                            text-slate-500 dark:text-slate-400"
                        >
                            Catat dan pantau aktivitas PKL harianmu.
                        </p>
                    </div>

                </div>
            </div>


            <a
                href="{{ route('siswa.journals.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                bg-blue-600 px-5 py-3 text-sm font-semibold text-white
                shadow-sm transition hover:bg-blue-700
                hover:shadow-md"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Tambah Jurnal

            </a>

        </div>



        {{-- JOURNAL LIST --}}
        <div
            class="overflow-hidden rounded-2xl border
            border-slate-200 bg-white shadow-sm
            dark:border-slate-800 dark:bg-slate-900"
        >

            @if ($journals->isEmpty())

                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center px-6 py-20 text-center">

                    <div
                        class="mb-5 flex h-16 w-16 items-center justify-center
                        rounded-2xl bg-slate-100
                        dark:bg-slate-800"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-slate-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25v-1.5"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12h6m-3-3v6"
                            />
                        </svg>
                    </div>

                    <h2
                        class="text-lg font-semibold
                        text-slate-800 dark:text-white"
                    >
                        Belum ada jurnal
                    </h2>

                    <p
                        class="mt-2 max-w-sm text-sm leading-6
                        text-slate-500 dark:text-slate-400"
                    >
                        Kamu belum membuat catatan kegiatan selama PKL.
                        Mulai dokumentasikan aktivitasmu hari ini.
                    </p>

                    <a
                        href="{{ route('siswa.journals.create') }}"
                        class="mt-6 inline-flex items-center gap-2
                        rounded-xl bg-blue-600 px-5 py-3
                        text-sm font-semibold text-white
                        transition hover:bg-blue-700"
                    >
                        Buat Jurnal Pertama
                    </a>

                </div>

            @else

                {{-- DESKTOP TABLE --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="w-full">

                        <thead
                            class="border-b border-slate-200
                            bg-slate-50
                            dark:border-slate-800 dark:bg-slate-950/40"
                        >
                            <tr>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold
                                    uppercase tracking-wider
                                    text-slate-500 dark:text-slate-400"
                                >
                                    Tanggal
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold
                                    uppercase tracking-wider
                                    text-slate-500 dark:text-slate-400"
                                >
                                    Kegiatan
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold
                                    uppercase tracking-wider
                                    text-slate-500 dark:text-slate-400"
                                >
                                    Status
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold
                                    uppercase tracking-wider
                                    text-slate-500 dark:text-slate-400"
                                >
                                    Lampiran
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold
                                    uppercase tracking-wider
                                    text-slate-500 dark:text-slate-400"
                                >
                                    Aksi
                                </th>

                            </tr>
                        </thead>


                        <tbody
                            class="divide-y divide-slate-100
                            dark:divide-slate-800"
                        >

                            @foreach ($journals as $journal)

                                <tr
                                    class="transition hover:bg-slate-50
                                    dark:hover:bg-slate-800/40"
                                >

                                    {{-- TANGGAL --}}
                                    <td class="whitespace-nowrap px-6 py-5">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 items-center
                                                justify-center rounded-xl
                                                bg-blue-50 text-blue-600
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
                                                        d="M6.75 3v1.5m10.5-1.5v1.5M3.75 18.75V7.5a2.25 2.25 0 012.25-2.25h12a2.25 2.25 0 012.25 2.25v11.25A2.25 2.25 0 0118 21H6a2.25 2.25 0 01-2.25-2.25z"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M3.75 10.5h16.5"
                                                    />
                                                </svg>
                                            </div>

                                            <div>
                                                <p
                                                    class="font-semibold
                                                    text-slate-700 dark:text-slate-200"
                                                >
                                                    {{ $journal->date->format('d M Y') }}
                                                </p>
                                            </div>

                                        </div>

                                    </td>


                                    {{-- JUDUL --}}
                                    <td class="px-6 py-5">

                                        <p
                                            class="max-w-xs truncate font-semibold
                                            text-slate-800 dark:text-slate-100"
                                        >
                                            {{ $journal->title }}
                                        </p>

                                    </td>


                                    {{-- STATUS --}}
                                    <td class="px-6 py-5">

                                        @if ($journal->status === 'pending')

                                            <span
                                                class="inline-flex items-center gap-1.5
                                                rounded-full bg-amber-50 px-3 py-1.5
                                                text-xs font-semibold text-amber-700
                                                dark:bg-amber-500/10 dark:text-amber-400"
                                            >
                                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                                Menunggu Review
                                            </span>

                                        @elseif ($journal->status === 'approved')

                                            <span
                                                class="inline-flex items-center gap-1.5
                                                rounded-full bg-emerald-50 px-3 py-1.5
                                                text-xs font-semibold text-emerald-700
                                                dark:bg-emerald-500/10 dark:text-emerald-400"
                                            >
                                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                                Disetujui
                                            </span>

                                        @elseif ($journal->status === 'rejected')

                                            <span
                                                class="inline-flex items-center gap-1.5
                                                rounded-full bg-red-50 px-3 py-1.5
                                                text-xs font-semibold text-red-700
                                                dark:bg-red-500/10 dark:text-red-400"
                                            >
                                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                                Perlu Revisi
                                            </span>

                                        @endif

                                    </td>


                                    {{-- LAMPIRAN --}}
                                    <td class="px-6 py-5">

                                        @if ($journal->attachment)

                                            <button
                                                type="button"
                                                @click="
                                                    previewUrl = '{{ asset('storage/' . $journal->attachment) }}';
                                                    previewType = '{{ strtolower(pathinfo($journal->attachment, PATHINFO_EXTENSION)) }}';
                                                    previewOpen = true;
                                                "
                                                class="inline-flex items-center gap-2
                                                rounded-lg border border-slate-200
                                                px-3 py-2 text-sm font-medium
                                                text-slate-600 transition
                                                hover:border-blue-200 hover:bg-blue-50
                                                hover:text-blue-600
                                                dark:border-slate-700
                                                dark:text-slate-300
                                                dark:hover:border-blue-500/30
                                                dark:hover:bg-blue-500/10
                                                dark:hover:text-blue-400"
                                            >

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M15 10.5V6.75A2.25 2.25 0 0012.75 4.5h-6A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V12"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M15.75 4.5H21m0 0v5.25M21 4.5l-7.5 7.5"
                                                    />
                                                </svg>

                                                Lihat

                                            </button>

                                        @else

                                            <span
                                                class="text-sm text-slate-400
                                                dark:text-slate-500"
                                            >
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- AKSI --}}
                                    <td class="px-6 py-5 text-right">

                                        <a
                                            href="{{ route('siswa.journals.show', $journal) }}"
                                            class="inline-flex items-center gap-2
                                            text-sm font-semibold text-blue-600
                                            transition hover:text-blue-700
                                            dark:text-blue-400 dark:hover:text-blue-300"
                                        >
                                            Detail

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 5l7 7-7 7"
                                                />
                                            </svg>

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>



                {{-- MOBILE CARD --}}
                <div
                    class="divide-y divide-slate-100 md:hidden
                    dark:divide-slate-800"
                >

                    @foreach ($journals as $journal)

                        <div class="p-5">

                            <div class="flex items-start justify-between gap-4">

                                <div>

                                    <p
                                        class="text-xs font-medium
                                        text-slate-500 dark:text-slate-400"
                                    >
                                        {{ $journal->date->format('d M Y') }}
                                    </p>

                                    <h3
                                        class="mt-1 font-semibold
                                        text-slate-800 dark:text-white"
                                    >
                                        {{ $journal->title }}
                                    </h3>

                                </div>


                                @if ($journal->status === 'pending')

                                    <span
                                        class="whitespace-nowrap rounded-full
                                        bg-amber-50 px-3 py-1
                                        text-xs font-semibold text-amber-700
                                        dark:bg-amber-500/10 dark:text-amber-400"
                                    >
                                        Menunggu
                                    </span>

                                @elseif ($journal->status === 'approved')

                                    <span
                                        class="whitespace-nowrap rounded-full
                                        bg-emerald-50 px-3 py-1
                                        text-xs font-semibold text-emerald-700
                                        dark:bg-emerald-500/10 dark:text-emerald-400"
                                    >
                                        Disetujui
                                    </span>

                                @elseif ($journal->status === 'rejected')

                                    <span
                                        class="whitespace-nowrap rounded-full
                                        bg-red-50 px-3 py-1
                                        text-xs font-semibold text-red-700
                                        dark:bg-red-500/10 dark:text-red-400"
                                    >
                                        Revisi
                                    </span>

                                @endif

                            </div>


                            <div class="mt-5 flex items-center gap-4">

                                <a
                                    href="{{ route('siswa.journals.show', $journal) }}"
                                    class="text-sm font-semibold text-blue-600
                                    dark:text-blue-400"
                                >
                                    Lihat Detail
                                </a>


                                @if ($journal->attachment)

                                    <button
                                        type="button"
                                        @click="
                                            previewUrl = '{{ asset('storage/' . $journal->attachment) }}';
                                            previewType = '{{ strtolower(pathinfo($journal->attachment, PATHINFO_EXTENSION)) }}';
                                            previewOpen = true;
                                        "
                                        class="text-sm font-semibold
                                        text-slate-600 dark:text-slate-300"
                                    >
                                        Lihat Lampiran
                                    </button>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>



        {{-- LIGHTBOX / PREVIEW --}}
        <div
            x-show="previewOpen"
            x-cloak
            @keydown.escape.window="previewOpen = false"
            class="fixed inset-0 z-[999] flex items-center justify-center p-4"
        >

            {{-- BACKDROP --}}
            <div
                @click="previewOpen = false"
                class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm"
            ></div>


            {{-- MODAL --}}
            <div
                @click.stop
                class="relative z-10 flex max-h-[90vh] w-full max-w-5xl
                flex-col overflow-hidden rounded-2xl
                bg-white shadow-2xl
                dark:bg-slate-900"
            >

                {{-- HEADER --}}
                <div
                    class="flex items-center justify-between border-b
                    border-slate-200 px-5 py-4
                    dark:border-slate-800"
                >

                    <div>
                        <h3
                            class="font-semibold text-slate-800
                            dark:text-white"
                        >
                            Preview Lampiran
                        </h3>

                        <p
                            class="mt-0.5 text-xs text-slate-500
                            dark:text-slate-400"
                        >
                            Klik di luar untuk menutup
                        </p>
                    </div>


                    <button
                        type="button"
                        @click="previewOpen = false"
                        class="flex h-9 w-9 items-center justify-center
                        rounded-lg text-slate-500 transition
                        hover:bg-slate-100 hover:text-slate-800
                        dark:text-slate-400 dark:hover:bg-slate-800
                        dark:hover:text-white"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
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


                {{-- CONTENT --}}
                <div
                    class="flex min-h-[300px] items-center justify-center
                    overflow-auto bg-slate-100 p-4
                    dark:bg-slate-950"
                >

                    {{-- IMAGE --}}
                    <template
                        x-if="
                            ['jpg', 'jpeg', 'png', 'gif', 'webp']
                            .includes(previewType)
                        "
                    >
                        <img
                            :src="previewUrl"
                            class="max-h-[75vh] max-w-full rounded-xl object-contain"
                        >
                    </template>


                    {{-- PDF --}}
                    <template x-if="previewType === 'pdf'">

                        <iframe
                            :src="previewUrl"
                            class="h-[75vh] w-full rounded-xl"
                        ></iframe>

                    </template>


                    {{-- OTHER FILE --}}
                    <template
                        x-if="
                            !['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf']
                            .includes(previewType)
                        "
                    >
                        <div class="py-16 text-center">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mx-auto h-12 w-12 text-slate-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25v-1.5"
                                />
                            </svg>

                            <p
                                class="mt-4 text-sm text-slate-500
                                dark:text-slate-400"
                            >
                                Preview tidak tersedia untuk jenis file ini.
                            </p>

                            <a
                                :href="previewUrl"
                                target="_blank"
                                class="mt-4 inline-flex rounded-lg
                                bg-blue-600 px-4 py-2 text-sm
                                font-semibold text-white"
                            >
                                Buka File
                            </a>

                        </div>

                    </template>

                </div>

            </div>

        </div>

    </div>

</x-layouts.app>