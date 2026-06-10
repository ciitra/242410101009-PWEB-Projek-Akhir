<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerProfilController extends Controller
{
    public function edit()
    {
        return view('customer.profil');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
        ]);

        $user->update($validatedData);

        return redirect()
            ->route('customer.profil.edit')
            ->with('success', 'Profil customer berhasil diperbarui.');
    }
}
