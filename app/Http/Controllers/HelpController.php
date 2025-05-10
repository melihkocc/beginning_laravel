<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use DB;

class HelpController extends Controller
{
    public function doctorIndex()
    {
        // Sadece giriş yapmış kullanıcının verilerini alıyoruz
        $helps = Help::where('doctor_id', Auth::id())->get();

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('Help/Doctor/List', [
            'helps' => $helps
        ]);
    }

    public function diseaseIndex()
    {
        // Sadece giriş yapmış kullanıcının verilerini alıyoruz
        $helps = Help::with('doctor')->where('patient_id', Auth::id())->get();

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('Help/Disease/List', [
            'helps' => $helps
        ]);
    }

    public function findDoctor()
    {
        // Sadece giriş yapmış kullanıcının verilerini alıyoruz
        $doctors = User::where('plan', 'doctor')
            ->where('status', 'aktif')
            ->get();

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('Help/Disease/Find', [
            'doctors' => $doctors
        ]);
    }

    public function storeHelp(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required', // Yaş zorunlu ve 10 karakteri geçemez
            'doctor_id' => 'required', // Akıntı zorunlu ve boolean olmalı
            'complaint_description' => 'required|string|max:500', // Koku zorunlu ve 255 karakteri geçemez
        ], [
            // Türkçe hata mesajları
            'patient_id.required' => 'HPV zorunludur.',
            'doctor_id.required' => 'Sigara durumu zorunludur.',
            'complaint_description.required' => 'Şikayet Açıklaması zorunludur.',
            'complaint_description.max' => 'Şikayet Açıklaması max 500 karakter olmalıdır.',
        ]);

        try {
            DB::beginTransaction();

            $help = new Help();
            $help->patient_id = $validated['patient_id'];
            $help->doctor_id = $validated['doctor_id'];
            $help->complaint_description = $validated['complaint_description'];
            $help->save();
            DB::commit();
            return redirect()->route('help-disease.index')->with('success', 'Talep başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Kayıt oluşturulurken bir hata oluştu.');
        }

        dd($request);
    }

    public function showHelpDisease($id)
    {
        $help = Help::with(['doctor', 'patient'])->findOrFail($id);

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('Help/Disease/Show', [
            'help' => $help
        ]);
    }


    ///// ortak messages

}
