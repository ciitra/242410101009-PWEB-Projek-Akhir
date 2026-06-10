@extends('layouts.app')

@section('title', 'Reservasi Saya - Studio LensArt')

@section('content')
<section class="customer-reservasi-page">

    {{-- HERO --}}
    <section class="customer-reservasi-hero">
        <div>
            <span class="customer-reservasi-kicker">Reservasi Saya</span>

            <h1>Riwayat Reservasi Studio LensArt</h1>

            <p>
                Lihat daftar reservasi yang sudah kamu buat, pantau jadwal pemotretan,
                status pembayaran, dan buat reservasi baru dengan mudah melalui akun customer.
            </p>
        </div>

        <a href="{{ route('customer.reservasi.create') }}" class="customer-reservasi-add">
            Tambah Reservasi
        </a>
    </section>

    {{-- SUMMARY --}}
    <section class="customer-reservasi-summary-grid">
        <article class="customer-reservasi-summary-card summary-total">
            <div class="customer-reservasi-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 2v3M17 2v3M4 8h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                </svg>
            </div>

            <div>
                <span>Total Reservasi Saya</span>
                <strong>{{ $reservasis->total() }} Data</strong>
                <p>Jumlah reservasi yang dibuat menggunakan akun ini.</p>
            </div>
        </article>

        <article class="customer-reservasi-summary-card summary-active">
            <div class="customer-reservasi-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 6h18v12H3z"/>
                    <path d="M7 10h.01M11 10h6M7 14h4"/>
                </svg>
            </div>

            <div>
                <span>Belum Bayar</span>
                <strong>{{ $reservasis->where('status_pembayaran', 'Belum Bayar')->count() }} Data</strong>
                <p>Reservasi yang belum mengupload bukti pembayaran.</p>
            </div>
        </article>

        <article class="customer-reservasi-summary-card summary-finished">
            <div class="customer-reservasi-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>

            <div>
                <span>Pembayaran Lunas</span>
                <strong>{{ $reservasis->where('status_pembayaran', 'Lunas')->count() }} Data</strong>
                <p>Reservasi yang pembayarannya sudah dikonfirmasi owner.</p>
            </div>
        </article>
    </section>

    {{-- FILTER --}}
    <section class="customer-reservasi-filter-card">
        <div class="customer-reservasi-filter-head">
            <div>
                <span class="customer-reservasi-kicker">Filter Data</span>
                <h2>Cari Reservasi Saya</h2>
            </div>
        </div>

        <div class="customer-reservasi-filter-grid">
            <div class="customer-reservasi-filter-group">
                <label for="customerFilterPaket">Filter Paket</label>

                <select id="customerFilterPaket">
                    <option value="">Semua Paket</option>
                    <option value="Paket Indie">Paket Indie</option>
                    <option value="Paket LensArt">Paket LensArt</option>
                    <option value="Paket Kalcer">Paket Kalcer</option>
                    <option value="Paket Custom">Paket Custom</option>
                </select>
            </div>

            <div class="customer-reservasi-filter-group">
                <label for="customerFilterPayment">Filter Pembayaran</label>

                <select id="customerFilterPayment">
                    <option value="">Semua Pembayaran</option>
                    <option value="Belum Bayar">Belum Bayar</option>
                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>

            <div class="customer-reservasi-filter-group">
                <label>&nbsp;</label>

                <button type="button" id="customerResetFilter" class="customer-reservasi-reset">
                    Reset Filter
                </button>
            </div>
        </div>

        <p id="customerFilterInfo" class="customer-reservasi-filter-info">
            Menampilkan semua data reservasi.
        </p>
    </section>

    {{-- TABLE --}}
    <section class="customer-reservasi-panel">
        <div class="customer-reservasi-panel-head">
            <div>
                <span class="customer-reservasi-kicker">Data Booking</span>
                <h2>Daftar Reservasi</h2>
            </div>
        </div>

        <div class="customer-reservasi-table-scroll">
            <table class="customer-reservasi-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Booking</th>
                        <th>Pelanggan</th>
                        <th>Paket</th>
                        <th>Jadwal</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>

                <tbody id="customerReservasiTableBody">
                    @forelse ($reservasis as $index => $reservasi)
                        @php
                            $statusPembayaran = $reservasi->status_pembayaran ?? 'Belum Bayar';

                            $paymentClass = match ($statusPembayaran) {
                                'Menunggu Verifikasi' => 'customer-payment-waiting',
                                'Lunas' => 'customer-payment-paid',
                                'Ditolak' => 'customer-payment-rejected',
                                default => 'customer-payment-unpaid',
                            };
                        @endphp

                        <tr
                            data-paket="{{ $reservasi->paket_foto }}"
                            data-payment="{{ $statusPembayaran }}"
                        >
                            <td>
                                <span class="customer-reservasi-number">
                                    {{ $reservasis->firstItem() + $index }}
                                </span>
                            </td>

                            <td>
                                <strong class="customer-booking-code">
                                    #{{ $reservasi->kode_booking }}
                                </strong>
                            </td>

                            <td>
                                <div class="customer-reservasi-customer">
                                    <strong>{{ $reservasi->nama_pelanggan }}</strong>
                                    <span>{{ $reservasi->email }}</span>
                                </div>
                            </td>

                            <td>
                                <span class="customer-package-badge">
                                    {{ $reservasi->paket_foto }}
                                </span>
                            </td>

                            <td>
                                <div class="customer-schedule-cell">
                                    <strong>
                                        {{ is_object($reservasi->tanggal_reservasi)
                                            ? $reservasi->tanggal_reservasi->format('d M Y')
                                            : date('d M Y', strtotime($reservasi->tanggal_reservasi)) }}
                                    </strong>

                                    <span>{{ substr($reservasi->jam_reservasi, 0, 5) }}</span>
                                </div>
                            </td>

                            <td>
                                <span class="customer-payment-badge {{ $paymentClass }}">
                                    {{ $statusPembayaran }}
                                </span>

                                @if ($reservasi->bukti_pembayaran)
                                    <a
                                        href="{{ asset('storage/' . $reservasi->bukti_pembayaran) }}"
                                        target="_blank"
                                        class="customer-payment-proof-link"
                                    >
                                        Lihat Bukti
                                    </a>
                                @endif

                                @if ($statusPembayaran === 'Belum Bayar')
                                    <a
                                        href="{{ route('customer.reservasi.pembayaran', $reservasi->id) }}"
                                        class="customer-payment-action-link"
                                    >
                                        Bayar Sekarang
                                    </a>
                                @elseif ($statusPembayaran === 'Ditolak')
                                    <a
                                        href="{{ route('customer.reservasi.pembayaran', $reservasi->id) }}"
                                        class="customer-payment-action-link"
                                    >
                                        Upload Ulang
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="customer-empty-reservasi">
                                    <div class="customer-empty-icon">
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M7 2v3M17 2v3M4 8h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                                        </svg>
                                    </div>

                                    <h3>Belum Ada Reservasi</h3>

                                    <p>
                                        Kamu belum membuat reservasi. Pilih paket foto dan buat jadwal
                                        pemotretan pertamamu di Studio LensArt.
                                    </p>

                                    <a href="{{ route('customer.reservasi.create') }}" class="customer-primary-button">
                                        Buat Reservasi Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($reservasis->hasPages())
            <div class="customer-reservasi-pagination">
                {{ $reservasis->links() }}
            </div>
        @endif
    </section>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterPaket = document.getElementById('customerFilterPaket');
        const filterPayment = document.getElementById('customerFilterPayment');
        const resetButton = document.getElementById('customerResetFilter');
        const filterInfo = document.getElementById('customerFilterInfo');
        const tableBody = document.getElementById('customerReservasiTableBody');

        function applyCustomerReservasiFilter() {
            const paketValue = filterPaket ? filterPaket.value : '';
            const paymentValue = filterPayment ? filterPayment.value : '';

            const rows = tableBody.querySelectorAll('tr[data-paket]');
            let visibleCount = 0;

            rows.forEach((row) => {
                const paket = row.dataset.paket || '';
                const payment = row.dataset.payment || '';

                const matchPaket = !paketValue || paket === paketValue;
                const matchPayment = !paymentValue || payment === paymentValue;

                const visible = matchPaket && matchPayment;

                row.style.display = visible ? '' : 'none';

                if (visible) {
                    visibleCount++;
                }
            });

            if (filterInfo) {
                if (!paketValue && !paymentValue) {
                    filterInfo.textContent = 'Menampilkan semua data reservasi.';
                } else {
                    filterInfo.textContent = 'Menampilkan ' + visibleCount + ' data sesuai filter.';
                }
            }
        }

        if (filterPaket) {
            filterPaket.addEventListener('change', applyCustomerReservasiFilter);
        }

        if (filterPayment) {
            filterPayment.addEventListener('change', applyCustomerReservasiFilter);
        }

        if (resetButton) {
            resetButton.addEventListener('click', function () {
                if (filterPaket) {
                    filterPaket.value = '';
                }

                if (filterPayment) {
                    filterPayment.value = '';
                }

                applyCustomerReservasiFilter();
            });
        }

        applyCustomerReservasiFilter();
    });
</script>
@endpush
