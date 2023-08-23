<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Data = [
            'mailer' => "Meta title",
            'host' => "Meta author",
            'port' => "Meta tag",
            'user_name' => "Meta description",
            'password' => "Meta keyword"
        ];

        // for ($i = 0; $i < 20; $i++) {
        DB::table('smtps')->insert($Data);
        // }
    }
}
