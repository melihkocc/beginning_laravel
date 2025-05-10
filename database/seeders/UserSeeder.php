<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
    }
}
