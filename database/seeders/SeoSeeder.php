<?php

namespace Database\Seeders;

use App\Models\Seo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seoData = [
            'meta_title' => "Meta title",
            'meta_author' => "Meta author",
            'meta_tag' => "Meta tag",
            'meta_description' => "Meta description",
            'meta_keyword' => "Meta keyword",
            'google_verification' => "Google verification",
            'google_analytics' => "Google analytics",
            'alexa_verification' => "Alexa verification",
            'google_adsense' => "Google adsense",
        ];

        // for ($i = 0; $i < 20; $i++) {
        DB::table('seos')->insert($seoData);
        // }
    }
}
