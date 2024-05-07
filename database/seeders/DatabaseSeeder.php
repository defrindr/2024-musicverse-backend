<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@musicverse.id',
            'role' => 'ADMINISTRATOR',
        ]);
        User::factory()->create([
            'name' => 'producer',
            'email' => 'producer@musicverse.id',
            'role' => 'PRODUCER',
        ]);
        User::factory()->create([
            'name' => 'talent',
            'email' => 'talent@musicverse.id',
            'role' => 'TALENT',
        ]);

        $this->call(WebConfigSeeder::class);
    }
}
