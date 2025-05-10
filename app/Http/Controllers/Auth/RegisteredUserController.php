<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function craeteRegisterDoctor(): Response
    {
        return Inertia::render('Auth/DoctorRegister');
    }

    public function storeRegisterDoctor(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'description' => 'required|string|max:1000',
            'specialization' => 'required|string|max:1000',
            'years_of_experience' => 'required|string|max:1000',
            'clinic_name' => 'required|string|max:1000',
            'city' => 'required|string|max:1000',
            'district' => 'required|string|max:1000',
            'address' => 'required|string|max:1000',
            'consultation_price' => 'required|numeric|max:1000',

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'İsim alanı zorunludur.',
            'name.string' => 'İsim metin olmalıdır.',
            'name.max' => 'İsim en fazla 255 karakter olabilir.',

            'surname.required' => 'Soyisim alanı zorunludur.',
            'surname.string' => 'Soyisim metin olmalıdır.',
            'surname.max' => 'Soyisim en fazla 255 karakter olabilir.',


            'description.required' => 'Soyisim alanı zorunludur.',
            'description.string' => 'Soyisim metin olmalıdır.',
            'description.max' => 'Soyisim en fazla 1000 karakter olabilir.',

            'specialization.required' => 'Uzmanlık Alanı alanı zorunludur.',
            'specialization.string' => 'Uzmanlık Alanı metin olmalıdır.',
            'years_of_experience.required' => 'Deneyim Yılı alanı zorunludur.',
            'years_of_experience.string' => 'Deneyim Yılı metin olmalıdır.',
            'clinic_name.required' => 'Hastane Adı alanı zorunludur.',
            'clinic_name.string' => 'Hastane Adı metin olmalıdır.',
            'city.required' => 'İl alanı zorunludur.',
            'city.string' => 'İl metin olmalıdır.',
            'district.required' => 'İlçe alanı zorunludur.',
            'district.string' => 'İlçe metin olmalıdır.',
            'address.required' => 'Adres alanı zorunludur.',
            'address.string' => 'Adres metin olmalıdır.',
            'consultation_price.required' => 'Danışma Ücreti alanı zorunludur.',
            'consultation_price.float' => 'Danışma Ücreti metin olmalıdır.',

            'email.required' => 'E-posta adresi zorunludur.',
            'email.string' => 'E-posta metin olmalıdır.',
            'email.lowercase' => 'E-posta küçük harf olmalıdır.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.max' => 'E-posta en fazla 255 karakter olabilir.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',

            'password.required' => 'Şifre alanı zorunludur.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'description' => $request->description,
            'plan' => 'doctor',
            'status' => 'pasif',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'gender' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [

            'gender.required' => 'Cinsiyet alanı zorunludur.',
            'gender.string' => 'Cinsiyet metin olmalıdır.',
            'gender.max' => 'Cinsiyet en fazla 255 karakter olabilir.',

            'name.required' => 'İsim alanı zorunludur.',
            'name.string' => 'İsim metin olmalıdır.',
            'name.max' => 'İsim en fazla 255 karakter olabilir.',

            'surname.required' => 'Soyisim alanı zorunludur.',
            'surname.string' => 'Soyisim metin olmalıdır.',
            'surname.max' => 'Soyisim en fazla 255 karakter olabilir.',

            'email.required' => 'E-posta adresi zorunludur.',
            'email.string' => 'E-posta metin olmalıdır.',
            'email.lowercase' => 'E-posta küçük harf olmalıdır.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.max' => 'E-posta en fazla 255 karakter olabilir.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',

            'password.required' => 'Şifre alanı zorunludur.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
        ]);

        $user = User::create([
            'gender' => $request->gender,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
