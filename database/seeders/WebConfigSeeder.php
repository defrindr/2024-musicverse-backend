<?php

namespace Database\Seeders;

use App\Models\Web\WebConfig;
use Illuminate\Database\Seeder;

class WebConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appTexts = [
            ['app.text.hero', "Virtual Stage\nfor Music\nTalents"],
            ['app.text.hero-bottom', 'More than 1000 people have joined the platform'],
            ['app.text.discover-title', "Discover the Musicverse\nExperience"],
            ['app.text.discover-content', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.'],
            ['app.text.gallery-title', "Get Inspired by\nMusical Talents!"],
            ['app.text.market-title', 'Help market and distribute music'],
            ['app.text.market-content', "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley."],
            ['app.text.faq-title', 'FAQ: Answers to Your Queries'],
            ['app.text.login-title', "Login and Show Your\nTalent!"],
            ['app.text.signin-title', 'We Helps You Create\nAmazing Music!'],
            ['app.text.copyright', '© 2024 All Rights Reserved by Defri Indra Mahardika'],
        ];
        $appImages = [
            ['app.image.logo', 'logo.png'],
            ['app.image.hero', 'hero.png'],
            ['app.image.market', 'market.png'],
            ['app.image.login', 'login.png'],
            ['app.image.signin', 'signin.png'],
        ];

        foreach ($appTexts as $item) {
            WebConfig::create(['type' => 'text', 'name' => $item[0], 'value' => $item[1]]);
        }
        foreach ($appImages as $item) {
            WebConfig::create(['type' => 'image', 'name' => $item[0], 'value' => $item[1]]);
        }
    }
}
