<x-layouts.app title="Detail Sekolah: {{ $school->school_name }}">

    {{-- BREADCRUMB --}}
    <div class="mb-6 flex items-center gap-2 text-xs font-medium text-slate-400">
        <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
        <span>/</span>
        <a href="{{ route('admin-platform.schools.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Subscriber Sekolah</a>
        <span>/</span>
        <span class="text-slate-600 dark:text-slate-300">{{ $school->school_name }}</span>
    </div>

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-100 font-extrabold text-2xl text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                {{ strtoupper(substr($school->school_name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                    {{ $school->school_name }}
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Informasi profil sekolah, paket langganan aktif, dan riwayat transaksi.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin-platform.schools.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                <span>← Kembali</span>
            </a>
            @if ($school->status === 'active')
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3.5 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Langganan Aktif
                </span>
            @elseif ($school->status === 'pending')
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3.5 py-1.5 text-xs font-bold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                    Menunggu Verifikasi
                </span>
            @elseif ($school->status === 'rejected')
                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3.5 py-1.5 text-xs font-bold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                    <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                    Pengajuan Ditolak
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3.5 py-1.5 text-xs font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                    {{ ucfirst($school->status) }}
                </span>
            @endif
        </div>
    </div>

    {{-- REJECTION REASON ALERT (IF REJECTED) --}}
    @if ($school->status === 'rejected' && $school->rejection_reason)
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-rose-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            <div>
                <strong class="font-semibold">Alasan Penolakan Pengajuan:</strong>
                <p class="mt-1 text-xs leading-relaxed text-rose-700 dark:text-rose-300">{{ $school->rejection_reason }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- LEFT COLUMN: DETAIL SEKOLAH & PEMBAYARAN --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- PROFIL SEKOLAH --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="mb-5 flex items-center gap-2 text-base font-bold text-slate-800 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A48.24 48.24 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.583V21" />
                    </svg>
                    Informasi Instansi Sekolah
                </h2>

                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Sekolah</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white text-sm">{{ $school->school_name }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Email Resmi</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white text-sm">{{ $school->school_email ?? '—' }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kontak Telepon</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white text-sm">{{ $school->school_phone ?? '—' }}</dd>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Admin Sekolah Terkait</dt>
                        <dd class="mt-1 font-bold text-slate-800 dark:text-white text-sm">{{ $school->adminUser->name ?? '—' }}</dd>
                    </div>

                    <div class="sm:col-span-2 rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Alamat Lengkap</dt>
                        <dd class="mt-1 text-sm text-slate-700 dark:text-slate-300">{{ $school->school_address ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- RIWAYAT TRANSAKSI PEMBAYARAN --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-100 p-5 dark:border-slate-800 flex items-center justify-between">
                    <h2 class="flex items-center gap-2 text-base font-bold text-slate-800 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 2.25 19.5Z" />
                        </svg>
                        Riwayat Pembayaran Sekolah
                    </h2>
                </div>

                @if ($school->payments->isEmpty())
                    <div class="p-8 text-center">
                        <p class="text-sm text-slate-400">Belum ada catatan pembayaran untuk sekolah ini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                            <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                                <tr>
                                    <th class="px-5 py-3">Tanggal</th>
                                    <th class="px-5 py-3">Nominal</th>
                                    <th class="px-5 py-3">Metode</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($school->payments as $payment)
                                    <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                        <td class="px-5 py-3.5 whitespace-nowrap text-slate-700 dark:text-slate-300 font-medium">
                                            {{ $payment->payment_date ? $payment->payment_date->translatedFormat('d M Y') : '—' }}
                                        </td>
                                        <td class="px-5 py-3.5 whitespace-nowrap font-bold text-slate-800 dark:text-white">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-3.5 whitespace-nowrap text-slate-600 dark:text-slate-400">
                                            {{ $payment->payment_method_label }}
                                        </td>
                                        <td class="px-5 py-3.5 whitespace-nowrap">
                                            @if ($payment->status === 'paid')
                                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-xs text-slate-400">
                                            {{ $payment->notes ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>

        {{-- RIGHT COLUMN: PAKET & STATUS LANGGANAN --}}
        <div class="space-y-6">

            {{-- KARTU PAKET --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-4 flex items-center gap-2 text-base font-bold text-slate-800 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Paket Langganan
                </h3>

                @if ($school->package)
                    <div class="rounded-xl border border-indigo-100 bg-indigo-50/50 p-4 dark:border-indigo-900/30 dark:bg-indigo-950/30 mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Paket Terpilih</span>
                        <h4 class="text-lg font-extrabold text-slate-800 dark:text-white mt-1">{{ $school->package->name }}</h4>
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                            Rp {{ number_format($school->package->price, 0, ',', '.') }}
                            <span class="text-xs font-normal text-slate-400">/ {{ $school->package->duration_months }} Bulan</span>
                        </p>
                    </div>

                    <div class="space-y-3 text-xs text-slate-600 dark:text-slate-300">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
                            <span class="text-slate-400">Maks. Siswa PKL</span>
                            <strong class="font-bold text-slate-700 dark:text-slate-200">{{ $school->package->max_students }} Siswa</strong>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
                            <span class="text-slate-400">Maks. Guru Pembimbing</span>
                            <strong class="font-bold text-slate-700 dark:text-slate-200">{{ $school->package->max_teachers }} Guru</strong>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
                            <span class="text-slate-400">Maks. Mentor Industri</span>
                            <strong class="font-bold text-slate-700 dark:text-slate-200">{{ $school->package->max_mentors }} Mentor</strong>
                        </div>
                    </div>

                    @if (!empty($school->package->features))
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800">
                            <p class="text-xs font-semibold text-slate-400 mb-2">Fitur Unggulan Paket:</p>
                            <ul class="space-y-1.5 text-xs text-slate-600 dark:text-slate-300">
                                @foreach ($school->package->features as $feat)
                                    <li class="flex items-center gap-2">
                                        <svg class="h-3.5 w-3.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @else
                    <p class="text-sm text-slate-400">Belum ada paket langganan yang dipilih.</p>
                @endif
            </div>

            {{-- PERIODE AKTIF --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-4 text-base font-bold text-slate-800 dark:text-white">Masa Berlaku</h3>

                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block">Tanggal Mulai:</span>
                        <strong class="font-semibold text-slate-800 dark:text-slate-200">
                            {{ $school->start_date ? $school->start_date->translatedFormat('d F Y') : '—' }}
                        </strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Tanggal Berakhir:</span>
                        <strong class="font-semibold text-slate-800 dark:text-slate-200">
                            {{ $school->end_date ? $school->end_date->translatedFormat('d F Y') : '—' }}
                        </strong>
                    </div>
                    @if ($school->approvedBy)
                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-400">
                            Disetujui oleh: <strong class="text-slate-600 dark:text-slate-300">{{ $school->approvedBy->name }}</strong>
                            pada {{ $school->approved_at ? $school->approved_at->translatedFormat('d M Y H:i') : '—' }}
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</x-layouts.app>
