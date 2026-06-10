<?php

namespace App\Http\Controllers;

use App\Models\ProfilOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = ProfilOwner::first();

        if (!$profil) {
            $profil = ProfilOwner::create([
                'nama_owner' => 'Owner Studio LensArt',
                'email' => 'studiolensart@gmail.com',
                'nama_studio' => 'Studio LensArt',
                'foto' => null,
            ]);
        }

        return view('profil.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $profil = ProfilOwner::first();

        if (!$profil) {
            $profil = ProfilOwner::create([
                'nama_owner' => 'Owner Studio LensArt',
                'email' => 'studiolensart@gmail.com',
                'nama_studio' => 'Studio LensArt',
                'foto' => null,
            ]);
        }

        $validatedData = $request->validate([
            'nama_owner' => 'required|min:3',
            'email' => 'required|email',
            'nama_studio' => 'required|min:3',
            'foto' => 'nullable|image|mimes:jpg,png|max:2048',
        ], [
            'nama_owner.required' => 'Nama owner wajib diisi.',
            'nama_owner.min' => 'Nama owner minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'nama_studio.required' => 'Nama studio wajib diisi.',
            'nama_studio.min' => 'Nama studio minimal 3 karakter.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat jpg atau png.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($profil->foto) {
                Storage::disk('public')->delete($profil->foto);
            }

            $validatedData['foto'] = $request->file('foto')->store('profil-owner', 'public');
        }

        $profil->update($validatedData);

        return redirect()
            ->route('profil.index')
            ->with('success', 'Profil owner berhasil diperbarui.');
    }
}
