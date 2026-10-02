<x-layouts.app title="Detail Jurnal">

    <div
        x-data="{
            imageModal: false,
            imageUrl: ''
        }"
        @open-image-preview.window="
            imageUrl = $event.detail.image;
            imageModal = true;
        "
    >

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div
                class="mb-6 flex items-center gap-3 rounded-2xl
                border border-green-200 bg-green-50 p-4
                text-green-700
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
                        d="M9 12.75L11.25 15 15 9.75"
                    />
                </svg>

                {{ session('success') }}

            </div>

        @endif


        {{-- ERROR MESSAGE --}}
        @if (session('error'))

            <div
                class="mb-6 flex items-center gap-3 rounded-2xl
                border border-red-200 bg-red-50 p-4
                text-red-700
                dark:border-red-500/20 dark:bg-red-500/10
                dark:text-red-400"
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
                        d="M15 9l-6 6m0-6l6 6"
                    />
                </svg>

                {{ session('error') }}

            </div>

        @endif


        {{-- HEADER --}}
        <div class="mb-8">

            <a
                href="{{ route('siswa.journals.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium
                text-slate-500 transition hover:text-blue-600
                dark:text-slate-400 dark:hover:text-blue-400"
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
                        d="M15.75 19.5L8.25 12l7.5-7.5"
                    />
                </svg>

                Kembali ke Jurnal Saya

            </a>


            <div class="mt-5 flex items-start gap-4">

                <div
                    class="flex h-12 w-12 shrink-0 items-center
                    justify-center rounded-xl bg-blue-50
                    text-blue-600 dark:bg-blue-500/10
                    dark:text-blue-400"
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
                            d="M19.5 14.25v2.625a3.375 3.375 0 01-3.375 3.375h-8.25A3.375 3.375 0 014.5 16.875V14.25"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 8.25L12 3.75 7.5 8.25M12 3.75v12"
                        />

                    </svg>

                </div>


                <div>

                    <h1
                        class="text-2xl font-bold tracking-tight
                        text-slate-800 dark:text-white"
                    >
                        Detail Jurnal
                    </h1>

                    <p
                        class="mt-1 text-sm text-slate-500
                        dark:text-slate-400"
                    >
                        Informasi lengkap mengenai kegiatan PKL yang telah dicatat.
                    </p>

                </div>

            </div>

        </div>


        <div class="grid gap-6 lg:grid-cols-3">

            {{-- CONTENT UTAMA --}}
            <div class="space-y-6 lg:col-span-2">


                {{-- INFORMASI KEGIATAN --}}
                <div
                    class="rounded-2xl border border-slate-200
                    bg-white p-6 shadow-sm
                    dark:border-slate-800 dark:bg-slate-900"
                >

                    <div
                        class="mb-6 flex items-center justify-between"
                    >

                        <div>

                            <h2
                                class="font-semibold text-slate-800
                                dark:text-white"
                            >
                                Informasi Kegiatan
                            </h2>

                            <p
                                class="mt-1 text-sm text-slate-500
                                dark:text-slate-400"
                            >
                                Detail aktivitas PKL yang telah dicatat.
                            </p>

                        </div>

                    </div>


                    <div
                        class="grid gap-6 border-b border-slate-100
                        pb-6 sm:grid-cols-2
                        dark:border-slate-800"
                    >

                        {{-- TANGGAL --}}
                        <div>

                            <p
                                class="text-xs font-medium uppercase
                                tracking-wider text-slate-400"
                            >
                                Tanggal Kegiatan
                            </p>

                            <p
                                class="mt-2 font-semibold
                                text-slate-800 dark:text-white"
                            >
                                {{ $journal->date->format('d M Y') }}
                            </p>

                        </div>


                        {{-- CREATED --}}
                        <div>

                            <p
                                class="text-xs font-medium uppercase
                                tracking-wider text-slate-400"
                            >
                                Waktu Ditambahkan
                            </p>

                            <p
                                class="mt-2 font-semibold
                                text-slate-800 dark:text-white"
                            >
                                {{ $journal->created_at->format('d M Y, H:i') }}
                            </p>

                        </div>

                    </div>


                    {{-- JUDUL --}}
                    <div
                        class="border-b border-slate-100 py-6
                        dark:border-slate-800"
                    >

                        <p
                            class="text-xs font-medium uppercase
                            tracking-wider text-slate-400"
                        >
                            Judul Kegiatan
                        </p>

                        <h3
                            class="mt-2 text-lg font-semibold
                            text-slate-800 dark:text-white"
                        >
                            {{ $journal->title }}
                        </h3>

                    </div>


                    {{-- DESKRIPSI --}}
                    <div class="pt-6">

                        <p
                            class="text-xs font-medium uppercase
                            tracking-wider text-slate-400"
                        >
                            Deskripsi Kegiatan
                        </p>

                        <p
                            class="mt-3 whitespace-pre-line
                            text-sm leading-7 text-slate-600
                            dark:text-slate-300"
                        >
                            {{ $journal->description }}
                        </p>

                    </div>

                    {{-- LINK TUGAS / PROYEK --}}
                    @if ($journal->link)
                        <div class="mt-6 border-t border-slate-100 pt-6 dark:border-slate-800">
                            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                                Link Proyek / Tugas
                            </p>
                            <div class="mt-3 flex items-center justify-between gap-3 rounded-xl border border-blue-200 bg-blue-50/60 p-4 dark:border-blue-500/20 dark:bg-blue-500/10">
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
                                            Tautan eksternal yang dilampirkan oleh siswa.
                                        </p>
                                    </div>
                                </div>
                                <a
                                    href="{{ $journal->link }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700"
                                >
                                    <span>Buka Link</span>
                                    <span>↗</span>
                                </a>
                            </div>
                        </div>
                    @endif

                </div>


                {{-- LAMPIRAN --}}
                <div
                    class="rounded-2xl border border-slate-200
                    bg-white p-6 shadow-sm
                    dark:border-slate-800 dark:bg-slate-900"
                >

                    <div class="mb-5">

                        <h2
                            class="font-semibold text-slate-800
                            dark:text-white"
                        >
                            Lampiran
                        </h2>

                        <p
                            class="mt-1 text-sm text-slate-500
                            dark:text-slate-400"
                        >
                            File pendukung dari kegiatan PKL.
                        </p>

                    </div>


                    @if ($journal->attachment)

                        @php

                            $extension = strtolower(
                                pathinfo(
                                    $journal->attachment,
                                    PATHINFO_EXTENSION
                                )
                            );

                            $isImage = in_array(
                                $extension,
                                ['jpg', 'jpeg', 'png']
                            );

                            $isZip = $extension === 'zip';

                        @endphp


                        @if ($isImage)

                            <div class="group relative overflow-hidden rounded-xl">

                                <img
                                    src="{{ asset('storage/' . $journal->attachment) }}"
                                    alt="Lampiran jurnal"
                                    class="max-h-[420px] w-full cursor-pointer
                                    rounded-xl object-cover transition
                                    duration-300 group-hover:scale-[1.01]"
                                    @click="
                                        imageUrl = '{{ asset('storage/' . $journal->attachment) }}';
                                        imageModal = true;
                                    "
                                >

                                <button
                                    type="button"
                                    class="absolute inset-0 flex items-center
                                    justify-center bg-slate-950/0
                                    opacity-0 transition
                                    group-hover:bg-slate-950/40
                                    group-hover:opacity-100"
                                    @click="
                                        imageUrl = '{{ asset('storage/' . $journal->attachment) }}';
                                        imageModal = true;
                                    "
                                >

                                    <span
                                        class="rounded-xl bg-white/90
                                        px-4 py-2 text-sm font-medium
                                        text-slate-800 shadow-lg"
                                    >
                                        Lihat Foto
                                    </span>

                                </button>

                            </div>


                        @else

                            <a
                                href="{{ asset('storage/' . $journal->attachment) }}"
                                target="_blank"
                                download
                                class="flex items-center gap-4 rounded-xl
                                border border-slate-200 p-4 transition
                                hover:bg-slate-50
                                dark:border-slate-700
                                dark:hover:bg-slate-800"
                            >

                                @if ($isZip)
                                    <div
                                        class="flex h-12 w-12 shrink-0
                                        items-center justify-center
                                        rounded-xl bg-amber-100 font-extrabold text-amber-700
                                        dark:bg-amber-500/20
                                        dark:text-amber-400"
                                    >
                                        ZIP
                                    </div>
                                @else
                                    <div
                                        class="flex h-11 w-11 shrink-0
                                        items-center justify-center
                                        rounded-xl bg-blue-50 text-blue-600
                                        dark:bg-blue-500/10
                                        dark:text-blue-400"
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
                                                d="M19.5 14.25v2.625a3.375 3.375 0 01-3.375 3.375h-8.25A3.375 3.375 0 014.5 16.875V14.25"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.5 8.25L12 3.75 7.5 8.25M12 3.75v12"
                                            />

                                        </svg>

                                    </div>
                                @endif


                                <div class="flex-1 truncate">

                                    <p
                                        class="text-sm font-semibold
                                        text-slate-700 dark:text-slate-200"
                                    >
                                        Download Lampiran ({{ strtoupper($extension) }})
                                    </p>

                                    <p
                                        class="mt-1 text-xs text-slate-400"
                                    >
                                        Klik untuk mengunduh atau membuka file lampiran.
                                    </p>

                                </div>

                                <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                    Unduh ↗
                                </span>

                            </a>

                        @endif


                    @else

                        <div
                            class="rounded-xl border border-dashed
                            border-slate-300 px-6 py-10 text-center
                            dark:border-slate-700"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mx-auto h-8 w-8 text-slate-300
                                dark:text-slate-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 14.25v2.625a3.375 3.375 0 01-3.375 3.375h-8.25A3.375 3.375 0 014.5 16.875V14.25"
                                />
                            </svg>

                            <p
                                class="mt-3 text-sm text-slate-500
                                dark:text-slate-400"
                            >
                                Tidak ada lampiran pada jurnal ini.
                            </p>

                        </div>

                    @endif

                </div>

            </div>


            {{-- SIDEBAR --}}
            <div class="space-y-6">


                {{-- STATUS REVIEW --}}
                <div
                    class="rounded-2xl border border-slate-200
                    bg-white p-6 shadow-sm
                    dark:border-slate-800 dark:bg-slate-900"
                >

                    <h2
                        class="font-semibold text-slate-800
                        dark:text-white"
                    >
                        Status Review
                    </h2>


                    @if ($journal->status === 'pending')

                        <div
                            class="mt-5 rounded-xl border
                            border-amber-200 bg-amber-50 p-4
                            dark:border-amber-500/20
                            dark:bg-amber-500/10"
                        >

                            <span
                                class="inline-flex rounded-full
                                bg-amber-100 px-3 py-1
                                text-xs font-semibold text-amber-700
                                dark:bg-amber-500/20
                                dark:text-amber-400"
                            >
                                Menunggu Review
                            </span>

                            <p
                                class="mt-3 text-sm leading-6
                                text-amber-800 dark:text-amber-300"
                            >
                                Jurnal sedang menunggu pemeriksaan dari guru pembimbing.
                            </p>

                        </div>

                    @elseif ($journal->status === 'approved')

                        <div
                            class="mt-5 rounded-xl border
                            border-green-200 bg-green-50 p-4
                            dark:border-green-500/20
                            dark:bg-green-500/10"
                        >

                            <span
                                class="inline-flex rounded-full
                                bg-green-100 px-3 py-1
                                text-xs font-semibold text-green-700
                                dark:bg-green-500/20
                                dark:text-green-400"
                            >
                                Disetujui
                            </span>

                            <p
                                class="mt-3 text-sm leading-6
                                text-green-800 dark:text-green-300"
                            >
                                Jurnal telah disetujui oleh guru pembimbing.
                            </p>

                        </div>

                    @elseif ($journal->status === 'rejected')

                        <div
                            class="mt-5 rounded-xl border
                            border-red-200 bg-red-50 p-4
                            dark:border-red-500/20
                            dark:bg-red-500/10"
                        >

                            <span
                                class="inline-flex rounded-full
                                bg-red-100 px-3 py-1
                                text-xs font-semibold text-red-700
                                dark:bg-red-500/20
                                dark:text-red-400"
                            >
                                Ditolak
                            </span>

                            <p
                                class="mt-3 text-sm leading-6
                                text-red-800 dark:text-red-300"
                            >
                                Jurnal perlu diperbaiki sesuai catatan dari guru pembimbing.
                            </p>

                        </div>

                    @endif


                    {{-- FEEDBACK --}}
                    @if ($journal->feedback)

                        <div
                            class="mt-5 border-t border-slate-100
                            pt-5 dark:border-slate-800"
                        >

                            <p
                                class="text-xs font-semibold uppercase
                                tracking-wider text-slate-400"
                            >
                                Catatan Pembimbing
                            </p>

                            <div
                                class="mt-3 rounded-xl bg-slate-50
                                p-4 text-sm leading-6 text-slate-600
                                dark:bg-slate-800 dark:text-slate-300"
                            >
                                {{ $journal->feedback }}
                            </div>

                        </div>

                    @endif

                </div>


                {{-- AKSI --}}
                @if ($journal->status === 'pending')

                    <div
                        class="rounded-2xl border border-slate-200
                        bg-white p-6 shadow-sm
                        dark:border-slate-800 dark:bg-slate-900"
                    >

                        <h2
                            class="font-semibold text-slate-800
                            dark:text-white"
                        >
                            Aksi
                        </h2>

                        <p
                            class="mt-1 text-sm text-slate-500
                            dark:text-slate-400"
                        >
                            Kamu masih dapat mengubah atau menghapus jurnal ini.
                        </p>


                        <div class="mt-5 space-y-3">

                            <a
                                href="{{ route('siswa.journals.edit', $journal) }}"
                                class="flex w-full items-center
                                justify-center rounded-xl bg-blue-600
                                px-4 py-3 text-sm font-semibold
                                text-white transition
                                hover:bg-blue-700"
                            >
                                Edit Jurnal
                            </a>


                            <form
                                method="POST"
                                action="{{ route('siswa.journals.destroy', $journal) }}"
                                onsubmit="return confirm('Yakin ingin menghapus jurnal ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full rounded-xl border
                                    border-red-200 px-4 py-3
                                    text-sm font-semibold text-red-600
                                    transition hover:bg-red-50
                                    dark:border-red-500/20
                                    dark:text-red-400
                                    dark:hover:bg-red-500/10"
                                >
                                    Hapus Jurnal
                                </button>

                            </form>

                        </div>

                    </div>

                @elseif ($journal->status === 'rejected')

                    <div
                        class="rounded-2xl border border-red-200
                        bg-red-50 p-6
                        dark:border-red-500/20
                        dark:bg-red-500/10"
                    >

                        <h2
                            class="font-semibold text-red-800
                            dark:text-red-300"
                        >
                            Perlu Perbaikan
                        </h2>

                        <p
                            class="mt-2 text-sm leading-6
                            text-red-700 dark:text-red-400"
                        >
                            Perbarui jurnal sesuai dengan feedback dari guru pembimbing,
                            kemudian simpan kembali.
                        </p>


                        <a
                            href="{{ route('siswa.journals.edit', $journal) }}"
                            class="mt-5 flex w-full items-center
                            justify-center rounded-xl bg-red-600
                            px-4 py-3 text-sm font-semibold
                            text-white transition hover:bg-red-700"
                        >
                            Perbaiki Jurnal
                        </a>

                    </div>

                @endif

            </div>

        </div>


        {{-- IMAGE LIGHTBOX --}}
        <div
            x-show="imageModal"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[100] flex items-center
            justify-center bg-slate-950/90 p-4"
            @keydown.escape.window="imageModal = false"
        >

            {{-- BACKDROP --}}
            <div
                class="absolute inset-0"
                @click="imageModal = false"
            ></div>


            {{-- IMAGE CONTENT --}}
            <div
                class="relative z-10 flex max-h-full
                max-w-5xl items-center justify-center"
            >

                <img
                    :src="imageUrl"
                    class="max-h-[90vh] max-w-full
                    rounded-xl object-contain shadow-2xl"
                >


                {{-- CLOSE --}}
                <button
                    type="button"
                    @click="imageModal = false"
                    class="absolute -right-2 -top-12 flex
                    h-10 w-10 items-center justify-center
                    rounded-full bg-white/10 text-white
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

    </div>

</x-layouts.app>