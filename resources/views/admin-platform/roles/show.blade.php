<x-layouts.app :title="'Detail Role: ' . $role->name . ' - Admin Platform'">

    {{-- BREADCRUMB --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin-platform.roles.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Role & Permission</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-semibold text-slate-800 dark:text-white">{{ ucwords(str_replace('_', ' ', $role->name)) }}</span>
    </nav>

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Kelola Permission: {{ ucwords(str_replace('_', ' ', $role->name)) }}
            </h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Identifier sistem: <code class="font-mono text-xs bg-slate-100 px-1.5 py-0.5 rounded text-slate-700 dark:bg-slate-800 dark:text-slate-300">{{ $role->name }}</code> &bull; {{ $userCount }} pengguna terdaftar
            </p>
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

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- FORM MATRIX PERMISSION --}}
        <div class="lg:col-span-2">
            <form action="{{ route('admin-platform.roles.permissions', $role->id) }}" method="POST">
                @csrf
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-100 p-6 dark:border-slate-800 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-slate-800 dark:text-white">Matriks Hak Akses (Permissions)</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Centang atau hilangkan centang hak akses untuk peran ini</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        @foreach ($allPermissions->groupBy(fn($p) => explode('-', $p->name)[0]) as $group => $perms)
                            <div>
                                <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                                    Modul {{ strtoupper($group) }}
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    @foreach ($perms as $permission)
                                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/50 p-3.5 transition hover:border-blue-300 hover:bg-blue-50/30 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:border-blue-500/40 dark:hover:bg-blue-900/10">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->name }}"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800"
                                            >
                                            <span class="text-xs font-mono font-medium text-slate-700 dark:text-slate-300">{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-100 p-6 dark:border-slate-800">
                        <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 hover:bg-blue-700 active:scale-95 transition">
                            Simpan Perubahan Hak Akses
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- SIDEBAR: PENGGUNA DENGAN ROLE INI --}}
        <div>
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 p-5 dark:border-slate-800">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Pengguna Terkait</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $userCount }} akun memiliki role ini</p>
                </div>

                @if ($users->isEmpty())
                    <div class="p-6 text-center">
                        <p class="text-xs text-slate-400">Belum ada user yang memiliki role ini.</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($users as $u)
                            <div class="flex items-center justify-between p-4 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="h-8 w-8 rounded-full object-cover">
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 dark:text-white">{{ $u->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $u->email }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin-platform.users.show', $u->id) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                    Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>

</x-layouts.app>
