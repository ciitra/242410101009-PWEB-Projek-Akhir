@extends('layouts.app')

@section('title', 'Tambah Reservasi - Studio LensArt')

@section('content')
<section class="customer-create-reservasi-page">

    {{-- HERO --}}
    <section class="customer-create-hero">
        <div>
            <span class="customer-create-kicker">Buat Reservasi</span>

            <h1>Atur Jadwal Pemotretanmu</h1>

            <p>
                Lengkapi data reservasi, pilih paket foto favorit, lalu tentukan jadwal
                pemotretan yang sesuai dengan kebutuhanmu.
            </p>
        </div>

        <a href="{{ route('customer.reservasi.index') }}" class="customer-create-back">
            Kembali
        </a>
    </section>

    @if ($errors->any())
        <div class="customer-create-alert">
            <strong>Reservasi belum berhasil dibuat.</strong>
            <p>Silakan periksa kembali data yang kamu masukkan.</p>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.reservasi.store') }}" method="POST" class="customer-create-form">
        @csrf

        {{-- DATA PELANGGAN --}}
        <section class="customer-create-card">
            <div class="customer-create-card-head">
                <div class="customer-create-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                        <path d="M4 21a8 8 0 0 1 16 0"/>
                    </svg>
                </div>

                <div>
                    <span class="customer-create-kicker">Langkah 1</span>
                    <h2>Data Pelanggan</h2>
                    <p>Masukkan identitas pelanggan yang melakukan reservasi.</p>
                </div>
            </div>

            <div class="customer-create-grid">
                <div class="customer-create-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input
                        type="text"
                        name="nama_pelanggan"
                        id="nama_pelanggan"
                        placeholder="Nama lengkap pelanggan"
                        value="{{ old('nama_pelanggan', auth()->user()->name) }}"
                        class="{{ $errors->has('nama_pelanggan') ? 'input-error' : '' }}"
                    >
                    @error('nama_pelanggan')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="customer-create-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="email@gmail.com"
                        value="{{ old('email', auth()->user()->email) }}"
                        class="{{ $errors->has('email') ? 'input-error' : '' }}"
                    >
                    @error('email')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="customer-create-group">
                    <label for="username_instagram">Username Instagram</label>
                    <input
                        type="text"
                        name="username_instagram"
                        id="username_instagram"
                        placeholder="@username"
                        value="{{ old('username_instagram') }}"
                        class="{{ $errors->has('username_instagram') ? 'input-error' : '' }}"
                    >
                    @error('username_instagram')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="customer-create-group">
                    <label for="no_hp">Nomor HP</label>
                    <input
                        type="text"
                        name="no_hp"
                        id="no_hp"
                        placeholder="081234567890"
                        value="{{ old('no_hp') }}"
                        class="{{ $errors->has('no_hp') ? 'input-error' : '' }}"
                    >
                    @error('no_hp')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>

        {{-- INFORMASI PAKET --}}
        <section class="customer-create-card">
            <div class="customer-create-card-head">
                <div class="customer-create-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 7h16v13H4z"/>
                        <path d="M8 7a4 4 0 0 1 8 0"/>
                    </svg>
                </div>

                <div>
                    <span class="customer-create-kicker">Langkah 2</span>
                    <h2>Informasi Paket</h2>
                    <p>Pilih paket foto. Harga akan otomatis mengikuti paket yang dipilih.</p>
                </div>
            </div>

            <div class="customer-create-grid">
                <div class="customer-create-group">
                    <label for="paket_foto">Pilih Paket Foto</label>
                    <select name="paket_foto" id="paket_foto" class="{{ $errors->has('paket_foto') ? 'input-error' : '' }}">
                        <option value="">-- Pilih Paket --</option>
                        @foreach ($filterPakets as $paket)
                            <option value="{{ $paket }}" {{ old('paket_foto') == $paket ? 'selected' : '' }}>
                                {{ $paket }}
                            </option>
                        @endforeach
                    </select>
                    @error('paket_foto')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="customer-create-group">
                    <label for="harga">Harga Paket</label>
                    <input
                        type="text"
                        id="harga"
                        placeholder="Harga otomatis"
                        value=""
                        readonly
                    >
                    <small class="customer-create-help">Harga otomatis mengikuti paket foto yang dipilih.</small>
                </div>

                <div class="customer-create-group">
                    <label for="jumlah_orang">Jumlah Orang</label>
                    <input
                        type="number"
                        name="jumlah_orang"
                        id="jumlah_orang"
                        placeholder="Contoh: 2"
                        value="{{ old('jumlah_orang') }}"
                        class="{{ $errors->has('jumlah_orang') ? 'input-error' : '' }}"
                    >
                    @error('jumlah_orang')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="customer-package-preview" id="packagePreview">
                <span>Preview Paket</span>
                <strong>Pilih paket terlebih dahulu</strong>
                <p>Detail singkat paket akan muncul setelah kamu memilih paket foto.</p>
            </div>
        </section>

        {{-- JADWAL --}}
        <section class="customer-create-card">
            <div class="customer-create-card-head">
                <div class="customer-create-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M7 2v3M17 2v3M4 8h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                    </svg>
                </div>

                <div>
                    <span class="customer-create-kicker">Langkah 3</span>
                    <h2>Jadwal Pemotretan</h2>
                    <p>Pilih tanggal dan jam reservasi sesuai waktu yang kamu inginkan.</p>
                </div>
            </div>

            <div class="customer-create-grid">
                <div class="customer-create-group">
                    <label for="tanggal_reservasi">Tanggal Reservasi</label>
                    <input
                        type="date"
                        name="tanggal_reservasi"
                        id="tanggal_reservasi"
                        value="{{ old('tanggal_reservasi') }}"
                        class="{{ $errors->has('tanggal_reservasi') ? 'input-error' : '' }}"
                    >
                    @error('tanggal_reservasi')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="customer-create-group">
                    <label for="jam_reservasi">Jam Reservasi</label>
                    <select name="jam_reservasi" id="jam_reservasi" class="{{ $errors->has('jam_reservasi') ? 'input-error' : '' }}">
                        <option value="">-- Pilih Jam Reservasi --</option>
                        <option value="08:00" {{ old('jam_reservasi') == '08:00' ? 'selected' : '' }}>08:00 - 08:30</option>
                        <option value="08:30" {{ old('jam_reservasi') == '08:30' ? 'selected' : '' }}>08:30 - 09:00</option>
                        <option value="09:00" {{ old('jam_reservasi') == '09:00' ? 'selected' : '' }}>09:00 - 09:30</option>
                        <option value="09:30" {{ old('jam_reservasi') == '09:30' ? 'selected' : '' }}>09:30 - 10:00</option>
                        <option value="10:00" {{ old('jam_reservasi') == '10:00' ? 'selected' : '' }}>10:00 - 10:30</option>
                        <option value="10:30" {{ old('jam_reservasi') == '10:30' ? 'selected' : '' }}>10:30 - 11:00</option>
                        <option value="11:00" {{ old('jam_reservasi') == '11:00' ? 'selected' : '' }}>11:00 - 11:30</option>
                        <option value="11:30" {{ old('jam_reservasi') == '11:30' ? 'selected' : '' }}>11:30 - 12:00</option>
                        <option value="12:00" {{ old('jam_reservasi') == '12:00' ? 'selected' : '' }}>12:00 - 12:30</option>
                        <option value="12:30" {{ old('jam_reservasi') == '12:30' ? 'selected' : '' }}>12:30 - 13:00</option>
                        <option value="13:00" {{ old('jam_reservasi') == '13:00' ? 'selected' : '' }}>13:00 - 13:30</option>
                        <option value="13:30" {{ old('jam_reservasi') == '13:30' ? 'selected' : '' }}>13:30 - 14:00</option>
                        <option value="14:00" {{ old('jam_reservasi') == '14:00' ? 'selected' : '' }}>14:00 - 14:30</option>
                        <option value="14:30" {{ old('jam_reservasi') == '14:30' ? 'selected' : '' }}>14:30 - 15:00</option>
                        <option value="15:00" {{ old('jam_reservasi') == '15:00' ? 'selected' : '' }}>15:00 - 15:30</option>
                        <option value="15:30" {{ old('jam_reservasi') == '15:30' ? 'selected' : '' }}>15:30 - 16:00</option>
                        <option value="16:00" {{ old('jam_reservasi') == '16:00' ? 'selected' : '' }}>16:00 - 16:30</option>
                        <option value="16:30" {{ old('jam_reservasi') == '16:30' ? 'selected' : '' }}>16:30 - 17:00</option>
                        <option value="17:00" {{ old('jam_reservasi') == '17:00' ? 'selected' : '' }}>17:00 - 17:30</option>
                        <option value="17:30" {{ old('jam_reservasi') == '17:30' ? 'selected' : '' }}>17:30 - 18:00</option>
                        <option value="18:00" {{ old('jam_reservasi') == '18:00' ? 'selected' : '' }}>18:00 - 18:30</option>
                        <option value="18:30" {{ old('jam_reservasi') == '18:30' ? 'selected' : '' }}>18:30 - 19:00</option>
                        <option value="19:00" {{ old('jam_reservasi') == '19:00' ? 'selected' : '' }}>19:00 - 19:30</option>
                        <option value="19:30" {{ old('jam_reservasi') == '19:30' ? 'selected' : '' }}>19:30 - 20:00</option>
                        <option value="20:00" {{ old('jam_reservasi') == '20:00' ? 'selected' : '' }}>20:00 - 20:30</option>
                        <option value="20:30" {{ old('jam_reservasi') == '20:30' ? 'selected' : '' }}>20:30 - 21:00</option>
                    </select>
                    @error('jam_reservasi')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>

        {{-- ACTION --}}
        <div class="customer-create-actions">
            <a href="{{ route('customer.reservasi.index') }}" class="customer-create-cancel">
                Batal
            </a>

            <button type="submit" class="customer-create-submit">
                Simpan Reservasi
            </button>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paketFoto = document.getElementById('paket_foto');
        const harga = document.getElementById('harga');
        const packagePreview = document.getElementById('packagePreview');

        const tanggalReservasi = document.getElementById('tanggal_reservasi');
        const jamReservasi = document.getElementById('jam_reservasi');

        const bookedSlots = @json($bookedSlots ?? []);

        const daftarHarga = {
            'Paket Indie': 50000,
            'Paket LensArt': 80000,
            'Paket Kalcer': 120000,
            'Paket Custom': 150000
        };

        const detailPaket = {
            'Paket Indie': 'Durasi 10 menit sesi foto, 1 lembar print, dan softcopy file.',
            'Paket LensArt': 'Durasi 15 menit sesi foto, 2 lembar print, dan softcopy file.',
            'Paket Kalcer': 'Durasi 20 menit sesi foto, 4 lembar print, dan softcopy file.',
            'Paket Custom': 'Paket foto fleksibel yang dapat disesuaikan dengan kebutuhan pelanggan.'
        };

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }

        function isiHargaOtomatis() {
            const paketDipilih = paketFoto.value;

            if (daftarHarga[paketDipilih]) {
                harga.value = formatRupiah(daftarHarga[paketDipilih]);

                if (packagePreview) {
                    packagePreview.innerHTML = `
                        <span>Preview Paket</span>
                        <strong>${paketDipilih} - ${formatRupiah(daftarHarga[paketDipilih])}</strong>
                        <p>${detailPaket[paketDipilih]}</p>
                    `;
                }
            } else {
                harga.value = '';

                if (packagePreview) {
                    packagePreview.innerHTML = `
                        <span>Preview Paket</span>
                        <strong>Pilih paket terlebih dahulu</strong>
                        <p>Detail singkat paket akan muncul setelah kamu memilih paket foto.</p>
                    `;
                }
            }
        }

        function resetJamOptions() {
            if (!jamReservasi) return;

            Array.from(jamReservasi.options).forEach((option) => {
                if (!option.value) return;

                option.disabled = false;

                if (option.dataset.originalText) {
                    option.textContent = option.dataset.originalText;
                } else {
                    option.dataset.originalText = option.textContent;
                }
            });
        }

        function updateJamTersedia() {
            if (!tanggalReservasi || !jamReservasi) return;

            const tanggalDipilih = tanggalReservasi.value;

            resetJamOptions();

            if (!tanggalDipilih || !bookedSlots[tanggalDipilih]) {
                return;
            }

            const jamSudahDibooking = bookedSlots[tanggalDipilih];

            Array.from(jamReservasi.options).forEach((option) => {
                if (!option.value) return;

                const jamOption = option.value.substring(0, 5);

                if (jamSudahDibooking.includes(jamOption)) {
                    option.disabled = true;

                    const originalText = option.dataset.originalText || option.textContent;
                    option.dataset.originalText = originalText;
                    option.textContent = originalText + ' (Sudah dibooking)';

                    if (jamReservasi.value === option.value) {
                        jamReservasi.value = '';
                    }
                }
            });
        }

        if (paketFoto && harga) {
            paketFoto.addEventListener('change', isiHargaOtomatis);
            isiHargaOtomatis();
        }

        if (tanggalReservasi && jamReservasi) {
            tanggalReservasi.addEventListener('change', updateJamTersedia);
            updateJamTersedia();
        }
    });
</script>
@endpush
