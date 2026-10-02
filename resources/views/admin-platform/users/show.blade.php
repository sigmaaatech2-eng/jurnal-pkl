<x-layouts.app :title="'Detail Pengguna: ' . $user->name . ' - Admin Platform'">

    {{-- BREADCRUMB --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin-platform.users.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Kelola User</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-semibold text-slate-800 dark:text-white">{{ $user->name }}</span>
    </nav>

    {{-- FLASH ALERT --}}
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

        {{-- LEFT COLUMN: KARTU PROFIL & KONTROL AKUN --}}
        <div class="space-y-6">

            {{-- KARTU FOTO & INFO UTAMA --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 text-center">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="mx-auto h-24 w-24 rounded-full object-cover ring-4 ring-blue-100 dark:ring-blue-900/40">
                <h2 class="mt-4 text-lg font-bold text-slate-800 dark:text-white">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>

                <div class="mt-3">
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                        {{ $user->role_display_name }}
                    </span>
                </div>

                <p class="mt-4 text-xs text-slate-400 border-t border-slate-100 pt-3 dark:border-slate-800">
                    Bergabung sejak {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '—' }}
                </p>
            </div>

            {{-- UBAH ROLE --}}
            @if ($user->id !== auth()->id())
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="mb-3 text-sm font-bold text-slate-800 dark:text-white">Ubah Role Pengguna</h3>
                    <p class="text-xs text-slate-400 mb-4">Ubah hak akses dan hak otoritas akun pengguna ini.</p>

                    <form action="{{ route('admin-platform.users.role', $user->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <select name="role" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full rounded-xl bg-blue-600 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 active:scale-95 transition">
                            Simpan Perubahan Role
                        </button>
                    </form>
                </div>

                {{-- GANTI PASSWORD --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="mb-2 text-sm font-bold text-slate-800 dark:text-white">Ganti Password User</h3>
                    <p class="text-xs text-slate-400 mb-4">Set password baru untuk akun pengguna ini.</p>

                    <form action="{{ route('admin-platform.users.password', $user->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <input
                                type="password"
                                name="password"
                                required
                                placeholder="Password Baru (min 6 karakter)"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                            >
                        </div>
                        <div>
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                placeholder="Konfirmasi Password Baru"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                            >
                        </div>
                        <button type="submit" class="w-full rounded-xl bg-amber-600 py-2.5 text-sm font-bold text-white shadow-md shadow-amber-500/20 hover:bg-amber-700 active:scale-95 transition">
                            Perbarui Password
                        </button>
                    </form>
                </div>

                {{-- KONTROL KEAMANAN --}}
                <div class="rounded-2xl border border-rose-100 bg-rose-50/50 p-6 shadow-sm dark:border-rose-900/30 dark:bg-rose-950/20">
                    <h3 class="mb-2 text-sm font-bold text-rose-700 dark:text-rose-400">Tindakan Keamanan</h3>
                    <p class="text-xs text-rose-600/80 dark:text-rose-300/70 mb-4">Kelola sesi aktif atau hapus akun pengguna jika diperlukan.</p>

                    <div class="space-y-2">
                        <form action="{{ route('admin-platform.users.toggle', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full rounded-xl border border-amber-300 bg-white py-2 text-xs font-bold text-amber-700 hover:bg-amber-50 active:scale-95 transition dark:border-amber-700 dark:bg-slate-800 dark:text-amber-300">
                                Logout Paksa Semua Sesi
                            </button>
                        </form>

                        <form action="{{ route('admin-platform.users.destroy', $user->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-xl border border-rose-300 bg-white py-2 text-xs font-bold text-rose-700 hover:bg-rose-50 active:scale-95 transition dark:border-rose-700 dark:bg-slate-800 dark:text-rose-300">
                                Hapus Akun Pengguna
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>

        {{-- RIGHT COLUMN: DETAIL DATA & AUDIT LOG --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- INFORMASI LENGKAP --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-4 text-base font-bold text-slate-800 dark:text-white">Informasi Akun</h3>

                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Lengkap</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white">{{ $user->name }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Alamat Email</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white">{{ $user->email }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nomor Telepon</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white">{{ $user->phone ?? '—' }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sekolah / Instansi</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white">{{ $user->school_name ?? $user->company_name ?? '—' }}</dd>
                    </div>

                    @if ($user->nisn || $user->nip)
                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $user->nisn ? 'NISN' : 'NIP' }}</dt>
                            <dd class="mt-1 font-bold text-slate-800 dark:text-white">{{ $user->nisn ?? $user->nip }}</dd>
                        </div>
                    @endif

                    @if ($user->jurusan || $user->kelas)
                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Jurusan & Kelas</dt>
                            <dd class="mt-1 font-bold text-slate-800 dark:text-white">{{ trim(($user->jurusan ?? '') . ' ' . ($user->kelas ?? '')) ?: '—' }}</dd>
                        </div>
                    @endif

                    @if ($user->address)
                        <div class="sm:col-span-2 rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Alamat</dt>
                            <dd class="mt-1 text-slate-700 dark:text-slate-300">{{ $user->address }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- RIWAYAT AKTIVITAS USER --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 p-5 dark:border-slate-800">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Riwayat Audit Aktivitas Pengguna</h3>
                </div>

                @if ($recentLogs->isEmpty())
                    <div class="p-8 text-center">
                        <p class="text-sm text-slate-400">Belum ada catatan aktivitas untuk pengguna ini.</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($recentLogs as $log)
                            <div class="flex items-center justify-between p-4 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $log->description }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">IP: {{ $log->ip_address ?? '—' }}</p>
                                </div>
                                <span class="text-xs text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>

</x-layouts.app>
