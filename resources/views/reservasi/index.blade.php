@extends('layouts.app')

@section('title', 'Daftar Reservasi - Studio LensArt')

@section('content')
<section class="reservasi-page-v2">

    {{-- PAGE HEADER --}}
    <div class="reservasi-hero-v2">
        <div class="reservasi-hero-content">
            <span class="reservasi-kicker">Manajemen Reservasi</span>

            <h1>Daftar Reservasi Studio LensArt</h1>

            <p>
                Kelola seluruh data pesanan pelanggan, pantau jadwal reservasi,
                cek status pembayaran, dan cari data booking dengan cepat.
            </p>
        </div>

        <a href="{{ route('reservasi.create') }}" class="reservasi-add-button">
            <span>+</span>
            Tambah Reservasi
        </a>
    </div>

    {{-- STATISTIK --}}
    <div class="reservasi-summary-grid-v2">
        <article class="reservasi-summary-box summary-primary">
            <div class="reservasi-summary-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 2v3M17 2v3M4 8h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                </svg>
            </div>

            <div>
                <span>Total Reservasi</span>
                <strong>{{ $totalReservasi ?? $reservasis->total() }} Data</strong>
                <p>Seluruh data reservasi yang tersimpan di sistem.</p>
            </div>
        </article>

        <article class="reservasi-summary-box summary-soft">
            <div class="reservasi-summary-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 6h18v12H3z"/>
                    <path d="M7 10h.01M11 10h6M7 14h4"/>
                </svg>
            </div>

            <div>
                <span>Belum Bayar</span>
                <strong>{{ $belumBayar ?? 0 }} Data</strong>
                <p>Reservasi yang belum mengirim bukti pembayaran.</p>
            </div>
        </article>

        <article class="reservasi-summary-box summary-brown">
            <div class="reservasi-summary-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 6v6l4 2"/>
                    <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"/>
                </svg>
            </div>

            <div>
                <span>Menunggu Verifikasi</span>
                <strong>{{ $menungguVerifikasi ?? 0 }} Data</strong>
                <p>Reservasi yang bukti pembayarannya perlu dicek owner.</p>
            </div>
        </article>

        <article class="reservasi-summary-box summary-green">
            <div class="reservasi-summary-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>

            <div>
                <span>Pembayaran Lunas</span>
                <strong>{{ $pembayaranLunas ?? 0 }} Data</strong>
                <p>Reservasi yang pembayarannya sudah dikonfirmasi lunas.</p>
            </div>
        </article>
    </div>

    {{-- SEARCH & FILTER --}}
    <div class="reservasi-search-card-v2">
        <div class="reservasi-search-header">
            <div>
                <span class="section-kicker">Pencarian & Filter</span>
                <h2>Cari Data Reservasi</h2>
            </div>
        </div>

        <form id="liveSearchForm" class="reservasi-search-form-v2">
            @csrf

            <div class="reservasi-search-input-wrap">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="m21 21-4.3-4.3"/>
                    <path d="M10.8 18a7.2 7.2 0 1 0 0-14.4 7.2 7.2 0 0 0 0 14.4Z"/>
                </svg>

                <input
                    type="text"
                    id="liveSearchInput"
                    name="keyword"
                    placeholder="Ketik nama, email, kode booking, paket, atau status pembayaran..."
                    autocomplete="off"
                >
            </div>

            <button type="submit" class="reservasi-search-button">
                Cari
            </button>
        </form>

        <div class="reservasi-filter-grid owner-reservasi-filter-grid clean-payment-filter-grid">
            <div class="reservasi-filter-group">
                <label for="filterPaket">Filter Paket</label>

                <select id="filterPaket">
                    <option value="">Semua Paket</option>

                    @foreach (($filterPakets ?? ['Paket Indie', 'Paket LensArt', 'Paket Kalcer', 'Paket Custom']) as $paket)
                        <option value="{{ $paket }}">{{ $paket }}</option>
                    @endforeach
                </select>
            </div>

            <div class="reservasi-filter-group">
                <label for="filterPayment">Filter Pembayaran</label>

                <select id="filterPayment">
                    <option value="">Semua Pembayaran</option>
                    <option value="Belum Bayar">Belum Bayar</option>
                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>

            <div class="reservasi-filter-group filter-button-group">
                <label>&nbsp;</label>

                <button type="button" id="resetFilterButton" class="reservasi-reset-button">
                    Reset Filter
                </button>
            </div>
        </div>

        <p id="liveSearchInfo" class="reservasi-search-info">
            Menampilkan data reservasi terbaru.
        </p>
    </div>

    {{-- TABLE --}}
    <div class="reservasi-panel-v2">
        <div class="reservasi-panel-header-v2">
            <div>
                <span class="section-kicker">Data Booking</span>
                <h2>Data Reservasi Pelanggan</h2>
            </div>
        </div>

        <div class="reservasi-table-scroll-v2">
            <table class="reservasi-table-v2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Booking</th>
                        <th>Pelanggan</th>
                        <th>Paket</th>
                        <th>Jadwal</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="reservasiTableBody">
                    @forelse ($reservasis as $reservasi)
                        @php
                            $statusPembayaran = $reservasi->status_pembayaran ?? 'Belum Bayar';

                            $paymentClass = match ($statusPembayaran) {
                                'Menunggu Verifikasi' => 'payment-waiting-v2',
                                'Lunas' => 'payment-paid-v2',
                                'Ditolak' => 'payment-rejected-v2',
                                default => 'payment-unpaid-v2',
                            };
                        @endphp

                        <tr
                            data-paket="{{ $reservasi->paket_foto }}"
                            data-payment="{{ $statusPembayaran }}"
                        >
                            <td>
                                <span class="reservasi-number">
                                    {{ $reservasis->firstItem() + $loop->index }}
                                </span>
                            </td>

                            <td>
                                <strong class="booking-code">
                                    #{{ $reservasi->kode_booking }}
                                </strong>
                            </td>

                            <td>
                                <div class="customer-cell-v2">
                                    <strong>{{ $reservasi->nama_pelanggan }}</strong>
                                    <span>{{ $reservasi->email }}</span>
                                </div>
                            </td>

                            <td>
                                <span class="package-badge-v2">
                                    {{ $reservasi->paket_foto }}
                                </span>
                            </td>

                            <td>
                                <div class="schedule-cell-v2">
                                    <strong>
                                        {{ is_object($reservasi->tanggal_reservasi)
                                            ? $reservasi->tanggal_reservasi->format('d M Y')
                                            : date('d M Y', strtotime($reservasi->tanggal_reservasi)) }}
                                    </strong>

                                    <span>{{ substr($reservasi->jam_reservasi, 0, 5) }}</span>
                                </div>
                            </td>

                            <td>
                                <span class="payment-badge-v2 {{ $paymentClass }}">
                                    {{ $statusPembayaran }}
                                </span>

                                @if ($reservasi->bukti_pembayaran)
                                    <a
                                        href="{{ asset('storage/' . $reservasi->bukti_pembayaran) }}"
                                        target="_blank"
                                        class="payment-proof-link-v2"
                                    >
                                        Lihat Bukti
                                    </a>
                                @endif
                            </td>

                            <td>
                                <div class="reservasi-action-buttons-v2">
                                    <a href="{{ route('reservasi.show', $reservasi->id) }}" class="action-button-v2 action-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('reservasi.edit', $reservasi->id) }}" class="action-button-v2 action-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('reservasi.destroy', $reservasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data reservasi ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="action-button-v2 action-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                Belum ada data reservasi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="reservasi-pagination-area">
            <div class="pagination-info" id="paginationInfo">
                <p>
                    Menampilkan {{ $reservasis->firstItem() ?? 0 }} sampai {{ $reservasis->lastItem() ?? 0 }}
                    dari {{ $reservasis->total() }} data reservasi.
                </p>
            </div>

            <div class="pagination-wrapper" id="paginationWrapper">
                {{ $reservasis->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const liveSearchForm = document.getElementById('liveSearchForm');
        const liveSearchInput = document.getElementById('liveSearchInput');
        const reservasiTableBody = document.getElementById('reservasiTableBody');
        const liveSearchInfo = document.getElementById('liveSearchInfo');
        const paginationInfo = document.getElementById('paginationInfo');
        const paginationWrapper = document.getElementById('paginationWrapper');

        const filterPaket = document.getElementById('filterPaket');
        const filterPayment = document.getElementById('filterPayment');
        const resetFilterButton = document.getElementById('resetFilterButton');

        const csrfToken = '{{ csrf_token() }}';
        const liveSearchUrl = '{{ route('reservasi.live-search') }}';

        let searchTimer = null;

        function escapeHtml(value) {
            if (value === null || value === undefined) {
                return '';
            }

            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function getPaymentClass(statusPembayaran) {
            if (statusPembayaran === 'Menunggu Verifikasi') {
                return 'payment-waiting-v2';
            }

            if (statusPembayaran === 'Lunas') {
                return 'payment-paid-v2';
            }

            if (statusPembayaran === 'Ditolak') {
                return 'payment-rejected-v2';
            }

            return 'payment-unpaid-v2';
        }

        function getSelectedFilters() {
            return {
                paket: filterPaket ? filterPaket.value : '',
                payment: filterPayment ? filterPayment.value : '',
            };
        }

        function updateFilterInfo(visibleCount) {
            const filters = getSelectedFilters();
            const keyword = liveSearchInput ? liveSearchInput.value.trim() : '';

            let activeInfo = [];

            if (keyword) {
                activeInfo.push('keyword "' + keyword + '"');
            }

            if (filters.paket) {
                activeInfo.push('paket ' + filters.paket);
            }

            if (filters.payment) {
                activeInfo.push('status pembayaran ' + filters.payment);
            }

            if (!liveSearchInfo) return;

            if (activeInfo.length === 0) {
                liveSearchInfo.textContent = 'Menampilkan data reservasi terbaru.';
            } else {
                liveSearchInfo.textContent = 'Menampilkan ' + visibleCount + ' data berdasarkan ' + activeInfo.join(', ') + '.';
            }
        }

        function applyClientFilters() {
            const filters = getSelectedFilters();
            const rows = reservasiTableBody.querySelectorAll('tr[data-paket]');
            let visibleCount = 0;

            rows.forEach((row) => {
                const paket = row.dataset.paket || '';
                const payment = row.dataset.payment || '';

                const matchPaket = !filters.paket || paket === filters.paket;
                const matchPayment = !filters.payment || payment === filters.payment;

                const isVisible = matchPaket && matchPayment;

                row.style.display = isVisible ? '' : 'none';

                if (isVisible) {
                    visibleCount++;
                }
            });

            updateFilterInfo(visibleCount);
        }

        function setLoadingRow() {
            reservasiTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty-state">
                        Mencari data reservasi...
                    </td>
                </tr>
            `;
        }

        function setEmptyRow() {
            reservasiTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty-state">
                        Data reservasi tidak ditemukan.
                    </td>
                </tr>
            `;
        }

        function renderRows(reservasis) {
            if (!reservasis.length) {
                setEmptyRow();
                updateFilterInfo(0);
                return;
            }

            let rows = '';

            reservasis.forEach((reservasi, index) => {
                const statusPembayaran = reservasi.status_pembayaran || 'Belum Bayar';
                const paymentClass = getPaymentClass(statusPembayaran);

                const proofLink = reservasi.bukti_pembayaran
                    ? `<a href="/storage/${escapeHtml(reservasi.bukti_pembayaran)}" target="_blank" class="payment-proof-link-v2">Lihat Bukti</a>`
                    : '';

                rows += `
                    <tr
                        data-paket="${escapeHtml(reservasi.paket_foto)}"
                        data-payment="${escapeHtml(statusPembayaran)}"
                    >
                        <td>
                            <span class="reservasi-number">
                                ${index + 1}
                            </span>
                        </td>

                        <td>
                            <strong class="booking-code">
                                #${escapeHtml(reservasi.kode_booking)}
                            </strong>
                        </td>

                        <td>
                            <div class="customer-cell-v2">
                                <strong>${escapeHtml(reservasi.nama_pelanggan)}</strong>
                                <span>${escapeHtml(reservasi.email)}</span>
                            </div>
                        </td>

                        <td>
                            <span class="package-badge-v2">
                                ${escapeHtml(reservasi.paket_foto)}
                            </span>
                        </td>

                        <td>
                            <div class="schedule-cell-v2">
                                <strong>${escapeHtml(reservasi.tanggal_reservasi)}</strong>
                                <span>${escapeHtml(reservasi.jam_reservasi)}</span>
                            </div>
                        </td>

                        <td>
                            <span class="payment-badge-v2 ${paymentClass}">
                                ${escapeHtml(statusPembayaran)}
                            </span>
                            ${proofLink}
                        </td>

                        <td>
                            <div class="reservasi-action-buttons-v2">
                                <a href="${reservasi.show_url}" class="action-button-v2 action-detail">
                                    Detail
                                </a>

                                <a href="${reservasi.edit_url}" class="action-button-v2 action-edit">
                                    Edit
                                </a>

                                <form action="${reservasi.delete_url}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data reservasi ini?')">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">

                                    <button type="submit" class="action-button-v2 action-delete">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                `;
            });

            reservasiTableBody.innerHTML = rows;
            applyClientFilters();
        }

        async function searchReservasi(keyword) {
            setLoadingRow();

            if (paginationInfo) {
                paginationInfo.style.display = keyword ? 'none' : '';
            }

            if (paginationWrapper) {
                paginationWrapper.style.display = keyword ? 'none' : '';
            }

            try {
                const response = await fetch(liveSearchUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        keyword: keyword
                    })
                });

                if (!response.ok) {
                    throw new Error('Gagal melakukan pencarian.');
                }

                const result = await response.json();

                renderRows(result.data);
            } catch (error) {
                reservasiTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="empty-state">
                            Terjadi kesalahan saat mencari data reservasi.
                        </td>
                    </tr>
                `;

                if (liveSearchInfo) {
                    liveSearchInfo.textContent = 'Pencarian gagal. Silakan coba lagi.';
                }
            }
        }

        if (liveSearchForm) {
            liveSearchForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const keyword = liveSearchInput.value.trim();
                searchReservasi(keyword);
            });
        }

        if (liveSearchInput) {
            liveSearchInput.addEventListener('input', function () {
                clearTimeout(searchTimer);

                searchTimer = setTimeout(function () {
                    const keyword = liveSearchInput.value.trim();
                    searchReservasi(keyword);
                }, 400);
            });
        }

        if (filterPaket) {
            filterPaket.addEventListener('change', applyClientFilters);
        }

        if (filterPayment) {
            filterPayment.addEventListener('change', applyClientFilters);
        }

        if (resetFilterButton) {
            resetFilterButton.addEventListener('click', function () {
                if (filterPaket) {
                    filterPaket.value = '';
                }

                if (filterPayment) {
                    filterPayment.value = '';
                }

                if (liveSearchInput) {
                    liveSearchInput.value = '';
                }

                searchReservasi('');
            });
        }

        applyClientFilters();
    });
</script>
@endpush
