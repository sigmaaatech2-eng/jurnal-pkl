<x-layouts.app>
    <x-slot:title>
        Profil & Pengaturan Akun - {{ $user->name }}
    </x-slot:title>

    @php
        $roleColor = match ($role) {
            'siswa' => 'blue',
            'guru_pembimbing' => 'emerald',
            'mentor' => 'amber',
            'admin_sekolah' => 'purple',
            'kepala_sekolah' => 'rose',
            'admin_platform' => 'sky',
            default => 'indigo',
        };

        $roleBadgeClasses = match ($role) {
            'siswa' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
            'guru_pembimbing' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
            'mentor' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
            'admin_sekolah' => 'bg-purple-50 text-purple-700 border-purple-200 dark:bg-purple-500/10 dark:text-purple-400 dark:border-purple-500/20',
            'kepala_sekolah' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20',
            'admin_platform' => 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-500/10 dark:text-sky-400 dark:border-sky-500/20',
            default => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20',
        };
    @endphp

    <div class="mx-auto max-w-6xl space-y-5 sm:space-y-7">

        {{-- ALERT NOTIFIKASI --}}
        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                class="flex items-center justify-between gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-emerald-800 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300"
            >
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-500/20">
                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Berhasil!</p>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300">
                    ✕
                </button>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                class="flex items-start justify-between gap-3 rounded-2xl border border-rose-200 bg-rose-50/90 p-4 text-rose-800 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300"
            >
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-rose-100 dark:bg-rose-500/20">
                        <svg class="h-5 w-5 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Terjadi Kesalahan</p>
                        <ul class="mt-1 list-inside list-disc text-xs space-y-0.5 text-rose-700 dark:text-rose-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700 dark:hover:text-rose-300">
                    ✕
                </button>
            </div>
        @endif


        {{-- HERO PROFILE BANNER --}}
        <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900 lg:p-8">
            {{-- Background decorative gradient glow --}}
            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-{{ $roleColor }}-500/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-16 -bottom-16 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"></div>

            <div class="relative flex flex-col items-center gap-6 sm:flex-row sm:items-center sm:justify-between">
                
                {{-- User Avatar & Info --}}
                <div class="flex flex-col items-center gap-5 text-center sm:flex-row sm:text-left">
                    
                    {{-- Avatar Container --}}
                    <div class="relative group">
                        <img
                            src="{{ $user->avatar_url }}"
                            alt="{{ $user->name }}"
                            class="h-24 w-24 rounded-2xl object-cover ring-4 ring-slate-100 shadow-md transition group-hover:scale-105 dark:ring-slate-800 sm:h-28 sm:w-28"
                        >
                        @if ($user->avatar)
                            <form
                                action="{{ route('profile.avatar.destroy') }}"
                                method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto profil ini?')"
                                class="absolute -top-2 -right-2"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    title="Hapus foto profil"
                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-rose-500 text-white shadow hover:bg-rose-600 transition"
                                >
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Identity details --}}
                    <div class="space-y-1.5">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                                {{ $user->name }}
                            </h1>
                            <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-semibold {{ $roleBadgeClasses }}">
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                {{ $user->role_display_name }}
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $user->email }}
                        </p>

                        {{-- Quick role specifics --}}
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 pt-1 text-xs text-slate-600 dark:text-slate-400">
                            @if ($role === 'siswa')
                                @if ($user->nisn)
                                    <span class="flex items-center gap-1 font-medium">
                                        <span class="text-slate-400">NISN:</span> {{ $user->nisn }}
                                    </span>
                                @endif
                                @if ($user->schoolClass?->name ?? $user->kelas)
                                    <span class="rounded-md bg-blue-50 px-2 py-0.5 font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                        {{ $user->schoolClass?->name ?? $user->kelas }}
                                    </span>
                                @endif
                                @if ($user->jurusan)
                                    <span class="rounded-md bg-slate-100 px-2 py-0.5 font-medium dark:bg-slate-800">
                                        {{ $user->jurusan }}
                                    </span>
                                @endif
                            @elseif ($role === 'guru_pembimbing')
                                @if ($user->nip)
                                    <span class="font-medium"><span class="text-slate-400">NIP:</span> {{ $user->nip }}</span>
                                @endif
                                @if ($user->bidang)
                                    <span class="rounded-md bg-emerald-50 px-2 py-0.5 font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        {{ $user->bidang }}
                                    </span>
                                @endif
                            @elseif ($role === 'mentor')
                                @if ($user->company_name)
                                    <span class="font-medium text-slate-700 dark:text-slate-300">🏢 {{ $user->company_name }}</span>
                                @endif
                                @if ($user->position)
                                    <span class="rounded-md bg-amber-50 px-2 py-0.5 font-medium text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                        {{ $user->position }}
                                    </span>
                                @endif
                            @elseif (in_array($role, ['admin_sekolah', 'kepala_sekolah']))
                                @if ($user->school_name)
                                    <span class="font-medium text-slate-700 dark:text-slate-300">🏫 {{ $user->school_name }}</span>
                                @endif
                                @if ($user->nip)
                                    <span>NIP: {{ $user->nip }}</span>
                                @endif
                            @endif

                            @if ($user->phone)
                                <span class="flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $user->phone }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Status Pills / Quick Action --}}
                <div class="flex flex-col sm:items-end gap-2 text-center sm:text-right">
                    <span class="text-xs text-slate-400">
                        Bergabung sejak {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Akun Aktif
                    </span>
                </div>

            </div>
        </div>


        {{-- MAIN GRID CONTENT --}}
        <div class="grid grid-cols-1 gap-7 lg:grid-cols-3">

            {{-- LEFT COLUMN: EDIT FORM & KOSTUMISASI (2 COLS) --}}
            <div class="space-y-7 lg:col-span-2">

                {{-- FORM DATA PROFIL --}}
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:p-8">
                    <div class="mb-6 flex items-center justify-between border-b border-slate-100 pb-5 dark:border-slate-800">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                                Kostumisasi Data Profil
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Sesuaikan informasi identitas diri dan atribut khusus peran Anda.
                            </p>
                        </div>
                        <span class="rounded-xl bg-blue-50 p-2.5 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </span>
                    </div>

                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        x-data="{
                            avatarPreview: null,
                            fileChosen(event) {
                                const file = event.target.files[0];
                                if (!file) return;
                                const reader = new FileReader();
                                reader.onload = (e) => { this.avatarPreview = e.target.result; };
                                reader.readAsDataURL(file);
                            }
                        }"
                        class="space-y-6"
                    >
                        @csrf
                        @method('PUT')

                        {{-- Upload Avatar Section --}}
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">
                                Foto Profil / Avatar
                            </label>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <div class="relative">
                                    <template x-if="avatarPreview">
                                        <img :src="avatarPreview" class="h-16 w-16 rounded-2xl object-cover ring-2 ring-blue-500">
                                    </template>
                                    <template x-if="!avatarPreview">
                                        <img src="{{ $user->avatar_url }}" class="h-16 w-16 rounded-2xl object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                                    </template>
                                </div>
                                <div class="flex-1 space-y-1">
                                    <input
                                        type="file"
                                        name="avatar"
                                        id="avatar"
                                        accept="image/png, image/jpeg, image/jpg, image/webp"
                                        @change="fileChosen"
                                        class="block w-full text-xs text-slate-500 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-slate-200 dark:file:bg-slate-800 dark:file:text-slate-300 dark:hover:file:bg-slate-700 cursor-pointer"
                                    >
                                    <p class="text-[11px] text-slate-400">
                                        Maksimal 3MB (Format JPG, PNG, atau WebP).
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Basic Info Grid --}}
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                >
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                    Alamat Email <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                >
                            </div>

                            <div>
                                <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                    No. Handphone / WhatsApp
                                </label>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    placeholder="Contoh: 081234567890"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                >
                            </div>

                            {{-- ROLE SPECIFIC FIELDS --}}
                            @if ($role === 'siswa')
                                <div>
                                    <label for="nisn" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                        NISN (Nomor Induk Siswa Nasional)
                                    </label>
                                    <input
                                        type="text"
                                        id="nisn"
                                        name="nisn"
                                        placeholder="Contoh: 0051234567"
                                        value="{{ old('nisn', $user->nisn) }}"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                    >
                                </div>

                                @php
                                    $currentMajorId = '';
                                    if (!empty($majors) && $user->jurusan) {
                                        $foundMajor = $majors->first(fn($m) => $m->name === $user->jurusan || $m->id == $user->jurusan);
                                        if ($foundMajor) $currentMajorId = $foundMajor->id;
                                    }
                                    $classesData = ($classes ?? collect())->map(function ($c) {
                                        return [
                                            'id' => $c->id,
                                            'name' => $c->name,
                                            'grade' => $c->grade,
                                            'major_id' => $c->school_major_id,
                                        ];
                                    })->values();
                                @endphp

                                <script>
                                    function profileAcademicForm() {
                                        return {
                                            selectedMajorId: '{{ old('jurusan', $currentMajorId) }}',
                                            selectedClass: '{{ old('kelas', $user->kelas ?? '') }}',
                                            allClasses: @json($classesData),
                                            get filteredClasses() {
                                                if (!this.selectedMajorId) return this.allClasses;
                                                return this.allClasses.filter(c => String(c.major_id) === String(this.selectedMajorId));
                                            },
                                            onMajorChange() {
                                                const match = this.allClasses.find(c => c.name === this.selectedClass && (!this.selectedMajorId || String(c.major_id) === String(this.selectedMajorId)));
                                                if (!match) this.selectedClass = '';
                                            }
                                        };
                                    }
                                </script>

                                <div
                                    class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4"
                                    x-data="profileAcademicForm()"
                                >
                                    <div>
                                        <label for="jurusan" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                            Jurusan / Konsentrasi Keahlian
                                        </label>
                                        @if (!empty($majors) && $majors->isNotEmpty())
                                            <select
                                                id="jurusan"
                                                name="jurusan"
                                                x-model="selectedMajorId"
                                                @change="onMajorChange()"
                                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                            >
                                                <option value="">-- Pilih Jurusan --</option>
                                                @foreach ($majors as $major)
                                                    <option value="{{ $major->id }}" @selected(old('jurusan', $currentMajorId) == $major->id)>
                                                        {{ $major->name }}{{ $major->code ? " ({$major->code})" : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input
                                                type="text"
                                                id="jurusan"
                                                name="jurusan"
                                                placeholder="Contoh: Rekayasa Perangkat Lunak"
                                                value="{{ old('jurusan', $user->jurusan) }}"
                                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                            >
                                        @endif
                                    </div>

                                    <div>
                                        <label for="kelas" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                            Kelas
                                        </label>
                                        @if (!empty($classes) && $classes->isNotEmpty())
                                            <select
                                                id="kelas"
                                                name="kelas"
                                                x-model="selectedClass"
                                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                            >
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach ($classes as $cls)
                                                    <option
                                                        value="{{ $cls->name }}"
                                                        x-show="!selectedMajorId || String(selectedMajorId) === '{{ $cls->school_major_id }}'"
                                                        @selected(old('kelas', $user->schoolClass?->name ?? $user->kelas) == $cls->name)
                                                    >
                                                        {{ $cls->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input
                                                type="text"
                                                id="kelas"
                                                name="kelas"
                                                placeholder="Contoh: XII RPL 1"
                                                value="{{ old('kelas', $user->kelas) }}"
                                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                            >
                                        @endif
                                    </div>
                                </div>

                            @elseif ($role === 'guru_pembimbing')
                                <div>
                                    <label for="nip" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                        NIP / Kode Guru
                                    </label>
                                    <input
                                        type="text"
                                        id="nip"
                                        name="nip"
                                        placeholder="Contoh: 198501012010011001"
                                        value="{{ old('nip', $user->nip) }}"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-emerald-500 dark:focus:bg-slate-800"
                                    >
                                </div>

                                <div>
                                    <label for="bidang" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                        Bidang / Mata Pelajaran
                                    </label>
                                    <input
                                        type="text"
                                        id="bidang"
                                        name="bidang"
                                        placeholder="Contoh: Pemrograman Web & Mobile"
                                        value="{{ old('bidang', $user->bidang) }}"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-emerald-500 dark:focus:bg-slate-800"
                                    >
                                </div>

                            @elseif ($role === 'mentor')
                                <div>
                                    <label for="company_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                        Nama Perusahaan / Instansi DUDI
                                    </label>
                                    <input
                                        type="text"
                                        id="company_name"
                                        name="company_name"
                                        placeholder="Contoh: PT Teknologi Inovasi Mandiri"
                                        value="{{ old('company_name', $user->company_name) }}"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-amber-500 dark:focus:bg-slate-800"
                                    >
                                </div>

                                <div>
                                    <label for="position" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                        Jabatan / Posisi di Industri
                                    </label>
                                    <input
                                        type="text"
                                        id="position"
                                        name="position"
                                        placeholder="Contoh: Senior Tech Lead / HR Mentor"
                                        value="{{ old('position', $user->position) }}"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-amber-500 dark:focus:bg-slate-800"
                                    >
                                </div>

                            @elseif (in_array($role, ['admin_sekolah', 'kepala_sekolah']))
                                <div>
                                    <label for="nip" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                        NIP / ID Pegawai
                                    </label>
                                    <input
                                        type="text"
                                        id="nip"
                                        name="nip"
                                        placeholder="Contoh: 197805152005011002"
                                        value="{{ old('nip', $user->nip) }}"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-purple-500 dark:focus:bg-slate-800"
                                    >
                                </div>

                                <div>
                                    <label for="school_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                        Nama Sekolah
                                    </label>
                                    <input
                                        type="text"
                                        id="school_name"
                                        name="school_name"
                                        placeholder="Contoh: SMKN 1 Jakarta"
                                        value="{{ old('school_name', $user->school_name) }}"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-purple-500 dark:focus:bg-slate-800"
                                    >
                                </div>
                            @endif
                        </div>

                        {{-- Address & Bio --}}
                        <div>
                            <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                Alamat Domisili
                            </label>
                            <textarea
                                id="address"
                                name="address"
                                rows="2"
                                placeholder="Alamat lengkap tempat tinggal..."
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                            >{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div>
                            <label for="bio" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                Bio / Catatan Pribadi
                            </label>
                            <textarea
                                id="bio"
                                name="bio"
                                rows="3"
                                placeholder="Tulis catatan singkat mengenai minat, keahlian, atau moto Anda..."
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                            >{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex flex-col sm:flex-row justify-end pt-2">
                            <button
                                type="submit"
                                class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 active:scale-95 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer"
                            >
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>

                {{-- FORM GANTI PASSWORD --}}
                <div class="rounded-3xl border border-slate-200/80 bg-white p-5 sm:p-6 lg:p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="mb-6 flex items-center justify-between border-b border-slate-100 pb-5 dark:border-slate-800">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                                Keamanan & Kata Sandi
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Pastikan akun Anda menggunakan kata sandi yang aman dan tidak mudah ditebak.
                            </p>
                        </div>
                        <span class="rounded-xl bg-amber-50 p-2.5 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                    </div>

                    <form
                        action="{{ route('profile.password.update') }}"
                        method="POST"
                        x-data="{ showPass: false }"
                        class="space-y-5"
                    >
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                            </label>
                            <input
                                :type="showPass ? 'text' : 'password'"
                                id="current_password"
                                name="current_password"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                            >
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                    Kata Sandi Baru <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    :type="showPass ? 'text' : 'password'"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="Minimal 8 karakter"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                >
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                                    Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    :type="showPass ? 'text' : 'password'"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    placeholder="Ulangi kata sandi baru"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-900 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-500 dark:focus:bg-slate-800"
                                >
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-1">
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-600 dark:text-slate-400 py-1">
                                <input type="checkbox" @change="showPass = !showPass" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-700">
                                <span>Tampilkan Kata Sandi</span>
                            </label>

                            <button
                                type="submit"
                                class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-slate-800 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-900 active:scale-95 dark:bg-slate-700 dark:hover:bg-slate-600 cursor-pointer"
                            >
                                Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>

            </div>


            {{-- RIGHT COLUMN: ROLE CONTEXT & STATS (1 COL) --}}
            <div class="space-y-5 sm:space-y-7">

                {{-- CARD INFORMASI PERAN --}}
                <div class="rounded-3xl border border-slate-200/80 bg-white p-5 sm:p-6 lg:p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="mb-4 text-sm font-bold tracking-wider uppercase text-slate-400">
                        Informasi Peran ({{ $user->role_display_name }})
                    </h3>

                    @if ($role === 'siswa')
                        @if ($internship)
                            <div class="space-y-4">
                                <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-4 dark:border-blue-500/10 dark:bg-blue-500/5">
                                    <p class="text-[11px] font-semibold tracking-wider text-blue-600 dark:text-blue-400 uppercase">
                                        Tempat PKL / Industri
                                    </p>
                                    <p class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                        {{ $internship->company_name }}
                                    </p>
                                    @if ($internship->company_address)
                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                            📍 {{ $internship->company_address }}
                                        </p>
                                    @endif
                                </div>

                                <div class="space-y-3 text-xs">
                                    <div class="flex items-center justify-between border-b border-slate-100 py-2 dark:border-slate-800">
                                        <span class="text-slate-500">Guru Pembimbing:</span>
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $internship->teacher?->name ?? 'Belum ditentukan' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between border-b border-slate-100 py-2 dark:border-slate-800">
                                        <span class="text-slate-500">Mentor Lapangan:</span>
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $internship->mentor?->name ?? 'Belum ditentukan' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between border-b border-slate-100 py-2 dark:border-slate-800">
                                        <span class="text-slate-500">Periode PKL:</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between py-1">
                                        <span class="text-slate-500">Status Magang:</span>
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 uppercase">
                                            {{ $internship->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-slate-200 p-5 text-center text-xs text-slate-500 dark:border-slate-800 dark:text-slate-400">
                                <p>Belum ada penempatan data PKL aktif.</p>
                                <p class="mt-1 text-[11px] text-slate-400">Hubungi Admin Sekolah untuk penempatan PKL.</p>
                            </div>
                        @endif

                    @elseif ($role === 'guru_pembimbing')
                        <div class="space-y-4">
                            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 dark:border-emerald-500/10 dark:bg-emerald-500/5">
                                <p class="text-[11px] font-semibold tracking-wider text-emerald-600 dark:text-emerald-400 uppercase">
                                    Siswa Bimbingan
                                </p>
                                <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">
                                    {{ $stats['assigned_students'] ?? 0 }} <span class="text-sm font-normal text-slate-500">Siswa Aktif</span>
                                </p>
                            </div>

                            @if (isset($relatedUsers) && $relatedUsers->isNotEmpty())
                                <div>
                                    <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                                        Daftar Siswa Bimbingan Terkini:
                                    </p>
                                    <div class="space-y-2">
                                        @foreach ($relatedUsers->take(5) as $student)
                                            <div class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-xs dark:bg-slate-800">
                                                <span class="font-medium text-slate-800 dark:text-slate-200">{{ $student->name }}</span>
                                                <span class="text-[10px] text-slate-400">{{ $student->kelas ?? 'Siswa' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <a
                                href="{{ route('guru-pembimbing.students.index') }}"
                                class="inline-flex w-full items-center justify-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50/50 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400"
                            >
                                Kelola Siswa Bimbingan →
                            </a>
                        </div>

                    @elseif ($role === 'mentor')
                        <div class="space-y-4">
                            <div class="rounded-2xl border border-amber-100 bg-amber-50/50 p-4 dark:border-amber-500/10 dark:bg-amber-500/5">
                                <p class="text-[11px] font-semibold tracking-wider text-amber-600 dark:text-amber-400 uppercase">
                                    Mentoring Industri
                                </p>
                                <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">
                                    {{ $stats['mentored_students'] ?? 0 }} <span class="text-sm font-normal text-slate-500">Siswa Dibimbing</span>
                                </p>
                            </div>

                            @if (isset($relatedUsers) && $relatedUsers->isNotEmpty())
                                <div>
                                    <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                                        Siswa Magang di Perusahaan:
                                    </p>
                                    <div class="space-y-2">
                                        @foreach ($relatedUsers->take(5) as $student)
                                            <div class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-xs dark:bg-slate-800">
                                                <span class="font-medium text-slate-800 dark:text-slate-200">{{ $student->name }}</span>
                                                <span class="text-[10px] text-slate-400">{{ $student->jurusan ?? 'Siswa' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <a
                                href="{{ route('mentor.students.index') }}"
                                class="inline-flex w-full items-center justify-center gap-1.5 rounded-xl border border-amber-200 bg-amber-50/50 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400"
                            >
                                Lihat Jurnal Siswa →
                            </a>
                        </div>

                    @elseif (in_array($role, ['admin_sekolah', 'kepala_sekolah']))
                        <div class="space-y-3 text-xs">
                            <div class="flex items-center justify-between border-b border-slate-100 py-2 dark:border-slate-800">
                                <span class="text-slate-500">Total Siswa Terdaftar:</span>
                                <span class="font-bold text-slate-800 dark:text-white">{{ $stats['total_students'] ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-slate-100 py-2 dark:border-slate-800">
                                <span class="text-slate-500">Guru Pembimbing:</span>
                                <span class="font-bold text-slate-800 dark:text-white">{{ $stats['total_teachers'] ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-slate-100 py-2 dark:border-slate-800">
                                <span class="text-slate-500">Mentor Industri:</span>
                                <span class="font-bold text-slate-800 dark:text-white">{{ $stats['total_mentors'] ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between py-1">
                                <span class="text-slate-500">Total Penempatan PKL:</span>
                                <span class="font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_internships'] ?? 0 }}</span>
                            </div>
                        </div>

                    @else
                        <div class="space-y-3 text-xs">
                            <div class="flex items-center justify-between border-b border-slate-100 py-2 dark:border-slate-800">
                                <span class="text-slate-500">Hak Akses:</span>
                                <span class="font-bold text-slate-800 dark:text-white">Akses Penuh Platform</span>
                            </div>
                            <div class="flex items-center justify-between py-1">
                                <span class="text-slate-500">Total Pengguna:</span>
                                <span class="font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_users'] ?? 0 }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- CARD PREFERENSI TAMPILAN --}}
                <div class="rounded-3xl border border-slate-200/80 bg-white p-5 sm:p-6 lg:p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="mb-3 text-sm font-bold tracking-wider uppercase text-slate-400">
                        Preferensi Tampilan
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                        Pilih tema antarmuka sesuai kenyamanan Anda.
                    </p>

                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                <template x-if="darkMode">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                    </svg>
                                </template>
                                <template x-if="!darkMode">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </template>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800 dark:text-white" x-text="darkMode ? 'Mode Gelap (Dark Mode)' : 'Mode Terang (Light Mode)'"></p>
                                <p class="text-[11px] text-slate-400">Tersimpan di peramban ini</p>
                            </div>
                        </div>

                        <button
                            type="button"
                            @click="toggleDarkMode()"
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                            :class="darkMode ? 'bg-blue-600' : 'bg-slate-300'"
                        >
                            <span
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                :class="darkMode ? 'translate-x-5' : 'translate-x-0'"
                            ></span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-layouts.app>
