<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Eğer e-posta adresi değiştirilmediyse, unique kuralını geçici olarak devre dışı bırak
        $emailRule = 'required|string|lowercase|email|max:255';
        if ($request->email !== $request->user()->email) {
            // Eğer e-posta adresi değiştiyse, 'unique' doğrulamasını ekleyin
            $emailRule .= '|unique:' . User::class;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3', "regex:/^[a-zA-ZçÇğĞıİöÖşŞüÜ\s]+$/u"],
            'surname' => ['required', 'string', 'max:255', 'min:2', "regex:/^[a-zA-ZçÇğĞıİöÖşŞüÜ\s]+$/u"],
            'email' => $emailRule,
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Ad zorunludur.',
            'name.regex' => 'Ad yalnızca harf içerebilir.',
        ]);

        // Kullanıcıyı güncelle
        $request->user()->fill($validated);

        // E-posta değişmişse, email doğrulama bilgisini sıfırla
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Profil güncelleme başarı mesajı
        return redirect()->route('profile.edit')->with('success', 'Profil başarıyla güncellendi.');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
