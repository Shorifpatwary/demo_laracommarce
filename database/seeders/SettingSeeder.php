<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'currency' => 'USD',
            'phone_one' => '123-456-7890',
            'phone_two' => '987-654-3210',
            'main_email' => 'info@example.com',
            'support_email' => 'support@example.com',
            'logo' => 'logo.png',
            'favicon' => 'favicon.ico',
            'address' => '123 Main Street, City, Country',
            'facebook' => 'https://facebook.com/example',
            'twitter' => 'https://twitter.com/example',
            'instagram' => 'https://instagram.com/example',
            'linkedin' => 'https://linkedin.com/company/example',
            'youtube' => 'https://youtube.com/c/example',
        ];

        DB::table('settings')->insert($data);
    }
}
