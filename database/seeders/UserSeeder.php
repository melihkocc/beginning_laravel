<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\New_;

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
        $user->save();
    }
}
