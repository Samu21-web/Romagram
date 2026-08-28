<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Kenyan females
            ['name' => 'Amina', 'gender' => 'female', 'interested_in' => 'male', 'age' => 24, 'city' => 'Nairobi', 'country' => 'Kenya'],
            ['name' => 'Grace', 'gender' => 'female', 'interested_in' => 'male', 'age' => 26, 'city' => 'Mombasa', 'country' => 'Kenya'],
            ['name' => 'Fatuma', 'gender' => 'female', 'interested_in' => 'male', 'age' => 22, 'city' => 'Kisumu', 'country' => 'Kenya'],
            ['name' => 'Sharon', 'gender' => 'female', 'interested_in' => 'male', 'age' => 28, 'city' => 'Nakuru', 'country' => 'Kenya'],
            ['name' => 'Wanjiru', 'gender' => 'female', 'interested_in' => 'male', 'age' => 25, 'city' => 'Nairobi', 'country' => 'Kenya'],
            ['name' => 'Aisha', 'gender' => 'female', 'interested_in' => 'male', 'age' => 23, 'city' => 'Mombasa', 'country' => 'Kenya'],
            ['name' => 'Cynthia', 'gender' => 'female', 'interested_in' => 'male', 'age' => 27, 'city' => 'Eldoret', 'country' => 'Kenya'],
            ['name' => 'Mercy', 'gender' => 'female', 'interested_in' => 'male', 'age' => 21, 'city' => 'Thika', 'country' => 'Kenya'],
            ['name' => 'Pauline', 'gender' => 'female', 'interested_in' => 'male', 'age' => 29, 'city' => 'Nairobi', 'country' => 'Kenya'],
            ['name' => 'Halima', 'gender' => 'female', 'interested_in' => 'male', 'age' => 24, 'city' => 'Garissa', 'country' => 'Kenya'],
            // International females
            ['name' => 'Ngozi', 'gender' => 'female', 'interested_in' => 'male', 'age' => 26, 'city' => 'Lagos', 'country' => 'Nigeria'],
            ['name' => 'Ama', 'gender' => 'female', 'interested_in' => 'male', 'age' => 23, 'city' => 'Accra', 'country' => 'Ghana'],
            ['name' => 'Zanele', 'gender' => 'female', 'interested_in' => 'male', 'age' => 28, 'city' => 'Johannesburg', 'country' => 'South Africa'],
            ['name' => 'Fatou', 'gender' => 'female', 'interested_in' => 'male', 'age' => 25, 'city' => 'Dakar', 'country' => 'Senegal'],
            ['name' => 'Imani', 'gender' => 'female', 'interested_in' => 'male', 'age' => 27, 'city' => 'Dar es Salaam', 'country' => 'Tanzania'],
            // Males
            ['name' => 'James', 'gender' => 'male', 'interested_in' => 'female', 'age' => 27, 'city' => 'Nairobi', 'country' => 'Kenya'],
            ['name' => 'Brian', 'gender' => 'male', 'interested_in' => 'female', 'age' => 30, 'city' => 'Eldoret', 'country' => 'Kenya'],
            ['name' => 'Kevin', 'gender' => 'male', 'interested_in' => 'female', 'age' => 25, 'city' => 'Nairobi', 'country' => 'Kenya'],
            ['name' => 'David', 'gender' => 'male', 'interested_in' => 'female', 'age' => 28, 'city' => 'Mombasa', 'country' => 'Kenya'],
            ['name' => 'Samuel', 'gender' => 'male', 'interested_in' => 'female', 'age' => 32, 'city' => 'Kisumu', 'country' => 'Kenya'],
        ];

        foreach ($users as $i => $u) {
            User::updateOrCreate(
                ['email' => strtolower($u['name']) . '@test.com'],
                [
                    'name'             => $u['name'],
                    'email'            => strtolower($u['name']) . '@test.com',
                    'phone'            => '+2547' . str_pad($i + 10, 8, '0', STR_PAD_LEFT),
                    'password'         => Hash::make('password'),
                    'gender'           => $u['gender'],
                    'interested_in'    => $u['interested_in'],
                    'age'              => $u['age'],
                    'city'             => $u['city'],
                    'country'          => $u['country'],
                    'latitude'         => -1.2921 + ($i * 0.05),
                    'longitude'        => 36.8219 + ($i * 0.05),
                    'profile_complete' => true,
                ]
            );
        }
    }
}