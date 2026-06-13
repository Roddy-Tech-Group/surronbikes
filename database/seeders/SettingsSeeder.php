<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name' => 'SuronBikes',
            'email' => 'contact@suronbikes.com',
            'phone' => '',
            'address' => '',
            'logo' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'twitter_url' => '',
            'youtube_url' => '',
            'tiktok_url' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
