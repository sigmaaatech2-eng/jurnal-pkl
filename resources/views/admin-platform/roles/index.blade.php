<x-layouts.app :title="'Kelola Role & Hak Akses - Admin Platform'">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Kelola Role &amp; Hak Akses</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Kelola Role &amp; Hak Akses
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Manajemen peran pengguna dan pemetaan izin akses (Spatie Permission) dalam sistem.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-center shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="text-xs font-semibold text-slate-400">Total Role</div>
                <div class="text-xl font-extrabold text-slate-800 dark:text-white">{{ $roles->count() }}</div>
            </div>
            <div class="rounded-xl border border-indigo-200 bg-indigo-50/60 px-4 py-2 text-center shadow-sm dark:border-indigo-500/20 dark:bg-indigo-500/5">
                <div class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">Total Permission</div>
                <div class="text-xl font-extrabold text-slate-800 dark:text-white">{{ $allPermissions->count() }}</div>
            </div>
        </div>
    </div>

    {{-- FLASH ALERT --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ROLE CARDS GRID --}}
    <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @php
            $roleConfig = [
                'siswa' => ['title' => 'Siswa PKL', 'color' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400', 'desc' => 'Mengisi jurnal kegiatan harian, absensi geotagging, dan melihat umpan balik.'],
                'guru_pembimbing' => ['title' => 'Guru Pembimbing', 'color' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400', 'desc' => 'Memantau siswa bimbingan, verifikasi absensi, rekap jurnal, dan nilai.'],
                'mentor' => ['title' => 'Mentor Industri', 'color' => 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400', 'desc' => 'Validasi jurnal harian di tempat kerja dan memberikan penilaian kinerja.'],
                'admin_sekolah' => ['title' => 'Admin Sekolah', 'color' => 'bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400', 'desc' => 'Mengatur penempatan siswa, plotting guru, kelola akun, dan verifikasi sekolah.'],
                'kepala_sekolah' => ['title' => 'Kepala Sekolah', 'color' => 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400', 'desc' => 'Dashboard eksekutif memantau statistik, rekap nilai, dan laporan menyeluruh.'],
                'admin_platform' => ['title' => 'Admin Platform', 'color' => 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400', 'desc' => 'Akses penuh mengelola seluruh subscriber sekolah, paket, audit log, dan pengguna.'],
            ];
        @endphp

        @foreach ($roles as $role)
            @php
                $cfg = $roleConfig[$role->name] ?? [
                    'title' => ucwords(str_replace('_', ' ', $role->name)),
                    'color' => 'bg-slate-50 text-slate-600 dark:bg-slate-800 dark:text-slate-400',
                    'desc' => 'Pengaturan izin dan otoritas hak akses peran sistem.'
                ];
            @endphp
            <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $cfg['color'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                            </svg>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                            {{ $role->permissions_count }} Izin
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                        {{ $cfg['title'] }}
                    </h3>
                    <code class="text-[11px] font-mono text-slate-400">{{ $role->name }}</code>

                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 leading-relaxed min-h-[36px]">
                        {{ $cfg['desc'] }}
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <a
                        href="{{ route('admin-platform.roles.show', $role->id) }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-slate-50 py-2.5 text-xs font-bold text-slate-700 transition hover:bg-blue-600 hover:text-white dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-blue-600 dark:hover:text-white"
                    >
                        <span>Kelola Hak Akses</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- DAFTAR SELURUH PERMISSIONS TERDAFTAR --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="border-b border-slate-100 p-6 dark:border-slate-800">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">Daftar Seluruh Hak Akses Sistem</h2>
            <p class="text-xs text-slate-400 mt-1">{{ $allPermissions->count() }} permission terdaftar dalam guard `web` (Spatie)</p>
        </div>

        <div class="p-6 space-y-6">
            @foreach ($permissionGroups as $group => $perms)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        Modul: {{ strtoupper($group) }}
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($perms as $p)
                            <span class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-mono font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-300">
                                {{ $p->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-layouts.app>
