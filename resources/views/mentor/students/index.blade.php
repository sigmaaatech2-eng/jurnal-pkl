<x-layouts.app title="Daftar Siswa">

    <div
        x-data="{
            showDeadlineModal: false,
            selectedInternshipId: '',
            selectedStudentName: 'Semua Siswa Bimbingan',
            currentDeadline: '08:00',

            openDeadlineModal(internshipId = '', studentName = 'Semua Siswa Bimbingan', time = '08:00') {
                this.selectedInternshipId = internshipId;
                this.selectedStudentName = studentName;
                this.currentDeadline = time;
                this.showDeadlineModal = true;
            }
        }"
    >

        {{-- HEADER --}}
        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Daftar Siswa</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Kelola dan pantau perkembangan jurnal seluruh siswa bimbingan Anda.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="button"
                    @click="openDeadlineModal('', 'Semua Siswa Bimbingan', '08:00')"
                    class="inline-flex items-center gap-2 rounded-xl border border-amber-300 bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-800 shadow-sm transition hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Atur Batas Waktu Absen</span>
                </button>
            </div>
        </div>

        {{-- SUCCESS ALERT --}}
        @if (session('success'))
            <div class="mb-6 flex items-center justify-between gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- FILTER & SEARCH --}}
        <form method="GET" action="{{ route('mentor.students.index') }}" class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama siswa..."
                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
                >
            </div>

            <div class="flex gap-2">
                @foreach(['all' => 'Semua', 'active' => 'Aktif'] as $value => $label)
                    <a
                        href="{{ route('mentor.students.index', array_merge(request()->query(), ['status' => $value])) }}"
                        class="rounded-xl px-4 py-2.5 text-sm font-semibold transition
                        {{ (request('status', 'all') === $value)
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20'
                            : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800'
                        }}"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </form>

        {{-- TABLE --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @if ($internships->isEmpty())
                <div class="py-16 text-center">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200">Tidak Ada Data Siswa</h3>
                    <p class="mt-1 text-sm text-slate-400">Coba ubah filter atau kata kunci pencarian.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                            <tr>
                                <th class="px-6 py-4">Nama Siswa</th>
                                <th class="px-6 py-4">Tempat PKL</th>
                                <th class="px-6 py-4">Batas Absen</th>
                                <th class="px-6 py-4">Total Jurnal</th>
                                <th class="px-6 py-4">Menunggu Validasi</th>
                                <th class="px-6 py-4">Progress</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($internships as $internship)
                                @php
                                    $total    = $internship->journals->count();
                                    $approved = $internship->journals->where('status', 'approved')->count();
                                    $pending  = $internship->journals->where('status', 'pending')->count();
                                    $progress = $total > 0 ? min(100, round(($approved / $total) * 100)) : 0;
                                    $deadline = substr($internship->max_check_in_time ?? '08:00:00', 0, 5);
                                @endphp
                                <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                                                {{ strtoupper(substr($internship->student->name ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 dark:text-white">{{ $internship->student->name ?? '-' }}</div>
                                                <div class="text-xs text-slate-400">{{ $internship->student->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-700 dark:text-slate-200">{{ $internship->company_name }}</div>
                                        <div class="text-xs text-slate-400">{{ Str::limit($internship->company_address, 35) }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <button
                                            type="button"
                                            @click="openDeadlineModal('{{ $internship->id }}', '{{ addslashes($internship->student->name ?? 'Siswa') }}', '{{ $deadline }}')"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-700 transition hover:border-amber-400 hover:bg-amber-50 hover:text-amber-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-amber-500/40 dark:hover:bg-amber-500/10"
                                            title="Klik untuk ubah batas waktu absen siswa ini"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <span>{{ $deadline }} WIB</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-3.143.944.943-3.143a4.5 4.5 0 0 1 1.13-1.897l9.247-9.247z" />
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-800 dark:text-slate-100">
                                        {{ $total }} Jurnal
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($pending > 0)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                {{ $pending }} Menunggu
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="h-2 w-28 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                                <div class="h-full rounded-full bg-blue-500" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $approved }}/{{ $total }}</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($internship->status === 'active')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                                {{ ucfirst($internship->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <a
                                            href="{{ route('mentor.students.show', $internship) }}"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                                        >
                                            Lihat Jurnal →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- MODAL ATUR BATAS WAKTU ABSEN --}}
        <div
            x-show="showDeadlineModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/75 p-4 backdrop-blur-sm"
            @keydown.escape.window="showDeadlineModal = false"
        >
            <div
                class="w-full max-w-md overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900"
                @click.away="showDeadlineModal = false"
            >
                <form method="POST" action="{{ route('mentor.attendance-deadline.update') }}">
                    @csrf
                    <input type="hidden" name="internship_id" :value="selectedInternshipId">

                    <div class="border-b border-slate-100 px-6 py-5 dark:border-slate-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 dark:text-white">Atur Batas Waktu Absen</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400" x-text="'Target: ' + selectedStudentName"></p>
                                </div>
                            </div>
                            <button
                                type="button"
                                @click="showDeadlineModal = false"
                                class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800 dark:hover:text-slate-300"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4 p-6">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Jam Maksimal Check In (WIB)
                            </label>
                            <input
                                type="time"
                                name="max_check_in_time"
                                x-model="currentDeadline"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-lg font-bold text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:[color-scheme:dark]"
                            >
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                Siswa yang check-in sebelum atau pada jam ini akan diberi status <span class="font-semibold text-emerald-600 dark:text-emerald-400">Tepat Waktu</span>. Lewat dari jam ini otomatis diberi keterangan <span class="font-semibold text-red-600 dark:text-red-400">Terlambat</span>.
                            </p>
                        </div>

                        <div x-show="!selectedInternshipId" class="rounded-xl bg-blue-50 p-3 text-xs text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                            💡 Batas waktu ini akan diterapkan ke seluruh siswa bimbingan PKL Anda.
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900/50">
                        <button
                            type="button"
                            @click="showDeadlineModal = false"
                            class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700"
                        >
                            <span>Simpan Batas Waktu</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-layouts.app>
