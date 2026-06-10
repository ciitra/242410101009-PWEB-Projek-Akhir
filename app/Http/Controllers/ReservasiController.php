<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    private array $filterPakets = [
        'Paket Indie',
        'Paket LensArt',
        'Paket Kalcer',
        'Paket Custom',
    ];

    private array $daftarHarga = [
        'Paket Indie' => 50000,
        'Paket LensArt' => 80000,
        'Paket Kalcer' => 120000,
        'Paket Custom' => 150000,
    ];

    private array $jamReservasi = [
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

    private array $statusPengunciSlot = [
        'Belum Bayar',
        'Menunggu Verifikasi',
        'Lunas',
    ];

    public function index()
    {
        $reservasis = Reservasi::latest()->paginate(10);

        $totalReservasi = Reservasi::count();
        $belumBayar = Reservasi::where('status_pembayaran', 'Belum Bayar')->count();
        $menungguVerifikasi = Reservasi::where('status_pembayaran', 'Menunggu Verifikasi')->count();
        $pembayaranLunas = Reservasi::where('status_pembayaran', 'Lunas')->count();
        $pembayaranDitolak = Reservasi::where('status_pembayaran', 'Ditolak')->count();

        $paketTerpopuler = Reservasi::select('paket_foto')
            ->whereNotNull('paket_foto')
            ->get()
            ->groupBy('paket_foto')
            ->sortByDesc(fn ($items) => $items->count())
            ->keys()
            ->first() ?? 'Belum ada data';

        $filterPakets = $this->filterPakets;

        return view('reservasi.index', compact(
            'reservasis',
            'totalReservasi',
            'belumBayar',
            'menungguVerifikasi',
            'pembayaranLunas',
            'pembayaranDitolak',
            'paketTerpopuler',
            'filterPakets'
        ));
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->input('keyword');

        $reservasis = Reservasi::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('kode_booking', 'like', '%' . $keyword . '%')
                    ->orWhere('nama_pelanggan', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('paket_foto', 'like', '%' . $keyword . '%')
                    ->orWhere('tanggal_reservasi', 'like', '%' . $keyword . '%')
                    ->orWhere('status_pembayaran', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $reservasis->count(),
            'data' => $reservasis->map(function ($reservasi) {
                return [
                    'id' => $reservasi->id,
                    'kode_booking' => $reservasi->kode_booking,
                    'nama_pelanggan' => $reservasi->nama_pelanggan,
                    'email' => $reservasi->email,
                    'paket_foto' => $reservasi->paket_foto,
                    'tanggal_reservasi' => $reservasi->tanggal_reservasi
                        ? Carbon::parse($reservasi->tanggal_reservasi)->format('d M Y')
                        : '-',
                    'jam_reservasi' => $reservasi->jam_reservasi
                        ? substr($reservasi->jam_reservasi, 0, 5)
                        : '-',
                    'status_pembayaran' => $reservasi->status_pembayaran ?? 'Belum Bayar',
                    'bukti_pembayaran' => $reservasi->bukti_pembayaran,
                    'show_url' => route('reservasi.show', $reservasi->id),
                    'edit_url' => route('reservasi.edit', $reservasi->id),
                    'delete_url' => route('reservasi.destroy', $reservasi->id),
                ];
            }),
        ]);
    }

    public function create()
    {
        $filterPakets = $this->filterPakets;
        $bookedSlots = $this->getBookedSlots();
        $kodeBooking = $this->generateKodeBookingOwner();

        return view('reservasi.create', compact('filterPakets', 'bookedSlots', 'kodeBooking'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_booking' => 'required|unique:reservasis,kode_booking',
            'nama_pelanggan' => 'required|min:3',
            'email' => 'required|email',
            'username_instagram' => 'required|min:3',
            'no_hp' => 'required|numeric',
            'jumlah_orang' => 'required|integer|min:1',
            'paket_foto' => 'required|in:Paket Indie,Paket LensArt,Paket Kalcer,Paket Custom',
            'tanggal_reservasi' => 'required|date',
            'jam_reservasi' => 'required|in:' . implode(',', $this->jamReservasi),
        ], [
            'kode_booking.required' => 'Kode booking wajib diisi.',
            'kode_booking.unique' => 'Kode booking sudah digunakan.',

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

        $sudahDibooking = $this->slotSudahDibooking(
            $validatedData['tanggal_reservasi'],
            $validatedData['jam_reservasi']
        );

        if ($sudahDibooking) {
            return back()
                ->withErrors([
                    'jam_reservasi' => 'Jadwal pada tanggal dan jam tersebut sudah dibooking. Silakan pilih jam lain.',
                ])
                ->withInput();
        }

        $validatedData['harga'] = $this->daftarHarga[$validatedData['paket_foto']];
        $validatedData['user_id'] = Auth::id();
        $validatedData['aktif'] = true;
        $validatedData['metode_pembayaran'] = 'Manual Owner';
        $validatedData['status_pembayaran'] = 'Lunas';
        $validatedData['bukti_pembayaran'] = null;

        Reservasi::create($validatedData);

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Data reservasi berhasil ditambahkan dan pembayaran ditandai lunas.');
    }

    public function show(Reservasi $reservasi)
    {
        return view('reservasi.show', compact('reservasi'));
    }

    public function edit(Reservasi $reservasi)
    {
        $filterPakets = $this->filterPakets;
        $bookedSlots = $this->getBookedSlots($reservasi->id);

        return view('reservasi.edit', compact('reservasi', 'filterPakets', 'bookedSlots'));
    }

    public function update(Request $request, Reservasi $reservasi)
    {
        $validatedData = $request->validate([
            'kode_booking' => 'required|unique:reservasis,kode_booking,' . $reservasi->id,
            'nama_pelanggan' => 'required|min:3',
            'email' => 'required|email',
            'username_instagram' => 'required|min:3',
            'no_hp' => 'required|numeric',
            'jumlah_orang' => 'required|integer|min:1',
            'paket_foto' => 'required|in:Paket Indie,Paket LensArt,Paket Kalcer,Paket Custom',
            'tanggal_reservasi' => 'required|date',
            'jam_reservasi' => 'required|in:' . implode(',', $this->jamReservasi),
        ], [
            'kode_booking.required' => 'Kode booking wajib diisi.',
            'kode_booking.unique' => 'Kode booking sudah digunakan.',

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

        $sudahDibooking = $this->slotSudahDibooking(
            $validatedData['tanggal_reservasi'],
            $validatedData['jam_reservasi'],
            $reservasi->id
        );

        if ($sudahDibooking) {
            return back()
                ->withErrors([
                    'jam_reservasi' => 'Jadwal pada tanggal dan jam tersebut sudah dibooking. Silakan pilih jam lain.',
                ])
                ->withInput();
        }

        $validatedData['harga'] = $this->daftarHarga[$validatedData['paket_foto']];
        $validatedData['aktif'] = true;

        $reservasi->update($validatedData);

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Data reservasi berhasil diperbarui.');
    }

    public function tandaiPembayaranLunas(Reservasi $reservasi)
    {
        if (!$reservasi->bukti_pembayaran && ($reservasi->metode_pembayaran ?? 'QRIS') !== 'Manual Owner') {
            return back()->with('error', 'Bukti pembayaran belum diupload oleh customer.');
        }

        $reservasi->update([
            'status_pembayaran' => 'Lunas',
            'aktif' => true,
        ]);

        return back()->with('success', 'Pembayaran berhasil ditandai lunas.');
    }

    public function tolakPembayaran(Reservasi $reservasi)
    {
        if (!$reservasi->bukti_pembayaran && ($reservasi->metode_pembayaran ?? 'QRIS') !== 'Manual Owner') {
            return back()->with('error', 'Bukti pembayaran belum diupload oleh customer.');
        }

        $reservasi->update([
            'status_pembayaran' => 'Ditolak',
            'aktif' => false,
        ]);

        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }

    public function destroy(Reservasi $reservasi)
    {
        $reservasi->delete();

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Data reservasi berhasil dihapus!');
    }

    private function getBookedSlots(?int $excludeId = null): array
    {
        return Reservasi::query()
            ->when($excludeId, function ($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->where(function ($query) {
                $query->whereIn('status_pembayaran', $this->statusPengunciSlot)
                    ->orWhereNull('status_pembayaran');
            })
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
    }

    private function slotSudahDibooking(string $tanggal, string $jam, ?int $excludeId = null): bool
    {
        return Reservasi::query()
            ->when($excludeId, function ($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->whereDate('tanggal_reservasi', $tanggal)
            ->whereTime('jam_reservasi', $jam)
            ->where(function ($query) {
                $query->whereIn('status_pembayaran', $this->statusPengunciSlot)
                    ->orWhereNull('status_pembayaran');
            })
            ->exists();
    }

    private function generateKodeBookingOwner(): string
    {
        $prefix = 'OWN-';

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
