<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferensiController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'font_size' => 'required|in:small,normal,large',
        ]);

        $theme = $validatedData['theme'];
        $fontSize = $validatedData['font_size'];

        $cookieThemeSebelumnya = $request->cookie('theme', 'belum ada');
        $cookieFontSebelumnya = $request->cookie('font_size', 'belum ada');

        return response()
            ->json([
                'success' => true,
                'message' => 'Preferensi berhasil disimpan ke cookie.',
                'data' => [
                    'theme_baru' => $theme,
                    'font_size_baru' => $fontSize,
                    'theme_sebelumnya' => $cookieThemeSebelumnya,
                    'font_size_sebelumnya' => $cookieFontSebelumnya,
                ],
            ])
            ->cookie('theme', $theme, 60 * 24 * 30, null, null, false, false)
            ->cookie('font_size', $fontSize, 60 * 24 * 30, null, null, false, false);
    }
}

