<x-layouts.app title="Edit Jurnal">

    <div
        x-data="{
            fileName: '',
            previewUrl: '',
            isImage: false,

            handleFile(event) {
                const file = event.target.files[0];

                if (!file) {
                    this.fileName = '';
                    this.previewUrl = '';
                    this.isImage = false;
                    return;
                }

                this.fileName = file.name;

                if (file.type.startsWith('image/')) {
                    this.isImage = true;
                    this.previewUrl = URL.createObjectURL(file);
                } else {
                    this.isImage = false;
                    this.previewUrl = '';
                }
            }
        }"
    >

        {{-- HEADER --}}
        <div class="mb-8">

            <a
                href="{{ route('siswa.journals.show', $journal) }}"
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

                Kembali ke Detail Jurnal
            </a>


            <div class="mt-5 flex items-start gap-4">

                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center
                    rounded-xl bg-blue-50 text-blue-600
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
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13l-3.143.944.943-3.143a4.5 4.5 0 011.13-1.897l9.247-9.247z"
                        />
                    </svg>
                </div>


                <div>

                    <h1
                        class="text-2xl font-bold tracking-tight
                        text-slate-800 dark:text-white"
                    >
                        Edit Jurnal
                    </h1>

                    <p
                        class="mt-1 text-sm leading-6
                        text-slate-500 dark:text-slate-400"
                    >
                        Perbarui informasi kegiatan PKL yang telah kamu catat.
                    </p>

                </div>

            </div>

        </div>


        {{-- ERROR VALIDATION --}}
        @if ($errors->any())

            <div
                class="mb-6 rounded-2xl border border-red-200
                bg-red-50 p-5
                dark:border-red-500/20 dark:bg-red-500/10"
            >

                <div class="flex gap-3">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 shrink-0 text-red-600
                        dark:text-red-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m9.303 3.376c-.866 1.5-2.79 1.5-3.657 0L12 4.5 6.354 16.126c-.866 1.5-2.79 1.5-3.657 0"
                        />
                    </svg>

                    <div>

                        <p
                            class="font-semibold text-red-800
                            dark:text-red-300"
                        >
                            Ada beberapa data yang perlu diperiksa
                        </p>

                        <ul
                            class="mt-2 list-disc space-y-1 pl-5
                            text-sm text-red-700 dark:text-red-400"
                        >
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                </div>

            </div>

        @endif


        <form
            action="{{ route('siswa.journals.update', $journal) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="grid gap-6 lg:grid-cols-3">

                {{-- FORM UTAMA --}}
                <div
                    class="lg:col-span-2 rounded-2xl border
                    border-slate-200 bg-white p-6 shadow-sm
                    dark:border-slate-800 dark:bg-slate-900"
                >

                    <div class="mb-7">

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
                            Perbarui informasi kegiatan sesuai dengan aktivitas yang telah dilakukan.
                        </p>

                    </div>


                    {{-- TANGGAL --}}
                    <div class="mb-6">

                        <label
                            for="date"
                            class="mb-2 block text-sm font-semibold
                            text-slate-700 dark:text-slate-300"
                        >
                            Tanggal Kegiatan
                        </label>

                        <input
                            type="date"
                            id="date"
                            name="date"
                            value="{{ old('date', $journal->date->format('Y-m-d')) }}"
                            class="w-full rounded-xl border border-slate-200
                            bg-white px-4 py-3 text-sm text-slate-800
                            outline-none transition
                            focus:border-blue-500 focus:ring-4
                            focus:ring-blue-500/10
                            dark:border-slate-700 dark:bg-slate-800
                            dark:text-white dark:[color-scheme:dark]"
                            required
                        >

                    </div>


                    {{-- JUDUL --}}
                    <div class="mb-6">

                        <label
                            for="title"
                            class="mb-2 block text-sm font-semibold
                            text-slate-700 dark:text-slate-300"
                        >
                            Judul Kegiatan
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $journal->title) }}"
                            class="w-full rounded-xl border border-slate-200
                            bg-white px-4 py-3 text-sm text-slate-800
                            placeholder:text-slate-400
                            outline-none transition
                            focus:border-blue-500 focus:ring-4
                            focus:ring-blue-500/10
                            dark:border-slate-700 dark:bg-slate-800
                            dark:text-white"
                            required
                        >

                    </div>


                    {{-- DESKRIPSI --}}
                    <div>

                        <label
                            for="description"
                            class="mb-2 block text-sm font-semibold
                            text-slate-700 dark:text-slate-300"
                        >
                            Deskripsi Kegiatan
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="8"
                            class="w-full resize-none rounded-xl border
                            border-slate-200 bg-white px-4 py-3
                            text-sm leading-6 text-slate-800
                            placeholder:text-slate-400
                            outline-none transition
                            focus:border-blue-500 focus:ring-4
                            focus:ring-blue-500/10
                            dark:border-slate-700 dark:bg-slate-800
                            dark:text-white"
                            required
                        >{{ old('description', $journal->description) }}</textarea>

                    </div>

                </div>


                {{-- SIDEBAR --}}
                <div class="space-y-6">

                    {{-- LAMPIRAN SAAT INI --}}
                    <div
                        class="rounded-2xl border border-slate-200
                        bg-white p-6 shadow-sm
                        dark:border-slate-800 dark:bg-slate-900"
                    >

                        <h3
                            class="font-semibold text-slate-800
                            dark:text-white"
                        >
                            Lampiran Saat Ini
                        </h3>


                        @if ($journal->attachment)

                            @php
                                $extension = strtolower(
                                    pathinfo(
                                        $journal->attachment,
                                        PATHINFO_EXTENSION
                                    )
                                );

                                $isCurrentImage = in_array(
                                    $extension,
                                    ['jpg', 'jpeg', 'png']
                                );
                            @endphp


                            @if ($isCurrentImage)

                                <div class="mt-4">

                                    <img
                                        src="{{ asset('storage/' . $journal->attachment) }}"
                                        alt="Lampiran jurnal"
                                        class="max-h-56 w-full cursor-pointer
                                        rounded-xl border border-slate-200
                                        object-cover transition hover:opacity-90
                                        dark:border-slate-700"
                                        @click="$dispatch(
                                            'open-image-preview',
                                            {
                                                image: '{{ asset('storage/' . $journal->attachment) }}'
                                            }
                                        )"
                                    >

                                </div>

                            @else

                                <a
                                    href="{{ asset('storage/' . $journal->attachment) }}"
                                    target="_blank"
                                    class="mt-4 flex items-center gap-3
                                    rounded-xl border border-slate-200
                                    p-4 text-sm font-medium text-blue-600
                                    transition hover:bg-slate-50
                                    dark:border-slate-700
                                    dark:text-blue-400
                                    dark:hover:bg-slate-800"
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

                                    Lihat Lampiran

                                </a>

                            @endif

                        @else

                            <p
                                class="mt-3 text-sm text-slate-500
                                dark:text-slate-400"
                            >
                                Belum ada lampiran.
                            </p>

                        @endif

                    </div>


                    {{-- GANTI LAMPIRAN --}}
                    <div
                        class="rounded-2xl border border-slate-200
                        bg-white p-6 shadow-sm
                        dark:border-slate-800 dark:bg-slate-900"
                    >

                        <div class="mb-4">

                            <h3
                                class="font-semibold text-slate-800
                                dark:text-white"
                            >
                                Ganti Lampiran
                            </h3>

                            <p
                                class="mt-1 text-xs leading-5
                                text-slate-500 dark:text-slate-400"
                            >
                                Kosongkan jika tidak ingin mengganti file.
                            </p>

                        </div>


                        <label
                            for="attachment"
                            class="flex cursor-pointer flex-col items-center
                            justify-center rounded-xl border border-dashed
                            border-slate-300 px-4 py-8 text-center
                            transition hover:border-blue-400
                            hover:bg-blue-50/50
                            dark:border-slate-700
                            dark:hover:border-blue-500
                            dark:hover:bg-blue-500/5"
                        >

                            <div
                                class="flex h-11 w-11 items-center
                                justify-center rounded-xl
                                bg-slate-100 text-slate-500
                                dark:bg-slate-800 dark:text-slate-400"
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
                                        d="M12 16.5V3.75m0 0L7.5 8.25M12 3.75l4.5 4.5M4.5 14.25v4.5A2.25 2.25 0 006.75 21h10.5a2.25 2.25 0 002.25-2.25v-4.5"
                                    />
                                </svg>
                            </div>


                            <span
                                class="mt-3 text-sm font-semibold
                                text-slate-700 dark:text-slate-300"
                                x-text="fileName || 'Pilih file baru'"
                            ></span>

                            <span
                                class="mt-1 text-xs text-slate-400"
                            >
                                PDF, DOC, DOCX, JPG, JPEG, PNG
                            </span>


                            <input
                                type="file"
                                id="attachment"
                                name="attachment"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                class="hidden"
                                @change="handleFile($event)"
                            >

                        </label>


                        {{-- PREVIEW FILE BARU --}}
                        <template x-if="isImage">

                            <div class="mt-4">

                                <p
                                    class="mb-2 text-xs font-medium
                                    text-slate-500 dark:text-slate-400"
                                >
                                    Preview Lampiran Baru
                                </p>

                                <img
                                    :src="previewUrl"
                                    class="max-h-56 w-full rounded-xl
                                    border border-slate-200 object-cover
                                    dark:border-slate-700"
                                >

                            </div>

                        </template>


                        <p
                            class="mt-4 text-xs text-slate-400
                            dark:text-slate-500"
                        >
                            Ukuran maksimal file 5 MB.
                        </p>

                    </div>

                </div>

            </div>


            {{-- ACTION --}}
            <div
                class="mt-6 flex flex-col-reverse gap-3
                sm:flex-row sm:items-center sm:justify-end"
            >

                <a
                    href="{{ route('siswa.journals.show', $journal) }}"
                    class="inline-flex justify-center rounded-xl
                    border border-slate-200 bg-white px-5 py-3
                    text-sm font-semibold text-slate-600
                    transition hover:bg-slate-50
                    dark:border-slate-700 dark:bg-slate-900
                    dark:text-slate-300 dark:hover:bg-slate-800"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2
                    rounded-xl bg-blue-600 px-6 py-3
                    text-sm font-semibold text-white shadow-sm
                    transition hover:bg-blue-700 hover:shadow-md"
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
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</x-layouts.app>