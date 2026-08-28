<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['name' => 'Daily',   'slug' => 'daily',   'price' => 40,  'duration_days' => 1,  'description' => 'Full access for 1 day'],
            ['name' => 'Weekly',  'slug' => 'weekly',  'price' => 90,  'duration_days' => 7,  'description' => 'Full access for 7 days'],
            ['name' => 'Monthly', 'slug' => 'monthly', 'price' => 250, 'duration_days' => 30, 'description' => 'Full access for 30 days'],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(['slug' => $pkg['slug']], $pkg);
        }
    }
}