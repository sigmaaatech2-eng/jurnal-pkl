<x-layouts.app :title="'Kelola Pengguna - Admin Platform'">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Kelola Pengguna</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Kelola Pengguna Administrator
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Kelola akun Administrator Platform dan Administrator Sekolah. (User Guru, Siswa, dan Mentor dikelola oleh masing-masing Admin Sekolah).
            </p>
        </div>
    </div>

    {{-- FLASH ALERT --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- SUMMARY CARDS --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
        {{-- Total --}}
        <a
            href="{{ route('admin-platform.users.index', ['page' => 1]) }}"
            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ !request('role') ? 'ring-2 ring-blue-500/30 dark:border-blue-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-slate-400 dark:text-slate-500">Semua Admin</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalCount }}</div>
        </a>

        @foreach ($roles as $roleItem)
            @php
                $colorMap = [
                    'admin_sekolah' => 'purple',
                    'admin_platform' => 'indigo',
                ];
                $c = $colorMap[$roleItem->name] ?? 'slate';
            @endphp
            <a
                href="{{ route('admin-platform.users.index', array_merge(request()->except('role'), ['role' => $roleItem->name, 'page' => 1])) }}"
                class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-{{ $c }}-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('role') === $roleItem->name ? 'ring-2 ring-' . $c . '-500/30 dark:border-' . $c . '-500/40' : '' }}"
            >
                <div class="text-xs font-semibold text-{{ $c }}-600 dark:text-{{ $c }}-400">{{ ucwords(str_replace('_', ' ', $roleItem->name)) }}</div>
                <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalByRole[$roleItem->name] ?? 0 }}</div>
            </a>
        @endforeach
    </div>

    {{-- SEARCH --}}
    <form method="GET" action="{{ route('admin-platform.users.index') }}" class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        @if (request('role'))
            <input type="hidden" name="role" value="{{ request('role') }}">
        @endif
        <div class="relative w-full lg:max-w-md">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari berdasarkan nama atau email pengguna..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500"
            >
        </div>

        <div class="flex items-center gap-2">
            @if (request()->hasAny(['search', 'role']))
                <a
                    href="{{ route('admin-platform.users.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-600 shadow-sm hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    <span>Reset Filter</span>
                </a>
            @endif
            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 active:scale-95 transition">
                Cari User
            </button>
        </div>
    </form>

    {{-- TABEL PENGGUNA --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($users->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Tidak Ada Pengguna</h3>
                <p class="mt-1 text-sm text-slate-400">Tidak ada user yang cocok dengan filter atau kata kunci pencarian.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role Sistem</th>
                            <th class="px-6 py-4">Asal Instansi / Sekolah</th>
                            <th class="px-6 py-4">Bergabung</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($users as $user)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Nama & Avatar --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-10 w-10 shrink-0 rounded-full object-cover ring-2 ring-slate-200 dark:ring-slate-700">
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">{{ $user->name }}</div>
                                            @if ($user->phone)
                                                <div class="text-xs text-slate-400">{{ $user->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $user->email }}
                                </td>

                                {{-- Role --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $userRole = $user->getRoleNames()->first() ?? 'user';
                                        $roleBadgeClasses = match($userRole) {
                                            'siswa' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
                                            'guru_pembimbing' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                                            'mentor' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                            'admin_sekolah' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400',
                                            'kepala_sekolah' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                                            'admin_platform' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400',
                                            default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold {{ $roleBadgeClasses }}">
                                        {{ $user->role_display_name }}
                                    </span>
                                </td>

                                {{-- Sekolah / Instansi --}}
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $user->school_name ?? $user->company_name ?? '—' }}
                                </td>

                                {{-- Tanggal Daftar --}}
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500 dark:text-slate-400 text-xs">
                                    {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '—' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('admin-platform.users.show', $user->id) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-400 hover:bg-blue-50/50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-blue-500/50 dark:hover:text-blue-400 active:scale-95"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        <span>Kelola</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>
