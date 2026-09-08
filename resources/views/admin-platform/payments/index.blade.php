<x-layouts.app :title="'Riwayat Pembayaran - Admin Platform'">

    {{-- BREADCRUMB & HEADER --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('admin-platform.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Admin Platform</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Riwayat Pembayaran</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
                Riwayat Pembayaran
            </h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Catatan mutasi dan riwayat pembayaran paket langganan dari instansi sekolah.
            </p>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
        {{-- Total --}}
        <a
            href="{{ route('admin-platform.payments.index') }}"
            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') == null || request('status') === '' ? 'ring-2 ring-blue-500/30 dark:border-blue-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-slate-400 dark:text-slate-500">Total Transaksi</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $paymentCounts['all'] ?? 0 }}</div>
        </a>

        {{-- Lunas --}}
        <a
            href="{{ route('admin-platform.payments.index', ['status' => 'paid']) }}"
            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-emerald-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') === 'paid' ? 'ring-2 ring-emerald-500/30 dark:border-emerald-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Lunas</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $paymentCounts['paid'] ?? 0 }}</div>
        </a>

        {{-- Menunggu --}}
        <a
            href="{{ route('admin-platform.payments.index', ['status' => 'pending']) }}"
            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-amber-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') === 'pending' ? 'ring-2 ring-amber-500/30 dark:border-amber-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-amber-600 dark:text-amber-400">Menunggu</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $paymentCounts['pending'] ?? 0 }}</div>
        </a>

        {{-- Gagal --}}
        <a
            href="{{ route('admin-platform.payments.index', ['status' => 'failed']) }}"
            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-rose-400 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 {{ request('status') === 'failed' ? 'ring-2 ring-rose-500/30 dark:border-rose-500/40' : '' }}"
        >
            <div class="text-xs font-semibold text-rose-600 dark:text-rose-400">Gagal</div>
            <div class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">{{ $paymentCounts['failed'] ?? 0 }}</div>
        </a>
    </div>

    {{-- FILTER & SEARCH --}}
    <form method="GET" action="{{ route('admin-platform.payments.index') }}" class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
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
                placeholder="Cari berdasarkan nama sekolah..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500"
            >
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            @if (request()->hasAny(['search', 'status']))
                <a
                    href="{{ route('admin-platform.payments.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-600 shadow-sm hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    <span>Reset Filter</span>
                </a>
            @endif
            <button
                type="submit"
                class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 active:scale-95 transition"
            >
                Cari
            </button>
        </div>
    </form>

    {{-- TABEL PEMBAYARAN --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($payments->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 2.25 19.5Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 dark:text-slate-200">Tidak Ada Data Pembayaran</h3>
                <p class="mt-1 text-sm text-slate-400">Tidak ada riwayat pembayaran yang sesuai dengan filter pencarian.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-100 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Sekolah &amp; Paket</th>
                            <th class="px-6 py-4">Nominal</th>
                            <th class="px-6 py-4">Metode Bayar</th>
                            <th class="px-6 py-4">Tanggal Transaksi</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Dikonfirmasi Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($payments as $payment)
                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                {{-- Sekolah & Paket --}}
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800 dark:text-white">
                                        {{ $payment->subscription->school_name }}
                                    </div>
                                    <div class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">
                                        {{ $payment->subscription->package->name ?? 'Paket Kustom' }}
                                    </div>
                                </td>

                                {{-- Nominal --}}
                                <td class="whitespace-nowrap px-6 py-4 font-black text-slate-800 dark:text-white">
                                    {{ $payment->amount_formatted }}
                                </td>

                                {{-- Metode --}}
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600 dark:text-slate-300 font-medium">
                                    {{ $payment->payment_method_label }}
                                </td>

                                {{-- Tanggal --}}
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $payment->payment_date ? $payment->payment_date->translatedFormat('d M Y') : '—' }}
                                </td>

                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($payment->status === 'paid')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Lunas
                                        </span>
                                    @elseif ($payment->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Konfirmasi --}}
                                <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-500 dark:text-slate-400">
                                    @if ($payment->confirmedBy)
                                        <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $payment->confirmedBy->name }}</span>
                                        @if ($payment->confirmed_at)
                                            <span class="block text-[11px] text-slate-400">{{ $payment->confirmed_at->translatedFormat('d M Y H:i') }}</span>
                                        @endif
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($payments->hasPages())
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    {{ $payments->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.app>
