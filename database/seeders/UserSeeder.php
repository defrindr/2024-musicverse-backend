<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'phone_number' => '6285604845437',
            'country' => 1,
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('password'),
        ]);

        User::create([
            'id' => 2,
            'name' => 'Producer',
            'email' => 'producer@gmail.com',
            'phone_number' => '6285604845437',
            'country' => 1,
            'role' => User::ROLE_PRODUCER,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('password'),
        ]);

        User::create([
            'id' => 3,
            'name' => 'Talent AN',
            'email' => 'talent@gmail.com',
            'phone_number' => '6285604845437',
            'country' => 1,
            'role' => User::ROLE_TALENT,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('password'),
        ]);

        SocialLink::create([
            'user_id' => 3,
            'name' => 'instagram',
            'value' => 'defrindr',
        ]);
        SocialLink::create([
            'user_id' => 3,
            'name' => 'tiktok',
            'value' => 'defrindr',
        ]);
    }
}
