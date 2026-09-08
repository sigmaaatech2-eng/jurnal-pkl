<x-layouts.app title="Rekapitulasi PKL Siswa">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                        Rekapitulasi PKL Siswa
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Laporan ringkas akumulasi kegiatan, verifikasi jurnal, dan kehadiran seluruh siswa bimbingan.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            {{-- Tombol Export Excel --}}
                <a
                    href="{{ route('guru-pembimbing.recap.export', ['format' => 'xlsx']) }}"
                    class="inline-flex items-center gap-2 whitespace-nowrap rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-500/20"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        <span>Export Excel</span>
    </a>

    {{-- Tombol Export CSV --}}
    <a
        href="{{ route('guru-pembimbing.recap.export', ['format' => 'csv']) }}"
        class="inline-flex items-center gap-2 whitespace-nowrap rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
    >
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 shrink-0"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            <span>Export CSV</span>
            </a>

            {{-- Tombol Kembali --}}
            <a
                href="{{ route('guru-pembimbing.dashboard') }}"
                class="inline-flex items-center gap-2 whitespace-nowrap rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <span>← Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($internships->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-700 dark:text-slate-200">Belum Ada Siswa Bimbingan</h3>
                <p class="mt-1 text-sm text-slate-400">Data bimbingan PKL siswa belum tersedia.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Nama Siswa</th>
                            <th class="px-6 py-4">Tempat PKL</th>
                            <th class="px-6 py-4">Total Jurnal</th>
                            <th class="px-6 py-4">Status Verifikasi</th>
                            <th class="px-6 py-4">Kehadiran</th>
                            <th class="px-6 py-4">Status PKL</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($internships as $internship)
                            @php
                                $total = $internship->journals->count();
                                $approved = $internship->journals->where('status', 'approved')->count();
                                $pending = $internship->journals->where('status', 'pending')->count();
                                $attendCount = $internship->attendances->count();
                            @endphp
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-white">
                                        {{ $internship->student->name ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $internship->student->email ?? '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium text-slate-700 dark:text-slate-200">
                                        {{ $internship->company_name ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $internship->company_address ? Str::limit($internship->company_address, 30) : '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-800 dark:text-slate-100">
                                    {{ $total }} Jurnal
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-2 text-xs">
                                        <span class="rounded-md bg-emerald-50 px-2 py-0.5 font-semibold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            {{ $approved }} Disetujui
                                        </span>
                                        @if ($pending > 0)
                                            <span class="rounded-md bg-amber-50 px-2 py-0.5 font-semibold text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                                                {{ $pending }} Pending
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="font-medium text-slate-700 dark:text-slate-200">
                                        {{ $attendCount }} Hari
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                        {{ ucfirst($internship->status ?? 'Aktif') }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('guru-pembimbing.students.show', $internship) }}"
                                        class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 transition hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:hover:bg-blue-500/20"
                                    >
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</x-layouts.app>
