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
        Schema::create('sexually_diseases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kullanıcıyla ilişki
            $table->string('age');  // yaş
            $table->boolean('stream'); // Akıntınız Var mı?
            $table->boolean('is_more_stream')->nullable(); // Akıntı Fazla Miktarda mı?
            $table->string('smell');   // koku
            $table->string('color');    // renk
            $table->boolean('edema'); // Ödeminiz Var mı
            $table->boolean('burning_urine'); /// İdrar yaparken yanma hissediyor musunuz
            $table->boolean('itching_or_burning'); /// Kaşıntı veya yanma hissiniz var mı?
            $table->boolean('sankr'); /// Düzgün kenarlı Ağrısız sert yuvarlak cilt lezyonu (Şankr) Var mı
            $table->boolean('lenf_node')->nullable(); /// Lenf Nodlarınızda şişme var mı?
            $table->boolean('plaque_rash'); /// Nemli bölgelerinizde plak döküntü var mı?
            $table->boolean('vezikul'); /// Ağrı hassasiyet ve genital bölgenizde içi sıvı dolu kabarcıklar (vezikül) var mı
            $table->boolean('need_to_urinate'); /// İdrar yapma ihtiyacı hissedip idrarınız yapamadığınız oluyor mu
            $table->string('result');   // koku
            $table->json('description');   // koku

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sexually_diseases');
    }
};
