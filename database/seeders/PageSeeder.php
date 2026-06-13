<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about-us',
                'title' => 'About Us',
                'content' => '',
            ],
            [
                'slug' => 'contact-us',
                'title' => 'Contact Us',
                'content' => '',
            ],
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'content' => '',
            ],
            [
                'slug' => 'terms-of-service',
                'title' => 'Terms of Service',
                'content' => '',
            ],
            [
                'slug' => 'shipping-policy',
                'title' => 'Shipping Policy',
                'content' => '',
            ],
            [
                'slug' => 'refund-policy',
                'title' => 'Refund Policy',
                'content' => '',
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
