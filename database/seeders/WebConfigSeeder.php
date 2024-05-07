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
            ['app.text.title', 'PETOLOGI'],

            ['app.text.about.title', 'About Our Pets Clinic'],
            ['app.text.about.description', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since theLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the'],
            ['app.text.about.button', 'Learn More'],

            ['app.text.service.title', 'Our Services'],
            ['app.text.service.button', 'Learn More'],

            ['app.text.gallery.title', 'Our Gallery'],

            // ['app.text.hospital.title', 'You Can Buy Pet From Our Clinic'],
            // ['app.text.hospital.description', 'consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip'],
            // ['app.text.hospital.button', 'Buy Now'],

            ['app.text.testimoni.title', 'What Say Our clients'],
            ['app.text.testimoni.description', 'orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut la'],

            ['app.text.contact.title', 'Contact Us'],
            ['app.text.contact.button', 'SEND'],
            ['app.text.contact.phone', '+6285604845437'],
            ['app.text.contact.email', 'defrindr@gmail.com'],

            ['app.text.copyright', '© 2019 All Rights Reserved By Free Html Templates'],
        ];
        $appColors = [
            ['app.color.primary', '#18d3ff'],
            ['app.color.secondary', '#023b48'],
        ];
        $appImages = [
            ['app.image.logo', ''],
            ['app.image.banner', ''],
            ['app.image.about', ''],
            ['app.image.service', ''],
        ];

        foreach ($appTexts as $item) {
            WebConfig::create(['type' => 'text', 'name' => $item[0], 'value' => $item[1]]);
        }
        foreach ($appColors as $item) {
            WebConfig::create(['type' => 'color', 'name' => $item[0], 'value' => $item[1]]);
        }
        foreach ($appImages as $item) {
            WebConfig::create(['type' => 'image', 'name' => $item[0], 'value' => $item[1]]);
        }
    }
}
