<?php

namespace Database\Seeders;

use App\Models\Audition\Audition;
use App\Models\Audition\AuditionAssesment;
use App\Models\Audition\SkillCategory;
use App\Models\User;
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

        Audition::create([
            'id' => 1,
            'title' => 'Audition Demo',
            'skill_id' => 1,
            'term' => 'term.pdf',
            'contract' => 'contract.pdf',
            'created_by' => User::whereRole(User::ROLE_PRODUCER)->first()->id,
            'date' => date('Y-m-d H:i:s'),
            "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga ducimus odio natus porro molestiae at doloribus, consectetur voluptatibus reprehenderit, earum tempore alias maxime? Tenetur excepturi obcaecati, assumenda laborum error doloremque."
        ]);

        AuditionAssesment::create([
            'audition_id' => 1,
            'assesment' => 'Vocal Ability',
            'weight' => 50,
        ]);
        AuditionAssesment::create([
            'audition_id' => 1,
            'assesment' => 'Creativity',
            'weight' => 30,
        ]);
        AuditionAssesment::create([
            'audition_id' => 1,
            'assesment' => 'Pearence',
            'weight' => 20,
        ]);
    }
}
