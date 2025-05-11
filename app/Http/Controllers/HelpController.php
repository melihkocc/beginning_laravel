<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\SexuallyDisease;
use App\Models\User;
use App\Models\WomenDisease;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use DB;
use Hamcrest\Type\IsDouble;

class HelpController extends Controller
{
    public function doctorIndex()
    {
        // Sadece giriş yapmış kullanıcının verilerini alıyoruz
        $helps = Help::with(['doctor', 'patient'])->where('doctor_id', Auth::id())->get();

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('Help/Doctor/List', [
            'helps' => $helps
        ]);
    }

    public function showHelpDoctor($id)
    {
        $help = Help::with(['doctor', 'patient'])->findOrFail($id);
        $womenDiseases = WomenDisease::where('user_id',$help->patient->id)->get();
        $sexuallyDiseases = SexuallyDisease::where('user_id',$help->patient->id)->get();

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('Help/Doctor/Show', [
            'help' => $help,
            'womenDiseases' => $womenDiseases,
            'sexuallyDiseases' => $sexuallyDiseases
        ]);
    }

    public function activateHelp(Request $request, $id)
    {
        $help = Help::findOrFail($id);
        $help->status = true;
        $help->doctor_description = $request->doctor_description;
        $help->save();

        // Inertia ile veriyi gönderiyoruz
        return redirect()->route('help-doctor.index')->with('success', 'Talep başarıyla onaylandı.');
    }
    //// patient

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

    public function showMessage($id)
    {
        $help = Help::with(['doctor', 'patient'])->findOrFail($id);

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('Help/Message', [
            'help' => $help
        ]);
    }

    public function sendMessage(Request $request, $id)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $help = Help::findOrFail($id);

        // Giriş yapan kullanıcının hasta mı doktor mu olduğunu kontrol ediyoruz
        $userId = Auth::id();
        $isPatient = $userId === $help->patient_id;
        $isDoctor = $userId === $help->doctor_id;


        if (!$isPatient && !$isDoctor) {
            return response()->json(['error' => 'Bu yardım talebine mesaj gönderme izniniz yok.'], 403);
        }

        // Mevcut mesajları alıyoruz
        $patientMessages = $help->patient_messages ? json_decode($help->patient_messages, true) : [];
        $doctorMessages = $help->doctor_messages ? json_decode($help->doctor_messages, true) : [];

        // Yeni mesaj
        $newMessage = [
            'message' => $validated['message'],
            'created_at' => now()->toDateTimeString(),
        ];

        // Mesajı doğru tarafa ekliyoruz
        if ($isPatient) {
            $patientMessages[] = $newMessage;
            $help->patient_messages = json_encode($patientMessages);
        } elseif ($isDoctor) {
            $doctorMessages[] = $newMessage;
            $help->doctor_messages = json_encode($doctorMessages);
        }

        // Veritabanını güncelliyoruz
        $help->save();
        return redirect()->back()->with('success', 'Mesaj başarıyla gönderildi.');
    }
}
