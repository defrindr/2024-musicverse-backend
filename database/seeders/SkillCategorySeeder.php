<?php

namespace Database\Seeders;

use App\Models\Audition\Audition;
use App\Models\Audition\SkillCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SkillCategory::create(['id' => 1, 'icon' => 'singing.png', 'name' => 'Singing']);
        SkillCategory::create(['id' => 2, 'icon' => 'guitarist.png', 'name' => 'Guitarist']);
        SkillCategory::create(['id' => 3, 'icon' => 'pianist.png', 'name' => 'Pianist']);


        // Audition::create([
        //     'title' => ''
        // ]);
    }
}
