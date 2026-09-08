<x-layouts.app title="Manajemen Pengguna">

    {{-- HEADER & BREADCRUMB --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-sekolah.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Admin Sekolah</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Manajemen Pengguna</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Manajemen Pengguna
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Kelola seluruh akun pengguna sekolah, termasuk siswa, guru pembimbing, mentor DUDI, dan kepala sekolah.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin-sekolah.users.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-700 active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Pengguna</span>
            </a>
        </div>
    </div>

    {{-- SUCCESS ALERT --}}
    @if (session('success'))
        <div class="mb-6 flex items-center justify-between gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 shadow-sm">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- STATS CARDS RINGKASAN ROLE --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
        {{-- Card Semua --}}
        <a
            href="{{ route('admin-sekolah.users.index') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('role') == null || request('role') === 'all' ? 'ring-2 ring-blue-500/30 dark:border-blue-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-slate-400 dark:text-slate-500">Semua Pengguna</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $counts['all'] ?? 0 }}
            </div>
        </a>

        {{-- Card Siswa --}}
        <a
            href="{{ route('admin-sekolah.users.index', ['role' => 'siswa']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('role') === 'siswa' ? 'ring-2 ring-blue-500/30 dark:border-blue-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-blue-600 dark:text-blue-400">Siswa PKL</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $counts['siswa'] ?? 0 }}
            </div>
        </a>

        {{-- Card Guru Pembimbing --}}
        <a
            href="{{ route('admin-sekolah.users.index', ['role' => 'guru_pembimbing']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-emerald-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('role') === 'guru_pembimbing' ? 'ring-2 ring-emerald-500/30 dark:border-emerald-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Guru Pembimbing</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $counts['guru_pembimbing'] ?? 0 }}
            </div>
        </a>

        {{-- Card Mentor --}}
        <a
            href="{{ route('admin-sekolah.users.index', ['role' => 'mentor']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-purple-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('role') === 'mentor' ? 'ring-2 ring-purple-500/30 dark:border-purple-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-purple-600 dark:text-purple-400">Mentor DUDI</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $counts['mentor'] ?? 0 }}
            </div>
        </a>

        {{-- Card Kepala Sekolah --}}
        <a
            href="{{ route('admin-sekolah.users.index', ['role' => 'kepala_sekolah']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-amber-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('role') === 'kepala_sekolah' ? 'ring-2 ring-amber-500/30 dark:border-amber-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-amber-600 dark:text-amber-400">Kepala Sekolah</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
                {{ $counts['kepala_sekolah'] ?? 0 }}
            </div>
        </a>
    </div>

    {{-- FILTER SEARCH & TABS --}}
    <form method="GET" action="{{ route('admin-sekolah.users.index') }}" class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <input type="hidden" name="role" value="{{ request('role', 'all') }}">

        {{-- SEARCH INPUT --}}
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
                placeholder="Cari nama atau email pengguna..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500"
            >
        </div>

        {{-- ROLE FILTER TABS --}}
        <div class="flex flex-wrap gap-2">
            @php
                $roleFilters = [
                    'all'             => 'Semua',
                    'siswa'           => 'Siswa',
                    'guru_pembimbing' => 'Guru Pembimbing',
                    'mentor'          => 'Mentor',
                    'kepala_sekolah'  => 'Kepala Sekolah',
                ];
            @endphp

            @foreach ($roleFilters as $val => $label)
                <a
                    href="{{ route('admin-sekolah.users.index', array_merge(request()->query(), ['role' => $val])) }}"
                    class="rounded-xl px-3.5 py-2 text-xs font-semibold transition
                    {{ (request('role', 'all') === $val)
                        ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20'
                        : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </form>

    {{-- TABEL PENGGUNA --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($users->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Tidak Ada Data Pengguna</h3>
                <p class="mt-1 text-sm text-slate-400">Tidak ada akun yang sesuai dengan filter atau kata kunci pencarian Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Pengguna</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Peran (Role)</th>
                            <th class="px-6 py-4">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($users as $user)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Nomor urut --}}
                                <td class="whitespace-nowrap px-6 py-4 text-xs font-semibold text-slate-400">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>

                                {{-- Nama & Avatar --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl font-bold
                                            @if ($user->hasRole('siswa')) bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400
                                            @elseif ($user->hasRole('guru_pembimbing')) bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400
                                            @elseif ($user->hasRole('mentor')) bg-purple-100 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400
                                            @elseif ($user->hasRole('kepala_sekolah')) bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400
                                            @else bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300
                                            @endif
                                        ">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-xs text-slate-400">
                                                ID: #{{ $user->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="font-medium text-slate-700 dark:text-slate-300">
                                        {{ $user->email }}
                                    </span>
                                </td>

                                {{-- Roles --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse ($user->getRoleNames() as $role)
                                            @if ($role === 'siswa')
                                                <span class="inline-flex items-center gap-1 rounded-lg border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                    Siswa PKL
                                                </span>
                                            @elseif ($role === 'guru_pembimbing')
                                                <span class="inline-flex items-center gap-1 rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Guru Pembimbing
                                                </span>
                                            @elseif ($role === 'mentor')
                                                <span class="inline-flex items-center gap-1 rounded-lg border border-purple-200 bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700 dark:border-purple-500/20 dark:bg-purple-500/10 dark:text-purple-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>
                                                    Mentor DUDI
                                                </span>
                                            @elseif ($role === 'kepala_sekolah')
                                                <span class="inline-flex items-center gap-1 rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                    Kepala Sekolah
                                                </span>
                                            @elseif ($role === 'admin_sekolah')
                                                <span class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                                    Admin Sekolah
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                                    {{ $role }}
                                                </span>
                                            @endif
                                        @empty
                                            <span class="text-xs text-slate-400">Tanpa Role</span>
                                        @endforelse
                                    </div>
                                </td>

                                {{-- Terdaftar --}}
                                <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}
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