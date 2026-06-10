<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function publicIndex()
    {
        $paketFotos = $this->getPaketFotos();

        return view('landing', compact('paketFotos'));
    }

    public function index()
    {
        $paketFotos = $this->getPaketFotos();

        // Slot ini harus sama dengan pilihan jam di form reservasi
        $jamReservasis = [
            '08:00',
            '08:30',
            '09:00',
            '09:30',
            '10:00',
            '10:30',
            '11:00',
            '11:30',
            '12:00',
            '12:30',
            '13:00',
            '13:30',
            '14:00',
            '14:30',
            '15:00',
            '15:30',
            '16:00',
            '16:30',
            '17:00',
            '17:30',
            '18:00',
            '18:30',
            '19:00',
            '19:30',
            '20:00',
            '20:30',
        ];

        $reservasis = Reservasi::latest()->get();

        $today = Carbon::today();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        /*
        |--------------------------------------------------------------------------
        | Statistik Utama Dashboard Owner
        |--------------------------------------------------------------------------
        */

        $totalReservasi = $reservasis->count();

        $reservasiHariIni = Reservasi::whereDate('tanggal_reservasi', $today)
            ->whereIn('status_pembayaran', [
                'Belum Bayar',
                'Menunggu Verifikasi',
                'Lunas',
            ])
            ->count();

        $reservasiBulanIni = Reservasi::whereMonth('tanggal_reservasi', $currentMonth)
            ->whereYear('tanggal_reservasi', $currentYear)
            ->where('status_pembayaran', 'Lunas')
            ->get();

        $pendapatanBulanIni = $reservasiBulanIni->sum(function ($reservasi) {
            return $this->formatHargaKeAngka($reservasi->harga ?? 0);
        });

        $totalPendapatan = Reservasi::where('status_pembayaran', 'Lunas')
            ->get()
            ->sum(function ($reservasi) {
                return $this->formatHargaKeAngka($reservasi->harga ?? 0);
            });

        $paketFavorit = $reservasis
            ->whereNotNull('paket_foto')
            ->groupBy('paket_foto')
            ->sortByDesc(function ($items) {
                return $items->count();
            })
            ->keys()
            ->first();

        if (!$paketFavorit) {
            $paketFavorit = 'Belum ada data';
        }

        $customerTerdaftar = User::query()
            ->where('role', '=', 'customer')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Jadwal Hari Ini dan Slot Studio
        |--------------------------------------------------------------------------
        | Slot dianggap terpakai jika status pembayaran:
        | - Belum Bayar
        | - Menunggu Verifikasi
        | - Lunas
        |
        | Status Ditolak tidak mengunci jadwal.
        |--------------------------------------------------------------------------
        */

        $jadwalHariIni = Reservasi::whereDate('tanggal_reservasi', $today)
            ->whereIn('status_pembayaran', [
                'Belum Bayar',
                'Menunggu Verifikasi',
                'Lunas',
            ])
            ->orderBy('jam_reservasi')
            ->get();

        $totalSlotHarian = count($jamReservasis);
        $slotTerpakaiHariIni = $jadwalHariIni->count();
        $slotTersedia = max($totalSlotHarian - $slotTerpakaiHariIni, 0);

        if ($slotTerpakaiHariIni >= 10) {
            $statusStudio = 'Ramai';
            $statusClass = 'status-warning';
        } elseif ($slotTerpakaiHariIni >= 5) {
            $statusStudio = 'Normal';
            $statusClass = 'status-safe';
        } else {
            $statusStudio = 'Longgar';
            $statusClass = 'status-safe';
        }

        /*
        |--------------------------------------------------------------------------
        | Data Preview Reservasi
        |--------------------------------------------------------------------------
        */

        $reservasiTerbaru = $reservasis->take(5);

        $reservasiDummies = $reservasiTerbaru->map(function ($reservasi) {
            return [
                'id' => $reservasi->id,
                'kode' => $reservasi->kode_booking,
                'nama' => $reservasi->nama_pelanggan,
                'email' => $reservasi->email,
                'instagram' => $reservasi->username_instagram ?? '-',
                'no_hp' => $reservasi->no_hp ?? '-',
                'jumlah_orang' => $reservasi->jumlah_orang,
                'paket' => $reservasi->paket_foto,
                'harga' => $reservasi->harga,
                'tanggal' => $reservasi->tanggal_reservasi,
                'jam' => $reservasi->jam_reservasi,
                'status_pembayaran' => $reservasi->status_pembayaran ?? 'Belum Bayar',
            ];
        })->toArray();

        /*
        |--------------------------------------------------------------------------
        | Card Statistik untuk View
        |--------------------------------------------------------------------------
        */

        $statCards = [
            [
                'judul' => 'Total Reservasi',
                'nilai' => $totalReservasi,
                'keterangan' => 'Semua data reservasi pelanggan',
                'ikon' => 'calendar',
                'warna' => 'stat-brown',
            ],
            [
                'judul' => 'Reservasi Hari Ini',
                'nilai' => $reservasiHariIni,
                'keterangan' => now()->format('d M Y'),
                'ikon' => 'clock',
                'warna' => 'stat-orange',
            ],
            [
                'judul' => 'Pendapatan Bulan Ini',
                'nilai' => 'Rp' . number_format($pendapatanBulanIni, 0, ',', '.'),
                'keterangan' => now()->format('F Y'),
                'ikon' => 'income',
                'warna' => 'stat-green',
            ],
            [
                'judul' => 'Paket Favorit',
                'nilai' => $paketFavorit,
                'keterangan' => 'Paling sering dipilih pelanggan',
                'ikon' => 'package',
                'warna' => 'stat-red',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Data Statistik Tambahan
        |--------------------------------------------------------------------------
        */

        $insightStudio = [
            [
                'label' => 'Total Reservasi',
                'nilai' => $totalReservasi,
            ],
            [
                'label' => 'Total Pendapatan',
                'nilai' => 'Rp' . number_format($totalPendapatan, 0, ',', '.'),
            ],
            [
                'label' => 'Customer Terdaftar',
                'nilai' => $customerTerdaftar,
            ],
            [
                'label' => 'Paket Terpopuler',
                'nilai' => $paketFavorit,
            ],
            [
                'label' => 'Slot Tersedia Hari Ini',
                'nilai' => $slotTersedia,
            ],
            [
                'label' => 'Status Studio Hari Ini',
                'nilai' => $statusStudio,
            ],
        ];

        return view('dashboard', compact(
            'paketFotos',
            'jamReservasis',
            'reservasis',
            'reservasiDummies',
            'reservasiTerbaru',
            'jadwalHariIni',
            'statCards',
            'insightStudio',
            'totalReservasi',
            'reservasiHariIni',
            'pendapatanBulanIni',
            'totalPendapatan',
            'paketFavorit',
            'customerTerdaftar',
            'slotTersedia',
            'slotTerpakaiHariIni',
            'statusStudio',
            'statusClass'
        ));
    }

    private function getPaketFotos(): array
    {
        return [
            [
                'nama' => 'Paket Indie',
                'deskripsi' => 'Durasi 10 menit sesi foto, 1 lembar print, dan softcopy file.',
                'harga' => 'Rp50.000',
            ],
            [
                'nama' => 'Paket LensArt',
                'deskripsi' => 'Durasi 15 menit sesi foto, 2 lembar print, dan softcopy file.',
                'harga' => 'Rp80.000',
            ],
            [
                'nama' => 'Paket Kalcer',
                'deskripsi' => 'Durasi 20 menit sesi foto, 4 lembar print, dan softcopy file.',
                'harga' => 'Rp120.000',
            ],
            [
                'nama' => 'Paket Custom',
                'deskripsi' => 'Paket foto fleksibel yang dapat disesuaikan dengan kebutuhan pelanggan.',
                'harga' => 'Rp150.000',
            ],
        ];
    }

    private function formatHargaKeAngka($harga): int
    {
        if (is_numeric($harga)) {
            return (int) $harga;
        }

        return (int) preg_replace('/[^0-9]/', '', $harga);
    }
}
