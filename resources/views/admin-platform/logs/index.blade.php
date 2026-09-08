<x-layouts.app :title="'Log Aktivitas Platform - Admin Platform'">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Log Aktivitas</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Log Aktivitas (Audit Trail)
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Rekam jejak seluruh aktivitas penting, mutasi data, dan keamanan sistem platform.
            </p>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <form method="GET" action="{{ route('admin-platform.logs.index') }}" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
            </svg>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari deskripsi aktivitas..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
            >
        </div>

        <div class="flex flex-wrap gap-2">
            <select name="action" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                <option value="">Semua Jenis Aksi</option>
                @foreach ($actions as $act)
                    <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $act)) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 active:scale-95 transition">
                Filter
            </button>

            @if (request()->hasAny(['search', 'action', 'user_id']))
                <a href="{{ route('admin-platform.logs.index') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- TABEL AUDIT LOG --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($logs->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Tidak Ada Catatan Log</h3>
                <p class="mt-1 text-sm text-slate-400">Belum ada riwayat aktivitas yang sesuai dengan filter.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">User Pelaksana</th>
                            <th class="px-6 py-4">Aktivitas</th>
                            <th class="px-6 py-4">Deskripsi Aktivitas</th>
                            <th class="px-6 py-4">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($logs as $log)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Waktu --}}
                                <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-500 dark:text-slate-400">
                                    <div class="font-semibold text-slate-700 dark:text-slate-200">
                                        {{ $log->created_at ? $log->created_at->translatedFormat('d M Y, H:i') : '—' }}
                                    </div>
                                    <div class="text-[11px] text-slate-400">
                                        {{ $log->created_at ? $log->created_at->diffForHumans() : '' }}
                                    </div>
                                </td>

                                {{-- User --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($log->user)
                                        <div class="flex items-center gap-2.5">
                                            <img src="{{ $log->user->avatar_url }}" alt="{{ $log->user->name }}" class="h-7 w-7 rounded-full object-cover">
                                            <div>
                                                <div class="font-bold text-slate-800 dark:text-white text-xs">{{ $log->user->name }}</div>
                                                <div class="text-[11px] text-slate-400">{{ $log->user->role_display_name }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-2 py-0.5 text-xs text-slate-500 dark:bg-slate-800 dark:text-slate-400 font-mono">
                                            System / Bot
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi Badge --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $badgeColor = match(true) {
                                            str_contains($log->action, 'login') => 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
                                            str_contains($log->action, 'approve') => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                                            str_contains($log->action, 'reject') => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                                            str_contains($log->action, 'delete') => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                                            str_contains($log->action, 'create') => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400',
                                            str_contains($log->action, 'update') => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                            default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-mono font-semibold {{ $badgeColor }}">
                                        {{ $log->action }}
                                    </span>
                                </td>

                                {{-- Deskripsi --}}
                                <td class="px-6 py-4 text-slate-700 dark:text-slate-200 text-xs leading-relaxed max-w-md">
                                    {{ $log->description }}
                                </td>

                                {{-- IP --}}
                                <td class="whitespace-nowrap px-6 py-4 text-xs font-mono text-slate-400">
                                    {{ $log->ip_address ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($logs->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $logs->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>
