@php
    $notifications = auth()->user()
        ? auth()->user()->notifications()->latest()->take(5)->get()
        : collect();

    $unreadNotifications = auth()->user()
        ? auth()->user()->unreadNotifications()->count()
        : 0;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, viewport-fit=cover"
    >

    <title>
        {{ $title ?? 'Jurnal PKL Online' }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const savedDarkMode = localStorage.getItem('darkMode');

            const isDark = savedTheme
                ? savedTheme === 'dark'
                : (savedDarkMode !== null
                    ? savedDarkMode === 'true'
                    : window.matchMedia('(prefers-color-scheme: dark)').matches);

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head> 

<body
    x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        sidebarOpen: false,

        toggleDarkMode() {
            this.darkMode = !this.darkMode;

            document.documentElement.classList.toggle('dark', this.darkMode);

            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            localStorage.setItem('darkMode', this.darkMode ? 'true' : 'false');
        }
    }"
    class="bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#070b18] dark:text-slate-100"
>

<div class="flex min-h-screen">

    {{-- OVERLAY MOBILE --}}
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden"
    ></div>


    {{-- SIDEBAR --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-[280px] sm:w-[290px] flex-col
        border-r border-slate-200/80 bg-white transition-transform duration-300 ease-in-out
        dark:border-slate-800 dark:bg-slate-900
        lg:static lg:translate-x-0 lg:shadow-none"
    >

        {{-- LOGO --}}
        <div class="flex h-16 sm:h-20 items-center justify-between px-6 border-b border-slate-100 dark:border-slate-800">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl bg-blue-50 dark:bg-blue-500/10">
                    <img
                        src="{{ asset('images/logo-jurnal-pkl.png') }}"
                        alt="Jurnal PKL"
                        class="h-full w-full object-contain"
                    >
                </div>

                <div>

                    <h1 class="text-sm font-bold tracking-[0.16em] text-slate-800 dark:text-white">
                        JURNAL <span class="text-blue-600">PKL</span>
                    </h1>

                    <p class="text-[9px] tracking-[0.3em] text-slate-400">
                        ONLINE
                    </p>

                </div>

            </div>


            <button
                @click="sidebarOpen = false"
                class="lg:hidden flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition"
                aria-label="Tutup Menu"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>


        {{-- MENU --}}
        <nav class="flex-1 overflow-y-auto px-4 py-6 custom-scrollbar">

            <p class="mb-3 px-3 text-[11px] font-bold tracking-wider uppercase text-slate-400">
                MENU UTAMA
            </p>


            {{-- SISWA --}}
            @role('siswa')

                <a
                    href="{{ route('siswa.dashboard') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('siswa.dashboard')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
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
                            d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75"
                        />
                    </svg>

                    Dashboard

                </a>


                <a
                    href="{{ route('siswa.journals.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('siswa.journals.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
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
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-8.25A3.375 3.375 0 0 0 4.5 11.625v6.75a3.375 3.375 0 0 0 3.375 3.375H16.5"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 3.75h7.5"
                        />
                    </svg>

                    Jurnal Saya

                </a>


                <a
                    href="{{ route('siswa.attendances.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('siswa.attendances.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="4"
                            width="18"
                            height="17"
                            rx="2"
                        />

                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>

                    Absensi

                </a>

            @endrole

            {{-- GURU PEMBIMBING --}}
            @role('guru_pembimbing')

                <a
                    href="{{ route('guru-pembimbing.dashboard') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('guru-pembimbing.dashboard')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
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
                            d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75"
                        />
                    </svg>

                    Dashboard
                </a>

                <a
                    href="{{ route('guru-pembimbing.journals.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('guru-pembimbing.journals.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
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
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-8.25A3.375 3.375 0 0 0 4.5 11.625v6.75a3.375 3.375 0 0 0 3.375 3.375H16.5"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 3.75h7.5"
                        />
                    </svg>

                    Monitoring Jurnal
                </a>

                <a
                    href="{{ route('guru-pembimbing.students.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('guru-pembimbing.students.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
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
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                        />
                    </svg>

                    Siswa Bimbingan
                </a>

                <a
                    href="{{ route('guru-pembimbing.attendances.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('guru-pembimbing.attendances.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="4"
                            width="18"
                            height="17"
                            rx="2"
                        />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>

                    Monitoring Absensi
                </a>

                <a
                    href="{{ route('guru-pembimbing.recap.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('guru-pembimbing.recap.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
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
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"
                        />
                    </svg>

                    Rekap PKL
                </a>

            @endrole

            {{-- MENTOR --}}
            @role('mentor')

                <a
                    href="{{ route('mentor.dashboard') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('mentor.dashboard')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
                    </svg>
                    Dashboard
                </a>

                <a
                    href="{{ route('mentor.students.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('mentor.students.index')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    Daftar Siswa
                </a>

                <a
                    href="{{ route('mentor.students.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ (request()->routeIs('mentor.students.show') || request()->routeIs('mentor.journals.*'))
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    Jurnal Siswa
                </a>

            @endrole

            {{-- ADMIN SEKOLAH --}}
            @role('admin_sekolah')

                <a
                    href="{{ route('admin-sekolah.dashboard') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-sekolah.dashboard')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
                    </svg>
                    Dashboard
                </a>

                <a
                    href="{{ route('admin-sekolah.students.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-sekolah.students.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    Data Siswa
                </a>

                <a
                    href="{{ route('admin-sekolah.internships.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-sekolah.internships.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                    Penempatan PKL
                </a>

                <a
                    href="{{ route('admin-sekolah.users.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-sekolah.users.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.999-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    Manajemen User
                </a>

                <a
                    href="{{ route('admin-sekolah.school-data.majors.index') }}"
                    class="mb-2 flex items-center justify-between rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-sekolah.school-data.majors.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
                        </svg>
                        <span>Data Jurusan</span>
                    </div>
                </a>

                <a
                    href="{{ route('admin-sekolah.school-data.classes.index') }}"
                    class="mb-2 flex items-center justify-between rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-sekolah.school-data.classes.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                        <span>Data & Form Kelas</span>
                    </div>
                    <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">Form</span>
                </a>

            @endrole


            {{-- KEPALA SEKOLAH --}}
            @role('kepala_sekolah')

                <a
                    href="{{ route('kepala-sekolah.dashboard') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('kepala-sekolah.dashboard')
                        ? 'bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
                    </svg>
                    Dashboard
                </a>

                <a
                    href="{{ route('kepala-sekolah.students.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('kepala-sekolah.students.*')
                        ? 'bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    Monitoring Siswa
                </a>

                <a
                    href="{{ route('kepala-sekolah.journals.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('kepala-sekolah.journals.*')
                        ? 'bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    Monitoring Jurnal
                </a>

                <a
                    href="{{ route('kepala-sekolah.attendances.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('kepala-sekolah.attendances.*')
                        ? 'bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M8 2v4M16 2v4M3 10h18" />
                    </svg>
                    Monitoring Absensi
                </a>

                <a
                    href="{{ route('kepala-sekolah.recap.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('kepala-sekolah.recap.*')
                        ? 'bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    Rekap PKL
                </a>

            @endrole

            {{-- ADMIN PLATFORM --}}
            @role('admin_platform')

                <a
                    href="{{ route('admin-platform.dashboard') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.dashboard')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
                    </svg>
                    Dashboard
                </a>

                <a
                    href="{{ route('admin-platform.schools.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.schools.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                    Subscriber Sekolah
                </a>

                <a
                    href="{{ route('admin-platform.packages.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.packages.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Kelola Paket
                </a>

                <a
                    href="{{ route('admin-platform.approvals.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.approvals.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Persetujuan Langganan
                </a>

                <a
                    href="{{ route('admin-platform.payments.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.payments.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 2.25 19.5Z" />
                    </svg>
                    Riwayat Pembayaran
                </a>

                <a
                    href="{{ route('admin-platform.users.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.users.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    Kelola User
                </a>

                <a
                    href="{{ route('admin-platform.roles.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.roles.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-2.18-4.303a6.002 6.002 0 0 1 6.93 6.93 6.002 6.002 0 0 1-6.93 6.93 6.002 6.002 0 0 1-6.93-6.93 6.002 6.002 0 0 1 6.93-6.93ZM12 6.75V3m0 18v-3.75m6-6h3.75m-18 0H6" />
                    </svg>
                    Role & Permission
                </a>

                <a
                    href="{{ route('admin-platform.logs.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.logs.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Log Aktivitas
                </a>

                <a
                    href="{{ route('admin-platform.reports.index') }}"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                    text-sm font-medium transition
                    {{ request()->routeIs('admin-platform.reports.*')
                        ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 font-semibold'
                        : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                    }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    Laporan Platform
                </a>

            @endrole

            <p class="mb-4 mt-6 px-3 text-[11px] font-semibold tracking-wider text-slate-400">
                PENGATURAN
            </p>

            <a
                href="{{ route('profile.edit') }}"
                class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3
                text-sm font-medium transition
                {{ request()->routeIs('profile.*')
                    ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/10'
                    : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'
                }}"
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
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                </svg>

                Profil Saya
            </a>

        </nav>


        {{-- QUOTE --}}
        <div class="mx-5 mb-5 rounded-2xl border border-slate-100 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-800/50">

            <div class="mb-3 text-2xl text-blue-600">
                “
            </div>

            <p class="text-sm leading-6 text-slate-500 dark:text-slate-400">
                Terus catat setiap prosesmu, karena pengalaman hari ini adalah bekal masa depan.
            </p>

            <div class="mt-5 h-1 w-16 rounded-full bg-blue-600"></div>

        </div>


        {{-- VERSION --}}
        <div class="border-t border-slate-100 px-8 py-5 text-xs text-slate-400 dark:border-slate-800">

            <p class="font-medium text-slate-500 dark:text-slate-300">
                Jurnal PKL Online
            </p>

            <p class="mt-1">
                v1.0.0
            </p>

        </div>

    </aside>



    {{-- MAIN --}}
    <div class="min-w-0 flex-1 flex flex-col min-h-screen">

        {{-- HEADER --}}
        <header
            class="sticky top-0 z-30 flex h-16 sm:h-20 items-center justify-between
            border-b border-slate-200/80 bg-white/85 px-4 sm:px-6 lg:px-8 backdrop-blur-md
            dark:border-slate-800/80 dark:bg-slate-900/85 transition-colors"
        >

            <div class="flex items-center gap-3 sm:gap-4">

                {{-- MOBILE MENU BUTTON --}}
                <button
                    @click="sidebarOpen = true"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 active:scale-95 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 lg:hidden"
                    aria-label="Buka Menu"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                {{-- MOBILE BRAND TITLE --}}
                <div class="flex items-center gap-2.5 lg:hidden">
                    <div class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-xl bg-blue-50 p-0.5 shadow-sm dark:bg-blue-500/10">
                        <img
                            src="{{ asset('images/logo-jurnal-pkl.png') }}"
                            alt="Jurnal PKL"
                            class="h-full w-full object-contain"
                        >
                    </div>
                    <span class="text-xs font-bold tracking-wider text-slate-800 dark:text-white uppercase">
                        Jurnal <span class="text-blue-600">PKL</span>
                    </span>
                </div>

                {{-- DESKTOP SEARCH --}}
                <div class="hidden w-[320px] xl:w-[380px] lg:block">

                    <div class="relative">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                            />
                        </svg>

                        <input
                            type="text"
                            placeholder="Cari aktivitas, jurnal, siswa..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/80 py-2.5 pl-10 pr-4 text-xs text-slate-800 placeholder:text-slate-400 outline-none transition
                            focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20
                            dark:border-slate-700 dark:bg-slate-800/80 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:bg-slate-800"
                        >

                    </div>

                </div>

            </div>


            <div class="flex items-center gap-3 lg:gap-5">


                {{-- DARK MODE --}}
                <button
                    type="button"
                    @click="toggleDarkMode()"
                    id="theme-toggle"
                    class="flex h-11 w-11 items-center justify-center rounded-xl
                    border border-slate-200 bg-slate-50 text-slate-600
                    transition-all duration-300
                    hover:bg-slate-100 hover:scale-105
                    dark:border-slate-700
                    dark:bg-slate-800
                    dark:text-yellow-400
                    dark:hover:bg-slate-700"
                    :title="darkMode ? 'Beralih ke mode terang' : 'Beralih ke mode gelap'"
                >

                    {{-- Icon Moon (tampil saat mode terang) --}}
                    <svg
                        id="moon-icon"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 dark:hidden"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21.752 15.002A9.718 9.718 0 0 1 12 21.75C6.615 21.75 2.25 17.385 2.25 12A9.718 9.718 0 0 1 8.998 2.248 7.5 7.5 0 0 0 21.752 15.002Z"
                        />
                    </svg>

                    {{-- Icon Sun (tampil saat mode gelap) --}}
                    <svg
                        id="sun-icon"
                        xmlns="http://www.w3.org/2000/svg"
                        class="hidden h-5 w-5 dark:block"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3v2.25m0 13.5V21m9-9h-2.25M5.25 12H3m15.364 6.364-1.591-1.591M7.227 7.227 5.636 5.636m12.728 0-1.591 1.591M7.227 16.773l-1.591 1.591M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                        />
                    </svg>

                </button>


                {{-- NOTIFICATION --}}
                <div
                    x-data="{ notificationOpen: false }"
                    class="relative"
                >
                    <button
                        type="button"
                        @click="notificationOpen = !notificationOpen"
                        class="relative flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl
                        border border-slate-200 bg-white text-slate-600 shadow-sm
                        transition-all duration-200 hover:bg-slate-50
                        dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300
                        dark:hover:bg-slate-700"
                    >
                        {{-- Bell Icon --}}
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
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.31 6.022 23.848 23.848 0 0 0 5.454 1.31m5.713 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                            />
                        </svg>

                        {{-- Badge jumlah notifikasi --}}
                        @if ($unreadNotifications > 0)
                            <span
                                class="absolute -right-1 -top-1 flex h-4 min-w-4 sm:h-5 sm:min-w-5 items-center
                                justify-center rounded-full bg-rose-500 px-1 text-[9px] sm:text-[10px]
                                font-bold text-white shadow"
                            >
                                {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                            </span>
                        @endif
                    </button>


                    {{-- Dropdown Notifikasi Mobile & Desktop Optimized --}}
                    <div
                        x-show="notificationOpen"
                        @click.outside="notificationOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        x-cloak
                        class="fixed inset-x-3 top-18 sm:absolute sm:inset-auto sm:right-0 sm:top-full sm:mt-3 sm:w-96 max-w-sm overflow-hidden rounded-2xl
                        border border-slate-200 bg-white shadow-2xl z-50
                        dark:border-slate-700 dark:bg-slate-900"
                    >

        {{-- Header --}}
        <div
            class="flex items-center justify-between border-b
            border-slate-100 px-5 py-4
            dark:border-slate-800"
        >
            <div>
                <h3
                    class="font-semibold text-slate-900
                    dark:text-white"
                >
                    Notifikasi
                </h3>

                <p
                    class="mt-1 text-xs text-slate-500
                    dark:text-slate-400"
                >
                    {{ $unreadNotifications }} belum dibaca
                </p>
            </div>
        </div>


        {{-- List Notifikasi --}}
        <div class="max-h-[400px] overflow-y-auto">

            @forelse ($notifications as $notification)

                @php
                    $notifStatus = $notification->data['status'] ?? '';
                    $notifType   = $notification->data['type'] ?? '';
                    $isUnread    = is_null($notification->read_at);

                    $iconBg = match(true) {
                        $notifStatus === 'approved'                => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400',
                        $notifStatus === 'rejected'                => 'bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400',
                        $notifType   === 'journal_pending'         => 'bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400',
                        default                                    => 'bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400',
                    };
                @endphp
                <a
                    href="{{ route('notifications.read', $notification->id) }}"
                    class="flex gap-3 border-b border-slate-100 px-5 py-4 transition
                           hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/60
                           {{ $isUnread ? 'bg-blue-50/60 dark:bg-blue-500/5 border-l-2 border-l-blue-400' : '' }}"
                >
                    {{-- Icon berdasarkan tipe notifikasi --}}
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $iconBg }}">
                        @if ($notifType === 'journal_pending')
                            {{-- Bell / review icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.31 6.022 23.848 23.848 0 0 0 5.454 1.31m5.713 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        @elseif ($notifStatus === 'approved')
                            {{-- Centang --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        @elseif ($notifStatus === 'rejected')
                            {{-- Silang / revisi --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                                {{ $notification->data['title'] }}
                            </p>
                            @if ($isUnread)
                                <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                            @endif
                        </div>

                        <p class="mt-1 text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                            {{ $notification->data['message'] }}
                        </p>

                        <p class="mt-1.5 text-[11px] text-slate-400 dark:text-slate-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                </a>

            @empty

                <div class="px-5 py-10 text-center">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto h-10 w-10 text-slate-300 dark:text-slate-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 0 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 0 1-6 0v-1m6 0H9"
                        />
                    </svg>

                    <p
                        class="mt-3 text-sm text-slate-500
                        dark:text-slate-400"
                    >
                        Belum ada notifikasi
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>


                {{-- USER --}}
                <div class="flex items-center gap-2 sm:gap-3">

                    <a
                        href="{{ route('profile.edit') }}"
                        class="group flex items-center gap-3 rounded-2xl p-1.5 transition hover:bg-slate-100 dark:hover:bg-slate-800"
                        title="Buka Profil Saya"
                    >
                        <img
                            src="{{ auth()->user()->avatar_url }}"
                            alt="{{ auth()->user()->name }}"
                            class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-200 transition group-hover:ring-blue-500 dark:ring-slate-700"
                        >

                        <div class="hidden text-left sm:block">
                            <p class="text-sm font-semibold text-slate-700 transition group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ auth()->user()->role_display_name }}
                            </p>
                        </div>
                    </a>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf
                        <button
                            type="submit"
                            title="Keluar dari akun"
                            class="rounded-xl p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition dark:hover:bg-rose-500/10 dark:hover:text-rose-400"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}
        <main class="flex-1 p-3 sm:p-5 md:p-6 lg:p-8 safe-main-content">

            {{ $slot }}

        </main>

    </div>

</div>

{{-- BOTTOM NAVIGATION BAR FOR MOBILE (PHONES & TABLETS IN PORTRAIT) --}}
<nav class="fixed bottom-0 inset-x-0 z-40 border-t border-slate-200/80 bg-white/95 px-2 backdrop-blur-lg dark:border-slate-800/80 dark:bg-slate-900/95 lg:hidden safe-bottom-nav">
    <div class="mx-auto flex h-full w-full max-w-md items-center justify-around sm:max-w-xl">
    @role('siswa')
        <a
            href="{{ route('siswa.dashboard') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('siswa.dashboard') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
            </svg>
            <span class="text-[10px]">Dashboard</span>
        </a>

        <a
            href="{{ route('siswa.journals.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('siswa.journals.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-8.25A3.375 3.375 0 0 0 4.5 11.625v6.75a3.375 3.375 0 0 0 3.375 3.375H16.5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3.75h7.5" />
            </svg>
            <span class="text-[10px]">Jurnal</span>
        </a>

        <a
            href="{{ route('siswa.attendances.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('siswa.attendances.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="17" rx="2" />
                <path d="M8 2v4M16 2v4M3 10h18" />
            </svg>
            <span class="text-[10px]">Absensi</span>
        </a>

        <a
            href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('profile.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <img src="{{ auth()->user()->avatar_url }}" class="h-5 w-5 rounded-full object-cover {{ request()->routeIs('profile.*') ? 'ring-2 ring-blue-500' : '' }}" />
            <span class="text-[10px]">Profil</span>
        </a>
    @endrole

    @role('guru_pembimbing')
        <a
            href="{{ route('guru-pembimbing.dashboard') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('guru-pembimbing.dashboard') ? 'text-emerald-600 dark:text-emerald-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
            </svg>
            <span class="text-[10px]">Dashboard</span>
        </a>

        <a
            href="{{ route('guru-pembimbing.journals.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('guru-pembimbing.journals.*') ? 'text-emerald-600 dark:text-emerald-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-8.25A3.375 3.375 0 0 0 4.5 11.625v6.75a3.375 3.375 0 0 0 3.375 3.375H16.5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3.75h7.5" />
            </svg>
            <span class="text-[10px]">Jurnal</span>
        </a>

        <a
            href="{{ route('guru-pembimbing.students.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('guru-pembimbing.students.*') ? 'text-emerald-600 dark:text-emerald-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            <span class="text-[10px]">Siswa</span>
        </a>

        <a
            href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('profile.*') ? 'text-emerald-600 dark:text-emerald-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <img src="{{ auth()->user()->avatar_url }}" class="h-5 w-5 rounded-full object-cover {{ request()->routeIs('profile.*') ? 'ring-2 ring-emerald-500' : '' }}" />
            <span class="text-[10px]">Profil</span>
        </a>
    @endrole

    @role('mentor')
        <a
            href="{{ route('mentor.dashboard') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('mentor.dashboard') ? 'text-amber-600 dark:text-amber-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
            </svg>
            <span class="text-[10px]">Dashboard</span>
        </a>

        <a
            href="{{ route('mentor.students.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('mentor.students.*') ? 'text-amber-600 dark:text-amber-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            <span class="text-[10px]">Jurnal</span>
        </a>

        <a
            href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('profile.*') ? 'text-amber-600 dark:text-amber-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <img src="{{ auth()->user()->avatar_url }}" class="h-5 w-5 rounded-full object-cover {{ request()->routeIs('profile.*') ? 'ring-2 ring-amber-500' : '' }}" />
            <span class="text-[10px]">Profil</span>
        </a>
    @endrole

    @role('admin_sekolah')
        <a
            href="{{ route('admin-sekolah.dashboard') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('admin-sekolah.dashboard') ? 'text-purple-600 dark:text-purple-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
            </svg>
            <span class="text-[10px]">Dashboard</span>
        </a>

        <a
            href="{{ route('admin-sekolah.students.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('admin-sekolah.students.*') ? 'text-purple-600 dark:text-purple-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            <span class="text-[10px]">Siswa</span>
        </a>

        <a
            href="{{ route('admin-sekolah.users.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('admin-sekolah.users.*') ? 'text-purple-600 dark:text-purple-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.999-3.198A5.994 5.994 0 0 0 6 12.75a5.994 5.994 0 0 0 5.058-2.772" />
            </svg>
            <span class="text-[10px]">User</span>
        </a>

        <a
            href="{{ route('admin-sekolah.school-data.majors.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('admin-sekolah.school-data.*') ? 'text-purple-600 dark:text-purple-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h7"/>
            </svg>
            <span class="text-[10px]">Data</span>
        </a>

        <a
            href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('profile.*') ? 'text-purple-600 dark:text-purple-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <img src="{{ auth()->user()->avatar_url }}" class="h-5 w-5 rounded-full object-cover {{ request()->routeIs('profile.*') ? 'ring-2 ring-purple-500' : '' }}" />
            <span class="text-[10px]">Profil</span>
        </a>
    @endrole

    @role('kepala_sekolah')
        <a
            href="{{ route('kepala-sekolah.dashboard') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('kepala-sekolah.dashboard') ? 'text-rose-600 dark:text-rose-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
            </svg>
            <span class="text-[10px]">Dashboard</span>
        </a>

        <a
            href="{{ route('kepala-sekolah.journals.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('kepala-sekolah.journals.*') ? 'text-rose-600 dark:text-rose-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-8.25A3.375 3.375 0 0 0 4.5 11.625v6.75a3.375 3.375 0 0 0 3.375 3.375H16.5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3.75h7.5" />
            </svg>
            <span class="text-[10px]">Jurnal</span>
        </a>

        <a
            href="{{ route('kepala-sekolah.recap.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('kepala-sekolah.recap.*') ? 'text-rose-600 dark:text-rose-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
            </svg>
            <span class="text-[10px]">Rekap</span>
        </a>

        <a
            href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('profile.*') ? 'text-rose-600 dark:text-rose-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <img src="{{ auth()->user()->avatar_url }}" class="h-5 w-5 rounded-full object-cover {{ request()->routeIs('profile.*') ? 'ring-2 ring-rose-500' : '' }}" />
            <span class="text-[10px]">Profil</span>
        </a>
    @endrole

    @role('admin_platform')
        <a
            href="{{ route('admin-platform.dashboard') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('admin-platform.dashboard') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75V19.5A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25V9.75" />
            </svg>
            <span class="text-[10px]">Dashboard</span>
        </a>

        <a
            href="{{ route('admin-platform.schools.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('admin-platform.schools.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
            <span class="text-[10px]">Sekolah</span>
        </a>

        <a
            href="{{ route('admin-platform.approvals.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('admin-platform.approvals.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span class="text-[10px]">Approval</span>
        </a>

        <a
            href="{{ route('admin-platform.users.index') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('admin-platform.users.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            <span class="text-[10px]">User</span>
        </a>

        <a
            href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition {{ request()->routeIs('profile.*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-400 hover:text-slate-600 dark:text-slate-500' }}"
        >
            <img src="{{ auth()->user()->avatar_url }}" class="h-5 w-5 rounded-full object-cover {{ request()->routeIs('profile.*') ? 'ring-2 ring-blue-500' : '' }}" />
            <span class="text-[10px]">Profil</span>
        </a>
    @endrole
    </div>
</nav>

@stack('scripts')

</body>

</html>