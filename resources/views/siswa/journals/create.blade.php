<x-layouts.app title="Tambah Jurnal">

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
                            d="M12 4.5v15m7.5-7.5h-15"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 7.5v-.75A2.25 2.25 0 0017.25 4.5H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25h4.5"
                        />
                    </svg>
                </div>


                <div>

                    <h1
                        class="text-2xl font-bold tracking-tight
                        text-slate-800 dark:text-white"
                    >
                        Tambah Jurnal
                    </h1>

                    <p
                        class="mt-1 text-sm leading-6
                        text-slate-500 dark:text-slate-400"
                    >
                        Catat aktivitas dan kegiatan yang kamu lakukan selama PKL hari ini.
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
            method="POST"
            action="{{ route('siswa.journals.store') }}"
            enctype="multipart/form-data"
        >

            @csrf


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
                            Isi informasi kegiatan PKL yang telah kamu lakukan.
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
                            value="{{ old('date', now()->format('Y-m-d')) }}"
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
                            value="{{ old('title') }}"
                            placeholder="Contoh: Membuat halaman dashboard"
                            class="w-full rounded-xl border border-slate-200
                            bg-white px-4 py-3 text-sm text-slate-800
                            placeholder:text-slate-400
                            outline-none transition
                            focus:border-blue-500 focus:ring-4
                            focus:ring-blue-500/10
                            dark:border-slate-700 dark:bg-slate-800
                            dark:text-white dark:placeholder:text-slate-500"
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
                            placeholder="Jelaskan kegiatan yang kamu lakukan, proses pengerjaan, dan hasil yang diperoleh..."
                            class="w-full resize-none rounded-xl border
                            border-slate-200 bg-white px-4 py-3
                            text-sm leading-6 text-slate-800
                            placeholder:text-slate-400
                            outline-none transition
                            focus:border-blue-500 focus:ring-4
                            focus:ring-blue-500/10
                            dark:border-slate-700 dark:bg-slate-800
                            dark:text-white dark:placeholder:text-slate-500"
                            required
                        >{{ old('description') }}</textarea>

                    </div>

                    {{-- LINK (OPSIONAL) --}}
                    <div class="mt-6">

                        <label
                            for="link"
                            class="mb-2 block text-sm font-semibold
                            text-slate-700 dark:text-slate-300"
                        >
                            Link Tugas / Proyek / Referensi (Opsional)
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                </svg>
                            </div>
                            <input
                                type="url"
                                id="link"
                                name="link"
                                value="{{ old('link') }}"
                                placeholder="https://github.com/... atau https://drive.google.com/..."
                                class="w-full rounded-xl border border-slate-200
                                bg-white py-3 pl-11 pr-4 text-sm text-slate-800
                                placeholder:text-slate-400
                                outline-none transition
                                focus:border-blue-500 focus:ring-4
                                focus:ring-blue-500/10
                                dark:border-slate-700 dark:bg-slate-800
                                dark:text-white dark:placeholder:text-slate-500"
                            >
                        </div>
                        <p class="mt-1.5 text-xs text-slate-400">
                            Tautan GitHub, Google Drive, Figma, Notion, atau demo website.
                        </p>

                    </div>

                </div>


                {{-- SIDEBAR --}}
                <div class="space-y-6">

                    {{-- INFORMASI PKL --}}
                    <div
                        class="rounded-2xl border border-slate-200
                        bg-white p-6 shadow-sm
                        dark:border-slate-800 dark:bg-slate-900"
                    >

                        <div
                            class="mb-4 flex h-10 w-10 items-center
                            justify-center rounded-xl
                            bg-slate-100 text-slate-600
                            dark:bg-slate-800 dark:text-slate-300"
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
                                    d="M3.75 21h16.5M4.5 18.75V9.375M19.5 18.75V9.375M8.25 18.75V9.375M15.75 18.75V9.375M2.25 6.75h19.5L12 2.25 2.25 6.75z"
                                />
                            </svg>
                        </div>


                        <p
                            class="text-xs font-semibold uppercase
                            tracking-wider text-slate-400"
                        >
                            Tempat PKL
                        </p>

                        <p
                            class="mt-2 font-semibold leading-6
                            text-slate-800 dark:text-white"
                        >
                            {{ $internship->company_name }}
                        </p>

                    </div>


                    {{-- LAMPIRAN --}}
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
                                Lampiran
                            </h3>

                            <p
                                class="mt-1 text-xs leading-5
                                text-slate-500 dark:text-slate-400"
                            >
                                Tambahkan bukti kegiatan (gambar, dokumen, atau file ZIP).
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
                                class="flex h-11 w-11 items-center justify-center
                                rounded-xl bg-slate-100 text-slate-500
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
                                x-text="fileName || 'Pilih file'"
                            ></span>

                            <span
                                class="mt-1 text-xs text-slate-400"
                            >
                                PDF, DOC, DOCX, JPG, JPEG, PNG, ZIP
                            </span>


                            <input
                                type="file"
                                id="attachment"
                                name="attachment"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                                class="hidden"
                                @change="handleFile($event)"
                            >

                        </label>


                        {{-- PREVIEW FOTO --}}
                        <template x-if="isImage">

                            <div class="mt-4">

                                <p
                                    class="mb-2 text-xs font-medium
                                    text-slate-500 dark:text-slate-400"
                                >
                                    Preview
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
                            class="mt-4 text-xs leading-5
                            text-slate-400 dark:text-slate-500"
                        >
                            Ukuran maksimal file 20 MB.
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
                    href="{{ route('siswa.journals.index') }}"
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
                    text-sm font-semibold text-white
                    shadow-sm transition
                    hover:bg-blue-700 hover:shadow-md"
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

                    Simpan Jurnal

                </button>

            </div>

        </form>

    </div>

</x-layouts.app>