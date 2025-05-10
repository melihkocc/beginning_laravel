<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('women_diseases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kullanıcıyla ilişki
            $table->boolean('hpv'); //hpv
            $table->boolean('cigarette');   //sigara kullanıyor musunuz
            $table->boolean('early_sexual');    //Erken yaşta cinsel ilişkiniz oldu mu
            $table->boolean('sexual_blood');    //Cinsel ilişki sonrası kanamanız oluyor mu
            $table->boolean('bad_smell_stream');    //kötü kokulu akıntı
            $table->boolean('urine_blood'); //idrarda kanama
            $table->boolean('edema');   //ödem var mı
            $table->boolean('more_pregnancy'); //Birden çok gebelik geçirdiniz mi
            $table->boolean('adet_blood');  //Adet kanamanızda anormallikler (yoğunlaşma, arada bir kanama, uzun ve fazla olması) var mı
            $table->boolean('pressure');  // kasık - belde basınç hissi var mı
            $table->boolean('menepoz_blood');  // Menepoz sonrası kanamalarınız oluyor mu?
            $table->boolean('late_menepoz');  // Menepoza geç mi girdiniz mi?
            $table->integer('special_1');  //     -(Fazla kilolu - diyabet - polikistik over sendromu - daha önce doğum yapmayan) Kaç tanesi sizi tanımlıyor
            $table->integer('special_2');  //     -(İdrar yaparken ağrı, çok idrar yapma, ani sıkışma hissi, kanlı idra, kötü koku idrar yapma) Kaç tanesi sizi tanımlıyor
            $table->string('result');  //     -(İdrar yaparken ağrı, çok idrar yapma, ani sıkışma hissi, kanlı idra, kötü koku idrar yapma) Kaç tanesi sizi tanımlıyor
            $table->json('description');  //     -(İdrar yaparken ağrı, çok idrar yapma, ani sıkışma hissi, kanlı idra, kötü koku idrar yapma) Kaç tanesi sizi tanımlıyor

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('women_diseases');
    }
};
