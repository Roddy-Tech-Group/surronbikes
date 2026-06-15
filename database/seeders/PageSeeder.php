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
                'content' => '<div>
<p class="text-xl leading-relaxed">Born from an obsession with adrenaline and a vision for the future, SuronBikes represents the pinnacle of electric dirt bike innovation. We are not just building bikes; we are engineering raw, unapologetic power.</p>

<p class="mt-6 text-xl leading-relaxed">We believe the dirt track is a canvas, and our electric powertrains are the brush. Zero emissions doesn\'t mean zero thrill. With instant torque that throws you back and a lightweight chassis that carves corners, we\'re delivering an experience that leaves traditional combustion engines eating dust.</p>

<p class="mt-6 text-xl leading-relaxed">Our mission is simple: to redefine off-road riding. Join the quiet revolution and experience the unparalleled performance of SuronBikes. The wilderness is calling—answer it with electrifying speed.</p>
</div>',
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
