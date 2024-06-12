<?php

namespace Database\Seeders;

use App\Models\Master\Country;
use App\Models\Master\Genre;
use App\Models\Master\Language;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create(['id' => 1, 'country' => 'Indonesia']);
        Country::create(['id' => 2, 'country' => 'Malaysia']);
        Country::create(['id' => 3, 'country' => 'Singapura']);
        Country::create(['id' => 4, 'country' => 'Thailand']);

        Language::create(['id' => 1, 'language' => 'Indonesia']);
        Language::create(['id' => 2, 'language' => 'Melayu']);
        Language::create(['id' => 3, 'language' => 'Tagalog']);
        Language::create(['id' => 4, 'language' => 'English']);

        Genre::create(['id' => 1, 'genre' => 'Pop']);
        Genre::create(['id' => 2, 'genre' => 'Metal']);
        Genre::create(['id' => 3, 'genre' => 'Rock']);
        Genre::create(['id' => 4, 'genre' => 'Reggae']);
        Genre::create(['id' => 5, 'genre' => 'Hip Hop']);
    }
}
