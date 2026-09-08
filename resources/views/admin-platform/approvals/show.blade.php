<x-layouts.app :title="'Tinjau Pengajuan: ' . $subscription->school_name . ' - Admin Platform'">

    {{-- BREADCRUMB --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin-platform.approvals.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Persetujuan Langganan</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-semibold text-slate-800 dark:text-white">{{ $subscription->school_name }}</span>
    </nav>

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-100 font-extrabold text-2xl text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">
                {{ strtoupper(substr($subscription->school_name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                    Tinjau Pengajuan Langganan
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    {{ $subscription->school_name }} &bull; Diajukan {{ $subscription->created_at->diffForHumans() }}
                </p>
            </div>
        </div>

        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3.5 py-1.5 text-xs font-bold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
            <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
            Menunggu Verifikasi
        </span>
    </div>

    {{-- FLASH / ERRORS --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 dark:border-rose-500/20 dark:bg-rose-500/10">
            <ul class="list-disc list-inside space-y-1 text-xs text-rose-700 dark:text-rose-300">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- INFO SEKOLAH & PAKET --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- DETAIL PROFIL SEKOLAH --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="mb-4 flex items-center gap-2 text-base font-bold text-slate-800 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A48.24 48.24 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.583V21" />
                    </svg>
                    Data Pengajuan Sekolah
                </h2>

                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Sekolah</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white text-sm">{{ $subscription->school_name }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Email Resmi</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white text-sm">{{ $subscription->school_email ?? '—' }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kontak Telepon</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white text-sm">{{ $subscription->school_phone ?? '—' }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Admin Pendaftar</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white text-sm">{{ $subscription->adminUser->name ?? '—' }}</dd>
                    </div>

                    <div class="sm:col-span-2 rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Alamat Lengkap</dt>
                        <dd class="mt-1 text-sm text-slate-700 dark:text-slate-300">{{ $subscription->school_address ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- AKSI PERSETUJUAN / PENOLAKAN --}}
            <div x-data="{ actionTab: 'approve' }" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="mb-4 text-base font-bold text-slate-800 dark:text-white">Keputusan Verifikasi</h2>

                {{-- TABS AKSI --}}
                <div class="flex rounded-xl bg-slate-100 p-1 dark:bg-slate-800 mb-6">
                    <button
                        type="button"
                        @click="actionTab = 'approve'"
                        :class="actionTab === 'approve' ? 'bg-white text-emerald-700 shadow-sm dark:bg-slate-900 dark:text-emerald-400' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'"
                        class="flex-1 rounded-lg py-2.5 text-xs font-bold transition"
                    >
                        ✓ Setujui Pengajuan Langganan
                    </button>
                    <button
                        type="button"
                        @click="actionTab = 'reject'"
                        :class="actionTab === 'reject' ? 'bg-white text-rose-700 shadow-sm dark:bg-slate-900 dark:text-rose-400' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'"
                        class="flex-1 rounded-lg py-2.5 text-xs font-bold transition"
                    >
                        ✕ Tolak Pengajuan
                    </button>
                </div>

                {{-- FORM APPROVE --}}
                <div x-show="actionTab === 'approve'">
                    <form method="POST" action="{{ route('admin-platform.approvals.approve', $subscription->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Pilih Paket Langganan Final <span class="text-rose-500">*</span></label>
                            <select name="package_id" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                                @foreach ($packages as $pkg)
                                    <option value="{{ $pkg->id }}" {{ $subscription->package_id == $pkg->id ? 'selected' : '' }}>
                                        {{ $pkg->name }} — {{ $pkg->price_formatted }} ({{ $pkg->duration_months }} bln / maks {{ $pkg->max_students }} siswa)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Tanggal Mulai Langganan <span class="text-rose-500">*</span></label>
                            <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                            <p class="mt-1 text-xs text-slate-400">Tanggal berakhir akan dihitung secara otomatis berdasarkan durasi paket.</p>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full rounded-xl bg-emerald-600 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 active:scale-95">
                                Konfirmasi & Aktifkan Langganan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- FORM REJECT --}}
                <div x-show="actionTab === 'reject'" x-cloak>
                    <form method="POST" action="{{ route('admin-platform.approvals.reject', $subscription->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Alasan / Catatan Penolakan <span class="text-rose-500">*</span></label>
                            <textarea name="rejection_reason" rows="4" required placeholder="Jelaskan alasan mengapa pengajuan ini ditolak, misalnya dokumen MoU belum lengkap..." class="w-full rounded-xl border border-slate-200 bg-white p-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-rose-400 focus:ring-4 focus:ring-rose-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full rounded-xl bg-rose-600 py-3 text-sm font-bold text-white shadow-lg shadow-rose-600/20 transition hover:bg-rose-700 active:scale-95">
                                Tolak Pengajuan Ini
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        {{-- RIGHT COLUMN: PAKET YANG DIAJUKAN --}}
        <div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-4 text-base font-bold text-slate-800 dark:text-white">Paket yang Diminta Sekolah</h3>

                @if ($subscription->package)
                    <div class="rounded-xl border border-indigo-100 bg-indigo-50/50 p-4 dark:border-indigo-900/30 dark:bg-indigo-950/30 mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Pilihan Sekolah</span>
                        <h4 class="text-lg font-extrabold text-slate-800 dark:text-white mt-1">{{ $subscription->package->name }}</h4>
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                            {{ $subscription->package->price_formatted }}
                            <span class="text-xs font-normal text-slate-400">/ {{ $subscription->package->duration_months }} Bulan</span>
                        </p>
                    </div>

                    <div class="space-y-3 text-xs text-slate-600 dark:text-slate-300">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
                            <span class="text-slate-400">Maks. Siswa PKL</span>
                            <strong class="font-bold text-slate-700 dark:text-slate-200">{{ $subscription->package->max_students }} Siswa</strong>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
                            <span class="text-slate-400">Maks. Guru</span>
                            <strong class="font-bold text-slate-700 dark:text-slate-200">{{ $subscription->package->max_teachers }} Guru</strong>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
                            <span class="text-slate-400">Maks. Mentor</span>
                            <strong class="font-bold text-slate-700 dark:text-slate-200">{{ $subscription->package->max_mentors }} Mentor</strong>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-400">Sekolah belum memilih paket saat pengajuan.</p>
                @endif
            </div>
        </div>

    </div>

</x-layouts.app>
