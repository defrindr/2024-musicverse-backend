<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MasterSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(WebConfigSeeder::class);
        $this->call(WebFaqSeeder::class);
        $this->call(SkillCategorySeeder::class);
    }
}
