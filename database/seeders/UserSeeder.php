<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\New_;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userCredentials = [
            [
                'gender' => 'erkek',
                'name' => 'Melih',
                'surname' => 'Koç',
                'email' => 'kocmelih20@gmail.com'
            ],
        ];
        $faker = Faker::create();

        foreach ($userCredentials as $userCredential) {
            $user = new User();
            $user->gender = $userCredential['gender'];
            $user->name = $userCredential['name'];
            $user->surname = $userCredential['surname'];
            $user->email = $userCredential['email'];
            $user->password = Hash::make('Melih123');
            $user->save();
        }

        $user = new User();
        $user->gender = 'kadin';
        $user->name = 'Ayşe';
        $user->surname = 'ayşe';
        $user->email = 'ayse@gmail.com';
        $user->plan = 'paid';
        $user->password = Hash::make('Melih123');
        $user->save();

        $user = new User();
        $user->gender = 'erkek';
        $user->name = 'Alperen';
        $user->surname = 'Kürk';
        $user->email = 'alperen@gmail.com';
        $user->plan = 'doctor';
        $user->description = 'Özgeçmiş';
        $user->specialization = 'Kadın Hastalıkları';
        $user->years_of_experience = '4';
        $user->clinic_name = 'Ufuk Hastanesi';
        $user->city = 'Ankara';
        $user->district = 'Mamak';
        $user->address = 'Kutlu Mahallesi';
        $user->consultation_price = 500;
        $user->password = Hash::make('Melih123');
        $user->ratings = 5; // Rastgele puan
        $user->save();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();

            // Random olarak gender seçimi
            $user->gender = (rand(0, 1) == 0) ? 'kadin' : 'erkek'; // %50 ihtimalle kadın veya erkek

            $user->name = $faker->firstName($user->gender); // Cinsiyetine uygun ilk isim
            $user->surname = $faker->lastName;
            $user->email = $faker->unique()->safeEmail;
            $user->plan = 'doctor'; // Plan doktor
            $user->description = $faker->sentence;
            $user->specialization = $faker->word; // Özel alan, örneğin "Kadın Hastalıkları"
            $user->years_of_experience = rand(1, 20); // Rastgele deneyim yılı
            $user->clinic_name = $faker->company;
            $user->city = $faker->city;
            $user->district = $faker->word; // Mahalle
            $user->address = $faker->address;
            $user->consultation_price = rand(300, 1000); // Rastgele danışmanlık ücreti
            $user->password = Hash::make('Melih123');
            $user->ratings = rand(1, 5); // Rastgele puan
            $user->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->gender = 'kadin'; // Kadın cinsiyet
            $user->name = $faker->firstNameFemale; // Kadın ismi
            $user->surname = $faker->lastName; // Rastgele soyisim
            $user->email = $faker->unique()->safeEmail; // Benzersiz email
            $user->plan = 'paid'; // Plan: paid
            $user->password = Hash::make('Melih123'); // Şifre
            $user->save();
        }
    }
}
