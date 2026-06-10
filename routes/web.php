<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CustomerReservasiController;
use App\Http\Controllers\CustomerProfilController;
use App\Http\Controllers\PreferensiController;

Route::get('/', [DashboardController::class, 'publicIndex'])
    ->name('home');

Route::view('/tentang', 'tentang')
    ->name('tentang');

Route::view('/kontak', 'kontak')
    ->name('kontak');

Route::view('/preferensi', 'preferensi')
    ->name('preferensi');

Route::post('/preferensi/simpan', [PreferensiController::class, 'store'])
    ->name('preferensi.store');

Route::get('/hitung/{a}/{b}', function ($a, $b) {
    return $a + $b;
});

/*
|--------------------------------------------------------------------------
| OWNER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'cekowner'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profil', [ProfilController::class, 'index'])
        ->name('profil.index');

    Route::put('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');

    Route::post('/reservasi/live-search', [ReservasiController::class, 'liveSearch'])
        ->name('reservasi.live-search');

    Route::patch('/reservasi/{reservasi}/pembayaran/lunas', [ReservasiController::class, 'tandaiPembayaranLunas'])
        ->name('reservasi.pembayaran.lunas');

    Route::patch('/reservasi/{reservasi}/pembayaran/tolak', [ReservasiController::class, 'tolakPembayaran'])
        ->name('reservasi.pembayaran.tolak');

    Route::resource('reservasi', ReservasiController::class);
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'cekcustomer'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER DASHBOARD + SESSION COUNTER
    |--------------------------------------------------------------------------
    */
    Route::get('/customer/dashboard', function () {
        $now = now('Asia/Jakarta')->format('d M Y H:i:s');

        $userId = auth()->id();

        $countKey = 'customer_' . $userId . '_dashboard_visit_count';
        $firstKey = 'customer_' . $userId . '_dashboard_first_visit';
        $currentKey = 'customer_' . $userId . '_dashboard_current_visit';
        $previousKey = 'customer_' . $userId . '_dashboard_previous_visit';

        $visitCount = (int) request()->cookie($countKey, 0);
        $firstVisit = request()->cookie($firstKey);
        $previousVisit = request()->cookie($currentKey);

        if (!$firstVisit) {
            $firstVisit = $now;
        }

        $visitCount++;

        Cookie::queue($countKey, $visitCount, 60 * 24 * 30);
        Cookie::queue($firstKey, $firstVisit, 60 * 24 * 30);
        Cookie::queue($previousKey, $previousVisit ?? 'Belum ada', 60 * 24 * 30);
        Cookie::queue($currentKey, $now, 60 * 24 * 30);

        return view('customer.dashboard', [
            'visitCount' => $visitCount,
            'firstVisit' => $firstVisit,
            'previousVisit' => $previousVisit ?? 'Belum ada',
            'currentVisit' => $now,
        ]);
    })->name('customer.dashboard');

    Route::post('/customer/dashboard/reset-visit', function () {
        $userId = auth()->id();

        $countKey = 'customer_' . $userId . '_dashboard_visit_count';
        $firstKey = 'customer_' . $userId . '_dashboard_first_visit';
        $currentKey = 'customer_' . $userId . '_dashboard_current_visit';
        $previousKey = 'customer_' . $userId . '_dashboard_previous_visit';

        Cookie::queue(Cookie::forget($countKey));
        Cookie::queue(Cookie::forget($firstKey));
        Cookie::queue(Cookie::forget($currentKey));
        Cookie::queue(Cookie::forget($previousKey));

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Hitungan kunjungan berhasil direset.');
    })->name('customer.dashboard.reset-visit');

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER RESERVASI
    |--------------------------------------------------------------------------
    */
    Route::get('/customer/reservasi', [CustomerReservasiController::class, 'index'])
        ->name('customer.reservasi.index');

    Route::get('/customer/reservasi/create', [CustomerReservasiController::class, 'create'])
        ->name('customer.reservasi.create');

    Route::post('/customer/reservasi', [CustomerReservasiController::class, 'store'])
        ->name('customer.reservasi.store');

    Route::get('/customer/reservasi/{id}/pembayaran', [CustomerReservasiController::class, 'pembayaran'])
        ->name('customer.reservasi.pembayaran');

    Route::post('/customer/reservasi/{id}/upload-bukti', [CustomerReservasiController::class, 'uploadBuktiPembayaran'])
        ->name('customer.reservasi.upload-bukti');

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER PROFIL
    |--------------------------------------------------------------------------
    */
    Route::get('/customer/profil', [CustomerProfilController::class, 'edit'])
        ->name('customer.profil.edit');

    Route::put('/customer/profil', [CustomerProfilController::class, 'update'])
        ->name('customer.profil.update');
});

require __DIR__.'/auth.php';
