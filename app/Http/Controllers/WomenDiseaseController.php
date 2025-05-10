<?php

namespace App\Http\Controllers;

use App\Models\WomenDisease;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use DB;

class WomenDiseaseController extends Controller
{
    public function index()
    {
        // Sadece giriş yapmış kullanıcının verilerini alıyoruz
        $womenDiseases = WomenDisease::where('user_id', Auth::id())->get();

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('WomenDisease/List', [
            'womenDiseases' => $womenDiseases
        ]);
    }

    public function create()
    {
        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('WomenDisease/Create', []);
    }

    private function determineResult(array $data): array
    {
        $scores = [
            'Serviks Kanseri' => 0,
            'Uterus Lezyonları' => 0,
            'Endometriyum Kanseri' => 0,
            'Akut veya Kronik Sistit' => 0,
        ];

        // Serviks Kanseri
        if ($data['hpv']) $scores['Serviks Kanseri']++;
        if ($data['cigarette']) $scores['Serviks Kanseri']++;
        if ($data['early_sexual']) $scores['Serviks Kanseri']++;
        if ($data['bad_smell_stream']) $scores['Serviks Kanseri']++;
        if ($data['urine_blood']) $scores['Serviks Kanseri']++;
        if ($data['edema']) $scores['Serviks Kanseri']++;
        if ($data['more_pregnancy']) $scores['Serviks Kanseri']++;

        // Uterus Lezyonları
        if ($data['adet_blood']) $scores['Uterus Lezyonları']++;
        if ($data['pressure']) $scores['Uterus Lezyonları']++;

        // Endometriyum Kanseri
        if ($data['menepoz_blood']) $scores['Endometriyum Kanseri']++;
        if ($data['special_1'] >= 2) $scores['Endometriyum Kanseri'] += $data['special_2'];

        // Akut veya Kronik Sistit
        if ($data['special_2'] >= 2) $scores['Akut veya Kronik Sistit'] += $data['special_2'];

        // Tüm puanlar 1'den düşükse risk bulunmamaktadır
        $maxScore = max($scores);
        if ($maxScore < 2) {
            return [
                'result' => 'Belirtilere göre riskli bir durum gözlemlenmemektedir.',
                'description' => ['Belirtiler ciddi bir hastalık riski oluşturacak seviyede değil.', 'Düzenli kontrollerinizi ihmal etmeyiniz.'],
            ];
        }

        // En yüksek puanlı sonucu al
        $result = collect($scores)->sortDesc()->keys()->first();

        // Açıklamalar
        $descriptions = [
            'Serviks Kanseri' => [
                'Kadın Kanserlerinin önemli bir kısmını oluşturur',
                'Erken tanıda %95 tedavi şansı var ancak geç kalınırsa hastaların %50 si hayatını kaybeder',
                'Tedavi de geç kalınırsa kısırlık olabilir',
            ],
            'Uterus Lezyonları' => [
                'Uterusta iyi huylu veya kötü huylu bir kitle olabilir',
                'Görüntüleme yöntemleriyle kanı gereklidir',
                'Uterus git gide büyür büyüdükçe de kanama artar',
            ],
            'Endometriyum Kanseri' => [
                'Rahim iç duvarından gelişen kanser türüdür',
                'Menopoz sonrası kanama en sık belirtisidir',
                'Erken evrede tanı ile yüksek tedavi şansı vardır',
            ],
            'Akut veya Kronik Sistit' => [
                'Mesane iltihabıdır',
                'Sık idrara çıkma, yanma, kötü koku gibi belirtiler görülür',
                'Antibiyotik tedavisi gerekebilir',
            ],
        ];

        return [
            'result' => $result,
            'description' => $descriptions[$result],
        ];
    }



    public function store(Request $request)
    {

        // Verilerin doğrulanması
        $validated = $request->validate([
            'hpv' => 'required|boolean', // Yaş zorunlu ve 10 karakteri geçemez
            'cigarette' => 'required|boolean', // Akıntı zorunlu ve boolean olmalı
            'early_sexual' => 'required|boolean', // Akıntı fazla ise nullable ve boolean
            'sexual_blood' => 'required|string|max:255', // Koku zorunlu ve 255 karakteri geçemez
            'bad_smell_stream' => 'required|string|max:50', // Renk zorunlu ve 50 karakteri geçemez
            'urine_blood' => 'required|boolean', // Ödem zorunlu ve boolean olmalı
            'edema' => 'required|boolean', // İdrar yaparken yanma zorunlu ve boolean olmalı
            'more_pregnancy' => 'required|boolean', // Kaşıntı veya yanma zorunlu ve boolean olmalı
            'adet_blood' => 'required|boolean', // Şankr zorunlu ve boolean olmalı
            'pressure' => 'required|boolean', // Lenf nodu şişliği nullable ve boolean olmalı
            'menepoz_blood' => 'required|boolean', // Plak döküntü zorunlu ve boolean olmalı
            'late_menepoz' => 'required|boolean', // Vezikül zorunlu ve boolean olmalı
            'special_1' => 'required|integer', // İdrar yapamama zorunlu ve boolean olmalı
            'special_2' => 'required|integer', // İdrar yapamama zorunlu ve boolean olmalı

        ], [
            // Türkçe hata mesajları
            'hpv.required' => 'HPV zorunludur.',
            'hpv.boolean' => 'HPV sadece metin olmalıdır.',
            'cigarette.required' => 'Sigara durumu zorunludur.',
            'cigarette.boolean' => 'Sigara durumu doğru bir şekilde belirtilmelidir.',
            'early_sexual.required' => 'Durum zorunludur.',
            'early_sexual.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'sexual_blood.required' => 'Durum zorunludur.',
            'sexual_blood.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'urine_blood.required' => 'Durum zorunludur.',
            'urine_blood.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'bad_smell_stream.required' => 'Durum zorunludur.',
            'bad_smell_stream.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'edema.required' => 'Durum zorunludur.',
            'edema.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'more_pregnancy.required' => 'Durum zorunludur.',
            'more_pregnancy.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'adet_blood.required' => 'Durum zorunludur.',
            'adet_blood.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'pressure.required' => 'Durum zorunludur.',
            'pressure.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'menepoz_blood.required' => 'Durum zorunludur.',
            'menepoz_blood.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'late_menepoz.required' => 'Durum zorunludur.',
            'late_menepoz.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'special_1.required' => 'Durum zorunludur.',
            'special_1.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
            'special_2.required' => 'Durum zorunludur.',
            'special_2.boolean' => 'Durum doğru bir şekilde belirtilmelidir.',
        ]);
        $result = $this->determineResult($validated);

        try {
            DB::beginTransaction();

            // Veritabanına kayıt işlemi
            $sexuallyDisease = new WomenDisease();
            $sexuallyDisease->user_id = Auth::user()->id;
            $sexuallyDisease->hpv = $validated['hpv'];
            $sexuallyDisease->cigarette = $validated['cigarette'];
            $sexuallyDisease->early_sexual = $validated['early_sexual'];
            $sexuallyDisease->sexual_blood = $validated['sexual_blood'];
            $sexuallyDisease->bad_smell_stream = $validated['bad_smell_stream'];
            $sexuallyDisease->urine_blood = $validated['urine_blood'];
            $sexuallyDisease->edema = $validated['edema'];
            $sexuallyDisease->more_pregnancy = $validated['more_pregnancy'];
            $sexuallyDisease->adet_blood = $validated['adet_blood'];
            $sexuallyDisease->pressure = $validated['pressure'];
            $sexuallyDisease->menepoz_blood = $validated['menepoz_blood'];
            $sexuallyDisease->late_menepoz = $validated['late_menepoz'];
            $sexuallyDisease->special_1 = $validated['special_1'];
            $sexuallyDisease->special_2 = $validated['special_2'];
            $sexuallyDisease->result = $result['result'];
            $sexuallyDisease->description = json_encode($result['description']);
            $sexuallyDisease->save();
            DB::commit();

            return redirect()->route('women-disease.index')->with('success', 'Kayıt başarıyla oluşturuldu. Sonucu Öğrenmek İçin Lütfen Görüntüleme Sayfasına Gidiniz  ');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Kayıt oluşturulurken bir hata oluştu.');
        }
    }

    public function show($id)
    {
        $womenDisease = WomenDisease::findOrFail($id);
        return Inertia::render(
            'WomenDisease/Show',
            ['womenDisease' => $womenDisease]
        );
    }
}
