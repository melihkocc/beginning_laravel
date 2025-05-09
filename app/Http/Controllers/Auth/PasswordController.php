<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ],
            [
                'current_password.required' => 'Mevcut şifre alanı zorunludur.',
                'current_password.current_password' => 'Mevcut şifreniz hatalı.',
                'password.required' => 'Yeni şifre alanı zorunludur.',
                'password.confirmed' => 'Yeni şifre ve şifre tekrar alanı aynı olmalıdır.',
                'password.min' => 'Yeni şifre en az :min karakter olmalıdır.',
                'password.letters' => 'Yeni şifre en az bir harf içermelidir.',
                'password.mixed' => 'Yeni şifre en az bir büyük ve bir küçük harf içermelidir.',
                'password.numbers' => 'Yeni şifre en az bir rakam içermelidir.',
                'password.symbols' => 'Yeni şifre en az bir özel karakter içermelidir.',
            ]
        );

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Şifreniz başarıyla güncellendi.');
    }
}
