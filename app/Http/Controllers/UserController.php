<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'surname', 'email', 'plan')->get();
        return Inertia::render('User/List', [
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('User/Show', [
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('User/Edit', [
            'user' => $user
        ]);
    }


    public function update(Request $request, $id)
    {
        // Kullanıcıyı bul
        $user = User::findOrFail($id);

        // Validasyon işlemi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // E-posta için kendini hariç tutuyoruz
            'plan' => 'required|string|max:50',
        ], [
            'name.required' => 'Ad alanı gereklidir.',
            'name.string' => 'Ad alanı yalnızca metin içerebilir.',
            'name.max' => 'Ad alanı en fazla 255 karakter uzunluğunda olmalıdır.',

            'surname.required' => 'Soyad alanı gereklidir.',
            'surname.string' => 'Soyad alanı yalnızca metin içerebilir.',
            'surname.max' => 'Soyad alanı en fazla 255 karakter uzunluğunda olmalıdır.',

            'email.required' => 'E-posta alanı gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.max' => 'E-posta adresi en fazla 255 karakter uzunluğunda olmalıdır.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',

            'plan.required' => 'Plan alanı gereklidir.',
            'plan.string' => 'Plan alanı yalnızca metin içerebilir.',
            'plan.max' => 'Plan alanı en fazla 50 karakter uzunluğunda olmalıdır.',
        ]);

        // Kullanıcıyı güncelle
        $user->update([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'email' => $validated['email'],
            'plan' => $validated['plan'],
        ]);

        // Kullanıcıyı güncelledikten sonra, Inertia ile kullanıcıyı edit sayfasına yönlendir
        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    public function delete($id)
    {
        // Find the user by id
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Optionally, return a response or redirect
        return redirect()->route('users.index')->with('success', 'Kullanıcı Başarıyla Silindi.');
    }
}
