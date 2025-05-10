<?php

namespace App\Http\Controllers;

use App\Models\SexuallyDisease;
use Illuminate\Http\Request;
use Auth;
use Inertia\Inertia;
use DB;

class SexuallyDiseaseController extends Controller
{
    public function index()
    {
        // Sadece giriş yapmış kullanıcının verilerini alıyoruz
        $sexuallyDiseases = SexuallyDisease::where('user_id', Auth::id())->get();

        // Inertia ile veriyi gönderiyoruz
        return Inertia::render('SexuallyDisease/List', [
            'sexuallyDiseases' => $sexuallyDiseases
        ]);
    }

    public function create()
    {
        return Inertia::render(
            'SexuallyDisease/Create',
            []
        );
    }

    private function determineResult(array $data): array
    {
        // 1. Genital Herpes doğrudan kontrol
        if ($data['vezikul']) {
            return [
                'result' => 'Genital Herpes',
                'description' => [
                    'İçi sıvı dolu kabarcıklar ve hassasiyet yapar.',
                    'Tedavi edilmezse yüzeyel ülserlere dönüşebilir.',
                    'Üretrayı tutarsa idrar yapamama (akut retansiyon) görülebilir.',
                    'Yılda ortalama 4 kez tekrar eder.',
                    'Nörolojik ağrılara neden olabilir.'
                ]
            ];
        }

        // 2. Hastalık belirtilerine göre puanlama
        $scores = [];

        // Trichomonas Vaginalis
        $scores['Trichomonas Vaginalis Enfeksiyonu'] = 0;
        if ($data['color'] === 'sarı yeşil') $scores['Trichomonas Vaginalis Enfeksiyonu']++;
        if ($data['smell'] === 'kötü kokulu') $scores['Trichomonas Vaginalis Enfeksiyonu']++;
        if ($data['burning_urine']) $scores['Trichomonas Vaginalis Enfeksiyonu']++;
        if ($data['itching_or_burning']) $scores['Trichomonas Vaginalis Enfeksiyonu']++;

        // Neisseria Gonorrhea
        $scores['Neisseria Gonorrhea'] = 0;
        if ((int)$data['age'] < 25) $scores['Neisseria Gonorrhea']++;
        if ($data['stream']) $scores['Neisseria Gonorrhea']++;
        if (in_array($data['is_more_stream'], [true, null])) $scores['Neisseria Gonorrhea']++;
        if ($data['color'] === 'beyaz sarı') $scores['Neisseria Gonorrhea']++;

        // Chlamidya trochomatis
        $scores['Chlamidya trochomatis'] = 0;
        if ((int)$data['age'] < 25) $scores['Chlamidya trochomatis']++;
        if ($data['color'] === 'şeffaf ve jelimsi kıvamda') $scores['Chlamidya trochomatis']++;
        if ($data['edema']) $scores['Chlamidya trochomatis']++;
        if ($data['burning_urine']) $scores['Chlamidya trochomatis']++;

        // Sfiliz
        $scores['Sfiliz (Treponema Pallidum)'] = 0;
        if ($data['sankr']) $scores['Sfiliz (Treponema Pallidum)']++;
        if ($data['lenf_node']) $scores['Sfiliz (Treponema Pallidum)']++;
        if ($data['plaque_rash']) $scores['Sfiliz (Treponema Pallidum)']++;
        if ($data['need_to_urinate']) $scores['Sfiliz (Treponema Pallidum)']++;

        // En yüksek skoru alan hastalığı bul
        arsort($scores);
        $topDisease = key($scores);
        $topScore = current($scores);

        // Eğer hiç belirti eşleşmediyse
        if ($topScore <= 2) {
            return [
                'result' => 'Cinsel Yolla Bulaşan Bir Hastalığa Sahip Olma Riskiniz Düşüktür.',
                'description' => [
                    'Belirtileriniz mevcut veritabanımızla eşleşmemektedir.',
                    'Yine de kesin tanı için bir doktora başvurmanızı öneririz.'
                ]
            ];
        }

        // Açıklamaları belirle
        $descriptions = [
            'Trichomonas Vaginalis Enfeksiyonu' => [
                'Bu enfeksiyona sıklıkla başka bir enfeksiyon da eşlik edebilir.',
                'Servikste küçük kanama odaklarına neden olabilir.',
                'Doğum sırasında bebeğe geçebilir.',
                'Partnerinizin de tedavi olması gerekir.',
                'Tedavi edilmezse ciddi sonuçlara yol açabilir.',
                'Trichomonas vaginalis, genital bölgede iltihaplanmaya yol açar. Bu durum, HIV gibi diğer cinsel yolla bulaşan enfeksiyonların daha kolay bulaşmasına ve yayılmasına neden olabilir.',
                'Tedavi edilmeyen enfeksiyon, kadınlarda pelvik inflamatuar hastalık (PID) gelişimine yol açabilir. PID, rahim, fallop tüpleri ve yumurtalıkları etkileyen bir enfeksiyon olup, ciddi sağlık sorunlarına neden olabilir.',
                'Trichomonas vaginalis enfeksiyonu, hamilelik sırasında düşük riski, erken doğum ve düşük doğum ağırlığı gibi komplikasyonlara yol açabilir.',
                'Trichomonas vaginalis, bağışıklık sistemini zayıflatabilir ve vücuda karşı başka enfeksiyonlara daha yatkın hale getirebilir.',
            ],
            'Neisseria Gonorrhea' => [
                'Üretra, böbrek, mesane gibi birçok organı etkileyebilir.',
                'Fallop tüplerine saldırarak kısırlığa neden olabilir.',
                'Partnerler de tedavi edilmeli.',
                'Tedavi süresince cinsel ilişkiye girilmemelidir.'
            ],
            'Chlamidya trochomatis' => [
                'Chlamydia enfeksiyonu, fallop tüplerinde tıkanıklığa yol açarak ektopik gebelik (dış gebelik) riskini artırabilir. Ektopik gebelik, tüplerde veya dış genital organlarda bebek gelişmesi durumudur ve bu durum hayatı tehdit edebilir.',
                'Gebelerde düşük ve erken doğuma neden olabilir.',
                'Kadınlarda yıllık tarama önerilir.',
                'Partnerin de tedavi olması gerekir.',
                'Enfekte anneden doğum sırasında bebeklere geçebilir. Yenidoğanlar, doğum kanalında Chlamydia bakterisini alarak, gözde enfeksiyon (konjonktivit) veya pnömoni (zatürre) gibi ciddi sağlık sorunlarına yol açabilir.',
                'Chlamydia enfeksiyonu, reaktif artrit adı verilen bir duruma yol açabilir. Bu, vücudun bağışıklık sistemi tarafından eklemlere saldırmasıyla eklem iltihabına neden olur. Ayrıca, idrar yolları enfeksiyonu, göz iltihaplanması ve cilt döküntülerine de yol açabilir.'
            ],
            'Sfiliz (Treponema Pallidum)' => [
                'Birincil evre: Yumuşak, ağrısız yaralar (şankr) genital bölgede veya enfekte bölgelerde oluşur.',
                'İkincil evre: Vücutta döküntüler, ateş, boğaz ağrısı, lenf bezi şişliği, baş ağrısı gibi genel enfeksiyon belirtileri görülür. Bu dönemde bulaşıcılık çok yüksektir.',
                'Üçüncül evre: Yıllar sonra tedavi edilmezse, organlarda ciddi hasara yol açabilir. Kalp, damarlar, sinir sistemi ve diğer organlar etkilenebilir.',
                'Tersiyer sifiliz, kalpte ve damarlar üzerinde ciddi hasar yaratabilir. Özellikle aort damarında genişleme (aort anevrizması) ve aort kapak hastalığı görülebilir. Bu durum kalp yetmezliğine yol açabilir.',
                'Tersiyer sifiliz, sinir sistemine ciddi zararlar verebilir. Tabes dorsalis, omurilikteki hasar nedeniyle denge kaybı, kas güçsüzlüğü ve ağrılı nöropatiler gelişebilir. Ayrıca, sifilitik ensefalit ve demans gibi beyin hasarlarına yol açabilir. Bu durum zihinsel işlev kaybına ve ruhsal bozukluklara neden olabilir',
                'Sifiliz, gözlerde ciddi hasarlara yol açabilir. Sifilitik konjonktivit ve retinada hasar meydana gelebilir. Ayrıca, işitme kaybı da sinir sistemi etkilenmesiyle oluşabilir.',
                'Hamile kadınlarda sifiliz, düşük, erken doğum, erken suyun açılması, düşük doğum ağırlığı ve doğumda ölüm risklerini artırabilir. Ayrıca, enfekte anne, doğum sırasında bebeğine sifiliz bulaştırabilir.',
                'Enfekte anneden doğum sırasında bebek sifiliz bulaşabilir. Yenidoğanlarda doğuştan sifiliz, ciddi cilt döküntülerine, organ hasarına, beyin hasarına ve ölüme yol açabilir.',
                'Sifiliz tedavi edilmezse vücutta pek çok organı etkileyebilir. Karaciğer, böbrekler, deri ve kemikler gibi organlar hasar görebilir. Sifilizli lezyonlar, organlarda hasar ve enfeksiyon oluşturabilir.'

            ]
        ];

        return [
            'result' => $topDisease,
            'description' => $descriptions[$topDisease]
        ];
    }

    public function store(Request $request)
    {

        // Verilerin doğrulanması
        $validated = $request->validate([
            'age' => 'required|string|max:10', // Yaş zorunlu ve 10 karakteri geçemez
            'stream' => 'required|boolean', // Akıntı zorunlu ve boolean olmalı
            'is_more_stream' => 'nullable|boolean', // Akıntı fazla ise nullable ve boolean
            'smell' => 'required|string|max:255', // Koku zorunlu ve 255 karakteri geçemez
            'color' => 'required|string|max:50', // Renk zorunlu ve 50 karakteri geçemez
            'edema' => 'required|boolean', // Ödem zorunlu ve boolean olmalı
            'burning_urine' => 'required|boolean', // İdrar yaparken yanma zorunlu ve boolean olmalı
            'itching_or_burning' => 'required|boolean', // Kaşıntı veya yanma zorunlu ve boolean olmalı
            'sankr' => 'required|boolean', // Şankr zorunlu ve boolean olmalı
            'lenf_node' => 'nullable|boolean', // Lenf nodu şişliği nullable ve boolean olmalı
            'plaque_rash' => 'required|boolean', // Plak döküntü zorunlu ve boolean olmalı
            'vezikul' => 'required|boolean', // Vezikül zorunlu ve boolean olmalı
            'need_to_urinate' => 'required|boolean', // İdrar yapamama zorunlu ve boolean olmalı
        ], [
            // Türkçe hata mesajları
            'age.required' => 'Yaş zorunludur.',
            'age.string' => 'Yaş sadece metin olmalıdır.',
            'age.max' => 'Yaş 10 karakteri geçemez.',
            'stream.required' => 'Akıntı durumu zorunludur.',
            'stream.boolean' => 'Akıntı durumu doğru bir şekilde belirtilmelidir.',
            'is_more_stream.boolean' => 'Akıntı fazla mı sorusu doğru bir şekilde belirtilmelidir.',
            'smell.required' => 'Koku durumu zorunludur.',
            'smell.string' => 'Koku metin olmalıdır.',
            'smell.max' => 'Koku açıklaması 255 karakteri geçemez.',
            'color.required' => 'Renk durumu zorunludur.',
            'color.string' => 'Renk metin olmalıdır.',
            'color.max' => 'Renk açıklaması 50 karakteri geçemez.',
            'edema.required' => 'Ödem durumu zorunludur.',
            'edema.boolean' => 'Ödem durumu doğru bir şekilde belirtilmelidir.',
            'burning_urine.required' => 'İdrar yaparken yanma hissi zorunludur.',
            'burning_urine.boolean' => 'İdrar yaparken yanma durumu doğru bir şekilde belirtilmelidir.',
            'itching_or_burning.required' => 'Kaşıntı veya yanma durumu zorunludur.',
            'itching_or_burning.boolean' => 'Kaşıntı veya yanma durumu doğru bir şekilde belirtilmelidir.',
            'sankr.required' => 'Şankr durumu zorunludur.',
            'sankr.boolean' => 'Şankr durumu doğru bir şekilde belirtilmelidir.',
            'lenf_node.boolean' => 'Lenf nodu şişliği durumu doğru bir şekilde belirtilmelidir.',
            'plaque_rash.required' => 'Plak döküntü durumu zorunludur.',
            'plaque_rash.boolean' => 'Plak döküntü durumu doğru bir şekilde belirtilmelidir.',
            'vezikul.required' => 'Vezikül durumu zorunludur.',
            'vezikul.boolean' => 'Vezikül durumu doğru bir şekilde belirtilmelidir.',
            'need_to_urinate.required' => 'İdrar yapma durumu zorunludur.',
            'need_to_urinate.boolean' => 'İdrar yapamama durumu doğru bir şekilde belirtilmelidir.',
        ]);
        $result = $this->determineResult($validated);

        try {
            DB::beginTransaction();

            // Veritabanına kayıt işlemi
            $sexuallyDisease = new SexuallyDisease;
            $sexuallyDisease->user_id = Auth::user()->id;
            $sexuallyDisease->age = $validated['age'];
            $sexuallyDisease->stream = $validated['stream'];
            $sexuallyDisease->is_more_stream = $validated['is_more_stream'];
            $sexuallyDisease->smell = $validated['smell'];
            $sexuallyDisease->color = $validated['color'];
            $sexuallyDisease->edema = $validated['edema'];
            $sexuallyDisease->burning_urine = $validated['burning_urine'];
            $sexuallyDisease->itching_or_burning = $validated['itching_or_burning'];
            $sexuallyDisease->sankr = $validated['sankr'];
            $sexuallyDisease->lenf_node = $validated['lenf_node'];
            $sexuallyDisease->plaque_rash = $validated['plaque_rash'];
            $sexuallyDisease->vezikul = $validated['vezikul'];
            $sexuallyDisease->need_to_urinate = $validated['need_to_urinate'];
            $sexuallyDisease->result = $result['result'];
            $sexuallyDisease->description = json_encode($result['description']);
            $sexuallyDisease->save();
            DB::commit();

            return redirect()->route('sexually-disease.index')->with('success', 'Kayıt başarıyla oluşturuldu.Sonucu Öğrenmek İçin Lütfen Görüntüleme Sayfasına Gidiniz  ');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Kayıt oluşturulurken bir hata oluştu.');
        }
    }

    public function show($id)
    {
        $sexuallyDisease = SexuallyDisease::findOrFail($id);
        return Inertia::render(
            'SexuallyDisease/Show',
            ['sexuallyDisease' => $sexuallyDisease]
        );
    }
}
