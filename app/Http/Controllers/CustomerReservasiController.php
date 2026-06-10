<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CustomerReservasiController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.reservasi.index', compact('reservasis'));
    }

    public function create()
    {
        $filterPakets = [
            'Paket Indie',
            'Paket LensArt',
            'Paket Kalcer',
            'Paket Custom',
        ];

        $bookedSlots = Reservasi::where('aktif', true)
            ->whereIn('status_pembayaran', [
                'Belum Bayar',
                'Menunggu Verifikasi',
                'Lunas',
            ])
            ->get(['tanggal_reservasi', 'jam_reservasi'])
            ->groupBy(function ($reservasi) {
                return Carbon::parse($reservasi->tanggal_reservasi)->format('Y-m-d');
            })
            ->map(function ($items) {
                return $items->map(function ($reservasi) {
                    return substr($reservasi->jam_reservasi, 0, 5);
                })->values();
            })
            ->toArray();

        return view('customer.reservasi.create', compact('filterPakets', 'bookedSlots'));
    }

    public function store(Request $request)
    {
        $daftarHarga = [
            'Paket Indie' => 50000,
            'Paket LensArt' => 80000,
            'Paket Kalcer' => 120000,
            'Paket Custom' => 150000,
        ];

        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|min:3',
            'email' => 'required|email',
            'username_instagram' => 'required|min:3',
            'no_hp' => 'required|numeric',
            'jumlah_orang' => 'required|integer|min:1',
            'paket_foto' => 'required|in:Paket Indie,Paket LensArt,Paket Kalcer,Paket Custom',
            'tanggal_reservasi' => 'required|date',
            'jam_reservasi' => 'required|in:08:00,08:30,09:00,09:30,10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00,17:30,18:00,18:30,19:00,19:30,20:00,20:30',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nama_pelanggan.min' => 'Nama pelanggan minimal 3 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'username_instagram.required' => 'Username Instagram wajib diisi.',
            'username_instagram.min' => 'Username Instagram minimal 3 karakter.',

            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.numeric' => 'Nomor HP hanya boleh berisi angka.',

            'jumlah_orang.required' => 'Jumlah orang wajib diisi.',
            'jumlah_orang.integer' => 'Jumlah orang harus berupa angka.',
            'jumlah_orang.min' => 'Jumlah orang minimal 1.',

            'paket_foto.required' => 'Paket foto wajib dipilih.',
            'paket_foto.in' => 'Paket foto tidak valid.',

            'tanggal_reservasi.required' => 'Tanggal reservasi wajib diisi.',
            'tanggal_reservasi.date' => 'Tanggal reservasi tidak valid.',

            'jam_reservasi.required' => 'Jam reservasi wajib dipilih.',
            'jam_reservasi.in' => 'Jam reservasi tidak valid.',
        ]);

        $sudahDibooking = Reservasi::whereDate('tanggal_reservasi', $validatedData['tanggal_reservasi'])
            ->whereTime('jam_reservasi', $validatedData['jam_reservasi'])
            ->where('aktif', true)
            ->whereIn('status_pembayaran', [
                'Belum Bayar',
                'Menunggu Verifikasi',
                'Lunas',
            ])
            ->exists();

        if ($sudahDibooking) {
            return back()
                ->withErrors([
                    'jam_reservasi' => 'Jadwal pada tanggal dan jam tersebut sudah dibooking. Silakan pilih jam lain.',
                ])
                ->withInput();
        }

        $validatedData['kode_booking'] = $this->generateKodeBookingCustomer();
        $validatedData['harga'] = $daftarHarga[$validatedData['paket_foto']];
        $validatedData['metode_pembayaran'] = 'QRIS';
        $validatedData['status_pembayaran'] = 'Belum Bayar';
        $validatedData['bukti_pembayaran'] = null;
        $validatedData['aktif'] = true;
        $validatedData['user_id'] = Auth::id();
        $validatedData['foto'] = null;

        $reservasi = Reservasi::create($validatedData);

        return redirect()
            ->route('customer.reservasi.pembayaran', $reservasi->id)
            ->with('success', 'Reservasi berhasil dibuat. Silakan lakukan pembayaran melalui QRIS.');
    }

    public function pembayaran($id)
    {
        $reservasi = Reservasi::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('customer.reservasi.pembayaran', compact('reservasi'));
    }

    public function uploadBuktiPembayaran(Request $request, $id)
    {
        $reservasi = Reservasi::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format bukti pembayaran harus JPG, JPEG, atau PNG.',
            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 2MB.',
        ]);

        if ($reservasi->bukti_pembayaran && Storage::disk('public')->exists($reservasi->bukti_pembayaran)) {
            Storage::disk('public')->delete($reservasi->bukti_pembayaran);
        }

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        $reservasi->update([
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'Menunggu Verifikasi',
        ]);

        return redirect()
            ->route('customer.reservasi.pembayaran', $reservasi->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Silakan tunggu verifikasi dari owner.');
    }

    private function generateKodeBookingCustomer(): string
    {
        $prefix = 'CST-';

        $lastKode = Reservasi::where('kode_booking', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->value('kode_booking');

        $nextNumber = 1;

        if ($lastKode) {
            $lastNumber = (int) str_replace($prefix, '', $lastKode);
            $nextNumber = $lastNumber + 1;
        }

        do {
            $kodeBooking = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $nextNumber++;
        } while (Reservasi::where('kode_booking', $kodeBooking)->exists());

        return $kodeBooking;
    }
}
